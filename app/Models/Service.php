<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['service_code', 'customer_id', 'device_id', 'date_received', 'items_brought', 'estimated_completion', 'status'];

    // Relasi ke Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Relasi ke Device
    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    // Relasi ke ServiceDetail
    public function serviceDetails()
    {
        return $this->hasMany(ServiceDetail::class);
    }
}
