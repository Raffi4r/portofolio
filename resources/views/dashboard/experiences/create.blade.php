@extends('dashboard.layout')

@section('content')
    <p class="card-title">Add Experience</p>

    <form action="{{ route('experiences.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="info1" class="form-label">Company</label>
            <input type="text" class="form-control form-control-md" name="info1" id="info1" aria-describedby="helpId"
                placeholder="Company" value="{{ Session::get('info1') }}">
        </div>
        <div class="mb-3">
            <label for="title" class="form-label">Position</label>
            <input type="text" class="form-control form-control-md" name="title" id="title"
                aria-describedby="helpId" placeholder="Position" value="{{ Session::get('title') }}">
        </div>
        <div class="mb-3">
            <div class="row">
                <div class="col-auto">Date Start</div>
                <div class="col-auto">
                    <input type="date" class="form-control form-control-sm" name="date_start">
                </div>
                <div class="col-auto">Date End</div>
                <div class="col-auto">
                    <input type="date" class="form-control form-control-sm" id="date_end" name="date_end">
                    <input type="checkbox" id="disable_date_end" name="disable_date_end" onchange="toggleDateEnd()">
                    <label for="disable_date_end">Present</label>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control summernote" rows="5" name="description">{{ Session::get('description') }}</textarea>
        </div>
        <a href="{{ route('experiences.index') }}" class="btn btn-secondary btn-fw">
            Back
        </a>
        <span class="mx-2"></span>
        <button type="submit" class="btn btn-primary btn-fw">
            Save
        </button>
    </form>
@endsection
