<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\User;
use Illuminate\Http\Response\ApiResponser as ResponseApiResponser;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $this->validate($request, [
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (Hash::check($request->password, $user->password)) {
            /**Take note of this: Your user authentication access token is generated here **/
            $data['token'] =  $user->createToken('MyApp')->accessToken;
            $data['user'] =  $user;

            return response(['data' => $data, 'message' => 'Account created successfully!', 'status' => true]);
        }
    }
}
