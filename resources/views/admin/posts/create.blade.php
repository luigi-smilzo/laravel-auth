@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-6">
            <h1 class="mb-4">New post</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="form" action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')

                <div class="form-group">
                    <label for="title">Title</label>
                    <input class="form-control" type="text" name="title" id="title" value="{{ old('title') }}">
                </div>
                
                <div class="form-group">
                    <label for="body">Body</label>
                    <textarea class="form-control" name="body" id="body">{{ old('body') }}</textarea>
                </div>
                
                <div class="form-group">
                    <label for="img">Upload a picture</label>
                    <input class="form-control" type="file" id="img" name="img_path" accept="image/*">
                </div>

                <input class="btn btn-primary float-right" type="submit" value="Confirm">
            </form>

        </div>
    </div>
</div>
@endsection