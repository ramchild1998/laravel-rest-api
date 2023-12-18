<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class RegisterController extends BaseController
{
    public function register(request $request): JsonResponse
    {
        // Validasi Data User untuk Registrasi
        $validator = Validator::make($request->all(),
        [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if($validator->fails()){

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan!',
                'data' => $validator->errors()
            ]);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('MyApp')->plainTextToken; // Token Sanctum (Login)
        $success['name'] = $user->name;

        return response()->json([
            'success' => true,
            'message' => 'Registrasi Berhasil!',
            'data' => $success
        ]);

    }

    // Fungsi Login
    public function login(Request $request): JsonResponse
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->plainTextToken;
            $success['name'] = $user->name;

            return response()->json([
                'success' => true,
                'message' => 'Login Berhasil!',
                'data' => $success
            ]);
        }else{

            return response()->json([
                'success' => true,
                'message' => 'Cek kembali email & password!',
                'data' => null
            ]);
        }
    }
}
