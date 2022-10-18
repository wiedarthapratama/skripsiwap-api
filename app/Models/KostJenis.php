<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KostJenis extends Model
{
    use HasFactory;

    protected $table = 'kost_jenis';
    protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $fillable = [
        'id_user',
        'nama',
        'foto'
    ];

    function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'id_user');
    }
}
