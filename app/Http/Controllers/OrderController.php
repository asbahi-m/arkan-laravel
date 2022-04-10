<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use Rule;
use App\Mail\ServiceOrder;
use App\Models\Service;
use App\Models\Order;

class OrderController extends Controller
{
    public function index(Request $request) {
        $orders = Order::query();

        $orders->when($request['status'], function ($q) use ($request) {
            $q->where('status', $request['status']);
        });

        if (in_array($request['sortBy'], ['name', 'email', 'phone', 'service', 'created_at', 'status', 'response_by'])) {
            if ($request['sortBy'] == 'service') {
                $orders->join('services', 'services.id', '=', 'orders.service_id')
                ->select('orders.*', 'services.name as service_name')
                ->orderBy('service_name');
            } else if ($request['sortBy'] == 'response_by') {
                $orders->join('users', 'users.id', '=', 'orders.response_by')
                ->select('orders.*', 'users.name as user_name')
                ->orderBy('user_name');
            } else {
                $orders->orderBy($request['sortBy']);
            }
        }

        if (in_array($request['sortByDesc'], ['name', 'email', 'phone', 'service', 'created_at', 'status', 'response_by'])) {
            if ($request['sortByDesc'] == 'service') {
                $orders->join('services', 'services.id', '=', 'orders.service_id')
                ->select('orders.*', 'services.name as service_name')
                ->orderByDesc('service_name');
            } else if ($request['sortByDesc'] == 'response_by') {
                $orders->join('users', 'users.id', '=', 'orders.response_by')
                ->select('orders.*', 'users.name as user_name')
                ->orderByDesc('user_name');
            } else {
                $orders->orderByDesc($request['sortByDesc']);
            }
        }

        $orders = $orders->paginate(20)->withQueryString();

        return view('admin.order.index', compact('orders'));
    }

    public function create() {
        // $services = Service::where('is_published', true)->get();

        // return view('admin.order.create', compact('services'));
    }

    public function store(Request $request) {
        $services = Service::where('is_published', true)->get();
        $service_ids = $services->pluck('id')->toArray();

        $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'email' => ['required', 'email'],
            'phone' => ['nullable', 'numeric', 'min:8'],
            'service' => ['required', Rule::in($service_ids)],
        ]);

        Order::create([
            'service_id' => $request['service'],
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'status' => 'pending',
        ]);

        $service = Service::find($request['service']);

        Mail::to($request['email'])
        ->send(new ServiceOrder([
            'orderNew' => [
                'name' => $request['name'],
                'service' => $service->name,
            ],
            'subject' => __('admin.service_order') . ' | ' . $service->name . ' | ' . $request['name'],
        ]));

        return redirect()->route('order.index')->with('success', __('admin.order_service_success'));
    }

    public function show(Order $order) {
        return view('admin.order.show', compact('order'));
    }

    public function destroy(Request $request) {
        Order::findOrFail($request['delete'])->delete();

        return redirect()->route('order.index')->with('success', __('admin.order_delete_success'));
    }

    public function accept(Request $request) {
        $request->validate([
            'order_name' => ['required', 'string', 'min:3', 'max:100'],
            'order_email' => ['required', 'email'],
            'order_service' => ['required', 'string'],
            'reply_msg' => ['required', 'string', 'min:3'],
        ]);

        Order::findOrFail($request['order_id'])->update([
            'reply_msg' => $request['reply_msg'],
            'status' => 'accepted',
            'response_by' => auth()->user()->id,
        ]);

        // $order = Order::findOrFail($request['order_id']);
        // $order->reply_msg = $request['reply_msg'];
        // $order->status = 'accepted';
        // $order->save();

        Mail::to($request['order_email'])
        ->send(new ServiceOrder([
            'orderAccept' => [
                'name' => $request['order_name'],
                'service' => $request['order_service'],
                'message' => $request['reply_msg'],
            ],
            'subject' => __('admin.service_order') . ' | ' . $request['order_service'] . ' | ' . $request['order_name'],
        ]));

        return back()->with('success', __('admin.order_accept_success'));
    }

    public function reject(Request $request) {
        $request->validate([
            'order_name' => ['required', 'string', 'min:3', 'max:100'],
            'order_email' => ['required', 'email'],
            'order_service' => ['required', 'string'],
            'reply_msg' => ['required', 'string', 'min:3'],
        ]);

        Order::findOrFail($request['order_id'])->update([
            'reply_msg' => $request['reply_msg'],
            'status' => 'rejected',
            'response_by' => auth()->user()->id,
        ]);
        // $order->reply_msg = $request['reply_msg'];
        // $order->status = 'rejected';
        // $order->save();

        Mail::to($request['order_email'])
        ->send(new ServiceOrder([
            'orderReject' => [
                'name' => $request['order_name'],
                'service' => $request['order_service'],
                'message' => $request['reply_msg'],
            ],
            'subject' => __('admin.service_order') . ' | ' . $request['order_service'] . ' | ' . $request['order_name'],
        ]));

        return back()->with('success', __('admin.order_reject_success'));
    }
}
