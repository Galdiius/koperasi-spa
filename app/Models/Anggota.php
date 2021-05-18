<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;
    protected $table = 'anggota';
    protected $fillable = [
        'kode_anggota', 'nama', 'jenis_kelamin','tanggal_lahir','alamat','kontak','tanggal_gabung','status_anggota'
    ];
    public $timestamps = false;
}
