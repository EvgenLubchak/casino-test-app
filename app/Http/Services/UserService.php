<?php

namespace App\Http\Services;

use App\Models\User;

class UserService
{
    /**
     * Create a new user record in the database.
     *
     * @param string $name The name of the user.
     * @param string $phone The phone number of the user.
     * @return \Illuminate\Database\Eloquent\Model The created user instance.
     */
    public function create($name, $phone) {
        return User::create([
            'name' => $name,
            'phone' => $phone,
        ]);
    }
}
