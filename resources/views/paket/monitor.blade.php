@extends('layouts.admin')

@section('content')
<div class="row">
	<div class="page-header">
		<div class="row align-items-center">
			<div class="col">
				<h3 class="page-title">{{$title ?? 'Data Paket' }}</h3>
				<ul class="breadcrumb">
					<li class="breadcrumb-item"><a href="/claim">Paket</a></li>
					<li class="breadcrumb-item active">Detail</li>
				</ul>
			</div>
			<div class="col-auto">
				<!-- <a href="add-expenses.html" class="btn btn-primary">
					<i class="fas fa-plus"></i>
				</a> -->
				<a class="btn btn-primary filter-btn" href="javascript:void(0);" id="filter_search">
					<i class="fas fa-filter"></i> Filter
				</a>
			</div>
		</div>
	</div>


	<div id="filter_inputs" class="card filter-card" style="display: none;">
		<form action="?" method="get">
			<div class="card-body pb-0">
				<div class="row">

					<div class="col-md-4" data-select2-id="6">
						<div class="form-group" data-select2-id="5">
							<label>Status:</label>
							<select class="form-control" name="filter_status">
								<option value="all">All / Semua</option>
								<option value="Delivered">Delivered</option>
								<option value="Dalam Proses">Dalam Proses</option>
								<option value="Gagal Kirim">Gagal Kirim</option>
								<option value="Dalam Proses Lebih Dari 3 Hari">Dalam Proses Lebih Dari 3 Hari</option>
								<option value="Dalam Proses Lebih Dari 7 Hari">Dalam Proses Lebih Dari 7 Hari</option>
								<option value="tidak_valid">Tidak Valid</option>
							</select>
						</div>
					</div>
					<div class="col-md-4" data-select2-id="6">
						<div class="form-group" data-select2-id="5">
							<label>Filter By :</label>
							<select class="form-control" name="filter_by">
								<option value="">All / Semua</option>
								<option value="waybill_no">WaybillNo</option>
								<option value="recipient_phone">Phone / HP</option>
								<option value="recipient_name">Nama</option>
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Kata Kunci </label>
							<input class="form-control" type="text" name="keyword" value="{{\Request()->keyword ?? ''}}">
						</div>
					</div>

					<div class="col-md-4">
						<div class="form-group">
							<label>From</label>
							<div class="cal-icon">
								<input class="form-control datetimepicker" type="text" name="filter_from" value="{{\Request()->filter_from ?? ''}}">
							</div>
						</div>
					</div>
					<div class="col-md-4">
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


	<div class="col-md-12 col-sm-12">
		<div class="card card-two">
			<div class="card-body">

				<div class="mb-3">
					{{ $paket->appends(request()->input())->links('vendor.pagination.bootstrap-4')}}
				</div>
				<div class="table-responsive">
					<table class="table table-stripped small" id="tabel-paket">
						<thead class="thead-light">
							<tr>
								<th class="text-center">No</th>
								<th class="text-center">Date</th>
								<th class="text-center">Waybill No</th>
								<th class="text-center">Recipient Name</th>
								<th class="text-center">Note</th>
								<th class="text-center">Status</th>
								<th class="text-center">Problem Paket</th>
								<th class="text-center">Checker</th>
								<th class="text-center">Update Bukti</th>
								<th class="text-center">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($paket as $p)
							<tr>
								<td class="text-center">
									{{ $loop->iteration }}
								</td>
								<td>{{ $p->pick_up_start_time ? Date('d/m/y',strtotime($p->pick_up_start_time)) : '' }} </td>
								<td>{{ $p->waybill_no }}</td>
								<td>
									{{ $p->recipient_name }} <br>
									{{ $p->recipient_phone }}

								</td>
								<?php
								$status = \App\Models\IdexpressStatus::where('operationType', $p->operationType)->first();
								$class = $status->class ?? '';
								$note = $status->note ?? '-';
								?>

								<td>{!! wordwrap($p->waybill_status,25,"<br>\n") !!}</td>
								<td class="text-center">
									<div class="dropdown">					
										<?php
											$text_color = 'text-dark';
											if($p->crm_monitor == 'Pending'){
												$text_color = 'text-warning';
											}elseif($p->crm_monitor == 'Clear'){
												$text_color = 'text-dark';
											}elseif($p->crm_monitor == 'Gagal'){
												$text_color = 'text-dark';
											}elseif($p->crm_monitor == 'Problem On Shipment'){
												$text_color = 'text-danger';
											}elseif($p->crm_monitor == 'Pending Confirm'){
												$text_color = 'text-success';
											}
											?>											
										<select name="status" id="status" data-id="{{$p->id}}" class="form-control {{ $text_color }}">
											<option class="text-warning" value="Pending" {{ ($p->crm_monitor=='Pending') ? 'selected' : ''}}>Pending</option>
											<option class="text-dark" value="Clear">Clear</option>
											<option class="text-dark" value="Gagal">Gagal</option>
											<option class="text-danger" value="Problem On Shipment" {{ ($p->crm_monitor=='Problem On Shipment') ? 'selected' : ''}}>Problem On Shipment</option>
											<option class="text-success" value="Pending Confirm" {{ ($p->crm_monitor=='Pending Confirm') ? 'selected' : ''}}>Pending Confirm</option>
										</select>
									</div>
								</td>
								<td class="text-center"><span class="badge {{ $class }}">{{ $note }}</span></td>
								<td>
									<?php
									$overdue = $p->overdue . ' Hari'; // . ' Hari ' . $hours . ' Jam ';
									$class_overdue = $p->overdue > 3 ? 'text-warning' : ($p->overdue > 7 ? 'text-danger' : '');
									?>
									<span class="{{ $class_overdue }}">{{ $overdue }}</span>
								</td>
								<!-- <td>{{ $p->batch_id }} <br> {{ $p->order_no }}</td> -->
								<td>
									{{ $p->destination }}
								</td>

								<td>
									Start Time : {{ $p->pick_up_start_time ? Date('d/m/y H:i',strtotime($p->pick_up_start_time)) : '' }} <br>
									End Time : {{ $p->pick_up_end_time ? Date('d/m/y H:i',strtotime($p->pick_up_end_time)) : ''}} <br>
								</td>
								<td>{{$p->rp_cod}}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
			<div class="card-footer">
				{{ $paket->appends(request()->input())->links('vendor.pagination.bootstrap-4')}}
			</div>
		</div>
	</div>
</div>

</div>
@endsection

@section('js')
<script>
	$('#status').on('change', function() {
		console.log($(this).attr("data-id"));
		Swal.fire({
			title: 'Apakah anda yakin merubah status ke <b></b>'+this.value+'</b> ?',
			// showDenyButton: true,
			showCancelButton: true,
			confirmButtonText: 'Ya',
			denyButtonText: `Tidak`,
		}).then((result) => {
			/* Read more about isConfirmed, isDenied below */
			if (result.isConfirmed) {
				$.ajax({
					'url':'crm-monitor?id='+$(this).attr("data-id")+'&status='+this.value,
					success:function(data){
						console.log(data);
						if(data.reload){
							location.reload();
						}
						Swal.fire('Saved!', '', 'success')
					}
				})
				
			} 
		})
	});
</script>
@endsection