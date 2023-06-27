@extends('dashboard.layout')

@section('content')
    <p class="card-title">Educations</p>
    <a href="{{ route('educations.create') }}">
        <button type="button" class="btn btn-primary btn-fw">
            + Add Education
        </button>
    </a>

    <div class="table-responsive my-3">
        @if ($data->isNotEmpty())
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>University</th>
                        <th>Faculty</th>
                        <th>Major</th>
                        <th>GPA</th>
                        <th>Date Start</th>
                        <th>Date End</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = ($data->currentPage() - 1) * $data->perPage();
                    @endphp
                    @foreach ($data as $item)
                        @php
                            $i++;
                        @endphp
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->info1 }}</td>
                            <td>{{ $item->info2 }}</td>
                            <td>{{ $item->info3 }}</td>
                            <td>{{ $item->start_date }}</td>
                            <td>{{ $item->end_date }}</td>
                            <td>
                                <a href="{{ route('educations.edit', $item->id) }}" class="btn btn-warning btn-md">
                                    Edit
                                </a>
                                <form action="{{ route('educations.destroy', $item->id) }}" class="d-inline delete-form"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-fw delete-btn">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="mt-3">No data</p>
        @endif
    </div>
    <div>
        {{ $data->links() }}
    </div>
@endsection

@section('script')
    <script>
        $(function() {
            $('.table-responsive').on('click', '.delete-btn', function(event) {
                event.preventDefault();
                var form = $(this).closest('.delete-form');

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Data will be deleted',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'Cancel'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection
