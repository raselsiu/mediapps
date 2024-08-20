@extends('backend.layouts.master')

@section('content')
    <div class="row mb-2">
        <div class="col-sm-6" style="display: flex">
            <h1 class="m-0">Account Books</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Accounts</a></li>
                <li class="breadcrumb-item active">Outdoor</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3><b>{{ number_format($income_balance) }} TK</b></h3>

                    <p>Todays Total Income</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3><b> {{ number_format($expenditureAmount) }}&nbsp;TK</b></h3>

                    <p>Todays Total Expenditure </p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
            </div>
        </div>



        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box {{ $inCash < 0 ? 'bg-danger' : 'bg-success' }}">
                <div class="inner">
                    <h3><b>{{ number_format($inCash) }}</b> TK</h3>

                    <p>In Cash (Today)</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3><b>

                            {{ number_format($inCashTotal) }}

                        </b> TK</h3>

                    <p>In Cash (Total)</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
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
                </div>


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
                                                <td>{{ number_format($data->income_amount) }}</td>
                                            </tr>
                                        @endforeach
                                        <tr class="income_amount">
                                            <th scope="row">#</th>

                                            <td><b>Todays Income:</b></td>
                                            <td><b> =&nbsp;{{ number_format($income_balance) }} TK</b></td>
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
                                                <td>{{ number_format($exp->amount) }}</td>
                                            </tr>
                                        @endforeach
                                        <tr class="exp_amount">
                                            <th scope="row">#</th>
                                            <td><b>Todays Expenditure:</b></td>
                                            <td><b> = &nbsp;{{ number_format($expenditureAmount) }}&nbsp;TK</b></td>
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


{{-- @push('js')
    <script>
        window.onload = function() {
            if (!window.location.hash) {
                window.location = window.location + '#loaded';
                window.location.reload();
            }
        }
    </script>
@endpush --}}
