<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id', 'product_id', 'quantity', 'status', 'order_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Mendapatkan total harga keranjang
    public function getTotalPriceAttribute()
    {
        return $this->product->price * $this->quantity;
    }

    // Mark as purchased
    public function markAsCompleted()
    {
        $this->status = 'completed';
        $this->save();
    }

    // Menangani checkout keranjang
    public function checkout()
    {
        // Mengubah status menjadi 'completed' untuk semua item
        $this->markAsCompleted();

        // Simpan total harga untuk catatan transaksi atau keperluan lain
        return $this->getTotalPriceAttribute();
    }
}

