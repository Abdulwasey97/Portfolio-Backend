<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'url',
        'technologies',
        'is_featured',
        'completion_date',
        'order'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'completion_date' => 'date',
        'technologies' => 'array'
    ];
}
