<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agama extends Model
{
    use HasFactory;

    protected $table = 'agama';

    protected $guarded = ['']; // "Mengambil, menyimpan, atau menghapus data dari tabel agama."
}
