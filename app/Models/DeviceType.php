<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceType extends Model
{
    use HasFactory;

    protected $fillable = ['type_name'];

    // Relasi ke Device
    public function devices()
    {
        return $this->hasMany(Device::class);
    }
}
