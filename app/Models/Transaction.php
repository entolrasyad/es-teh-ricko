<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 't_transactions';

    protected $guarded = [];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
