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
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title">Patients Profile</h1>
                    {{-- <button type="button" id="print" class="btn btn-success"
                        onclick="PrintDiv('print_area')">Print</button> --}}
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

                            <table id="tobeprint" class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    Date:- &nbsp;&nbsp;
                                    {{ $patient->created_at->format('D, d M Y h:i A') }}
                                    {{-- <p class="float-right">#MAF00{{ $patient->serial_no }}</p> --}}
                                </li>
                                <li class="list-group-item">
                                    Patient ID: &nbsp;&nbsp;&nbsp;{{ $patient->uuid }}
                                </li>
                                <li class="list-group-item">
                                    Patient Name:-
                                    <p class="float-right">{{ $patient->name }}</p>
                                </li>
                                <li class="list-group-item">
                                    Address:-
                                    <p class="float-right">{{ $patient->present_address }}, {{ $patient->pre_district }}</p>
                                </li>

                                <li class="list-group-item">
                                    Mobile:-
                                    <p class="float-right">{{ $patient->mobile }}</p>
                                </li>
                                <li class="list-group-item">
                                    Cabin No:- &nbsp;{{ $patient->cabin_no }}
                                    <p class="float-right">Regi. No:-&nbsp;&nbsp;{{ $patient->regi_no }}</p>
                                </li>

                                <span class="gn_by">Generated By: &nbsp;&nbsp;{{ Auth::user()->name }}</span>
                            </table>


                        </div>
                    </div>

                    <div class="row">
                        {{-- <div class="col-md-6"> <a href="{{ route('admission_form_view', $patient->uuid) }}"
                                    class="btn btn-success btn-block"><b>Admit patient</b></a>
                            </div> --}}
                        <div class="col-md-6">
                            @if ($patient->is_cash_memo_generated)
                                <p class="cash_memo_generated">Cash-Memo Generated</p>
                            @else
                                <a href="{{ route('cash_memo_form', $patient->uuid) }}" class="btn btn-success btn-block">
                                    <b>Generate Cash Memo</b>
                                </a>
                            @endif
                        </div>
                        @if ($patient->is_cash_memo_generated)
                            <div class="col-md-6"> <a href="{{ route('view_cash_memo', $patient->uuid) }}"
                                    class="btn btn-success btn-block"><b>View Cash-Memo</b></a>
                            </div>
                        @else
                            <div class="col-md-6"> <a href="{{ route('all_regi_patient') }}"
                                    class="btn btn-success btn-block"><b>Pateint Lists</b></a>
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
@endpush
