<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    
    protected $table = 't_orders';

    protected $guarded = [];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
