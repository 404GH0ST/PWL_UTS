<?php

namespace App\Policies;

use App\Models\Supplier;
use App\Models\User;
use App\Policies\Concerns\HandlesLevelAuthorization;

class SupplierPolicy
{
    use HandlesLevelAuthorization;

    public function viewAny(?User $user): bool
    {
        return $this->canViewMasterData($user);
    }

    public function view(?User $user, Supplier $supplier): bool
    {
        return $this->canViewMasterData($user);
    }

    public function create(?User $user): bool
    {
        return $this->canManageMasterData($user);
    }

    public function update(?User $user, Supplier $supplier): bool
    {
        return $this->canManageMasterData($user);
    }

    public function delete(?User $user, Supplier $supplier): bool
    {
        return $this->canManageMasterData($user);
    }

    public function deleteAny(?User $user): bool
    {
        return $this->canManageMasterData($user);
    }
}
