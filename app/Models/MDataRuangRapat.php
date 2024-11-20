<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MDataRuangRapat extends Model
{
    protected $table = 'data_ruangan';
    protected $primary_key = 'id';
    protected $fillable = [
        'uuid', 'ruang', 'time_available', 'day_available', 'lokasi', 'gedung', 'kampus'
    ];
}
