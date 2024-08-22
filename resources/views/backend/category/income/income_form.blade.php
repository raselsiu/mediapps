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
                <li class="breadcrumb-item"><a href="#">Data Entry</a></li>
                <li class="breadcrumb-item active">Income</li>
            </ol>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title">Add Daily Income</h1>

                </div>
                <form method="POST" action="{{ route('storeIncomeForm') }}" id="userForm">
                    @csrf
                    {{-- <input type="text" hidden name="indoor_registration_fee" value="Indoor Registration"> --}}
                    <div class="card-body">
                        <div class="row">



                            <div class="form-group col-md-6">
                                <label>Select Category</label>
                                <select class="custom-select" name="category" id="category_name">
                                    <option value="">Select Category</option>
                                    @foreach ($data as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('category'))
                                    <span style="color: red">{{ $errors->first('category') }}</span>
                                @endif
                            </div>


                            <div class="form-group col-md-6">
                                <label>Select Sub Category</label>
                                <select class="custom-select" name="sub_category" id="sub_category"></select>
                                @if ($errors->has('sub_category'))
                                    <span style="color: red">{{ $errors->first('sub_category') }}</span>
                                @endif
                            </div>


                            <div class="form-group col-md-6">
                                <label for="amount">Amount: </label>
                                <input type="text" class="form-control" name="amount" id="amount"
                                    placeholder="Income Amount">
                                @if ($errors->has('amount'))
                                    <span style="color: red">{{ $errors->first('amount') }}</span>
                                @endif
                            </div>


                            <div class="form-group col-md-12">
                                <label for="amount">Take a note: </label>
                                <textarea class="form-control" name="description" id="description" cols="5" rows="5"
                                    placeholder="Write something"></textarea>
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
                    category: {
                        required: true,
                    },
                    sub_category: {
                        required: true,
                    },
                    amount: {
                        required: true,
                    }
                },
                messages: {
                    category: {
                        required: "Field is required!",
                    },
                    sub_category: {
                        required: "Field is required!",
                    },
                    amount: {
                        required: "Field is required!",
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







    <script>
        $(document).ready(function() {
            $('#category_name').on('change', function() {
                let id = $(this).val();
                $('#sub_category').empty();
                $('#sub_category').append(`<option value="0" disabled selected>Processing...</option>`);
                $.ajax({
                    type: 'GET',
                    url: '/data-entry/get_subcategory/income/' + id,
                    success: function(response) {
                        var response = JSON.parse(response);
                        console.log(response);
                        $('#sub_category').empty();
                        $('#sub_category').append(
                            `<option value="0" disabled selected>Select Sub Category*</option>`
                        );
                        response.forEach(element => {
                            $('#sub_category').append(
                                `<option value="${element['subcategory']}">${element['subcategory']}</option>`
                            );
                        });
                    }
                });
            });
        });
    </script>
@endpush
