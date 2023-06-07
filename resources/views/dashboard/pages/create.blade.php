@extends('dashboard.layout')

@section('content')
    <p class="card-title">Add Page</p>

    <form action="{{ route('pages.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control form-control-md" name="title" id="title" aria-describedby="helpId"
                placeholder="Title" value="{{ Session::get('title') }}">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control summernote" rows="5" name="description">{{ Session::get('description') }}</textarea>
        </div>
        <a href="{{ route('pages.index') }}" class="btn btn-secondary btn-fw">
            Back
        </a>
        <span class="mx-2"></span>
        <button type="submit" class="btn btn-primary btn-fw">
            Save
        </button>
    </form>
@endsection
