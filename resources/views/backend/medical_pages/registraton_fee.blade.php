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
                <li class="breadcrumb-item active">Patient Registration</li>
            </ol>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title">Registration Form</h1>
                </div>
                <form method="POST" action="{{ route('storeRegistration') }}" id="userForm">
                    @csrf
                    <input type="text" hidden name="indoor_registration_fee" value="Indoor Registration">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="name">Name: </label>
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="Patient Name....">
                                @if ($errors->has('name'))
                                    <span style="color: red">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label for="address">Address: </label>
                                <input type="text" class="form-control" id="address" name="address"
                                    placeholder="Patient Address...." />
                                @if ($errors->has('address'))
                                    <span style="color: red">{{ $errors->first('address') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="row">

                            <div class="form-group col-md-4">
                                <label for="cabin_no">Cabin No.: -</label>
                                <input type="text" class="form-control" name="cabin_no" id="cabin_no"
                                    placeholder="Cabin No....">
                                @if ($errors->has('cabin_no'))
                                    <span style="color: red">{{ $errors->first('cabin_no') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label for="regi_no">Regi. No: - </label>
                                <input type="text" class="form-control" id="regi_no" name="regi_no"
                                    placeholder="Regi No. - ....">
                                @if ($errors->has('regi_no'))
                                    <span style="color: red">{{ $errors->first('regi_no') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label for="regi_fee">Registration Fee: - </label>
                                <input type="number" class="form-control" id="regi_fee" name="regi_fee"
                                    placeholder="Amount - ....">
                                @if ($errors->has('regi_fee'))
                                    <span style="color: red">{{ $errors->first('regi_fee') }}</span>
                                @endif
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Confim</button>
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
