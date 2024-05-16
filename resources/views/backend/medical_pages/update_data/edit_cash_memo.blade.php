@extends('backend.layouts.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('backend/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@section('content')
    <div class="row mb-2">
        <div class="col-sm-6"></div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Update Cash Memo</li>
            </ol>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Generate Cash-Memo for Patient ID: {{ $uuid }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="" method="POST" id="myForm">
                        @csrf


                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif




                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="name">Admission Date: </label>
                                <input type="date" class="form-control" name="admission_date"
                                    value="{{ $patient->created_at->format('Y-m-d') }}" placeholder="Admission Date....">
                                {{-- @if ($errors->has('name'))
                                    <span style="color: red">{{ $errors->first('name') }}</span>
                                @endif --}}
                            </div>

                            <div class="form-group col-md-4">
                                <label for="name">Leave Date: </label>
                                <input type="date" class="form-control" name="leave_date" placeholder="Leave Date....">
                                {{-- @if ($errors->has('name'))
                                    <span style="color: red">{{ $errors->first('name') }}</span>
                                @endif --}}
                            </div>

                            <div class="form-group col-md-4">
                                <label for="name">Name: </label>
                                <input type="text" class="form-control" value="{{ $patient->name }}" name="name"
                                    placeholder="Patient Name....">
                                {{-- @if ($errors->has('name'))
                                    <span style="color: red">{{ $errors->first('name') }}</span>
                                @endif --}}
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="name">Mobile No: </label>
                                <input type="text" class="form-control" name="mobile" value="{{ $patient->mobile }}"
                                    placeholder="Patient Mobile Number....">
                                {{-- @if ($errors->has('name'))
                                    <span style="color: red">{{ $errors->first('name') }}</span>
                                @endif --}}
                            </div>



                            <div class="form-group col-md-4">
                                <label for="name">Cabin No: </label>
                                <input type="text" class="form-control" name="cabin_no" value="{{ $patient->cabin_no }}"
                                    placeholder="Patient Cabin No. ....">
                                {{-- @if ($errors->has('name'))
                                    <span style="color: red">{{ $errors->first('name') }}</span>
                                @endif --}}
                            </div>

                            <div class="form-group col-md-4">
                                <label for="name">Regi No: </label>
                                <input type="text" class="form-control" value="{{ $patient->regi_no }}" name="regi_no"
                                    value="" placeholder="Regi. No....">
                                {{-- @if ($errors->has('name'))
                                    <span style="color: red">{{ $errors->first('name') }}</span>
                                @endif --}}
                            </div>
                            <div class="form-group col-md-6">
                                <label for="name">Address: </label>
                                <textarea class="form-control" name="address" id="address" cols="5" rows="2"
                                    placeholder="Patient Address Here...">{{ $patient->present_address }}, {{ $patient->pre_village }},{{ $patient->pre_post_code }},{{ $patient->pre_thana }}, {{ $patient->pre_district }}</textarea>
                                {{-- @if ($errors->has('name'))
                                    <span style="color: red">{{ $errors->first('name') }}</span>
                                @endif --}}
                            </div>
                        </div>






                        <table class="table table-bordered" id="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <input type="hidden" name="patient_uuid" value="{{ $uuid }}"
                                        id="patient_uuid">
                                    <td>
                                        <select class="custom-select form-control" name="description[]" id="description">
                                            <option value="">Select a service</option>
                                            @foreach ($service_list as $service)
                                                <option value="{{ $service->name }}">{{ $service->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('description'))
                                            <span style="color: red">{{ $errors->first('description') }}</span>
                                        @endif
                                    </td>

                                    <td>
                                        <input type="text" name="comments[]" placeholder="Add Some Notes.."
                                            class="form-control">

                                    </td>
                                    <td><input type="number" onchange="sumArrayValues()" name="amount[]"
                                            placeholder="Amount" class="form-control" required>
                                    </td>
                                </tr>



                                <button type="button" id="add" name="add" class="btn btn-success"><i
                                        class="fas fa-plus"></i></button>

                                {{-- <button type="button" onclick="sumArrayValues()">Get Array Values</button> --}}


                            </tbody>
                        </table>

                        <div class="account_area">
                            <div class="row ">
                                <div class="form-group col-md-4">
                                    <label for="name">Amount: </label>
                                    <input type="number" class="form-control" name="total_bill" id="total_bill"
                                        placeholder="Total Bill" required>
                                    {{-- @if ($errors->has('name'))
                                        <span style="color: red">{{ $errors->first('name') }}</span>
                                    @endif --}}
                                </div>

                            </div>


                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="name">Discount: </label>
                                    <input type="number" class="form-control" onchange="discountCount();"
                                        name="discount" id="discount" placeholder="Discount Amount">
                                    {{-- @if ($errors->has('name'))
                                        <span style="color: red">{{ $errors->first('name') }}</span>
                                    @endif --}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="name">Total Amount: </label>
                                    <input type="number" class="form-control" name="total_paid" id="total_paid"
                                        placeholder="Total Paid Amount">
                                    {{-- @if ($errors->has('name'))
                                        <span style="color: red">{{ $errors->first('name') }}</span>
                                    @endif --}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="name">Paid: </label>
                                    <input type="number" class="form-control" name="paid" id="paid"
                                        placeholder="Paid Amount">
                                    {{-- @if ($errors->has('name'))
                                        <span style="color: red">{{ $errors->first('name') }}</span>
                                    @endif --}}
                                </div>
                            </div>
                        </div>








                        <button type="sbumit" class="btn btn-success">Generate Cash-Memo</button>



                    </form>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <ul class="pagination pagination-sm m-0 float-right">
                        <li class="page-item generate_sign">Cash-Memo Generated By:
                            {{ Auth::user()->name }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
    <br>
@endsection

@push('js')
    <script>
        $('#add').click(function(e) {
            $('#table').append(
                `
                
                <tr>
                    <td>
                        <select class="custom-select form-control" name="description[]" id="description">
                            <option value="">Select a service</option>
                            @foreach ($service_list as $service)
                                <option value="{{ $service->name }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="text" name="comments[]" placeholder="Add Some Notes.." class="form-control">
                    </td>
                    <td><input type="number" onchange="sumArrayValues()" name="amount[]" placeholder="Amount" class="form-control" required></td>

                    <td><button type="button" id="add" name="add" class="btn btn-danger remove-table-row"><i
                                        class="fas fa-minus"></i></button></td>
                </tr>
                
                `
            );

        });

        $(document).on('click', '.remove-table-row', function() {
            $(this).parents('tr').remove();
        });
    </script>






    <script>
        function sumArrayValues() {
            var form = document.getElementById("myForm");
            var sum = 0;

            for (var i = 0; i < form.elements.length; i++) {
                var element = form.elements[i];
                if (element.name === "amount[]") {
                    sum += parseFloat(element.value);
                }

            }

            var sumInput = document.getElementById("total_bill");
            sumInput.value = sum;

            console.log("Sum of array values:", sum);

        }
    </script>



    <script>
        function discountCount() {


            var discount = document.getElementById('discount');
            var totalBill = document.getElementById('total_bill');
            var total_paid = document.getElementById('total_paid');

            var discountBill = discount.value;
            var haveToPaid = (totalBill.value - discountBill);


            total_paid.value = haveToPaid;






        }
    </script>


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
                $('#myForm').validate({
                    rules: {
                        admission_date: {
                            required: true,
                        },
                        leave_date: {
                            required: true,
                        },
                        name: {
                            required: true,
                        },
                        mobile: {
                            required: true,
                        },
                        cabin_no: {
                            required: true,
                        },

                        regi_no: {
                            required: true,
                        },
                        address: {
                            required: true,
                        },
                        description: {
                            required: true,
                        },
                        comments: {
                            required: true,
                        },
                        amount: {
                            required: true,
                        },
                        total_bill: {
                            required: true,
                        },
                        discount: {
                            required: true,
                        },
                        total_paid: {
                            required: true,
                        },
                        paid: {
                            required: true,
                        }
                    },
                    messages: {
                        admission_date: {
                            required: 'Field is required',
                        },
                        leave_date: {
                            required: 'Field is required',
                        },
                        name: {
                            required: 'Field is required',
                        },
                        mobile: {
                            required: "Field is required",
                        },
                        cabin_no: {
                            required: 'Field is required',
                        },
                        regi_no: {
                            required: 'Field is required',
                        },

                        address: {
                            required: 'Field is required',
                        },
                        description: {
                            required: 'Field is required',
                        },
                        comments: {
                            required: 'Field is required',
                        },
                        amount: {
                            required: 'Field is required',
                        },
                        total_bill: {
                            required: 'Field is required',
                        },
                        discount: {
                            required: 'Field is required',
                        },

                        total_paid: {
                            required: 'Field is required',
                        },
                        paid: {
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
@endpush
