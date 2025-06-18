@extends('layout')

@section('content')
<h2>お問い合わせ</h2>
<form action="{{ route('contact.confirm') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="name" class="form-label">お名前</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
    @if($errors->has('name'))
    <div class="text-danger">{{$errors->first("name")}}</div>
     @endif
    </div>


    <div class="mb-3">
        <label for="email" class="form-label">メールアドレス</label>
        <input type="text" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
    @error('email')
         <div class="text-danger">{{$errors->first('email')}}</div>
    @enderror
    </div>

    <div class="mb-3">
        <label for="message" class="form-label">メッセージ</label>
        <textarea name="message" id="message" class="form-control" rows="5" required>{{ old('message') }}</textarea>
    @error('message')
    <div class="text-danger">{{$errors->first('message')}}</div>
     @enderror
    
    </div>

    <button type="submit" class="btn btn-primary">確認</button>
</form>

@endsection