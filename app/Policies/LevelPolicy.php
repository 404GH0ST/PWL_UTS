<?php

namespace App\Policies;

use App\Models\Level;
use App\Models\User;
use App\Policies\Concerns\HandlesLevelAuthorization;

class LevelPolicy
{
    use HandlesLevelAuthorization;

    public function viewAny(?User $user): bool
    {
        return $this->canViewMasterData($user);
    }

    public function view(?User $user, Level $level): bool
    {
        return $this->canViewMasterData($user);
    }

    public function create(?User $user): bool
    {
        return $this->canManageMasterData($user);
    }

    public function update(?User $user, Level $level): bool
    {
        return $this->canManageMasterData($user);
    }

    public function delete(?User $user, Level $level): bool
    {
        return $this->canManageMasterData($user);
    }

    public function deleteAny(?User $user): bool
    {
        return $this->canManageMasterData($user);
    }
}
