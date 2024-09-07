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
}
