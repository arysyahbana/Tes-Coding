<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $page = "Barang";
        $barang = Barang::get();
        return view('admin.pages.Barang.index', compact('page', 'barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kodeBarang' => 'required',
            'namaBarang' => 'required',
            'hargaBarang' => 'required',
        ]);

        $store = new Barang();
        $store->kode = $request->kodeBarang;
        $store->nama = $request->namaBarang;
        $store->harga = $request->hargaBarang;
        $store->save();

        return redirect()->route('barang.show')->with('success', 'Data barang berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kodeBarang' => 'required',
            'namaBarang' => 'required',
            'hargaBarang' => 'required',
        ]);

        $update = Barang::find($id);
        $update->kode = $request->kodeBarang;
        $update->nama = $request->namaBarang;
        $update->harga = $request->hargaBarang;
        $update->save();
        return redirect()->route('barang.show')->with('success', 'Data barang berhasil diubah.');
    }

    public function destroy($id)
    {
        $destroy = Barang::find($id);
        $destroy->delete();
        return redirect()->route('barang.show')->with('success', 'Data barang berhasil dihapus.');
    }
}
