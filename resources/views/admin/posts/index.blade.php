@extends('layouts.admin')

@section('content')
<div class="container">
    @if (session('del_success'))
        <div class="alert alert-success">
            Post <strong>{{ session('del_success') }}</strong> successfully deleted!
        </div>
    @endif

    <h1 class="mb-4">Archive</h1>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Created</th>
                <th>Edited</th>
                <th colspan="3"></th>
            </tr>
        </thead>

        <tbody>
            @foreach($posts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->created_at->format('d/m/Y') }}</td>
                    <td>{{ $post->updated_at->diffForHumans() }}</td>
                    <td>
                        <a href="{{ route('admin.posts.show', $post->id) }}" class="btn btn-success">Show</a>
                    </td>
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
            @endforeach
        
        </tbody>
    </table>


    <div class="pagination mt-5 d-flex justify-content-center">
        {{ $posts->links() }}
    </div>
</div>
@endsection