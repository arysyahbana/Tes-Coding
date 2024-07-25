@extends('admin.app')

@section('title', 'Daftar Transaksi')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <h6>Daftar Transaksi</h6>
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between">
                        <a href="{{ route('transaksi.create') }}" class="btn bg-gradient-success"><i class="fa fa-plus"
                                aria-hidden="true"></i><span class="text-capitalize ms-1">Tambah</span></a>
                        <span class="text-dark fw-bold">Grand Total : Rp.
                            {{ number_format($grandTotal, 2, ',', '.') ?? '0' }}</span>
                    </div>
                    <div class="card-body px-5 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <x-admin.table id="datatable">
                                @slot('header')
                                    <tr>
                                        <x-admin.th>No</x-admin.th>
                                        <x-admin.th>No Transaksi</x-admin.th>
                                        <x-admin.th>Tanggal</x-admin.th>
                                        <x-admin.th>Nama Customer</x-admin.th>
                                        <x-admin.th>Jumlah Barang</x-admin.th>
                                        <x-admin.th>Sub Total</x-admin.th>
                                        <x-admin.th>Diskon</x-admin.th>
                                        <x-admin.th>Ongkir</x-admin.th>
                                        <x-admin.th>Total</x-admin.th>
                                        <x-admin.th>Action</x-admin.th>
                                    </tr>
                                @endslot

                                @foreach ($transaksi as $item)
                                    <tr>
                                        <x-admin.td>{{ $loop->iteration }}</x-admin.td>
                                        <x-admin.td>{{ $item->kode ?? '-' }}</x-admin.td>
                                        <x-admin.td>{{ $item->tgl ? \Carbon\Carbon::parse($item->tgl)->format('d-m-Y') : '-' }}</x-admin.td>
                                        <x-admin.td>{{ $item->rCustomer->name ?? '-' }}</x-admin.td>
                                        <x-admin.td>{{ $item->rSalesDetails->sum('qty') ?? '-' }}</x-admin.td>
                                        <x-admin.td>Rp.
                                            {{ number_format($item->subtotal, 2, ',', '.') ?? '-' }}</x-admin.td>
                                        <x-admin.td>Rp. {{ number_format($item->diskon, 2, ',', '.') ?? '-' }}</x-admin.td>
                                        <x-admin.td>Rp. {{ number_format($item->ongkir, 2, ',', '.') ?? '-' }}</x-admin.td>
                                        <x-admin.td>Rp.
                                            {{ number_format($item->total_bayar, 2, ',', '.') ?? '-' }}</x-admin.td>
                                        <x-admin.td>
                                            <a href="{{ route('transaksi.edit', $item->id) }}"
                                                class="btn bg-gradient-info"><i class="fa fa-pencil"
                                                    aria-hidden="true"></i><span
                                                    class="text-capitalize ms-1">Edit</span></a>
                                            <a href="{{ route('transaksi.destroy', $item->id) }}"
                                                class="btn bg-gradient-danger"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?');">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                                <span class="text-capitalize ms-1">Hapus</span>
                                            </a>

                                        </x-admin.td>
                                    </tr>
                                @endforeach
                            </x-admin.table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
