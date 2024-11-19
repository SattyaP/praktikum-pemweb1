<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Blog::factory()
            ->count(10)
            ->create([
                'title' => 'Sample Blog Title',
                'content' => 'This is a sample blog content.'
            ]);
    }
}
