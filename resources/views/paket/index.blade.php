@extends('layouts.admin')

@section('content')
<div class="row">
	<div class="page-header">
		<div class="row align-items-center">
			<div class="col">
				<h3 class="page-title">Data Paket</h3>
				<ul class="breadcrumb">
					<li class="breadcrumb-item"><a href="index.html">Paket</a></li>
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
			<div class="card-header">
				<div class="row">
					<div class="col">
						<h5 class="card-title">Data Resi</h5>
					</div>
					<div class="col-auto">
						<a href="{{ url('paket/upload') }}" class="btn-right btn btn-sm btn-outline-primary">
							Upload Resi
						</a>
					</div>
				</div>
			</div>
			<div class="card-body">
			
				<div class="mb-3">
					<!-- <div class="row">
						<div class="col-auto">
							<i class="fas fa-circle text-success me-1"></i> Delivered
						</div>
						<div class="col-auto">
							<i class="fas fa-circle text-warning me-1"></i> Dalam Pengiriman
						</div>
						<div class="col-auto">
							<i class="fas fa-circle text-danger me-1"></i> Gagal Pengiriman
						</div>
					</div> -->
					{{ $paket->appends(request()->input())->links('vendor.pagination.bootstrap-4')}}
				</div>
				<div class="table-responsive">
				<table class="table table-stripped small" id="tabel-paket">
						<thead class="thead-light">
							<tr>
								<th class="text-center">No</th>
								<th class="text-center">Waybill No</th>
								<th class="text-center">Recipient Name</th>
								<th class="text-center">Note</th>
								<th class="text-center">Status</th>
								<th class="text-center">Action</th>								
								<th class="text-center">Overdue</th>
								<th class="text-center">Batch Order</th>
								<th class="text-center">Destination</th>
								<th class="text-center">Pick Up</th>
								<th class="text-center">Rp COD</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($paket as $p)
							<tr>
								<td class="text-center">
									{{ $loop->iteration }}
								</td>
								
								<td>{{ $p->waybill_no }}</td>
								<td>
									{{ $p->recipient_name }} <br>
									{{ $p->recipient_phone }}

								</td>
								<td class="text-center"><span class="badge {{ $p->IdexpressStatus->class ?? '' }}">{{ $p->IdexpressStatus->note ?? '-' }}</span>
								</td>
								<td>{!! wordwrap($p->waybill_status,25,"<br>\n") !!}</td>
								<td class="text-center">
									<div class="dropdown dropdown-action">
										<a href="#" class="btn btn-success btn-sm small action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">action</a>
										<div class="dropdown-menu dropdown-menu-right">
										<a class="dropdown-item" href="{{ url('paket/show') }}/{{ $p->id }}"><i class="far fa-eye me-2"></i>View</a>
											<a class="dropdown-item" href="{{ url('paket/resend-notif') }}/{{ $p->id }}"><i class="far fa-paper-plane me-2"></i>Resend Notif</a>
											<a class="dropdown-item" onclick="return confirm('Are you sure?')" href="{{ url('paket/delete') }}/{{ $p->id }}"><i class="far fa-trash-alt me-2"></i>Delete</a>
										</div>
									</div>
								</td>
								<td>
									<?php																		
									$overdue = $p->overdue .' Hari';// . ' Hari ' . $hours . ' Jam ';
									$class_overdue = $p->overdue > 3 ? 'text-warning' : ($p->overdue > 7 ? 'text-danger' : '');
									?>
									<span class="{{ $class_overdue }}">{{ $overdue }}</span>
								</td>
								<td>{{ $p->batch_id }} <br> {{ $p->order_no }}</td>
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

@endsection