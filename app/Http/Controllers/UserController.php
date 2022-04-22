<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Fortify\Rules\Password;
use Arr;
use Rule;
use Hash;
use Storage;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('super')->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(request()->all());
        $users = User::query();
        $users->when(in_array(request('sortBy'), ['name', 'email', 'email_verified_at', 'is_super_admin']), function ($q) {
            $q->orderBy(request('sortBy'));
        })->when(in_array(request('sortByDesc'), ['name', 'email', 'email_verified_at', 'is_super_admin']), function ($q) {
            $q->orderByDesc(request('sortByDesc'));
        });

        $users = $users->paginate(PAGINATION_NUMBER)->withQueryString();
        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:40', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
            'password' => ['required', 'string', new Password, 'confirmed'],
            'is_super_admin' => ['nullable', 'boolean'],
        ]);

        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'is_super_admin' => isset($request['is_super_admin']) ? true : false,
        ]);

        $user = User::where('email', $request['email'])->first();

        event(new Registered($user));

        return redirect()->route('user.index')->with('success', __('admin.user_add_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if ($user->id == 1 && auth()->user()->id != 1) {
            return redirect()->route('user.index')->with('warning', __('admin.user_cannot_update'));
        }

        $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:40', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:100', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', new Password, 'confirmed'],
            'is_super_admin' => ['nullable', 'boolean'],
        ]);

        if ($request['email'] !== $user->email && $user instanceof MustVerifyEmail) {
            $user->email_verified_at = null;
        }

        $user->update([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => $request['password'] ? Hash::make($request['password']) : $user->password,
            'is_super_admin' => isset($request['is_super_admin']) ? true : false,
        ]);

        return redirect()->route('user.index')->with('success', __('admin.user_update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = User::findOrFail($request['delete']);

        if ($user->id == auth()->user()->id || $user->id == 1) {
            return redirect()->route('user.index')->with('warning', __('admin.user_cannot_delete'));
        }

        // Delete User Avatar
        Storage::delete('public/' . $user->profile_photo_path);

        $user->delete();

        return back()->with('success', __('admin.user_delete_success'));
    }
}
