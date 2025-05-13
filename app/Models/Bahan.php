<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bahan extends Model
{
    /** @use HasFactory<\Database\Factories\SuperCategoryFactory> */
    use HasFactory;

    protected $table = 'bahan';

    protected $guarded = [];
}
