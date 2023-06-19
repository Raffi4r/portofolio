@extends('dashboard.layout')

@section('content')
    <p class="card-title">Add Page</p>

    <form action="{{ route('pages.store') }}" method="POST" id="pageForm">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title<span style="color:red">*</span> :</label>
            <input type="text" class="form-control form-control-md @error('title') is-invalid @enderror" name="title"
                id="title" aria-describedby="helpId" placeholder="Title" value="{{ Session::get('title') }}"
                data-validation="required">
            <div id="titleError" class="error"></div>
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description<span style="color:red">*</span> :</label>
            <textarea class="ckeditor" rows="5" name="description" id="editor" data-validation="required">{{ Session::get('description') }}</textarea>
            <div id="descriptionError" class="error"></div>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <a href="{{ route('pages.index') }}" class="btn btn-secondary btn-fw">
            Back
        </a>
        <span class="mx-2"></span>
        <button class="btn btn-primary btn-fw">
            Save
        </button>
    </form>
@endsection

@section('script')
    <script>
        $(function() {
            var editor = null;
            var titleInput = $('#title');
            var pageForm = $('#pageForm');

            ClassicEditor.create($('#editor')[0])
                .then(function(myEditor) {
                    editor = myEditor;
                    editor.model.document.on('change:data', function() {
                        var content = editor.getData();
                        if (content) {
                            hideError('descriptionError');
                        }
                    });
                })
                .catch(function(err) {
                    console.log(err.stack);
                });

            pageForm.on('submit', function(event) {
                event.preventDefault();

                if (validateForm()) {
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
                }
            });

            titleInput.on('input', function() {
                hideError('titleError');
                titleInput.removeClass('is-invalid');
            });

            function validateForm() {
                var isValid = true;

                if (titleInput.val().trim() === '') {
                    showError('Title cannot be empty', 'titleError');
                    titleInput.addClass('is-invalid');
                    isValid = false;
                }

                if (!editor.getData()) {
                    showError('Description cannot be empty', 'descriptionError');
                    isValid = false;
                }

                if (isValid) {
                    hideError('titleError');
                }

                return isValid;
            }

            function showError(errorMessage, errorId) {
                $('#' + errorId).text(errorMessage);
            }

            function hideError(errorId) {
                $('#' + errorId).text('');
            }
        });
    </script>
@endsection
