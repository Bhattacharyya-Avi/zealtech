<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class categoyseeder extends Seeder
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
                'name' => 'cat1',
                'slug' => Str::slug('cat1')
            ],

            [
                'name' => 'cat2',
                'slug' => Str::slug('cat2')
            ],
        ];
        foreach ($data as $key => $value) {
            Category::create($value);
        }
    }
}
