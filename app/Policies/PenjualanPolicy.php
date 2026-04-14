<?php

namespace App\Policies;

use App\Models\Penjualan;
use App\Models\User;
use App\Policies\Concerns\HandlesLevelAuthorization;

class PenjualanPolicy
{
    use HandlesLevelAuthorization;

    public function viewAny(?User $user): bool
    {
        return $this->canViewPenjualan($user);
    }

    public function view(?User $user, Penjualan $penjualan): bool
    {
        return $this->canViewPenjualan($user);
    }

    public function create(?User $user): bool
    {
        return $this->canManagePenjualan($user);
    }

    public function update(?User $user, Penjualan $penjualan): bool
    {
        return $this->canManagePenjualan($user);
    }

    public function delete(?User $user, Penjualan $penjualan): bool
    {
        return $this->canManagePenjualan($user);
    }

    public function deleteAny(?User $user): bool
    {
        return $this->isAdmin($user);
    }
}
