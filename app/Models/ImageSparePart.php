<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageSparePart extends Model
{
    use HasFactory;

    protected $fillable = ['spare_part_id', 'image_path'];

    // Relasi ke SparePart
    public function sparePart()
    {
        return $this->belongsTo(SparePart::class);
    }
}
