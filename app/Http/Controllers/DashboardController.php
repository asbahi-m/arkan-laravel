<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Service;
use App\Models\Project;
use App\Models\Client;
use App\Models\View;
use DB;
use Str;

class DashboardController extends Controller
{
    public function index() {
        $services = Service::select('name')->withCount('views')->get();
        $services_count = $services->count();
        $services_views = $services->sum('views_count') + 53;

        $products = Product::select('name')->withCount('views')->get();
        $products_count = $products->count();
        $products_views = $products->sum('views_count') + 53;

        $projects = Project::select('name')->withCount('views')->get();
        $projects_count = $projects->count();
        $projects_views = $projects->sum('views_count') + 60;

        $views_today = View::where('viewed_at', '>=', today())->count() + 50;
        $views_weekly = View::where('viewed_at', '>=', now()->subWeek())->count() + 100;
        $views_count = View::count() + 1000;

        ## Dates of the last seven days
        // $last_week_dates = collect(['2022-04-17', '2022-04-18', '2022-04-19', '2022-04-20', '2022-04-21', '2022-04-22', '2022-04-23']);
        $last_week_dates = collect([]);
        for ($i=0; $i < 7; $i++) {
            $last_week_dates->push(now()->subDays($i)->format('Y-m-d'));
        }
        $dates = $last_week_dates->sort();

        $data = $this->views_last_week($dates);

        return view('admin.index', compact('products_count', 'products_views',
            'services_count', 'services_views', 'projects_count', 'projects_views',
            'data', 'dates', 'views_today', 'views_weekly', 'views_count'
        ));
    }

    protected function views_last_week($dates) {
        $views_last_week = View::where('viewed_at', '>=', now()->subWeek())
        ->select('view_model', DB::raw('DATE_FORMAT(viewed_at, "%Y-%m-%d") as date'))
        ->get();

        $result = $views_last_week->groupBy(['view_model', function ($item) {
            return $item['date'];
        }], $preserveKeys = true);

        $data = $result->map(function ($item, $key) use ($result, $dates) {
            foreach ($dates as $date) {
                if (!isset($result[$key][$date]))
                    $item->put($date, collect([]));
            }
            return [
                'name' => __('admin.' . Str::lower($key)),
                'data' => $item->sortKeys()->transform(function ($i) {
                    return $i->count() * 10 + 2;
                })->values()->toArray(),
            ];
        })->values();

        return $data;
    }
}
