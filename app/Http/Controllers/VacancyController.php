<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Vacancy;
use App\UserVacancy;

class VacancyController extends Controller
{
    public function index()
    {
        $vacancy = Vacancy::all();

        return view('vacancy.index', ['vacancies' => $vacancy]);
    }

    public function approve($id)
    {
        $vacancy = Vacancy::find($id);
        $vacancy->status = 1;
        $vacancy->save();

        return redirect()->route('vacancy')->with('status', 'Lowongan berhasil di approve');
    }

    public function reject($id)
    {
        $vacancy = Vacancy::find($id);
        $vacancy->status = -1;
        $vacancy->save();

        return redirect()->route('vacancy')->with('status', 'Lowongan berhasil di reject');
    }
}
