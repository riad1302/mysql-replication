@extends('layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Laravel 10 CRUD Example from scratch</h2>
            </div>
            <div class="pull-right mt-5">
                <a class="btn btn-success" href="{{ route('post.add') }}"> Create New Post</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered mt-5">
        <tr>
            <th>No</th>
            <th>Title</th>
            <th>Details</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($posts as $post)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $post->title }}</td>
                <td>{{ $post->details }}</td>
                <td>
                    <form action="{{ route('post.destroy',$post->id) }}" method="POST">

                        <a class="btn btn-info" href="{{ route('post.edit',$post->id) }}">Show</a>

                        <a class="btn btn-primary" href="{{ route('post.edit',$post->id) }}">Edit</a>

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    {!! $posts->links() !!}

@endsection
