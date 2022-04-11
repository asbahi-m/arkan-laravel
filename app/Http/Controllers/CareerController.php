<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use Storage;
use App\Mail\JobApplication;

use App\Models\Career;

class CareerController extends Controller
{
    public function index(Request $request) {
        $careers_count = Career::count();
        $pending_count = Career::where('status', 'pending')->count();
        $accepted_count = Career::where('status', 'accepted')->count();
        $rejected_count = Career::where('status', 'rejected')->count();

        $careers = Career::query();

        $careers->when($request['status'], function ($q) use ($request) {
            $q->where('status', $request['status']);
        });

        if (in_array($request['sortBy'], ['name', 'email', 'phone', 'created_at', 'status', 'response_by'])) {
            if ($request['sortBy'] == 'response_by') {
                $careers->join('users', 'users.id', '=', 'careers.response_by')
                ->select('careers.*', 'users.name as user_name')
                ->orderBy('user_name');
            } else {
                $careers->orderBy($request['sortBy']);
            }
        }

        if (in_array($request['sortByDesc'], ['name', 'email', 'phone', 'created_at', 'status', 'response_by'])) {
            if ($request['sortByDesc'] == 'response_by') {
                $careers->join('users', 'users.id', '=', 'careers.response_by')
                ->select('careers.*', 'users.name as user_name')
                ->orderByDesc('user_name');
            } else {
                $careers->orderByDesc($request['sortByDesc']);
            }
        }

        $careers = $careers->latest()->paginate(20)->withQueryString();

        return view('admin.career.index', compact('careers', 'careers_count', 'pending_count', 'accepted_count', 'rejected_count'));
    }

    public function create() {
        // return view('admin.career.create');
    }

    public function store(Request $request) {

        $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'email' => ['required', 'email'],
            'phone' => ['nullable', 'numeric', 'min:8'],
            'file' => ['required', 'mimes:pdf', 'max:5120'],
            'message' => ['nullable', 'string', 'min:3', 'max:1000'],
        ]);

        // Uploade CV Attachment
        if (isset($request['file'])) {
            $attachment = $request->file('file');
            $attach_ext = $attachment->extension();
            $attach_name = time() . '.' . $attach_ext;
            $attach_path = 'careers/' . $attach_name;

            $attachment->storePubliclyAs('careers', $attach_name, 'public');
        }

        Career::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'attachment' => isset($request['file']) ? $attach_path : null,
            'message' => $request['message'],
            'status' => 'pending',
        ]);

        Mail::to($request['email'])
        ->send(new JobApplication([
            'jobNew' => [
                'name' => $request['name'],
            ],
            'subject' => __('admin.job_application') . ' | ' . $request['name'],
        ]));

        return redirect()->route('career.index')->with('success', __('admin.job_apply_success'));
    }

    public function show(Career $career) {
        return view('admin.career.show', compact('career'));
    }

    public function destroy(Request $request) {
        $career = Career::findOrFail($request['delete']);

        // Remove CV Attachment
        Storage::delete('public/' . $career->attachment);

        $career->delete();

        return redirect()->route('career.index')->with('success', __('admin.job_delete_success'));
    }

    public function accept(Request $request) {
        $request->validate([
            'career_name' => ['required', 'string', 'min:3', 'max:100'],
            'career_email' => ['required', 'email'],
            'reply_msg' => ['required', 'string', 'min:3'],
        ]);

        Career::findOrFail($request['career_id'])->update([
            'reply_msg' => $request['reply_msg'],
            'status' => 'accepted',
            'response_by' => auth()->user()->id,
        ]);

        Mail::to($request['career_email'])
        ->send(new JobApplication([
            'jobAccept' => [
                'name' => $request['career_name'],
                'message' => $request['reply_msg'],
            ],
            'subject' => __('admin.job_application') . ' | ' . $request['career_name'],
        ]));

        return back()->with('success', __('admin.job_accept_success'));
    }

    public function reject(Request $request) {
        $request->validate([
            'career_name' => ['required', 'string', 'min:3', 'max:100'],
            'career_email' => ['required', 'email'],
            'reply_msg' => ['required', 'string', 'min:3'],
        ]);

        Career::findOrFail($request['career_id'])->update([
            'reply_msg' => $request['reply_msg'],
            'status' => 'rejected',
            'response_by' => auth()->user()->id,
        ]);

        Mail::to($request['career_email'])
        ->send(new JobApplication([
            'jobReject' => [
                'name' => $request['career_name'],
                'message' => $request['reply_msg'],
            ],
            'subject' => __('admin.job_application') . ' | ' . $request['career_name'],
        ]));

        return back()->with('success', __('admin.job_reject_success'));
    }
}
