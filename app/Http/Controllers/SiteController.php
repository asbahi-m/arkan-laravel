<?php

namespace App\Http\Controllers;

use App\Http\Requests\CareerRequest;
use App\Http\Requests\ContactUsRequest;
use App\Http\Requests\OrderRequest;
use App\Mail\ContactUs as ContactMail;
use App\Mail\JobApplication;
use App\Mail\ServiceOrder;
use App\Models\Career;
use App\Models\Client;
use App\Models\ContactUs;
use App\Models\Feature;
use App\Models\Order;
use App\Models\Page;
use App\Models\Product;
use App\Models\Project;
use App\Models\Service;
use App\Models\Slider;
use App\Models\Type;
use App\Traits\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SiteController extends Controller
{
    use UploadFile;

    public function home() {
        $sliders = Slider::where('is_published', true)->where('place', 'home')->orderBy('order')->get();
        $about_us = Page::where('is_published', true)->find(1);
        $features = Feature::where('is_published', true)->limit(4)->get();
        $types = Type::all();
        $services = Service::where('is_published', true)->get();
        $clients = Client::where('is_published', true)->get();
        return view('site.home', compact('sliders', 'about_us', 'features', 'types', 'services', 'clients'));
    }

    public function page($id) {
        $page = Page::where('is_published', true)->findOrFail($id);
        $features = Feature::where('is_published', true)->limit(4)->get();
        $projects = Project::where('is_published', true)->limit(6)->latest()->get();
        $clients = Client::where('is_published', true)->get();
        return view('site.page', compact('page', 'features', 'projects', 'clients'));
    }

    public function feature($id) {
        $feature = Feature::where('is_published', true)->findOrFail($id);
        return view('site.feature', compact('feature'));
    }

    public function services() {
        $services = Service::where('is_published', true)->get();
        return view('site.services');
    }

    public function service($id) {
        $service = Service::where('is_published', true)->findOrFail($id);
        return view('site.service', compact('service'));
    }

    public function products() {
        $products = Product::where('is_published', true)->get();
        return view('site.products');
    }

    public function product($id) {
        $product = Product::where('is_published', true)->findOrFail($id);
        return view('site.product', compact('product'));
    }

    public function projects() {
        $projects = Project::where('is_published', true)->get();
        return view('site.projects');
    }

    public function project($id) {
        $project = Project::where('is_published', true)->findOrFail($id);
        return view('site.project', compact('project'));
    }

    public function clients() {
        $clients = Client::where('is_published', true)->get();
        return view('site.clients');
    }

    public function client($id) {
        $client = Client::where('is_published', true)->findOrFail($id);
        return view('site.client', compact('client'));
    }

    public function serviceOrder(OrderRequest $request) {
        $validated = $request->safe();

        Order::create($validated->merge(['status' => 'pending'])->all());

        $service = Service::find($validated['service_id']);

        Mail::to($validated['email'])
        ->send(new ServiceOrder([
            'orderNew' => [
                'name' => $validated['name'],
                'service' => $service->name,
            ],
            'subject' => __('site.service_order') . ' | ' . $service->name . ' | ' . $validated['name'],
        ]));

        return back()->with('success', __('site.order_service_success'));
    }

    public function jobApplication(CareerRequest $request) {
        $validated = $request->safe();

        // Uploade CV Attachment
        if ($request->hasFile('attachment')) {
            $attach_path = $this->saveFile($request->file('attachment'), 'careers');

            $validated['attachment'] = $attach_path;
        }

        Career::create($validated->merge(['status' => 'pending'])->all());

        Mail::to($validated['email'])
        ->send(new JobApplication([
            'jobNew' => [
                'name' => $validated['name'],
            ],
            'subject' => __('admin.job_application') . ' | ' . $validated['name'],
        ]));

        return back()->with('success', __('admin.job_apply_success'));
    }

    public function contactUs(ContactUsRequest $request) {
        $validated = $request->safe();

        ContactUs::create($validated->merge(['status' => 'unread'])->all());

        Mail::to($validated['email'])
        ->send(new ContactMail([
            'contactNew' => [
                'name' => $validated['name'],
            ],
            'subject' => __('admin.contact_us') . ' | ' . $validated['name'],
        ]));

        return back()->with('success', __('admin.message_delete_success'));
    }
}
