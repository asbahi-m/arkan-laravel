<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    use HasFactory;
    protected $guarded = [];
    // public $timestamps = false;
    const CREATED_AT = 'viewed_at';
    protected $dateFormat = 'U';

    public function service() {
        return $this->belongsTo(Service::class, 'view_id')->where('view_model', 'Service');
    }

    public function product() {
        return $this->belongsTo(Product::class, 'view_id')->where('view_model', 'Product');
    }

    public function project() {
        return $this->belongsTo(Project::class, 'view_id')->where('view_model', 'Project');
    }

    public function feature() {
        return $this->belongsTo(Feature::class, 'view_id')->where('view_model', 'Feature');
    }

    public function client() {
        return $this->belongsTo(Client::class, 'view_id')->where('view_model', 'Client');
    }

    public function page() {
        return $this->belongsTo(Page::class, 'view_id')->where('view_model', 'Page');
    }
}
