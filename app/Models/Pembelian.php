<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    protected $table = 'pembelian';
    protected $primaryKey = 'id_pembelian';
    public $timestamps = false; // Matikan jika tidak menggunakan created_at/updated_at

    // Pastikan id_supplier diizinkan untuk diisi (Mass Assignment)
    protected $fillable = [
        'no_faktur', 
        'id_supplier', 
        'tanggal', 
        'total_bayar', 
        'metode_pembayaran'
    ];

    /**
     * PERBAIKAN UTAMA: Hubungkan id_supplier milik tabel pembelian 
     * ke id_supplier milik tabel supplier
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier', 'id_supplier');
    }
}