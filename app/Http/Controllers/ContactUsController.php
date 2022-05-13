<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactUsRequest;
use Illuminate\Support\Facades\Mail;

use App\Mail\ContactUs as ContactMail;

use App\Models\ContactUs;

class ContactUsController extends Controller
{
    public function index(Request $request) {
        $msgs_count = ContactUs::count();
        $unread_count = ContactUs::where('status', 'unread')->count();
        $read_count = ContactUs::where('status', 'read')->count();

        $contacts = ContactUs::query();

        $contacts->when($request['status'], function ($q) use ($request) {
            $q->where('status', $request['status']);
        });

        if (in_array($request['sortBy'], ['name', 'email', 'phone', 'created_at', 'status', 'response_by'])) {
            $contacts->orderBy($request['sortBy']);
        }

        if (in_array($request['sortByDesc'], ['name', 'email', 'phone', 'created_at', 'status', 'response_by'])) {
            $contacts->orderByDesc($request['sortByDesc']);
        }

        $contacts = $contacts->latest()->paginate(PAGINATION_NUMBER)->withQueryString();

        return view('admin.contact.index', compact('contacts', 'msgs_count', 'unread_count', 'read_count'));
    }

    public function create() {
        // return view('admin.contact.create');
    }

    public function store(ContactUsRequest $request) {
        $validated = $request->safe();

        ContactUs::create($validated->merge(['status' => 'unread'])->all());

        Mail::to($validated['email'])
        ->send(new ContactMail([
            'contactNew' => [
                'name' => $validated['name'],
            ],
            'subject' => __('admin.contact_us') . ' | ' . $validated['name'],
        ]));

        return redirect()->route('contact.index')->with('success', __('admin.message_delete_success'));
    }

    public function show(ContactUs $contact) {
        return view('admin.contact.show', compact('contact'));
    }

    public function destroy(Request $request) {
        ContactUs::findOrFail($request['delete'])->delete();

        return redirect()->route('contact.index')->with('success', __('admin.message_delete_success'));
    }

    public function reply(Request $request) {
        $request->validate([
            'contact_name' => ['required', 'string', 'min:3', 'max:100'],
            'contact_email' => ['required', 'email'],
            'reply_msg' => ['required', 'string', 'min:3'],
        ]);

        ContactUs::findOrFail($request['contact_id'])->update([
            'reply_msg' => $request['reply_msg'],
            'status' => 'read',
            'response_by' => auth()->user()->id,
        ]);

        Mail::to($request['contact_email'])
        ->send(new ContactMail([
            'contactReply' => [
                'name' => $request['contact_name'],
                'message' => $request['reply_msg'],
            ],
            'subject' => __('admin.contact_us') . ' | ' . $request['contact_name'],
        ]));

        return redirect()->route('contact.index')->with('success', __('admin.message_reply_success'));
    }
}
