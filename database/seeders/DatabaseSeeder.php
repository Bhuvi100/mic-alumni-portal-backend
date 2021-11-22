<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
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
        \App\Models\User::factory(6)->create();
        Project::factory(1)->create();

        $project = Project::all()->first();

        foreach (User::all() as $user) {
            $project->users()->attach($user);
        }
    }
}
