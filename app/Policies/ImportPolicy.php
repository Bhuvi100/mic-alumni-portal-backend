<?php

namespace App\Policies;

use App\Models\Import;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ImportPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        return $user->is_admin();
    }
}