@extends('admin.master')
@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h5 class="card-title">Data Voucher</h5>
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
                                <th style="width: 20%;">Code Voucher</th>
                                <th style="width: 10%;">Jumlah</th>
                                <th style="width: 25%;">Expiration Date</th>
                                <th style="width: 25%;">Minimal</th>
                                <th style="width: 20%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($voucher as $item)
                            <tr>
                                <td style="width: 5%;">1</td>
                                <td style="width: 20%;">{{ $item->code }}</td>
                                <td style="width: 10%;">{{ $item->jumlah }}</td>
                                <td style="width: 25%;">{{ $item->expiration_date }}</td>
                                <td style="width: 25%;">{{ $item->minimal_belanja }}</td>
                                
                                <td style="width: 20%;">
                                    <div class="d-flex">
                                        <a href="#" class="btn btn-primary me-2" data-bs-toggle="modal"
                                            data-bs-target="#modal-edit" data-id="{{ $item->id }}"
                                            data-nm="{{ $item->code }}" data-desc="{{ $item->jumlah }}"
                                            data-hrg="{{ $item->expiration_date }}" data-minim="{{ $item->minimal_belanja }}">
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
                <h5 class="modal-title" id="exampleModalLabel">Tambah Voucher</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{ route('voucher.store') }}" enctype="multipart/form-data">
                            @csrf
                            @include('admin.page.voucher.form')
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
                <h5 class="modal-title" id="modal-editLabel">Tambah Voucher</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{ route('voucher.update') }}" enctype="multipart/form-data">
                            <input type="hidden" name="id" id="id">
                            @csrf
                            @include('admin.page.voucher.form')
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
                <h5 class="modal-title" id="modal-editLabel">Delete Voucher</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{ route('voucher.delete') }}" enctype="multipart/form-data">
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
        var minimal = button.data('minim');
        
        var modal = $(this);

        modal.find('.modal-body #code').val(nama);
        modal.find('.modal-body #jumlah').val(desc);
        modal.find('.modal-body #expiration_date').val(hrg);
        modal.find('.modal-body #minimal_belanja').val(minimal);
        modal.find('.modal-body #id').val(kode);

    });


    $('#modal-delete').on('show.bs.modal', function (event) {
        var haha = $(event.relatedTarget)
        var kode = haha.data('id')

        var modal = $(this)

        modal.find('.modal-body #id').val(kode);

    });

</script>

@endsection
