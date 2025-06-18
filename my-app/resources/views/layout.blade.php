<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>掲示板アプリ</title>

  <!-- BootstrapのCSS読み込み -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <nav class = "navbar navbar-expand-lg bg-primary">
    <div class = "container" >
      <a class = "navbar-brand text-white" href="{{ route ('posts.index')}}">掲示板アプリ</a>
      <ul class="navbar-nav">



        <li class="nav-item">
  <a class="nav-link text-white" href="{{ route('contact.index') }}">お問い合わせ</a>
</li>

        @if (Auth::check())
        <li class = "nav-item">
          <form id = "logout-form" action="{{route ('logout')}}" method="POST" style="display: none;">
            @csrf
          </form>
          <a class ="nav-link text-white" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> ログアウト </a>
          </li>
        @else
        <li class="nav-item">
            <a class="nav-link text-white" href = "{{route('login')}}">ログイン</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="{{route('register')}}">新規登録</a>
        </li>

        @endif
      </ul>
    </div>
  </nav>



@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <div class="text-center">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <div class="text-center">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
@endif





  <div class="container mt-4">
    @yield('content') 
  </div>

    {{-- ▼ スクリプト読み込み用 --}}
@stack('scripts')
     <!-- ↓↓↓ ここに追加 ↓↓↓ -->
     <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>


