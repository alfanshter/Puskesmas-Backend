<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nama' => ['required'],
            'alamat' => ['required'],
            'username' => ['required'],
            'role' => ['required'],
            'password' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $register = User::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'username' => $request->username,
            'role' => $request->role,
            'password' => Hash::make($request->password)
        ]);
         $token = $register->createToken('auth_token')->plainTextToken;

            return response()
                ->json(['data' => $register,'access_token' => $token, 'token_type' => 'Bearer', ]);
    }

       //Proses Login
     public function login(Request $request)
    {
        if (!Auth::attempt($request->only('username', 'password')))
        {
             $response = [
                'message' => 'username atau password salah',
                'data' => 0
            ];        
            return response()->json($response,Response::HTTP_OK);  
        }

        $user = User::where('username', $request['username'])->first();
        if ($user->role =="admin") {
             $token = $user->createToken('auth_token')->plainTextToken;
            $response = [
                'message' => 'admin',
                'data' => 1,
                'token' => $token
            ];        
            return response()->json($response,Response::HTTP_OK);  
        }
        else  if ($user->role =="user") {
             $token = $user->createToken('auth_token')->plainTextToken;
            $response = [
                'message' => 'user',
                'data' => 1,
                'token' => $token,
            ];        
            return response()->json($response,Response::HTTP_OK);  
        }
      
             
           

    }
    //End Proses Login

}
