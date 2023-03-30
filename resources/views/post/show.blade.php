@extends('layouts.app')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
<li class="breadcrumb-item active" aria-current="page">Post {{ $post->title }}</li>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">
                        <div class="hstack gap-2">
                            <a class="text-decoration-none text-primary-emphasis me-auto" href="{{ route('post.show', $post->id) }}">
                                {{ $post->title }}
                            </a>
                            @if(auth()->user()->id === $post->user->id)
                                <a href="{{ route('post.edit', $post->id) }}" class="btn btn-warning">Edit</a>
                                <form action="{{ route('post.destroy', $post->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit">Delete</button>
                                </form>
                            @endif
                        </div>
                    </h2>
                    <h6 class="card-subtitle mb-2 text-secondary">
                        <a class="text-decoration-none text-secondary" href="{{ route('user.show', $post->user->id) }}">
                            {{ $post->user->name }}
                            @if(auth()->user()->id === $post->user->id)
                            (you)
                            @endif
                        </a>
                    </h6>
                    <p class="card-text">
                        {{ $post->content }}
                    </p>
                </div>
                <div class="card-footer">
                    <div class="d-flex me-auto flex-row">
                        <form class="me-auto" action="{{ route('vote.store') }}" method="POST">
                            @csrf
                            @method('POST')
                            <input type="hidden" name="post_id" value="{{ $post->id }}" />
                            <button
                                class="btn btn-light"
                                type="submit"

                                {{-- If we havent voted yet --}}
                                {{-- @if(!array_search(['post_id' => $post->id, 'user_id' => auth()->user()->id], auth()->user()->votes->toArray()))
                                disabled
                                @endif --}}
                            >Upvote ({{ count($post->votes) }})</button>
                        </form>

                        <div class="hstack gap-2">
                            <button class="btn btn-light" type="button" data-bs-toggle="collapse" data-bs-target="#commentCollapse{{ $post->id }}" aria-expanded="false" aria-controls="commentCollapse">
                                See comments ({{ count($post->comments) }})
                            </button>
                        </div>
                    </div>

                    <div class="collapse show" id="commentCollapse{{ $post->id }}">
                        <hr/>

                        {{-- @if(count($post->comments) !== 0) --}}
                        <div class="mt-3 mb-2">
                            <p class="lead">Comments ({{ count($post->comments) }})</p>

                            <div class="row gy-2">
                                <div class="col-12">
                                    <form action="{{ route('comment.store') }}" method="POST">
                                        @csrf
                                        @method('POST')
                                        <input type="hidden" name="post_id" value="{{ $post->id }}" />
                                        <div class="hstack gap-2">
                                            <textarea rows=1 class="form-control me-auto" placeholder="Your comment here" name="content"></textarea>
                                            <button class="btn btn-primary" type="submit">Send</button>
                                        </div>
                                    </form>
                                </div>

                                @foreach($post->comments as $comment)
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
    </div>
</div>
@endsection
