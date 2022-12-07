@extends('layouts.admin')

@section('content')
<div class="row">
	<div class="card">
		<div class="card-header">
			<h5 class="card-title">Upload Data Paket</h5>
			<p class="card-text">Upload data csv</p>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-sm">
					<form class="{{isset($error) ? 'was-validated' : '' }}" action="{{url('paket/upload')}}" method="post" enctype="multipart/form-data">
						@csrf
						<div class="mb-3">
							<input type="file" class="form-control" aria-label="file example" name="file" required="" accept=".csv">
							<!-- <div class="invalid-feedback">Example invalid form file feedback</div> -->
						</div>
						<button type="submit" class="btn btn-primary">Upload</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection