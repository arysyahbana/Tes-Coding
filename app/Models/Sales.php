<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    public function rSalesDetails()
    {
        return $this->hasMany(SalesDetails::class, 'sales_id', 'id');
    }

    public function rCustomer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
}
