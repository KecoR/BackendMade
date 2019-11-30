<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Vacancy;
use App\UserVacancy;

use Hash;

class MobileController extends Controller
{
    //Modul User
    public function doLogin(Request $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');

        $cekUser = User::where('email',  $email)->first();
        if (!empty($cekUser)) {
            if (Hash::check($password, $cekUser->password, [])) {
                $cekUser->makeHidden(['passowrd']);
    
                return response()->json(['statusCode' => 1, 'data' => $cekUser]);
            } else {
                return response()->json(['statusCode' => 0, 'data' => 'Password Salah']);
            }
        } else {
            return response()->json(['statusCode' => 0, 'data' => 'Email Tidak Ditemukan']);
        }
    }

    public function doRegist(Request $request)
    {
        $email = $request->get('email');

        $cekUser = User::where('email', $email)->first();
        
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

            return response()->json(['statusCode' => 1, 'data' => 'OK']);
        } else {
            return response()->json(['statusCode' => 0, 'data' => 'Email Telah Digunakan']);
        }
    }
}
