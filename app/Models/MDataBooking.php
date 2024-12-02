<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MDataBooking extends Model
{
    protected $table = 'data_booking';
    protected $primary_key = 'id';
    protected $fillable = [
        'uuid', 'kode', 'nama', 'no_hp', 'agenda_rapat', 'tanggal', 'uuid_ruang', 'kode_ruang'
    ];
}
