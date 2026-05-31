<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function ensureCanDelete(): void
    {
        if (! auth()->user()?->canDelete()) {
            abort(403, 'You do not have permission to delete.');
        }
    }

    protected function ensureCanManageUsers(): void
    {
        if (! auth()->user()?->canManageUsers()) {
            abort(403, 'You do not have permission to manage users.');
        }
    }

    protected function ensureCanEditProfile(): void
    {
        if (! auth()->user()?->canEditProfile()) {
            abort(403, 'You do not have permission to change your profile.');
        }
    }

    protected function ensureCanEditUser(User $target): void
    {
        if (! auth()->user()?->canEditUser($target)) {
            abort(403, 'You do not have permission to edit this user.');
        }
    }

    protected function ensureCanDeleteUser(User $target): void
    {
        if (! auth()->user()?->canDeleteUser($target)) {
            abort(403, 'You do not have permission to delete this user.');
        }
    }

    protected function ensureCanCreateCustomers(): void
    {
        if (! auth()->user()?->canCreateCustomers()) {
            abort(403, 'You do not have permission to add customers.');
        }
    }

    protected function ensureCanEditCustomers(): void
    {
        if (! auth()->user()?->canEditCustomers()) {
            abort(403, 'You do not have permission to edit customers.');
        }
    }
}
