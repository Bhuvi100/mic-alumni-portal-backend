<?php

/**
 * @param \Illuminate\Database\Eloquent\Model $base
 * @param \App\Models\User|null $user
 * @param callable|null $condition
 * @return void
 */
function authorize_action(\Illuminate\Database\Eloquent\Model $base,
                          \App\Models\User $user = null,
                          callable $condition = null)
{
    if (auth()->user()->is_admin()) {
        $result = true;
    } elseif (is_callable($condition)) {
        $result = (bool) $condition($base, $user);
    } else {
        $user = is_null($user?->id) ? auth()->user() : $user;

        $result = $base->is_permitted($user);
    }

    if (!$result) {
        abort(403);
    }
}