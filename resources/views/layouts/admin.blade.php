<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<title>Monitoring Paket</title>

	<!-- Favicon -->
	<link rel="shortcut icon" href="/assets/img/favicon.png">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="/assets/css/bootstrap.min.css">

	<!-- Select2 CSS -->
	<link rel="stylesheet" href="/assets/plugins/select2/css/select2.min.css">

	<!-- Datepicker CSS -->
	<link rel="stylesheet" href="/assets/css/bootstrap-datetimepicker.min.css">

	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="/assets/plugins/fontawesome/css/fontawesome.min.css">
	<link rel="stylesheet" href="/assets/plugins/fontawesome/css/all.min.css">
	<link rel="stylesheet" href="/assets/plugins/material/materialdesignicons.css">
	<!-- Main CSS -->
	<link rel="stylesheet" href="/assets/css/style.css">

	<!-- Datatble -->
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
	@yield('css')
</head>

<body>

	<!-- Main Wrapper -->
	<div class="main-wrapper">

		<!-- Header -->
		<div class="header header-two">

			<!-- Logo -->
			<div class="header-left header-left-two">
				<!-- Sidebar Toggle -->
				<a href="javascript:void(0);" id="toggle_btn">
					<i class="fas fa-bars"></i>
				</a>
				<!-- /Sidebar Toggle -->
				<a href="/" class="logo">
					<!-- <img src="/assets/img/logo-white.png" alt="Logo"> -->
					<span>WEBMON PAKET</span>
				</a>
				<a href="/" class="dark-logo">
					<!-- <img src="/assets/img/logo.png" alt="Logo"> -->
					<span>WEBMON PAKET</span>
				</a>
				<a href="/" class="logo logo-small">
					<!-- <img src="/assets/img/logo-small.png" alt="Logo" width="30" height="30"> -->
					<span>WEBMON PAKET</span>
				</a>
			</div>
			<!-- /Logo -->

			<!-- Search -->
			<!-- <div class="top-nav-search top-nav-search-two">
                <form>
                    <input type="text" class="form-control" placeholder="Search here">
                    <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div> -->
			<!-- /Search -->

			<!-- Mobile Menu Toggle -->
			<a class="mobile_btn mobile_btn-two" id="mobile_btn">
				<i class="fas fa-bars"></i>
			</a>
			<!-- /Mobile Menu Toggle -->

			<!-- Header Menu -->
			<ul class="nav nav-tabs user-menu user-menu-two">

				<!-- Notifications -->
				<li class="nav-item dropdown">
					<a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
						<i data-feather="bell"></i> <span class="badge rounded-pill">{{$gagal7}}</span>
					</a>
					<div class="dropdown-menu notifications">
						<div class="topnav-dropdown-header">
							<span class="notification-title">Notifications</span>
							<!--<a href="javascript:void(0)" class="clear-noti"> Clear All</a>-->
						</div>
						<div class="noti-content">
							<ul class="notification-list">
								@foreach($paketgagal as $pk)
								<li class="notification-message">
									<a href="{{url('paket/show/'.$pk->id)}}">
										<div class="media d-flex">
											<!--<span class="avatar avatar-sm">-->
											<!--	<img class="avatar-img rounded-circle" alt="" src="/assets/img/profiles/avatar-02.jpg">-->
											<!--</span>-->
											<div class="media-body">
												<p class="noti-details">
													<span class="noti-title">{{$pk->waybill_no}}</span>
													{!! strip_tags($pk->waybill_status)!!}
												</p>
												<p class="noti-time"><span class="notification-time">{{$pk->pick_up_end_time ?? $pk->last_cek_at}}</span></p>
											</div>
										</div>
									</a>
								</li>
								@endforeach
							</ul>
						</div>
						<div class="topnav-dropdown-footer">
							<a href="{{url('paket?filter_status=Gagal+Kirim&filter_from=&filter_to=')}}">View all</a>
						</div>
					</div>
				</li>
				<!-- /Notifications -->



				<!-- User Menu -->
				<li class="nav-item dropdown has-arrow main-drop">
					<a href="#" class="dropdown-toggle dropdown-toggle-two nav-link" data-bs-toggle="dropdown">
						<span class="user-img">
							<img src="/assets/img/profiles/avatar-01.jpg" alt="">
							<span class="status online"></span>
						</span>
						<span>{{ Auth::user()->name ?? '--' }}</span>
					</a>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="{{ url('profile') }}"><i data-feather="user" class="me-1"></i> Profile</a>
						<a class="dropdown-item" href="{{ url('logout') }}"><i data-feather="log-out" class="me-1"></i> Logout</a>
					</div>
				</li>
				<!-- /User Menu -->

			</ul>
			<!-- /Header Menu -->

		</div>
		<!-- /Header -->

		<!-- Sidebar -->
		<div class="sidebar sidebar-two" id="sidebar">
			<div class="sidebar-inner slimscroll">
				<div id="sidebar-menu" class="sidebar-menu sidebar-menu-two">
					<ul>
						<li class="menu-title menu-title-two"><span>Main</span></li>
						<li class="{{ request()->is('/') ? 'active' : '' }}">
							<a href="/"><i data-feather="home"></i> <span>Dashboard</span></a>
						</li>
						<li class="{{ request()->is('paket*') ? 'active' : '' }}">
							<a href="{{ url('paket') }}">
								<i class="mdi mdi-arrange-bring-forward" data-bs-toggle="tooltip" title="" data-bs-original-title="mdi-arrange-bring-forward" aria-label="mdi-arrange-bring-forward"></i>
								<span>Data Paket</span>
							</a>
						</li>
						<li class="{{ request()->is('crm-monitor*') ? 'active' : '' }}">
							<a href="{{ url('crm-monitor') }}">
								<i class="mdi mdi-arrange-bring-forward" data-bs-toggle="tooltip" title="" data-bs-original-title="mdi-arrange-bring-forward" aria-label="mdi-arrange-bring-forward"></i>
								<span>CRM Monitoring</span>
							</a>
						</li>

						<li class="{{ request()->is('claim*') ? 'active' : '' }}">
							<a href="{{ url('claim') }}">
								<i class="mdi mdi-arrange-bring-forward" data-bs-toggle="tooltip" title="" data-bs-original-title="mdi-arrange-bring-forward" aria-label="mdi-arrange-bring-forward"></i>
								<span>Paket Hilang (CLAIM)</span>
							</a>
						</li>

						<li class="{{ request()->is('rts*') ? 'active' : '' }}">
							<a href="{{ url('rts') }}">
								<i class="mdi mdi-arrange-bring-forward" data-bs-toggle="tooltip" title="" data-bs-original-title="mdi-arrange-bring-forward" aria-label="mdi-arrange-bring-forward"></i>
								<span>Paket RTS</span>
							</a>
						</li>

						<li class="{{ request()->is('message*') ? 'active' : '' }}">
							<a href="{{ route('message') }}">
								<i class="fas fa-paper-plane" data-bs-toggle="tooltip" title=""></i>
								<span>Message</span>
							</a>
						</li>
						<li class="submenu">
							<a href="#"><i data-feather="settings"></i> <span> Setting</span> <span class="menu-arrow"></span></a>
							<ul>
								<li><a href="/setting/notifikasi"></i> Notifikasi WA</a></li>
								<li><a href="/setting/user">Users</a></li>
								<li><a href="/setting/apiwa">APIWA</a></li>
							</ul>
						</li>

					</ul>
				</div>
			</div>
		</div>
		<!-- /Sidebar -->

		<!-- Page Wrapper -->
		<div class="page-wrapper">
			@if (\Session::has('success'))
			<div class="alert alert-success">
				<ul>
					<li>{!! \Session::get('success') !!}</li>
				</ul>
			</div>
			@endif
			@if (\Session::has('error'))
			<div class="alert alert-error">
				<ul>
					<li>{!! \Session::get('error') !!}</li>
				</ul>
			</div>
			@endif
			<div class="content container-fluid">
				@yield('content')
			</div>
		</div>
		<!-- /Page Wrapper -->

	</div>
	<!-- /Main Wrapper -->


	<!-- jQuery -->
	<script src="/assets/js/jquery-3.6.0.min.js"></script>

	<!-- Bootstrap Core JS -->
	<script src="/assets/js/bootstrap.bundle.min.js"></script>

	<!-- Feather Icon JS -->
	<script src="/assets/js/feather.min.js"></script>

	<!-- Slimscroll JS -->
	<script src="/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

	<script src="/assets/plugins/select2/js/select2.min.js"></script>
	<!-- Datepicker Core JS -->
	<script src="/assets/plugins/moment/moment.min.js"></script>
	<script src="/assets/js/bootstrap-datetimepicker.min.js"></script>

	<!-- Chart JS -->
	<script src="/assets/plugins/apexchart/apexcharts.min.js"></script>
	<script src="/assets/plugins/apexchart/chart-data.js"></script>

	<!-- Custom JS -->
	<script src="/assets/js/script.js"></script>

	<!-- Datatable JS -->
	<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

	<!-- Sweetalert JS -->
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

	@yield('js')

</body>

</html>