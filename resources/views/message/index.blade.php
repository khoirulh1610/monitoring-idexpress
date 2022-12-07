@extends('layouts.admin')

@section('content')
<div class="row">
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col">
        <h3 class="page-title">Message</h3>
        <ul class="breadcrumb">
          <li class="breadcrumb-item"><a href="">Message</a></li>
          <li class="breadcrumb-item active">Report</li>
        </ul>
      </div>
      <div class="col-auto">
        <a class="btn btn-primary filter-btn" href="javascript:void(0);" id="filter_search">
          <i class="fas fa-filter"></i>
        </a>
      </div>
    </div>
  </div>
<div class="col-sm-12">
  <div class="card card-two">
    <div class="card-header">
      <div class="row">
        <div class="col">
          <h5 class="card-title">Message</h5>
        </div>
        {{-- <div class="col-auto">
          <a href="#" class="btn-right btn btn-sm btn-outline-primary">
            Filter
          </a>
        </div> --}}
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-stripped" id="tabel-message">
          <thead class="thead-light">
            <tr>
              <th class="text-center">No</th>
              <th class="text-center">Phone</th>
              <th class="text-center">Message</th>
              <th class="text-center">File</th>
              <th class="text-center">Status</th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($data as $p)
            <tr id="{{ $p->id }}">
              <td class="text-center">{{ $loop->iteration + ((int)(request()->input('page')??1)-1)*10}}</td>
              <td class="text-center">{{ $p->phone }}</td>
              <td><?php echo wordwrap($p->message,40,"<br>") ?></td>
              <td>{{ $p->file ?? '-' }}</td>
              <td class="text-center">{{ $p->report ?? 'Draft' }}</td>
              <td class="text-center">
                  <a id="del{{ $p->id }}" class="btn btn-danger btn-sm" onclick="hapus({{ $p->id }})"><i class="far fa-trash-alt me-2"></i>Delete</a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <div class="card-footer">
      {{ $data->appends(request()->input())->links('vendor.pagination.bootstrap-4')}}
  </div>
  </div>
</div>
</div>
@endsection
@section('js')
<script>
function hapus(id){
  $('#del'+id).replaceWith('<span class="spinner-border text-danger" role="status"></span>');
  $.get("{{ url('message/delete') }}/" + id, {}, function(data, status) {
      $('#'+data).remove();
  });
}
</script>
@endsection