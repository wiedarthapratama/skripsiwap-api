<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    use HasFactory;
    protected $table = 'provinsi';
    protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $fillable = [
        'nama_provinsi'
    ];

    function kabupatens()
    {
        return $this->hasMany('App\Models\Kabupaten', 'id_provinsi', 'id');
    }
}
