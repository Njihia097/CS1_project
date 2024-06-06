<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Jetstream;
use App\Notifications\WelcomeEditorNotification;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Illuminate\Support\Str;
// use Laravel\Fortify\Rules\Password;
use App\Actions\Fortify\PasswordValidationRules;

class CreateNewEditor
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered editor.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:10', 'unique:users', 'safaricom_phone'],
            // 'password' => $this->passwordRules(),
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'phone' => $input['phone'],
            'password' => Hash::make(Str::random(8)), // Set a temporay password
        ]);

        $user->assignRole('editor'); // Assign editor role

        // Send welcome email with verification link
        $user->notify(new WelcomeEditorNotification());

        return $user;
    }
}
