<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
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
            'role_name' => 'admin'
        ];
        $item = new Role;
        $item->fill($param)->save();

        $param = [
            'id' => 2,
            'role_name' => 'member'
        ];
        $item = new Role;
        $item->fill($param)->save();

        $param = [
            'id' => 3,
            'role_name' => 'user'
        ];
        $item = new Role;
        $item->fill($param)->save();
    }
}
