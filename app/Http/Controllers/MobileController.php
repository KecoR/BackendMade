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

    public function viewProfile($id)
    {
        $dataUser = User::find($id);

        if (!empty($dataUser)) {
            return response()->json(['statusCode' => 1, 'data' => $dataUser]);
        } else {
            return response()->json(['statusCode' => 0, 'data' => 'Data Tidak Ditemukan']);
        }
    }

    public function editProfile(Request $request, $id)
    {
        $user = User::find($id);

        $email = $request->get('email');
        $email_old = $request->get('email_old');
        $image = $request->get('image');
        $birth = $request->get('date_birth');
        $password = $request->get('password');

        $finalBirth = date('Y-m-d', strtotime($birth));

        if (!empty($user)) {
            $user->name = $request->get('name');
            $user->telp = $request->get('telp');
            $user->alamat = $request->get('alamat');
            $user->umur = $request->get('umur');
            $user->jenis_kel = $request->get('jenis_kel');
            $user->save();

            return response()->json(['statusCode' => 1, 'data' => 'OK']);
        } else {
            return response()->json(['statusCode' => 0, 'data' => 'User Tidak Ditemukan']);
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
        $vacancy->gaji = $request->get('gaji');
        $vacancy->tipe_gaji = $request->get('tipe_gaji');
        $vacancy->slot = $request->get('slot');
        $vacancy->luas_lahan = $request->get('luas_lahan');
        $vacancy->latitude = $request->get('latitude');
        $vacancy->longitude = $request->get('longitude');
        $vacancy->pemilik_id = $id;
        $vacancy->save();

        return response()->json(['statusCode' => 1, 'data' => 'Data berhasil ditambah']);
    }

    public function viewBuruh($id)
    {
        $userVac = UserVacancy::where('vacancys_id', $id)->with('buruh')->get();

        if ($userVac->count() > 0) {
            return response()->json(['statusCode' => 1, 'data' => $userVac]);
        } else {
            return response()->json(['statusCode' => 0, 'data' => 'Data Tidak Ditemukan']);
        }
    }

    //Modul Buruh
    public function buruhVacancies($id, $lat, $lon)
    {
        $vacancies = Vacancy::whereDoesntHave('buruh', function($q) use ($id) {
            $q->where('pelamar_id', $id);
        })->where('status', 1)->whereRaw('buruh < slot')->with('pemilik')->get();

        if ($vacancies->count() > 0) {
            foreach ($vacancies as $vacancy) {
                $vacancy->distance = $this->haversineMethod($lat, $lon, $vacancy->latitude, $vacancy->longitude);
            }

            $dataVacancies = $vacancies->sortBy('distance');

            return response()->json(['statusCode' => 1, 'data' => $dataVacancies]);
        } else {
            return response()->json(['statusCode' => 0, 'data' => 'Data tidak ditemukan']);
        }
        
    }

    public function getVacancy($id)
    {
        $vacancy = Vacancy::find($id);

        if (!empty($vacancy)) {
            return response()->json(['statusCode' => 1, 'data' => $vacancy]);
        } else {
            return response()->json(['statusCode' => 0, 'data' => 'Data Tidak Ditemukan']);
        }
    }

    public function applyJob(Request $request, $id, $vacancyid)
    {
        $vacancy = Vacancy::find($vacancyid);

        if (!empty($vacancy)) {
            if ($vacancy->buruh < $vacancy->slot) {
                $userVacancy = new UserVacancy;
                $userVacancy->vacancys_id = $vacancyid;
                $userVacancy->pelamar_id = $id;
                $userVacancy->message_id = $request->get('message_id');
                $userVacancy->save();

                $vacancy = Vacancy::find($vacancyid);
                $vacancy->buruh += 1;
                $vacancy->save();

                return response()->json(['statusCode' => 1, 'data' => 'Data Berhasil Ditambah']);
            } else {
                return response()->json(['statusCode' => 0, 'data' => 'Slot Full']);
            }
            
        } else {
            return response()->json(['statusCode' => 0, 'data' => 'Data Tidak Ditemukan']);
        }
        
    }

    public function historyJob($id)
    {
        $userVac = UserVacancy::where('pelamar_id', $id)->with('vacancy', 'vacancy.pemilik')->get();

        if ($userVac->count() > 0) {
            return response()->json(['statusCode' => 1, 'data' => $userVac]);
        } else {
            return response()->json(['statusCode' => 0, 'data'=> 'Data Tidak Ditemukan']);
        }
    }

    protected function haversineMethod($lat1, $lon1, $lat2, $lon2)
    {
        $r = 6371;
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * asin(sqrt($a));
        $d = $r * $c;
	
        return round($d, 2);
    }
}
