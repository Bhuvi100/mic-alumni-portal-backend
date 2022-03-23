<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

class BasePolicy
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

    public function index(User $user)
    {
        return false;
    }

    public function show(User $user, Project $model)
    {
        return $model->is_permitted($user);
    }

    public function update(User $user, Project $model)
    {
        if ($model->id) {
            return $model->is_permitted($user);
        }

        return true;
    }
}