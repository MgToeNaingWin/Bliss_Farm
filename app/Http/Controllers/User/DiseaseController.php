<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AnimalType;
use App\Models\DiseaseInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;

class DiseaseController extends Controller
{
    // 1. Manage Page
    public function index()
    {
        $diseases = DiseaseInfo::with('animalType')->latest()->paginate(8);
        return view('admin.home.diseases.manage', compact('diseases'));
    }

    // 2. Create Page
    public function create()
    {
        $animalTypes = AnimalType::all();
        return view('admin.home.diseases.create', compact('animalTypes'));
    }

    // 3. Store Data
    public function store(Request $request)
    {
        $messages = [
            'animal_type_id.required' => 'တိရစ္ဆာန်အမျိုးအစားကို ရွေးချယ်ပေးရန် လိုအပ်ပါသည်။',
            'disease_title.required'  => 'ရောဂါအမည် ခေါင်းစဉ်ကို ထည့်သွင်းပေးရန် လိုအပ်ပါသည်။',
            'disease_title.string'    => 'ရောဂါအမည်သည် စာသား (Text) ဖြစ်ရပါမည်။',
            'disease_title.max'       => 'ရောဂါအမည်သည် စာလုံးရေ ၂၅၅ လုံးထက် မကျော်ရပါ။',
            'disease_img.image'       => 'ဓာတ်ပုံဖိုင် အမျိုးအစားသာ ဖြစ်ရပါမည်။',
            'disease_img.mimes'       => 'ဓာတ်ပုံသည် jpeg, png, jpg, webp အမျိုးအစားများသာ ဖြစ်ရပါမည်။',
            'disease_img.max'         => 'ဓာတ်ပုံဖိုင်ဆိုဒ်သည် 2MB (2048 KB) ထက် မကျော်ရပါ။',
        ];

        // 💡 Static Value (cow, goat, etc.) များ လက်ခံနိုင်ရန် exists အစား in: သို့မဟုတ် string ဖြင့် စစ်ဆေးပါသည်
        $request->validate([
            'animal_type_id' => 'required|string',
            'disease_title'  => 'required|string|max:255',
            'disease_img'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], $messages);

        $data = $request->all();

        if ($request->hasFile('disease_img')) {
            $fileName = uniqid() . '_' . $request->file('disease_img')->getClientOriginalName();
            $request->file('disease_img')->move(public_path('diseaseImage'), $fileName);
            $data['disease_img'] = $fileName;
        }

        DiseaseInfo::create($data);

        Alert::success('အောင်မြင်ပါသည်', 'ရောဂါအချက်အလက်အသစ်ကို အောင်မြင်စွာ သိမ်းဆည်းပြီးပါပြီ။');
        return redirect()->route('diseaseManagePage');
    }

    // 4. Detail Page
    public function show($id)
    {
        $disease = DiseaseInfo::with('animalType')->findOrFail($id);
        return view('admin.home.diseases.details', compact('disease'));
    }

    // 5. Edit Page
    public function edit($id)
    {
        $disease = DiseaseInfo::findOrFail($id);
        $animalTypes = AnimalType::all();
        return view('admin.home.diseases.update', compact('disease', 'animalTypes'));
    }

    // 6. Update Data
    public function update(Request $request, $id)
    {
        $messages = [
            'animal_type_id.required' => 'တိရစ္ဆာန်အမျိုးအစားကို ရွေးချယ်ပေးရန် လိုအပ်ပါသည်။',
            'disease_title.required'  => 'ရောဂါအမည် ခေါင်းစဉ်ကို ထည့်သွင်းပေးရန် လိုအပ်ပါသည်။',
            'disease_title.string'    => 'ရောဂါအမည်သည် စာသား (Text) ဖြစ်ရပါမည်။',
            'disease_title.max'       => 'ရောဂါအမည်သည် စာလုံးရေ ၂၅၅ လုံးထက် မကျော်ရပါ။',
            'disease_img.image'       => 'ဓာတ်ပုံဖိုင် အမျိုးအစားသာ ဖြစ်ရပါမည်။',
            'disease_img.mimes'       => 'ဓာတ်ပုံသည် jpeg, png, jpg, webp အမျိုးအစားများသာ ဖြစ်ရပါမည်။',
            'disease_img.max'         => 'ဓာတ်ပုံဖိုင်ဆိုဒ်သည် 2MB (2048 KB) ထက် မကျော်ရပါ။',
        ];

        $request->validate([
            'animal_type_id' => 'required|string',
            'disease_title'  => 'required|string|max:255',
            'disease_img'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], $messages);

        $disease = DiseaseInfo::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('disease_img')) {
            if ($disease->disease_img && File::exists(public_path('diseaseImage/' . $disease->disease_img))) {
                File::delete(public_path('diseaseImage/' . $disease->disease_img));
            }

            $fileName = uniqid() . '_' . $request->file('disease_img')->getClientOriginalName();
            $request->file('disease_img')->move(public_path('diseaseImage'), $fileName);
            $data['disease_img'] = $fileName;
        }

        $disease->update($data);

        Alert::success('အောင်မြင်ပါသည်', 'ရောဂါအချက်အလက်ကို ပြင်ဆင်ပြီးပါပြီ။');
        return redirect()->route('diseaseManagePage');
    }

    // 7. Delete Data
    public function destroy($id)
    {
        $disease = DiseaseInfo::findOrFail($id);

        if ($disease->disease_img && File::exists(public_path('diseaseImage/' . $disease->disease_img))) {
            File::delete(public_path('diseaseImage/' . $disease->disease_img));
        }

        $disease->delete();

        Alert::success('အောင်မြင်ပါသည်', 'အချက်အလက်ကို ဖျက်သိမ်းပြီးပါပြီ။');
        return back();
    }
}
