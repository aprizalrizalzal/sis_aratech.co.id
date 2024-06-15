<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartUsage extends Model
{
    use HasFactory;

    protected $fillable = ['service_detail_id', 'spare_part_id', 'quantity'];

    // Relasi ke ServiceDetail
    public function serviceDetail()
    {
        return $this->belongsTo(ServiceDetail::class);
    }

    // Relasi ke SparePart
    public function sparePart()
    {
        return $this->belongsTo(SparePart::class);
    }

    protected static function booted()
    {
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('service_detail_id');
        });
    }
}
