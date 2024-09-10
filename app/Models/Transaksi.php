<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $guarded = [''];

    public function listTransaksi()
    {
        return $this->hasMany(ListTransaksi::class, 'kode');
    }

    public function listCicilTransaksi()
    {
        return $this->hasMany(ListCicilTransaksi::class, 'kode');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function siswa()
    {
        return $this->hasOneThrough(Siswa::class, User::class, 'id', 'user_id', 'user_id', 'id');
    }
}
