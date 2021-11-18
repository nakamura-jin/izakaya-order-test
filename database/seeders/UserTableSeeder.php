<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
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
            'name' => 'admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
            'role_id' => 1
        ];
        $item = new User;
        $item->fill($param)->save();
    }
}
