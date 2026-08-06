<?php
// app/Http/Controllers/PostInteractionController.php
namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Reaction;
use App\Events\PostLiked;
use App\Events\PostCommented;
use App\Events\PostReacted;
use Illuminate\Http\Request;

class PostInteractionController extends Controller
{
    public function toggleLike(Request $request, Post $post)
    {
        $userId = auth()->id();

        $like = Like::where('post_id', $post->id)->where('user_id', $userId)->first();

        if ($like) {
            $like->delete();
            $liked = false;
        } else {
            Like::create(['user_id' => $userId, 'post_id' => $post->id]);
            $liked = true;
        }

        $likeCount = $post->likes()->count();

        broadcast(new PostLiked($post->id, $likeCount, $liked, $userId))->toOthers();

        return response()->json([
            'success'    => true,
            'liked'      => $liked,
            'like_count' => $likeCount,
        ]);
    }

    public function storeComment(Request $request, Post $post)
    {
        $request->validate(['body' => 'required|string|max:1000']);

        $comment = Comment::create([
            'user_id' => auth()->id(),
            'post_id' => $post->id,
            'body'    => $request->body,
        ]);
        $comment->load('user');

        $commentData = [
            'id'         => $comment->id,
            'body'       => $comment->body,
            'user_name'  => $comment->user->name,
            'created_at' => $comment->created_at->diffForHumans(),
        ];

        $commentCount = $post->comments()->count();

        broadcast(new PostCommented($post->id, $commentData, $commentCount))->toOthers();

        return response()->json([
            'success'       => true,
            'comment'       => $commentData,
            'comment_count' => $commentCount,
        ]);
    }

    public function react(Request $request, Post $post)
    {
        $request->validate(['type' => 'required|string|in:like,love,haha,sad,angry']);

        $userId = auth()->id();
        $reaction = Reaction::where('post_id', $post->id)->where('user_id', $userId)->first();

        if ($reaction && $reaction->type === $request->type) {
            $reaction->delete();
            $currentType = null;
        } elseif ($reaction) {
            $reaction->update(['type' => $request->type]);
            $currentType = $request->type;
        } else {
            Reaction::create(['user_id' => $userId, 'post_id' => $post->id, 'type' => $request->type]);
            $currentType = $request->type;
        }

        $reactionCount = $post->reactions()->count();
        $countsByType = $post->reactions()->selectRaw('type, count(*) as total')->groupBy('type')->pluck('total', 'type');

        broadcast(new PostReacted($post->id, $reactionCount, $countsByType, $currentType, $userId))->toOthers();

        return response()->json([
            'success'        => true,
            'current_type'   => $currentType,
            'reaction_count' => $reactionCount,
            'counts_by_type' => $countsByType,
        ]);
    }
}
