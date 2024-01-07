<?php

namespace App\Models;

use App\Models\Transaksi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransaksiDetail extends Model
{
    use HasFactory;
    protected $table = "transaksi_detail";
    protected $fillable = [
        'transaksi_id',
        'produk_id',
        'qty',
        'total',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
    
}
