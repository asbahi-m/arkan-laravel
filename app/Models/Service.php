<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function type() {
        return $this->belongsTo(Type::class);
    }

    public function views() {
        return $this->hasMany(View::class, 'view_id')->where('view_model', class_basename($this));
    }

    public function t_services() {
        return $this->hasMany(T_service::class);
    }

    ## Accessor
    protected function getIsPublishedAttribute($value) {
        return $value == 1 ? 'published' : 'unpublished';
    }
}
