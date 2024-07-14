<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Footer extends Model
{
    use HasFactory;

    protected $fillable = ['type_footer_id', 'platform_footer_id', 'image_path', 'url', 'username', 'value',];

    // Relasi ke TypeFooter
    public function typeFooter()
    {
        return $this->belongsTo(TypeFooter::class);
    }

    // Relasi ke PlatformFooter
    public function platformFooter()
    {
        return $this->belongsTo(PlatformFooter::class);
    }

    protected static function booted()
    {
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('type_footer_id');
        });
    }
}
