<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // protected $fillable = ['user_id', 'menu_list', 'total_price', 'display', 'date', 'time'];

        protected $casts = ['menu_list' => 'json'];

        protected $guarded = ['id'];

}
