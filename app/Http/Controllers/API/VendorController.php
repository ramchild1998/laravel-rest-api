<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
    public function DataVendor(){

        $data = Vendor::get();

        return response()->json([
            'success' => true,
            'message' => 'Get Data Vendor Berhasil!',
            'data' => $data
        ]);

    }

    public function InsertVendor(Request $request){

        // Valiadasi Data Vendor
        $validator = Validator::make($request->all(),
        [
            'name' => 'required',
            'pic_name' => 'required',
            'pic_phone' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan!',
                'data' => $validator->errors()
            ]);
        }

        // Jika Vendor sudah ada tidak dapat ditambahkan atau double data!
        $existingVendor = Vendor::where('name', $request->name)->first();

        if($existingVendor){
            return response()->json([
                'success' => false,
                'message' => 'Vendor sudah ada, Silahkan cek kembali!',
                'data' => null
            ]);
        }

        $vendor = new Vendor;
        $vendor->name = $request->name;
        $vendor->pic_name = $request->pic_name;
        $vendor->pic_phone = $request->pic_phone;
        $vendor->is_active = $request->is_active;

        $vendor->save();

        // Jika Sukses
        $success['name'] = $request->name;
        $success['pic_name'] = $request->pic_name;
        $success['pic_phone'] = $request->pic_phone;
        $success['is_active'] = $request->is_active;

        return response()->json([
            'success' => true,
            'message' => 'Data Vendor berhasil ditambahkan!',
            'data' => $success
        ]);

    }

    public function UpdateVendor(Request $request, $id)
    {

        // Validate Data Vendor
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required',
            'pic_name' => 'required',
            'pic_phone' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan!',
                'data' => $validator->errors()
            ]);
        }

        // Find the vendor by ID
        $vendor = Vendor::find($id);

        if (!$vendor) {
            return response()->json([
                'success' => false,
                'message' => 'Vendor tidak ada!',
                'data' => null
            ]);
        }

        // Update vendor details
        $update = Vendor::where('id', $request->$id)
            ->update([
                'name' => $request->name,
                'pic_name' => $request->pic_name,
                'pic_phone' => $request->pic_phone
            ]);

        if (!$update) {

            // Success message
            $success = [
                'id' => $vendor->id,
                'name' => $vendor->name,
                'pic_name' => $vendor->pic_name,
                'pic_phone' => $vendor->pic_phone,
            ];

            return response()->json([
                'success' => true,
                'message' => 'Data Vendor berhasil diubah!',
                'data' => $success
            ]);

        } else {

            return response()->json([
                'success' => true,
                'message' => 'Data Vendor gagal diubah!',
                'data' => null
            ]);

        }
    }

    public function DetailVendor(Request $request)
    {
        $id = $request->input('filter');

        $data = Vendor::find($id);

        if ($data) {
            return response()->json([
                'success' => true,
                'message' => 'Data ditemukan!',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan!',
                'data' => null
            ]);
        }
    }
}
