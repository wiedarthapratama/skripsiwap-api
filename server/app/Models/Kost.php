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
        return $this->hasOne('App\Models\Desa', 'id', 'id_desa');
    }

    function kecamatan()
    {
        return $this->hasOne('App\Models\Kecamatan', 'id', 'id_kecamatan');
    }

    function kabupaten()
    {
        return $this->hasOne('App\Models\Kabupaten', 'id', 'id_kabupaten');
    }

    function provinsi()
    {
        return $this->hasOne('App\Models\Provinsi', 'id', 'id_provinsi');
    }

    function pemilik()
    {
        return $this->hasOne('App\Models\Pemilik', 'id', 'id_pemilik');
    }

    function tipe()
    {
        return $this->hasMany('App\Models\KostTipe', 'id_kost', 'id');
    }
}
