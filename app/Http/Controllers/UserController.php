<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Role;

class UserController extends Controller
{
    public function index()
    {
        $user = User::all();
        $role = Role::all();

        return view('user.index', ['users' => $user, 'roles' => $role]);
    }

    public function add(Request $request)
    {
        $cekUser = User::where('email', $request->email)->first();

        if (empty($cekUser)) {
            $user = new User;
            $user->name = $request->get('name');
            $user->email = $request->get('email');
            $user->password = \Hash::make($request->get('password'));
            $user->role_id = $request->get('role_id');
            $user->umur = $request->get('umur');
            $user->telp = $request->get('telp');
            $user->jenis_kel = $request->get('jenis_kel');
            $user->tgl_lahir = $request->get('tgl_lahir');
            $user->alamat = $request->get('alamat');
            $user->save();

            return redirect()->route('users')->with('status', 'Berhasil menambahkan role');
        }

        return redirect()->route('users')->with('fail', 'Gagal menambahakn user, Email telah digunakan');

    }

    public function getData($id)
    {
        $user = User::find($id);

        return $user;
    }

    public function edit(Request $request)
    {
        $user = User::find($request->id);
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        if ($request->has('password')) {
            $user->password = \Hash::make($request->get('password'));
        }
        $user->role_id = $request->get('role_id');
        $user->umur = $request->get('umur');
        $user->telp = $request->get('telp');
        $user->jenis_kel = $request->get('jenis_kel');
        if ($request->get('tgl_lahir')) {
            $user->tgl_lahir = $request->get('tgl_lahir');
        } else {
            $user->tgl_lahir = $request->get('old_tgl_lahir');
        }
        
        $user->alamat = $request->get('alamat');
        $user->save();

        return redirect()->route('users')->with('status', 'Berhasil mengubah user');
    }

    public function delete($id)
    {
        $user = User::find($id);

        $user->delete();

        return redirect()->route('users')->with('status', 'Berhasil menghapus user');
    }
}
