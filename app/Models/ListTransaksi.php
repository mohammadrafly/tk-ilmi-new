<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListTransaksi extends Model
{
    use HasFactory;

    protected $table = 'list_transaksi';

    protected $guarded = [''];

    public function kategori()
    {
        return $this->belongsTo(KategoriTransaksi::class, 'kategori_id');
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'kode', 'kode');
    }
}
