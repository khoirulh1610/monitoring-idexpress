@extends('layouts.admin')

@section('content')
<div class="row">
	<div class="col-xl-3 col-sm-4 col-12">
		<div class="card card-two">
			<div class="card-body">
				<a href="{{url('paket?filter_status=Delivered&filter_from=&filter_to=')}}">
					<div class="dash-widget-header">
						<span class="dash-widget-icon bg-1 bg-three">
							<i class="mdi mdi-airplane-landing" data-bs-toggle="tooltip" title="" data-bs-original-title="mdi-airplane-landing" aria-label="mdi-airplane-landing"></i>
						</span>
						<div class="dash-count">
							<div class="dash-title">Delivered</div>
							<div class="dash-counts">
								<p>{{ number_format($delivered ?? 0) }}</p>
							</div>
						</div>						
					</div>
					<p class="text-muted mt-3 mb-0"><span class="text-danger me-1">{{number_format($delivered/$all*100,2)}}%</span></p>
				</a>
			</div>
		</div>
	</div>
	<div class="col-xl-3 col-sm-4 col-12">
		<div class="card card-two">
			<div class="card-body">
				<a href="{{url('paket?filter_status=Dalam+Proses&filter_from=&filter_to=')}}">
					<div class="dash-widget-header">
						<span class="dash-widget-icon bg-2 bg-two">
							<i class="mdi mdi-airplane-takeoff" data-bs-toggle="tooltip" title="" data-bs-original-title="mdi-airplane-takeoff" aria-label="mdi-airplane-takeoff"></i>
						</span>
						<div class="dash-count">
							<div class="dash-title">Dalam Proses</div>
							<div class="dash-counts">
								<p>{{ number_format($onprocess ?? 0) }}</p>
							</div>
						</div>
					</div>
					<p class="text-muted mt-3 mb-0"><span class="text-danger me-1">{{number_format($onprocess/$all*100,2)}}%</span></p>
				</a>
			</div>
		</div>
	</div>
	<div class="col-xl-3 col-sm-4 col-12">
		<div class="card card-two">
			<div class="card-body">
				<a href="{{url('paket?filter_status=Gagal+Kirim&filter_from=&filter_to=')}}">
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
					<p class="text-muted mt-3 mb-0"><span class="text-danger me-1">{{number_format($gagal/$all*100,2)}}%</span></p>
				</a>
			</div>
		</div>
	</div>

	<div class="col-xl-3 col-sm-4 col-12">
		<div class="card card-two">
			<div class="card-body">
				<a href="{{url('paket?filter_status=Dalam+Proses+Lebih+Dari+3+Hari&filter_from=&filter_to=')}}">
					<div class="dash-widget-header">
						<span class="dash-widget-icon bg-3 bg-one">
							<i class="mdi mdi-alarm-check" data-bs-toggle="tooltip" title="" data-bs-original-title="mdi-alarm-check" aria-label="mdi-alarm-check"></i>
						</span>
						<div class="dash-count">
							<div class="dash-title">Proses 3D+</div>
							<div class="dash-counts">
								<p>{{ number_format($plus3 ?? 0) }}</p>
							</div>
						</div>
					</div>
					<p class="text-muted mt-3 mb-0"><span class="text-danger me-1">{{number_format($plus3/$all*100,2)}}%</span></p>
				</a>
			</div>
		</div>
	</div>

	<div class="col-xl-3 col-sm-4 col-12">
		<div class="card card-two">
			<div class="card-body">
				<a href="{{url('paket?filter_status=Dalam+Proses+Lebih+Dari+7+Hari&filter_from=&filter_to=')}}">
					<div class="dash-widget-header">
						<span class="dash-widget-icon bg-3 bg-danger">
							<i class="mdi mdi-alarm" data-bs-toggle="tooltip" title="" data-bs-original-title="mdi-alarm-check" aria-label="mdi-alarm-check"></i>
						</span>
						<div class="dash-count">
							<div class="dash-title">Proses 7D+</div>
							<div class="dash-counts">
								<p>{{ number_format($plus7 ?? 0) }}</p>
							</div>
						</div>
					</div>
					<p class="text-muted mt-3 mb-0"><span class="text-danger me-1">{{number_format($plus7/$all*100,2)}}%</span></p>
				</a>
			</div>
		</div>
	</div>

	<div class="col-xl-3 col-sm-4 col-12">
		<div class="card card-two">
			<div class="card-body">
				<a href="{{url('rts')}}">
					<div class="dash-widget-header">
						<span class="dash-widget-icon bg-3 bg-yellow">
							<i class="mdi mdi-alarm-check" data-bs-toggle="tooltip" title="" data-bs-original-title="mdi-alarm-check" aria-label="mdi-alarm-check"></i>
						</span>
						<div class="dash-count">
							<div class="dash-title">RTS</div>
							<div class="dash-counts">
								<p>{{ number_format($rts ?? 0) }}</p>
							</div>
						</div>
					</div>
					<p class="text-muted mt-3 mb-0"><span class="text-danger me-1">{{number_format($rts/$all*100,2)}}%</span></p>
				</a>
			</div>
		</div>
	</div>

	<div class="col-xl-3 col-sm-4 col-12">
		<div class="card card-two">
			<div class="card-body">
				<a href="{{url('paket?filter_status=belum_cek&filter_from=&filter_to=')}}">
					<div class="dash-widget-header">
						<span class="dash-widget-icon bg-3 bg-info">
							<i class="mdi mdi-database" data-bs-toggle="tooltip" title="" data-bs-original-title="mdi-alarm-check" aria-label="mdi-alarm-check"></i>
						</span>
						<div class="dash-count">
							<div class="dash-title">Pending CEK</div>
							<div class="dash-counts">
								<p>{{ number_format($belum_proses ?? 0) }}</p>
							</div>
						</div>
					</div>
					<p class="text-muted mt-3 mb-0"><span class="text-danger me-1">{{number_format($belum_proses/$all*100,2)}}%</span></p>
				</a>
			</div>
		</div>
	</div>
	<div class="col-xl-3 col-sm-4 col-12">
		<div class="card card-two">
			<div class="card-body">
				<a href="{{url('paket?filter_status=tidak_valid&filter_from=&filter_to=')}}">
					<div class="dash-widget-header">
						<span class="dash-widget-icon bg-3 bg-dark">
							<i class="mdi mdi-alert" data-bs-toggle="tooltip" title="" data-bs-original-title="mdi-alarm-check" aria-label="mdi-alarm-check"></i>
						</span>
						<div class="dash-count">
							<div class="dash-title">Tidak Valid</div>
							<div class="dash-counts">
								<p>{{ number_format($tidak_valid ?? 0) }}</p>
							</div>
						</div>
					</div>
					<p class="text-muted mt-3 mb-0"><span class="text-danger me-1">{{number_format($tidak_valid/$all*100,2)}}%</span></p>
				</a>
			</div>
		</div>
	</div>
