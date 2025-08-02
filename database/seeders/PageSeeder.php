<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Page::create([
            'title' => 'About Us',
            'slug' => 'about-us',
            'content' => 'Welcome to our store! Write your about us content here.'
        ]);
    }
}
