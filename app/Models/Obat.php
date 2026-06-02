<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    protected $table = 'obat'; 
    protected $primaryKey = 'id_obat'; // Sesuaikan primary key kamu
    public $timestamps = false;

    protected $fillable = ['nama_obat', 'kategori', 'stok', 'harga', 'expired'];
}