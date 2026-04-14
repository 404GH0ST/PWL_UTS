<?php

namespace App\Policies;

use App\Models\Stok;
use App\Models\User;
use App\Policies\Concerns\HandlesLevelAuthorization;

class StokPolicy
{
    use HandlesLevelAuthorization;

    public function viewAny(?User $user): bool
    {
        return $this->canViewMasterData($user);
    }

    public function view(?User $user, Stok $stok): bool
    {
        return $this->canViewMasterData($user);
    }

    public function create(?User $user): bool
    {
        return $this->canManageMasterData($user);
    }

    public function update(?User $user, Stok $stok): bool
    {
        return $this->canManageMasterData($user);
    }

    public function delete(?User $user, Stok $stok): bool
    {
        return $this->canManageMasterData($user);
    }

    public function deleteAny(?User $user): bool
    {
        return $this->canManageMasterData($user);
    }
}
