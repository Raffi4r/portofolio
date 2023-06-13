@extends('dashboard.layout')

@section('content')
    <p class="card-title">Pages</p>
    <a href="{{ route('pages.create') }}">
        <button type="button" class="btn btn-primary btn-fw">
            + Add Page
        </button>
    </a>

    <div class="table-responsive my-3">
        @if ($data->isNotEmpty())
            <table class="table table-stripped">
                <thead>
                    <tr>
                        <th class="col-1">No</th>
                        <th>Title</th>
                        <th class="col-3">Action</th>
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
                                <form action="{{ route('pages.destroy', $item->id) }}" class="d-inline" method="POST"
                                    id="deleteForm">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-fw" onclick="confirmDelete(event)">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="my-5">
                {{ $data->links() }}
            </div>
        @else
            <p class="mt-3">No data</p>
        @endif

    </div>

    <script>
        function confirmDelete(event) {
            event.preventDefault();

            Swal.fire({
                title: 'You are sure?',
                text: 'Data will be deleted',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm').submit();
                }
            });
        }
    </script>
@endsection
