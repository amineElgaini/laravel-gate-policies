<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
        ]);

        $author = User::factory()->create([
            'name' => 'Author User',
            'email' => 'author@gmail.com',
            'role' => 'author',
        ]);

        $user = User::factory()->create([
            'name' => 'Regular User',
            'email' => 'user@gmail.com',
            'role' => 'user',
        ]);

        Post::create([
            'user_id' => $author->id,
            'title' => 'First Post by Author',
            'content' => "This is a post created by the author user.\nOnly the author and admin should be able to manage this.",
        ]);

        Post::create([
            'user_id' => $admin->id,
            'title' => 'Admin Notice',
            'content' => "This is an administrative notice.\nOnly the admin can edit this.",
        ]);
    }
}