</div>



<div class="row">
	<div class="col-sm-12">
		<div class="card card-two">
			<div class="card-header">
				<div class="row">
					<div class="col">
						<h5 class="card-title">Recent Update</h5>
					</div>
					<div class="col-auto">
						<a href="{{url('paket')}}" class="btn-right btn btn-sm btn-outline-primary">
							View All
						</a>
					</div>
				</div>
			</div>
			<div class="card-body">
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
								<!-- <th class="text-center">Batch Order</th> -->
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

								<td>{!! wordwrap($p->waybill_status,25,"<br>\n") !!}</td>
								<td class="text-center"><span class="badge {{ $p->IdexpressStatus->class ?? '' }}">{{ $p->IdexpressStatus->note ?? '-' }}</span>
								</td>

								<td class="text-center">
									<div class="dropdown dropdown-action">
										<a href="#" class="btn btn-success btn-sm small action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">action</a>
										<div class="dropdown-menu dropdown-menu-right dr" style="width: 250px;">
											<a class="dropdown-item" href="{{ url('paket/show') }}/{{ $p->id }}"><i class="far fa-eye me-2"></i>History Paket</a>
											<a class="dropdown-item" href="{{ url('paket/resend-notif') }}/{{ $p->id }}"><i class="far fa-paper-plane me-2"></i>Resend Notif</a>
											<a class="dropdown-item" href="{{ url('paket/update') }}/{{ $p->id }}?v=crm_monitoring"><i class="fas fa-share me-2"></i>Masukan CRM Monitoring</a>
											<a class="dropdown-item" href="{{ url('paket/update') }}/{{ $p->id }}?v=rts"><i class="fas fa-share me-2"></i>Pindahkan Ke RTS</a>
											<a class="dropdown-item" href="{{ url('paket/update') }}/{{ $p->id }}?v=terkirim"><i class="fas fa-share me-2"></i>Pindahkan Ke Terkirim</a>
											<a class="dropdown-item" href="{{ url('paket/update') }}/{{ $p->id }}?v=claim"><i class="fas fa-share me-2"></i>Pindahkan Ke Barang Hilang</a>
											<a class="dropdown-item" onclick="return confirm('Are you sure?')" href="{{ url('paket/delete') }}/{{ $p->id }}"><i class="far fa-trash-alt me-2"></i>Delete</a>
										</div>
									</div>
								</td>
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
		</div>
	</div>
</div>
<!-- /Page Content -->
@endsection
@section('js')
<script>
	$('#tabel-dashboard').DataTable()
</script>
@endsection