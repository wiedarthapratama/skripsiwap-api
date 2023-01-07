<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pekerja extends Model
{
    use HasFactory;

    protected $table = 'pekerja';
    protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $fillable = [
        'nama',
        'nohp',
        'id_user',
        'id_provinsi',
        'id_kabupaten',
        'id_kecamatan',
        'id_desa',
        'alamat'
    ];

    function provinsi()
    {
        return $this->hasOne('App\Models\Provinsi', 'id', 'id_provinsi');
    }

    function kabupaten()
    {
        return $this->hasOne('App\Models\Kabupaten', 'id', 'id_kabupaten');
    }

    function kecamatan()
    {
        return $this->hasOne('App\Models\Kecamatan', 'id', 'id_kecamatan');
    }

    function desa()
    {
        return $this->hasOne('App\Models\Desa', 'id', 'id_desa');
    }

    function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'id_user');
    }
}
