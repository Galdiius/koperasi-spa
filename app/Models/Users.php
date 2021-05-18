<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
class Users extends Model
{
    use HasApiTokens,HasFactory;
    protected $table = 'user';
    protected $fillable = [
        'nama', 'username', 'password','level'
    ];
    public $timestamps = false;
}
