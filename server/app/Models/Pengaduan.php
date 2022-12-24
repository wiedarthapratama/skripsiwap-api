<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    protected $table = 'pengaduan';
    protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $fillable = [
        'id_user',
        'id_pemilik',
        'id_kost',
        'id_kost_stok',
        'judul',
        'deskripsi',
        'status',
        'tanggal',
        'foto_pengaduan'
    ];

    function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'id_user');
    }

    function pemilik()
    {
        return $this->hasOne('App\Models\Pemilik', 'id', 'id_pemilik');
    }

    function kost()
    {
        return $this->hasOne('App\Models\Kost', 'id', 'id_kost');
    }

    function kost_tipe()
    {
        return $this->hasOne('App\Models\KostTipe', 'id', 'id_kost_stok');
    }

    function pengerjaan()
    {
        return $this->hasOne('App\Models\Pengerjaan', 'id_pengaduan', 'id');
    }
}
