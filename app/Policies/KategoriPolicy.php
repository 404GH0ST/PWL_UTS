<?php

namespace App\Policies;

use App\Models\Kategori;
use App\Models\User;
use App\Policies\Concerns\HandlesLevelAuthorization;

class KategoriPolicy
{
    use HandlesLevelAuthorization;

    public function viewAny(?User $user): bool
    {
        return $this->canViewMasterData($user);
    }

    public function view(?User $user, Kategori $kategori): bool
    {
        return $this->canViewMasterData($user);
    }

    public function create(?User $user): bool
    {
        return $this->canManageMasterData($user);
    }

    public function update(?User $user, Kategori $kategori): bool
    {
        return $this->canManageMasterData($user);
    }

    public function delete(?User $user, Kategori $kategori): bool
    {
        return $this->canManageMasterData($user);
    }

    public function deleteAny(?User $user): bool
    {
        return $this->canManageMasterData($user);
    }
}
