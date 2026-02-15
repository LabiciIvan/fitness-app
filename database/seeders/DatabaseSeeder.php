<?php

namespace Database\Seeders;

use App\Models\Categories;
use App\Models\Profile;
use App\Models\Program;
use App\Models\Reviews;
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
            ->count(3)
            ->create();

        $testAccount = User::factory(3)
            ->state(new Sequence(
                ['email' => 'trainer@mail.com'],
                ['email' => 'customer@mail.com'],
                ['email' => 'admin@mail.com'],
            ))
            ->has(Profile::factory()->count(1))
            ->create();

        $typesForTestAccounts = [
            'trainer@mail.com'   => config('tables.types.trainerKey'),
            'customer@mail.com'  => config('tables.types.customerKey'),
            'admin@mail.com'     => config('tables.types.adminKey'),
        ];

        $testAccount->each(function ($testUser) use ($typesForTestAccounts) {
            $accountType = Type::where('title', $typesForTestAccounts[$testUser->email])->pluck('id');

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

        $trainers = User::whereHas('types', function ($query) {
            $query->where('title', config('tables.types.trainerKey'));
        })->with('types')->get();

        $trainers->each(function ($trainer) use ($users) {
            $trainer->programs->each(function ($program) use ($users) {
                $enrolledUsers = $users->random(3);

                $program->enrolled()->attach($enrolledUsers->pluck('id'));

                $enrolledUsers->each(function ($user) use ($program) {
                    Reviews::factory()->create([
                        'program_id' => $program->id,
                        'user_id'    => $user->id,
                    ]);
                });
            });
        });
    }
}
