<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Record;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalCustomers = Customer::count();
        $totalRecords = Record::count();
        $userRecords = Auth::user()->records()->count();

        return view('dashboard', compact('totalUsers', 'totalCustomers', 'totalRecords', 'userRecords'));
    }
}
