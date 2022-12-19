<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KostFoto extends Model
{
    use HasFactory;

    protected $table = 'kost_foto';
    protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $fillable = [
        'id_kost_jenis',
        'main_foto',
        'foto'
    ];
}
