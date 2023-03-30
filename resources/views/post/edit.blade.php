@extends('layouts.app')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
<li class="breadcrumb-item active" aria-current="page">Edit post</li>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit {{ $post->title }}</div>

                <div class="card-body">
                    <form action="{{ route('post.update', $post->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-floating mb-3">
                            <input name="title" type="text" class="form-control" id="titleInput" placeholder="Your title" required value="{{ $post->title }}">
                            <label for="titleInput">Title</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" placeholder="Write here" style="height: 30ch;" id="contentInput" name="content" required>{{ $post->content }}</textarea>
                            <label for="contentInput">Content</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
