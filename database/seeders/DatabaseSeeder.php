<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        // Users Table (id, role, name, email, email_verified_at,
        // password, remember_token, created_at, updated_at, deleted_at)

            // Fake Users
        for ($i = 0; $i < 5; $i++) {
            DB::table('users')->insert([
                'role' => 'user',
                'name' => $faker->unique()->userName,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make($faker->password),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

            // Admin
        DB::table('users')->insert([
            'role' => 'admin',
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

            // User
        DB::table('users')->insert([
            'role' => 'user',
            'name' => 'user',
            'email' => 'user@user.com',
            'password' => Hash::make('user'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Groups Table (id, group_name, group_owner, created_at, updated_at, deleted_at)
        for ($i = 0; $i < 10; $i++) {
            DB::table('groups')->insert([
                'group_name' => $faker->unique()->userName,
                'group_owner' => $faker->numberBetween(1, 7),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        // User_groups Table (id, user_id, group_id, created_at, updated_at, deleted_at)
        for ($i = 0; $i < 20; $i++) {
            DB::table('user_groups')->insert([
                'user_id' => $faker->numberBetween(1, 7),
                'group_id' => $faker->numberBetween(1, 10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        // Todos Table (id, user_id, group_id, priority, status,
        // description, created_at, updated_at, deleted_at)
        for ($i = 0; $i < 50; $i++) {
            DB::table('todos')->insert([
                'user_id' => $faker->numberBetween(1, 7),
                'group_id' => $faker->randomElement([0, 1, 2, 3, 4, 5]),
                'priority' => $faker->numberBetween(1, 5),
                'status' => $faker->randomElement(['unsolved', 'in_progress', 'solved']),
                'description' => $faker->sentence(5, false),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
