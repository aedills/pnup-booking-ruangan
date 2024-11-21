<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MDataGedung extends Model
{
    protected $table = 'data_gedung';
    protected $primary_key = 'id';
    protected $fillable = [
        'uuid', 'gedung', 'kampus'
    ];
}
