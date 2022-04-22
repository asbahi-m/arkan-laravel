<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function type() {
        return $this->belongsTo(Type::class);
    }

    public function views() {
        return $this->hasMany(View::class, 'view_id')->where('view_model', class_basename($this));
    }

    ## Accessor
    protected function getIsPublishedAttribute($value) {
        return $value == 1 ? 'published' : 'unpublished';
    }
}
