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
            $user->alamat = $request->get('alamat');
            $user->save();

            return response()->json(['statusCode' => 1, 'data' => 'OK']);
        } else {
            return response()->json(['statusCode' => 0, 'data' => 'Email Telah Digunakan']);
        }
    }

    //Modul Petani
    public function petaniVacancies($id)
    {
        $vacancy = Vacancy::where('pemilik_id', $id)->get();

        if (!empty($vacancy)) {
            return response()->json(['statusCode' => 1, 'data' => $vacancy]);
        } else {
            return response()->json(['statusCode' => 0, 'data' => 'Data tidak ditemukan']);
        }
    }

    public function addVacancy(Request $request, $id)
    {
        $vacancy = new Vacancy;
        $vacancy->judul = $request->get('judul');
        $vacancy->telp = $request->get('telp');
        $vacancy->gaji = $request->get('gaji');
        $vacancy->tipe_gaji = $request->get('tipe_gaji');
        $vacancy->slot = $request->get('slot');
        $vacancy->buruh = $request->get('buruh');
        $vacancy->luas_lahan = $request->get('luas_lahan');
        $vacancy->longitude = $request->get('longitude');
        $vacancy->pemilik_id = $request->get('pemilik_id');
        $vacancy->save();

        return response()->json(['statusCode' => 1, 'data' => 'Data berhasil ditambah']);
    }

    //Modul Buruh
}
