<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CareerRequest;
use Mail;
use Storage;
use App\Mail\JobApplication;
use App\Traits\UploadFile;

use App\Models\Career;

class CareerController extends Controller
{
    use UploadFile;

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

        $careers = $careers->latest()->paginate(PAGINATION_NUMBER)->withQueryString();

        return view('admin.career.index', compact('careers', 'careers_count', 'pending_count', 'accepted_count', 'rejected_count'));
    }

    public function create() {
        // return view('admin.career.create');
    }

    public function store(CareerRequest $request) {
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
