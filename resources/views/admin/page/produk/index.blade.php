@extends('admin.master')
@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h5 class="card-title">Data Produk</h5>
                        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-plus fa-sm text-white">Tambah Data</i>
                </a> -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            Tambah Data
                        </button>
                    </div>
                    <!-- Table with stripped rows -->
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th style="width: 20%;">Nama Produk</th>
                                <th style="width: 10%;">Harga</th>
                                <th style="width: 25%;">Deskripsi</th>
                                <th style="width: 20%;">Image</th>
                                <th style="width: 20%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produk as $item)
                            <tr>
                                <td style="width: 5%;">1</td>
                                <td style="width: 20%;">{{ $item->name_produk }}</td>
                                <td style="width: 10%;">{{ 'Rp ' . number_format($item->price, 0, ',', '.') }}</td>
                                <td style="width: 25%;">{{ $item->desc }}</td>
                                <td style="width: 20%;">
                                    @if(!empty($item->image))
                                    <img src="{{ asset('image/produk/'.$item->image) }}" alt="" class="img-thumbnail"
                                        width="200">
                                    @endif
                                </td>
                                <td style="width: 20%;">
                                    <div class="d-flex">
                                        <a href="#" class="btn btn-primary me-2" data-bs-toggle="modal"
                                            data-bs-target="#modal-edit" data-id="{{ $item->id }}"
                                            data-nm="{{ $item->name_produk }}" data-desc="{{ $item->desc }}"
                                            data-hrg="{{ $item->price }}"
                                            data-image="{{ asset('image/produk/'.$item->image) }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="#" class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#modal-delete" data-id="{{ $item->id }}">
                                            <i class="bi bi-trash-fill"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</section>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{ route('produk.store') }}" enctype="multipart/form-data">
                            @csrf
                            @include('admin.page.produk.form')
                            <div class="col-12">
                                <label for="image" class="form-label">Image Produk</label>
                                <input type="file" id="image" name="image" class="dropify form-control"
                                    data-height="300" />
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="modal-editLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-editLabel">Tambah Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{ route('produk.update') }}" enctype="multipart/form-data">
                            <input type="hidden" name="id" id="id">
                            @include('admin.page.produk.form')
                            <div class="col-12">
                                <label for="image" class="form-label">Harga Produk</label>
                                <input type="file" id="image" name="image" class="dropify form-control" data-default-file="{{ asset('image/produk/'.$item->image) }}" data-height="300" />
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="fileku" id="fileku" value="">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save
                                    changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-delete" tabindex="-1" aria-labelledby="modal-editLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-editLabel">Delete Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{ route('produk.delete') }}" enctype="multipart/form-data">
                            <input type="hidden" name="id" id="id">
                            <p>Apakah Data dihapus?</p>
                            {{method_field('delete')}}
                            {{csrf_field()}}
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection


@section('scriptjs')
<script>
    // $(document).ready(function () {
    //     alert('okee');
    // });

    $('#modal-edit').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var nama = button.data('nm');
        var desc = button.data('desc');
        var kode = button.data('id');
        var hrg = button.data('hrg');
        var gambar = button.data('image');
        var modal = $(this);

        modal.find('.modal-body #name_produk').val(nama);
        modal.find('.modal-body #desc').val(desc);
        modal.find('.modal-body #price').val(hrg);
        modal.find('.modal-body #id').val(kode);

        if (gambar) {
            var str = '<img class="img-thumbnail" src="' + gambar + '" width="50%">';
            modal.find('.dropify-preview .dropify-render img').attr('src', gambar); // Set image source for Dropify preview
            modal.find('.dropify').attr('data-default-file', gambar); // Set default file for Dropify
        } else {
            var str = '<div class="alert alert-danger alert-dismissible">Foto Kosong</div>';
        }
        $('#gambarku').html(str);

        // Initialize Dropify
        modal.find('.dropify').dropify();
    });


    $('#modal-delete').on('show.bs.modal', function (event) {
        var haha = $(event.relatedTarget)
        var kode = haha.data('id')

        var modal = $(this)

        modal.find('.modal-body #id').val(kode);

    });

</script>

@endsection
