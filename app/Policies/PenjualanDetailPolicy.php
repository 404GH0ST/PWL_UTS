<?php

namespace App\Policies;

use App\Models\PenjualanDetail;
use App\Models\User;
use App\Policies\Concerns\HandlesLevelAuthorization;

class PenjualanDetailPolicy
{
    use HandlesLevelAuthorization;

    public function viewAny(?User $user): bool
    {
        return $this->canViewPenjualanDetail($user);
    }

    public function view(?User $user, PenjualanDetail $detail): bool
    {
        return $this->canViewPenjualanDetail($user);
    }

    public function create(?User $user): bool
    {
        return false;
    }

    public function update(?User $user, PenjualanDetail $detail): bool
    {
        return false;
    }

    public function delete(?User $user, PenjualanDetail $detail): bool
    {
        return false;
    }

    public function deleteAny(?User $user): bool
    {
        return false;
    }
}
