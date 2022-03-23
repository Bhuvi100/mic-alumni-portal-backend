<?php

namespace Database\Factories;

use App\Models\Initiative;
use Illuminate\Database\Eloquent\Factories\Factory;

class InitiativeFactory extends Factory
{
    protected $model = Initiative::class;

    public function definition(): array
    {
        return [
            'hackathon' => \Arr::random(['Smart India Hackathon', 'Toycathon', 'ASEAN']),
            'edition' => \Arr::random(['2017', '2018', '2019'])
        ];
    }
}
