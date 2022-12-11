@extends('layouts.admin')

@section('content')
<div class="row">


</div>

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
          <i class="fas fa-filter"></i> Filter
        </a>
      </div>
    </div>
  </div>


  <div class="col-xl-4 col-sm-6 col-12">
    <div class="card card-two">
      <div class="card-body">
        <a href="{{url('message?filter_status=terkirim&filter_from=&filter_to=')}}">
          <div class="dash-widget-header">
            <span class="dash-widget-icon bg-1 bg-three">
              <i class="mdi mdi-airplane-landing" data-bs-toggle="tooltip" title="" data-bs-original-title="mdi-airplane-landing" aria-label="mdi-airplane-landing"></i>
            </span>
            <div class="dash-count">
              <div class="dash-title">Terkirim</div>
              <div class="dash-counts">
                <p>{{ number_format($terkirim ?? 0) }}</p>
              </div>
            </div>
          </div>
        </a>
      </div>
    </div>
  </div>
  <div class="col-xl-4 col-sm-6 col-12">
    <div class="card card-two">
      <div class="card-body">
        <a href="{{url('message?filter_status=pending&filter_from=&filter_to=')}}">
          <div class="dash-widget-header">
            <span class="dash-widget-icon bg-2 bg-two">
              <i class="mdi mdi-airplane-takeoff" data-bs-toggle="tooltip" title="" data-bs-original-title="mdi-airplane-takeoff" aria-label="mdi-airplane-takeoff"></i>
            </span>
            <div class="dash-count">
              <div class="dash-title">Pending</div>
              <div class="dash-counts">
                <p>{{ number_format($pending ?? 0) }}</p>
              </div>
            </div>
          </div>
        </a>
      </div>
    </div>
  </div>
  <div class="col-xl-4 col-sm-6 col-12">
    <div class="card card-two">
      <div class="card-body">
        <a href="{{url('message?filter_status=gagal&filter_from=&filter_to=')}}">
          <div class="dash-widget-header">
            <span class="dash-widget-icon bg-3 bg-one">
              <i class="mdi mdi-airplane-off" data-bs-toggle="tooltip" title="" data-bs-original-title="mdi-airplane-off" aria-label="mdi-airplane-off"></i>
            </span>
            <div class="dash-count">
              <div class="dash-title">Gagal Kirim</div>
              <div class="dash-counts">
                <p>{{ number_format($gagal ?? 0) }}</p>
              </div>
            </div>
          </div>
        </a>
      </div>
    </div>
  </div>


  <div id="filter_inputs" class="card filter-card" style="display: none;">
    <form action="?" method="get">
      <div class="card-body pb-0">
        <div class="row">

          <div class="col-md-3" data-select2-id="6">
            <div class="form-group" data-select2-id="5">
              <label>Status:</label>
              <select class="form-control" name="filter_status">
                <option value="all">All / Semua</option>
                <option value="terkirim">Terkirim</option>
                <option value="pending">Pending</option>
                <option value="gagal">Gagal Kirim</option>                
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>From</label>
              <div class="cal-icon">
                <input class="form-control datetimepicker" type="text" name="filter_from" value="{{\Request()->filter_from ?? ''}}">
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>To</label>
              <div class="cal-icon">
                <input class="form-control datetimepicker" format="Y-m-d" type="text" name="filter_to" value="{{\Request()->filter_to ?? ''}}">
              </div>
            </div>
          </div>
          <div class="col-md-3 mt-2">
            <div class="form-group">
              <br>
              <button type="submit" class="btn btn-success">Filter</button>
            </div>
          </div>
        </div>
      </div>
    </form>
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
                <th class="text-center">Tanggal</th>
                <th class="text-center">Status</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($data as $p)
              <tr id="{{ $p->id }}">
                <td class="text-center">{{ $loop->iteration + ((int)(request()->input('page')??1)-1)*10}}</td>
                <td class="text-center">{{ $p->phone }}</td>
                <td><?php echo nl2br($p->message) ?></td>
                <td>{{ $p->created_at ?? 'Updated_at' }}</td>
                <td class="text-center">{{ $p->report ?? 'Pending' }}</td>
                <td class="text-center">
                  <a id="del({{ $p->id }})" class="btn btn-danger btn-sm" onclick="hapus('{{ $p->id }}')"><i class="far fa-trash-alt me-2"></i>Delete</a>
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
  function hapus(id) {
    $('#del' + id).replaceWith('<span class="spinner-border text-danger" role="status"></span>');
    $.get("{{ url('message/delete') }}/" + id, {}, function(data, status) {
      $('#' + data).remove();
    });
  }
</script>
@endsection