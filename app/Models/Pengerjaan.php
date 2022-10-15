<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengerjaan extends Model
{
    use HasFactory;

    protected $table = 'pengerjaan';
    protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $fillable = [
        'id_pengaduan',
        'id_pekerja',
        'status'
    ];

    function pengaduan()
    {
        return $this->belongsTo('App\Models\Pengaduan', 'id_pengaduan', 'id');
    }

    function pekerja()
    {
        return $this->belongsTo('App\Models\Pekerja', 'id_pekerja', 'id');
    }
}
