@extends('backend.layouts.master')

@section('content')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Outdoor</h1>
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
                        {{-- <span><a class="btn btn-warning" href="{{ route('dataTwentyFourHour') }}">Previous Day</a></span>
                        <span><a class="btn btn-warning" href="{{ route('getCurrentMonthRevenue') }}">Current Month
                            </a></span>
                        <span><a class="btn btn-warning" href="{{ route('getLastMonthRevenue') }}">Last Month
                            </a></span>
                            --}}
                        <span style="float: right">
                            <a class="btn btn-success" target="_blank" href="{{ route('acoutdoor') }}">Print</a>
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="search_border">
                        <form action="{{ route('getDatedOutdrData') }}" method="GET" class="formHandler" id="userForm">
                            @csrf
                            <span>Start Date</span>&nbsp;&nbsp;
                            <input class="inputControl" type="date" name="start_date"
                                placeholder="Start Date">&nbsp;&nbsp;
                            @if ($errors->has('start_date'))
                                <span style="color: red">Field is Required</span>
                            @endif
                            <span>End Date</span>&nbsp;
                            <input class="inputControl" type="date" name="end_date" placeholder="End Date">
                            @if ($errors->has('end_date'))
                                <span style="color: red">Field is Required</span>
                            @endif
                            <button class="submitBtn" type="submit">Search By Date</button>
                        </form>
                    </div>
                    <br>
                    <table class="table table-bordered table-striped" id="">
                        <thead>
                            <tr>
                                <th># SL No</th>
                                <th>Name</th>
                                <th>Amount(TK)</th>
                                <th class="notForPrint">View Patient</th>
                            </tr>
                        </thead>
                        <tbody>



                            @foreach ($data as $key => $income)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $income->name }}</td>
                                    <td>
                                        <p class="amount" style="margin: 0px;padding:0px;">{{ $income->regi_fee }}</p>
                                    </td>
                                    <td>
                                        <a href="{{ route('outdoor_regi_form_view', $income->uuid) }}"
                                            class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No.</th>
                                <th>Name </th>
                                <th> Total = &nbsp;<span id="total_amount" class="total_amount">{{ $total_amount }}</span>
                                </th>
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
