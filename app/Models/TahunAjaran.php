<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    use HasFactory;

    protected $table = 'tahunajaran';

    protected $guarded = [''];

    public function programSemesters()
    {
        return $this->hasMany(ProgramSemester::class, 'tahun_ajaran', 'tahun_ajaran');
    }
}
