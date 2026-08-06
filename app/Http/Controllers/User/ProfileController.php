<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;


class ProfileController extends Controller
{
    /**
     * Display the authenticated user's profile.
     */
    public function index()
    {
        $user = Auth::user();
        return view('admin.home.profile.home', compact('user'));
    }

    /**
     * Update the authenticated user's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // ၁။ Custom validation messages များကို မြန်မာလို သတ်မှတ်ခြင်း
        $messages = [
            'required' => ':attribute ဖြည့်စွက်ရန် လိုအပ်ပါသည်။',
            'string' => ':attribute သည် စာသား (Text) ဖြစ်ရပါမည်။',
            'max' => ':attribute သည် စာလုံးရေ အများဆုံး :max ထက် မကျော်ရပါ။',
            'email' => 'မှန်ကန်သော :attribute ကို ထည့်သွင်းပေးပါ။',
            'unique' => 'ဤ :attribute သည် အသုံးပြုပြီးသား ဖြစ်နေပါသည်။',
            'image' => ':attribute သည် ပုံဖိုင် (Image File) ဖြစ်ရပါမည်။',
            'mimes' => ':attribute သည် jpeg, png, jpg, gif အမျိုးအစားများသာ ဖြစ်ရပါမည်။',
            'profile_photo.max' => ':attribute ဖိုင်ဆိုဒ်သည် 2MB ထက် မကျော်ရပါ။',
            'regex' => 'မှန်ကန်သော မြန်မာဖုန်းနံပါတ်ပုံစံ ဖြစ်ရပါမည်။ (ဥပမာ - 09xxxxxxxxx)',
        ];

        // ၂။ ပြသမည့် နေရာများတွင် မြန်မာလို နာမည်ပြောင်းလဲရန် သတ်မှတ်ခြင်း
        $attributes = [
            'name' => 'အမည်',
            'email' => 'အီးမေးလ်လိပ်စာ',
            'phone' => 'ဖုန်းနံပါတ်',
            'region' => 'တိုင်းဒေသကြီး/ပြည်နယ်',
            'township' => 'မြို့နယ်',
            'village' => 'ကျေးရွာ/ရပ်ကွက်',
            'profile_photo' => 'ပရိုဖိုင်ဓာတ်ပုံ',
        ];

        // ၃။ Validation စစ်ဆေးခြင်း (မြန်မာဖုန်းနံပါတ် Regex သုံးထားပါသည်)
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'regex:/^(09|\+959)\d{7,9}$/'],
            'region' => ['nullable', 'string', 'max:100'],
            'township' => ['nullable', 'string', 'max:100'],
            'village' => ['nullable', 'string', 'max:100'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ], $messages, $attributes);

        // ၄။ ပရိုဖိုင်ပုံ အသစ်တင်လျှင် အဟောင်းဖျက်ပြီး အသစ်သိမ်းခြင်း
        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $validated['profile_photo'] = $path;
        }

        // ၅။ Database ထဲတွင် သိမ်းဆည်းခြင်း
        $user->update($validated);

        // SweetAlert အတွက် Flash Session အောင်မြင်ကြောင်း မက်ဆေ့ခ်ျ ပို့ခြင်း
        return redirect()->back()->with('sweet_success', 'ပရိုဖိုင်အချက်အလက်များကို အောင်မြင်စွာ ပြင်ဆင်ပြီးပါပြီ။');
    }

    /**
     * Update the authenticated user's password.
     */
    public function updatePassword(Request $request)
    {
        $messages = [
            'current_password.required' => 'လက်ရှိအသုံးပြုနေသော စကားဝှက်ကို ဖြည့်သွင်းပေးပါ။',
            'current_password.current_password' => 'လက်ရှိအသုံးပြုနေသော စကားဝှက် မှားယွင်းနေပါသည်။',
            'password.required' => 'စကားဝှက်အသစ် ထည့်သွင်းရန် လိုအပ်ပါသည်။',
            'password.string' => 'စကားဝှက်သည် စာသားပုံစံ ဖြစ်ရပါမည်။',
            'password.min' => 'စကားဝှက်အသစ်သည် အနည်းဆုံး စာလုံးရေ ၈ လုံး ရှိရပါမည်။',
            'password.confirmed' => 'စကားဝှက်အသစ်နှစ်ခု ကိုက်ညီမှုမရှိပါ။',
        ];

        // Laravel ရဲ့ current_password rule က လက်ရှိ password မှန်မမှန်ကို Auto စစ်ပေးပါတယ်
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], $messages);

        // စကားဝှက်အသစ်ကို Hash လုပ်ပြီး Database ထဲမှာ Update လုပ်ခြင်း
        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('sweet_success', 'စကားဝှက်ကို အောင်မြင်စွာ ပြောင်းလဲပြီးပါပြီ။');
    }



    /**
     * ၁။ အက်ဒမင်နှင့် အသုံးပြုသူများစာရင်းစာမျက်နှာ
     */
    public function indexAdmin(Request $request)
    {
        // Tab ခွဲခြားခြင်း (Default ကို admin ဟု သတ်မှတ်သည်)
        $tab = $request->query('tab', 'admin');

        // role ပေါ်မူတည်၍ Query စစ်ထုတ်ခြင်း
        $users = User::where('role', $tab)
                    ->orderBy('id', 'desc')
                    ->paginate(10)
                    ->withQueryString();

        return view('admin.home.userAndadmin_management.list', compact('users', 'tab'));
    }

    /**
     * ၂။ အက်ဒမင်အသစ်ထည့်ရန် Form ပြသခြင်း
     */
    public function createAdmin()
    {
        return view('admin.home.userAndadmin_management.create');
    }

    /**
     * ၃။ အက်ဒမင်အသစ်အား Validation စစ်ဆေးပြီး သိမ်းဆည်းခြင်း
     */
    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'region' => ['nullable', 'string', 'max:100'],
            'township' => ['nullable', 'string', 'max:100'],
            'village' => ['nullable', 'string', 'max:100'],
        ], [
            'name.required' => 'အမည် ထည့်သွင်းရန် လိုအပ်ပါသည်။',
            'email.required' => 'အီးမေးလ် ထည့်သွင်းရန် လိုအပ်ပါသည်။',
            'email.unique' => 'ဤအီးမေးလ်သည် စနစ်အတွင်း အသုံးပြုပြီးသား ဖြစ်နေသည်။',
            'password.required' => 'လျှို့ဝှက်နံပါတ် ထည့်သွင်းရန် လိုအပ်ပါသည်။',
            'password.confirmed' => 'လျှို့ဝှက်နံပါတ် နှစ်ကြိမ်ရိုက်နှိပ်မှု မကိုက်ညီပါ။',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'region' => $request->region,
            'township' => $request->township,
            'village' => $request->village,
        ]);

        return redirect()->route('admin.users.index', ['tab' => 'admin'])
                         ->with('sweet_success', 'အက်ဒမင်အကောင့်အသစ်အား အောင်မြင်စွာ ဖန်တီးပြီးပါပြီ။');
    }

    /**
     * ၄။ အက်ဒမင်တစ်ဦးချင်းစီ၏ အသေးစိတ်အချက်အလက်ပြသခြင်း
     */
    public function showAdmin($id)
    {
        $user = User::findOrFail($id);
        return view('admin.home.userAndadmin_management.details', compact('user'));
    }

    /**
     * ၅။ အကောင့် ဖျက်သိမ်းခြင်း
     */
    public function destroyAdmin($id)
    {
        $user = User::findOrFail($id);

        // မိမိကိုယ်တိုင် ပြန်မဖျက်မိစေရန် ကာကွယ်ခြင်း
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('sweet_error', 'မိမိအကောင့်အား မိမိပြန်လည်ဖျက်သိမ်း၍ မရနိုင်ပါ။');
        }

        $user->delete();

        return redirect()->back()->with('sweet_success', 'အကောင့်အား စနစ်အတွင်းမှ ဖျက်သိမ်းပြီးပါပြီ။');
    }
}


