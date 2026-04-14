<?php

namespace App\Policies\Concerns;

use App\Models\User;

trait HandlesLevelAuthorization
{
    protected function isAdmin(?User $user): bool
    {
        return $user?->isAdministrator() ?? false;
    }

    protected function isManager(?User $user): bool
    {
        return $user?->isManager() ?? false;
    }

    protected function isStaff(?User $user): bool
    {
        return $user?->isStaff() ?? false;
    }

    protected function canViewMasterData(?User $user): bool
    {
        return $this->isAdmin($user) || $this->isManager($user);
    }

    protected function canManageMasterData(?User $user): bool
    {
        return $this->isAdmin($user);
    }

    protected function canViewPenjualan(?User $user): bool
    {
        return $this->isAdmin($user) || $this->isManager($user) || $this->isStaff($user);
    }

    protected function canManagePenjualan(?User $user): bool
    {
        return $this->isAdmin($user) || $this->isStaff($user);
    }

    protected function canViewPenjualanDetail(?User $user): bool
    {
        return $this->canViewPenjualan($user);
    }
}
