<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\RegisterRequest;
use App\Mail\PasswordCode;
use App\Models\Formation;
use App\Models\User;
use \App\Http\Requests\ForgotPasswordRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

use function Laravel\Prompts\password;

class AuthController extends Controller
{
    /**
     * retourne la page de connection.
     * @return \Illuminate\View\View
     */
    public function loggin(){
        return view('auth.loggin');
    }


    /**
     * verifie la validation et l'authentification de l'utilisateur
     * authentifie l'utilisateur
     * redirige l'utilisateur.
     * @param  \App\Http\Requests\AuthRequest  $request
     * @return \Illuminate\Http\RedirectResponse
    */
    public function logUser(AuthRequest $request){
    $credentials = $request->only('email', 'password');
    if (auth()->attempt($credentials)) {
        return redirect()->route('acceuil');
    }
    return redirect()->route('loggin')->withErrors(['error' => 'Les identifiants ne correspondent pas']);
    }


    /**
     * retourne  la page de creation de compte.
     * @return \Illuminate\View\View
     */
    public function create(){
        $formations = Formation::all();
        return view('auth.register', ['formations'=>$formations]);
    }


    /**
     * enregistre un nouvel utilisateur
     * authentifie le nouvel utilisateur
     * redirige l'utilisateur.
     * @param  \App\Http\Requests\RegisterRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RegisterRequest $request){
        $user = User::create([
            'name' => $request->input('name'),
            'first_name' => $request->input('first_name'),
            'formation_id' => $request->input('formation_id'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        Auth::login($user);
        return redirect()->route('acceuil');
    }


    /**
     * deconnecte l'utilisateur.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(){
        auth()->logout();
        return redirect()->route('acceuil');
    }


    /**
     * retourne la vue vers le formulaire de mot de passe oublié.
     * @return \Illuminate\View\View
     */
    public function viewForgotPassword(){
        return view('auth.forgotPassword');
    }


    /**
     * renvoie un formulaire pour reinitialiser le mot de passe
     * @return \Illuminate\View\View
     */
    public function viewResetPassword(User $user){
        return view('auth.resetPassword', ['user' => $user]);
    }


    /**
     * retourne une vue vers le formulaire de code
     * @return \Illuminate\View\View
     */
    public function viewforgotPasswordCode(String $email){
        return view('auth.forgotPasswordCode', ['email' => $email]);
    }


    /**
     * creer un code secret.
     * l'envoie par mail
     * redirige l'utisateur
     * @param  \App\Http\Requests\ForgotPasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forgotPasswordGetCode(ForgotPasswordRequest $request){
        $code = Str::random(8);
        Cache::put('reset_code_' . $request->input('email'), $code, now()->addMinutes(5));
        Mail::to($request->input('email'))->send(new PasswordCode($code));
        return redirect()->route('viewPasswordForgotCode', ['email' => $request->input('email')]);
    }


    /**
     * recupere et un code et le valide.
     * @param  \App\Http\Requests\ForgotPasswordRequest $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function authenticateCode(ForgotPasswordRequest $request)
    {
        $storedCode = Cache::get('reset_code_' . $request->input('email'));

        if ($storedCode && $request->input('code') === $storedCode) {
            return $this->resetPasswordForm($request->input('email'));
        } else {
            return view('auth.forgotPasswordCode', ['email' => $request->input('email'), 'error' => 'Code incorrect ou expiré. Veuillez réessayer.']);
        }
    }


    /**
     * Recherche l'utilisateur en base de données à partir de l'adresse e-mail et renvoie le formulaire de réinitialisation du mot de passe.
     *
     * @param  string $email
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetPasswordForm(String $email){
        $user = User::where('email', $email)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'Utilisateur non trouvé.');
        }
        return redirect()->route('viewResetPassword', ['user' => $user]);
    }


    /**
     * Hash le nouveau mot de passe, enregistre la modification en base de données,
     * authentifie l'utilisateur et le redirige vers la page d'accueil.
     *
     * @param  \App\Models\User $user
     * @param  \App\Http\Requests\PasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function StoreResetPassword(User $user, PasswordRequest $request){
        $user->password = Hash::make($request->input('password'));
        $user->update();

        AUTH::login($user);
        return redirect()->route('acceuil');
    }
}
