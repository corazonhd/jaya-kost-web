<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image_url',
        'blok',     
        'order_index', 
    ];

    protected $casts = [
        'order_index' => 'integer',
    ];

    public function scopeByBlok($query, $blok)
    {
        return $query->where('blok', $blok)->orderBy('order_index');
    }
}
