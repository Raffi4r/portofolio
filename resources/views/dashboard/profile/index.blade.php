@extends('dashboard.layout')

@section('content')
    <form action="{{ route('profile.update') }}" method="POST" id="pageForm" enctype="multipart/form-data">
        @csrf
        <div class="row justify-content-between">
            <div class="col-md-4 grid-margin stretch-card">
                <div class="column">
                    <p class="card-title">Profile</p>
                    <div class="mb-3">
                        <img id="profile" class="img-thumbnail" alt="blank_profile.png"
                            style="width: 200px; height: 200px;"
                            src="{{ get_meta_value('photo') ? asset('admin') . '/images/profile/' . get_meta_value('photo') : asset('admin') . '/images/blank_profile.png' }}">
                    </div>
                    <div class="mb-3">
                        <label for="photo" class="form-label">Profile Picture<span style="color:red">*</span> :</label>
                        <input type="file" accept=".jpg,.jpeg,.png class="form-control form-control-md
                            @error('photo') is-invalid @enderror skill" name="photo"
                            value="{{ asset('admin') . '/images/profile/' . get_meta_value('photo') }}" id="photo">
                        <div id="photoError" class="error"></div>
                        @error('photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="province" class="form-label">Province<span style="color:red">*</span> :</label>
                        <input type="text"
                            class="form-control form-control-md @error('province') is-invalid @enderror skill"
                            name="province" value="{{ get_meta_value('province') }}" id="province" autocomplete="off">
                        <div id="provinceError" class="error"></div>
                        @error('province')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label">City<span style="color:red">*</span> :</label>
                        <input type="text" class="form-control form-control-md @error('city') is-invalid @enderror skill"
                            name="city" value="{{ get_meta_value('city') }}" id="city" autocomplete="off">
                        <div id="cityError" class="error"></div>
                        @error('city')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number<span style="color:red">*</span> :</label>
                        <input type="text"
                            class="form-control form-control-md @error('phone') is-invalid @enderror skill" name="phone"
                            value="{{ get_meta_value('phone') }}" id="phone" autocomplete="off">
                        <div id="phoneError" class="error"></div>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email<span style="color:red">*</span> :</label>
                        <input type="text"
                            class="form-control form-control-md @error('email') is-invalid @enderror skill" name="email"
                            value="{{ get_meta_value('email') }}" id="email" autocomplete="off">
                        <div id="emailError" class="error"></div>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card">
                <div class="column">
                    <p class="card-title">Social Media</p>
                    <div class="mb-3">
                        <label for="facebook" class="form-label">Facebook :</label>
                        <input type="text" class="form-control form-control-md" name="facebook" id="facebook"
                            value="{{ get_meta_value('facebook') }}" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="instagram" class="form-label">Instagram :</label>
                        <input type="text" class="form-control form-control-md" name="instagram" id="instagram"
                            value="{{ get_meta_value('instagram') }}" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="discord" class="form-label">Discord :</label>
                        <input type="text" class="form-control form-control-md" name="discord" id="discord"
                            value="{{ get_meta_value('discord') }}" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="twitter" class="form-label">Twitter :</label>
                        <input type="text" class="form-control form-control-md" name="twitter" id="twitter"
                            value="{{ get_meta_value('twitter') }}" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="linkedin" class="form-label">LinkedIn :</label>
                        <input type="text" class="form-control form-control-md" name="linkedin" id="linkedin"
                            value="{{ get_meta_value('linkedin') }}" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="github" class="form-label">Github :</label>
                        <input type="text" class="form-control form-control-md" name="github" id="github"
                            value="{{ get_meta_value('github') }}" autocomplete="off">
                    </div>
                </div>
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
            var photoInput = $('#photo');
            var validExtensions = ['jpg', 'jpeg', 'png']
            var provinceInput = $('#province');
            var cityInput = $('#city');
            var phoneInput = $('#phone');
            var emailInput = $('#email');
            var pageForm = $('#pageForm');

            photoInput.on('change', function(event) {
                var input = event.target;
                var preview = $('#profile');

                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        preview.attr('src', e.target.result);
                        preview.show();
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            });

            function toggleError(condition, errorId, errorMessage = '', addClass = '') {
                var errorElement = $('#' + errorId);
                if (condition) {
                    errorElement.text(errorMessage).addClass(addClass);
                } else {
                    errorElement.text('').removeClass(addClass);
                }
            }

            var inputElements = [phoneInput, provinceInput, cityInput, phoneInput, emailInput];
            inputElements.forEach(function(inputElement) {
                inputElement.on('input', function() {
                    var errorId = inputElement.attr('id') + 'Error';
                    toggleError(false, errorId, '', 'is-invalid');
                });
            });

            function validateForm() {
                var isValid = true;

                var fields = [{
                        input: provinceInput,
                        errorId: 'provinceError',
                        message: 'Province cannot be empty'
                    },
                    {
                        input: cityInput,
                        errorId: 'cityError',
                        message: 'City cannot be empty'
                    },
                    {
                        input: phoneInput,
                        errorId: 'phoneError',
                        message: 'Phone number cannot be empty'
                    },
                    {
                        input: emailInput,
                        errorId: 'emailError',
                        message: 'Email cannot be empty'
                    },
                ];

                fields.forEach(function(field) {
                    toggleError(field.input.val().trim() === '', field.errorId, field.message,
                        'is-invalid');
                    if (field.input.val().trim() === '') {
                        isValid = false;
                    }
                });

                if (isValid) {
                    toggleError(false, 'info1Error');
                    toggleError(false, 'titleError');
                    toggleError(false, 'date_startError');
                    toggleError(false, 'date_endError');
                }

                var srcValue = $('#profile').attr('src');
                var file = photoInput[0].files[0];

                if (srcValue === "{{ asset('admin') }}/images/blank_profile.png") {
                    if (!file) {
                        toggleError(true, 'photoError', 'Photo cannot be empty', 'is-invalid');
                        isValid = false;
                    } else {
                        var fileExtension = file.name.split('.').pop().toLowerCase();
                        if (!validExtensions.includes(fileExtension)) {
                            toggleError(true, 'photoError',
                                'Only .jpg, .jpeg, and .png files are allowed', 'is-invalid');
                            isValid = false;
                        } else {
                            toggleError(false, 'photoError', '', 'is-invalid');
                        }
                    }
                }

                var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (emailInput.val() != '') {
                    if (!emailRegex.test(emailInput.val())) {
                        toggleError(true, 'emailError',
                            'Invalid email format');
                        isValid = false;
                    } else {
                        toggleError(false, 'emailError', '', 'is-invalid');
                    }
                }

                return isValid;
            }

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
        });
    </script>
@endsection
