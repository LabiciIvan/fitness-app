<?php

namespace Database\Seeders;

use App\Models\Categories;
use App\Models\Type;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Categories::factory(8)->create();
    }
}
