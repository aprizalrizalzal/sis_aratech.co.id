<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SparePart extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image_path', 'category_spare_part_id', 'pieces', 'price', 'description'];

    // Relasi ke CategorySparePart
    public function categorySparePart()
    {
        return $this->belongsTo(CategorySparePart::class);
    }

    // Relasi ke PartUsage
    public function partUsages()
    {
        return $this->hasMany(PartUsage::class);
    }

    protected static function booted()
    {
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('category_spare_part_id');
        });
    }

    // Scope lokal untuk hasil acak
    public function scopeRandom($query)
    {
        return $query->inRandomOrder();
    }
}
