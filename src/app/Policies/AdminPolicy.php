<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\QueryException;

class AdminPolicy
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

    public function access(User $user) {
        try {
            $user_role = Role::where('id', '=', $user['id_role'])->first();
            return $user_role['nama'] === 'admin';
        } catch (QueryException $e) {
            dd($e);
        }
    }
}
