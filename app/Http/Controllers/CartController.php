<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\User;
use App\Models\Menu;
use App\Models\Tag;

class CartController extends Controller
{
    public function index(Request $request)
    {

        $items = Cart::all();

        foreach($items as $item) {
            // user
            $user = User::where('id', $item->user_id)->first();
            $item->user = $user;
            // menu
            $menu = Menu::where('id', $item->menu_id)->get();
            $item->menu = $menu;
        }

        return response()->json(['data' => $items]);

    }

    public function store(Request $request)
    {
        Cart::create([
            'user_id' => $request->user_id,
            'menu_id' => $request->menu_id,
            'quantity' => $request->quantity
        ]);

        $cart = $this->userCart($request);
        return response()->json(['message' => $cart], 201);
    }

    public function userCart(Request $request)
    {
        $items = Cart::where('user_id', $request->id)->get();
        foreach ($items as $item) {
            // menu
            $menu = Menu::where('id', $item->menu_id)->get();
            $item->menu_title = $menu[0]->title;
            $item->menu_discription = $menu[0]->discription;
            $item->menu_image = $menu[0]->image;
            $item->menu_tag_id = $menu[0]->tag_id;
            $item->menu_price = $menu[0]->price;
        }

        return response()->json(['data' => $items]);
    }

    public function update(Request $request, $id)
    {
        $update = [
            'quantity' => $request->quantity,
        ];
        $item = Cart::find($id)->update($update);

        if ($item) {
            return response()->json(['message' => '変更しました'], 201);
        } else {
            return response()->json(['message' => '変更に失敗しました'], 404);
        }
    }


    public function destroy(Request $request)
    {
        $item = Cart::where('id', $request->id)->delete();
        if ($item) {
            return response()->json(['data' => 'カートから削除しました'], 201);
        } else {
            return response()->json(['message' => 'カートから削除できませんでした'], 404);
        }
    }

    public function userCartDelete(Request $request)
    {
        $item = Cart::where('user_id', $request->id)->delete();
        if ($item) {
            return response()->json(['data' => 'カートから削除しました'], 201);
        } else {
            return response()->json(['message' => 'カートから削除できませんでした'], 404);
        }
    }
}
