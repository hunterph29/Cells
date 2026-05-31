<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'profile_picture' => 'nullable|image|max:2048',
        ]);

        if (!$request->hasFile('profile_picture')) {
            return back();
        }

        $file = $request->file('profile_picture');
        $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\.\-]/', '_', $file->getClientOriginalName());
        $destination = public_path('profile_pictures');
        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }
        $file->move($destination, $filename);
        $user->update(['profile_picture' => 'profile_pictures/' . $filename]);
        Auth::setUser($user->fresh());

        return back()->with('success', 'Profile picture updated successfully.');
    }

    public function updateAccount(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore($user->id),
            ],
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'gender' => 'nullable|string|in:male,female,other,prefer_not_to_say',
            'phone' => 'nullable|string|max:50',
            'birthdate' => 'nullable|date|before:today',
            'country' => 'nullable|string|max:255',
            'profile_picture' => 'nullable|image|max:2048',
        ]);

        $firstName = $request->first_name;
        $lastName = $request->last_name;

        $data = [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'name' => trim($firstName . ' ' . $lastName),
            'username' => $request->username,
            'email' => $request->email,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'birthdate' => $request->birthdate,
            'country' => $request->country,
        ];

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\.\-]/', '_', $file->getClientOriginalName());
            $destination = public_path('profile_pictures');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }
            $file->move($destination, $filename);
            $data['profile_picture'] = 'profile_pictures/' . $filename;
        }

        $user->update($data);

        Auth::setUser($user->fresh());

        return back()->with('success', 'Account details saved successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Password updated successfully.');
    }
}
