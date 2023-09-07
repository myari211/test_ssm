@extends('admin.layouts.app')
@section('content')
    <div class="row mt-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <span class="header-1">Kategori Buku</span>
            <button type="button" class="btn btn-md rounded btn-primary text-capitalize z-depth-0 m-0" data-toggle="modal" data-target="#create_category">Tambah Kategori</button>
        </div>
    </div>
    <div class="row mt-4">
        @foreach($category as $data)
        <div class="col-lg-2">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <span style="font-weight: 600" class="text-muted">{{ $data->category_name }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="modal fade" id="create_category" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header modal-header-style bg-primary d-flex align-items-center">
                    <div>
                        <div class="row">
                            <div class="col-12">
                                <span class="text-white header-text-modal">Tambah</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <span class="text-white header-text-modal">Kategory</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('admin.create_category') }}">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="md-form md-outline m-0">
                                    <label for="category">Nama Kategory</label>
                                    <input type="text" class="form-control rounded" id="category" name="category">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-12 d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary rounded text-capitalize z-depth-0">
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection