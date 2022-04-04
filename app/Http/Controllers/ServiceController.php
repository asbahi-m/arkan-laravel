<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    public function view() {
        $result = Service::all();
        return $result;
    }

    public function show($id) {
        $result = Service::findOrFail($id);
        return $result;
    }
}
