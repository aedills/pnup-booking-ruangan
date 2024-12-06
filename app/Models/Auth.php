<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auth extends Model
{
    protected $table = 'data_admin';
    protected $primary_key = 'id';
    protected $fillable = [
        'uuid', 'username', 'password'
    ];
}
