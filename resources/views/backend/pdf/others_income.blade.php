<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $hospitalName }}</title>


    <style>
        table,
        td,
        th {
            border: 1px solid black;
        }

        table.head_info td {
            border: 0px !important;
            margin: 0px;
        }

        table.head_info {
            border: 0px !important;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table tr,
        td {
            padding: 5px
        }

        h2 {
            text-align: center
        }

        .address p,
        h2 {
            text-align: center;
            margin: 0 auto;
        }
    </style>



</head>

<body>
    <div class="address">
        <h2>{{ $hospitalName }}</h2>
        <p>{{ $hospitalAddress }} | Mobile: {{ $hospitalPhone }}</p>
        <br>
    </div>
    <table id="printable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th># SL No</th>
                <th>Date</th>
                <th>Particulars</th>
                <th>Details</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($data as $key => $income)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $income->created_at->format('Y-m-d') }}</td>
                    <td>{{ $income->category }}</td>
                    <td>{{ $income->sub_category }}</td>
                    <td>
                        <p class="amount" style="margin: 0px;padding:0px;text-align:center;">{{ $income->amount }}
                        </p>
                    </td>

                </tr>
            @endforeach

        </tbody>
        <tfoot>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th>Total = <span id="total_amount" class="total_amount">{{ $total_amount }} Tk</span></th>
            </tr>
        </tfoot>
    </table>

</body>

</html>
