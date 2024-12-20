<?php

use Carbon\Carbon;

?>

@extends('backend.layouts.master')


@section('content')
    <div class="row mb-2">
        <div class="col-sm-6">
            {{-- <h1>Manage Profile</h1> --}}
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Profile</li>
            </ol>
        </div>
    </div>
    <br>

    <div class="outer_area">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title">Cash-Memo</h1>
                {{-- <button type="button" id="print" class="btn btn-success"
                    onclick="PrintDiv('print_area')">Print</button> --}}
                <a href="{{ route('memoViewPrint', $patient_info->uuid) }}" class="btn btn-success"
                    style="float: right">Print Now</a>
            </div>

            <div class="card-body">
                <div class="card card-success card-outline" id="print_area" style="width: 500px">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle"
                                src="{{ asset('backend/img/uploads/no_img.png') }}" alt="User profile picture">
                        </div>


                        <h3 class="profile-username text-center">{{ $hospitalName }}</h3>
                        <p class="text-muted text-center">{{ $hospitalAddress }} | Mobile: {{ $hospitalPhone }}</p>


                        <table class="table table-bordered patient_info_viewer" style="font-size: 18px">
                            <tbody>
                                <tr>
                                    <td> Patients ID:</td>
                                    <td>{{ $patient_info->uuid }}</td>
                                    <td> Date:</td>
                                    <td>{{ Carbon::now()->toFormattedDateString() }}</td>
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
                                <tr>
                                    <td>Reference:</td>
                                    <td colspan="3"> {{ $patient_info->care_of }}</td>

                                </tr>
                            </tbody>
                        </table>


                        <hr>

                        <table class="table table-bordered" style="font-size: 18px">
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

                        <div class="calculated_area " style="font-size: 18px">

                            <table id="tobeprint" class="list-group list-group-unbordered mb-3 custom_table_list">
                                <li class="list-group-item">
                                    <b>Amount: </b>
                                    <p class="float-right" style="font-weight: bold">{{ $rcpt_info->total_bill }} TK</p>
                                    {{-- {{ $patient->created_at->format('D, d M Y h:i A') }} --}}
                                    {{-- <p class="float-right">#MAF00{{ $patient->serial_no }}</p> --}}
                                </li>
                                <li class="list-group-item">
                                    <b>Discount:</b>
                                    <p class="float-right" style="font-weight: bold">{{ $rcpt_info->discount }} TK</p>
                                </li>
                                <li class="list-group-item">
                                    <b>Total Amount: </b>
                                    <p class="float-right" style="font-weight: bold">{{ $rcpt_info->total_paid }} TK</p>
                                </li>
                                <li class="list-group-item">
                                    <b>Paid: </b>
                                    <p class="float-right" style="font-weight: bold">{{ $rcpt_info->paid }} TK</p>
                                </li>
                                </li>
                                <li class="list-group-item">
                                    <b>Due: </b>
                                    <p class="float-right" style="font-weight: bold">{{ $rcpt_info->outstanding_total }} TK
                                    </p>
                                </li>
                            </table>

                        </div>

                    </div>
                    <span class="gn_by" style="display: table;margin: 0 auto">Cash Memo Generated By:
                        &nbsp;&nbsp;{{ Auth::user()->name }}</span>
                    <br>
                </div>

                <div class="cashmemo_btn">
                    <div class="row">
                        @if ($rcpt_info->outstanding_total > 0)
                            <div class="col-md-3">
                                <a href="{{ route('edit_cash_memo', $patient_info->uuid) }}"
                                    class="btn btn-sm btn-warning">
                                    <b><i class="fa fa-pen"></i> &nbsp;&nbsp;Update Cash-Memo</b>
                                </a>
                            </div>
                        @endif

                        <div class="col-md-3"> <a href="{{ route('all_regi_patient') }}" class="btn btn-success btn-sm">
                                &nbsp;<i class="fa fa-user"></i> &nbsp; Indoor Pateint
                                Lists</a>
                        </div>

                        @if ($patient_info->status == 'released')
                        @else
                            <div class="col-md-3"> <a href="{{ route('addMoreServicesForm', $patient_info->uuid) }}"
                                    class="btn btn-sm btn-danger"><i class="fa fa-plus"></i> &nbsp;Add More
                                    Services</a>
                            </div>
                        @endif





                        <?php
                        use App\Models\AdmissinForm;
                        $status = AdmissinForm::where('uuid', $patient_info->uuid)
                            ->pluck('status')
                            ->first();
                        
                        ?>



                        @if ($status == 'released')
                            <div class="col-md-3"> <a class="btn btn-sm btn-danger disabled">
                                    <i class="fas fa-user-shield"></i> &nbsp; Already Released!</a>
                            </div>
                        @else
                            <div class="col-md-3" id="release"> <a
                                    href="{{ route('release_cabin', [$patient_info->cabin_no, $patient_info->uuid]) }}"
                                    class="btn btn-sm btn-danger">
                                    <i class="fas fa-user-shield"></i> &nbsp; Release this Patient </a>
                            </div>
                        @endif







                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection


@push('js')
    <script>
        $(function() {
            $("#tobeprint").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>


    <script>
        $(function() {
            $(document).on('click', '#deleteEvent', function(e) {
                e.preventDefault();
                var link = $(this).attr('href');
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = link;
                        Swal.fire({
                            title: "Deleted!",
                            text: "Your file has been deleted.",
                            icon: "success"
                        });
                    }
                });
            })
        })
    </script>

    <script>
        $(function() {
            $(document).on('click', '#release', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: "Are you sure?",
                    text: "You want to release this patient!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, release!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href =
                            '{{ route('release_cabin', [$patient_info->cabin_no, $patient_info->uuid]) }}';
                        Swal.fire({
                            title: "Released!",
                            text: "This patient has been released successfully!",
                            icon: "success"
                        });
                    }
                });
            })
        })
    </script>
@endpush
