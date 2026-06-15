<?php

namespace App\Policies;

use App\Models\Submission;
use App\Models\User;

class SubmissionPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Submission $submission): bool
    {
        // Admin bisa lihat semua, user hanya miliknya
        return $user->isAdmin() || $submission->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return ! $user->isAdmin();
    }

    public function update(User $user, Submission $submission): bool
    {
        if ($user->isAdmin()) return true;

        return $submission->user_id === $user->id
            && $submission->status === 'pending';
    }

    public function delete(User $user, Submission $submission): bool
    {
        if ($user->isAdmin()) return true;

        return $submission->user_id === $user->id
            && $submission->status === 'pending';
    }

    public function grade(User $user): bool
    {
        return $user->isAdmin();
    }

    public function restore(User $user, Submission $submission): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, Submission $submission): bool
    {
        return $user->isAdmin();
    }
}