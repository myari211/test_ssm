@extends('admin.layouts.app')
@section('content')
    <div class="row mt-4">
        <div class="col-12 d-flex justify-content-between">
            <span class="header-1">Daftar Buku</span>
            <button type="button" class="btn btn-md rounded btn-primary z-depth-0 text-capitalize" data-toggle="modal" data-target="#create_book">
                Tambah Buku
            </button>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-12">
            <table id="dtBasicExample" class="table" width="100%">
                <thead>
                    <tr>
                        <th class="th-sm">Judul Buku</th>
                        <th class="th-sm">Category</th>
                        <th class="th-sm">Tahun Rilis</th>
                        <th class="th-sm">Sinopsis</th>
                        <th class="th-sm">Penulis</th>
                        <th class="th-sm">Stock</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($book as $data)
                        <tr>
                            <td>{{ $data->book_name }}</td>
                            <td>{{ $data->category_name }}</td>
                            <td>{{ $data->year }}</td>
                            <td>{{ $data->synopsis }}</td>
                            <td>{{ $data->author }}</td>
                            <td>{{ $data->stock }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <div class="modal fade" id="create_book" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <span class="text-white header-text-modal">Buku</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('admin.create_book') }}">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="md-form md-outline m-0">
                                    <label for="book_name">Nama Buku</label>
                                    <input type="text" class="form-control rounded" id="book_name" name="book_name">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <div class="md-form md-outline m-0">
                                    <textarea id="synopsis" class="md-textarea form-control" rows="3" name="synopsis"></textarea>
                                    <label for="synopsis">Sinopsis</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-6">
                                <div class="form-group">
                                    <select name="category" class="form-control">
                                        @foreach($category as $data)
                                            <option value="{{ $data->id }}">{{ $data->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="md-form md-outline m-0">
                                        <label for="author">Penulis</label>
                                        <input type="text" class="form-control" id="author" name="author">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="md-form md-outline m-0">
                                    <label for="year">Tahun Rilis</label>
                                    <input type="number" class="form-control" name="year" id="year">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="md-form md-outline m-0">
                                    <label for="stock">Stock</label>
                                    <input type="number" class="form-control" name="stock" id="stock">
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
<script type="text/javascript">
    $(document).ready(function () {
        $('#dtBasicExample').DataTable();
        $('.dataTables_length').addClass('bs-select');
    });
</script>
@endsection