<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class T_project extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function locale() {
        return $this->belongsTo(Locale::class);
    }
}
