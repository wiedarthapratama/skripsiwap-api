<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KostTipe extends Model
{
    use HasFactory;

    protected $table = 'kost_tipe';
    protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $fillable = [
        'id_kost',
        'id_kost_jenis',
        'jumlah_kontrakan',
        'harga_per_bulan',
        'jumlah_ruang',
        'is_perabot',
        'is_rumah',
        'is_kamar_mandi_dalam',
        'is_listrik',
        'luas'
    ];

    // function user()
    // {
    //     return $this->hasOne('App\Models\User', 'id', 'id_user');
    // }
}
