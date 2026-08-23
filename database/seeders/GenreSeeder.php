<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Genre;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        $genres = [
            'Romance',
            'Fantasy',
            'Mystery',
            'Thriller',
            'Horror',
            'Drama',
            'Action',
            'Adventure',
            'Teen Fiction',
            'Slice of Life',
            'Historical',
            'Science Fiction',
            'Poetry',
            'Non-Fiction',
            'Dark Romance',
            'Harem',
        ];

        foreach ($genres as $genre) {
            Genre::firstOrCreate(
                ['slug' => Str::slug($genre)],
                ['name' => $genre]
            );
        }
    }
}