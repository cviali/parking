<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class parked_car extends Model
{
    protected $fillable = ['nopol', 'kode', 'pegawai'];
}
