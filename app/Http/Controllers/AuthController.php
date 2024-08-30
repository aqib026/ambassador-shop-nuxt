<?php

namespace App\Http\Controllers;

use App\HTTP\Requests\RegisterRequest;
use App\HTTP\Requests\UpdateInfoRequest;
use App\HTTP\Requests\UpdatePasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    //

    public function register(RegisterRequest $request){

        $user = User::create(
            $request->only('first_name', 'last_name', 'email')
            + [
                'password' => \Hash::make($request->input('password')),
                'is_admin' => $request->path() == 'api/admin/register' ? 1 : 0
            ]
        );

        echo response($user, Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {
        if(!\Auth::attempt( $request->only('email', 'password'))){
            return response(
                [
                    'error' => 'invalid credentials',
                ], Response::HTTP_UNAUTHORIZED
            );
        }

        
        $user = \Auth::user();
        $scope = $request->path() == 'api/admin/login' ? 'admin' : 'ambassador';
        $jwt = $user->createToken('token', [$scope])->plainTextToken;
        $cookie = cookie('jwt', $jwt, 60*24);

        return response([
            'message' => $jwt
        ])->withCookie($cookie);


    }

    public function user(Request $request)
    {
        return $request->user();
    }

    public function updateInfo(UpdateInfoRequest $request)
    {  
        $user = $request->user();
        $user->update($request->only('first_name', 'last_name', 'email'));

        return response( $user, Response::HTTP_ACCEPTED );
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = $request->user();
        
        $user->update(
            [ 
                'password' => \Hash::make($request->input('password'))
            ]
        );
        
        return response(
            [
                'message' => 'success',
            ], Response::HTTP_ACCEPTED
        );
    }

    public function logout()
    {
        $cookie = \Cookie::forget('jwt');

        return response([
            'message' => 'success'
            ])->withCookie($cookie);
    }
}
