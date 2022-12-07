@extends('layouts.admin')

@section('content')
<div class="row">
	<div class="col-xl-4 col-sm-6 col-12">
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
				</a>
			</div>
		</div>
	</div>
	<div class="col-xl-4 col-sm-6 col-12">
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
				</a>
			</div>
		</div>
	</div>
	<div class="col-xl-4 col-sm-6 col-12">
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
				</a>
			</div>
		</div>
	</div>

	<div class="col-xl-6 col-sm-6 col-12">
		<div class="card card-two">
			<div class="card-body">
				<a href="{{url('paket?filter_status=Dalam+Proses+Lebih+Dari+3+Hari&filter_from=&filter_to=')}}">
					<div class="dash-widget-header">
						<span class="dash-widget-icon bg-3 bg-one">
							<i class="mdi mdi-alarm-check" data-bs-toggle="tooltip" title="" data-bs-original-title="mdi-alarm-check" aria-label="mdi-alarm-check"></i>
						</span>
						<div class="dash-count">
							<div class="dash-title">Dalam Proses Lebih Dari 3 Hari</div>
							<div class="dash-counts">
								<p>{{ number_format($plus3 ?? 0) }}</p>
							</div>
						</div>
					</div>
				</a>
			</div>
		</div>
	</div>

	<div class="col-xl-6 col-sm-6 col-12">
		<div class="card card-two">
			<div class="card-body">
				<a href="{{url('paket?filter_status=Dalam+Proses+Lebih+Dari+7+Hari&filter_from=&filter_to=')}}">
					<div class="dash-widget-header">
						<span class="dash-widget-icon bg-3 bg-danger">
							<i class="mdi mdi-alarm" data-bs-toggle="tooltip" title="" data-bs-original-title="mdi-alarm-check" aria-label="mdi-alarm-check"></i>
						</span>
						<div class="dash-count">
							<div class="dash-title">Dalam Proses Lebih Dari 7 Hari</div>
							<div class="dash-counts">
								<p>{{ number_format($plus7 ?? 0) }}</p>
							</div>
						</div>
					</div>
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
					<table class="table table-stripped" id="tabel-paket">
						<thead class="thead-light">
							<tr>
								<th class="text-center">No</th>
								<th class="text-center">Batch Order</th>
								<th class="text-center">Waybill No</th>
								<th class="text-center">Pick Up</th>
								<th class="text-center">Destination</th>
								<th class="text-center">Recipient Name</th>
								<th class="text-center">Overdue</th>
								<th class="text-center">Status</th>
								<th>Note</th>
								<th class="text-center">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($paket as $p)
							<tr>
								<td class="text-center">
									{{ $loop->iteration }}
								</td>
								<td>{{ $p->batch_id }} <br> {{ $p->order_no }}</td>
								<td>{{ $p->waybill_no }}</td>
								<td>
									Start Time : {{ $p->pick_up_start_time }} <br>
									End Time : {{ $p->pick_up_end_time }} <br>
								</td>
								<td>
									{{ $p->destination }}
								</td>
								<td>
									{{ $p->recipient_name }} <br>
									{{ $p->recipient_phone }}

								</td>
								<td>
									<?php
									$now = $p->pick_up_end_time ? new DateTime($p->pick_up_end_time) : new DateTime();
									$overdue = new DateTime($p->pick_up_start_time);
									$interval = $now->diff($overdue);
									$days = $interval->format('%a');
									$hours = $interval->format('%h');
									$minutes = $interval->format('%i');
									$seconds = $interval->format('%s');
									$overdue = $days . ' Hari ' . $hours . ' Jam ';
									$class_overdue = $days > 3 ? 'text-warning' : ($days > 7 ? 'text-danger' : '');
									?>
									<span class="{{ $class_overdue }}">{{ $overdue }}</span>
								</td>
								<td class="text-center"><span class="badge {{ $p->IdexpressStatus->class ?? '' }}">{{ $p->IdexpressStatus->note ?? '-' }}</span>
								</td>
								<td>{{$p->waybill_status}}</td>
								<td class="text-center">
									<div class="dropdown dropdown-action">
										<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-h"></i></a>
										<div class="dropdown-menu dropdown-menu-right">
											<a class="dropdown-item" href="{{ url('paket/show') }}/{{ $p->id }}"><i class="far fa-eye me-2"></i>View</a>
											<a class="dropdown-item" href="{{ url('paket/resend-notif') }}/{{ $p->id }}"><i class="far fa-paper-plane me-2"></i>Resend Notif</a>
											<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-trash-alt me-2"></i>Delete</a>
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
<!-- /Page Content -->
@endsection
@section('js')
<script>
	$('#tabel-dashboard').DataTable()
</script>
@endsection