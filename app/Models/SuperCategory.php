<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SuperCategory extends Model
{
    /** @use HasFactory<\Database\Factories\SuperCategoryFactory> */
    use HasFactory;

    // Boleh mass assign semua field
    protected $guarded = [];

    /**
     * Relasi: SuperCategory milik sebuah Business
     */
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    /**
     * Relasi: SuperCategory punya banyak Menu
     * Menggunakan foreign key 'kategori_id' di tabel 'menus'
     */
    public function menus()
    {
        return $this->hasMany(Menu::class, 'kategori_id');
    }

    /**
     * Relasi: SuperCategory punya banyak SizePrice
     */
    public function sizePrices()
    {
        return $this->hasMany(SizePrice::class);
    }
    /**
     * Relasi: SuperCategory punya banyak Category
     */
    public function categories()
    {
        return $this->hasMany(Category::class, 'super_kategori_id');
    }
}
