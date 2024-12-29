<?php

$start_date = request()->start_date;
$end_date = request()->end_date;

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


        <div id="cf-data-container"></div>


        <div class="col-md-12 col-lg-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="btn-row">
                        <a href="{{ route('searchExpenData', [request()->start_date, request()->end_date]) }}"
                            target="_blank" class="btn btn-success" style="float: right">Print</a>

                    </div>
                    <div class="card-body">

                        <div class="search_border">
                            <form action="{{ route('getDatedExpenditureData') }}" method="GET" class="formHandler"
                                id="userForm">
                                @csrf
                                <span>Start Date</span>&nbsp;&nbsp;
                                <input class="inputControl" id="dp" type="date" value="{{ $start_date }}"
                                    name="start_date" placeholder="Start Date">&nbsp;
                                @if ($errors->has('start_date'))
                                    <span style="color: red">Field is equired</span>
                                @endif
                                <span>End Date</span>&nbsp;
                                <input class="inputControl" type="date" value="{{ $end_date }}" name="end_date"
                                    placeholder="End Date">
                                @if ($errors->has('end_date'))
                                    <span style="color: red">Field is Required</span>
                                @endif
                                &nbsp;&nbsp;<button class="submitBtn" type="submit">Search By Date</button>
                            </form>
                        </div>
                        <br>

                        <table class="table table-bordered table-striped" id="">
                            <thead>
                                <tr>
                                    <th>#SL No</th>
                                    <th>Particulars</th>
                                    <th>Details</th>
                                    <th>Note</th>
                                    <th>Amount</th>
                                    {{-- <th class="notForPrint">Details</th> --}}
                                </tr>
                            </thead>
                            <tbody>



                                @foreach ($data as $key => $expenditure)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>

                                        <td>{{ $expenditure->category }}</td>
                                        <td>{{ $expenditure->sub_category }}</td>
                                        <td>{{ $expenditure->description }}</td>

                                        <td>
                                            <p class="amount" style="margin: 0px;padding:0px;">{{ $expenditure->amount }} TK
                                            </p>
                                        </td>
                                        {{-- <td>
                                        <a href="" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>
                                    </td> --}}
                                    </tr>
                                @endforeach
                            <tfoot>
                                <tr>
                                    <th></th>
                                    {{-- <th>Patients ID</th> --}}
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><span class="total_amount">Total ={{ $total_amount }} TK</span></th>

                                </tr>
                            </tfoot>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection