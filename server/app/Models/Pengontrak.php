<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengontrak extends Model
{
    use HasFactory;

    protected $table = 'pengontrak';
    protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $fillable = [
        'id_kost_jenis',
        'id_user',
        'tanggal_masuk',
        'status',
        'nomor_kost',
        'id_pendaftaran'
    ];
}
