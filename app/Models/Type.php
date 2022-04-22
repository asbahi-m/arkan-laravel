<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $hidden = ['created_at', 'updated_at'];

    public function services() {
        return $this->hasMany(Service::class);
    }

    public function products() {
        return $this->hasMany(Product::class);
    }

    public function projects() {
        return $this->hasMany(Project::class);
    }
}
