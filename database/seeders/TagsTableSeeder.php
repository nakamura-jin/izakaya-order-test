<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;


class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'id' => 1,
            'tag_name' => '肉料理'
        ];
        $item = new Tag;
        $item->fill($param)->save();

        $param = [
            'id' => 2,
            'tag_name' => '揚げ物'
        ];
        $item = new Tag;
        $item->fill($param)->save();

        $param = [
            'id' => 3,
            'tag_name' => '野菜料理'
        ];
        $item = new Tag;
        $item->fill($param)->save();

        $param = [
            'id' => 4,
            'tag_name' => '定番おつまみ'
        ];
        $item = new Tag;
        $item->fill($param)->save();

        $param = [
            'id' => 5,
            'tag_name' => 'ごはんもの'
        ];
        $item = new Tag;
        $item->fill($param)->save();
    }
}
