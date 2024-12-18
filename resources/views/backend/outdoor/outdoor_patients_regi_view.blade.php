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
        <div class="indoor_outer_card">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title">Outdoor Patients</h1>
                    &nbsp;&nbsp;
                    <a href="{{ route('all_out_regi_patient') }}" class="btn btn-info">View Patients </a>

                    <a href="{{ route('printOutDoor', $patient->uuid) }}" target="_blank" id="print"
                        class="btn btn-success" style="float:right">Print</a>



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

                            <table id="tobeprint" class="list-group list-group-unbordered mb-3" style="font-size: 20px;">
                                <li class="list-group-item" style="font-size: 18px;">
                                    Date:- &nbsp;&nbsp;
                                    {{ $patient->created_at->format('D, d M Y h:i A') }}
                                    <p class="float-right">#{{ $patient->serial_no }}</p>
                                </li>
                                <li class="list-group-item" style="font-size: 18px;">
                                    Patient ID: &nbsp;&nbsp;&nbsp;{{ $patient->uuid }}
                                </li>
                                <li class="list-group-item" style="font-size: 18px;">
                                    Patient Name:-
                                    <p class="float-right">{{ $patient->name }}</p>
                                </li>
                                <li class="list-group-item" style="font-size: 18px;">
                                    Address:-
                                    <p class="float-right" style="font-size: 18px;">{{ $patient->address }}
                                    </p>
                                </li>
                                <li class="list-group-item" style="font-size: 18px;">
                                    Service Name:
                                    <p class="float-right" style="font-size: 18px;">{{ $patient->service_category }}
                                    </p>
                                </li>
                                <li class="list-group-item" style="font-size: 18px;">
                                    Service Fee:-
                                    <p class="float-right">{{ $patient->regi_fee }}</p>
                                </li> <br>
                                <span class="gn_by">Generated By: &nbsp;&nbsp;{{ Auth::user()->name }}</span>
                            </table>


                        </div>
                    </div>

                    {{-- <div class="row">
                        <div class="col-md-6"> <a href="{{ route('admission_form_view', $patient->uuid) }}"
                                class="btn btn-success btn-block"><b>Admit
                                    Patients</b></a>
                        </div>
                        <div class="col-md-6"> <a href="{{ route('cash_memo_form', $patient->uuid) }}"
                                class="btn btn-success btn-block"><b>Generate Cash
                                    Memo</b></a>
                        </div>
                    </div> --}}
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
