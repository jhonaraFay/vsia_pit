<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'user_id',
    ];

    public function purchases()
{
    return $this->hasMany(Purchase::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}

}
