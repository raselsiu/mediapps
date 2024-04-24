@extends('backend.layouts.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('backend/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@section('content')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Profile Management</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Password</li>
            </ol>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title">Change Password</h1>
                    <a href="{{ route('profileView') }}" class="float-right btn btn-sm btn-success"> <i
                            class="fa fa-user"></i>
                        &nbsp;View Profile</a>
                </div>
                <form method="POST" action="{{ route('updatePassword') }}" id="userForm">
                    @csrf
                    <div class="card-body">


                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="current_password">Current Password</label>
                                <input type="password" class="form-control" name="current_password" id="current_password"
                                    placeholder="Enter Current Password">
                                {{-- @if ($errors->has('password'))
                                    <span style="color: red">{{ $errors->first('password') }}</span>
                                @endif --}}
                            </div>
                        </div>

                        <div class="row">

                            <div class="form-group col-md-6">
                                <label for="new_password">New Password</label>
                                <input type="password" class="form-control" name="new_password" id="new_password"
                                    placeholder="New Password">
                                @if ($errors->has('new_password'))
                                    <span style="color: red">{{ $errors->first('password') }}</span>
                                @endif
                            </div>

                            <div class="form-group col-md-6">
                                <label for="confirm_new_password">Confirm New Password</label>
                                <input type="password" class="form-control" name="confirm_new_password"
                                    id="confirm_new_password" placeholder="Confirm New Password">
                                @if ($errors->has('confirm_new_password'))
                                    <span style="color: red">{{ $errors->first('confirm_new_password') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                        </div>

                        <button type="submit" class="btn btn-primary">Update Password</button>

                    </div>



            </div>
            <!-- /.card-body -->


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
            //Initialize Select2 Elements
            $('.custom-select').select2()

        });
    </script>

    <script>
        $(function() {
            $('#userForm').validate({
                rules: {
                    current_password: {
                        required: true,
                        minlength: 8
                    },
                    new_password: {
                        required: true,
                        minlength: 8
                    },
                    confirm_new_password: {
                        required: true,
                        equalTo: '#new_password',
                    }
                },
                messages: {
                    current_password: {
                        required: "Please provide a current password",
                    },
                    new_password: {
                        required: "Please provide a new password",
                        minlength: "Your password must be at least 8 characters long"
                    },
                    confirm_new_password: {
                        required: "Re-type New Password",
                        equalTo: "Password does't match with new password"
                    },
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
