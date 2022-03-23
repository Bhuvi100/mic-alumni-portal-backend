<?php

namespace App\Providers;

use App\Models\Announcement;
use App\Models\Feedback;
use App\Models\Import;
use App\Models\ParticipantStatus;
use App\Models\Project;
use App\Models\ProjectStatus;
use App\Models\Story;
use App\Models\User;
use App\Policies\BasePolicy;
use App\Policies\ImportPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Import::class => ImportPolicy::class,
        Feedback::class => BasePolicy::class,
        ParticipantStatus::class => BasePolicy::class,
        ProjectStatus::class => BasePolicy::class,
        Story::class => BasePolicy::class,
        User::class => BasePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
