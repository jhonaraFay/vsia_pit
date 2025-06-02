<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Product;
use App\Models\Customer;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'customers_id',
        'products_id',
        'quantity',
        'total',
        'purchase_date',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class, 'products_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customers_id');
    }
}
