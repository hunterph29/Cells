<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::query();

        if ($search = $request->string('search')->trim()->toString()) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%")
                    ->orWhere('zip_code', 'like', "%{$search}%")
                    ->orWhere('contract', 'like', "%{$search}%");
            });
        }

        $totalCustomers = Customer::count();
        $customers = $query->latest()->paginate(10)->withQueryString();

        $editCustomer = null;
        if ($editId = $request->query('edit') ?? session('edit_customer_id')) {
            $editCustomer = Customer::find($editId);
        }

        return view('customers.index', compact('customers', 'totalCustomers', 'editCustomer'));
    }

    public function create()
    {
        $this->ensureCanCreateCustomers();

        return redirect()
            ->route('customers.index')
            ->with('open_customer_modal', 'add');
    }

    public function store(Request $request)
    {
        $this->ensureCanCreateCustomers();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:1000',
            'city' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:20',
            'contract' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('customers.index')
                ->withInput()
                ->withErrors($validator)
                ->with('open_customer_modal', 'add');
        }

        Customer::create($validator->validated());

        return redirect()->route('customers.index')->with('success', 'Customer added successfully.');
    }

    public function edit(Customer $customer)
    {
        $this->ensureCanEditCustomers();

        return redirect()->route('customers.index', ['edit' => $customer->id]);
    }

    public function update(Request $request, Customer $customer)
    {
        $this->ensureCanEditCustomers();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers,email,' . $customer->id,
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:1000',
            'city' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:20',
            'contract' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('customers.index')
                ->withInput()
                ->withErrors($validator)
                ->with('edit_customer_id', $customer->id)
                ->with('open_customer_modal', 'edit');
        }

        $customer->update($validator->validated());

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        $this->ensureCanDelete();

        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}
