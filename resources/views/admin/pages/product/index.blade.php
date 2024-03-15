@extends('admin.layouts.app')
@section('admin_contant')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>DataTables</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <a href="{{ route('products.create') }}" class="btn btn-primary"> + Add New</a>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">All Categories List Hare</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-hover table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th style="width: 3%">SL</th>
                                        <th style="width: 25%">Product Title</th>
                                        <th>Current Qty</th>
                                        <th>Base Price</th>
                                        <th>Status</th>
                                        <th>Druft</th>
                                        <th class="text-right" style="width: 18%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $key => $product)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $product->product_id }}</td>

                                            @if ($product->productQtys && $product->productQtys->isNotEmpty())
                                            @foreach ($product->productQtys as $productQty)
                                                @if ($productQty->current_qty != 0)
                                                    <td>{{ $productQty->current_qty }}
                                                        @if ($productQty->druft === 0)
                                                            <span class="badge badge-warning ml-1">Druft</span>
                                                        @else
                                                            <span class="badge badge-success ml-1">Published</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $productQty->unit_price }}</td>
                                                    @break
                                                @endif
                                            @endforeach
                                        @else
                                            <!-- Handle the case when $product->productQtys is null or empty -->
                                            <td>Undefine</td>
                                            <td>Undefine</td>
                                        @endif
                                        
                                        <td>
                                            @if ($product->status == 0)
                                                <span class="badge badge-danger ml-1">False</span>
                                            @else
                                                <span class="badge badge-success ml-1">True</span>
                                            @endif
                                        </td>

                                        <td>
                                            <form id="myForm-{{ $product->id }}"
                                                action="{{ route('products.druft.update', $product->id) }}"
                                                method="POST">
                                                @csrf
                                                <div class="custom-control custom-switch">
                                                    <input class="custom-control-input druft-checkbox" type="checkbox"
                                                        onclick="updateStatus({{ $product->id }})"
                                                        id="status-{{ $product->id }}" data-id="{{ $product->id }}"
                                                        {{ $product->druft == 1 ? 'checked' : '' }}>
                                                    <label class="custom-control-label"
                                                        for="status-{{ $product->id }}"></label>
                                                </div>
                                            </form>
                                        </td>

                                        <td class="text-right">
                                            <a href="{{ route('editeProduct', $product->id) }}"
                                                class="btn btn-info btn-sm edit mx-1">
                                                <i class="fas fa-edit"></i></a>

                                            <a href="{{ route('deleteProduct', $product->id) }}"
                                                class="btn btn-danger btn-sm mx-1" id="delete">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                            <a href="{{ route('products.QtyDetails', $product->id) }}"
                                                class="btn btn-primary btn-sm mx-1">
                                                <i class="fa-solid fa-table-list"></i>

                                        </td>
                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.js"></script>
@endsection
@section('custom_js')
<script>
    $(function() {
        $("#example1").DataTable({
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
    function updateStatus(id) {
        document.getElementById('myForm-' + id).submit();
    }
</script>
@endsection
