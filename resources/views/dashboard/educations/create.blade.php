@extends('dashboard.layout')

@section('content')
    <p class="card-title">Add Education</p>

    <form action="{{ route('educations.store') }}" method="POST" id="expForm">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">University<span style="color:red">*</span> :</label>
            <input type="text" class="form-control form-control-md @error('title') is-invalid @enderror" name="title"
                id="title" aria-describedby="helpId" placeholder="University">
            <div id="titleError" class="error"></div>
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="info1" class="form-label">Faculty<span style="color:red">*</span> :</label>
            <input type="text" class="form-control form-control-md @error('info1') is-invalid @enderror" name="info1"
                id="info1" aria-describedby="helpId" placeholder="Faculty">
            <div id="info1Error" class="error"></div>
            @error('info1')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="info2" class="form-label">Major<span style="color:red">*</span> :</label>
            <input type="text" class="form-control form-control-md @error('info2') is-invalid @enderror" name="info2"
                id="info2" aria-describedby="helpId" placeholder="Major">
            <div id="info2Error" class="error"></div>
            @error('info2')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="info3" class="form-label">GPA<span style="color:red">*</span> :</label>
            <input type="text" class="form-control form-control-md @error('info3') is-invalid @enderror" name="info3"
                id="info3" aria-describedby="helpId" placeholder="GPA (max 4.00)">
            <div id="info3Error" class="error"></div>
            @error('info3')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="row">
            <div class="col-md-4 grid-margin stretch-card">
                <div class="column">
                    <label for="date_start" class="form-label">Start Date<span style="color:red">*</span> :</label>
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
                    <label for="date_end" class="form-label">End Date<span style="color:red">*</span> : </label>
                    <div class="col-auto">
                        <input type="date" class="form-control form-control-sm @error('date_end') is-invalid @enderror"
                            id="date_end" name="date_end" onkeydown="return false">
                        <div id="date_endError" class="error"></div>
                        @error('date_end')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <a href="{{ route('educations.index') }}" class="btn btn-secondary btn-fw">
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
            var titleInput = $('#title');
            var info1Input = $('#info1');
            var info2Input = $('#info2');
            var info3Input = $('#info3');
            var date_startInput = $('#date_start');
            var date_endInput = $('#date_end');

            function toggleError(condition, errorId, errorMessage = '', addClass = '') {
                var errorElement = $('#' + errorId);
                if (condition) {
                    errorElement.text(errorMessage).addClass(addClass);
                } else {
                    errorElement.text('').removeClass(addClass);
                }
            }

            var inputElements = [titleInput, info1Input, info2Input, info3Input, date_startInput, date_endInput];
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
                        input: titleInput,
                        errorId: 'titleError',
                        message: 'University cannot be empty'
                    },
                    {
                        input: info1Input,
                        errorId: 'info1Error',
                        message: 'Faculty cannot be empty'
                    },
                    {
                        input: info2Input,
                        errorId: 'info2Error',
                        message: 'Major cannot be empty'
                    },
                    {
                        input: info3Input,
                        errorId: 'info3Error',
                        message: 'GPA cannot be empty'
                    },
                    {
                        input: date_startInput,
                        errorId: 'date_startError',
                        message: 'Start date cannot be empty'
                    },
                    {
                        input: date_endInput,
                        errorId: 'date_endError',
                        message: 'End date cannot be empty'
                    }
                ];

                fields.forEach(function(field) {
                    toggleError(field.input.val().trim() === '', field.errorId, field.message,
                        'is-invalid');
                    if (field.input.val().trim() === '') {
                        isValid = false;
                    }
                });

                if (isValid) {
                    toggleError(false, 'titleError');
                    toggleError(false, 'info1Error');
                    toggleError(false, 'info2Error');
                    toggleError(false, 'info3Error');
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
