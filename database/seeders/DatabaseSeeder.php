<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\Models\User::factory(30)->create();
        $company = \App\Models\Company::factory(30)->create();
        $task = \App\Models\Task::factory(50)->create();
    }
}
