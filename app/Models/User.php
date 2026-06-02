<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'user'; 

    // UBAH BAGIAN INI: Sesuaikan dengan nama primary key di database kamu. 
    // Jika namanya 'id', tulis 'id'.
    protected $primaryKey = 'id'; 

    public $timestamps = false; 

    protected $fillable = ['username', 'password', 'role'];
}