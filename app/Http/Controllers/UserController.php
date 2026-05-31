<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        $editUser = null;
        if ($editId = $request->query('edit') ?? session('edit_user_id')) {
            $editUser = User::find($editId);
        }

        return view('users.index', compact('users', 'editUser'));
    }

    public function create()
    {
        return redirect()
            ->route('users.index')
            ->with('open_user_modal', 'add');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->userRules());

        if ($validator->fails()) {
            return redirect()
                ->route('users.index')
                ->withInput()
                ->withErrors($validator)
                ->with('open_user_modal', 'add');
        }

        $validated = $validator->validated();

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $this->resolvedRole($request),
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('users.index')->with('success', 'User added successfully.');
    }

    public function edit(User $user)
    {
        return redirect()->route('users.index', ['edit' => $user->id]);
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), $this->userRules($user));

        if ($validator->fails()) {
            return redirect()
                ->route('users.index')
                ->withInput()
                ->withErrors($validator)
                ->with('edit_user_id', $user->id)
                ->with('open_user_modal', 'edit');
        }

        $data = [
            'name' => $validator->validated()['name'],
            'email' => $validator->validated()['email'],
            'role' => $this->resolvedRole($request, $user),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            abort(403, 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    protected function userRules(?User $user = null): array
    {
        $actor = auth()->user();
        $allowedRoles = array_keys(User::assignableRolesFor($actor, $user));

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email' . ($user ? ',' . $user->id : ''),
        ];

        if (! $user) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        if ($actor?->canManageRoles() && $allowedRoles !== []) {
            $rules['role'] = 'required|string|in:' . implode(',', $allowedRoles);
        } else {
            $rules['role'] = 'nullable';
        }

        return $rules;
    }

    protected function resolvedRole(Request $request, ?User $user = null): string
    {
        $allowedRoles = array_keys(User::assignableRolesFor(auth()->user(), $user));

        if ($allowedRoles !== [] && $request->filled('role')) {
            return $request->role;
        }

        return $user?->role ?? User::ROLE_STAFF;
    }
}
