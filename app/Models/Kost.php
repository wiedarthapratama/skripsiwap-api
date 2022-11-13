<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kost extends Model
{
    use HasFactory;

    protected $table = 'kost';
    protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $fillable = [
        'id_pemilik',
        'judul',
        'deskripsi',
        'id_provinsi',
        'id_kabupaten',
        'id_kecamatan',
        'id_desa',
        'alamat',
        'lat',
        'long'
    ];

    function desa()
    {
        return $this->hasOne('App\Models\Desa', 'id_desa', 'id');
    }

    function kecamatan()
    {
        return $this->hasOne('App\Models\Kecamatan', 'id_kecamatan', 'id');
    }

    function kabupaten()
    {
        return $this->hasOne('App\Models\Kabupaten', 'id_kabupaten', 'id');
    }

    function provinsi()
    {
        return $this->hasOne('App\Models\Provinsi', 'id_provinsi', 'id');
    }

    function pemilik()
    {
        return $this->hasOne('App\Models\Pemilik', 'id_pemilik', 'id');
    }

    function tipe()
    {
        return $this->hasMany('App\Models\KostTipe', 'id', 'id_kost');
    }
}
