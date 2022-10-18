<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsertableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'user1',
                'email' => 'user1@gmail.com',
                'password' => bcrypt('12345')
            ],
        ];
        foreach ($data as $key => $value) {
            User::create($value);
        }
    }
}
