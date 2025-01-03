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
        <br>
        <br>
    </div>

    <span style="border:1px solid #bbbbbb;padding:5px">Admission</span>
    <br><br>


    <table class="head_info" style="margin-bottom: 5px;margin-left:-4px;">
        <tr>
            <td> <span>
                    <b>Date:</b>
                    {{ $patient->created_at->format('D, d M Y h:i A') }}
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
            <td>{{ $patient->present_address }},{{ $patient->pre_thana }},
                {{ $patient->pre_district }}</td>
        </tr>
        <tr>
            <td>Mobile No:</td>
            <td>{{ $patient->mobile }}</td>
        </tr>
        <tr>
            <td>Cabin No: {{ Str::ucfirst($patient->cabin_no) }}</td>
            <td>Regi No: {{ $patient->regi_no }}</td>
        </tr>
        </tr>
        <tr>
            <td>Regi. Fee:</td>
            <td>{{ $patient->regi_fee }} TK</td>
        </tr>
    </table>

    <br>
    <br>
    <br>
    <br>


    <table class="head_info">
        <tr>
            <td>
                <p style="text-align: left;">-------------- <br>Gurdian Sign</p>
            </td>
            <td style="text-align: right">------------------ <br> Authority &nbsp;&nbsp;&nbsp;
            </td>
        </tr>

        <br>
        <br>
        <br>

        <tr>
            <td><span style="font-size: 12px">Generated
                    By___{{ Auth::user()->name }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
        </tr>

    </table>

</body>

</html>
