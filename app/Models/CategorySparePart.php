<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategorySparePart extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    // Relasi ke SparePart
    public function spareParts()
    {
        return $this->hasMany(SparePart::class);
    }

    protected static function booted()
    {
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('name');
        });
    }
}
