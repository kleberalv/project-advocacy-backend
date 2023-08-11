<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserRepository
{
    public function getUserById($user)
    {
        $user = User::where('id_usuario', $user['id'])->first();
        return $user;
    }

    public function getIndex()
    {
        return User::whereNull('deleted_at')->get();
    }

    public function createUser($user)
    {
        return User::create($user);
    }

    public function updateUser($user)
    {
        $userToUpdate = User::findOrFail($user['id']);
        foreach ($user as $field => $value) {
            if (in_array($field, $userToUpdate->getFillable())) {
                $userToUpdate->$field = $value;
            }
        }
        $userToUpdate->save();
        return $userToUpdate;
    }

    public function deleteUser($user)
    {
        $user->deleted_at = now();
        $user->save();
        return $user;
    }
}
