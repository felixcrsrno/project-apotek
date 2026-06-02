<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    // Mengunci nama tabel agar Laravel tidak mencari 'detail_transaksis'
    protected $table = 'detail_transaksi';
    
    public $timestamps = false;

    protected $fillable = ['id_transaksi', 'id_obat', 'jumlah', 'subtotal'];

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'id_obat', 'id_obat');
    }
}