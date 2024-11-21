<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MDataRuangRapat extends Model
{
    protected $table = 'data_ruangan';
    protected $primary_key = 'id';
    protected $fillable = [
        'uuid', 'ruang', 'time_available', 'day_available', 'lokasi', 'id_gedung', 'kampus'
    ];

    public function gedung(){
        return $this->hasOne(MDataGedung::class, 'id', 'id_gedung');
    }
}
