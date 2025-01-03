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
                <li class="breadcrumb-item active">Service Entry</li>
            </ol>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title">Service Entry</h1>
                    <a href="{{ route('all_out_regi_patient') }}" class="float-right btn btn-success"> <i
                            class="fa fa-eye"></i> Service List</a>
                </div>
                <form method="POST" action="{{ route('storeOutdoor_regi_form') }}" id="userForm">
                    @csrf
                    <input type="text" hidden name="outdoor_registration_fee" value="Outdoor Registration Fee">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="name" class="required">Name: </label>
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="Name....">
                                @if ($errors->has('name'))
                                    <span style="color: red">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label for="address" class="required">Address: </label>
                                <input type="text" class="form-control" id="address" name="address"
                                    placeholder="Address...." />
                                @if ($errors->has('address'))
                                    <span style="color: red">{{ $errors->first('address') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="row">

                            <div class="form-group col-md-4">
                                <label for="regi_fee" class="required">Service Fee: </label>
                                <input type="number" class="form-control" id="regi_fee" name="regi_fee"
                                    placeholder="Amount ....">
                                @if ($errors->has('regi_fee'))
                                    <span style="color: red">{{ $errors->first('regi_fee') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-4 col-lg-4 col-sm-4">
                                <label for="category" class="required">Service Category: </label>
                                &nbsp;&nbsp;&nbsp;&nbsp;<label for="category" class="service_btn"> <a
                                        href="{{ route('outdoorServiceView') }}">Create a
                                        Service</a></label>
                                <select class="custom-select" name="service_category" id="service_category">
                                    <option value="">Select a service</option>

                                    @foreach ($service as $data)
                                        <option value="{{ $data->name }}">{{ $data->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('service_category'))
                                    <span style="color: red">{{ $errors->first('service_category') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-6 col-lg-6 col-sm-6">
                                <label for="category">Add Extra Service (If Any) Separated By Comma</label>
                                <textarea name="extra_service" id="extra_service" class="form-control" cols="5" rows="2"></textarea>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Save</button>
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
                    },
                    regi_fee: {
                        required: true,
                        maxlength: 50,
                    },
                    service_category: {
                        required: true,
                        maxlength: 50,
                    },
                },
                messages: {
                    name: {
                        required: "Please enter name",
                        maxlength: "Your password must be not greater then 50 characters long"
                    },
                    regi_fee: {
                        required: "Please enter Amount",
                    },
                    service_category: {
                        required: "Select a category",
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
