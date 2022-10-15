<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemilik extends Model
{
    use HasFactory;

    protected $table = 'pemilik';
    protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $fillable = [
        'id_user',
        'id_provinsi',
        'id_kabupaten',
        'id_kecamatan',
        'id_desa',
        'alamat'
    ];

    function provinsi()
    {
        return $this->hasOne('App\Models\Provinsi', 'id_provinsi', 'id');
    }

    function kabupaten()
    {
        return $this->hasOne('App\Models\Kabupaten', 'id_kabupaten', 'id');
    }

    function kecamatan()
    {
        return $this->hasOne('App\Models\Kecamatan', 'id_kecamatan', 'id');
    }

    function desa()
    {
        return $this->hasOne('App\Models\Desa', 'id_desa', 'id');
    }
}
