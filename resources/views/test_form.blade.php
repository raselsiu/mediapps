@extends('backend.layouts.master')


@section('content')
    <div class="row mb-2">
        <div class="col-sm-6"></div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Simple Tables</li>
            </ol>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Generate Cash-Memo for Patient: ID</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('testFormStore') }}" method="POST">
                        @csrf


                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif



                        <table class="table table-bordered" id="table">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>Comments</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>

                                    <input type="hidden" name="patient_uuid" id="patient_uuid" value="sdf45sdf5">

                                    <td><input type="text" name="description[]" placeholder="Add Description.."
                                            class="form-control">
                                    </td>
                                    <td><input type="text" name="comments[]" placeholder="Add Comments.."
                                            class="form-control">
                                    </td>
                                    <td><input type="number" name="amount[]" placeholder="Amount" class="form-control">
                                    </td>

                                </tr>
                                <tr>

                                    <td><input type="text" name="description[]" placeholder="Add Description.."
                                            class="form-control">
                                    </td>
                                    <td><input type="text" name="comments[]" placeholder="Add Comments.."
                                            class="form-control">
                                    </td>
                                    <td><input type="number" name="amount[]" placeholder="Amount" class="form-control">
                                    </td>

                                </tr>

                            </tbody>
                        </table>
                        <button type="button" id="add" name="add" class="btn btn-success">Add
                            More</button>
                        <button type="sbumit" class="btn btn-success">Submit and Generate Cash</button>
                    </form>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <ul class="pagination pagination-sm m-0 float-right">
                        <li class="page-item generate_sign">Cash-Memo Generated By:
                            {{ Auth::user()->name }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
    <br>
@endsection

@push('js')
    <script>
        $('#add').click(function(e) {
            $('#table').append(
                `
                
                <tr>
                    <td><input type="text" name="description[]" placeholder="Add Description.." class="form-control">
                    </td>
                    <td><input type="text" name="comments[]" placeholder="Add Comments.." class="form-control">
                    </td>
                    <td><input type="number" name="amount[]" placeholder="Amount" class="form-control"></td>

                    <td><button type="button" id="add" name="add" class="btn btn-danger remove-table-row">Remove</button></td>
                </tr>
                
                `
            );

        });

        $(document).on('click', '.remove-table-row', function() {
            $(this).parents('tr').remove();
        });
    </script>
@endpush
