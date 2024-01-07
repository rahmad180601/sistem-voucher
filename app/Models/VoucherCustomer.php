<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherCustomer extends Model
{
    use HasFactory;
    protected $table = "voucher_customer";
    protected $fillable = [
        'user_id',
        'voucher_id',
        'cart_id',
    ];
}
