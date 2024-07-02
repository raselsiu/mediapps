<?php
$total_revenue = 0;
$total = Session::get('total_revenue');
?>


@extends('backend.layouts.master')

@section('content')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Outdoor Accounting</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Accounts</a></li>
                <li class="breadcrumb-item active">Outdoor</li>
            </ol>
        </div><!-- /.col -->
    </div>
    <div class="row">

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    {{-- <h3 id="amount_id">{{ $total ? $total : '0' }}</h3> --}}
                    <h3 id="amount_id"></h3>

                    <p>Total Outdoor Revenue </p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>53<sup style="font-size: 20px">%</sup></h3>

                    <p>Bounce Rate</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>44</h3>

                    <p>User Registrations</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>65</h3>

                    <p>Unique Visitorsdsfsfsd</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>



        <div id="cf-data-container"></div>


        <div class="col-md-12 col-lg-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="btn-row">
                        <span><a class="btn btn-warning" href="{{ route('dataTwentyFourHour') }}">Todays Revenue</a></span>
                        <span><a class="btn btn-warning" href="{{ route('getCurrentMonthRevenue') }}">Current Month
                                Revenue</a></span>
                        <span><a class="btn btn-warning" href="{{ route('getLastMonthRevenue') }}">Last Month
                                Revenue</a></span>
                    </div>



                    {{-- <a href="" class="float-right btn btn-success"> <i class="fa fa-plus-circle"></i> Register
                        Patients</a> --}}
                </div>
                <div class="card-body">

                    <table id="example1xc" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th># SL No</th>
                                {{-- <th>Patients ID</th> --}}
                                <th>Name</th>
                                <th>Income Amount</th>
                                <th>View Patient</th>
                            </tr>
                        </thead>
                        <tbody>



                            @foreach ($data as $key => $income)
                                <?php $total_revenue = $total_revenue + $income->income_amount;
                                
                                $patientName = DB::table('outdoor_models')
                                    ->where('uuid', $income->patient_uuid)
                                    ->get(['name']);
                                
                                Session::put('total_revenue', $total_revenue);
                                
                                ?>
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    {{-- <td>{{ $income->patient_uuid }}</td> --}}
                                    @foreach ($patientName as $patient)
                                        <td>{{ $patient->name }}</td>
                                    @endforeach
                                    <td>
                                        <p class="amount" style="margin: 0px;padding:0px;">+{{ $income->income_amount }}</p>
                                    </td>
                                    <td>
                                        <a href="{{ route('outdoor_regi_form_view', $income->patient_uuid) }}"
                                            class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No.</th>
                                {{-- <th>Patients ID</th> --}}
                                <th>Name </th>
                                <th> Total = <span id="total_amount" class="total_amount">{{ $total_revenue }}</span></th>
                                <th>View Patient</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>


    </div>





    @push('js')
        <script>
            $(function() {
                $("#example1xc").DataTable({
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    "buttons": ["csv", "excel", "pdf", "print"]
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
                $('#example2').DataTable({
                    "paging": true,
                    "lengthChange": false,
                    "searching": false,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                });
            });


            // window.onload = function() {
            //     if (!window.location.hash) {
            //         window.location = window.location + '#loaded';
            //         window.location.reload();
            //     }
            // }


            // Get the value of the element with ID 'total_amount'
            var totalAmountElement = document.getElementById('total_amount');

            // Get the value from total_amount and set it to the text content of amount_id
            var amountIdElement = document.getElementById('amount_id');
            amountIdElement.textContent = totalAmountElement.textContent + " TK";
        </script>
    @endpush
@endsection
