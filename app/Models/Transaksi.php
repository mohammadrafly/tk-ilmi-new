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
        return $this->hasMany(ListTransaksi::class, 'kode', 'kode');
    }

    public function kategoriTransaksi()
    {
        return $this->hasManyThrough(
            KategoriTransaksi::class,  // The final related model
            ListTransaksi::class,      // The intermediate model
            'kode',                    // Foreign key on ListTransaksi (relating to Transaksi)
            'id',                      // Foreign key on KategoriTransaksi (relating to ListTransaksi)
            'kode',                    // Local key on Transaksi
            'kategori_id'              // Local key on ListTransaksi (relating to KategoriTransaksi)
        );
    }


    public function listCicilTransaksi()
    {
        return $this->hasMany(ListCicilTransaksi::class, 'kode', 'kode');
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
