<link rel="stylesheet" href="<?php echo base_url('assets/n-css/component.css?ver=' . time()) ?>">
<!-- <div class="sm-header">
    <header class="terms-con bg-none">
        <div class="overlaay">
            <div class="container">
                <div class="row">
                            <div class="col-md-4 col-sm-4 left-header col-xs-4 fw-479">
								<?php $this->load->view('main_logo'); ?>
                            </div>
                            <div class="col-md-8 col-sm-8 right-header col-xs-8 fw-479">
                                <div class="btn-right">
                                <?php if(!$this->session->userdata('aileenuser')) {?>
									<ul class="nav navbar-nav navbar-right test-cus drop-down">
										<?php $this->load->view('profile-dropdown'); ?>
										<li><a href="<?php echo base_url('login'); ?>" class="btn2">Login</a></li>
										<li><a href="<?php echo base_url('registration'); ?>" class="btn3">Create an account</a></li>
										<li class="mob-bar-li">
											<span class="mob-right-bar">
												<?php $this->load->view('mobile_right_bar'); ?>
											</span>
										</li>
									
									</ul>
                                <?php }?>
                                </div>
                            </div>
                        </div>
            </div>
        </div>
    </header>
    <div class="site-map-all-profile cust-site">
        <div class="container">
            <h1 class="text-center"><a href="<?php echo base_url('sitemap') ?>"> Sitemap </a></h1>
            <div class="fw text-center">
                <ul>
                    <li><a href="<?php echo base_url('sitemap/job-profile') ?>" class="<?php if($this->uri->segment(2) == 'job-profile'){ echo 'sitemap_active'; } ?>">Job Profile</a></li>
                    <li><a href="<?php echo base_url('sitemap/recruiter-profile') ?>" class="<?php if($this->uri->segment(2) == 'recruiter-profile'){ echo 'sitemap_active'; } ?>">Recruiter Profile</a></li>
                    <li><a href="<?php echo base_url('sitemap/freelance-profile') ?>" class="<?php if($this->uri->segment(2) == 'freelance-profile'){ echo 'sitemap_active'; } ?>">Freelance Profile</a></li>
                    <li><a href="<?php echo base_url('sitemap/business-profile') ?>" class="<?php if($this->uri->segment(2) == 'business-profile'){ echo 'sitemap_active'; } ?>">Business Profile</a></li>
                    <li><a href="<?php echo base_url('sitemap/artistic-profile') ?>" class="<?php if($this->uri->segment(2) == 'artistic-profile'){ echo 'sitemap_active'; } ?>">Artistic Profile</a></li>
                </ul>
            </div>

        </div>
    </div>
</div> -->
<header>
    <div class="">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-4 left-header col-xs-4 fw-479">
                    <?php $this->load->view('main_logo'); ?>
                </div>
                <div class="col-md-8 col-sm-8 right-header col-xs-8 fw-479">
                    <div class="btn-right">
                    <?php if(!$this->session->userdata('aileenuser')) {?>
                        <ul class="nav navbar-nav navbar-right test-cus drop-down">
                            <?php $this->load->view('profile-dropdown'); ?>
                            <li><a href="<?php echo base_url('login'); ?>" class="btn2">Login</a></li>
                            <li><a href="<?php echo base_url('registration'); ?>" class="btn3">Create an account</a></li>
                            <li class="mob-bar-li">
                                <span class="mob-right-bar">
                                    <?php $this->load->view('mobile_right_bar'); ?>
                                </span>
                            </li>
                        
                        </ul>
                    <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>