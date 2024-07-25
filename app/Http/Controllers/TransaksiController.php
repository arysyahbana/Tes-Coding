<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Customer;
use App\Models\Sales;
use App\Models\SalesDetails;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $page = "Transaksi";
        $transaksi = Sales::get();
        $grandTotal = $transaksi->sum('total_bayar');
        return view('admin.pages.Daftar_Transaksi.index', compact('page', 'transaksi', 'grandTotal'));
    }
    public function create()
    {
        $page = "Transaksi";
        $barang = Barang::get();
        $customers = Customer::get();
        // Generate kode transaksi
        $currentMonth = Carbon::now()->format('Ym');
        $lastTransaction = DB::table('sales')
            ->where(DB::raw("DATE_FORMAT(tgl, '%Y%m')"), $currentMonth)
            ->orderBy('id', 'desc')
            ->first();

        $lastTransactionNumber = $lastTransaction ? intval(substr($lastTransaction->kode, -4)) : 0;
        $newTransactionNumber = str_pad($lastTransactionNumber + 1, 4, '0', STR_PAD_LEFT);

        $kodeTransaksi = $currentMonth . '-' . $newTransactionNumber;

        // dd($kodeTransaksi);
        return view('admin.pages.Daftar_Transaksi.create', compact('page', 'barang', 'customers', 'kodeTransaksi'));
    }


    public function store(Request $request)
    {
        // $request->validate([
        //     'noTransaksi' => 'required',
        //     'tanggal' => 'required',
        //     'kode' => 'required',
        // ]);

        $store = new Sales();
        $store->kode = $request->noTransaksi;
        $store->tgl = $request->tanggal;
        $store->customer_id = $request->kodeCustomer;
        $store->subtotal = $request->subTotal;
        $store->diskon = $request->diskonNilai;
        $store->ongkir = $request->ongkir;
        $store->total_bayar = $request->totalBayar;
        $store->save();

        $sales_id = $store->id;
        $barang = Barang::whereIn('kode', $request->input('kodeBarang'))->get();
        $barang_id = $barang->pluck('id');
        // return $barang_id;
        $data = $request->input('qty');
        foreach ($data as $key => $value) {
            SalesDetails::create([
                'sales_id' => $sales_id,
                'barang_id' => $barang_id[$key],
                'harga_bandrol' => $request->hargaBandrol[$key],
                'qty' => $value,
                'diskon_pct' => $request->diskon[$key],
                'diskon_nilai' => $request->hargaDiskon[$key],
                'harga_diskon' => $request->total[$key],
                'total' => $request->total2[$key],
            ]);
        }

        return redirect()->route('transaksi.show')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $page = "Transaksi";
        $transaksi = Sales::findOrFail($id);
        $customers = Customer::all();
        $barang = Barang::all();

        return view('admin.pages.Daftar_Transaksi.edit', compact('transaksi', 'customers', 'barang', 'page'));
    }

    public function update(Request $request, $id)
    {
        // return $request->all();
        $request->validate([
            'noTransaksi' => 'required',
            'tanggal' => 'required|date',
            'kodeCustomer' => 'required',
            'namaBarang.*' => 'required',
            'qty.*' => 'required|integer|min:1',
            'diskon.*' => 'required|numeric|min:0|max:100',
        ]);

        // return $id;
        DB::transaction(function () use ($request, $id) {
            // Update transaksi utama
            $transaksi = Sales::findOrFail($id);
            $transaksi->kode = $request->noTransaksi;
            $transaksi->tgl = $request->tanggal;
            $transaksi->customer_id = $request->kodeCustomer;
            $transaksi->subtotal = $request->subTotal;
            $transaksi->diskon = $request->diskonNilai;
            $transaksi->ongkir = $request->ongkir;
            $transaksi->total_bayar = $request->totalBayar;
            $transaksi->save();

            // Hapus detail transaksi lama
            SalesDetails::where('sales_id', $id)->delete();

            $barang = Barang::whereIn('kode', $request->input('kodeBarang'))->get();
            $barang_id = $barang->pluck('id');
            // Tambahkan detail transaksi baru
            foreach ($barang_id as $index => $value) {
                $detail = new SalesDetails();
                $detail->sales_id = $transaksi->id;
                $detail->barang_id = $value;
                $detail->qty = $request->qty[$index];
                $detail->harga_bandrol = $request->hargaBandrol[$index];
                $detail->diskon_pct = $request->diskon[$index];
                $detail->diskon_nilai = $request->hargaDiskon[$index];
                $detail->harga_diskon = $request->hargaDiskon[$index];
                $detail->total = $request->total[$index];
                $detail->save();
            }
        });

        return redirect()->route('transaksi.show')->with('success', 'Transaksi berhasil diubah.');
    }

    public function destroy($id)
    {
        $transaksi = Sales::findOrFail($id);
        $transaksi->delete();
        return redirect()->route('transaksi.show')->with('success', 'Transaksi berhasil dihapus.');
    }
}
