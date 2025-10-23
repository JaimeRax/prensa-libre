<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\News;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $cats = collect(['Nacionales','Deportes','Economía','Internacional','Tecnología'])
            ->map(fn ($n) => Category::firstOrCreate(
                ['slug' => Str::slug($n)],
                ['name' => $n]
            ));

        News::factory()->count(8)->create()->each(function ($n) use ($cats) {
            $n->categories()->attach($cats->random(rand(1, 2))->pluck('id'));
        });
    }
}
