<?php
$total_expenditure = 0;
$total = Session::get('total_expenditure');
?>


@extends('backend.layouts.master')

@section('content')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Account Books</h1>
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
            <div class="small-box bg-success">
                <div class="inner">
                    <h3><b>{{ $income_balance }} TK</b></h3>

                    <p>Total Income</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3><b> {{ $expenditureAmount }}&nbsp;TK</b></h3>

                    <p>Total Expenditure </p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
            </div>
        </div>



        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3><b>{{ $inCash }}</b> TK</h3>

                    <p>In Cash</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
            </div>
        </div>



        <div id="cf-data-container"></div>


        <div class="col-md-12 col-lg-12 col-sm-12">
            <div class="card">
                {{-- <div class="card-header">
                    <div class="btn-row">
                        <span><a class="btn btn-warning" href="">Todays Revenue</a></span>
                        <span><a class="btn btn-warning" href="">Current Month
                                Revenue</a></span>
                        <span><a class="btn btn-warning" href="">Last Month
                                Revenue</a></span>
                    </div>
                </div> --}}


                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="booksarea">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Income</th>
                                            <th scope="col">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                        @foreach ($merge_income as $key => $data)
                                            <tr>
                                                <th scope="row">{{ $key + 1 }}</th>
                                                <td>{{ $data->income_source }}</td>
                                                <td>{{ $data->income_amount }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <th scope="row">#</th>

                                            <td><b>Todays Income:</b></td>
                                            <td><b>{{ $income_balance }}</b></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="booksarea">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Expenditure</th>
                                            <th scope="col">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($expenditure as $key => $exp)
                                            <tr>
                                                <th scope="row">{{ $key + 1 }}</th>
                                                <td>{{ $exp->category }}</td>
                                                <td>{{ $exp->amount }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <th scope="row">#</th>
                                            <td><b>Todays Expenditure:</b></td>
                                            <td><b> = &nbsp;{{ $expenditureAmount }}&nbsp;TK</b></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
