<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran';
    protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $fillable = [
        'id_user',
        'id_pemilik',
        'id_kost',
        'id_kost_stok',
        'tanggal_sewa',
        'foto_ktp',
        'foto_pribadi',
        'foto_kk',
        'durasi_sewa',
        'tanggal_mulai',
        'jumlah_bayar'
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
}
