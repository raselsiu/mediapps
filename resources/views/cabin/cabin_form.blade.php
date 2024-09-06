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
                <li class="breadcrumb-item active">Add Cabin No.</li>
            </ol>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title">Save Cabin</h1>
                </div>
                <form method="POST" action="{{ route('storeCabin') }}" id="userForm">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="cabin_no">Cabin No: </label>
                                <input type="text" class="form-control" name="cabin_no" id="cabin_no"
                                    placeholder="Enter your Cabin no.">
                                @if ($errors->has('cabin_no'))
                                    <span style="color: red">{{ $errors->first('cabin_no') }}</span>
                                @endif
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
            </div>
            </form>
        </div>
    </div>



    <?php
    
    $available = $cabin->where('status', 0)->count();
    $booked = $cabin->where('status', 1)->count();
    
    ?>

    <h3 class="cd">
        Cabin Detials
        <span class="breaking">
            <span style="color: green;font-size:12px">Available Cabin: {{ $available }}</span>
            <span style="color: red;font-size:12px">Booked Cabin: {{ $booked }}</span>
        </span>
    </h3>


    <div class="grid-container">
        @foreach ($cabin as $data)
            <div class="grid-item badge badge-warning {{ $data->status ? 'bk_clr' : '' }}">
                {{ Str::ucfirst($data->cabin_no) }}
                @if ($data->status == 0)
                    <br> <span class="available">Available</span>
                @else
                    <br> <span class="booked">Booked</span>
                @endif
            </div>
        @endforeach

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
                    cabin_no: {
                        required: true,
                    }
                },
                messages: {
                    cabin_no: {
                        required: "Cabin number is required!",
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
