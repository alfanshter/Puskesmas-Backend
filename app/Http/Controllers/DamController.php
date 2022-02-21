<?php

namespace App\Http\Controllers;

use App\Models\Dam;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class DamController extends Controller
{
    public function insertdam(Request $request)
    {
            
          $validator = Validator::make($request->all(),[
            'tpm' => ['required'],
            'desa' => ['required'],
            'pemilik' => ['required'],
            'alamat' => ['required'],
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
            $tpm = Dam::create($request->all());
            $response = [
                'message' => 'dam berhasil',
                'data' => $tpm
            ];

            return response()->json($response, Response::HTTP_CREATED);

        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed" . $e->errorInfo
            ]);
        }


    }

    public function readdamall()
    {
        $getdata = Dam::get();
          $response = [
                'message' => 'Dam berhasil',
                'data' => $getdata
            ];

            return response()->json($response, Response::HTTP_CREATED);
    }
 
    public function readdamdetail(Request $request)
    {
        $getdata = Dam::get()->where('id',$request->input('id'))->first();
          $response = [
                'message' => 'Dam berhasil',
                'data' => $getdata
            ];

            return response()->json($response, Response::HTTP_CREATED);
    }

    public function updatedam(Request $request)
    {
        try {
            $updatetpm = DB::table('dams')->where('id',$request->id)->update($request->all());
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

    public function deletedam(Request $request)
    {
        try {
            Dam::where('id',$request->id)->delete();
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
