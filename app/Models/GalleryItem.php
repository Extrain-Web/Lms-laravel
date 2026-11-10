<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'image_url',
        'caption',
        'description',
    ];

    public function getDescriptionAttribute($value)
    {
        return $value ?: $this->caption;
    }
}
