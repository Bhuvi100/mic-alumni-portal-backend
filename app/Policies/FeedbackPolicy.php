<?php

namespace App\Policies;

use App\Models\Feedback;
use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FeedbackPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @return bool|void
     */
    public function before(User $user)
    {
        if ($user->is_admin()) {
            return true;
        }
    }

    public function view(User $user, Project $project, ?User $model): bool
    {
        return $project->is_permitted($model->id ? $model : $user);
    }

    public function update(User $user, Project $project): bool
    {
        return $project->is_permitted($user);
    }
}