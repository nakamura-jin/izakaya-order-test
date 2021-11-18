<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $items = User::where('role_id', '<', 3)->get();

        foreach ($items as $item) {
            $role = Role::where('id', $item->role_id)->first();
            $item->role_name = $role->role_name;
        }

        return response()->json([
            'data' => $items
        ], 200);
    }

    public function show($user)
    {
        $item = User::find($user);

        if ($item) {
            return response()->json(['data' => $item], 201);
        } else {
            return response()->json(['message' => 'エラーです'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $update = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ];
        $item = User::find($id)->update($update);

        if ($item) {
            return response()->json(['message' => '変更しました'], 201);
        } else {
            return response()->json(['message' => '変更に失敗しました'], 404);
        }
    }

    public function destroy(Request $request)
    {
        $item = User::where('id', $request->id)->delete();
        if ($item) {
            return response()->json(['message' => 'ユーザーを削除しました'], 201);
        } else {
            return response()->json(['message' => 'ユーザを削除できませんでした'], 404);
        }
    }

    public function userList()
    {
        $items = User::where('role_id', '=', 3)->get();

        foreach ($items as $item) {
            $role = Role::where('id', $item->role_id)->first();
            $item->role_name = $role->role_name;
        }

        return response()->json([
            'data' => $items
        ], 200);
    }

}
