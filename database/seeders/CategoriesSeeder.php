<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Admin' => '',
            'Advice and guidance' => '',
            'Arts and crafts' => '',
            'Audio, photo and video' => '',
            'Business' => '',
            'Cooking' => '',
            'Computers' => '',
            'DIY' => '',
            'Driving' => '',
            'Health and Beauty' => '',
            'Gardening' => '',
            'Tutoring' => '',
            'Pet care' => '',
            'Social media' => '',
            'Websites' => '',
        ];

        foreach($categories as $name => $description){
            \App\Models\Category::create([
                'name' => $name,
                'description' => $description
            ]);
        }
    }
}
