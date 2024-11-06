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
                    <form action="{{ route('updateDueAmount', $cash_memo_info->patient_uuid) }}" method="POST"
                        id="myForm">
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
                                <label for="name">Name: </label>
                                <input type="text" class="form-control" value="{{ $patient->name }}" name="name"
                                    placeholder="Patient Name...." readonly>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="name">Regi No: </label>
                                <input type="text" class="form-control" value="{{ $patient->regi_no }}" name="regi_no"
                                    value="" placeholder="Regi. No...." readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="name">Address: </label>
                                <textarea class="form-control" name="address" id="address" cols="5" rows="2"
                                    placeholder="Patient Address Here..." readonly>{{ $patient->present_address }}, {{ $patient->pre_village }},{{ $patient->pre_post_code }},{{ $patient->pre_thana }}, {{ $patient->pre_district }}</textarea>
                            </div>
                        </div>



                        <div class="account_area">
                            <div class="row ">
                                <div class="form-group col-md-4">
                                    <label for="name">Due Amount: </label>
                                    <input type="number" class="form-control"
                                        value="{{ $cash_memo_info->outstanding_total }}" oninput="calculateTotalPaid()"
                                        name="due_amount" id="due_amount" placeholder="Due Amount" required>
                                    @if ($errors->has('due_amount'))
                                        <span style="color: red">{{ $errors->first('Enter Corrent Amount!') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="due_discount">Discount Amount: </label>
                                    <input type="number" class="form-control" oninput="calculateTotalPaid()"
                                        name="due_discount" id="due_discount" placeholder="Enter Amount">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="total_paid">Total Amount: </label>
                                    <input type="number" class="form-control" name="total_due_paid" id="total_due_paid"
                                        placeholder="Enter Amount" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="remarks">Remarks: </label>
                                    <input type="text" class="form-control" name="remarks" id="remarks"
                                        placeholder="Remarks">
                                </div>
                            </div>
                        </div>

                        <button type="sbumit" class="btn btn-success">Update Memo</button>

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
    <script src="{{ asset('backend/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/jquery-validation/additional-methods.min.js') }}"></script>



    <script>
        function calculateTotalPaid() {
            // Get the values of due_amount and due_discount
            let dueAmount = document.getElementById('due_amount').value || 0;
            let dueDiscount = document.getElementById('due_discount').value || 0;

            // Calculate total_paid
            let totalPaid = dueAmount - dueDiscount;

            // Set the result in the total_paid input field
            document.getElementById('total_due_paid').value = totalPaid;
            document.getElementById('due_discount').value = dueDiscount; // Rounds to 2 decimal places
        }

        window.onload = calculateTotalPaid;
    </script>




    <script>
        $(function() {
            $('#myForm').validate({
                rules: {
                    admission_date: {
                        required: true,
                    }
                },
                messages: {
                    admission_date: {
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
