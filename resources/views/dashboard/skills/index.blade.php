@extends('dashboard.layout')

@section('content')
    <p class="card-title">Skills</p>

    <form action="{{ route('skills.update') }}" method="POST" id="pageForm">
        @csrf
        <div class="mb-3">
            <label for="languages" class="form-label">Programming Languages & Tools<span style="color:red">*</span> :</label>
            <input type="text" class="form-control form-control-md @error('languages') is-invalid @enderror skill"
                name="languages" id="languages" aria-describedby="helpId" data-validation="required"
                value="{{ get_meta_value('languages') }}" autocomplete="off">
            <div id="languagesError" class="error"></div>
            @error('languages')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="workflow" class="form-label">Workflow<span style="color:red">*</span> :</label>
            <textarea class="ckeditor" rows="5" name="workflow" id="editor" data-validation="required">{{ get_meta_value('workflow') }}</textarea>
            <div id="workflowError" class="error"></div>
            @error('workflow')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button class="btn btn-primary btn-fw">
            Save
        </button>
    </form>
@endsection

@section('script')
    <script>
        $(function() {
            var editor = null;
            var languagesInput = $('#languages');
            var pageForm = $('#pageForm');

            ClassicEditor.create($('#editor')[0])
                .then(function(myEditor) {
                    editor = myEditor;
                    editor.model.document.on('change:data', function() {
                        var content = editor.getData();
                        if (content) {
                            hideError('workflowError');
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

            languagesInput.on('input', function() {
                hideError('languagesError');
                languagesInput.removeClass('is-invalid');
            });

            function validateForm() {
                var isValid = true;

                if (languagesInput.val().trim() === '') {
                    showError('Languages cannot be empty', 'languagesError');
                    languagesnput.addClass('is-invalid');
                    isValid = false;
                }

                if (!editor.getData()) {
                    showError('Workflow cannot be empty', 'workflowError');
                    isValid = false;
                }

                if (isValid) {
                    hideError('languagesError');
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

    @push('child-scripts')
        <script>
            $(document).ready(function() {
                $('.skill').tokenfield({
                    autocomplete: {
                        source: [{!! $skill !!}],
                        delay: 100
                    },
                    showAutocompleteOnFocus: true
                });
            });
        </script>
    @endpush
@endsection
