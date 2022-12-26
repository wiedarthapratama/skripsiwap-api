<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersFcm extends Model
{
    use HasFactory;

    protected $table = 'users_fcm';
    protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $fillable = [
        'id_user',
        'fcm_id',
        'fcm_token'
    ];
}
