<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
public function login()
    {
        if (auth()->check()) {
            return redirect()->back();
        }

        return view("layout.login");
    }

    public function authenticate(Request $request)
    {
        $login = $request->input('login');
        $password = $request->input('password');

        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        if (Auth::attempt([$field => $login, 'password' => $password])) {

            $request->session()->regenerate(true);

            $user = auth()->user();

            if($user->role === 'admin') {
                return redirect()->route('users.index')->with('success', "Bienvunue " . $user->name. " Vous avez été connecté.");
            }

            return redirect()->route('icecubes.logs', $user->id)->with('success', "Bienvenue " . $user->name . ", vous avez été connecté.");
        }

        return back()->withErrors([
            'login' => 'Nom d\'utilisateur ou mot de passe incorrect.'
        ])->withInput();
    }

    public function logout()
    {
        session()->invalidate();
        return redirect()->route('login');
        auth()->logout();
    }
}
