<?php

namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Helpers\ApiFormatter;
use App\Models\User;



class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index()
    {
        try {
            //ambil data yg mau ditampilkan
            $data = User::all()->toArray();

            return ApiFormatter::sendResponse(200, 'success', $data);
        }catch (\Exception $err){
            return ApiFormatter::sendResponse(400, 'bad request', $err->getMessage());
        }
    }

    public function store (Request $request)
    {
        try {
            // validasi
            // 'nama_column' => validasi
            $this->validate($request, [
                'email' => 'required|unique:users,email',
                'username' => 'required|min:4|unique:users,username',
                'password' => 'required|min:3',
                'role' => 'required'
            ]);

            $prosesData = user::create([
                'email' => $request->email,
                'username' => $request->username,
                'password' => hash::make($request->password),
                'role' => $request->role,
            ]);

            if ($prosesData) {
                return ApiFormatter::sendResponse(200, 'success', $prosesData);
            } else {
                return ApiFormatter::sendResponse(400, 'bad request', 'gagal memproses tambah data users! silahkan coba lagi.');
            }
        }catch (\Exception $err) {
            return ApiFormatter::sendResponse(400,'bad request',$err->getMessage());
        }
    }
    public function show($id)
    {
        try {
            $data = User::where('id', $id)->first();
            return ApiFormatter::sendResponse(200, 'success', $data);
        } catch (\Exception $err) {
            return ApiFormatter::sendResponse(400, 'bad request', $err->getMessage());
        }
    }

    public function update(Request $Request, $id)
    {
        try {
            $this->validate($Request, [
                'username' => 'required|unique:users,email',
                'email' => 'required|min:4|unique:users,username',
                'password' => 'required|min:6',
                'role' => 'required'
            ]);

            $checkProses = User::where('id', $id)->update([
                'username' => $Request->username,
                'email' => $Request->email,
                'password' => hash::make($Request->password),
                'role' => $Request->role
            ]);

            if ($checkProses) {
                $data = User::where('id', $id)->first();

                return ApiFormatter::sendResponse(200, 'success', $data);
            }
        } catch (\Exception $err) {
            return ApiFormatter::sendResponse(400, 'bad request', $err->getmessage());
        }
    }

    public function destroy($id)
    {
        try {
            $checkproses = User::where('id', $id)->delete();

            if ($checkproses) {
                return
                    ApiFormatter::sendResponse(200, 'succes', 'berhasil hapus data User!');
            }
        } catch (\Exception $err) {
            return
                ApiFormatter::sendResponse(400, 'bad request', $err->getMessage());
        }
    }

    public function trash()
    {
        try {
            $data = User::onlyTrashed()->get();

            return
                ApiFormatter::sendResponse(200, 'succes', $data);
        } catch (\Exception $err) {
            return
                ApiFormatter::sendResponse(400, 'bad request', $err->getMessage());
        }
    }

    public function restore($id)
    {
        try {
            $checkRestore = User::onlyTrashed()->where('id',$id)->restore();

            if ($checkRestore) {
                $data = User::where('id', $id)->first();
                return ApiFormatter::sendResponse(200, 'succes', $data);
            }
        }catch (\Exception $err) {
            return ApiFormatter::sendResponse(400, 'bad request', $err->getMessage());
        }
    }

    public function permanentDelete($id)
    {
        try {
            // forceDelete() = untuk menghapus secara permanent (hilang juga data di databasenya)
            $checkPermanetDelete = User::onlyTrashed()->where('id',$id)->forceDelete();

            if ($checkPermanetDelete) {
                return ApiFormatter::sendResponse(200,'success','berhasil menghapus data stuff!');
            }
        }catch(\Exception $err){
            return ApiFormatter::sendResponse(400,'bad request',$err->getMessage());
        }
    }
}


