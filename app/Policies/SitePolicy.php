<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SitePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @param $user
     * @param $ability
     * @return bool
     * The ability is the action the user is attempting to reach.
     * This before method is going to return true in the case of when we want the user to access the ability,
     * false to deny access and null to let it fall through to the corresponding ability method in our other policies
     * In this case, true for user as a super user
     */
    public function before($user, $ability)
    {
        if (is_null($user->team_id)) {
            return true;
        }
    }
}
