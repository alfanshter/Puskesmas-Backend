<?php

namespace App\Http\Controllers;

use App\Models\Tpm;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class TpmControlller extends Controller
{
    public function inserttpm(Request $request)
    {
            
          $validator = Validator::make($request->all(),[
            'tpm' => ['required'],
            'desa' => ['required'],
            'pemilik' => ['required'],
            'alamat' => ['required'],
            'golongan' => ['required'],
            'karyawan' => ['required'],
            'ikl' => ['required'],
            'ujisampel' => ['required'],
            'sertifikatpenjamaah' => ['required'],
            'laiksehat' => ['required'],
            'izinusaha' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $tpm = Tpm::create($request->all());
            $response = [
                'message' => 'tpm berhasil',
                'data' => $tpm
            ];

            return response()->json($response, Response::HTTP_CREATED);

        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed" . $e->errorInfo
            ]);
        }


    }

    public function readtpmall()
    {
        $getdata = Tpm::get();
          $response = [
                'message' => 'tpm berhasil',
                'data' => $getdata
            ];

            return response()->json($response, Response::HTTP_CREATED);
    }
 
    public function readtpmdetail(Request $request)
    {
        $getdata = Tpm::get()->where('id',$request->input('id'))->first();
          $response = [
                'message' => 'tpm berhasil',
                'data' => $getdata
            ];

            return response()->json($response, Response::HTTP_CREATED);
    }

    public function updatetpm(Request $request)
    {
        try {
            $updatetpm = DB::table('tpms')->where('id',$request->id)->update($request->all());
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

    public function deletetpm(Request $request)
    {
        try {
            Tpm::where('id',$request->id)->delete();
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

}
