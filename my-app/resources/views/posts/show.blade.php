@extends('layout')

@section('content')
    <h2>投稿詳細</h2>

   <div class="card mb-3">
    <div class="card-body">
        <h3 class="card-title">{{ $post->title }}</h3>

        <!-- 投稿内容 -->
        <p class="card-text">{{ $post->content }}</p>

        <!-- ✅ いいねボタンをここに移動 -->
        <div class="d-flex align-items-center mb-3" style="gap: 8px;">
            <button id="like-button" data-post-id="{{ $post->id }}" class="btn btn-outline-danger p-2" style="border-radius: 50%;">
                ❤️
            </button>
            <span id="like-count">{{ $post->likes }}</span> 件のいいね
            



        </div>

        <!-- ボタン群 -->
        <a href="{{ route('posts.index') }}" class="btn btn-secondary">戻る</a>

        @if (Auth::check() && Auth::id() === $post->user_id)
            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning">編集</a>
            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">削除</button>
            </form>
        @endif
    </div>
</div>

    {{-- ▼ サザコギミックHTML（動画＋MP3） --}}
    <div id="sazako-overlay" style="display: none;">
        <div id="sazako-video">
            <iframe
                src="https://www.youtube.com/embed/nYyWzsweAEU?autoplay=1&mute=1&controls=0&rel=0&showinfo=0"
                allow="autoplay; encrypted-media"
                allowfullscreen
                style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; border: none; z-index: 10000;">
            </iframe>

            <audio id="sazako-audio" autoplay>
                <source src="{{ asset('audio/sazako.mp3') }}" type="audio/mp3">
                お使いのブラウザは audio タグをサポートしていません。
            </audio>
        </div>
    </div>

    <h3>コメント一覧</h3>
    @if($comments->isNotEmpty())
       @foreach ($comments as $comment)
            <div class ="card mb-2">
                    <div class="card-body">
                        <p class="card-text">{{$comment->content}}</p>
                        <p class="text-muted">投稿者:{{$comment->user->name}}|投稿日時:{{$comment->created_at->format('Y-m-d')}}</p>
                    </div> 
            </div>    
        @endforeach
    @else
      <p>コメントはまだありません。</p>
    @endif
@auth
    <h3>コメントを投稿する</h3>
  <form action="{{ route('comments.store', $post->id) }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="content" class="form-label">コメント内容</label>
        <textarea name="content" id="content" class="form-control" rows="3" required style="color:#000; background-color:#fff;"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">コメント投稿</button>
</form>

@else
   <p>コメントを投稿するにはログインしてください</p>
@endauth


 {{-- ページネーション --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $comments->links() }} 
        </div>


       
<!-- いいねボタン（Blade） -->





<!-- JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

<script>
document.getElementById('like-button').addEventListener('click', function () {
    // ✅ ① 音を鳴らす（効果音ファイルを public/audio/like.mp3 に置いておく）
      const audio = new Audio('/audio/teemo_4.mp3'); // ←ファイル名に合わせて変更
    audio.play();
    
    

    const emojis = ['❤️', '💛', '💙', '💚', '🧡', '💜', '🖤', ];

    // ✅ ② 大量に絵文字を画面にばらまく（10個）
    for (let i = 0; i < 10; i++) {
        const emoji = document.createElement('div');
        emoji.className = 'floating-heart';
        emoji.innerText = emojis[Math.floor(Math.random() * emojis.length)];

        const size = 20 + Math.random() * 20;
        emoji.style.position = 'fixed';
        emoji.style.fontSize = `${size}px`;
        emoji.style.left = `${Math.random() * 100}vw`;  // 画面横ランダム
        emoji.style.top = `${Math.random() * 100}vh`;   // 画面縦ランダム
        emoji.style.zIndex = 9999;
        emoji.style.pointerEvents = 'none';

        document.body.appendChild(emoji);

        gsap.to(emoji, {
            y: -100 - Math.random() * 200,     // 上方向に浮く
            x: -100 + Math.random() * 200,     // 左右にばらつく
            scale: 1 + Math.random(),
            rotation: Math.random() > 0.5 ? 360 : -360,
            opacity: 0,
            duration: 2,
            ease: "power2.out",
            onComplete: () => emoji.remove()
        });
    }

    // ✅ ③ 通常のいいね処理
   fetch(`/posts/{{ $post->id }}/like`, {
    method: 'POST',
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Content-Type': 'application/json',
    },
    body: JSON.stringify({})
})
.then(response => response.json())
.then(data => {
    const count = document.getElementById('like-count');
    count.innerText = data.likes;  // ← 直接反映
});

});
</script>










@endsection

@push('scripts')
    <link rel="stylesheet" href="{{ asset('css/sazako.css') }}">
    <script src="{{ asset('js/sazako.js') }}"></script>
@endpush
