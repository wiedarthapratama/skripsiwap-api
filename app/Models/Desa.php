<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    use HasFactory;

    protected $table = 'desa';
    protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $fillable = [
        'id_kecamatan',
        'nama_desa'
    ];

    function kecamatan()
    {
        return $this->belongsTo('App\Models\Kecamatan', 'id_kecamatan', 'id');
    }
}
