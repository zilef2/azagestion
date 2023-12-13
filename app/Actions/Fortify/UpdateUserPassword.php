<?php

namespace App\Actions\Fortify;

use App\Jobs\SendEmailForPasswords;
use App\Models\User;
use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;

class UpdateUserPassword implements UpdatesUserPasswords
{
    use PasswordValidationRules;

    /**
     * Validate and update the user's password.
     *
     * @param  array<string, string>  $input
     */
    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'current_password' => ['required', 'string', 'current_password:web'],
            'password' => $this->passwordRules(),
        ], [
            'current_password.current_password' => __('The provided password does not match your current password.'),
        ])->validateWithBag('updatePassword');

        $user->forceFill([
            'password' => Hash::make($input['password']),
            'email_verified_at' => Carbon::now()
        ])->save();

        $ConsultaBase = User::Where('email_verified_at',null)
        ->whereNot('email','like','%UsuarioDesconocido%');

        $ContarListaPendiente = ($ConsultaBase->count());
        $listaModelo = $ConsultaBase->pluck('name')->toArray();

        if($ContarListaPendiente == 0){
            SendEmailForPasswords::dispatch($user,'',0)->onQueue('emails');
        } else{
            $listaPendiente = implode(', ', $listaModelo);
            SendEmailForPasswords::dispatch($user,$listaPendiente,$ContarListaPendiente)->onQueue('emails');
        }
    }
}
