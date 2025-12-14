<?php

namespace Database\Seeders;

use App\Models\Categories;
use App\Models\Profile;
use App\Models\Program;
use App\Models\Tag;
use App\Models\Type;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            TagSeeder::class,
            CategoriesSeeder::class,
        ]);

        $tags = Tag::all();
        $categories = Categories::all();
        
        $types = Type::factory()
            ->count(2)
            ->create();

        $testAccount = User::factory(2)
            ->state(new Sequence(
                ['email' => 'trainer@mail.com'],
                ['email' => 'customer@mail.com']
            ))
            ->has(Profile::factory()->count(1))
            ->create();

        $testAccount->each(function ($testUser) {
            $accountType = Type::where('title', $testUser->email === 'trainer@mail.com' ? 'trainer' : 'customer')->pluck('id');

            $testUser->types()->attach($accountType);
        });

        $users = User::factory(4)
            ->has(
                Profile::factory()
                    ->state(new Sequence(
                        ['complete' => true],
                        ['complete' => false],
                    ))
                    ->count(1)
                )
            ->create();

        $users->each(function ($user) use ($types) {
            $user->types()->attach($types->random()->id);
        });

        $trainerType = Type::where('title', config('tables.types.trainerKey'))->first();
        $customerType = Type::where('title', config('tables.types.customerKey'))->first();

        // Create trainers and attach available programs.
        User::factory(3)
            ->has(Profile::factory()->count(1))
            ->has(Program::factory()->count(10))
            ->create()
            ->each(function ($user) use ($trainerType) {
                $user->types()->attach($trainerType->id);
            });

        $programs = Program::all();

        User::factory(3)
            ->has(Profile::factory()->count(1))
            ->create()
            ->each(function ($user) use ($customerType, $programs) {
                $user->types()->attach($customerType->id);
                $user->enrollments()->attach($programs->random()->id);
            });

        $programs->each(function ($program) use ($tags, $categories){
            $program->tags()->attach($tags->random()->id);
            $program->categories()->attach($categories->random()->id);
        });
    }
}
