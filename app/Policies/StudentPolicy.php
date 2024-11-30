<?php

namespace App\Policies;

use App\Models\User;

class StudentPolicy
{
    public function view(User $user, User $student)
    {
        return $user->homeroom_class_id === $student->class_id;
    }
}
