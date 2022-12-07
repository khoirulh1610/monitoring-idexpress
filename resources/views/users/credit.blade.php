@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title d-flex justify-content-between">
                        <span>Data User</span>
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ url('setting/user/store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <input type="hidden" value="{{ $user->id ?? '' }}" name="id">
                            <div class="col-lg-12 mb-3">
                                <label class="col-form-label">Nama User</label>
                                <input type="text" class="form-control" name="nama" value="{{ $user->name ?? '' }}">
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label">Email</label>
                                <input type="text" class="form-control" name="email" value="{{ $user->email ?? '' }}">
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label">Password</label>
                                <input type="password" class="form-control" name="password">
                            </div>
                            <div class="d-flex mt-4 justify-content-end">
                                <a class="btn btn-danger me-2" href="{{ url('setting/user') }}" type="button">Batal</a>
                                <button class="btn btn-success" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    
</script>
@endsection
