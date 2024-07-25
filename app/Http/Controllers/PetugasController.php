<?php

namespace App\Http\Controllers;

use App\Models\Officer;
use App\Models\User;
use Illuminate\Http\Request;

class PetugasController extends Controller
{
    public function index()
    {
        $page = "Petugas";
        $petugas = Officer::whereHas('user', function ($query) {
            $query->where('role', 'petugas');
        })->get();
        $users = User::where('role', 'petugas')->get();
        return view('admin.pages.Petugas.index', compact('page', 'petugas', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kodePetugas' => 'required',
            'namaPetugas' => 'required',
            'noHp' => 'required',
        ]);

        $store = new Officer();
        $store->user_id = $request->namaPetugas;
        $store->kode = $request->kodePetugas;
        $store->telp = $request->noHp;
        $store->save();

        return redirect()->route('petugas.show')->with('success', 'Data petugas berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kodePetugas' => 'required',
            'namaPetugas' => 'required',
            'noHp' => 'required',
        ]);

        $update = Officer::find($id);
        $update->user_id = $request->namaPetugas;
        $update->kode = $request->kodePetugas;
        $update->telp = $request->noHp;
        $update->save();
        return redirect()->route('petugas.show')->with('success', 'Data petugas berhasil diubah.');
    }

    public function destroy($id)
    {
        $destroy = Officer::find($id);
        $destroy->delete();
        return redirect()->route('petugas.show')->with('success', 'Data petugas berhasil dihapus.');
    }
}
