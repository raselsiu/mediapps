@extends('backend.layouts.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('backend/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush



@section('content')
    <div class="row mb-2">
        <div class="col-sm-6">
            {{-- <h1>Patients Registration</h1> --}}
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Income Sub-Category</li>
            </ol>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title">Add Income Sub-Category</h1>
                </div>
                <form method="POST" action="{{ route('StoreIncomeSubcategory') }}" id="userForm">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-12">


                                <div class="form-group">
                                    <label for="category">Category: </label>
                                    <select class="custom-select" name="category_id" id="category_id" required>
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('category_id'))
                                        <span style="color: red">Select a category first.</span>
                                    @endif
                                </div>

                            </div>

                            <div class="form-group col-md-12">
                                <label for="name">Add Sub-Category: </label>
                                <input type="text" class="form-control" name="sub_category" id="sub_category"
                                    placeholder="Add Expenditure Category">
                                @if ($errors->has('sub_category'))
                                    <span style="color: red">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
            </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title">Available Sub Category Under Category</h1>
                    <a href="{{ route('income_form') }}" class="float-right btn btn-success"> <i
                            class="fa fa-plus-circle"></i>Income Form</a>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Category</th>
                                <th>Sub-Category</th>
                                @if (Auth::user()->usertype == 'developers')
                                    <th>Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>



                            @foreach ($categoryList as $key => $subcategory)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $subcategory->name }}</td>
                                    <td>{{ $subcategory->subcategory }}</td>
                                    @if (Auth::user()->usertype == 'developers')
                                        <td>
                                            <a href="{{ route('deleteIncomeSubCategory', $subcategory->id) }}"
                                                id="deleteEvent" class="btn btn-sm btn-danger"><i
                                                    class="fa fa-trash"></i></a>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No.</th>
                                <th>Category</th>
                                <th>Sub-Category</th>
                                @if (Auth::user()->usertype == 'developers')
                                    <th>Actions</th>
                                @endif
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('js')
    <script src="{{ asset('backend/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/jquery-validation/additional-methods.min.js') }}"></script>

    <script>
        $(function() {
            $('.custom-select').select2()

        });
    </script>


    <script>
        $(function() {
            $('#userForm').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    sub_category: {
                        required: true,
                    },
                },
                messages: {
                    name: {
                        required: "Category name required",
                    },
                    sub_category: {
                        required: "Add some details",
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
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
                    text: "want to delete this Subcategory?",
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
        });
    </script>
@endpush
