<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = ['device_type_id', 'model', 'serial_number'];

    // Relasi ke DeviceType
    public function deviceType()
    {
        return $this->belongsTo(DeviceType::class, 'device_type_id');
    }

    // Relasi Ke Service
    public function services()
    {
        return $this->hasMany(Service::class);
    }

    protected static function booted()
    {
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderByDesc('created_at');
        });
    }
}
