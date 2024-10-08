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

                    @if ($errors->has('regi_no'))
                        <span style="color: red">{{ $errors->first('regi_no') }}</span>
                    @endif

                    <input type="text" hidden name="registration_fee" value="registration_fee">
                    <div class="card-body">

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="name" class="required">Patient Name: </label>
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="Patient Name...." value="{{ old('name') }}">
                                @if ($errors->has('name'))
                                    <span style="color: red">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-2">
                                <label for="age" class="required">Age: </label>
                                <input type="text" class="form-control" id="age" name="age"
                                    placeholder="Age...." value="{{ old('age') }}" />
                                @if ($errors->has('age'))
                                    <span style="color: red">{{ $errors->first('age') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-3">
                                <label for="father_or_husb_name" class="required">Father/Husband Name: </label>
                                <input type="text" class="form-control" id="father_or_husb_name"
                                    name="father_or_husb_name" placeholder="Father or Husband Name...."
                                    value="{{ old('father_or_husb_name') }}" />
                                @if ($errors->has('father_or_husb_name'))
                                    <span style="color: red">{{ $errors->first('father_or_husb_name') }}</span>
                                @endif
                            </div>
                        </div>


                        <div class="addr_area">
                            <div class="row">
                                <div class="form-group col-md-4 col-sm-6 col-lg-4">
                                    <label for="present_address" class="required">Present Address: </label>
                                    <input type="text" class="form-control" name="present_address" id="present_address"
                                        placeholder="Present Address...." value="{{ old('present_address') }}">
                                    @if ($errors->has('present_address'))
                                        <span style="color: red">{{ $errors->first('present_address') }}</span>
                                    @endif
                                </div>
                                <div class="form-group col-md-4 col-sm-6 col-lg-4">
                                    <label for="pre_post_code">Post Office: </label>
                                    <input type="text" class="form-control" name="pre_post_code" id="pre_post_code"
                                        placeholder="Post Office...." value="{{ old('pre_post_code') }}">

                                </div>
                                <div class="form-group col-md-4 col-sm-6 col-lg-4">
                                    <label for="pre_thana" class="required">Thana: </label>
                                    <input type="text" class="form-control" name="pre_thana" id="pre_thana"
                                        placeholder="Thana...." value="{{ old('pre_thana') }}">
                                    @if ($errors->has('pre_thana'))
                                        <span style="color: red">{{ $errors->first('pre_thana') }}</span>
                                    @endif
                                </div>
                                <div class="form-group col-md-4 col-sm-6 col-lg-4">
                                    <label for="pre_district" class="required">District: </label>
                                    <input type="text" class="form-control" name="pre_district" id="pre_district"
                                        placeholder="District...." value="{{ old('pre_district') }}">
                                    @if ($errors->has('pre_district'))
                                        <span style="color: red">{{ $errors->first('pre_district') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <br>
                        <div class="row">

                            <div class="form-group col-md-3 col-lg-3 col-sm-3">
                                <label for="mobile" class="required">Mobile: </label>
                                <input type="text" class="form-control" name="mobile" id="mobile"
                                    placeholder="Mobile Number...." value="{{ old('mobile') }}">
                                @if ($errors->has('mobile'))
                                    <span style="color: red">{{ $errors->first('mobile') }}</span>
                                @endif
                            </div>

                            <div class="form-group col-md-3 col-lg-3 col-sm-3">
                                <label for="disease_name" class="required">Disease Name: </label>
                                <input type="text" class="form-control" name="disease_name" id="disease_name"
                                    placeholder="Disease Name...." value="{{ old('disease_name') }}">
                                @if ($errors->has('disease_name'))
                                    <span style="color: red">{{ $errors->first('disease_name') }}</span>
                                @endif
                            </div>

                            <div class="form-group col-md-3 col-lg-3 col-sm-3">
                                <label for="doctor_name" class="required">Doctor's Name: </label>
                                <input type="text" class="form-control" name="doctor_name" id="doctor_name"
                                    placeholder="Doctor Name...." value="{{ old('doctor_name') }}">
                                @if ($errors->has('doctor_name'))
                                    <span style="color: red">{{ $errors->first('doctor_name') }}</span>
                                @endif
                            </div>

                            <div class="form-group col-md-3 col-lg-3 col-sm-3">
                                <label for="category" class="required">Select Cabin No: </label>
                                <select class="custom-select" name="cabin_no" id="cabin_no">
                                    <option value="">Select Cabin</option>

                                    @foreach ($cabin_info as $cabin)
                                        <option value="{{ $cabin->cabin_no }}">{{ $cabin->cabin_no }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('cabin_no'))
                                    <span style="color: red">{{ $errors->first('cabin_no') }}</span>
                                @endif
                            </div>

                        </div>


                        <div class="addr_area">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="care_of" class="required">Reference: </label>
                                    <input type="text" class="form-control" name="care_of" id="care_of"
                                        placeholder="Enter Reference " value="{{ old('care_of') }}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="regi_fee" class="required">Registration Fee: </label>
                                    <input type="number" class="form-control" name="regi_fee" id="regi_fee"
                                        placeholder="Amount" value="{{ old('regi_fee') }}">
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
                    regular_date: {
                        required: true,
                    },
                    name: {
                        required: true,
                    },
                    age: {
                        required: true,
                    },
                    father_or_husb_name: {
                        required: true,
                    },
                    present_address: {
                        required: true,
                    },
                    pre_thana: {
                        required: true,
                    },
                    pre_district: {
                        required: true,
                    },
                    mobile: {
                        required: true,
                    },
                    disease_name: {
                        required: true,
                    },
                    doctor_name: {
                        required: true,
                    },
                    cabin_no: {
                        required: true,
                    },
                    care_of: {
                        required: true,
                    },
                    regi_fee: {
                        required: true,
                    },
                },
                messages: {
                    regular_date: {
                        required: 'Date required.',
                    },
                    name: {
                        required: 'Enter patient name',
                    },
                    age: {
                        required: 'Age',
                    },
                    father_or_husb_name: {
                        required: "Father or Husband name is requied",
                    },
                    present_address: {
                        required: 'Present Address',
                    },
                    pre_thana: {
                        required: "Field is required",
                    },
                    pre_district: {
                        required: 'Field is required',
                    },
                    mobile: {
                        required: 'Field is required',
                    },
                    disease_name: {
                        required: 'Field is required',
                    },
                    doctor_name: {
                        required: 'Field is required',
                    },
                    cabin_no: {
                        required: 'Field is required',
                    },
                    care_of: {
                        required: 'Field is required',
                    },
                    regi_fee: {
                        required: 'Field is required',
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
