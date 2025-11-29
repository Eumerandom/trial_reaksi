<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\ShareholderEntity;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShareholderEntityPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ShareholderEntity');
    }

    public function view(AuthUser $authUser, ShareholderEntity $shareholderEntity): bool
    {
        return $authUser->can('View:ShareholderEntity');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ShareholderEntity');
    }

    public function update(AuthUser $authUser, ShareholderEntity $shareholderEntity): bool
    {
        return $authUser->can('Update:ShareholderEntity');
    }

    public function delete(AuthUser $authUser, ShareholderEntity $shareholderEntity): bool
    {
        return $authUser->can('Delete:ShareholderEntity');
    }

    public function restore(AuthUser $authUser, ShareholderEntity $shareholderEntity): bool
    {
        return $authUser->can('Restore:ShareholderEntity');
    }

    public function forceDelete(AuthUser $authUser, ShareholderEntity $shareholderEntity): bool
    {
        return $authUser->can('ForceDelete:ShareholderEntity');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ShareholderEntity');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ShareholderEntity');
    }

    public function replicate(AuthUser $authUser, ShareholderEntity $shareholderEntity): bool
    {
        return $authUser->can('Replicate:ShareholderEntity');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:ShareholderEntity');
    }

}