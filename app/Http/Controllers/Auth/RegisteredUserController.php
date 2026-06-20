<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.home.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required','min:6','max:8', 'confirmed'],
        ],[
            'name.required' => 'ဖြည့်စွက်ရန် လိုအပ်သည်။',
            'email.required' => 'ဖြည့်စွက်ရန် လိုအပ်သည်။',
            'password.required' => 'ဖြည့်စွက်ရန် လိုအပ်သည်။',
            'password.confirmed' => 'မိမိရိုက်ထည့်ခဲ့တဲ့ စကားဝှက်နဲ့ အတည်ပြုစကားဝှက် မကိုက်သေးပါ',
            'password.min' => 'စကားဝှက်ကွက်မှာ အနည်းဆုံး စာလုံး ၆ လုံး ဖြစ်ဖို့ လိုပါတယ်။',
            'password.max' => 'စကားဝှက်ကွက်မှာ အက္ခရာ ၈ လုံးထက် မပိုရပါ။'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);
        return to_route('userHome');

        // return redirect(route('dashboard', absolute: false));
    }
}
