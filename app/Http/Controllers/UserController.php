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
            $user->password = \Hash::make($request->password);
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
        $role = Role::find($id);

        return $role;
    }

    public function edit(Request $request)
    {
        $role = Role::find($request->id);
        $role->role_desc = $request->get('role_desc');
        $role->save();

        return redirect()->route('roles')->with('status', 'Berhasil mengubah role');
    }

    public function delete($id)
    {
        $role = Role::find($id);

        $role->delete();

        return redirect()->route('roles')->with('status', 'Berhasil menghapus role');
    }
}
