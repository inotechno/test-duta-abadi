@extends('layout')

@section('content')
<div class="d-flex justify-content-center align-items-center vh-50">
<a class="btn btn-info" href="{{route('test')}}">Test 1,2,3</a>
    <button class="btn btn-primary" id="add-product" data-toggle="modal" data-target="#productModal">Tambah
        Produk</button>
</div>
<div class="d-flex justify-content-center align-items-center vh-50">
    <div class="card m-3">
        <div class="card-header">
            <h5 class="card-title">Table Product</h5>
            <form action="{{ route('crud.index') }}" method="GET">
                <input type="text" class="form-control" id="search" placeholder="Search by name" name="search">
                <button type="submit" class="btn btn-primary mt-1">Search</button>
            </form>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Action</th>
                </thead>
                <tbody id="table-body">
                    @if ($products->isEmpty())
                        <tr>
                            <td colspan="3" class="text-center">Product not found</td>
                        </tr>
                    @else
                        @foreach ($products as $product)
                            <tr>
                                <td>{{$product->nama_barang}}</td>
                                <td>{{$product->harga_barang}}</td>
                                <td>
                                    <button class="btn btn-edit btn-warning btn-sm" data-id="{{$product->id}}"
                                        data-name="{{$product->nama_barang}}"
                                        data-price="{{$product->harga_barang}}">Edit</button>
                                    <button class="btn btn-delete btn-danger btn-sm" data-id="{{$product->id}}"
                                        data-name="{{$product->nama_barang}}"
                                        data-price="{{$product->harga_barang}}">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel">Tambah Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="product-form">
                    @csrf
                    <div class="form-group">
                        <label for="nama_barang">Name</label>
                        <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
                    </div>
                    <div class="form-group">
                        <label for="harga_barang">Price</label>
                        <input type="number" class="form-control" id="harga_barang" name="harga_barang" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="productModal-update" tabindex="-1" role="dialog" aria-labelledby="productModal-updateLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModal-updateLabel">Tambah Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="product-form-update">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id">
                    <div class="form-group">
                        <label for="nama_barang">Name</label>
                        <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
                    </div>
                    <div class="form-group">
                        <label for="harga_barang">Price</label>
                        <input type="number" class="form-control" id="harga_barang" name="harga_barang" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="productModal-delete" tabindex="-1" role="dialog" aria-labelledby="productModal-deleteLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModal-deleteLabel">Delete Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="product-form-delete">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id">

                    <p>Apakah anda yakin ingin menghapus data ini ?</p>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {

            $('#product-form').submit(function (e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('crud.store') }}",
                    type: "POST",
                    data: formData,
                    success: function (response) {
                        console.log(response);
                        if (response.success == true) {
                            $('#productModal').modal('hide');
                            location.reload();
                        }
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });

            $('#table-body').on('click', '.btn-edit', function () {
                var id = $(this).data('id');
                var name = $(this).data('name');
                var price = $(this).data('price');

                $('#productModal-update').modal('show');
                $('#product-form-update').find('input[name="nama_barang"]').val(name);
                $('#product-form-update').find('input[name="harga_barang"]').val(price);
                $('#product-form-update').find('input[name="id"]').val(id);

            })

            $('#table-body').on('click', '.btn-delete', function () {
                var id = $(this).data('id');

                $('#productModal-delete').modal('show');
                $('#product-form-delete').find('input[name="id"]').val(id);

            })

            $('#product-form-update').submit(function (e) {
                e.preventDefault();
                var id = $(this).find('input[name="id"]').val();

                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ url('crud') }}/"+id,
                    type: "PUT",
                    data: formData,
                    success: function (response) {
                        console.log(response);
                        if (response.success == true) {
                            $('#productModal-update').modal('hide');
                            location.reload();
                        }
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });

            $('#product-form-delete').submit(function (e) {
                e.preventDefault();
                var id = $(this).find('input[name="id"]').val();

                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ url('crud') }}/"+id,
                    type: "DELETE",
                    data: formData,
                    success: function (response) {
                        console.log(response);
                        if (response.success == true) {
                            $('#productModal-delete').modal('hide');
                            location.reload();
                        }
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endpush