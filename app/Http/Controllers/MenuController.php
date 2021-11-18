<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Tag;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;



class MenuController extends Controller
{
    public function index()
    {
        $items = Menu::all();

        foreach ($items as $item) {
            $tag = Tag::where('id', $item->tag_id)->first();
            $item->tag_name = $tag->tag_name;
        }

        return response()->json([
            'data' => $items
        ], 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'required',
            'discription' => 'required',
            'price' => 'required|numeric',
            'tag_id' => 'required',
            'image' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json(['message' => '登録に失敗しました']);
        }

        $url = $this->upload($request);

        Menu::create([
            'title' => $request->title,
            'discription' => $request->discription,
            'tag_id' => $request->tag_id,
            'price' => $request->price,
            'image' => $url,
        ]);

        return response()->json(['message', 'Successfully']);
    }

    public function upload(Request $request)
    {
        $image = $request->file('image');

        $path = Storage::disk('s3')->putFile('/', $image, 'public');

        $url = Storage::disk('s3')->url($path);

        return $url;
    }

    public function show($menu)
    {
        $item = Menu::find($menu);

        $tag = Tag::find($item->tag_id);
        $item->tag_name = $tag->tag_name;

        if ($item) {
            return response()->json(['data' => $item], 201);
        } else {
            return response()->json(['message' => 'エラーです'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        if($request->image) {
            $url = $this->upload($request);
            $update = [
                'title' => $request->title,
                'discription' => $request->discription,
                'tag_id' => $request->tag_id,
                'price' => $request->price,
                'image' => $url
            ];
        } else {
            $update = [
                'title' => $request->title,
                'discription' => $request->discription,
                'tag_id' => $request->tag_id,
                'price' => $request->price,
            ];
        }

        $item = Menu::find($id)->update($update);


        if ($item) {
            return response()->json(['data' => $item], 201);
        } else {
            return response()->json(['message' => '変更に失敗しました'], 404);
        }
    }

    public function destroy(Request $request)
    {
        $item = Menu::where('id', $request->id)->delete();
        if ($item) {
            return response()->json(['message' => 'メニューを削除しました'], 201);
        } else {
            return response()->json(['message' => 'メニューを削除できませんでした'], 404);
        }
    }

    // public function updateImage(Request $request, $menu_id)
    // {
    //     $item = Menu::find($menu_id);
    //     ImageService::deleteImage($item->image);

    //     $url = $this->uploadImage($request);
    //     $item->image_url = $url;
    //     $item->save();

    //     return response()->json([
    //         'data' => $item
    //     ], config('const.STATUS_CODE.OK'));
    // }

    public function selectMenu(Request $request)
    {
        $items = Menu::where('tag_id', $request->id)->get();

        foreach ($items as $item) {
            $tag = Tag::where('id', $item->tag_id)->first();
            $item->tag_name = $tag->tag_name;
        }

        return response()->json(['data' => $items], 201);
    }
}
