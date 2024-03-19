@extends('admin.layouts.app')
@section('admin_contant')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Brand</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#addModal"> + Add New</button>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-dark">
                            <h3 class="card-title">All Brand List Here</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="" class="table table-bordered table-striped table-sm ytable">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Brand Name</th>
                                        <th>Brand Slug</th>
                                        <th>Brand Logo</th>
                                        <th>Home Page</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    {{-- category insert modal --}}
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Brand</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.storeBrand') }}" method="Post" enctype="multipart/form-data" id="add-form">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="brand_name">Brand Name</label>
                            <input type="text" id="brand_name" class="form-control" name="brand_name" required="">
                            <small id="emailHelp" class="form-text text-muted">This is your Brand </small>
                        </div>
                        <div class="form-group">
                            <label for="brand_logo">Brand Logo</label><br>
                            <input type="file" class="dropify" data-height="140" id="brand_logo" name="brand_logo"
                                required="" />
                            <small id="emailHelp" class="form-text text-muted">This is your Brand Logo </small>
                        </div>
                        <div class="form-group">
                            <label for="show">Home Pgae Show</label>
                            <select id="show" class="form-control" name="front_page">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                            <small id="emailHelp" class="form-text text-muted">If yes it will be show on your home page
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="Submit" class="btn btn-primary"> <span class="d-none"> loading..... </span>
                            Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- edit modal --}}
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Brand</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="modal_body">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom_js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>


    <script type="text/javascript">
        $(function childcategory() {
            var table = $('.ytable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.brand') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'brand_name',
                        name: 'brand_name'
                    },
                    {
                        data: 'brand_slug',
                        name: 'brand_slug'
                    },
                    {
                        data: 'brand_logo',
                        name: 'brand_logo',
                        render: function(data, type, full, meta) {
                            var imageUrl = "{{ asset('storage') }}/" + data;
                            return "<img src=\"" + imageUrl + "\" height=\"30\" />";
                        }
                    },
                    {
                        data: 'front_page',
                        name: 'front_page'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },

                ]
            });
        });


        $('body').on('click', '.edit', function() {
            let id = $(this).data('id');
            $.get("{{ url('admin/brand/edit') }}/" + id, function(data) {
                $("#modal_body").html(data);
            });
        });
    </script>
@endsection
