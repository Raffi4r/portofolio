@extends('dashboard.layout')

@section('content')
    <p class="card-title">Add Experience</p>

    <form action="{{ route('experiences.store') }}" method="POST" id="expForm">
        @csrf
        <div class="mb-3">
            <label for="info1" class="form-label">Company<span style="color:red">*</span> :</label>
            <input type="text" class="form-control form-control-md @error('info1') is-invalid @enderror" name="info1"
                id="info1" aria-describedby="helpId" placeholder="Company" value="{{ Session::get('info1') }}">
            <div id="info1Error" class="error"></div>
            @error('info1')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="title" class="form-label">Position<span style="color:red">*</span> :</label>
            <input type="text" class="form-control form-control-md @error('title') is-invalid @enderror" name="title"
                id="title" aria-describedby="helpId" placeholder="Position" value="{{ Session::get('title') }}">
            <div id="titleError" class="error"></div>
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="row">
            <div class="col-md-4 grid-margin stretch-card">
                <div class="column">
                    <label for="info1" class="form-label">Start Date<span style="color:red">*</span> :</label>
                    <div>
                        <input type="date" class="form-control form-control-sm @error('date_start') is-invalid @enderror"
                            name="date_start" id="date_start" onkeydown="return false">
                        <div id="date_startError" class="error"></div>
                        @error('date_start')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card">
                <div class="column">
                    <label for="info1" class="form-label">End Date<span style="color:red">*</span> : </label>
                    <div class="col-auto">
                        <input type="date" class="form-control form-control-sm @error('date_end') is-invalid @enderror"
                            id="date_end" name="date_end" onkeydown="return false">
                        <input type="checkbox" id="present" name="present" value="present">
                        <label for="disable_date_end">Present</label>
                        <div id="date_endError" class="error"></div>
                        @error('date_end')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description<span style="color:red">*</span> :</label>
            <textarea class="ckeditor" rows="5" name="description" id="editor" data-validation="required">{{ Session::get('description') }}</textarea>
            <div id="descriptionError" class="error"></div>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
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

@section('script')
    <script>
        $(function() {
            var expForm = $('#expForm');
            var info1Input = $('#info1');
            var titleInput = $('#title');
            var date_startInput = $('#date_start');
            var date_endInput = $('#date_end');
            var presentInput = $('input[name="present"]');
            var myEditor = $('#editor')[0];

            ClassicEditor
                .create(myEditor)
                .then(function(editor) {
                    myEditor = editor;
                    myEditor.model.document.on('change:data', function() {
                        var content = editor.getData();
                        toggleError(content === '', 'descriptionError', 'Description cannot be empty',
                            'is-invalid');
                    });
                })
                .catch(function(err) {
                    console.error(err.stack);
                });

            function toggleError(condition, errorId, errorMessage = '', addClass = '') {
                var errorElement = $('#' + errorId);
                if (condition) {
                    errorElement.text(errorMessage).addClass(addClass);
                } else {
                    errorElement.text('').removeClass(addClass);
                }
            }

            var inputElements = [info1Input, titleInput, date_startInput, date_endInput];
            inputElements.forEach(function(inputElement) {
                inputElement.on('input', function() {
                    var errorId = inputElement.attr('id') + 'Error';
                    toggleError(false, errorId, '', 'is-invalid');
                    if (inputElement === date_startInput) {
                        setEndDate();
                    }
                });
            });

            function validateForm() {
                var isValid = true;

                var fields = [{
                        input: info1Input,
                        errorId: 'info1Error',
                        message: 'Company cannot be empty'
                    },
                    {
                        input: titleInput,
                        errorId: 'titleError',
                        message: 'Position cannot be empty'
                    },
                    {
                        input: date_startInput,
                        errorId: 'date_startError',
                        message: 'Start date cannot be empty'
                    }
                ];

                fields.forEach(function(field) {
                    toggleError(field.input.val().trim() === '', field.errorId, field.message,
                        'is-invalid');
                    if (field.input.val().trim() === '') {
                        isValid = false;
                    }
                });

                if (!presentInput.prop('checked')) {
                    toggleError(date_endInput.val().trim() === '', 'date_endError', 'End date cannot be empty',
                        'is-invalid');
                    if (date_endInput.val().trim() !== '' && date_endInput.val().trim() < date_startInput.val()
                        .trim()) {
                        toggleError(true, 'date_endError', 'End date must be greater than or equal to start date',
                            'is-invalid');
                        isValid = false;
                    }
                }

                if (myEditor.getData() === '') {
                    toggleError(true, 'descriptionError', 'Description cannot be empty', 'is-invalid');
                    isValid = false;
                }

                if (isValid) {
                    toggleError(false, 'info1Error');
                    toggleError(false, 'titleError');
                    toggleError(false, 'date_startError');
                    toggleError(false, 'date_endError');
                }

                return isValid;
            }

            function setEndDate() {
                date_endInput.attr('min', date_startInput.val());
                if (date_endInput.val() < date_startInput.val()) {
                    date_endInput.val('');
                }
            }

            presentInput.on('click', function() {
                date_endInput.removeClass('is-invalid');
            });

            presentInput.on('change', function() {
                date_endInput.prop('disabled', presentInput.prop('checked')).val('');
                toggleError(false, 'date_endError');
            });

            expForm.on('submit', function(event) {
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
                            expForm.off('submit').submit();
                        }
                    });
                }
            });
        });
    </script>
@endsection
