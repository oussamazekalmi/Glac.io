<?php

namespace App\Http\Controllers;

use App\Mail\PasswordRecovering;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function forget_password() {
        return view('mail.forget_password');
    }

    public function recover_password(Request $request)
    {
        $request->validate(
            [
                'email' =>'required|email|exists:users,email',
            ],
            [
                'email.required' => 'Veuillez renseigner votre adresse email',
                'email.email' => 'Veuillez renseigner une adresse email valide',
                'email.exists' => 'L\'adresse mail saisi est invalide.',
            ]
        );

        $user = User::where('email', $request->input('email'))->firstOrFail();

        $created_at_year = date_format($user->created_at, 'Y-m-d');
        $created_at = str_replace('-', '', $created_at_year);
        $password = substr($user->password, 8, 12);

        Mail::to($user->email)->send(new PasswordRecovering(
            $user->id,
            $password,
            $created_at
        ));

        return redirect()->route('login')->with('success', 'Veuillez vérifier votre e-mail afin de réinitialiser votre mot de passe.');
    }

    public function verify_password($hash) {
        [$id, $password, $created_at] = explode('$$', base64_decode((string)$hash));
        $hashedChain = $id.''.$password.''.$created_at;
        return view('mail.verify_password', compact('hashedChain', 'id'));
    }


    public function confirm_password(Request $request)
    {
        $request->validate([
            'randomType' => 'required|same:hashedChain',
            'password' => 'required|min:8|max:50',
            'confirm_password' => 'required|same:password',
        ],
        [
            'password.min' => 'Le mot de passe doit avoir au moins 8 caractères.',
            'password.max' => 'Le mot de passe ne doit pas dépasser 50 caractères.',
            'password.required' => 'Le mot de passe est requis.',
            'confirm_password.same' => 'Les mots de passe doivent être les mêmes.',
            'randomType.same' => 'La chaîne aléatoire est invalide.',
        ]);

        $user = User::where('id', $request->input('id'))->firstOrFail();

        $user->update([
            'password' => Hash::make($request->input('password'))
        ]);

        return redirect()->route('login')->with('success', 'Mot de passe réinitialisé avec succès.');
    }
}
