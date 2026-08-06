<?php

namespace App\Http\Controllers\SystemUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    //user profile page
    public function profilePage(){
          $user = Auth::user();
        return view('user.profile.home', compact('user'));
    }

    // User edit profile  page
    public function editProfilePage()
    {
        $user = Auth::user();

        return view('user.profile.edit', compact('user'));
    }

    // Edit profile (Handles Profile Info, Photo Upload, Location, and Password Update)
    public function profileEdit(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // -------------------------------------------------------------
        // 1. Password Update Form Submitted
        // -------------------------------------------------------------
        if ($request->hasAny(['current_password', 'password'])) {
            $request->validate([
                'current_password' => ['required', 'current_password'],
                'password'         => ['required', 'confirmed', Password::defaults()],
            ], [
                'current_password.required'         => 'လက်ရှိစကားဝှက်ကို ထည့်သွင်းပေးပါ။',
                'current_password.current_password' => 'လက်ရှိစကားဝှက် မှားယွင်းနေပါသည်။',
                'password.required'                 => 'စကားဝှက်အသစ် ထည့်သွင်းပေးပါ။',
                'password.confirmed'                => 'စကားဝှက်အသစ် အတည်ပြုချက် မကိုက်ညီပါ။',
            ]);

            $user->update([
                'password' => Hash::make($request->password),
            ]);

            Alert::success('အောင်မြင်ပါသည်။', 'စကားဝှက် ပြောင်းလဲပြီးပါပြီ။');
            return redirect()->back()->with('status', 'စကားဝှက် ပြောင်းလဲပြီးပါပြီ။');
        }

        // -------------------------------------------------------------
        // 2. Location Form Submitted
        // -------------------------------------------------------------
        if ($request->hasAny(['region', 'township', 'village']) && !$request->has('name')) {
            $validated = $request->validate([
                'region'   => ['nullable', 'string', 'max:255'],
                'township' => ['nullable', 'string', 'max:255'],
                'village'  => ['nullable', 'string', 'max:255'],
            ]);

            $user->update($validated);

            Alert::success('အောင်မြင်ပါသည်။', 'နေရပ်လိပ်စာ အချက်အလက်များ သိမ်းဆည်းပြီးပါပြီ။');
            return redirect()->back()->with('status', 'နေရပ်လိပ်စာ အချက်အလက်များ သိမ်းဆည်းပြီးပါပြီ။');
        }

        // -------------------------------------------------------------
        // 3. Profile Photo or Personal Info Form Submitted
        // -------------------------------------------------------------
        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'phone'         => ['nullable', 'string', 'max:20'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'name.required'       => 'အမည် ထည့်သွင်းပေးပါ။',
            'profile_photo.image' => 'ဓာတ်ပုံဖိုင် အမျိုးအစား (jpg, jpeg, png, webp) သာ တင်ခွင့်ရှိပါသည်။',
            'profile_photo.max'   => 'ဓာတ်ပုံဖိုင်ပမာဏ 2MB ထက် မကျော်ရပါ။',
        ]);

        // Handle Profile Photo Upload
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            $photoPath = $request->file('profile_photo')->store('profile-photos', 'public');
            $user->profile_photo = $photoPath;
        }

        $user->name = $validated['name'];
        $user->phone = $validated['phone'] ?? null;
        $user->save();

        Alert::success('အောင်မြင်ပါသည်။', 'ကိုယ်ရေးအချက်အလက်များ သိမ်းဆည်းပြီးပါပြီ။');
        return redirect()->back()->with('status', 'ကိုယ်ရေးအချက်အလက်များ သိမ်းဆည်းပြီးပါပြီ။');
    }
}
