<?php

namespace Database\Seeders;

use App\Models\EventCategory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EventCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'School Campaign',
            ],
            [
                'name' => 'Church Campaign',
            ],
            [
                'name' => 'Political Campaign',
            ],
            [
                'name' => 'Freedom Campaign',
            ],
            [
                'name' => 'Honours Campaign',
            ],
        ];

        foreach($categories as $category){
            EventCategory::create([
                'name' => $category['name'],
                'description' => "This is a " .$category['name'] ."Description",
                'is_active' => true
            ]);
        }
    }
}
