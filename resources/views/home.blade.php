@extends('layouts.app')



@section('content')
<div class="container">
<div class="row">
    <div class="col-md-4">
 @if ( Auth::check() )
    <ul class="navbar-nav mr-auto">
        <div class="sidebar">
            <div class="sidebar-item">
            <h4><i style="color:#094067;" class="fas fa-user">USER：</i>{{ Auth::user()->name }}</h4>
                @if (Auth::user()->images->isEmpty()) 
                    <img style="width:250px;height:200px;" src="{{ URL::asset('image/4.jpg') }}"  class="card-img-top" alt="...">
                @else
                    @foreach(Auth::user()->images as $image)
                    <img style="width:250px;height:200px;" src="{{ asset('storage/' . $image['file_name']) }}">
                    @endforeach
                @endif
                
                    <!-- <p><a href="/profile" class="btn btn-primary"><i class="fas fa-user"></i>MyProfile:{{ Auth::user()->name }}</a></p> -->
                    <p><a href="/profile" class="btn btn-primary">MyProfile</a></p>
                <div class="btn-sidebar">
                <div class="btn-sidebar">
                    <!-- <a type="button" class="btn btn-primary btn-lg active btn-sm" href="map"><i class="fas fa-comment-dots">DM</i></a>
                    <br> -->
                    <!-- <a type="button" class="btn btn-primary btn-lg active btn-sm" href="map2"><i class="fas fa-comment-dots">MAP2で検索</i></a>
                    <br>
                    <a type="button" class="btn btn-primary btn-lg active btn-sm" href="map3"><i class="fas fa-comment-dots">MAP3で検索</i></a>
                    <br> -->
                    <a type="button" class="btn btn-primary btn-sm" href="map"><i class="fas fa-comment-dots">MAPで検索(実装中：クリックOK)</i></a>
                    <br>
                    <p></p>
                    <a type="button" class="btn btn-primary btn-sm" href="post"><i class="fas fa-comment-dots">共有チャット/タイムライン</i></a>
                    <p></p>
                    <br>
                </div>
            </div>
        </div>
    </ul>
@endif
    </div>

<div class="col-md-8">
        @if ($errors->has('text'))
        <ul>
        @foreach($errors->all() as $error)
            <font color =red>*{{ $error }}</font>
        @endforeach
        </ul>
        @endif
        <!-- <h5 type="button" class="btn btn-primary" href="#"><i class="fas fa-edit">地名/住所を入力して、あなたの旅をシェアしよう</i></h5> -->
    <h5 class=".font-weight-bold" style="color:#094067;"><i class="fas fa-edit">地名/住所を入力して旅をシェアする</i></h5>
    <form action="/post" method="post" class=".form-control:focus">
        {{ csrf_field() }}
        <input type="search" name="text" placeholder="地名/住所">
        <button class="btn btn-primary btn-lg active btn-sm" type="submit"><i class="fas fa-edit"></i></button>
    </form>

<br>

@foreach ($pins as $pins)
<div class="card">
  <h5 class="card-header" style="color:#094067;"><a type="button" class="btn btn-default btn-sm" style="color:#3da9fc;" href="profile/{{$pins->user_id}}"><i class="fas fa-user"></i> {{$pins->user->name}}</a>：{{ $pins->text }}

  </h5>
  <div class="card-body">
    <!-- <h5 class="card-title">SNS for Backpackers</h5> -->


    @if ($pins->photos->isEmpty()) 
        <img style="width:250px;height:200px;" src="{{ URL::asset('image/noimage.png') }}"  class="card-img-top" alt="...">
    @else
        @foreach($pins->photos as $photo)
        <img style="width:250px;height:200px;" src="{{ asset('storage/' . $photo['photo']) }}">
        @endforeach
    @endif

    <p class="card-text"></p>
    <a href="post/{{$pins->id}}" class="btn btn-primary">MAPを見る</a>
@if($pins->users()->where('user_id', Auth::id())->exists())
      <form action="{{ route('unfavorites', $pins) }}" method="POST">
         @csrf
         <input type="submit" value="&#xf164;Like {{ $pins->users()->count() }}" class="fas btn btn-primary">
      </form>
@else
      <form action="{{ route('favorites', $pins) }}" method="POST">
        @csrf
        <input type="submit" value="&#xf164;Like {{ $pins->users()->count() }}" class="fas btn btn-link">
      </form>
@endif
</div>
</div>
<br>
@endforeach

<br>

    <!-- <div class="col-md-4">
    </div> -->
    </div>
</div>

@endsection
