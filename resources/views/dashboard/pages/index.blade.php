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
            <table class="table table-stripped">
                <thead>
                    <tr>
                        <th class="col-1">No</th>
                        <th>Title</th>
                        <th class="col-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ $item->title }}</td>
                            <td>
                                <a href="{{ route('pages.edit', $item->id) }}" class="btn btn-warning btn-md">
                                    Edit
                                </a>
                                <form onsubmit="return confirm('Do you want to delete this page?')"
                                    action="{{ route('pages.destroy', $item->id) }}" class="d-inline" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-fw" name="submit">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php $i++; ?>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="mt-3">No data</p>
        @endif

    </div>
@endsection
