<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $hidden = ['created_at', 'updated_at'];

    public function service() {
        return $this->hasMany(Service::class);
    }

    public function product() {
        return $this->hasMany(Product::class);
    }

    public function project() {
        return $this->hasMany(Project::class);
    }
}
