@extends('backend.layouts.master')


@section('content')
    <div class="row mb-2">
        <div class="col-sm-6"></div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Simple Tables</li>
            </ol>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Generate Cash-Memo for Patient ID: {{ $uuid }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('cash_memo_form_save') }}" method="POST" id="myForm">
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
                                    placeholder="Admission Date....">
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
                                <input type="text" class="form-control" name="name" placeholder="Patient Name....">
                                {{-- @if ($errors->has('name'))
                                    <span style="color: red">{{ $errors->first('name') }}</span>
                                @endif --}}
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="name">Mobile No: </label>
                                <input type="text" class="form-control" name="mobile"
                                    placeholder="Patient Mobile Number....">
                                {{-- @if ($errors->has('name'))
                                    <span style="color: red">{{ $errors->first('name') }}</span>
                                @endif --}}
                            </div>



                            <div class="form-group col-md-4">
                                <label for="name">Cabin No: </label>
                                <input type="text" class="form-control" name="cabin_no"
                                    placeholder="Patient Cabin No. ....">
                                {{-- @if ($errors->has('name'))
                                    <span style="color: red">{{ $errors->first('name') }}</span>
                                @endif --}}
                            </div>

                            <div class="form-group col-md-4">
                                <label for="name">Regi No: </label>
                                <input type="text" class="form-control" name="regi_no" placeholder="Regi. No....">
                                {{-- @if ($errors->has('name'))
                                    <span style="color: red">{{ $errors->first('name') }}</span>
                                @endif --}}
                            </div>
                            <div class="form-group col-md-6">
                                <label for="name">Address: </label>
                                <textarea class="form-control" name="address" id="address" cols="5" rows="2"
                                    placeholder="Patient Address Here..."></textarea>
                                {{-- @if ($errors->has('name'))
                                    <span style="color: red">{{ $errors->first('name') }}</span>
                                @endif --}}
                            </div>
                        </div>






                        <table class="table table-bordered" id="table">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>Comments</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <input type="hidden" name="patient_uuid" value="{{ $uuid }}" id="patient_uuid">

                                    <td><input type="text" name="description[]" value="Registration Fee"
                                            placeholder="Add Description.." class="form-control" required>
                                    </td>
                                    <td><input type="text" name="comments[]" placeholder="Add Comments.."
                                            class="form-control">
                                    </td>
                                    <td><input type="number" onchange="sumArrayValues()" name="amount[]"
                                            placeholder="Amount" class="form-control" required>
                                    </td>
                                </tr>


                                <tr>
                                    <td><input type="text" name="description[]" value="Cabin/Normal Cabin""
                                            class="form-control" required>
                                    </td>
                                    <td><input type="text" name="comments[]" placeholder="Add Comments.."
                                            class="form-control">
                                    </td>
                                    <td><input type="number" onchange="sumArrayValues()" name="amount[]"
                                            placeholder="Amount" class="form-control" required>
                                    </td>
                                </tr>

                                <tr>
                                    <td><input type="text" name="description[]" value="AC Cabin/VIP Cabin""
                                            class="form-control" required>
                                    </td>
                                    <td><input type="text" name="comments[]" placeholder="Add Comments.."
                                            class="form-control">
                                    </td>
                                    <td><input type="number" onchange="sumArrayValues()" name="amount[]"
                                            placeholder="Amount" class="form-control" required>
                                    </td>
                                </tr>


                                <tr>
                                    <td><input type="text" name="description[]" value="Word Fee""
                                            class="form-control" required>
                                    </td>
                                    <td><input type="text" name="comments[]" placeholder="Add Comments.."
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
                                    <label for="name">Total: </label>
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
                                    <label for="name">Total Paid: </label>
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
                    <td><input type="text" name="description[]" placeholder="Add Description.." class="form-control" required>
                    </td>
                    <td><input type="text" name="comments[]" placeholder="Add Comments.." class="form-control">
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

            var discountBill = (totalBill.value * discount.value) / 100;
            var haveToPaid = (totalBill.value - discountBill);

            total_paid.value = Math.round(haveToPaid);


        }
    </script>



    <script></script>
@endpush
