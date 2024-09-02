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
                        <span><a class="btn btn-warning" href="{{ route('expTwentyFourHour') }}">Previous Day</a></span>
                        <span><a class="btn btn-warning" href="{{ route('expGetCurrentMonthRevenue') }}">Current Month
                            </a></span>
                        <span><a class="btn btn-warning" href="{{ route('expGetLastMonthRevenue') }}">Last Month
                            </a></span>
                    </div>

                    <div class="card-body">

                        <table class="table table-bordered table-striped" id="example1">
                            <thead>
                                <tr>
                                    <th># SL No</th>
                                    <th>Particulars</th>
                                    <th>Details</th>
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
                                    <th><span class="total_amount">Total ={{ $total_amount }} TK</span></th>

                                </tr>
                            </tfoot>
                            </tbody>

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
