<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectUserBasedOnRole(Auth::user());
        }
        return view('auth.login');
    }

    /**
     * Handle authentication attempt.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $throttleKey = Str::transliterate(Str::lower($request->input('email')) . '|' . $request->ip());

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withErrors([
                'email' => "Trop de tentatives de connexion. Veuillez réessayer dans {$seconds} secondes.",
            ])->withInput($request->only('email'));
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Check if user is active
            $user = Auth::user();
            if ($user->actif !== 'oui') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Votre compte a été désactivé. Veuillez contacter l\'administration.',
                ])->withInput($request->only('email'));
            }

            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();

            return $this->redirectUserBasedOnRole($user);
        }

        RateLimiter::hit($throttleKey, 60);

        return back()->withErrors([
            'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
        ])->withInput($request->only('email'));
    }

    /**
     * Show the registration form.
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectUserBasedOnRole(Auth::user());
        }
        return view('auth.register');
    }

    /**
     * Handle registration request.
     */
    public function register(Request $request)
    {
        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'sexe' => ['required', 'string', 'in:M,F'],
            'date_naissance' => ['required', 'date', 'before:today'],
            'telephone' => ['required', 'string', 'max:20'],
            'adresse' => ['required', 'string', 'max:255'],
        ], [
            'email.unique' => 'Cette adresse email est déjà enregistrée.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
        ]);

        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'sexe' => $request->sexe,
            'date_naissance' => $request->date_naissance,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
            'profil_id' => 3, // id 3 is 'apprenant'
        ]);

        return redirect()->route('login')->with('success', 'Votre compte a été créé avec succès ! Vous pouvez maintenant vous connecter.');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Vous avez été déconnecté.');
    }

    /**
     * Redirect users to their specific dashboard based on profile name.
     */
    protected function redirectUserBasedOnRole($user)
    {
        $profileName = $user->profil ? strtolower(trim($user->profil->nom)) : null;

        if ($profileName === 'administrateur' || $user->profil_id == 1) {
            return redirect()->route('dashboard.admin');
        } elseif ($profileName === 'professeur' || $user->profil_id == 2) {
            return redirect()->route('dashboard.professeur');
        } elseif ($profileName === 'apprenant' || $user->profil_id == 3) {
            return redirect()->route('dashboard.apprenant');
        }

        return redirect()->route('home');
    }

    // ---------------------------------------------------------------------
    // Password Reset Flow
    // ---------------------------------------------------------------------

    /**
     * Show form to request a password reset link.
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle sending of the password reset link.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    /**
     * Show the password reset form for a given token.
     */
    public function showResetForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    /**
     * Handle resetting the password.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, $password) {
                $user->password = Hash::make($password);
                $user->setRememberToken(Str::random(60));
                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
