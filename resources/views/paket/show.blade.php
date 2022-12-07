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
						<h6>Tanggal Pengiriman</h6>
					</li>
					<li>
						{{ $data['shippingTime'] }}
					</li>					
					<li class="pt-2 pb-0">
						<h6>Pengirim</h6>
					</li>
					<li>
						{{ $data['senderName'] }}, {{ $data['senderDistrictName'] }} - {{ $data['senderCityName'] }}
					</li>					
					<li class="pt-2 pb-0">
						<h6>Penerima</h6>
					</li>
					<li>
						{{ $data['recipientName'] }}, {{ $data['recipientDistrictName'] }}, {{ $data['recipientCityName'] }}
					</li>
				</ul>
			</div>
		</div>

	</div>

	<div class="col-lg-8">
		<div class="card">
			<div class="card-header">
				<h5 class="card-title">Status</h5>
			</div>
			<div class="card-body card-body-height">
				<ul class="activity-feed">
					@foreach($data['scanLineVOS'] as $d)
					<li class="feed-item">
						<div class="feed-date">{{$d['operationTime']}}</div>
						<?php
							$status = \App\Models\IdexpressStatus::where('operationType',$d['operationType'])->first();
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