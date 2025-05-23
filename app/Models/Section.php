<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_id',
        'project_id',
        'title',
        'content',
        'image',
        'order',
        'status',
    ];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
