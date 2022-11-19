<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    #-------------Membuat Register------------
    public function register(Request $request)
    {
        # Menangkap Inputan
        $input = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->passwaord),
        ];

        # Menginput data ke tabel user
        $user = User::create($input);

        $data = [
            'message' => 'User is created succesfully',
        ];

        return response()->json($data, 200);
    }
    #-------------Membuat Login---------------
    public function login(Request $request)
    {
        # menangkap inputan user
        $input = [
            'email' => $request->email,
            'password' => $request->password
        ];

        # mengambil data user di database
        $user = User::where('email', $input['email'])->first();

        # membandingkan inputan user dengan database
        $isLoginSuccesfully = $input['email'] == $user->email && Hash::check($input['password'], $user->password);

        if ($isLoginSuccesfully) {
            # membuat token
            $token = $user->createToken('auth_token');

            $data = [
                'message' => 'Login Succesfully',
                'token' => $token->plainTextToken
            ];

            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Email and Password incorrect'
            ];

            return response()->json($data, 401);
        }
    }
}
