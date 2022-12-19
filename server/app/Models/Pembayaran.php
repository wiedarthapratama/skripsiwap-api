<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';
    protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $fillable = [
        'id_user',
        'id_pemilik',
        'id_kost',
        'id_kost_stok',
        'jumlah_bayar',
        'tanggal_bayar',
        'bukti_bayar',
        'status'
    ];

    function user()
    {
        return $this->hasOne('App\Models\User', 'id_user', 'id');
    }

    function pemilik()
    {
        return $this->hasOne('App\Models\Pemilik', 'id_pemilik', 'id');
    }

    function kost()
    {
        return $this->hasOne('App\Models\Kost', 'id_kost', 'id');
    }

    function kost_stok()
    {
        return $this->hasOne('App\Models\KostStok', 'id_kost_stok', 'id');
    }
}
