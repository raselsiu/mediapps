@extends('backend.layouts.master')

@section('content')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Indoor Accounting</h1>
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
                        <span><a class="btn btn-warning" href="{{ route('indoorTwentyFourHour') }}">Todays
                                Revenue</a></span>
                        <span><a class="btn btn-warning" href="{{ route('indoorGetCurrentMonthRevenue') }}">Current Month
                                Revenue</a></span>
                        <span><a class="btn btn-warning" href="{{ route('indoorGetLastMonthRevenue') }}">Last Month
                                Revenue</a></span>
                    </div>



                    {{-- <a href="" class="float-right btn btn-success"> <i class="fa fa-plus-circle"></i> Register
                        Patients</a> --}}
                </div>
                <div class="card-body">

                    <table id="printable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th># SL No</th>
                                {{-- <th>Patients ID</th> --}}
                                <th>Name</th>
                                <th>Amount</th>
                                <th class="notForPrint">View Patient</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($data as $key => $income)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $income->patient_name }}</td>
                                    <td>
                                        <p class="amount" style="margin: 0px;padding:0px;">+{{ $income->paid }}</p>
                                    </td>
                                    <td>
                                        <a href="{{ route('regi_form_view', $income->patient_uuid) }}"
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
                                <th> Total = <span id="total_amount" class="total_amount">{{ $totalAmount }} Tk</span></th>
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
