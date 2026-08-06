<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\SellPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // user home
    public function userHome()
    {
        return view('user.home.home');
    }

    // ==========================================
    // 1. PAGES & POST CREATION
    // ==========================================

    public function listPage()
    {
        $posts = SellPost::with(['user', 'reactions', 'comments.user', 'comments.replies.user'])
            ->withCount(['reactions', 'comments'])
            ->latest()
            ->get();

        return view('user.sellpost.list', compact('posts'));
    }

    public function createPage()
    {
        return view('user.sellpost.create');
    }

    public function createPost(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'price'       => 'required|numeric',
            'category'    => 'required|string',
            'description' => 'required|string',
            'phone'       => 'required|string',
            'location'    => 'required|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ], [
            'title.required'       => 'ခေါင်းစဉ် မဖြစ်မနေ ထည့်သွင်းပေးပါရန်။',
            'price.required'       => 'စျေးနှုန်း မဖြစ်မနေ ထည့်သွင်းပေးပါရန်။',
            'category.required'    => 'အမျိုးအစား မဖြစ်မနေ ရွေးချယ်ပေးပါရန်။',
            'description.required' => 'အကြောင်းအရာ မဖြစ်မနေ ထည့်သွင်းပေးပါရန်။',
            'phone.required'       => 'ဖုန်းနံပါတ် မဖြစ်မနေ ထည့်သွင်းပေးပါရန်။',
            'location.required'    => 'မြို့နယ်/လိပ်စာ မဖြစ်မနေ ထည့်သွင်းပေးပါရန်။',
            'image.image'          => 'ဓာတ်ပုံ ဖိုင်အမျိုးအစား သာလျှင် တင်ပေးပါရန်။',
        ]);

        $validated['user_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('posts', 'public');
        }

        SellPost::create($validated);

        return redirect()->route('postListPage')->with('success', 'အရောင်းပို့စ်ကို အောင်မြင်စွာ တင်ပြီးပါပြီ။');
    }

    // ==========================================
    // 2. EDIT & UPDATE POST
    // ==========================================

    public function editPostPage($id)
    {
        $post = SellPost::findOrFail($id);

        if ($post->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('user.sellpost.edit', compact('post'));
    }

    public function updatePost(Request $request, $id)
    {
        $post = SellPost::findOrFail($id);

        if ($post->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'price'       => 'required|numeric',
            'category'    => 'nullable|string',
            'description' => 'required|string',
            'phone'       => 'required|string',
            'location'    => 'required|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ], [
            'title.required'       => 'ခေါင်းစဉ် မဖြစ်မနေ ထည့်သွင်းပေးပါရန်။',
            'price.required'       => 'စျေးနှုန်း မဖြစ်မနေ ထည့်သွင်းပေးပါရန်။',
            'description.required' => 'အကြောင်းအရာ မဖြစ်မနေ ထည့်သွင်းပေးပါရန်။',
            'phone.required'       => 'ဖုန်းနံပါတ် မဖြစ်မနေ ထည့်သွင်းပေးပါရန်။',
            'location.required'    => 'မြို့နယ်/လိပ်စာ မဖြစ်မနေ ထည့်သွင်းပေးပါရန်။',
            'image.image'          => 'ဓာတ်ပုံ ဖိုင်အမျိုးအစား သာလျှင် တင်ပေးပါရန်။',
        ]);

        if ($request->hasFile('image')) {
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }
            $validated['image'] = $request->file('image')->store('posts', 'public');
        }

        $post->update($validated);

        return redirect()->route('postListPage')->with('success', 'ပို့စ်ကို အောင်မြင်စွာ ပြင်ဆင်ပြီးပါပြီ။');
    }

    // ==========================================
    // 3. DELETE POST (FIXED FOR AJAX & SWEETALERT)
    // ==========================================

    public function deletePost($id)
    {
        $post = SellPost::find($id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'ပို့စ် ရှာမတွေ့ပါ။'
            ], 404);
        }

        if ($post->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'ဤပို့စ်ကို ဖျက်ရန် အခွင့်အာဏာ မရှိပါ။'
            ], 403);
        }

        // Storage မှ ပုံပါ တစ်ပါတည်း ဖျက်ထုတ်ခြင်း
        if ($post->image && Storage::disk('public')->exists($post->image)) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'ပို့စ်ကို အောင်မြင်စွာ ဖျက်လိုက်ပါပြီ။'
        ]);
    }

    // ==========================================
    // 4. AJAX INTERACTIVE FUNCTIONS
    // ==========================================

    public function toggleReaction(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:sell_posts,id',
            'type'    => 'required|string',
        ]);

        $post = SellPost::findOrFail($request->post_id);
        $existingReaction = $post->reactions()->where('user_id', Auth::id())->first();

        if ($existingReaction) {
            if ($existingReaction->type === $request->type) {
                $existingReaction->delete();
                $status = 'removed';
            } else {
                $existingReaction->update(['type' => $request->type]);
                $status = 'updated';
            }
        } else {
            $post->reactions()->create([
                'user_id' => Auth::id(),
                'type'    => $request->type,
            ]);
            $status = 'added';
        }

        return response()->json([
            'status' => $status,
            'count'  => $post->reactions()->count(),
        ]);
    }

    public function storeComment(Request $request)
    {
        $request->validate([
            'post_id'   => 'required|exists:sell_posts,id',
            'comment'   => 'required|string',
            'parent_id' => 'nullable',
        ]);

        $post = SellPost::findOrFail($request->post_id);

        $comment = $post->comments()->create([
            'user_id'   => Auth::id(),
            'comment'   => $request->comment,
            'parent_id' => $request->parent_id ?? null,
        ]);

        $user = Auth::user();
        $avatar = $user->profile_photo_path
            ? asset('storage/' . $user->profile_photo_path)
            : 'https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?w=80&auto=format&fit=crop';

        return response()->json([
            'success' => true,
            'count'   => $post->comments()->count(),
            'comment' => [
                'id'          => $comment->id,
                'text'        => $comment->comment,
                'user_name'   => $user->name,
                'user_avatar' => $avatar,
                'time'        => $comment->created_at->diffForHumans(),
            ]
        ]);
    }

    /**
     * Increment View Count (DUPLICATE VIEWS FIX)
     */
    public function incrementView(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:sell_posts,id',
        ]);

        $post = SellPost::findOrFail($request->post_id);

        // Session ဖြင့် စစ်ဆေး၍ User တစ်ယောက်တည်း ထပ်ခါထပ်ခါ View မတိုးအောင် ပြုလုပ်ခြင်း
        $sessionKey = 'viewed_post_' . $post->id;

        if (!session()->has($sessionKey)) {
            $post->increment('views_count');
            session()->put($sessionKey, true);
        }

        return response()->json([
            'success' => true,
            'views'   => $post->views_count
        ]);
    }
}
