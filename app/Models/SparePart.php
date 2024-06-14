<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SparePart extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image_path', 'price'];

    // Relasi ke PartUsage
    public function partUsages()
    {
        return $this->hasMany(PartUsage::class);
    }
}
