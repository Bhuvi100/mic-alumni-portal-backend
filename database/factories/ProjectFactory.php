<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        return [
            'year' => Arr::random(['2017', '2018']),
            'team_name' => $this->faker->name,
            'title' => $this->faker->title,
            'idea_id/team_id' => \Str::random(5),
            'description' => $this->faker->text,
            'leader_id' => User::all()->random(1)->first()->id,
            'ps_id' => \Str::random(5),
            'ps_code' => '#' . \Str::random(4),
            'ps_title' => $this->faker->title,
            'ps_description' => $this->faker->text,
            'type' => 'winner',
            'theme' => 'Some random theme',
            'ministry/organisation' => Arr::random(['Department of atomic energy', 'Department of biotechnology', 'UGC']),
            'college' => 'SKCET',
            'college_state' => 'TamilNadu'
        ];
    }
}
