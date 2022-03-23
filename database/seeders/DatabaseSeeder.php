<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Initiative;
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
        User::factory(1, ['email' => 'bhuvi@kajuzi.co.za', 'name' => 'Bhuvi', 'role' => 'admin'])->create();
        \App\Models\User::factory(5)->create();
        Initiative::factory(1)->create();
        Project::factory(1)->create();

        Announcement::create(['user_id' => 1, 'title' => 'Announcement 1']);

        $project = Project::first();

        foreach (User::all() as $user) {
            $project->users()->attach($user);
        }
    }
}
