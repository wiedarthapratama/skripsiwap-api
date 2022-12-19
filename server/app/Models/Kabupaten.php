<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    use HasFactory;

    protected $table = 'kabupaten';
    protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $fillable = [
        'id_provinsi',
        'nama_kabupaten'
    ];

    function kecamatans()
    {
        return $this->hasMany('App\Models\Kecamatan', 'id_kabupaten', 'id');
    }

    function provinsi()
    {
        return $this->belongsTo('App\Models\Provinsi', 'id_provinsi', 'id');
    }
}
