<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 't_menus';

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
