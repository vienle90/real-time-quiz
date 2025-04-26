<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Programming',
            'Mathematics',
            'Science',
            'History',
            'Geography',
            'Literature',
            'Music',
            'Sports',
            'Movies',
            'General Knowledge',
        ];

        foreach ($categories as $categoryName) {
            Category::create(['name' => $categoryName]);
        }
    }
}