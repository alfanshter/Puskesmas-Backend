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
            'dam' => ['required'],
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
                'data' => 1
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

      public function readdamdesa(Request $request)
    {
               $getdata = DB::table('dams')->where('desa',$request->input('desa'))->get();
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

    public function getdatadam(Request $request)
    {
        $ikl0 =DB::table('dams')->where('desa',$request->input('desa'))->where('ikl',"Memenuhi Syarat")->count();
        $ikl1 =DB::table('dams')->where('desa',$request->input('desa'))->where('ikl',"Tidak Memenuhi Syarat")->count();
        $sampel0 =DB::table('dams')->where('desa',$request->input('desa'))->where('ujisampel',"Memenuhi Syarat")->count();
        $sampel1 =DB::table('dams')->where('desa',$request->input('desa'))->where('ujisampel',"Tidak Memenuhi Syarat")->count();
        $sampel2 =DB::table('dams')->where('desa',$request->input('desa'))->where('ujisampel',"Belum Uji Sampel")->count();
        $penjamaah0 =DB::table('dams')->where('desa',$request->input('desa'))->where('sertifikatpenjamaah',"Ada")->count();
        $penjamaah1 =DB::table('dams')->where('desa',$request->input('desa'))->where('sertifikatpenjamaah',"Belum Ada")->count();
        $laiksehat0 =DB::table('dams')->where('desa',$request->input('desa'))->where('laiksehat',"Ada")->count();
        $laiksehat1 =DB::table('dams')->where('desa',$request->input('desa'))->where('laiksehat',"Belum Ada")->count();
        $izin0 =DB::table('dams')->where('desa',$request->input('desa'))->where('izinusaha',"Ada")->count();
        $izin1 =DB::table('dams')->where('desa',$request->input('desa'))->where('izinusaha',"Belum Ada")->count();
       
        $response = [
                'message' => 'data',
                'ikl0' => $ikl0,
                'ikl1' => $ikl1,
                'sampel0' => $sampel0,
                'sampel1' => $sampel1,
                'sampel2' => $sampel2,
                'penjamaah0' => $penjamaah0,
                'penjamaah1' => $penjamaah1,
                'laiksehat0' => $laiksehat0,
                'laiksehat1' => $laiksehat1,
                'izin0' => $izin0,
                'izin1' => $izin1
            ];
              return response()->json($response, Response::HTTP_OK);
    }

    public function getdatadam_all(Request $request)
    {
        $ikl0 =DB::table('dams')->where('ikl',"Memenuhi Syarat")->count();
        $ikl1 =DB::table('dams')->where('ikl',"Tidak Memenuhi Syarat")->count();
        $sampel0 =DB::table('dams')->where('ujisampel',"Memenuhi Syarat")->count();
        $sampel1 =DB::table('dams')->where('ujisampel',"Tidak Memenuhi Syarat")->count();
        $sampel2 =DB::table('dams')->where('ujisampel',"Belum Uji Sampel")->count();
        $penjamaah0 =DB::table('dams')->where('sertifikatpenjamaah',"Ada")->count();
        $penjamaah1 =DB::table('dams')->where('sertifikatpenjamaah',"Belum Ada")->count();
        $laiksehat0 =DB::table('dams')->where('laiksehat',"Ada")->count();
        $laiksehat1 =DB::table('dams')->where('laiksehat',"Belum Ada")->count();
        $izin0 =DB::table('dams')->where('izinusaha',"Ada")->count();
        $izin1 =DB::table('dams')->where('izinusaha',"Belum Ada")->count();
       
        $response = [
                'message' => 'data',
                'ikl0' => $ikl0,
                'ikl1' => $ikl1,
                'sampel0' => $sampel0,
                'sampel1' => $sampel1,
                'sampel2' => $sampel2,
                'penjamaah0' => $penjamaah0,
                'penjamaah1' => $penjamaah1,
                'laiksehat0' => $laiksehat0,
                'laiksehat1' => $laiksehat1,
                'izin0' => $izin0,
                'izin1' => $izin1
            ];
              return response()->json($response, Response::HTTP_OK);
    }

}
