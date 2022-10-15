<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KostStok extends Model
{
    use HasFactory;

    protected $table = 'kost_stok';
    protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $fillable = [
        'id_kost',
        'id_user',
        'tersedia'
    ];

    function kost()
    {
        return $this->belongsTo('App\Models\Kost', 'id_kost', 'id');
    }

    function user()
    {
        return $this->hasOne('App\Models\User', 'id_user', 'id');
    }
}
