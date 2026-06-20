<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Socialite;
// use Illuminate\Http\Request;

class SocialLoginController extends Controller
{
    //redirect
    public function socialredirect(){
        return Socialite::driver('google')->redirect();
    }

    //callback
    public function callback(){
        $googleUser = Socialite::driver('google')->user();

    $user = User::updateOrCreate([
        'provider_id' => $googleUser->id,
    ], [
        'name' => $googleUser->name,
        'email' => $googleUser->email,
        'provider_token' => $googleUser->token,
        'provider' => 'google',
        'role' => 'user'
    ]);

    Auth::login($user);

    return to_route('userHome');
    }


}
