<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesDetails extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function rSales()
    {
        return $this->belongsTo(Sales::class);
    }

    public function rBarang()
    {
        return $this->belongsTo(Barang::class, 'barang_id', 'id');
    }
}
