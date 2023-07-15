@extends('dashboard.layout')

@section('content')
    <p class="card-title">Page Setting</p>

    <form action="{{ route('setting.update') }}" method="POST" id="pageForm">
        @csrf
        <div class="form-group row">
            <label class="col-sm-2" for="about">About</label>
            <div class="col-sm-6">
                <select class="form-control form-control-sm" name="about">
                    @foreach ($data as $item)
                        <option value="{{ $item->id }}" {{ $item->id == get_meta_value('about') ? 'selected' : '' }}>
                            {{ $item->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2" for="award">Award</label>
            <div class="col-sm-6">
                <select class="form-control form-control-sm" name="award">
                    @foreach ($data as $item)
                        <option value="{{ $item->id }}" {{ $item->id == get_meta_value('award') ? 'selected' : '' }}>
                            {{ $item->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2" for="interest">Interest</label>
            <div class="col-sm-6">
                <select class="form-control form-control-sm" name="interest">
                    @foreach ($data as $item)
                        <option value="{{ $item->id }}" {{ $item->id == get_meta_value('interest') ? 'selected' : '' }}>
                            {{ $item->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <button class="btn btn-primary btn-fw">
            Save
        </button>
    </form>
@endsection

@section('script')
    <script>
        $(function() {
            var pageForm = $('#pageForm');

            pageForm.on('submit', function(event) {
                event.preventDefault();

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Data will be saved',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'Cancel'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        pageForm.off('submit').submit();
                    }
                });
            });

        });
    </script>
@endsection
