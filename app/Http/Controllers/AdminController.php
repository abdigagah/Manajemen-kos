<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Menampilkan data admin
    public function index()
    {
        $admins = User::all();

        return view('admin.index', compact('admins'));
    }

    // Form tambah admin
    public function create()
    {
        return view('admin.create');
    }

    // Simpan admin
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, // otomatis di-hash oleh model User
            'role' => 'admin',
        ]);

        return redirect()->route('admin.index')
            ->with('success', 'Admin berhasil ditambahkan.');
    }

    // Form edit admin
    public function edit(User $admin)
    {
        return view('admin.edit', compact('admin'));
    }

    // Update admin
    public function update(Request $request, User $admin)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $admin->id,
        ]);

        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.index')
            ->with('success', 'Admin berhasil diperbarui.');
    }

    // Hapus admin
    public function destroy(User $admin)
    {
        $admin->delete();

        return redirect()->route('admin.index')
            ->with('success', 'Admin berhasil dihapus.');
    }
}