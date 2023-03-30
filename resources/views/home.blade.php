@extends('layouts.app')

@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page">Home</li>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center gy-3">
        <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card sticky-top">
                <div class="card-header">Welcome</div>
                <div class="card-body">
                    <p>
                        Welcome 
                        <a class="text-decoration-none" href="{{ route('user.show', auth()->user()->id) }}">
                            {{ auth()->user()->name }}
                        </a>, to the Classroom!
                    </p>
                    <a href="{{ route('post.create') }}" class="btn btn-primary">New post</a>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-12 order-lg-3">
            <div class="card sticky-top">
                <div class="card-header"><a>Your profile</a></div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">{{ count(auth()->user()->posts) }} Posts</li>
                    <li class="list-group-item">{{ count(auth()->user()->votes) }} Votes</li>
                    <li class="list-group-item">{{ count(auth()->user()->comments) }} Comments</li>
                </ul>
            </div>
        </div>
        <div class="col-md-8 col-lg-6 col-md-12 col-12 row gy-3">
            <div class="col-12">
                <h1>Posts</h1>
            </div>

            @foreach($post as $row)
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title">
                                <div class="hstack gap-2">
                                    <a class="text-decoration-none text-primary-emphasis me-auto" href="{{ route('post.show', $row->id) }}">
                                        {{ $row->title }}
                                    </a>
                                    @if(auth()->user()->id === $row->user->id)
                                        <a href="{{ route('post.edit', $row->id) }}" class="btn btn-warning">Edit</a>
                                        <form action="{{ route('post.destroy', $row->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger" type="submit">Delete</button>
                                        </form>
                                    @endif
                                </div>
                            </h2>
                            <h6 class="card-subtitle mb-2 text-secondary">
                                <a class="text-decoration-none text-secondary" href="{{ route('user.show', $row->user->id) }}">
                                    {{ $row->user->name }}
                                    @if(auth()->user()->id === $row->user->id)
                                    (you)
                                    @endif
                                </a>
                            </h6>
                            <p class="card-text">
                                {{ $row->content }}
                            </p>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex me-auto flex-row">
                                <form class="me-auto" action="{{ route('vote.store') }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" name="post_id" value="{{ $row->id }}" />
                                    <button
                                        class="btn btn-light"
                                        type="submit"

                                        {{-- If we havent voted yet --}}
                                        {{-- @if(!array_search(['post_id' => $row->id, 'user_id' => auth()->user()->id], auth()->user()->votes->toArray()))
                                        disabled
                                        @endif --}}
                                    >Upvote ({{ count($row->votes) }})</button>
                                </form>

                                <div class="hstack gap-2">
                                    <button class="btn btn-light" type="button" data-bs-toggle="collapse" data-bs-target="#commentCollapse{{ $row->id }}" aria-expanded="false" aria-controls="commentCollapse">
                                        See comments ({{ count($row->comments) }})
                                    </button>
                                </div>
                            </div>

                            <div class="collapse" id="commentCollapse{{ $row->id }}">
                                <hr/>

                                {{-- @if(count($row->comments) !== 0) --}}
                                <div class="mt-3 mb-2">
                                    <p class="lead">Comments ({{ count($row->comments) }})</p>

                                    <div class="row gy-2">
                                        <div class="col-12">
                                            <form action="{{ route('comment.store') }}" method="POST">
                                                @csrf
                                                @method('POST')
                                                <input type="hidden" name="post_id" value="{{ $row->id }}" />
                                                <div class="hstack gap-2">
                                                    <textarea rows=1 class="form-control me-auto" placeholder="Your comment here" name="content"></textarea>
                                                    <button class="btn btn-primary" type="submit">Send</button>
                                                </div>
                                            </form>
                                        </div>

                                        @foreach($row->comments as $comment)
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h6><strong>{{ $comment->user->name }}</strong></h6>
                                                    <p class="mb-0">{{ $comment->content }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                {{-- @endif --}}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
