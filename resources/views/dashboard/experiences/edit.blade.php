@extends('dashboard.layout')

@section('content')
    <p class="card-title">Edit Page</p>

    <form action="{{ route('pages.update', $data->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control form-control-md" name="title" id="title" aria-describedby="helpId"
                placeholder="Title" value="{{ $data->title }}">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control summernote" rows="5" name="description">{{ $data->description }}</textarea>
        </div>
        <a href="{{ route('pages.index') }}" class="btn btn-secondary btn-fw">
            Back
        </a>
        <span class="mx-2"></span>
        <button type="submit" class="btn btn-primary btn-fw">
            Update
        </button>
    </form>
@endsection
