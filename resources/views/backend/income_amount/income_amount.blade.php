@extends('backend.layouts.master')

@section('content')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Others Amount</h1>
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
                        <span><a class="btn btn-warning" href="{{ route('othersTwentyFourHour') }}">Todays</a></span>
                        <span><a class="btn btn-warning" href="{{ route('othersGetCurrentMonthRevenue') }}">Current Month
                            </a></span>
                        <span><a class="btn btn-warning" href="{{ route('othersGetLastMonthRevenue') }}">Last Month
                            </a></span>
                    </div>

                </div>
                <div class="card-body">

                    <table id="printable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#SL No</th>
                                <th>Particulars</th>
                                <th>Detials</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>



                            @foreach ($data as $key => $others)
                                <tr>
                                    <td>{{ $key + 1 }}</td>

                                    <td>{{ $others->category }}</td>
                                    <td>{{ $others->sub_category }}</td>

                                    <td>
                                        <p class="amount" style="margin: 0px;padding:0px;">{{ $others->amount }} TK
                                        </p>
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
                                <th><span class="total_amount">Total = {{ $totalAmount }} TK</span></th>

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
