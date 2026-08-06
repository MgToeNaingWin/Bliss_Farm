<?php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        // dd(Auth::check());
        return view('auth.home.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        // ၁။ မြန်မာစာ Validation စစ်ဆေးခြင်း
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'အီးမေးလ် ဖြည့်စွက်ရန် လိုအပ်သည်။',
            'email.email' => 'မှန်ကန်သော အီးမေးလ် ပုံစံ ဖြစ်ရပါမည်။',
            'password.required' => 'စကားဝှက် ဖြည့်စွက်ရန် လိုအပ်သည်။',
        ]);

        // ၂။ Login အချက်အလက် စစ်ဆေးခြင်း (အီးမေးလ် သို့မဟုတ် စကားဝှက် မှားရင် Error ထုတ်ပေးမည်)
        if (! Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'ထည့်သွင်းထားသော အီးမေးလ် (သို့မဟုတ်) စကားဝှက် မှားယွင်းနေပါသည်။',
            ]);
        }

        // အကိုရေးထားတဲ့ မူလ logic အတိုင်း လုံးဝမပြင်ဘဲ ထားရှိထားပါတယ်
        $request->session()->regenerate();

        if($request->user()->role == 'admin'||$request->user()->role == 'superadmin'){
            return to_route('adminHome');
        }

        if($request->user()->role == 'user'){
            return to_route('userHome');
        }
        // return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
