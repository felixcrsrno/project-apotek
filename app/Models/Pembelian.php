<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected $table = 'pembelian';
    protected $primaryKey = 'id_pembelian';
    public $timestamps = false;

    protected $fillable = ['no_faktur', 'nama_supplier', 'tanggal', 'total_bayar', 'metode_pembayaran'];
}