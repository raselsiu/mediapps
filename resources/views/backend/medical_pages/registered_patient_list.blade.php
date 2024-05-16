@extends('backend.layouts.master')


@section('content')
    <div class="row mb-2">
        <div class="col-sm-6">
            {{-- <h1>User Management</h1> --}}
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Patients</li>
            </ol>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title">Available Patients</h1>
                    <a href="{{ route('registration_form') }}" class="float-right btn btn-success"> <i
                            class="fa fa-plus-circle"></i> Register Patients</a>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Mobile</th>
                                <th>Cabin No.</th>
                                <th>Payment Status</th>
                                <th>Cash-Memo</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($patients as $key => $patient)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $patient->name }}</td>
                                    <td>{{ $patient->present_address }}, {{ $patient->pre_thana }},
                                        {{ $patient->pre_district }}</td>
                                    <td>{{ $patient->mobile }}</td>
                                    <td>{{ $patient->cabin_no }}</td>

                                    <?php
                                    
                                    $balance = DB::table('cash_memo_infos')
                                        ->where('patient_uuid', $patient->uuid)
                                        ->first();
                                    
                                    ?>

                                    <td>
                                        @isset($balance->outstanding_total)
                                            <span class="{{ $balance->outstanding_total == 0 ? 'p_clear' : 'p_not_clear' }}">
                                                {{ $balance->outstanding_total == 0 ? 'Clear - Paid: ' . $balance->total_paid . ' TK' : 'Due - ' . $balance->outstanding_total . 'TK' }}
                                            </span>
                                        @else
                                            <p
                                                style="background: #fa9090; padding:2px 5px; border-radius:5px;text-align:center">
                                                Not Genereted</p>
                                        @endisset
                                    </td>
                                    <td>
                                        @if ($patient->is_cash_memo_generated)
                                            <a href="{{ route('view_cash_memo', $patient->uuid) }}"
                                                class="btn_cash_memo_view">View Memo</a>
                                        @else
                                            No Cash Memo
                                        @endif

                                    </td>
                                    <td>
                                        <a href="" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                        <a href="" id="deleteEvent" class="btn btn-sm btn-danger"><i
                                                class="fa fa-trash"></i></a>
                                        -
                                        <a href="{{ route('regi_form_view', $patient->uuid) }}"
                                            class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Mobile</th>
                                <th>Cabin No.</th>
                                <th>Payment Status</th>
                                <th>Cash-Memo</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('js')
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["csv", "excel", "pdf", "print"]
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
