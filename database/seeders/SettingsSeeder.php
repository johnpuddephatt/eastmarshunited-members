<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            'initial_credits' => '0',
        ];

        foreach($settings as $name => $value){
            \App\Models\Setting::create([
                'name' => $name,
                'value' => $value
            ]);
        }
    }
}
