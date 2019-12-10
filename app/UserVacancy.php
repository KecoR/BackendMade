<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserVacancy extends Model
{
    public function buruh()
    {
        return $this->belongsTo('App\User', 'pelamar_id', 'id');
    }
    
    public function vacancy()
    {
        return $this->belongsTo('App\Vacancy', 'vacancys_id', 'id');
    }
}
