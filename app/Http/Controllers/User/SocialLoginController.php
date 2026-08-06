<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
// မှားယွင်းနေတဲ့ namespace ကို ပြင်ဆင်ထားပါတယ် (Laravel\Socialite\Socialite မဟုတ်ဘဲ Facade ကို သုံးရပါမယ်)
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    // redirect
    public function socialredirect()
    {
        // နိုင်ငံတကာ standard အတိုင်း state ပြဿနာ ကင်းဝေးအောင် ပထမဆုံးအဆင့်မှာပါ stateless() ခေါ်ထားလို့ရပါတယ်
        return Socialite::driver('google')->stateless()->redirect();
    }

    // callback
    public function callback()
    {
        // InvalidStateException ကို ဖြေရှင်းရန် ->stateless() ကို ထည့်သွင်းထားပါတယ်
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::updateOrCreate([
            'provider_id' => $googleUser->id,
        ], [
            'name'           => $googleUser->name,
            'email'          => $googleUser->email,
            'provider_token' => $googleUser->token,
            'provider'       => 'google',
            'role'           => 'user'
        ]);

        Auth::login($user);

        return to_route('userHome');
    }
}
