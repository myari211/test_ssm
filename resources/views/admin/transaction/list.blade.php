@extends('admin.layouts.app')
@section('content')
<div class="row mt-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <span class="header-1">Daftar Pinjaman</span>
        <button type="button" class="btn btn-primary rounded btn-md z-depth-0 text-capitalize" data-toggle="modal" data-target="#create_transaction">Buat Pinjaman</button>
    </div>
</div>
<div class="row mt-4">
    <div class="col-12">
        <table id="dtBasicExample" class="table" width="100%">
            <thead>
                <tr>
                    <th class="th-sm">Nama Peminjam</th>
                    <th class="th-sm">Judul Buku
                    <th class="th-sm">Tanggal Peminjaman</th>
                    <th class="th-sm">Jadwal Pengembalian</th>
                    <th class="th-sm">Tanggal Pengembalian</th>
                    <th class="th-sm">Denda</th>
                    <th class="th-sm">Status</th>
                    <th class="th-sm">Option</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaction as $data)
                    <tr>
                        <td>{{ $data->first_name." ".$data->last_name }}</td>
                        <td>{{ $data->book_name }}</td>
                        <td>{{ \Carbon\Carbon::parse($data->created_at)->format('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($data->date_deadline)->format('d M Y') }}</td>
                        <td>{{ $data->date_back == null ? "-" : \Carbon\Carbon::parse($data->date_back)->format('d M Y') }}</td>
                        <td>
                            @if(\Carbon\Carbon::parse($data->date_deadline) < \Carbon\Carbon::now())
                                @if($data->date_back == null OR \Carbon\carbon::parse($data->date_back) > \Carbon\Carbon::parse($data->date_deadline) AND \Carbon\Carbon::now() <= \Carbon\Carbon::parse($data->date_deadline)->addDays(7))
                                    Denda 1 - 7 Hari
                                @elseif($data->date_back == null OR \Carbon\carbon::parse($data->date_back) > \Carbon\Carbon::parse($data->date_deadline) AND \Carbon\Carbon::now() >= \Carbon\Carbon::parse($data->date_deadline)->addDays(8) AND \Carbon\Carbon::now() <= \Carbon\Carbon::parse($data->date_deadline)->addDays(30))
                                    Denda 8 - 30 Hari
                                @else
                                    Denda > 31 Hari
                                @endif
                            @else
                                -
                            @endif

                        </td>
                        <td>{{ $data->status == 1 ? "Di Pinjam" : ($data->status == 2 ? "Dikembalikan" : "Hilang") }}</td>
                        <td>
                            <button type="button" class="btn btn-md rounded btn-primary z-depth-0 text-capitalize" onClick="modalTransaction('{{ $data->transaction_id }}')">
                                Update
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


<div class="modal fade" id="create_transaction" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <span class="text-white header-text-modal">Pinjaman</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('admin.create_transaction') }}">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <select class="form-control rounded" name="book">
                                    @foreach($book as $data)
                                        <option value="{{ $data->id }}">{{ $data->book_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <select class="form-control rounded" name="user">
                                    @foreach($user as $data)
                                        <option value="{{ $data->user_id }}">{{ $data->first_name." ".$data->last_name }}</option>
                                    @endforeach
                                </select>
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


<div class="modal fade" id="update_transaction" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header modal-header-style bg-primary d-flex align-items-center">
                <div>
                    <div class="row">
                        <div class="col-12">
                            <span class="text-white header-text-modal">Update</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <span class="text-white header-text-modal">Pinjaman</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <select class="form-control rounded" name="status" id="update_status">
                                <option value="2">Dikembalikan</option>
                                <option value="3">Hilang</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12 d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary rounded text-capitalize z-depth-0" id="buttonUpdate">
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#dtBasicExample').DataTable();
        $('.dataTables_length').addClass('bs-select');
    });

    const modalTransaction = (param) => {
        $('#update_transaction').modal({
            'show': true,
        });

        $('#buttonUpdate').attr('onClick', "updateTransaction('"+ param +"')");
    }

    const updateTransaction = (param) => {
        var url = "{{ url('/') }}";

        var data = {
            'status': $('#update_status :selected').val(),
        }

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: url + '/admin/transaction/update/' + param,
            headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
            data: data,
            success:function(data) {
                alert(data.message);
                if(data.success == true) {
                    pageReload();
                }
            }
        });
    }


    const pageReload = () => {
        location.reload();
    }
</script>
@endsection