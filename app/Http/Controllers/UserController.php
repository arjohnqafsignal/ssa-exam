<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Rules\PasswordMatch;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->userService->list();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $validated = $request->validated();
        if($validated)
        {
            $filePath = '';
            if($request->file()) {
                $filePath = $this->userService->upload($request->file('photo'));
            }
            $attributes = [
                'prefixname' => $request->prefixname,
                'firstname' => $request->firstname,
                'middlename' => $request->middlename,
                'lastname' => $request->lastname,
                'suffixname' => $request->suffixname,
                'username' => $request->username,
                'email' => $request->email,
                'type' => $request->type,
                'photo' => $filePath,
                'password' => Hash::make($request->password)
            ];

            $user = $this->userService->store($attributes);

            return redirect()->route('users.index')->with('status','New User successfully created!');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user)
    {
        $user = $this->userService->find($user);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($user)
    {
        $user = $this->userService->find($user);
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $user)
    {
        $user = $this->userService->find($user);

        $validated = $request->validated();

        if($validated)
        {
            $filePath = '';
            if($request->file('')) {
                $filePath = $this->userService->upload($request->file('photo'));
            }
            $attributes = [
                'prefixname' => $request->prefixname,
                'firstname' => $request->firstname,
                'middlename' => $request->middlename,
                'lastname' => $request->lastname,
                'suffixname' => $request->suffixname,
                'username' => $request->username,
                'email' => $request->email,
                'type' => $request->type,
                'photo' => $filePath,
            ];

            if($request->filled('password'))
            {
                $attributes['password'] = Hash::make($request->password);
            }

            $user = $this->userService->update($user->id, $attributes);

            return redirect()->route('users.index')->with('status','User successfully updated!');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user)
    {
        $user = $this->userService->destroy($user);
        if($user)
        {
            return redirect()->route('users.index')->with('status', 'User Deleted!');
        }

    }

    public function delete($user)
    {

        $delete_user = $this->userService->delete($user);
        return redirect()->route('users.trashed')->with('status', 'User Permanently Deleted!');
    }

    public function trashed()
    {
        $users = $this->userService->listTrashed();

        return view('users.trashed', compact('users'));
    }

    public function restore($user)
    {
        $user = $this->userService->restore($user);

        return redirect()->route('users.trashed')->with('status', 'User Restored Successfully!');
    }
}
