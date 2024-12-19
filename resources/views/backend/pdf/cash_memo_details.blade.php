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

        .due {
            color: red;
        }
    </style>



</head>

<body>
    <div class="address">
        <h2>{{ $hospitalName }}</h2>
        <p>{{ $hospitalAddress }} | Mobile: {{ $hospitalPhone }}</p>
        <br>
    </div>



    <table class="table table-bordered patient_info_viewer" style="font-size: 18px">
        <tbody>
            <tr>
                <td> Patients ID:</td>
                <td>{{ $patient_info->uuid }}</td>
                <td> Date:</td>
                <td>{{ \Carbon\Carbon::now()->toFormattedDateString() }}</td>
            </tr>
            <tr>
                <td> Name:</td>
                <td>{{ $patient_info->name }}</td>
                <td>Cabin No: </td>
                <td> {{ Str::ucfirst($patient_info->cabin_no) }}</td>
            </tr>

            <tr>
                <td>Regi. No: </td>
                <td> {{ $patient_info->regi_no }}</td>
                <td>Contact No: </td>
                <td>{{ $patient_info->mobile }}</td>
            </tr>
            <?php $newtime = strtotime($patient_info->created_at); ?>
            <tr>
                <td>Adm. Date:</td>
                <td> {{ date('M d, Y', $newtime) }} </td>
                <td> Leave Date:</td>
                <td> {{ $rcpt_info->leave_date }}</td>
            </tr>
            {{-- <tr>
                <td>Reference:</td>
                <td colspan="3"> {{ $patient_info->care_of }}</td>

            </tr> --}}
        </tbody>
    </table>

    <br>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Amount</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($get_bill as $bill)
                <tr>
                    <td>{{ $bill['description'] }} </td>
                    <td>{{ $bill['comments'] }} </td>
                    <td>{{ $bill['amount'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br>


    <table class="table">
        <tbody>
            <tr>
                <td><b>Amount</b></td>
                <td>{{ $rcpt_info->total_bill }} TK</td>
            </tr>
            <tr>
                <td><b>Discount</b></td>
                <td>{{ $rcpt_info->discount }} TK</td>
            </tr>
            <tr>
                <td><b>Total Amount: </b></td>
                <td>{{ $rcpt_info->total_paid }} TK</td>
            </tr>
            <tr>
                <td><b>Paid: </b></td>
                <td><b>{{ $rcpt_info->paid }}</b> TK</td>
            </tr>
            <tr class="{{ $rcpt_info->outstanding_total > 0 ? 'due' : '' }}">
                <td><b>Due: </b></td>
                <td><b>{{ $rcpt_info->outstanding_total }} TK</b></td>
            </tr>
        </tbody>
    </table>


</body>

</html>
