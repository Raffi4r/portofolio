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
        <button type="submit" class="btn btn-primary btn-fw">
            Save
        </button>
    </form>

    <script>
        var myEditor;
        var form = document.getElementById('pageForm');
        var titleInput = document.getElementById('title');

        ClassicEditor
            .create(document.querySelector('#editor'))
            .then(editor => {
                myEditor = editor;
                myEditor.model.document.on('change:data', () => {
                    var content = editor.getData();
                    if (content != '') {
                        hideError('descriptionError');
                    }
                });
            })
            .catch(err => {
                console.error(err.stack);
            });

        form.addEventListener('submit', function(event) {
            event.preventDefault();

            if (validateForm()) {
                Swal.fire({
                    title: 'You are sure?',
                    text: 'Data will be saved',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            }
        });

        titleInput.addEventListener('input', function() {
            hideError('titleError');
            titleInput.classList.remove('is-invalid');
        });

        function validateForm() {
            var title = titleInput.value.trim();

            var isValid = true;

            if (title === '') {
                showError('Title cannot be empty', 'titleError');
                titleInput.classList.add('is-invalid');
                isValid = false;
            }

            if (myEditor.getData() === '') {
                showError('Description cannot be empty', 'descriptionError');
                isValid = false;
            }

            if (isValid) {
                hideError('titleError');
            }

            return isValid;
        }

        function showError(errorMessage, errorId) {
            var errorDiv = document.getElementById(errorId);
            errorDiv.textContent = errorMessage;
        }

        function hideError(errorId) {
            var errorDiv = document.getElementById(errorId);
            errorDiv.textContent = '';
        }
    </script>
@endsection
