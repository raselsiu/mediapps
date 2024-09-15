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
                <li class="breadcrumb-item active">Outdoor Service</li>
            </ol>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title">Add Outdoor Service</h1>

                </div>
                <form method="POST" action="{{ route('outdoorServiceStore') }}" id="userForm">
                    @csrf
                    {{-- <input type="text" hidden name="indoor_registration_fee" value="Indoor Registration"> --}}
                    <div class="card-body">
                        <div class="row">


                            <div class="form-group col-md-12">
                                <label for="name" class="required">Service Name: </label>
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="Add a service">
                                @if ($errors->has('name'))
                                    <span style="color: red">{{ $errors->first('name') }}</span>
                                @endif
                            </div>

                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
            </div>
            </form>
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
                    }
                },
                messages: {
                    name: {
                        required: "Service name required!",
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
