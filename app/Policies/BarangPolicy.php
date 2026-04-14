<?php

namespace App\Policies;

use App\Models\Barang;
use App\Models\User;
use App\Policies\Concerns\HandlesLevelAuthorization;

class BarangPolicy
{
    use HandlesLevelAuthorization;

    public function viewAny(?User $user): bool
    {
        return $this->canViewMasterData($user);
    }

    public function view(?User $user, Barang $barang): bool
    {
        return $this->canViewMasterData($user);
    }

    public function create(?User $user): bool
    {
        return $this->canManageMasterData($user);
    }

    public function update(?User $user, Barang $barang): bool
    {
        return $this->canManageMasterData($user);
    }

    public function delete(?User $user, Barang $barang): bool
    {
        return $this->canManageMasterData($user);
    }

    public function deleteAny(?User $user): bool
    {
        return $this->canManageMasterData($user);
    }
}
