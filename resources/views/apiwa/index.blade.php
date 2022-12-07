@extends('layouts.admin')

@section('content')
<div class="row">
	<div class="col-md-12 col-sm-12">
		<div class="card card-two">
			<div class="card-header">
				<div class="row">
					<div class="col">
						<h5 class="card-title">APIWA</h5>
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">

					<table class="table table-stripped table-hover">
						<thead class="thead-light">
							<tr>
								<th>No</th>
								<th>Server Name</th>
								<th>Host</th>
								<th>Phone</th>
								<th>Name</th>
								<th>Image Profile</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($apiwa as $p)
							<tr>
								<td>
									{{ $loop->iteration }}
								</td>
								<td>{{$p->name}}</td>
								<td>{{$p->host}}</td>
								<td>{{$p->wa_phone}}</td>
								<td>
									{{$p->wa_name}}
								</td>
								<td>
									<img src="{{$p->wa_profile}}" alt="" srcset="" style="width:30px">
								</td>
								<td>
									{{$p->status==1 ? 'online' : '-'}}
								</td>
								<td>
									@if($p->name=='Tokalink')
									<a href="{{$p->host}}/qr/{{$p->apikey}}" onclick="window.open('{{$p->host}}/qr/{{$p->apikey}}', 'newwindow','width=500,height=450');return false;" target="_blank">
										<i class="fas fa-qrcode"></i>
									</a>
									@endif
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
@endsection