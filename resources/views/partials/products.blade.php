@extends('layout.master')
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">DataTable with minimal features & hover style</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Vendor ID</th>
                            <th>SKU</th>
                            <th>Product</th>
                            <th>Description</th>
                            <th>Brand</th>
                            <th>Vendor</th>
                            <th>Billing Type</th>
                            <th>Rental Term</th>
                            <th>Dealer Price</th>
                            <th>MAP Price</th>
                            <th>MSRP Price</th>
                            <th>Customer Price</th>
                            <th>Currency</th>
                            <th>Download Path</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Vendor ID</th>
                            <th>SKU</th>
                            <th>Product</th>
                            <th>Description</th>
                            <th>Brand</th>
                            <th>Vendor</th>
                            <th>Billing Type</th>
                            <th>Rental Term</th>
                            <th>Dealer Price</th>
                            <th>MAP Price</th>
                            <th>MSRP Price</th>
                            <th>Customer Price</th>
                            <th>Currency</th>
                            <th>Download Path</th>
                            <th>Status</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <!-- /.col -->
    </div>

@endsection

@section('extra-js')
    <script>

        $(document).ready(function() {
            $('#example1').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/product/listings',
                    type: 'GET',
                    data: function(d) {
                        // Optionally, you can send additional data parameters to the server here
                    }
                },
                columns: [
                    { data: 'vendor_id', name: 'vendor_id' },
                    { data: 'sku', name: 'sku' },
                    { data: 'product', name: 'product' },
                    { data: 'descript', name: 'descript' },
                    { data: 'brand', name: 'brand' },
                    { data: 'vendor', name: 'vendor' },
                    { data: 'billing_type', name: 'billing_type' },
                    { data: 'rental_term', name: 'rental_term' },
                    { data: 'dealer_price', name: 'dealer_price' },
                    { data: 'map_price', name: 'map_price' },
                    { data: 'msrp_price', name: 'msrp_price' },
                    { data: 'customer_price', name: 'customer_price' },
                    { data: 'currency', name: 'currency' },
                    { data: 'download_path', name: 'download_path' },
                    { data: 'status', name: 'status' }
                ],
                dom: '<"credentials-table-container table-responsive" rt><"credentials-bottom" ilp>',
                pageLength: 10,
                searching: false,
                language: {
                    paginate: {
                        first: '<i class="fa fa-angle-double-left"></i>',
                        last: '<i class="fa fa-angle-double-right"></i>',
                        next: '<i class="fa fa-angle-right"></i>',
                        previous: '<i class="fa fa-angle-left"></i>',
                    },
                },
                info: false,
                lengthChange: false,
                // columnDefs: [{ targets: "_all", orderable: false }],
            });
        });
    </script>
@endsection

