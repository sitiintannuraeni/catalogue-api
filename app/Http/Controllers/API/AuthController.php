<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'birthdate' => 'required|date',
        ]);

        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat akun',
                'data' => $validator->errors(),
            ], 400);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'confirm_password' => $request->confirm_password,
            'birthdate' => $request->birthdate,
        ]);

        $success['token'] = $user->createToken('auth_token')->plainTextToken;
        $success['name'] = $user->name;

        return response()->json([
            'success' => true,
            'message' => 'Berhasil membuat akun',
            'data' => $success,
        ], 201);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function login(Request $request)
    {
        {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $auth = Auth::user();
                $success['token'] = $auth->createToken('auth_token')->plainTextToken;
                $success['name'] = $auth->name;
                $success['email'] = $auth->email;
    
                return response()->json([
                    'success' => true,
                    'message' => 'Akun Berhasil Login',
                    'data' => $success
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Cek email dan password lagi',
                    'data' => null
                ]);
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
