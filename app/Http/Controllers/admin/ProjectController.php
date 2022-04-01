<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function view() {
        $result = Project::all();
        return $result;
    }

    public function latest() {
        $result = Project::limit(3)->orderByDesc('id')->get();
        return $result;
    }

    public function show($id) {
        $result = Project::findOrFail($id);
        return $result;
    }
}
