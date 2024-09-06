@extends('backend.layouts.master')

@section('content')
    <div class="row mb-2">
        <div class="col-sm-6" style="display: flex">
            <h1 class="m-0">&nbsp; Search By Date</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Accounts</a></li>
                <li class="breadcrumb-item active">Outdoor</li>
            </ol>
        </div>
    </div>


    <div id="cf-data-container"></div>


    <div class="col-md-12 col-lg-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="btn-row">
                    <form action="{{ route('getDatedData') }}" method="GET" class="formHandler" id="userForm">
                        @csrf
                        <span>Start Date</span>&nbsp;&nbsp;
                        <input class="inputControl" type="date" name="start_date" placeholder="Start Date"
                            value="{{ $startDate->toDateString() }}">&nbsp;&nbsp;
                        @if ($errors->has('start_date'))
                            <span style="color: red">Field is Required</span>
                        @endif
                        <span>End Date</span>&nbsp;
                        <input class="inputControl" type="date" name="end_date" placeholder="End Date"
                            value="{{ $endDate->toDateString() }}">
                        @if ($errors->has('end_date'))
                            <span style="color: red">Field is Required</span>
                        @endif
                        <button class="submitBtn" type="submit">Search By Date</button>
                    </form>
                </div>
            </div>


            <div class="card-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="time_booksarea">

                            <table class="table table-bordered" id="printable">

                                <thead>
                                    <tr>
                                        <th scope="col" class="notForPrint">No.</th>
                                        <th scope="col">Detials</th>
                                        <th scope="col">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <th scope="row">1</th>
                                        <td>Indoor</td>
                                        <td>{{ $indoors }} Tk</td>
                                    </tr>

                                    <tr>
                                        <th scope="row">2</th>
                                        <td>Outdoor</td>
                                        <td>{{ $outdoor }} Tk</td>
                                    </tr>

                                    <tr>
                                        <th scope="row">3</th>
                                        <td>Others</td>
                                        <td> {{ $income }} Tk</td>
                                    </tr>
                                    <tr class="marking">
                                        <th scope="row">4</th>
                                        <td>Total</td>
                                        <td>{{ $total_income }} Tk</td>
                                    </tr>
                                    <tr class="marking">
                                        <th scope="row">5</th>
                                        <td>Expenditure</td>
                                        <td>{{ $expenditure }} Tk</td>
                                    </tr>

                                    <tr class="income_amount">
                                        <th scope="row">6</th>

                                        <td><b>Cash:</b></td>
                                        <td><b> =&nbsp;&nbsp;{{ number_format($total_income - $expenditure) }} TK</b></td>
                                    </tr>


                                    <tr class="due">
                                        <th scope="row">7</th>
                                        <td><b>Due Amount:</b></td>
                                        <td><b> = &nbsp;{{ $due }} Tk (All Patient)</b></td>
                                    </tr>
                                    <tr class="due">
                                        <th scope="row">8</th>
                                        <td><b>Due Collected:</b></td>
                                        <td><b> = &nbsp;{{ $dueCollection }} Tk</b></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <th>##</th>
                                    <th colspan="1"><span class="title_bar">Result Between:
                                            {{ $startDate->toFormattedDateString() }} -
                                            {{ $endDate->toFormattedDateString() }}&nbsp;&nbsp;!</span>
                                    </th>
                                    <th>
                                        <span class="bf">BF: {{ $previousDayIncome }}</span>
                                    </th>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    </div>
@endsection

@push('js')
    <script>
        $(function() {
            $("#printable").DataTable({
                "responsive": true,
                "lengthChange": false,
                searching: false,
                paging: false,
                info: false,
                "autoWidth": true,
                // 'footer': true,
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
