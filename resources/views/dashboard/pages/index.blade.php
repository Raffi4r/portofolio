@extends('dashboard.layout')

@section('content')
    <p class="card-title">Pages</p>
    <a href="{{ route('pages.create') }}">
        <button type="button" class="btn btn-primary btn-fw">
            + Add Page
        </button>
    </a>

    <div class="table-responsive">
        @if ($data->isNotEmpty())
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Title</th>
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
                            <td>
                                <a href="{{ route('pages.edit', $item->id) }}" class="btn btn-warning btn-md">
                                    Edit
                                </a>
                                <form action="{{ route('pages.destroy', $item->id) }}" class="d-inline delete-form"
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

    <script>
        $(document).ready(function() {
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
