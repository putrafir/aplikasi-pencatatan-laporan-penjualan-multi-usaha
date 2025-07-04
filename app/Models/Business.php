<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    protected $table = 'business';

    protected $fillable = ['name'];

    public function users()
    {
        return $this->hasMany(User::class, 'id_business', 'id');
    }

    public function menus()
    {
        return $this->hasMany(Menu::class, 'business_id');
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class, 'business_id');
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'business_id', 'id'); // Relasi ke tabel transaksis
    }
}
