<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use App\Notifications\LikeNotification;

class LikeController extends Controller
{
   public function toggle(Post $post)
{
    if (!auth()->check()) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    $user = Auth::user();
    $like = $post->likes()->where('user_id', $user->id);

    if ($like->exists()) {
        $like->delete();
    } else {
        $post->likes()->create(['user_id' => $user->id]);
        $post->user->notify(new LikeNotification($post));
    }

    // 🔁 ここで直接 Like モデルから数え直す！
    return response()->json([
        'likes' => Like::where('post_id', $post->id)->count()
    ]);
}

}
