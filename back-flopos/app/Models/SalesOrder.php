<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    use HasFactory;

    protected $fillable = [ 'product_id', 'customer_id', 'total_amount', 'total_quantity', 'payment', 'zipcode' ];
}
