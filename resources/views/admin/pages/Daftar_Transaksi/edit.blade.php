@extends('admin.app')

@section('title', 'Edit Transaksi')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <h6>Edit Transaksi</h6>
                <div class="card mb-4">
                    <form method="post" action="{{ route('transaksi.update', $transaksi->id) }}">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-lg-6 px-5 pt-5">
                                <p class="fw-bold">Transaksi</p>
                                <x-admin.input type="text" placeholder="No Transaksi" label="No" name="noTransaksi"
                                    id="noTransaksi" value="{{ $transaksi->kode }}" readonly />
                                <x-admin.input type="date" placeholder="Tanggal" label="Tanggal" name="tanggal"
                                    id="tanggal" value="{{ $transaksi->tgl }}" />
                            </div>
                            <div class="col-12 col-lg-6 px-5 pt-5">
                                <p class="fw-bold">Customer</p>
                                <label>Kode</label>
                                <select class="form-select mb-3" aria-label="Default select example" name="kodeCustomer"
                                    id="kode">
                                    <option selected hidden>--- Pilih Kode ---</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}"
                                            data-info="{{ $customer->name }}|{{ $customer->telp }}"
                                            {{ $customer->id == $transaksi->customer_id ? 'selected' : '' }}>
                                            {{ $customer->kode }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-admin.input type="text" placeholder="Nama" label="Nama" name="nama"
                                    id="nama" value="{{ $transaksi->rCustomer->name }}" readonly />
                                <x-admin.input type="text" placeholder="Telp" label="Telp" name="telp"
                                    id="telp" value="{{ $transaksi->rCustomer->telp }}" readonly />
                            </div>
                        </div>
                        <div class="card-header pb-0">
                            <a href="#" class="btn bg-gradient-success" data-bs-toggle="modal"
                                data-bs-target="#addData"><i class="fa fa-plus" aria-hidden="true"></i><span
                                    class="text-capitalize ms-1">Tambah</span></a>
                        </div>
                        <div class="card-body px-5 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <x-admin.table id="barangTable" class="table-bordered">
                                    @slot('header')
                                        <tr>
                                            <x-admin.th rowspan="2" class="text-dark">No</x-admin.th>
                                            <x-admin.th rowspan="2" class="text-dark">Kode Barang</x-admin.th>
                                            <x-admin.th rowspan="2" class="text-dark">Nama Barang</x-admin.th>
                                            <x-admin.th rowspan="2" class="text-dark">Qty</x-admin.th>
                                            <x-admin.th rowspan="2" class="text-dark">Harga Bandrol</x-admin.th>
                                            <x-admin.th colspan="2" class="text-dark">Diskon</x-admin.th>
                                            <x-admin.th rowspan="2" class="text-dark">Harga Diskon</x-admin.th>
                                            <x-admin.th rowspan="2" class="text-dark">Total</x-admin.th>
                                            <x-admin.th rowspan="2" class="text-dark">Action</x-admin.th>
                                        </tr>
                                        <tr>
                                            <x-admin.th class="text-dark">%</x-admin.th>
                                            <x-admin.th class="text-dark">(Rp)</x-admin.th>
                                        </tr>
                                    @endslot

                                    <tbody>
                                        @forelse ($transaksi->rSalesDetails as $detail)
                                            <tr>
                                                <x-admin.td class="no">{{ $loop->iteration }}</x-admin.td>
                                                <x-admin.td class="kode"><input type="text"
                                                        class="form-control form-control-sm" name="kodeBarang[]"
                                                        value="{{ $detail->rBarang->kode }}" readonly></x-admin.td>
                                                <x-admin.td class="nama"><input type="text"
                                                        class="form-control form-control-sm" name="namaBarang[]"
                                                        value="{{ $detail->rBarang->nama }}" readonly></x-admin.td>
                                                <x-admin.td class="qty"><input type="number"
                                                        class="form-control form-control-sm" name="qty[]"
                                                        value="{{ $detail->qty }}" readonly></x-admin.td>
                                                <x-admin.td class="hargaBandrol"><input type="text"
                                                        class="form-control form-control-sm" name="hargaBandrol[]"
                                                        value="{{ $detail->harga_bandrol }}" readonly></x-admin.td>
                                                <x-admin.td class="diskon"><input type="text"
                                                        class="form-control form-control-sm" name="diskon[]"
                                                        value="{{ $detail->diskon_pct }}" readonly></x-admin.td>
                                                <x-admin.td class="hargaDiskon"><input type="text"
                                                        class="form-control form-control-sm" name="hargaDiskon[]"
                                                        value="{{ $detail->diskon_nilai }}" readonly></x-admin.td>
                                                <x-admin.td class="total"><input type="text"
                                                        class="form-control form-control-sm" name="total[]"
                                                        value="{{ $detail->harga_diskon }}" readonly></x-admin.td>
                                                <x-admin.td class="total2"><input type="text"
                                                        class="form-control form-control-sm" name="total2[]"
                                                        value="{{ $detail->total }}" readonly></x-admin.td>
                                                <x-admin.td>
                                                    <a href="#" class="btn bg-gradient-info btn-edit"><i
                                                            class="fa fa-pencil" aria-hidden="true"></i><span
                                                            class="text-capitalize ms-1">Edit</span></a>
                                                    <a href="#" class="btn bg-gradient-danger btn-delete"><i
                                                            class="fa fa-trash" aria-hidden="true"></i><span
                                                            class="text-capitalize ms-1">Hapus</span></a>
                                                </x-admin.td>
                                            </tr>
                                        @empty
                                            <tr id="noDataRow">
                                                <x-admin.td colspan="10" class="text-center">Tidak ada data</x-admin.td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </x-admin.table>

                                <div class="d-flex justify-content-end mt-3">
                                    <table class="text-sm fw-bold">
                                        <tr>
                                            <td>Sub Total</td>
                                            <td class="px-5 d-flex gap-2">Rp. <input type="number"
                                                    class="form-control form-control-sm" name="subTotal" readonly
                                                    value="{{ $transaksi->subtotal }}"></td>
                                        </tr>
                                        <tr>
                                            <td>Diskon</td>
                                            <td class="px-5 d-flex gap-2">
                                                Rp. <input type="number" class="form-control form-control-sm"
                                                    name="diskonNilai" value="{{ $transaksi->diskon }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Ongkir</td>
                                            <td class="px-5 d-flex gap-2">
                                                Rp. <input type="text" class="form-control form-control-sm"
                                                    name="ongkir" value="{{ $transaksi->ongkir }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Total Bayar</td>
                                            <td class="px-5 d-flex gap-2">
                                                Rp. <input type="number" class="form-control form-control-sm"
                                                    name="totalBayar" readonly value="{{ $transaksi->total_bayar }}">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center gap-2 mt-5">
                            <button type="submit" class="btn bg-gradient-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add Data -->
    <div class="modal fade" id="addData" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="addDataLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addDataLabel">Tambahkan Barang</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <Label>Nama Barang</Label>
                    <select class="form-select mb-3" aria-label="Default select example" name="namaBarang[]"
                        id="namaBarang">
                        <option selected hidden>--- Pilih Barang ---</option>
                        @foreach ($barang as $item)
                            <option value="{{ $item->id }}" data-info="{{ $item->kode }}|{{ $item->harga }}">
                                {{ $item->nama }}</option>
                        @endforeach
                    </select>
                    <x-admin.input type="number" placeholder="Qty" label="Qty" name="qty" id="qty" />
                    <x-admin.input type="number" placeholder="Diskon (%)" label="Diskon (%)" name="diskon%"
                        id="diskon" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-success" id="btnTambah">Tambah</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Data -->
    <div class="modal fade" id="editData" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="editDataLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editDataLabel">Edit Barang</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <Label>Nama Barang</Label>
                    <select class="form-select mb-3" aria-label="Default select example" name="namaPetugas"
                        id="editNamaBarang">
                        <option selected hidden>--- Pilih Barang ---</option>
                        @foreach ($barang as $item)
                            <option value="{{ $item->id }}" data-info="{{ $item->kode }}|{{ $item->harga }}">
                                {{ $item->nama }}</option>
                        @endforeach
                    </select>
                    <x-admin.input type="number" placeholder="Qty" label="Qty" name="qty" id="editQty" />
                    <x-admin.input type="number" placeholder="Diskon (%)" label="Diskon (%)" name="diskon%"
                        id="editDiskon" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-success" id="btnEdit">Simpan</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('kode').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var info = selectedOption.getAttribute('data-info').split('|');
            var customerName = info[0];
            var customerTelp = info[1];

            // console.log('Name:', customerName);
            // console.log('Telp:', customerTelp);

            document.getElementById('nama').value = customerName;
            document.getElementById('telp').value = customerTelp;
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentEditRow;

            function addEditEventListeners() {
                const editButtons = document.querySelectorAll('.btn-edit');
                editButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        currentEditRow = this.closest('tr');
                        const kode = currentEditRow.querySelector('.kode').textContent;
                        const nama = currentEditRow.querySelector('.nama').textContent;
                        const qty = currentEditRow.querySelector('.qty input').value;
                        const diskon = currentEditRow.querySelector('.diskon input').value;

                        document.getElementById('editQty').value = qty;
                        document.getElementById('editDiskon').value = diskon;

                        const editNamaBarang = document.getElementById('editNamaBarang');
                        for (let i = 0; i < editNamaBarang.options.length; i++) {
                            if (editNamaBarang.options[i].text === nama) {
                                editNamaBarang.selectedIndex = i;
                                break;
                            }
                        }

                        const editModal = new bootstrap.Modal(document.getElementById('editData'));
                        editModal.show();
                    });
                });

                // Event listener untuk menghapus backdrop saat modal disembunyikan, dipasang hanya sekali
                const editModalElement = document.getElementById('editData');
                if (!editModalElement.dataset.listenerAdded) {
                    editModalElement.addEventListener('hidden.bs.modal', function() {
                        const backdrop = document.querySelector('.modal-backdrop');
                        if (backdrop) {
                            backdrop.remove();
                        }
                    });
                    editModalElement.dataset.listenerAdded = true;
                }
            }

            function addDeleteEventListeners() {
                const deleteButtons = document.querySelectorAll('.btn-delete');
                deleteButtons.forEach(button => {
                    button.addEventListener('click', function(event) {
                        event.preventDefault();
                        const rowToDelete = this.closest('tr');

                        if (confirm('Apakah Anda yakin ingin menghapus item ini?')) {
                            rowToDelete.remove();

                            const rows = document.querySelectorAll('#barangTable tbody tr');
                            rows.forEach((row, index) => {
                                row.querySelector('.no').textContent = index + 1;
                            });

                            const barangTableBody = document.querySelector('#barangTable tbody');
                            if (barangTableBody.querySelectorAll('tr').length === 0) {
                                barangTableBody.innerHTML = `
                                <tr id="noDataRow">
                                    <x-admin.td colspan="10" class="text-center">Tidak ada data</x-admin.td>
                                </tr>
                            `;
                            }

                            calculateTotals();
                        }
                    });
                });
            }

            function calculateTotals() {
                let subTotal = 0;

                document.querySelectorAll('#barangTable .total2 input').forEach(input => {
                    const value = parseFloat(input.value.replace('Rp. ', '').replace(',', ''));
                    subTotal += value;
                });

                document.querySelector('input[name="subTotal"]').value = subTotal.toFixed(2);

                const diskonInput = document.querySelector('input[name="diskonNilai"]');
                const ongkirInput = document.querySelector('input[name="ongkir"]');
                const diskon = parseFloat(diskonInput.value) || 0;
                const ongkir = parseFloat(ongkirInput.value) || 0;

                const totalBayar = subTotal - diskon + ongkir;

                document.querySelector('input[name="totalBayar"]').value = totalBayar.toFixed(2);
            }

            addEditEventListeners();
            addDeleteEventListeners();

            document.getElementById('btnTambah').addEventListener('click', function() {
                const namaBarang = document.getElementById('namaBarang');
                const selectedOption = namaBarang.options[namaBarang.selectedIndex];
                const [kode, harga] = selectedOption.getAttribute('data-info').split('|');
                const qty = document.getElementById('qty').value;
                const diskon = document.getElementById('diskon').value;

                const hargaBandrol = parseFloat(harga);
                const hargaDiskon = hargaBandrol - (hargaBandrol * (diskon / 100));
                const total = hargaDiskon * qty;

                const barangTableBody = document.querySelector('#barangTable tbody');
                const noUrut = barangTableBody.querySelectorAll('tr').length;

                const newRow = `
                <tr>
                    <x-admin.td class="no">${noUrut + 1}</x-admin.td>
                    <x-admin.td class="kode"><input type="text" class="form-control form-control-sm" name="kodeBarang[]" value="${kode}" readonly></x-admin.td>
                    <x-admin.td class="nama"><input type="text" class="form-control form-control-sm" name="namaBarang[]" value="${selectedOption.text}" readonly></x-admin.td>
                    <x-admin.td class="qty"><input type="number" class="form-control form-control-sm" name="qty[]" value="${qty}" readonly></x-admin.td>
                    <x-admin.td class="hargaBandrol"><input type="text" class="form-control form-control-sm" name="hargaBandrol[]" value="${hargaBandrol.toFixed(2)}" readonly></x-admin.td>
                    <x-admin.td class="diskon"><input type="text" class="form-control form-control-sm" name="diskon[]" value="${diskon}" readonly></x-admin.td>
                    <x-admin.td class="hargaDiskon"><input type="text" class="form-control form-control-sm" name="hargaDiskon[]" value="${(hargaBandrol * (diskon / 100)).toFixed(2)}" readonly></x-admin.td>
                    <x-admin.td class="total"><input type="text" class="form-control form-control-sm" name="total[]" value="${hargaDiskon.toFixed(2)}" readonly></x-admin.td>
                    <x-admin.td class="total2"><input type="text" class="form-control form-control-sm" name="total2[]" value="${total.toFixed(2)}" readonly></x-admin.td>
                    <x-admin.td>
                        <a href="#" class="btn bg-gradient-info btn-edit"><i class="fa fa-pencil" aria-hidden="true"></i><span class="text-capitalize ms-1">Edit</span></a>
                        <a href="#" class="btn bg-gradient-danger btn-delete"><i class="fa fa-trash" aria-hidden="true"></i><span class="text-capitalize ms-1">Hapus</span></a>
                    </x-admin.td>
                </tr>
            `;

                const noDataRow = document.getElementById('noDataRow');
                if (noDataRow) {
                    noDataRow.remove();
                }

                barangTableBody.insertAdjacentHTML('beforeend', newRow);

                addEditEventListeners();
                addDeleteEventListeners();

                calculateTotals();

                const tambahModal = bootstrap.Modal.getInstance(document.getElementById('addData'));
                tambahModal.hide();
            });

            document.getElementById('btnEdit').addEventListener('click', function() {
                const namaBarang = document.getElementById('editNamaBarang');
                const selectedOption = namaBarang.options[namaBarang.selectedIndex];
                const [kode, harga] = selectedOption.getAttribute('data-info').split('|');
                const qty = document.getElementById('editQty').value;
                const diskon = document.getElementById('editDiskon').value;

                const hargaBandrol = parseFloat(harga);
                const hargaDiskon = hargaBandrol - (hargaBandrol * (diskon / 100));
                const total = hargaDiskon * qty;

                currentEditRow.querySelector('.kode input').value = kode;
                currentEditRow.querySelector('.nama input').value = selectedOption.text;
                currentEditRow.querySelector('.qty input').value = qty;
                currentEditRow.querySelector('.hargaBandrol input').value =
                    `${hargaBandrol.toFixed(2)}`;
                currentEditRow.querySelector('.diskon input').value = diskon;
                currentEditRow.querySelector('.hargaDiskon input').value = (hargaBandrol * (diskon / 100))
                    .toFixed(2);
                currentEditRow.querySelector('.total input').value = `${hargaDiskon.toFixed(2)}`;
                currentEditRow.querySelector('.total2 input').value = `${total.toFixed(2)}`;

                calculateTotals();

                const editModal = bootstrap.Modal.getInstance(document.getElementById('editData'));
                editModal.hide();
            });

            document.querySelectorAll('input[name="diskonNilai"], input[name="ongkir"]').forEach(input => {
                input.addEventListener('input', calculateTotals);
            });
        });
    </script>
@endsection
