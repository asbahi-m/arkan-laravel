<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use Mail;
use App\Mail\ServiceOrder;
use App\Models\Service;
use App\Models\Order;

class OrderController extends Controller
{
    public function index(Request $request) {
        $orders_count = Order::count();
        $pending_count = Order::where('status', 'pending')->count();
        $accepted_count = Order::where('status', 'accepted')->count();
        $rejected_count = Order::where('status', 'rejected')->count();

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

        $orders = $orders->latest()->paginate(PAGINATION_NUMBER)->withQueryString();

        return view('admin.order.index', compact('orders', 'orders_count', 'pending_count', 'accepted_count', 'rejected_count'));
    }

    public function create() {
        // $services = Service::where('is_published', true)->get();

        // return view('admin.order.create', compact('services'));
    }

    public function store(OrderRequest $request) {
        $validated = $request->safe();

        Order::create($validated->merge(['status' => 'pending'])->all());

        $service = Service::find($validated['service_id']);

        Mail::to($validated['email'])
        ->send(new ServiceOrder([
            'orderNew' => [
                'name' => $validated['name'],
                'service' => $service->name,
            ],
            'subject' => __('admin.service_order') . ' | ' . $service->name . ' | ' . $validated['name'],
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
