<!DOCTYPE html>
<html>
<title>{{ $hospitalName }}</title>

<head>
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

    <br><br>
    <div class="address">
        <h2>{{ $hospitalName }}</h2>
        <p>{{ $hospitalAddress }} | Mobile: {{ $hospitalPhone }}</p>
        <br>
    </div>



    <table class="head_info" style="margin-bottom: 5px;margin-left:-4px;">
        <tr>
            <td> <span>
                    <b>Date:</b>
                    {{ $patient->created_at->format('D, d M Y h:i A') }} | <b>#{{ $patient->serial_no }}</b>
                </span>
            </td>
            <td style="text-align: right"><b>Patient ID:</b> &nbsp;&nbsp;&nbsp;<span>{{ $patient->uuid }}</span></td>
        </tr>
    </table>



    <table>
        <tr>
            <td>Patient Name</td>
            <td>{{ $patient->name }}</td>
        </tr>
        <tr>
            <td>Address</td>
            <td>{{ $patient->address }}</td>
        </tr>
        <tr>
            <td>Service Name:</td>
            <td>{{ $patient->service_category }}</td>
        </tr>
        </tr>
        <tr>
            <td>Regi. Fee:</td>
            <td>{{ $patient->regi_fee }} TK</td>
        </tr>
    </table>

    <br>
    <br>


    <table class="head_info">
        <tr>
            <td style="font-size: 12px">Generated By __ {{ Auth::user()->name }}</td>
        </tr>

    </table>
</body>

</html>
