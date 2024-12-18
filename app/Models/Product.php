<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image', 'price', 'description']; // Tambahkan 'description'

    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image); // Menghasilkan URL lengkap untuk gambar
    }
}
