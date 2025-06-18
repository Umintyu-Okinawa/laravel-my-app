@extends('layout')

@section('content')
    <h2>新規作成</h2>
    <form action = "{{route('posts.store')}}" method="POST">
    
@csrf
<div class = "mb-3">
    <label for ="title" class ="form-label"> タイトル</label>
    <input type = "text" name="title" class="form-control" required>
</div>
<div class = "mb-3">
    <label for ="content" class ="form-label"> 内容</label>
    <textarea name ="content" class="form-control" rows="5" required></textarea>
</div>
<button type="submit" class="btn btn-success">投稿</button>

</form>
<class="mt-3">
 <a href="{{route('posts.index',)}}" class="btn btn-secondary">戻る</a>
@endsection



