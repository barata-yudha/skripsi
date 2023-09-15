<?php

namespace App\Http\Controllers;

use App\DataTables\UserDataTable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(UserDataTable $dataTable)
    {
        return $dataTable->render('master.user.index', [
            'title' => 'List User',
            'datatable' => true
        ]);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah User'
        ];
        return view('master.user.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'unique:users,email'],
            'username' => ['required', 'unique:users,username'],
            'password' => ['required'],
            'foto' => ['nullable', 'file', 'mimes:jpg,jpeg,png,bmp', 'between:0,1048'],
            'role' => ['required']
        ]);

        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->username = $request->username;
            $user->password = Hash::make($request->password);

            if ($request->hasFile('foto')) {
                $filename = Str::random(32) . '.' . $request->file('foto')->getClientOriginalExtension();
                $foto_path = $request->file('foto')->storeAs('public/foto', $filename);
            }

            $user->foto = isset($foto_path) ? $foto_path : '';
            $user->role = $request->role;
            $user->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membuat user: ' . $e->getMessage());
        }

        return redirect()->route('dashboard.user.index')->with('success', 'Berhasil membuat user.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        $data = [
            'data' => $user,
            'title' => 'Edit User'
        ];

        return view('master.user.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'unique:users,email,' . $id],
            'username' => ['required', 'unique:users,username, ' . $id],
            'password' => ['nullable'],
            'foto' => ['nullable', 'file', 'mimes:jpg,jpeg,png,bmp', 'between:0,1048'],
            'role' => ['required']
        ]);

        try {
            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
            if ($request->password) {
                $user->password = Hash::make($request->password);
            }

            if ($request->hasFile('foto')) {
                if($user->foto != '') {
                    try {
                        Storage::delete($user->foto);
                    } catch (\Throwable $th) {
                    }
                }
                $filename = Str::random(32) . '.' . $request->file('foto')->getClientOriginalExtension();
                $foto_path = $request->file('foto')->storeAs('public/foto', $filename);
                $user->foto = $request->file('foto')->getClientOriginalName();
            }
            $user->foto = isset($foto_path) ? $foto_path : $user->foto;

            $user->role = $request->role;
            $user->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengupdate user: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Berhasil mengupdate user.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        try {
            if($user->foto != '') {
                try {
                    Storage::delete($user->foto);
                } catch (\Throwable $th) {
                }
            }
            $user->delete();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Berhasil menghapus data user.');
    }

    public function profile()
    {
        $user = Auth::user();
        $data = [
            'title' => 'Profile Anda',
            'data' => $user
        ];

        return view('master.user.profile', $data);
    }

    public function profile_update(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $request->validate([
            'name' => ['required'],
            'username' => ['nullable', 'unique:users,username,' . $user->id],
            'email' => ['nullable', 'unique:users,email,' . $user->id],
            'password' => ['nullable'],
            'foto' => ['nullable', 'file', 'mimes:jpg,jpeg,png,bmp', 'between:0,1048'],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('foto')) {
            if($user->foto != '') {
                try {
                    Storage::delete($user->foto);
                } catch (\Throwable $th) {
                }
            }
            $filename = Str::random(32) . '.' . $request->file('foto')->getClientOriginalExtension();
            $foto_path = $request->file('foto')->storeAs('public/foto', $filename);
            $user->foto = $request->file('foto')->getClientOriginalName();
        }
        $user->foto = isset($foto_path) ? $foto_path : $user->foto;
        $user->save();

        return redirect()->back()->with('success', 'Berhasil mengupdate profile');
    }
}
