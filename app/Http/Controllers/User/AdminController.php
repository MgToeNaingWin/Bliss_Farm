<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DiseaseInfo;
use App\Models\News;
use App\Models\SellPost;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{
    // admin home
    public function adminHome()
    {
        // 1. ရောဂါနှင့် သတင်းများ ပေါင်းလဒ် (Admin News + Disease Infos)
        $newsCount = News::count();
        $diseaseCount = DiseaseInfo::count();
        $totalNewsAndDisease = $newsCount + $diseaseCount;

        // 2. မွေးမြူရေးနှင့် အရောင်း ပို့စ်များ စုစုပေါင်း (User Sell Posts)
        $postsCount = SellPost::count();

        // 3. သုံးစွဲသူ / ဝယ်ယူသူ ဦးရေ (Users Table မှ စုစုပေါင်း)
        $clientsCount = User::count();

        // 4. အရောင်းပမာဏ (Default / Dummy Value သို့မဟုတ် စုစုပေါင်း စျေးနှုန်း)
        $totalSales = '$103,430';

        // 5. User Sell Posts စာရင်းကို Table အတွက် ဆွဲထုတ်ခြင်း (User Table နဲ့ Relationship ချိတ်ထားပါမည်)
        $sellPosts = SellPost::with('user')->latest()->get();

        return view('admin.home.home', compact(
            'totalNewsAndDisease',
            'postsCount',
            'clientsCount',
            'totalSales',
            'sellPosts'
        ));
    }

    // Sell Post ကို ဖျက်ရန် (Soft Delete သို့မဟုတ် Hard Delete)
  // Sell Post ကို ဖျက်ရန်
    public function deletePost($id)
    {
        $post = SellPost::findOrFail($id);
        $post->delete();

        // SweetAlert ဖြင့် အောင်မြင်ကြောင်းပြသရန်
        Alert::success('အောင်မြင်ပါသည်', 'Post ကို အောင်မြင်စွာ ဖျက်ပြီးပါပြီ။');

        return redirect()->back();
    }

    // // Post ဖျက်ရန် Function
    // public function deletePost($id)
    // {
    //     $post = SellPost::findOrFail($id);

    //     // Image ရှိပါက Storage မှ ဖျက်လိုပါက ဒီမှာ ဖျက်နိုင်ပါသည်
    //     $post->delete();

    //     return redirect()->back()->with('success', 'Post successfully deleted!');
    // }

    // news create page
    public function newsCreatePage(){
        $news = News::orderBy('created_at', 'desc')->take(3)->get();
        return view('admin.home.news.create', compact('news'));
    }

    // news create
    public function newsCreate(Request $request){
        $this->newsValidation($request);
        $newsData = $this->newsData($request);

        if($request->hasFile('newsPhoto')){
           $fileName = uniqid().$request->file('newsPhoto')->getClientOriginalName();
           $request->file('newsPhoto')->move(public_path().'/newsImage/', $fileName);
           $newsData['news-img'] = $fileName;
        }

        News::create($newsData);
        Alert::success('အောင်မြင်ပါသည်', 'သတင်းအသစ်ကို အောင်မြင်စွာ တင်ပြီးပါပြီ။');
        return back();
    }

    // UPDATE - ပြင်ဆင်မည့် စာမျက်နှာသို့သွားခြင်း
    public function newsEditPage($id){
        $newsItem = News::findOrFail($id);
        $news = News::orderBy('created_at', 'desc')->get();
        return view('admin.home.news.update', compact('newsItem', 'news'));
    }

    // UPDATE - ပြင်ဆင်ထားသည့် ဒေတာများကို Database ထဲ သိမ်းဆည်းခြင်း
    public function newsUpdate(Request $request, $id){
        $request->validate([
            'title' => 'required|min:4|max:30',
            'description' => 'required|min:10',
            'newsPhoto' => 'nullable|mimes:png,jpg,jpeg,svg|file',
            'writer' => 'required|min:4|max:20',
        ]);

        $newsItem = News::findOrFail($id);
        $updateData = $this->newsData($request);

        // ပုံအသစ် တင်ထားခြင်း ရှိမရှိ စစ်ဆေးခြင်း
        if($request->hasFile('newsPhoto')){
            // ပြင်ဆင်ရန် - $newsItem->newsPhoto အစား $newsItem->{'news-img'} ကို သုံးပါသည်
            if($newsItem->{'news-img'} && file_exists(public_path().'/newsImage/'.$newsItem->{'news-img'})){
                unlink(public_path().'/newsImage/'.$newsItem->{'news-img'});
            }

            // ပုံအသစ်သိမ်းရန်
            $fileName = uniqid().$request->file('newsPhoto')->getClientOriginalName();
            $request->file('newsPhoto')->move(public_path().'/newsImage/', $fileName);
            $updateData['news-img'] = $fileName;
        }

        $newsItem->update($updateData);
        Alert::success('အောင်မြင်ပါသည်', 'သတင်းကို ပြင်ဆင်ပြီးပါပြီ။');
        return redirect()->route('adminHome');
    }

    // DELETE
    public function newsDelete($id){
        $newsItem = News::findOrFail($id);

        // ပြင်ဆင်ရန် - $newsItem->newsPhoto အစား $newsItem->{'news-img'} ကို သုံးပါသည်
        if($newsItem->{'news-img'} && file_exists(public_path().'/newsImage/'.$newsItem->{'news-img'})){
            unlink(public_path().'/newsImage/'.$newsItem->{'news-img'});
        }

        $newsItem->delete();
        Alert::success('အောင်မြင်ပါသည်', 'သတင်းကို ဖျက်သိမ်းပြီးပါပြီ။');
        return redirect()->route('newsManageAll');
    }

    // Manage All News စာမျက်နှာသစ်သို့ သွားရန်
public function manageAllNews() {
    // သတင်းအားလုံးကို အသစ်ဆုံးကနေ အဟောင်းအတိုင်း ဆွဲထုတ်ပြီး Paginate (၁ ထဲ အများကြီးမပြဘဲ စာမျက်နှာခွဲပြခြင်း) လုပ်ထားပါတယ်
    $news = News::orderBy('created_at', 'desc')->paginate(10);
    return view('admin.home.news.manage', compact('news'));
}

// သတင်းအသေးစိတ်ပြသရန် Function
public function newsDetail($id)
{
    // သတင်းကို ရှာမယ်၊ မတွေ့ရင် 404 Page ပြမယ်
    $newsItem = News::findOrFail($id);

    return view('admin.home.news.details', compact('newsItem'));
}

    // create news data get from admin
    private function newsData($request){
        return [
            'title' => $request->title,
            'description' => $request->description,
            'writer' => $request->writer,
            'created_at' => now(),

        ];
    }

    // news validation
    private function newsValidation($request){
        $request->validate([
            'title' => 'required|min:4|max:30',
            'description' => 'required|min:10',
            'newsPhoto' => 'required|mimes:png,jpg,jpeg,svg|file',
            'writer' => 'required|min:4|max:20',
        ],[
            'title.required' => 'သတင်းခေါင်းစဉ်ဖြည့်ရန်လိုပါတယ်',
            'description.required' => 'သတင်းဖော်ပြချက်ကို ဖြည့်စွက်ရန် လိုပါတယ်',
            'description.min' => 'သတင်းဖော်ပြချက်ကို အနည်းဆုံး စာလုံး ၁၀ လုံးဖြစ်ရမယ်။',
            'newsPhoto.required' => 'သတင်းရုပ်ပုံဖြည့်စွက်ရန်လိုပါတယ်',
            'writer.required' => "စာရေးသူဖြည့်စွက်ရဖို့လိုပါတယ်"
        ]);
    }
}
