<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Menu;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['tag_name'];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
