<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Customer;
use App\Models\Sales;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $page = "Dashboard";
        $transaksi = Sales::get();
        $grandTotal = $transaksi->sum('total_bayar');
        $userTotal = User::count();
        $customerTotal = Customer::count();
        $barangTotal = Barang::count();
        return view('admin.pages.dashboard', compact('page', 'transaksi', 'grandTotal', 'userTotal', 'customerTotal', 'barangTotal'));
    }
}
