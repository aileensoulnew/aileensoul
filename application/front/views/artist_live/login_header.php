<header>
    <div class="">
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
							<li class="hidden-991"><a href="<?php echo base_url('login'); ?>" class="btn8">Login</a></li>
							<li class="hidden-991"><a href="<?php echo base_url('artist-profile/create-account'); ?>" class="btn9">Create Artistic Account</a></li>
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
				<li><a href="<?php echo base_url('find-artist'); ?>">Artist Profile</a></li>
				<li><a href="<?php echo base_url('artist/category'); ?>">Artists by Category</a></li>
				<li><a href="<?php echo base_url('artist/location'); ?>">Artists by Location</a></li>
				<li><a href="<?php echo base_url('how-to-use-artistic-profile-in-aileensoul'); ?>">How Artistic Profile Works</a></li>
				<li><a href="<?php echo base_url('blog'); ?>">Blog</a></li>
			</ul>
		</div>
		<div class="mob-ld-sub">
			<ul class="">
				<li class="tab-first-li">
					<a href="javascript:void(0);">Artists</a>
					<ul>
						<li><a href="<?php echo base_url('find-artist'); ?>">Artist Profile</a></li>
						<li><a href="<?php echo base_url('artist/category'); ?>">Artists by Category</a></li>
						<li><a href="<?php echo base_url('artist/location'); ?>">Artists by Location</a></li>
						<li><a href="<?php echo base_url('how-to-use-artistic-profile-in-aileensoul'); ?>">How Artistic Profile Works</a></li>
						<li><a href="<?php echo base_url('blog'); ?>">Blog</a></li>
					</ul>
					
				</li>
				<li><a href="<?php echo base_url('login'); ?>">Login</a></li>
				<li><a href="<?php echo base_url('artist-profile/create-account'); ?>"><span class="hidden-479">Create Artistic Profile</span><span class="visible-479">Sign Up</span></a></li>
			</ul>
		</div>
	</div>
</div>