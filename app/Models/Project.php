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

    public function view() {
        return $this->hasMany(View::class, 'view_id')->where('view_model', class_basename($this));
    }
}
