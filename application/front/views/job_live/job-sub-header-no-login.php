<header>
                    <div class="header">
                        <div class="container">
							<div class="row">
								<div class="col-md-4 col-sm-4 left-header col-xs-4 fw-479">
									<?php $this->load->view('main_logo'); ?>
								</div>
								<div class="col-md-8 col-sm-8 right-header col-xs-8 fw-479">
									<div class="btn-right other-hdr">
										<?php if (!$this->session->userdata('aileenuser')) { ?>
											<ul class="nav navbar-nav navbar-right test-cus drop-down">
												<?php $this->load->view('profile-dropdown'); ?>
												<li class="hidden-991"><a href="<?php echo base_url('login'); ?>" tabindex="9" class="btn8">Login</a></li>
												<li class="hidden-991"><a href="<?php echo base_url(); ?>job-profile/create-account" tabindex="10" class="btn9">Create Job Profile</a></li>
												<li class="mob-bar-li">
													<span class="mob-right-bar">
														<?php $this->load->view('mobile_right_bar'); ?>
													</span>
												</li>
											
											</ul>
										<?php } ?>
									</div>
								</div>
							</div>
                            
                        </div>
                    </div>
                </header>
				<div class="ld-sub-header">
					<div class="container">
						<div class="web-ld-sub">
							<ul class="">
								<li><a href="<?php echo base_url('job-search'); ?>">Job Profile</a></li>
								<li><a href="<?php echo base_url('jobs-by-categories'); ?>">Jobs by Category</a></li>
								<li><a href="<?php echo base_url('jobs-by-skills'); ?>">Jobs by Skill</a></li>
								<li><a href="<?php echo base_url('jobs-by-designations'); ?>">Jobs by Designation</a></li>
								<li><a href="<?php echo base_url('jobs-by-companies'); ?>">Jobs by Company</a></li>
								<li><a href="<?php echo base_url('jobs-by-location'); ?>">Jobs by Location</a></li>
							</ul>
						</div>
						<div class="mob-ld-sub">
							<ul class="">
								<li class="tab-first-li">
									<a href="javascript:void(0);">Jobs</a>
									<ul>
										<li><a href="<?php echo base_url('job-search'); ?>">Job Profile</a></li>
										<li><a href="<?php echo base_url('jobs-by-categories'); ?>">Jobs by Category</a></li>
										<li><a href="<?php echo base_url('jobs-by-skills'); ?>">Jobs by Skill</a></li>
										<li><a href="<?php echo base_url('jobs-by-designations'); ?>">Jobs by Designation</a></li>
										<li><a href="<?php echo base_url('jobs-by-companies'); ?>">Jobs by Company</a></li>
										<li><a href="<?php echo base_url('jobs-by-location'); ?>">Jobs by Location</a></li>
									</ul>
									
								</li>
								<li><a href="<?php echo base_url('login'); ?>">Login</a></li>
								<li><a href="<?php echo base_url(); ?>job-profile/create-account">Create Job Profile</a></li>
							</ul>
						</div>
					</div>
				</div>