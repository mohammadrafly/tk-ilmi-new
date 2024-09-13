<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramSemester extends Model
{
    use HasFactory;

    protected $table = 'programsemester';

    protected $guarded = [''];

    public function tahunajaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran');
    }
}
