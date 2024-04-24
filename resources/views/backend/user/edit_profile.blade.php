@extends('backend.layouts.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('backend/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@section('content')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Manage Profile</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Profile</li>
            </ol>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title">Edit Profile</h1>
                    <a href="{{ route('profileView') }}" class="float-right btn btn-sm btn-success"> <i
                            class="fa fa-user"></i>
                        &nbsp;View Profile</a>
                </div>
                <form method="post" action="{{ route('profileUpdate', $user->id) }}" id="userForm"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                        <div class="form-group">
                            <img id="showImg"
                                src="{{ empty($user->image) ? asset('backend/img/uploads/no_img.png') : asset('backend/img/uploads/' . $user->image) }}"
                                alt=""
                                style="height: 80px; width: 80px; border: 1px solid #a8a3a3; border-radius: 50%">
                        </div>


                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="exampleInputFile">Choose Profile Picture</label>
                                <div class="input-group">
                                    <input type="file" class="form-control" name="image" id="image">

                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" value="{{ $user->name }}" name="name"
                                    id="name" placeholder="Enter name">
                                @if ($errors->has('name'))
                                    <span style="color: red">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" value="{{ $user->email }}" id="email"
                                    name="email" placeholder="Enter email">
                                @if ($errors->has('email'))
                                    <span style="color: red">{{ $errors->first('email') }}</span>
                                @endif
                            </div>


                            <div class="form-group col-md-4">
                                <label for="email">Mobile No.</label>
                                <input type="text" class="form-control" value="{{ $user->mobile }}" id="mobile"
                                    name="mobile" placeholder="Phone Number">
                                @if ($errors->has('mobile'))
                                    <span style="color: red">{{ $errors->first('mobile') }}</span>
                                @endif
                            </div>

                        </div>
                        <div class="row">

                            <div class="form-group col-md-4">
                                <label for="email">Address</label>
                                <input type="text" class="form-control" value="{{ $user->address }}" id="address"
                                    name="address" placeholder="Address">
                                @if ($errors->has('address'))
                                    <span style="color: red">{{ $errors->first('address') }}</span>
                                @endif
                            </div>


                            <div class="form-group col-md-4">
                                <label for="gender">Gender</label>
                                <select class="custom-select rounded-0" name="gender" id="gender">
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ $user->gender == 'Male' ? 'selected' : '' }}>Male
                                    </option>
                                    <option value="Female" {{ $user->gender == 'Female' ? 'selected' : '' }}>Female
                                    </option>
                                </select>
                                @if ($errors->has('user_role'))
                                    <span style="color: red">{{ $errors->first('user_role') }}</span>
                                @endif
                            </div>



                        </div>

                        <button type="submit" class="btn btn-success">Update Profile</button>

                    </div>


                </form>
            </div>
            <!-- /.card-body -->



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
            //Initialize Select2 Elements
            $('.custom-select').select2()

        });
    </script>


    <script>
        $(function() {
            // $.validator.setDefaults({
            //     submitHandler: function() {
            //         alert("Form successful submitted!");
            //     }
            // });
            $('#userForm').validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 50,
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    gender: {
                        required: true
                    },
                },
                messages: {
                    name: {
                        required: "Please enter name",
                        maxlength: "Your password must be not greater then 50 characters long"
                    },
                    email: {
                        required: "Please enter a email address",
                        email: "Please enter a valid email address"
                    },
                    gender: {
                        required: "Please select gender",
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
