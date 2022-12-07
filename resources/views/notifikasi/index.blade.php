@extends('layouts.admin')
<style>
    .truncated {
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        height: 30px;
    }
</style>
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card card-two">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title">Data Notifikasi</h5>
                        </div>
                        <div class="col-auto">
                            <button class="btn-right btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#creditNotif">
                                <i class="fa fa-plus"></i>
                                Tambah Notifikasi
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-stripped" id="tabel-notif">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Device</th>
                                    <th class="text-center">Judul Notifikasi</th>
                                    <th class="text-center" style="width: 500px">Copywriting</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($notifikasi as $notif)
                                    <tr>
                                        <td class="text-center">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="text-center">{{ $notif->api_id }}</td>
                                        <td>{{ $notif->name }}</td>
                                        <td class="truncated" style="width: 500px">{!! nl2br($notif->copywriting) !!}</td>
                                        <td class="text-center">
                                            @if ($notif->status == 0)
                                                <span class="badge badge-danger">Tidak Aktif</span>
                                            @else
                                                <span class="badge badge-success">Aktif</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                        class="fas fa-ellipsis-h"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <button class="dropdown-item"
                                                        onclick="editNotif('{{ $notif->id }}')"><i
                                                            class="fa fa-pen me-2"></i>Edit</button>
                                                    <button class="dropdown-item"
                                                        onclick="deleteNotif('{{ $notif->id }}')"><i
                                                            class="far fa-trash-alt me-2"></i>Delete</button>
                                                </div>
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
    </div>

    <!-- Modal -->
    <div class="modal fade" id="creditNotif" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Setting Notifikasi</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ url('setting/notifikasi/store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="hidden" class="form-control" name="id_notifikasi" id="id-notifikasi">
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <label for="recipient-name" class="col-form-label">Nama Notifikasi</label>
                                    <input type="text" class="form-control" id="nama-notifikasi" name="nama_notifikasi">
                                </div>
                                <div class="col-12 col-lg-4">
                                    <label for="recipient-name" class="col-form-label">Device</label>
                                    <select name="device_notifikasi" id="device-notifikasi" class="form-control">
                                        @foreach ($device as $dev)
                                            <option value="{{ $dev->id }}">{{ $dev->name }} - {{ $dev->wa_phone }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-lg-2">
                                    <label for="recipient-name" class="col-form-label">Status</label>
                                    <select name="status_notifikasi" id="status-notifikasi" class="form-control">
                                        <option value="0">Tidak Aktif</option>
                                        <option value="1">Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Message</label>
                            <textarea cols="20" rows="20" class="form-control" id="message-notifikasi" name="message_notifikasi"></textarea>
                            <b>Parameter yang bisa digunakan : </b><br>
                            @foreach($keys as $k)
                                [{{ $k }}] | 
                            @endforeach
                            [waktu]
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $('#tabel-notif').DataTable();

        function editNotif(id_notifikasi) {
            $.ajax({
                url: document.location.href + '/credit?id=' + id_notifikasi,
                method: 'GET',
                success: function(result) {
                    $('#nama-notifikasi').val(result.name)
                    // $('#device-notifikasi').val(result.send_device)
                    $('#id-notifikasi').val(result.id)
                    $('#message-notifikasi').html(result.copywriting)
                    $(`#status-notifikasi option[value=${result.status}]`).prop("selected", true)
                    $(`#device-notifikasi option[value=${result.send_device}]`).prop("selected", true)
                    $('#creditNotif').modal('show')
                }
            })
        }

        function deleteNotif(id_notifikasi) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data notif yang dihapus harus tidak dapat dikembalikan! dan notif terkait tidak akan terkirim lagi",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: document.location.href + '/remove?id=' + id_notifikasi,
                        success: function(result) {
                            console.log(result);
                            Swal.fire(
                                'Terhapus!',
                                'Data berhasil dihapus.',
                                'success'
                            )
                        }
                    })
                }
            })
        }
    </script>
@endsection
