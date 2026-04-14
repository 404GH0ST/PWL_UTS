<?php

namespace App\Policies;

use App\Models\User;
use App\Policies\Concerns\HandlesLevelAuthorization;

class UserPolicy
{
    use HandlesLevelAuthorization;

    public function viewAny(?User $user): bool
    {
        return $this->canViewMasterData($user);
    }

    public function view(?User $user, User $model): bool
    {
        return $this->canViewMasterData($user);
    }

    public function create(?User $user): bool
    {
        return $this->canManageMasterData($user);
    }

    public function update(?User $user, User $model): bool
    {
        return $this->canManageMasterData($user);
    }

    public function delete(?User $user, User $model): bool
    {
        return $this->canManageMasterData($user);
    }

    public function deleteAny(?User $user): bool
    {
        return $this->canManageMasterData($user);
    }
}
