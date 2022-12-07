@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card card-two">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title">Data User</h5>
                        </div>
                        <div class="col-auto">
                            <button data-bs-toggle="modal" onclick="addUser()" data-bs-target="#creditUser"
                                class="btn-right btn btn-sm btn-outline-primary">
                                <i class="fa fa-plus"></i>
                                Tambah User
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-stripped" id="tabel-user">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="text-center">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td class="text-center">
                                            <a href="{{ $user->apiwa->host ?? '' }}/wa/{{ $user->apiwa->apikey ?? '' }}"
                                                class="btn btn-info btn-sm text-white">
                                                <i class="fas fa-qrcode"></i>
                                            </a>
                                            <button onclick="editUser({{ $user->id }})"
                                                class="btn btn-warning btn-sm text-white">
                                                <i class="fa fa-pen"></i>
                                            </button>
                                            <button onclick="deleteUser({{ $user->id }})"
                                                class="btn btn-danger btn-sm text-white">
                                                <i class="fa fa-trash"></i>
                                            </button>
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
    <div class="modal fade" id="creditUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalLabel">Setting User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ url('setting/user/store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="hidden" class="form-control" name="id_user" id="id_user">
                            <div class="form-group row">
                                <label class="col-form-label col-md-2">Nama User</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" id="nama_user" name="nama_user">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-md-2">Email User</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="email_user" id="email_user">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-md-2">Password</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control col-6 col-lg-2" name="password"
                                        id="password">
                                    <span class="d-none" id="notif-password"><span style="color:red">*</span> isi input
                                        diatas jika ingin ganti password</span>
                                </div>
                            </div>
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
        $('#tabel-user').DataTable()
        function editUser(id_user) {
            $.ajax({
                url: document.location.href + '?id=' + id_user,
                method: 'GET',
                success: function(result) {
                    $('#id_user').val(result.id)
                    $('#nama_user').val(result.name)
                    $('#email_user').val(result.email)
                    $('#notif-password').removeClass('d-none')
                    $('#modalLabel').html('Edit Data User')
                    $('#creditUser').modal('show')
                }
            })
        }

        function addUser() {
            $('#modalLabel').html('Tambah User Baru')
            $('#notif-password').addClass('d-none')
            $('#creditUser').modal('show')
            $('#id_user').val('')
            $('#nama_user').val('')
            $('#email_user').val('')
        }

        function deleteUser(id_user) {
            Swal.fire({
                title: 'Apakah anda yakin menghapus user?',
                text: "Data user yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: document.location.href + '/remove?id=' + id_user,
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
