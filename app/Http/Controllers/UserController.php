<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('Admin.User.User', compact('users'));
    }

    public function laporan()
    {
        $users = User::all();
        return view('Admin.Laporan.User', compact('users'));
    }


    public function create()
    {
        return view('Admin.User.TambahUser');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required',
        ]);

        User::create([
            'name' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'alamat' => $request->alamat,
            'nomor_hp' => $request->nomor_hp,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'desa' => $request->desa,
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        return view('Admin.User.DetailUser', compact('user'));
    }

    public function edit(User $user)
    {
        return view('Admin.User.EditUser', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required',
        ]);

        $user->update([
            'name' => $request->nama_lengkap,
            'email' => $request->email,
            'role' => $request->role,
            'alamat' => $request->alamat,
            'nomor_hp' => $request->nomor_hp,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'desa' => $request->desa,
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil diupdate.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }

    public function cetakUser()
    {
        $users = User::all();

        $pdf = Pdf::loadView('Admin.Laporan.CetakUser', compact('users'));

        return $pdf->stream('laporan_user.pdf');
    }

}
