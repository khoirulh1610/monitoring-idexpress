@extends('layouts.admin')
@section('content')
<div class="row">
	<div class="col-lg-4">
		<div class="card">
			<div class="card-header">
				<h5 class="card-title d-flex justify-content-between">
					<span>Detail Pengiriman</span>
				</h5>
			</div>
			<div class="card-body">
				<ul class="list-unstyled mb-0">
					<li class="py-0">
						<h6>WaybillNo</h6>
					</li>
					<li>
						{{$data['waybillNo']??'-'}}
					</li> <br>
					<li class="py-0">
						<h6>Tanggal Pengiriman</h6>
					</li>
					<li>
						{{ $data['shippingTime'] }}
					</li><br>
					<li class="pt-2 pb-0">
						<h6>Pengirim</h6>
					</li>
					<li>
						{{ $data['senderName'] }}, {{ $data['senderDistrictName'] }} - {{ $data['senderCityName'] }}
					</li><br>
					<li class="pt-2 pb-0">
						<h6>Penerima</h6>
					</li>
					<li>
						{{ $data['recipientName'] }}, {{ $data['recipientDistrictName'] }}, {{ $data['recipientCityName'] }} <br>
						{{ $paket->recipient_phone }}
					</li>
				</ul>
			</div>
		</div>

	</div>

	<div class="col-lg-8">
		<div class="card">
			<div class="card-header">
				<div class="d-flex justify-content-between align-items-center">
					<h5 class="card-title">Status</h5>

					<div class="dropdown">
						<button class="btn btn-white btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
							Action
						</button>
						<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
							<li>
								<a class="dropdown-item" href="{{ url('paket/resend-notif') }}/{{ $paket->id }}"><i class="far fa-paper-plane me-2"></i>Resend Notif</a>
							</li>
							<li>
								<a class="dropdown-item" onclick="return confirm('Are you sure?')" href="{{ url('paket/delete') }}/{{ $paket->id }}"><i class="far fa-trash-alt me-2"></i>Delete</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="card-body card-body-height">
				<ul class="activity-feed">
					@foreach($data['scanLineVOS'] as $d)
					<li class="feed-item">
						<div class="feed-date">{{$d['operationTime']}}</div>
						<?php
						$status = \App\Models\IdexpressStatus::where('operationType', $d['operationType'])->first();
						$col = $status->col ?? 'operationType';
						?>
						<span class="feed-text">{!! $status->description ?? '-' !!} <b> {{$d[$col]}}</b></span>
					</li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>
</div>
@endsection