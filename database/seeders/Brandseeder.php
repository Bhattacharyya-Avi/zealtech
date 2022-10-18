<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class Brandseeder extends Seeder
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
                'name' => 'brand1',
                'slug' => Str::slug('brand1')
            ],

            [
                'name' => 'brand2',
                'slug' => Str::slug('brand2')
            ],
        ];
        foreach ($data as $key => $value) {
            Brand::create($value);
        }
    }
}
