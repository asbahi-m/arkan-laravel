<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $hidden = ['created_at', 'updated_at'];

    public function type() {
        return $this->belongsTo(Type::class);
    }

    public function views() {
        return $this->hasMany(View::class, 'view_id')->where('view_model', class_basename($this));
    }

    public function t_products() {
        return $this->hasMany(T_product::class);
    }

    ## Accessor
    protected function getIsPublishedAttribute($value) {
        return $value == 1 ? 'published' : 'unpublished';
    }
}
