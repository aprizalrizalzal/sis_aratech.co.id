<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['service_code', 'customer_id', 'device_id', 'date_received',  'problem_description', 'estimated_completion', 'items_brought', 'status'];

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
    public function serviceDetail()
    {
        return $this->hasOne(ServiceDetail::class);
    }

    protected static function booted()
    {
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderByDesc('created_at');
        });
    }
}
