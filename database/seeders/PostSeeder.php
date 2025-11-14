<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        // Create a test user if none exists
        $user = User::firstOrCreate(
            ['email' => 'demo@techforum.com'],
            [
                'name' => 'Demo User',
                'password' => bcrypt('password')
            ]
        );

        // Sample posts
        $posts = [
            [
                'title' => 'What are the best practices for Laravel in 2024?',
                'content' => 'I\'ve been working with Laravel for a while now, and I\'m curious about what the community considers best practices. What patterns do you use for large applications?',
                'category' => 'programming',
            ],
            [
                'title' => 'The Future of AI: GPT-5 and Beyond',
                'content' => 'With the rapid advancement in AI technology, what do you think the next generation of language models will bring? How will they impact software development?',
                'category' => 'ai',
            ],
            [
                'title' => 'AMD vs Intel: Which CPU should I choose in 2024?',
                'content' => 'Building a new workstation for development. Should I go with AMD Ryzen or Intel Core? What\'s your experience with both for compilation times?',
                'category' => 'hardware',
            ],
            [
                'title' => 'Securing Your Web Application: Essential Tips',
                'content' => 'Security breaches are becoming more common. What are the essential security practices you implement in your web applications? Let\'s share knowledge!',
                'category' => 'security',
            ],
            [
                'title' => 'Tailwind CSS vs Bootstrap: The Debate Continues',
                'content' => 'I\'ve been using Bootstrap for years, but everyone is talking about Tailwind. Is it worth switching? What are the real advantages?',
                'category' => 'web',
            ],
        ];

        foreach ($posts as $postData) {
            Post::create([
                'user_id' => $user->id,
                'title' => $postData['title'],
                'content' => $postData['content'],
                'category' => $postData['category'],
                'vote_count' => rand(5, 50),
                'comment_count' => rand(0, 15),
            ]);
        }
    }
}