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
        'status',
        'nama_rekening',
        'nama_bank',
        'to_id_bank',
        'komentar'
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

    function bank()
    {
        return $this->hasOne('App\Models\Bank', 'id', 'to_id_bank');
    }
}
