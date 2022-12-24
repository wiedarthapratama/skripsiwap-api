<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $table = 'bank';
    protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $fillable = [
        'nama_bank',
        'nama_rekening',
        'nomor_rekening',
        'id_pemilik'
    ];
}
