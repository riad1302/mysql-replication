@extends('layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 mt-5 margin-tb">
            <div class="pull-left">
                <h2>{{isset($post['id']) ? 'Edit  Post' : 'Add New Post'}}</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('post.index') }}"> Back</a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($post['id']) ? route('post.update', $post['id']) : route('post.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                <div class="form-group">
                    <strong>Title:</strong>
                    <input type="text" name="title" class="form-control mt-2" placeholder="Title" value="{{ isset($post['title']) ?  $post['title'] : old('title') }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                <div class="form-group">
                    <strong>Detail:</strong>
                    <textarea class="form-control mt-2" style="height:150px" name="details" placeholder="Detail" value="{{ isset($post['details']) ? $post['details'] : old('details') }}">{{ isset($post['details']) ? $post['details'] : old('details') }}</textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>

    </form>
@endsection
