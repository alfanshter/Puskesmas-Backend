<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $user = DB::table('users')->where('username',$request->username)->first();
        if ($user!=null) {
             $response = [
                'message' => 'username sudah terdaftar',
                'data' => 0
            ];        
            return response()->json($response,Response::HTTP_OK);  
        }
        $register = User::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'username' => $request->username,
            'role' => $request->role,
            'password' => Hash::make($request->password)
        ]);
         $token = $register->createToken('auth_token')->plainTextToken;

         
            $response = [
                'message' => 'berhasil daftar',
                'data' => 1
            ];        
            return response()->json($response,Response::HTTP_OK);  
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
  //Proses Logout
      public function logout()
    {
        Auth::user()->tokens->each(function($token, $key) {
        $token->delete();
      });

        $response = [
                'message' => 'Logout berhasil',
                'data' => 1
            ];        
            return response()->json($response,Response::HTTP_OK);  
    }
    //End Proses Logout

    public function getakunall()
    {
      $getdata = User::where('role','user')->get();
          $response = [
                'message' => 'Dam berhasil',
                'data' => $getdata
            ];

            return response()->json($response, Response::HTTP_CREATED);
    }

    public function detailakun(Request $request)
    {
          $getdata = User::get()->where('id',$request->input('id'))->first();
          $response = [
                'message' => 'Akun Detail berhasil',
                'data' => $getdata
            ];

            return response()->json($response, Response::HTTP_CREATED);
    }

    public function hapusakun(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'id' => ['required']
          
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            User::where('id',$request->id)->delete();
             $response = [
                'message' => 'delete berhasil',
                'data' => 1
            ];

         return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $th) {
              $response = [
                'message' => $th->errorInfo,
                'data' => 0
            ];
            
         return response()->json($response, Response::HTTP_OK);
        }
    }

    public function updateakun(Request $request)
    {
         $validator = Validator::make($request->all(),[
            'nama' => ['required'],
            'alamat' => ['required'],
            'password' => ['required'],
            'id' => ['required']
          
        ]);
         if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        try {
            $updatetpm = DB::table('users')->where('id',$request->id)->update([
                'nama'=> $request->nama,
                'alamat'=> $request->alamat,
                'password'=> Hash::make($request->password)
            ]);
            
            $response = [
                'message' => 'update berhasil',
                'data' => 1
            ];

            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $th) {
             $response = [
                'message' => $th->errorInfo,
                'data' => 0
            ];

            return response()->json($response, Response::HTTP_CREATED);
        }
       
    }

    public function updatepasswordamin(Request $request)
    {
          $validator = Validator::make($request->all(),[
            'password' => ['required']
          
        ]);
         if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        try {
            $updatetpm = DB::table('users')->where('role','admin')->update([
                'password'=> Hash::make($request->password)
            ]);
            
            $response = [
                'message' => 'update berhasil',
                'data' => 1
            ];

            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $th) {
             $response = [
                'message' => $th->errorInfo,
                'data' => 0
            ];

            return response()->json($response, Response::HTTP_CREATED);
        }
    }
}
