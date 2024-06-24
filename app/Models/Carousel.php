<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// Belum Selesai
class Carousel extends Model
{
    use HasFactory;

    protected $fillable = ['image_path', 'alt',];

    protected static function booted()
    {
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderByDesc('created_at');
        });
    }
}
