<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPembelian extends Model
{
    protected $table = 'detail_pembelian';
    public $timestamps = false;

    protected $fillable = ['id_pembelian', 'id_obat', 'qty', 'harga_beli', 'subtotal'];
}