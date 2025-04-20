<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    protected $guarded = [];
    public function menus()
    {
        return $this->hasMany(Menu::class, 'kategori_id');
    }
    public function sizePrices()
    {
        return $this->hasMany(SizePrice::class);
    }
}
