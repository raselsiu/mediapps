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

        table.comt_sign td {
            border: 0px !important;
            margin: 0px;
        }

        table.comt_sign {
            border: 0px !important;
        }
    </style>
</head>

<body>

    <br><br>
    <div class="address">
        <h2>{{ $hospitalName }}</h2>
        <p>{{ $hospitalAddress }} | Mobile: {{ $hospitalPhone }}</p>
        <br>
        <br>
    </div>
    <span style="border:1px solid #bbbbbb;padding:5px">Outdoor</span>
    <br><br>
    <br>


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
            <td>{{ $patient->service_category }} {{ $patient->extra_service ? ',' : '' }}
                {{ $patient->extra_service }}</td>
        </tr>
        </tr>
        <tr>
            <td>Service Fee:</td>
            <td>{{ $patient->regi_fee }} TK</td>
        </tr>
    </table>

    <br>
    <br>



    <table class="comt_sign">
        <tr>
            <td>&nbsp;&nbsp;Comments <br> -----------------</td>
            <td style="text-align: right">Signature &nbsp;&nbsp; <br>---------------</td>
        </tr>
    </table>

    <br>
    <br> <br>
    <br>

    <table class="head_info">
        <tr>
            <td style="font-size: 12px">Generated By __ {{ Auth::user()->name }}</td>
        </tr>
    </table>



</body>

</html>
