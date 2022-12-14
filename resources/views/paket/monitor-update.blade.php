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
				<br>
				<hr>
				<div class="row">
					<form action="" method="post">
						@csrf
						<input type="hidden" name="id" value="{{$paket->id}}">
						<div class="col-12">
							<label for="problem_paket">Problem Paket</label>
							<textarea name="problem_paket" id="problem_paket" rows="3" class="form-control">{{$paket->problem_paket}}</textarea>
						</div>
						<div class="col-12">
							<label for="checker">Checker</label>
							<textarea name="checker" id="checker" rows="3" class="form-control">{{$paket->checker}}</textarea>
						</div>
						<div class="col-12">
							<label for="img_url">Update Bukti (Link, pisahkan dengan koma[,]) jika lebih dari 1)</label>
							<textarea name="img_url" id="img_url" rows="3" class="form-control">{{$paket->img_url}}</textarea>
						</div>
						<div class="col-12">
							<br>
							<button type="submit" class="btn btn-info">Submit</button>
						</div>
					</form>
				</div>
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
								<!-- <a class="dropdown-item" href="{{ url('paket/update') }}/{{ $paket->id }}?v=crm_monitoring"><i class="fas fa-share me-2"></i>Masukan CRM Monitoring</a> -->
								<a class="dropdown-item" href="{{ url('paket/update') }}/{{ $paket->id }}?v=rts"><i class="fas fa-share me-2"></i>Pindahkan Ke RTS</a>
								<a class="dropdown-item" href="{{ url('paket/update') }}/{{ $paket->id }}?v=terkirim"><i class="fas fa-share me-2"></i>Pindahkan Ke Terkirim</a>
								<a class="dropdown-item" href="{{ url('paket/update') }}/{{ $paket->id }}?v=claim"><i class="fas fa-share me-2"></i>Pindahkan Ke Barang Hilang</a>
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