<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::query();

        // 絞り込み検索
        if ($request->has('search') && $request->filled('search')) {
            $searchType = $request->input('search_type');
            $searchKeyword = $request->input('search');

            switch ($searchType) {
                case 'prefix':
                    $query->where('title', 'like', $searchKeyword . '%');
                    break;
                case 'suffix':
                    $query->where('title', 'like', '%' . $searchKeyword);
                    break;
                case 'partial':
                    $query->where('title', 'like', '%' . $searchKeyword . '%');
                    break;
                default:
                    $query->where('title', 'like', '%' . $searchKeyword . '%');
                    break;
            }
        }

        // ソート処理
        $sortType = $request->input('sort', 'newest');

        switch ($sortType) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $posts = $query->paginate(5);
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        return view('posts.create');
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('posts.show', ['post' => $post->id])->with('success','掲示板の投稿に成功しました。');
    }

    public function show(string $id)
{
    $post = Post::with(['likes', 'comments.user'])->findOrFail($id);
    $comments = $post->comments()->with('user')->paginate(5);

    return view('posts.show', compact('post', 'comments'));
}


    public function edit(string $id)
    {
        $post = Post::findOrFail($id);

        if (Auth::id() !== $post->user_id) {
            return redirect()->route('posts.index');
        }

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $post = Post::findOrFail($id);

        if (Auth::id() !== $post->user_id) {
            return redirect()->route('posts.index');
        }

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);

        if (Auth::id() !== $post->user_id) {
            return redirect()->route('posts.index');
        }

        $post->delete();

        return redirect()->route('posts.index');
    }
}
