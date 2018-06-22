@extends('layouts.app')

@section('content')
    <div class="row">
        <aside class="col-xs-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ $user->name }}</h3>
                </div>
                <div class="panel-body">
                    <img class="media-object img-rounded img-responsive" src="{{ Gravatar::src($user->email, 500) }}" alt="">
                </div>
            </div>
            @include('user_follow.follow_button', ['user' => $user])
        </aside>
        <div class="col-xs-8">
            <ul class="nav nav-tabs nav-justified">
                <li role="presentation" class="{{ Request::is('users/' . $user->id) ? 'active' : '' }}"><a href="{{ route('users.show', ['id' => $user->id]) }}">TimeLine <span class="badge">{{ $count_microposts }}</span></a></li>
                <li role="presentation" class="{{ Request::is('users/*/followings') ? 'active' : '' }}"><a href="{{ route('users.followings', ['id' => $user->id]) }}">Followings <span class="badge">{{ $count_followings }}</span></a></li>
                <li role="presentation" class="{{ Request::is('users/*/followers') ? 'active' : '' }}"><a href="{{ route('users.followers', ['id' => $user->id]) }}">Followers <span class="badge">{{ $count_followers }}</span></a></li>
                <li role="presentation" class="{{ Request::is('users/*/favoriteMicroposts') ? 'active' : '' }}"><a href="{{ route('favorites.favoriteMicroposts', ['id' => $user->id]) }}">Favorites <span class="badge">{{ $count_favoriteMicroposts }}</span></a></li>
            </ul>
            @foreach ($favoriteMicroposts as $favoriteMicropost)
            <?php $user = $favoriteMicropost->user; ?>
                <ul class="media-list">
                        <li class="media">
                            <div class="media-left">
                                <img class="media-object img-rounded" src="{{ Gravatar::src($user->email, 50) }}" alt="">
                            </div>

                            <div class="media-body">
                                <div>
                                    {!! link_to_route('users.show', $user->name, ['id' => $user->id]) !!} <span class="text-muted">posted at {{ $favoriteMicropost->created_at }}</span>
                                </div>

                                <div>
                                    <p>{!! nl2br(e($favoriteMicropost->content)) !!}</p>
                                </div>

                                <div style="display:inline-block" class="button2">
                                    @if (Auth::user()->isFavorite($favoriteMicropost->id))
                                        {!! Form::open(['route' => ['favorites.unfavorite', $favoriteMicropost->id], 'method' => 'delete']) !!}
                                        {!! Form::submit('unfavorite', ['class' => "btn btn-success btn-xs"]) !!}
                                        {!! Form::close() !!}

                                    @else
                                        {!! Form::open(['route' => ['favorites.favorite', $favoriteMicropost->id]])!!}
                                        {!! Form::submit('favorite', ['class' => "btn btn-default btn-xs"]) !!}
                                        {!! Form::close() !!}
                                    @endif
                                </div>

                                <div style="display:inline-block" class="button1">
                                    @if (Auth::id() == $favoriteMicropost->user_id)
                                        {!! Form::open(['route' => ['microposts.destroy', $favoriteMicropost->id], 'method' => 'delete']) !!}
                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs']) !!}
                                        {!! Form::close() !!}
                                    @endif
                                </div>
                            </div>
                        </li>
                </ul>
            @endforeach
        </div>
    </div>
@endsection