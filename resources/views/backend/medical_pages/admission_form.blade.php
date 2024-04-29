@extends('backend.layouts.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('backend/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush



@section('content')
    <div class="row mb-2">
        <div class="col-sm-6">
            {{-- <h1>Patients Registration</h1> --}}
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Patient Admission</li>
            </ol>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title">Patient Admission Form</h1>
                </div>
                <form method="POST" action="{{ route('admission_form_save') }}" id="userForm">
                    @csrf

                    {{-- <input type="hidden" name="uuid" value="{{ $uuid }}"> --}}

                    <input type="text" hidden name="registration_fee" value="registration_fee">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="name">Patient Name: </label>
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="Patient Name....">
                                @if ($errors->has('name'))
                                    <span style="color: red">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-2">
                                <label for="age">Age: </label>
                                <input type="text" class="form-control" id="age" name="age"
                                    placeholder="Age...." />
                                @if ($errors->has('age'))
                                    <span style="color: red">{{ $errors->first('age') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-3">
                                <label for="father_or_husb_name">Father/Husband Name: </label>
                                <input type="text" class="form-control" id="father_or_husb_name"
                                    name="father_or_husb_name" placeholder="Father or Husband Name...." />
                                @if ($errors->has('father_or_husb_name'))
                                    <span style="color: red">{{ $errors->first('father_or_husb_name') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-3">
                                <label for="mother_name">Mother Name: </label>
                                <input type="text" class="form-control" id="mother_name" name="mother_name"
                                    placeholder="Mother Name...." />
                                @if ($errors->has('mother_name'))
                                    <span style="color: red">{{ $errors->first('mother_name') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="addr_area">
                                    <div class="form-group col-md-12">
                                        <label for="permanent_address">Permanent Address: </label>
                                        <input type="text" class="form-control" name="permanent_address"
                                            id="permanent_address" placeholder="Permanent Address....">
                                        @if ($errors->has('permanent_address'))
                                            <span style="color: red">{{ $errors->first('permanent_address') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="pa_village">Village: </label>
                                        <input type="text" class="form-control" name="pa_village" id="pa_village"
                                            placeholder="Village....">
                                        @if ($errors->has('pa_village'))
                                            <span style="color: red">{{ $errors->first('pa_village') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="pa_post_code">Post Office: </label>
                                        <input type="text" class="form-control" name="pa_post_code" id="pa_post_code"
                                            placeholder="Post Office....">
                                        @if ($errors->has('pa_post_code'))
                                            <span style="color: red">{{ $errors->first('pa_post_code') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="pa_thana">Thana: </label>
                                        <input type="text" class="form-control" name="pa_thana" id="pa_thana"
                                            placeholder="Thana....">
                                        @if ($errors->has('pa_thana'))
                                            <span style="color: red">{{ $errors->first('pa_thana') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="pa_district">District: </label>
                                        <input type="text" class="form-control" name="pa_district" id="pa_district"
                                            placeholder="District....">
                                        @if ($errors->has('pa_district'))
                                            <span style="color: red">{{ $errors->first('pa_district') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="addr_area">
                                    <div class="form-group col-md-12">
                                        <label for="present_address">Present Address: </label>
                                        <input type="text" class="form-control" name="present_address"
                                            id="present_address" placeholder="Present Address....">
                                        @if ($errors->has('present_address'))
                                            <span style="color: red">{{ $errors->first('present_address') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="pre_village">Village: </label>
                                        <input type="text" class="form-control" name="pre_village" id="pre_village"
                                            placeholder="Village....">
                                        @if ($errors->has('pre_village'))
                                            <span style="color: red">{{ $errors->first('pre_village') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="pre_post_code">Post Office: </label>
                                        <input type="text" class="form-control" name="pre_post_code"
                                            id="pre_post_code" placeholder="Post Office....">
                                        @if ($errors->has('pre_post_code'))
                                            <span style="color: red">{{ $errors->first('pre_post_code') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="pre_thana">Thana: </label>
                                        <input type="text" class="form-control" name="pre_thana" id="pre_thana"
                                            placeholder="Thana....">
                                        @if ($errors->has('pre_thana'))
                                            <span style="color: red">{{ $errors->first('pre_thana') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="pre_district">District: </label>
                                        <input type="text" class="form-control" name="pre_district" id="pre_district"
                                            placeholder="District....">
                                        @if ($errors->has('pre_district'))
                                            <span style="color: red">{{ $errors->first('pre_district') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <br>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="mobile">Mobile: </label>
                                <input type="text" class="form-control" name="mobile" id="mobile"
                                    placeholder="Mobile Number....">
                                @if ($errors->has('mobile'))
                                    <span style="color: red">{{ $errors->first('mobile') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label for="admission_date">Admission Date: </label>
                                <input type="date" class="form-control" name="admission_date" id="admission_date"
                                    placeholder="Admission Date....">
                                @if ($errors->has('admission_date'))
                                    <span style="color: red">{{ $errors->first('admission_date') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label for="admission_time">Admission Time: </label>
                                <input type="time" class="form-control" name="admission_time" id="admission_time"
                                    placeholder="Admission Time....">
                                @if ($errors->has('admission_time'))
                                    <span style="color: red">{{ $errors->first('admission_time') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label for="disease_name">Disease Name: </label>
                                <input type="text" class="form-control" name="disease_name" id="disease_name"
                                    placeholder="Disease Name....">
                                @if ($errors->has('disease_name'))
                                    <span style="color: red">{{ $errors->first('disease_name') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label for="doctor_name">Doctor Name: </label>
                                <input type="text" class="form-control" name="doctor_name" id="doctor_name"
                                    placeholder="Doctor Name....">
                                @if ($errors->has('doctor_name'))
                                    <span style="color: red">{{ $errors->first('doctor_name') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label for="cabin_no">Cabin No: </label>
                                <input type="text" class="form-control" name="cabin_no" id="cabin_no"
                                    placeholder="Cabin Number....">
                                @if ($errors->has('cabin_no'))
                                    <span style="color: red">{{ $errors->first('cabin_no') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="addr_area">
                                    <div class="form-group col-md-12">
                                        <label for="date_of_leave">Date Of Leave: </label>
                                        <input type="date" class="form-control" name="date_of_leave"
                                            id="date_of_leave" placeholder="Cabin Number....">
                                        @if ($errors->has('date_of_leave'))
                                            <span style="color: red">{{ $errors->first('date_of_leave') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="leave_time">Time: </label>
                                        <input type="time" class="form-control" name="leave_time" id="leave_time"
                                            placeholder="Cabin Number....">
                                        @if ($errors->has('leave_time'))
                                            <span style="color: red">{{ $errors->first('leave_time') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>

                        <button type="submit" class="btn btn-primary">Admit Patient</button>
                    </div>
            </div>
            </form>
        </div>
    </div>
    </div>
@endsection


@push('js')
    <script src="{{ asset('backend/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/jquery-validation/additional-methods.min.js') }}"></script>

    <script>
        $(function() {
            $('.custom-select').select2()

        });
    </script>


    <script>
        $(function() {
            $('#userForm').validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 50,
                    }
                },
                messages: {
                    name: {
                        required: "Please enter name",
                        maxlength: "Your password must be not greater then 50 characters long"
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endpush
