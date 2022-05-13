<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $hidden = ['created_at', 'updated_at'];

    public function t_sliders() {
        return $this->hasMany(T_slider::class);
    }

    ## Accessor
    protected function getIsPublishedAttribute($value) {
        return $value == 1 ? 'published' : 'unpublished';
    }
}
