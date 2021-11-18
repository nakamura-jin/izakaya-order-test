<?php

namespace App\Http\Controllers;

use App\Events\OrderCreated;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{

    public function index()
    {
        $items = Order::orderBy('date', 'asc')->orderBy('time', 'asc')->get();

        foreach ($items as $item) {
            $lists = [];
            foreach ($item->menu_list as $id) {
                $menu = Menu::where('id', $id['id'])->first();
                $menu->quantity = $id[('quantity')];
                // $menu = $id['quantity'];

                array_push($lists, $menu);
            }

            $item->menu_list = $lists;

            $user = User::where('id', $item->user_id)->first();
            $item->user_name = $user->name;
        }

        return response()->json([
            'data' => $items
        ], 200);
    }

    public function create(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required',
            'menu_list' => 'required',
            'date' => 'required',
            'time' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json(['message' => '登録に失敗しました']);
        }


        $order = Order::create([
            'user_id' => $request->user_id,
            'menu_list' => $request->menu_list,
            'display' => 1,
            'cooked' => 1,
            'date' => $request->date,
            'time' => $request->time,
        ]);


        event(new OrderCreated($order));

        return $order;
    }

    public function show($order)
    {
        $item = Order::find($order);

        foreach ($item->menu_list as $id) {
            $lists = [];
            $menu = Menu::where('id', $id)->first();
            // $item
            $menu->quantity = $id['quantity'];
            array_push($lists, $menu);
        }

        $item->menu_list = $lists;

        $user = User::where('id', $item->user_id)->first();
        $item->user_name = $user->name;

        if ($item) {
            return response()->json(['data' => $item], 201);
        } else {
            return response()->json(['message' => 'エラーです'], 404);
        }
    }


    public function update(Request $request, $id)
    {

        $update = [
            'user_id' => $request->user_id,
            'menu_list' => $request->menu_list,
            'display' => $request->display,
            'cooked' => 1,
            'date' => $request->date,
            'time' => $request->time,
        ];

        $item = Order::find($id)->update($update);


        if ($item) {
            return response()->json(['data' => $item], 201);
        } else {
            return response()->json(['message' => '変更に失敗しました'], 404);
        }
    }


    public function cooked(Request $request, $id)
    {
        $update = [
            'cooked' => $request->cooked,
        ];

        $item = Order::find($id)->update($update);

        if ($item) {
            return response()->json(['data' => $item], 201);
        } else {
            return response()->json(['message' => '変更に失敗しました'], 404);
        }
    }

    public function listDelete(Request $request)
    {
        $order_list = Order::where('id', $request->id)->first();

        $listData = ['id' => $request->menu_id, 'quantity' => $request->quantity];
        foreach ($order_list->menu_list as $list) {
            if($listData == $list) {
                $data = $list;
            }
        }

        $arr = $order_list->menu_list;
        $index = array_search($data, $arr);
        unset($arr[$index]);

        $update = [
            'menu_list' => $arr
        ];

        $item = $order_list->update($update);

        if ($item) {
            return response()->json(['data' => $item], 201);
        } else {
            return response()->json(['message' => '変更に失敗しました'], 404);
        }

    }
}
