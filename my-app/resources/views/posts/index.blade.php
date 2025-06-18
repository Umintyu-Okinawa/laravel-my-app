@extends('layout')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-3">掲示板一覧</h2>

        <a href="{{ route('posts.create') }}" class="btn btn-primary mb-3">新規投稿</a>

        {{-- 検索 & ソート フォーム --}}
        <form action="{{ route('posts.index') }}" method="GET" class="mb-4">
            <div class="d-flex flex-wrap gap-2">

                {{-- 検索タイプ --}}
                <select name="search_type" class="form-select me-2" style="max-width: 160px;">
                    <option value="partial" {{ request('search_type') == 'partial' ? 'selected' : '' }}>部分一致</option>
                    <option value="prefix" {{ request('search_type') == 'prefix' ? 'selected' : '' }}>前方一致</option>
                    <option value="suffix" {{ request('search_type') == 'suffix' ? 'selected' : '' }}>後方一致</option>
                </select>

                {{-- キーワード --}}
                <input type="text" name="search" class="form-control me-2" placeholder="検索キーワード" value="{{ request('search') }}" style="max-width: 200px;">

                {{-- 並び順 --}}
                <select name="sort" class="form-select me-2" style="max-width: 160px;">
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>新しい順</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>古い順</option>
                    <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>タイトル昇順</option>
                    <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>タイトル降順</option>
                </select>

                {{-- ボタン --}}
                <button type="submit" class="btn btn-primary">検索・ソート</button>
            </div>
        </form>

        {{-- 投稿一覧 --}}
        @foreach ($posts as $post)
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">{{ $post->title }}</h5>
                    <p class="card-text">{{ Str::limit($post->content, 100) }}</p>
                    <a href="{{ route('posts.show', $post->id) }}" class="btn btn-info text-white">詳細</a>
                </div>
            </div>
        @endforeach

        {{-- ページネーション --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $posts->links() }}
        </div>
    </div>
@endsection
