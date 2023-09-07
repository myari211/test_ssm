@extends('admin.layouts.app')
@section('content')
    <div class="row mt-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <span class="header-1">Daftar Anggota</span>
            <button type="button" class="btn btn-md rounded btn-primary text-capitalize z-depth-0" data-toggle="modal" data-target="#create_user">
                Tambah Anggota
            </button>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <table id="dtBasicExample" class="table" width="100%">
                <thead>
                    <tr>
                        <th class="th-sm">Nama Depan</th>
                        <th class="th-sm">Nama Belakang</th>
                        <th class="th-sm">Email</th>
                        <th class="th-sm">Tanggal Join</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($user as $data)
                        <tr>
                            <td>{{ $data->first_name }}</td>
                            <td>{{ $data->last_name }}</td>
                            <td>{{ $data->email }}</td>
                            <td>{{\Carbon\Carbon::parse($data->created_at)->format('d M Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="create_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <span class="text-white header-text-modal">Anggota</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('admin.create_user') }}">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="md-form md-outline m-0">
                                    <label for="first_name">Nama Depan</label>
                                    <input type="text" class="form-control rounded" id="first_name" name="first_name">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="md-form md-outline m-0">
                                    <label for="last_name">Nama Belakang</label>
                                    <input type="text" class="form-control rounded" id="last_name" name="last_name">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="md-form md-outline m-0">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control rounded" id="email" name="email">
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