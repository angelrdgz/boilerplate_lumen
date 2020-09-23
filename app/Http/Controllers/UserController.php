<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\User;
use Illuminate\Http\Response\ApiResponser as ResponseApiResponser;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use ApiResponser;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    public function index()
    {
        $users = User::all();
        return $this->validResponse($users);
    }

    public function store(Request $request)
    {
        $rules =  [
            "name" => "required|max:255",
            "email" => "required|unique:users,email|email",
            "password" => "required|min:7|confirmed",
        ];

        $this->validate($request, $rules);

        $fields = $request->all();
        $fields['password'] = Hash::make($request->password);
        $user = User::create($fields);
        return $this->validResponse($user, Response::HTTP_CREATED);

    }

    public function show($user)
    {
        $user = User::findOrFail($user);
        return $this->validResponse($user);
    }

    public function update(Request $request, $user)
    {
        $rules =  [
            "name" => "max:255",
            "email" => "email|unique:users,email,".$user,
            "password" => "min:7|confirmed",
        ];

        $this->validate($request, $rules);
        $user = User::findOrFail($user);

        $user->fill($request->all());

        if($request->has('password')){
            $user->password = Hash::make($request->password);
        }

        if($user->isClean()){
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user->save();

        return $this->validResponse($user, Response::HTTP_CREATED);

    }

    public function destroy($user)
    {
        $user = User::findOrFail($user);
        $user->delete();
        return $this->validResponse($user);
    }

    //

    public function me(Request $request)
    {
        //return $this->validateResponse($request->user());
    }
}
