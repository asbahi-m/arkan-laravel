<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $hidden = ['created_at', 'updated_at'];

    ## Accessor
    protected function getIsPublishedAttribute($value) {
        return $value == 1 ? 'published' : 'unpublished';
    }
}
