<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'supplier';
    
    // PERBAIKAN UTAMA: Wajib deklarasikan primary key custom kamu
    protected $primaryKey = 'id_supplier'; 
    
    public $timestamps = false;

    protected $fillable = [
        'nama_supplier', 

    ];
}