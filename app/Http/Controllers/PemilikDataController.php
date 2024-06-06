<?php

namespace App\Http\Controllers;

use App\Http\Resources\PemilikDataResource;
use Illuminate\Http\Request;
use App\Models\PemilikData;
use Illuminate\Support\Facades\Validator;

class PemilikDataController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        $data = PemilikData::when($request->search, function ($query, $search) {
            $query->where('nama_pemilik_data', 'like', '%' . $search . '%');
        })->paginate(1); 

        return new PemilikDataResource(true, 'List Data Pemilik Data', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_pemilik_data' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = PemilikData::create([
            'nama_pemilik_data' => $request->nama_pemilik_data,
        ]);

        return new PemilikDataResource(true, 'Data Berhasil Disimpan', $data);
    }

    public function show($id)
    {
        $data = PemilikData::find($id);
        if ($data) {
            return new PemilikDataResource(true, 'Data Ditemukan', $data);
        } else {
            return new PemilikDataResource(false, 'Data Tidak Ditemukan', null);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_pemilik_data' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = PemilikData::find($id);
        if ($data) {
            $data->update([
                'nama_pemilik_data' => $request->nama_pemilik_data,
            ]);
            return new PemilikDataResource(true, 'Data Berhasil Diubah', $data);
        }else{
            return new PemilikDataResource(false, 'Data Tidak Ditemukan', null);
        }
    }

    public function destroy($id)
    {
        $data = PemilikData::find($id);
        if ($data) {
            $data->delete();
            return new PemilikDataResource(true, 'Data Berhasil Dihapus', null);
        }else{
            return new PemilikDataResource(false, 'Data Tidak Ditemukan', null);
        }
    }
}
