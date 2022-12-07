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
		
		<!-- Fontawesome CSS -->
		<link rel="stylesheet" href="/assets/plugins/fontawesome/css/fontawesome.min.css">
		<link rel="stylesheet" href="/assets/plugins/fontawesome/css/all.min.css">
		<link rel="stylesheet" href="/assets/plugins/material/materialdesignicons.css">
		<!-- Main CSS -->
		<link rel="stylesheet" href="/assets/css/style.css">
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
					<a href="index.html" class="logo">
						<img src="/assets/img/logo-white.png" alt="Logo">
					</a>
					<a href="index.html" class="dark-logo">
						<img src="/assets/img/logo.png" alt="Logo">
					</a>
					<a href="index.html" class="logo logo-small">
						<img src="/assets/img/logo-small.png" alt="Logo" width="30" height="30">
					</a>
				</div>
				<!-- /Logo -->
								
				<!-- Search -->
				<div class="top-nav-search top-nav-search-two">
					<form>
						<input type="text" class="form-control" placeholder="Search here">
						<button class="btn" type="submit"><i class="fas fa-search"></i></button>
					</form>
				</div>
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
							<i data-feather="bell"></i> <span class="badge rounded-pill">5</span>
						</a>
						<div class="dropdown-menu notifications">
							<div class="topnav-dropdown-header">
								<span class="notification-title">Notifications</span>
								<a href="javascript:void(0)" class="clear-noti"> Clear All</a>
							</div>
							<div class="noti-content">
								<ul class="notification-list">
									<li class="notification-message">
										<a href="activities.html">
											<div class="media d-flex">
												<span class="avatar avatar-sm">
													<img class="avatar-img rounded-circle" alt="" src="/assets/img/profiles/avatar-02.jpg">
												</span>
												<div class="media-body">
													<p class="noti-details"><span class="noti-title">Brian Johnson</span> paid the invoice <span class="noti-title">#DF65485</span></p>
													<p class="noti-time"><span class="notification-time">4 mins ago</span></p>
												</div>
											</div>
										</a>
									</li>
									<li class="notification-message">
										<a href="activities.html">
											<div class="media d-flex">
												<span class="avatar avatar-sm">
													<img class="avatar-img rounded-circle" alt="" src="/assets/img/profiles/avatar-03.jpg">
												</span>
												<div class="media-body">
													<p class="noti-details"><span class="noti-title">Marie Canales</span> has accepted your estimate <span class="noti-title">#GTR458789</span></p>
													<p class="noti-time"><span class="notification-time">6 mins ago</span></p>
												</div>
											</div>
										</a>
									</li>
									<li class="notification-message">
										<a href="activities.html">
											<div class="media d-flex">
												<div class="avatar avatar-sm">
													<span class="avatar-title rounded-circle bg-primary-light"><i class="far fa-user"></i></span>
												</div>
												<div class="media-body">
													<p class="noti-details"><span class="noti-title">New user registered</span></p>
													<p class="noti-time"><span class="notification-time">8 mins ago</span></p>
												</div>
											</div>
										</a>
									</li>
									<li class="notification-message">
										<a href="activities.html">
											<div class="media d-flex">
												<span class="avatar avatar-sm">
													<img class="avatar-img rounded-circle" alt="" src="/assets/img/profiles/avatar-04.jpg">
												</span>
												<div class="media-body">
													<p class="noti-details"><span class="noti-title">Barbara Moore</span> declined the invoice <span class="noti-title">#RDW026896</span></p>
													<p class="noti-time"><span class="notification-time">12 mins ago</span></p>
												</div>
											</div>
										</a>
									</li>
									<li class="notification-message">
										<a href="activities.html">
											<div class="media d-flex">
												<div class="avatar avatar-sm">
													<span class="avatar-title rounded-circle bg-info-light"><i class="far fa-comment"></i></span>
												</div>
												<div class="media-body">
													<p class="noti-details"><span class="noti-title">You have received a new message</span></p>
													<p class="noti-time"><span class="notification-time">2 days ago</span></p>
												</div>
											</div>
										</a>
									</li>
								</ul>
							</div>
							<div class="topnav-dropdown-footer">
								<a href="activities.html">View all Notifications</a>
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
							<span>Admin</span>
						</a>
						<div class="dropdown-menu">
							<a class="dropdown-item" href="{{url('profile')}}"><i data-feather="user" class="me-1"></i> Profile</a>							
							<a class="dropdown-item" href="{{url('logout')}}"><i data-feather="log-out" class="me-1"></i> Logout</a>
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
							<li class="active">
								<a href="index.html"><i data-feather="home"></i> <span>Dashboard</span></a>
							</li>
							<li>
								<a href="{{url('paket')}}">
                                    <i class="mdi mdi-arrange-bring-forward" data-bs-toggle="tooltip" title="" data-bs-original-title="mdi-arrange-bring-forward" aria-label="mdi-arrange-bring-forward"></i>
                                    <span>Data Paket</span>
                                </a>
							</li>
							<li class="submenu">
								<a href="#"><i data-feather="clipboard"></i> <span> Setting</span> <span class="menu-arrow"></span></a>
								<ul>
									<li><a href="invoices.html">Notifikasi Whatsapp</a></li>	
                                    <li><a href="invoices.html">Users</a></li>										
								</ul>                               
							</li>
							
						</ul>
					</div>
				</div>
			</div>
			<!-- /Sidebar -->
			
			<!-- Page Wrapper -->
			<div class="page-wrapper">
				<div class="content container-fluid">

					<div class="row">
						<div class="col-xl-4 col-sm-6 col-12">
							<div class="card card-two">
								<div class="card-body">
									<div class="dash-widget-header">
										<span class="dash-widget-icon bg-1 bg-three">
                                        <i class="mdi mdi-airplane-landing" data-bs-toggle="tooltip" title="" data-bs-original-title="mdi-airplane-landing" aria-label="mdi-airplane-landing"></i>
										</span>
										<div class="dash-count">
											<div class="dash-title">Delivered</div>
											<div class="dash-counts">
												<p>1,642</p>
											</div>
										</div>
									</div>																		
								</div>
							</div>
						</div>
						<div class="col-xl-4 col-sm-6 col-12">
							<div class="card card-two">
								<div class="card-body">
									<div class="dash-widget-header">
										<span class="dash-widget-icon bg-2 bg-two">
                                        <i class="mdi mdi-airplane-takeoff" data-bs-toggle="tooltip" title="" data-bs-original-title="mdi-airplane-takeoff" aria-label="mdi-airplane-takeoff"></i>
										</span>
										<div class="dash-count">
											<div class="dash-title">Dalam Proses</div>
											<div class="dash-counts">
												<p>3,642</p>
											</div>
										</div>
									</div>									
								</div>
							</div>
						</div>
						<div class="col-xl-4 col-sm-6 col-12">
							<div class="card card-two">
								<div class="card-body">
									<div class="dash-widget-header">
										<span class="dash-widget-icon bg-3 bg-one">
                                        <i class="mdi mdi-airplane-off" data-bs-toggle="tooltip" title="" data-bs-original-title="mdi-airplane-off" aria-label="mdi-airplane-off"></i>
										</span>
										<div class="dash-count">
											<div class="dash-title">Gagal Kirim</div>
											<div class="dash-counts">
												<p>1,041</p>
											</div>
										</div>
									</div>									
								</div>
							</div>
						</div>						
					</div>
					
					

					<div class="row">
						<div class="col-md-6 col-sm-6">
							<div class="card card-two">
								<div class="card-header">
									<div class="row">
										<div class="col">
											<h5 class="card-title">Recent Waybill</h5>
										</div>
										<div class="col-auto">
											<a href="invoices.html" class="btn-right btn btn-sm btn-outline-primary">
												View All 
											</a>
										</div>
									</div>
								</div>
								<div class="card-body">
									<div class="mb-3">
										<div class="progress progress-md rounded-pill mb-3">
											<div class="progress-bar bg-success" role="progressbar" style="width: 47%" aria-valuenow="47" aria-valuemin="0" aria-valuemax="100"></div>
											<div class="progress-bar bg-warning" role="progressbar" style="width: 28%" aria-valuenow="28" aria-valuemin="0" aria-valuemax="100"></div>
											<div class="progress-bar bg-danger" role="progressbar" style="width: 15%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
											<div class="progress-bar bg-info" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
										<div class="row">
											<div class="col-auto">
												<i class="fas fa-circle text-success me-1"></i> Paid
											</div>
											<div class="col-auto">
												<i class="fas fa-circle text-warning me-1"></i> Unpaid
											</div>
											<div class="col-auto">
												<i class="fas fa-circle text-danger me-1"></i> Overdue
											</div>
											<div class="col-auto">
												<i class="fas fa-circle text-info me-1"></i> Draft
											</div>
										</div>
									</div>
				
									<div class="table-responsive">
									
										<table class="table table-stripped table-hover">
											<thead class="thead-light">
												<tr>
												   <th>Customer</th>
												   <th>Amount</th>
												   <th>Due Date</th>
												   <th>Status</th>
												   <th class="text-right">Action</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>
														<h2 class="table-avatar">
															<a href="profile.html"><img class="avatar avatar-sm me-2 avatar-img rounded-circle" src="/assets/img/profiles/avatar-04.jpg" alt="User Image">Barbara Moore</a>
														</h2>
													</td>
													<td>$118</td>
													<td>23 Nov 2020</td>
													<td><span class="badge bg-success-light">Paid</span></td>
													<td class="text-right">
														<div class="dropdown dropdown-action">
															<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-h"></i></a>
															<div class="dropdown-menu dropdown-menu-right">
																<a class="dropdown-item" href="edit-invoice.html"><i class="far fa-edit me-2"></i>Edit</a>
																<a class="dropdown-item" href="view-invoice.html"><i class="far fa-eye me-2"></i>View</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-trash-alt me-2"></i>Delete</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-check-circle me-2"></i>Mark as sent</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-paper-plane me-2"></i>Send Invoice</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-copy me-2"></i>Clone Invoice</a>
															</div>
														</div>
													</td>
												</tr>
												<tr>
													<td>
														<h2 class="table-avatar">
															<a href="profile.html"><img class="avatar avatar-sm me-2 avatar-img rounded-circle" src="/assets/img/profiles/avatar-06.jpg" alt="User Image">Karlene Chaidez</a>
														</h2>
													</td>
													<td>$222</td>
													<td>18 Nov 2020</td>
													<td><span class="badge bg-info-light">Sent</span></td>
													<td class="text-right">
														<div class="dropdown dropdown-action">
															<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-h"></i></a>
															<div class="dropdown-menu dropdown-menu-right">
																<a class="dropdown-item" href="edit-invoice.html"><i class="far fa-edit me-2"></i>Edit</a>
																<a class="dropdown-item" href="view-invoice.html"><i class="far fa-eye me-2"></i>View</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-trash-alt me-2"></i>Delete</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-check-circle me-2"></i>Mark as sent</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-paper-plane me-2"></i>Send Invoice</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-copy me-2"></i>Clone Invoice</a>
															</div>
														</div>
													</td>
												</tr>
												<tr>
													<td>
														<h2 class="table-avatar">
															<a href="profile.html"><img class="avatar avatar-sm me-2 avatar-img rounded-circle" src="/assets/img/profiles/avatar-08.jpg" alt="User Image">Russell Copeland</a>
														</h2>
													</td>
													<td>$347</td>
													<td>10 Nov 2020</td>
													<td><span class="badge bg-warning-light">Partially Paid</span></td>
													<td class="text-right">
														<div class="dropdown dropdown-action">
															<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-h"></i></a>
															<div class="dropdown-menu dropdown-menu-right">
																<a class="dropdown-item" href="edit-invoice.html"><i class="far fa-edit me-2"></i>Edit</a>
																<a class="dropdown-item" href="view-invoice.html"><i class="far fa-eye me-2"></i>View</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-trash-alt me-2"></i>Delete</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-check-circle me-2"></i>Mark as sent</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-paper-plane me-2"></i>Send Invoice</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-copy me-2"></i>Clone Invoice</a>
															</div>
														</div>
													</td>
												</tr>
												<tr>
													<td>
														<h2 class="table-avatar">
															<a href="profile.html"><img class="avatar avatar-sm me-2 avatar-img rounded-circle" src="/assets/img/profiles/avatar-10.jpg" alt="User Image">Joseph Collins</a>
														</h2>
													</td>
													<td>$826</td>
													<td>25 Sep 2020</td>
													<td><span class="badge bg-danger-light">Overdue</span></td>
													<td class="text-right">
														<div class="dropdown dropdown-action">
															<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-h"></i></a>
															<div class="dropdown-menu dropdown-menu-right">
																<a class="dropdown-item" href="edit-invoice.html"><i class="far fa-edit me-2"></i>Edit</a>
																<a class="dropdown-item" href="view-invoice.html"><i class="far fa-eye me-2"></i>View</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-trash-alt me-2"></i>Delete</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-check-circle me-2"></i>Mark as sent</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-paper-plane me-2"></i>Send Invoice</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-copy me-2"></i>Clone Invoice</a>
															</div>
														</div>
													</td>
												</tr>
												<tr>
													<td>
														<h2 class="table-avatar">
															<a href="profile.html"><img class="avatar avatar-sm me-2 avatar-img rounded-circle" src="/assets/img/profiles/avatar-11.jpg" alt="User Image">Jennifer Floyd</a>
														</h2>
													</td>
													<td>$519</td>
													<td>18 Sep 2020</td>
													<td><span class="badge bg-success-light">Paid</span></td>
													<td class="text-right">
														<div class="dropdown dropdown-action">
															<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-h"></i></a>
															<div class="dropdown-menu dropdown-menu-right">
																<a class="dropdown-item" href="edit-invoice.html"><i class="far fa-edit me-2"></i>Edit</a>
																<a class="dropdown-item" href="view-invoice.html"><i class="far fa-eye me-2"></i>View</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-trash-alt me-2"></i>Delete</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-check-circle me-2"></i>Mark as sent</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-paper-plane me-2"></i>Send Invoice</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-copy me-2"></i>Clone Invoice</a>
															</div>
														</div>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
							<div class="card card-two">
								<div class="card-header">
									<div class="row">
										<div class="col">
											<h5 class="card-title">Recent Update</h5>
										</div>
										<div class="col-auto">
											<a href="estimates.html" class="btn-right btn btn-sm btn-outline-primary">
												View All 
											</a>
										</div>
									</div>
								</div>
								<div class="card-body">
									<div class="mb-3">
										<div class="progress progress-md rounded-pill mb-3">
											<div class="progress-bar bg-success" role="progressbar" style="width: 39%" aria-valuenow="39" aria-valuemin="0" aria-valuemax="100"></div>
											<div class="progress-bar bg-danger" role="progressbar" style="width: 35%" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
											<div class="progress-bar bg-warning" role="progressbar" style="width: 26%" aria-valuenow="26" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
										<div class="row">
											<div class="col-auto">
												<i class="fas fa-circle text-success me-1"></i> Sent
											</div>
											<div class="col-auto">
												<i class="fas fa-circle text-warning me-1"></i> Draft
											</div>
											<div class="col-auto">
												<i class="fas fa-circle text-danger me-1"></i> Expired
											</div>
										</div>
									</div>
									<div class="table-responsive">
										<table class="table table-hover">
											<thead class="thead-light">
												<tr>
													<th>Customer</th>
													<th>Expiry Date</th>
													<th>Amount</th>
													<th>Status</th>
													<th class="text-right">Action</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>
														<h2 class="table-avatar">
															<a href="profile.html"><img class="avatar avatar-sm me-2 avatar-img rounded-circle" src="/assets/img/profiles/avatar-05.jpg" alt="User Image"> Greg Lynch</a>
														</h2>
													</td>
													<td>5 Nov 2020</td>
													<td>$175</td>
													<td><span class="badge bg-info-light">Sent</span></td>
													<td class="text-right">
														<div class="dropdown dropdown-action">
															<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-h"></i></a>
															<div class="dropdown-menu dropdown-menu-right">
																<a class="dropdown-item" href="edit-invoice.html"><i class="far fa-edit me-2"></i>Edit</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-trash-alt me-2"></i>Delete</a>
																<a class="dropdown-item" href="view-estimate.html"><i class="far fa-eye me-2"></i>View</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-file-alt me-2"></i>Convert to Invoice</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-check-circle me-2"></i>Mark as sent</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-paper-plane me-2"></i>Send Estimate</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-check-circle me-2"></i>Mark as Accepted</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-times-circle me-2"></i>Mark as Rejected</a>
															</div>
														</div>
													</td>
												</tr>
												<tr>
													<td>
														<h2 class="table-avatar">
															<a href="profile.html"><img class="avatar avatar-sm me-2 avatar-img rounded-circle" src="/assets/img/profiles/avatar-06.jpg" alt="User Image"> Karlene Chaidez</a>
														</h2>
													</td>
													<td>28 Oct 2020</td>
													<td>$1500</td>
													<td><span class="badge bg-warning-light">Expired</span></td>
													<td class="text-right">
														<div class="dropdown dropdown-action">
															<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-h"></i></a>
															<div class="dropdown-menu dropdown-menu-right">
																<a class="dropdown-item" href="edit-invoice.html"><i class="far fa-edit me-2"></i>Edit</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-trash-alt me-2"></i>Delete</a>
																<a class="dropdown-item" href="view-estimate.html"><i class="far fa-eye me-2"></i>View</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-file-alt me-2"></i>Convert to Invoice</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-check-circle me-2"></i>Mark as sent</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-paper-plane me-2"></i>Send Estimate</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-check-circle me-2"></i>Mark as Accepted</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-times-circle me-2"></i>Mark as Rejected</a>
															</div>
														</div>
													</td>
												</tr>
												<tr>
													<td>
														<h2 class="table-avatar">
															<a href="profile.html"><img class="avatar avatar-sm me-2 avatar-img rounded-circle" src="/assets/img/profiles/avatar-07.jpg" alt="User Image"> John Blair</a>
														</h2>
													</td>
													<td>17 Oct 2020</td>
													<td>$2350</td>
													<td><span class="badge bg-success-light">Accepted</span></td>
													<td class="text-right">
														<div class="dropdown dropdown-action">
															<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-h"></i></a>
															<div class="dropdown-menu dropdown-menu-right">
																<a class="dropdown-item" href="edit-invoice.html"><i class="far fa-edit me-2"></i>Edit</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-trash-alt me-2"></i>Delete</a>
																<a class="dropdown-item" href="view-estimate.html"><i class="far fa-eye me-2"></i>View</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-file-alt me-2"></i>Convert to Invoice</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-check-circle me-2"></i>Mark as sent</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-paper-plane me-2"></i>Send Estimate</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-check-circle me-2"></i>Mark as Accepted</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-times-circle me-2"></i>Mark as Rejected</a>
															</div>
														</div>
													</td>
												</tr>
												<tr>
													<td>
														<h2 class="table-avatar">
															<a href="profile.html"><img class="avatar avatar-sm me-2 avatar-img rounded-circle" src="/assets/img/profiles/avatar-08.jpg" alt="User Image"> Russell Copeland</a>
														</h2>
													</td>
													<td>8 Oct 2020</td>
													<td>$1890</td>
													<td><span class="badge bg-success-light">Accepted</span></td>
													<td class="text-right">
														<div class="dropdown dropdown-action">
															<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-h"></i></a>
															<div class="dropdown-menu dropdown-menu-right">
																<a class="dropdown-item" href="edit-invoice.html"><i class="far fa-edit me-2"></i>Edit</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-trash-alt me-2"></i>Delete</a>
																<a class="dropdown-item" href="view-estimate.html"><i class="far fa-eye me-2"></i>View</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-file-alt me-2"></i>Convert to Invoice</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-check-circle me-2"></i>Mark as sent</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-paper-plane me-2"></i>Send Estimate</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-check-circle me-2"></i>Mark as Accepted</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-times-circle me-2"></i>Mark as Rejected</a>
															</div>
														</div>
													</td>
												</tr>
												<tr>
													<td>
														<h2 class="table-avatar">
															<a href="profile.html"><img class="avatar avatar-sm me-2 avatar-img rounded-circle" src="/assets/img/profiles/avatar-09.jpg" alt="User Image"> Leatha Bailey</a>
														</h2>
													</td>
													<td>30 Sep 2020</td>
													<td>$785</td>
													<td><span class="badge bg-success-light">Accepted</span></td>
													<td class="text-right">
														<div class="dropdown dropdown-action">
															<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-h"></i></a>
															<div class="dropdown-menu dropdown-menu-right">
																<a class="dropdown-item" href="edit-invoice.html"><i class="far fa-edit me-2"></i>Edit</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-trash-alt me-2"></i>Delete</a>
																<a class="dropdown-item" href="view-estimate.html"><i class="far fa-eye me-2"></i>View</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-file-alt me-2"></i>Convert to Invoice</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-check-circle me-2"></i>Mark as sent</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-paper-plane me-2"></i>Send Estimate</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-check-circle me-2"></i>Mark as Accepted</a>
																<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-times-circle me-2"></i>Mark as Rejected</a>
															</div>
														</div>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
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
		
		<!-- Chart JS -->
		<script src="/assets/plugins/apexchart/apexcharts.min.js"></script>
		<script src="/assets/plugins/apexchart/chart-data.js"></script>
		
		<!-- Custom JS -->
		<script src="/assets/js/script.js"></script>

	</body>
</html>