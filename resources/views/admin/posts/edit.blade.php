@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-6">
            <h1 class="mb-4">Edit post</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="form" action="{{ route('admin.posts.update', $post->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="form-group">
                    <label for="title">Title</label>
                    <input class="form-control" type="text" name="title" id="title" value="{{ old('title', $post->title) }}">
                </div>
                
                <div class="form-group">
                    <label for="body">Body</label>
                    <textarea class="form-control" name="body" id="body">{{ old('body', $post->body) }}</textarea>
                </div>

                <input class="btn btn-primary float-right" type="submit" value="Confirm">
            </form>

        </div>
    </div>
</div>
@endsection