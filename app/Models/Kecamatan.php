<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;

    protected $table = 'kecamatan';
    protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $fillable = [
        'id_kabupaten',
        'nama_kecamatan'
    ];

    function desas()
    {
        return $this->hasMany('App\Models\Desa', 'id_desa', 'id');
    }

    function kabupaten()
    {
        return $this->belongsTo('App\Models\Kabupaten', 'id_kabupaten', 'id');
    }
}
