<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $page = "Users";
        $users = User::get();
        return view('admin.pages.User.index', compact('page', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required',
            'role' => 'required',
            'password' => 'required',
        ]);

        $store = new User();
        $store->name = $request->nama;
        $store->email = $request->email;
        $store->role = $request->role;
        $store->password = Hash::make($request->password);
        $store->save();

        return redirect()->route('users.show')->with('success', 'Data user berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required',
            'role' => 'required',
        ]);

        $update = User::find($id);
        $update->name = $request->nama;
        $update->email = $request->email;
        $update->role = $request->role;
        if ($request->password != null) {
            $update->password = Hash::make($request->password);
        }
        $update->save();
        return redirect()->route('users.show')->with('success', 'Data user berhasil diubah.');
    }

    public function destroy($id)
    {
        $destroy = User::find($id);
        $destroy->delete();
        return redirect()->route('users.show')->with('success', 'Data user berhasil dihapus.');
    }
}
