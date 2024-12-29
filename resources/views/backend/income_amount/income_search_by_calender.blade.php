<?php

$start_date = request()->start_date;
$end_date = request()->end_date;

?>


@extends('backend.layouts.master')

@section('content')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Others Account</h1>
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

                        <a href="{{ route('searchIncmData', [request()->start_date, request()->end_date]) }}"
                            target="_blank" class="btn btn-success" style="float: right">Print</a>

                    </div>

                </div>
                <div class="card-body">
                    <div class="search_border">
                        <form action="{{ route('getDatedIncomesData') }}" method="GET" class="formHandler" id="userForm">
                            @csrf
                            <span>Start Date</span>&nbsp;&nbsp;
                            <input class="inputControl" type="date" name="start_date" value="{{ $start_date }}"
                                placeholder="Start Date">&nbsp;&nbsp;
                            @if ($errors->has('start_date'))
                                <span style="color: red">Field is Required</span>
                            @endif
                            <span>End Date</span>&nbsp;
                            <input class="inputControl" type="date" name="end_date" value="{{ $end_date }}"
                                placeholder="End Date">
                            @if ($errors->has('end_date'))
                                <span style="color: red">Field is Required</span>
                            @endif
                            <button class="submitBtn" type="submit">Search By Date</button>
                        </form>
                    </div>
                    <br>
                    <table id="" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#SL No</th>
                                <th>Date</th>
                                <th>Particulars</th>
                                <th>Detials</th>
                                <th>Amount(TK)</th>
                            </tr>
                        </thead>
                        <tbody>



                            @foreach ($data as $key => $others)
                                <tr>

                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $others->created_at->format('d/m/Y') }}</td>
                                    <td>{{ $others->category }}</td>
                                    <td>{{ $others->sub_category }}</td>

                                    <td>
                                        <p class="amount" style="margin: 0px;padding:0px;">{{ $others->amount }}
                                        </p>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#SL No</th>
                                <th>Date</th>
                                <th>Particulars</th>
                                <th>Detials</th>
                                <th><span class="total_amount">Total = {{ $total_amount }}</span></th>

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
                $("#printable").DataTable({
                    "responsive": true,
                    "lengthChange": true,
                    "autoWidth": true,
                    'footer': true,
                    dom: 'lBfrtip',
                    buttons: [{
                        extend: ['print'],
                        footer: true,
                        exportOptions: {
                            columns: ':not(.notForPrint)'
                        }
                    }]

                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            });
        </script>
    @endpush
@endsection
