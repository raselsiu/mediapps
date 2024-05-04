<?php
$total_expenditure = 0;
$total = Session::get('total_expenditure');
?>


@extends('backend.layouts.master')

@section('content')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Expenditure Accounting</h1>
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
                    <h3>{{ $total ? $total : '0' }} TK</h3>

                    <p>Total Expenditure </p>
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
                    <h3>0 TK</sup></h3>

                    <p>Todays</p>
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
                    <h3>0 TK</h3>

                    <p>Last Months</p>
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
                    <h3>0 TK</h3>

                    <p>Last 1 Year</p>
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
                        <span><a class="btn btn-warning" href="">Todays Revenue</a></span>
                        <span><a class="btn btn-warning" href="">Last 24 Hours Revenue</a></span>
                        <span><a class="btn btn-warning" href="">Current Month Revenue</a></span>
                        <span><a class="btn btn-warning" href="">Last Month Revenue</a></span>
                        <span><a class="btn btn-warning" href="">Last 24 Hours</a></span>
                        <span><a class="btn btn-warning" href="">Last 24 Hours</a></span>
                    </div>



                    {{-- <a href="" class="float-right btn btn-success"> <i class="fa fa-plus-circle"></i> Register
                        Patients</a> --}}
                </div>
                <div class="card-body">

                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th># SL No</th>
                                <th>Category</th>
                                <th>Subcategory</th>
                                <th>Amount</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>



                            @foreach ($data as $key => $expenditure)
                                <?php $total_expenditure = $total_expenditure + $expenditure->amount;
                                
                                Session::put('total_expenditure', $total_expenditure);
                                
                                ?>
                                <tr>
                                    <td>{{ $key + 1 }}</td>

                                    <td>{{ $expenditure->category }}</td>
                                    <td>{{ $expenditure->sub_category }}</td>

                                    <td>
                                        <p class="amount" style="margin: 0px;padding:0px;">{{ $expenditure->amount }} TK
                                        </p>
                                    </td>
                                    <td>
                                        <a href="" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No.</th>
                                {{-- <th>Patients ID</th> --}}
                                <th></th>
                                <th></th>
                                <th><span class="total_amount">Total = -{{ $total_expenditure }} TK</span></th>
                                <th>Details</th>
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
                $("#example1").DataTable({
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
        </script>
    @endpush
@endsection
