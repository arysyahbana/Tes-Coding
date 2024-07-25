<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $page = "Customer";
        $customers = Customer::get();
        return view('admin.pages.Customer.index', compact('page', 'customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kodeCustomer' => 'required',
            'namaCustomer' => 'required',
            'noHp' => 'required',
        ]);

        $store = new Customer();
        $store->kode = $request->kodeCustomer;
        $store->name = $request->namaCustomer;
        $store->telp = $request->noHp;
        $store->save();

        return redirect()->route('customer.show')->with('success', 'Data customer berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kodeCustomer' => 'required',
            'namaCustomer' => 'required',
            'noHp' => 'required',
        ]);

        $update = Customer::find($id);
        $update->kode = $request->kodeCustomer;
        $update->name = $request->namaCustomer;
        $update->telp = $request->noHp;
        $update->save();
        return redirect()->route('customer.show')->with('success', 'Data customer berhasil diubah.');
    }

    public function destroy($id)
    {
        $destroy = Customer::find($id);
        $destroy->delete();
        return redirect()->route('customer.show')->with('success', 'Data customer berhasil dihapus.');
    }
}
