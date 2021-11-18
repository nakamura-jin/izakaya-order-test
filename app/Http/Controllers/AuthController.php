<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'role_id' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json(['message' => '登録に失敗しました']);
        }


        $items = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        return response()->json(['data' => $items]);
    }


    public function getUser(Request $request)
    {
        $item = User::where('email', $request->email)->first();

        if ($item) {
            return response()->json(['data' => $item], 201);
        } else {
            return response()->json(['message' => 'ユーザーが見当たりません'], 404);
        }
    }

}
