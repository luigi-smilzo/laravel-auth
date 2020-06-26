@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Post: {{ $post->id }}</h1>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Body</th>
                <th>Created</th>
                <th>Edited</th>
                <th colspan="2"></th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>{{ $post->id }}</td>
                <td>{{ $post->title }}</td>
                <td>{{ $post->body }}</td>
                <td>{{ $post->created_at }}</td>
                <td>{{ $post->updated_at }}</td>
                <td>
                    <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-primary">Edit</a>
                </td>
                <td>
                    <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input class="btn btn-danger" type="submit" value="Delete">
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection