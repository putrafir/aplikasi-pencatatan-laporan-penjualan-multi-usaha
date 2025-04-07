<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SizePrice extends Model
{
    /** @use HasFactory<\Database\Factories\SizePriceFactory> */
    use HasFactory;

    protected $fillable = ['category_id', 'size_id', 'harga'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }
}
