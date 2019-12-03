<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    public function pemilik()
    {
        return $this->belongsTo('App\User', 'pemilik_id', 'id');
    }

    public function buruh()
    {
        return $this->hasMany('App\UserVacancy', 'vacancys_id', 'id');
    }
}
