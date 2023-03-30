@extends('layouts.app')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
<li class="breadcrumb-item active" aria-current="page">Create a new Post</li>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create a new post</div>

                <div class="card-body">
                    <form action="{{ route('post.store') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="form-floating mb-3">
                            <input name="title" type="text" class="form-control" id="titleInput" placeholder="Your title" required>
                            <label for="titleInput">Title</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" placeholder="Write here" style="height: 30ch;" id="contentInput" name="content" required></textarea>
                            <label for="contentInput">Content</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

                    {{-- <div class="row">
                        <form action="{{ route('post.store') }}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="col-12">
                                <label for="titleEdit">Title</label>
                                <input id="titleEdit" type="text" name="title" value="My New Post" required />
                            </div>

                            <div class="col-12">
                                <label for="contentEdit">Content</label>
                                <textarea name="content" id="contentEdit" cols="30" rows="10">Hello world</textarea>
                            </div>
                        </form>
                    </div> --}}
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
