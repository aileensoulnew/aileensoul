<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title; ?></title>
	<meta name="description" content="<?php echo $metadesc; ?>" />
	<?php echo $head; ?>
	<?php if (IS_HIRE_CSS_MINIFY == '0') { ?>
		
	<?php } else { ?>
		
	<?php } ?>
	<?php if (!$this->session->userdata('aileenuser')) { ?>
	   <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css'); ?>">
   <?php } ?>
   <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/freelancer-hire.css?ver=' . time()); ?>">
   <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>" />
   <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>" />
<?php $this->load->view('adsense'); ?>
</head>
<?php if (!$this->session->userdata('aileenuser')) { ?>
   <body class="page-container-bg-solid page-boxed pushmenu-push botton_footer no-login body-loader">
   <?php } ?>
   <body class="page-container-bg-solid page-boxed pushmenu-push botton_footer body-loader">
	<?php
	if ($this->session->userdata('aileenuser')) {
		//echo $header;
	} else {
		?>
		<header>
			<div class="container">
				<div class="row">
					<div class="col-md-4 col-sm-3 left-header text-center fw-479">
						<?php $this->load->view('main_logo'); ?>
					</div>
				 <div class="col-md-8 col-sm-9 right-header fw-479 text-center">
					<div class="btn-right pull-right">
						<a title="Login" href="javascript:void(0);" onclick="login_profile();" class="btn2">Login</a>
						<a title="Create an account" href="javascript:void(0);" onclick="create_profile();" class="btn3">Create an account</a>
					</div>
				</div>
			</div>
			</div>
		</header>
<?php }
?>
<?php
if ($this->session->userdata('aileenuser')) {
	if ($freelancerhiredata[0]['user_id'] != $this->session->userdata('aileenuser')) {
		echo $freelancer_post_header2;
	} else {
		echo $freelancer_hire_header2;
	}
}
?>
 
<?php $this->load->view('page_loader'); ?>
<div id="main_page_load" style="display: block;">
	<section class="custom-row">
		<div class="container" id="paddingtop_fixed">
			<div class="row" id="row1" style="display:none;">
				<div class="col-md-12 text-center">
					<div id="upload-demo" ></div>
				</div>
				<div class="col-md-12 cover-pic" >
					<button class="btn btn-success  cancel-result" onclick="" ><?php echo $this->lang->line("cancel"); ?></button>
					<button class="btn btn-success set-btn upload-result "><?php echo $this->lang->line("save"); ?></button>
					<div id="message1" style="display:none;">
						<div id="floatBarsG">
							<div id="floatBarsG_1" class="floatBarsG"></div>
							<div id="floatBarsG_2" class="floatBarsG"></div>
							<div id="floatBarsG_3" class="floatBarsG"></div>
							<div id="floatBarsG_4" class="floatBarsG"></div>
							<div id="floatBarsG_5" class="floatBarsG"></div>
							<div id="floatBarsG_6" class="floatBarsG"></div>
							<div id="floatBarsG_7" class="floatBarsG"></div>
							<div id="floatBarsG_8" class="floatBarsG"></div>
						</div>
					</div>
				</div>
				<div class="col-md-12"  style="visibility: hidden; ">
					<div id="upload-demo-i" ></div>
				</div>
			</div>
			<div class="">
				<div class="" id="row2">
					<?php
					$userid = $this->session->userdata('aileenuser');
					if ($this->uri->segment(3) == $userid) {
						$user_id = $userid;
					} elseif ($this->uri->segment(3) == "") {
						$user_id = $userid;
					} else {
						$user_id = $this->uri->segment(3);
					}
					$contition_array = array('user_id' => $user_id, 'is_delete' => '0', 'status' => '1');
					$image = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = 'profile_background', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
					$image_ori = $image[0]['profile_background'];
					if ($image_ori) {
						if (IMAGEPATHFROM == 'upload') {
							if (!file_exists($this->config->item('free_hire_bg_main_upload_path') . $freelancerhiredata[0]['freelancer_hire_user_image'])) {
								?>
								<img alt="No Image" src="<?php echo base_url(WHITEIMAGE); ?>" name="image_src" id="image_src" />
							<?php } else { ?>
								<img alt="<?php echo $freelancerhiredata[0]['fullname'] . " " . $freelancerhiredata[0]['username']; ?>" src="<?php echo FREE_HIRE_BG_MAIN_UPLOAD_URL . $image[0]['profile_background']; ?>" name="image_src" id="image_src" / >
								<?php
							}
						} else {
							$filename = $this->config->item('free_hire_profile_main_upload_path') . $freelancerhiredata[0]['freelancer_hire_user_image'];
							$s3 = new S3(awsAccessKey, awsSecretKey);
							$this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
							if ($info) {
								?>
								<img alt="<?php echo $freelancerhiredata[0]['fullname'] . " " . $freelancerhiredata[0]['username']; ?>" src="<?php echo FREE_HIRE_BG_MAIN_UPLOAD_URL . $image[0]['profile_background']; ?>" name="image_src" id="image_src" / >
							<?php } else { ?>
							   <img alt="No Image" src="<?php echo base_url(WHITEIMAGE); ?>" name="image_src" id="image_src" />
							   <?php
						   }
					   }
				   } else {
					?>
					<div class="bg-images no-cover-upload">
						<img alt="No Image" src="<?php echo base_url(WHITEIMAGE); ?>" name="image_src" id="image_src" />
					</div>
				<?php }
				?>
			</div>
		</div>
	</div>
	<div class="container tablate-container  art-profile">    
		<?php if ($freelancerhiredata[0]['user_id'] == $this->session->userdata('aileenuser')) { ?>
			<div class="upload-img">
				<label class="cameraButton"><span class="tooltiptext"><?php echo $this->lang->line("upload_cover_photo"); ?></span><i class="fa fa-camera" aria-hidden="true"></i>
					<input type="file" id="upload" name="upload" accept="image/*;capture=camera" onclick="showDiv()">
				</label>
			</div>
		<?php } ?>
		<div class="profile-photo">
			<div class="profile-pho">
				<div class="user-pic padd_img">
					<?php
					$fname = $freelancerhiredata[0]['fullname'];
					$lname = $freelancerhiredata[0]['username'];
					$sub_fname = substr($fname, 0, 1);
					$sub_lname = substr($lname, 0, 1);
					if ($freelancerhiredata[0]['freelancer_hire_user_image']) {
						if (IMAGEPATHFROM == 'upload') {
							if (!file_exists($this->config->item('free_hire_profile_main_upload_path') . $freelancerhiredata[0]['freelancer_hire_user_image'])) {
								?>
								<div class="post-img-user">
									<?php echo ucfirst(strtolower($sub_fname)) . ucfirst(strtolower($sub_lname)); ?>
								</div>
							<?php } else { ?>
								<img src="<?php echo FREE_HIRE_PROFILE_MAIN_UPLOAD_URL . $freelancerhiredata[0]['freelancer_hire_user_image']; ?>" alt="<?php echo $freelancerhiredata[0]['fullname'] . " " . $freelancerhiredata[0]['username']; ?>" >
								<?php
							}
						} else {
							$filename = $this->config->item('free_hire_profile_main_upload_path') . $freelancerhiredata[0]['freelancer_hire_user_image'];
							$s3 = new S3(awsAccessKey, awsSecretKey);
							$this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
							if ($info) {
								?>
								<img src="<?php echo FREE_HIRE_PROFILE_MAIN_UPLOAD_URL . $freelancerhiredata[0]['freelancer_hire_user_image']; ?>" alt="<?php echo $freelancerhiredata[0]['fullname'] . " " . $freelancerhiredata[0]['username']; ?>" >
							<?php } else {
								?>
								<div class="post-img-user">
									<?php echo ucfirst(strtolower($sub_fname)) . ucfirst(strtolower($sub_lname)); ?>
								</div>
								<?php
							}
						}
					} else {
						?>
						<div class="post-img-user">
							<?php echo ucfirst(strtolower($sub_fname)) . ucfirst(strtolower($sub_lname)); ?>
						</div>
					<?php } ?>
					<?php if ($freelancerhiredata[0]['user_id'] == $this->session->userdata('aileenuser')) { ?>
						<a title="Update Profile Picture" href="javascript:void(0);"  class="cusome_upload" onclick="updateprofilepopup();"><img alt="Update Profile Picture"  src="<?php echo base_url('assets/img/cam.png'); ?>"><?php echo $this->lang->line("update_profile_picture"); ?></a>
					<?php } ?>
				</div>
			</div>
			<div class="job-menu-profile mob-block">
				<a title="<?php echo ucwords($freelancerhiredata[0]['fullname']) . ' ' . ucwords($freelancerhiredata[0]['username']); ?>" href="javascript:void(0);">
					<h3> <?php echo ucwords($freelancerhiredata[0]['fullname']) . ' ' . ucwords($freelancerhiredata[0]['username']); ?></h3>
				</a>
				<div class="profile-text">
					<?php
					if ($freelancerhiredata[0]['user_id'] == $this->session->userdata('aileenuser')) {
						if ($freelancerhiredata[0]['designation'] == '') {
							?>
							<a title="<?php echo $this->lang->line("designation"); ?>" id="designation" href="javascript:void(0);" class="designation" title="Designation"><?php echo $this->lang->line("designation"); ?></a>
						<?php } else { ?> 
							<a id="designation" href="javascript:void(0);" class="designation" title="<?php echo ucwords($freelancerhiredata[0]['designation']); ?>"><?php echo ucwords($freelancerhiredata[0]['designation']); ?></a>
							<?php
						}
					} else {
						if ($freelancerhiredata[0]['designation'] == '') {
							?>
							<?php echo $this->lang->line("designation"); ?>
						<?php } else {
							?>
							<a id="designation" style="cursor: default;" class="designation" title="<?php echo ucwords($freelancerhiredata[0]['designation']); ?>"><?php echo ucwords($freelancerhiredata[0]['designation']); ?></a>
							<?php
						}
					}
					?>
				</div>
			</div>
			
			<div class="profile-main-rec-box-menu profile-box-art col-md-12 padding_les">
				<div class=" right-side-menu art-side-menu padding_less_right  right-menu-jr">  
					<?php
					$userid = $this->session->userdata('aileenuser');
					if(is_numeric($this->uri->segment(3))){
						$slug= $this->db->select('freelancer_hire_slug')->get_where('freelancer_hire_reg', array('user_id' => $this->uri->segment(3)))->row()->freelancer_hire_slug;
					}else{
						$slug= $this->uri->segment(count($this->uri->segment_array()));
					}
					if ($freelancerhiredata[0]['user_id'] == $userid) {
						?>     
						<ul class="current-user pro-fw">
						<?php } else { ?>
							<ul class="pro-fw4">
							<?php } ?>  
							<li <?php if (($this->uri->segment(1) == 'freelance-employer') && ($this->uri->segment(3) == '') && ($this->uri->segment(2) != 'projects') && ($this->uri->segment(2) != 'saved-freelancer')) { ?> class="active" <?php } ?>>
								<?php if ($freelancerhiredata[0]['user_id'] != $this->session->userdata('aileenuser')) { ?>
									<a title="Employer Details" href="<?php echo base_url('freelance-employer/' . $slug); ?>">
										<?php echo $this->lang->line("employer_details"); ?>
									</a> 
								<?php } else { ?> 
									<a title="Employer Details" href="<?php echo base_url .'freelance-employer/'. $freelancerhiredata[0]['freelancer_hire_slug']; ?>"><?php echo $this->lang->line("employer_details"); ?>
									</a> <?php } ?>
							</li>
							<li <?php if (($this->uri->segment(1) == 'freelance-employer') && ($this->uri->segment(2) == 'saved-freelancer')) { ?> class="active" <?php } ?>> 
								<?php if($this->session->userdata('aileenuser')){ ?>
									<?php if ($freelancerhiredata[0]['user_id'] != $this->session->userdata('aileenuser'))
										{ ?>
											<a title="Projects"  href="<?php echo base_url('freelance-employer/projects/' . $slug); ?>"><?php echo $this->lang->line("Projects"); ?></a>
										<?php
										}
										else
										{ ?>
											<a title="Projects" href="<?php echo base_url('freelance-employer/projects'); ?>"><?php echo $this->lang->line("Projects"); ?></a>
										<?php 
										} ?>
								<?php }else{ ?>
									<a title="Projects"  href="javascript:void(0);"><?php echo $this->lang->line("Projects"); ?></a>
								<?php } ?>
							</li>
							<?php
							// if (($this->uri->segment(1) == 'freelance-employer') && ($this->uri->segment(2) == 'projects' || $this->uri->segment(2) == 'employer-details' || $this->uri->segment(2) == 'add-projects' || $this->uri->segment(2) == 'saved-freelancer') && ($this->uri->segment(3) == $this->session->userdata('aileenuser') || $this->uri->segment(3) == '')) {
							if (($this->uri->segment(1) == 'freelance-employer') && ($this->uri->segment(3) == $this->session->userdata('aileenuser') || $this->uri->segment(3) == '' && $freelancerhiredata[0]['user_id'] == $this->session->userdata('aileenuser'))) {
								?>
								<li <?php if (($this->uri->segment(1) == 'freelance-employer') && ($this->uri->segment(2) == 'saved-freelancer')) { ?> class="active" <?php } ?>><a title="Saved Freelancer" href="<?php echo base_url('freelance-employer/saved-freelancer'); ?>"><?php echo $this->lang->line("saved_freelancer"); ?></a>
								</li>
							<?php } ?>
							</ul>                          
							<?php
							$userid = $this->session->userdata('aileenuser');
							if ($userid != $this->uri->segment(count($this->uri->segment_array()))) {
								if ($this->uri->segment(count($this->uri->segment_array())) != "") {
									if (is_numeric($this->uri->segment(count($this->uri->segment_array())))) {
										$id = $this->uri->segment(count($this->uri->segment_array()));
									} else {
										$id = $this->db->get_where('freelancer_hire_reg', array('freelancer_hire_slug' => $this->uri->segment(count($this->uri->segment_array())), 'status' => '1'))->row()->user_id;
									}
									?>
									<div class="flw_msg_btn fr">
										<ul> <li>
											<?php
											if($this->session->userdata('aileenuser')){
												if ($freelancerhiredata[0]['user_id'] != $this->session->userdata('aileenuser')) {
													// $msg_url = base_url('chat/abc/4/3/' . $id);//Old
													$msg_url = MESSAGE_URL.'fa/fh-'.$freelancerhiredata[0]['freelancer_hire_slug'];
													?>
													<a title="Message" href="<?php echo $msg_url; ?>"><?php echo $this->lang->line("message"); ?></a>
												<?php } /*else { ?>
													<a title="Message" href="<?php echo base_url('chat/abc/3/4/' . $id); ?>"><?php echo $this->lang->line("message"); ?></a>
												<?php }*/
											}
											?>
										</li>
									</ul>
								</div>
								<?php
							}
						}
						?>
					</ul>
				</div>
			</div>
		</div>

	<div>          
		<div class="job-menu-profile mob-none job_edit_menu new-fw-name">
				<a title="<?php echo ucwords($freelancerhiredata[0]['fullname']) . ' ' . ucwords($freelancerhiredata[0]['username']); ?>" href="javascript:void(0);">
					<h3> <?php echo ucwords($freelancerhiredata[0]['fullname']) . ' ' . ucwords($freelancerhiredata[0]['username']); ?></h3>
				</a>
				<div class="profile-text">
					<?php
					if ($freelancerhiredata[0]['user_id'] == $this->session->userdata('aileenuser')) {
						if ($freelancerhiredata[0]['designation'] == '') {
							?>
							<a title="<?php echo $this->lang->line("designation"); ?>" id="designation" class="designation" title="Designation"><?php echo $this->lang->line("designation"); ?></a>
						<?php } else { ?> 
							<a id="designation" class="designation" title="<?php echo ucwords($freelancerhiredata[0]['designation']); ?>"><?php echo ucwords($freelancerhiredata[0]['designation']); ?></a>
							<?php
						}
					} else {
						if ($freelancerhiredata[0]['designation'] == '') {
							?>
							<?php echo $this->lang->line("designation"); ?>
						<?php } else {
							?>
							<a style="cursor: default;"  title=" <?php echo ucwords($freelancerhiredata[0]['designation']); ?>">
								<?php echo ucwords($freelancerhiredata[0]['designation']); ?> </a>
								<?php
							}
						}
						?>
					</div>
				
				</div>
				
		<div class="cus-inner-middle mob-clear mobp0">
			<div class="tab-add-991">
				<?php $this->load->view('banner_add'); ?>
			</div>
			<div class="common-form">
				<!-- Basic information  -->
				<div class="dtl-box">
					<div class="dtl-title">
						<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/about.png?ver=' . time()) ?>">
						<span>Basic Information</span>
						<a href="#" data-target="#job-basic-info" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
					</div>
					<div class="dtl-dis">
						<ul class="dis-list list-ul-cus">
							<li>
								<span>Email</span>
								<label>harshad2406patoliya@gmail.com</label>
							</li>
							<li>
								<span>Phone Number</span>
								<label>+91 951005589</label>
							</li>
							<li>
								<span>Skype</span>
								<label>harshad2406</label>
							</li>
							<li>
								<span>Current Position</span>
								<label>Sr.Multimedia Designer</label>
							</li>
							<li>
								<span>Skills Hired For</span>
								<label>Lorem ipsum</label>
							</li>
							<li>
								<span>Industry Hired For</span>
								<label>Lorem ipsum</label>
							</li>
							<li>
								<span>Professional Information about you</span>
								<label>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam feugiat turpis a erat sagittis pharetra. Etiam sapien nulla, tincidunt id libero non, iaculis elementum ex. <span class="collapse-text-toggle">Read More</span></label>
							</li>
						</ul>
					</div>
				</div>			
			
				<!-- Basic Company information  -->
				<div class="dtl-box">
					<div class="dtl-title">
						<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/company-details.png?ver=' . time()) ?>">
						<span>Company Information</span>
						<a href="#" data-target="#emp-company-info" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
					</div>
					<div class="dtl-dis">
						<ul class="dis-list list-ul-cus">
							<li>
								<span>Company Name</span>
								<label>Verv system</label>
							</li>
							<li>
								<span>Company Industry</span>
								<label>IT Field</label>
							</li>
							<li>
								<span>Company Profile</span>
								<label>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam feugiat turpis a erat sagittis pharetra. Etiam sapien nulla, tincidunt id libero non, iaculis elementum ex. Aenean commodo vitae felis ut dictum... <span class="collapse-text-toggle">Read More</span></label>
							</li>
							<li>
								<span>Location</span>
								<label>Ahmedabad, Gujrat , India</label>
							</li>
						</ul>
					</div>
				</div>
				
				<!-- Company Information -->
				<div class="dtl-box">
					<div class="dtl-title">
						<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/company-details.png?ver=' . time()) ?>"><span>Company Information</span>
						<a href="#" data-target="#com-info" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
					</div>
					<div class="dtl-dis">
						<ul class="dis-list list-ul-cus">
							<li>
								<span>Company Name</span>
								<label>Verv System pvt ltd</label>
							</li>
							<li>
								<span>Industry</span>
								<label>IT Field</label>
							</li>
							<li>
								<span>Team Size</span>
								<label>105</label>
							</li>
							<li>
								<span>Timezone</span>
								<label>GMT 21:45</label>
							</li>
							<li>
								<span>Company Founded</span>
								<label>June 2008</label>
							</li>
							<li>
								<span>Company Overview</span>
								<label>Lorem ipsum its a dummy text and its user to for all.Lorem ipsum its a dummy text and its user to for all.Lorem ipsum its a dummy text and its user to for all.Lorem ipsum its a dummy text and its user to for all.. <span class="collapse-text-toggle">Read More</span></label>
							</li>
							<li>
								<span>Services you offer</span>
								<ul>
									<li>Web design</li>
									<li>Graphic design</li>
									<li>SEO</li>
								</ul>
							</li>
							<li>
								<span>Total Experience</span>
								<label>5 Year 7 Month</label>
							</li>
							<li>
								<span>Skills you offer</span>
								<ul class="skill-list">
									<li>Devloping</li>
									<li>Desigining</li>
									<li>Marketing</li>
								</ul>
							</li>
							<li>
								<span>Location</span>
								<label>Ahmedabad, Gujrat , India</label>
							</li>
							<li>
								<span>Company Logo</span>
								<a href="#"><img style="width:80px;" src="<?php echo base_url('assets/n-images/detail/pr-web.png?ver=' . time()) ?>"></a>
							</li>
						</ul>
					</div>
				</div>
				
				<!-- Company Contact Information -->
				<div class="dtl-box">
					<div class="dtl-title">
						<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/contact.png?ver=' . time()) ?>">
						<span>Company Contact Information</span>
						<a href="#" data-target="#com-contact-info" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
					</div>
					<div class="dtl-dis">
						<ul class="dis-list list-ul-cus">
							<li>
								<span>Company Email </span>
								<label>harshad2406patoliya@gmail.com</label>
							</li>
							<li>
								<span>Company Phone number</span>
								<label>+91 951005589</label>
							</li>
							<li>
								<span>Skype</span>
								<label>harshad2406</label>
							</li>
							<li>
								<span>Website URL</span>
								<label>www.vervsystem.com</label>
							</li>
							<li>
								<span>Location</span>
								<label>Ahmedabad, Gujrat , India</label>
							</li>
						</ul>
					</div>
				</div>
				
				<!-- Reviews  -->
				<div class="gallery-item">
					<div class="dtl-box">
						<div class="dtl-title">
							<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/review.png?ver=' . time()) ?>"><span>Reviews</span>
							<a href="#" data-target="#reviews" data-toggle="modal" class="pull-right write-review"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"> 
								<span>Write a review</span>
							</a>
						</div>
						<div class="dtl-dis">
							<div class="total-rev">
								<span class="total-rat">4.8</span> 
								<span class="rating-star">
									<input id="input-21b" value="4" type="text" class="rating" data-min=0 data-max=5 data-step=0.2 data-size="sm" required title="">
								</span><span class="rev-count">59 Reviews</span>
							</div>
							<ul class="review-list">
								<li>
									<div class="review-left">
										<img src="<?php echo base_url('assets/n-images/detail/user-pic.jpg?ver=' . time()) ?>">
									</div>
									<div class="review-right">
										<h4>Yatin Belani</h4>
										<div class="rating-star-cus">
											<span class="rating-star">
											<input id="input-21b" value="2" type="text" class="rating" data-min=0 data-max=5 data-step=0.2 data-size="sm" required title="">
												</span>
										</div>
										<div class="review-dis">
													Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam feugiat turpis a erat sagittis pharetra. Etiam sapien nulla, tincidunt id libero non, iaculis elementum ex. Aenean commodo vitae felis ut dictum.
										</div>
									</div>
								</li>
								<li>
									<div class="review-left">
										<img src="<?php echo base_url('assets/n-images/detail/user-pic.jpg?ver=' . time()) ?>">
									</div>
									<div class="review-right">
										<h4>Yatin Belani</h4>
										<div class="rating-star-cus">
											<span class="rating-star">
											<input id="input-21b" value="2" type="text" class="rating" data-min=0 data-max=5 data-step=0.2 data-size="sm" required title="">
												</span>
										</div>
										<div class="review-dis">
													Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam feugiat turpis a erat sagittis pharetra. Etiam sapien nulla, tincidunt id libero non, iaculis elementum ex. Aenean commodo vitae felis ut dictum.
										</div>
									</div>
								</li>
								<li>
									<div class="review-left">
										<img src="<?php echo base_url('assets/n-images/detail/user-pic.jpg?ver=' . time()) ?>">
									</div>
									<div class="review-right">
										<h4>Yatin Belani</h4>
										<div class="rating-star-cus">
											<span class="rating-star">
											<input id="input-21b" value="2" type="text" class="rating" data-min=0 data-max=5 data-step=0.2 data-size="sm" required title="">
												</span>
										</div>
										<div class="review-dis">
													Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam feugiat turpis a erat sagittis pharetra. Etiam sapien nulla, tincidunt id libero non, iaculis elementum ex. Aenean commodo vitae felis ut dictum.
										</div>
									</div>
								</li>
										
							</ul>
							
						</div>
					</div>
				</div>
				
			</div>
			<div class="banner-add">
				<?php $this->load->view('banner_add'); ?>
			</div>
		</div>
		<div class="right-add">
			<div class="dtl-box">
				<div class="dtl-title">
					<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/e-profile.png?ver=' . time()) ?>">
					<span>Edit Profile</span>
				</div>
				<div class="dtl-dis dtl-edit-p">
					<img src="<?php echo base_url('assets/n-images/detail/profile-progressbar.jpg?ver=' . time()) ?>">
				</div>
			</div>
			<div class="dtl-box p10 dtl-adv cus-add-block">
				<img src="<?php echo base_url('assets/n-images/detail/add.png?ver=' . time()) ?>">
			</div>
		</div>
	</div>
	</section>
<?php echo $login_footer ?>
<?php echo $footer; ?>
<!---  model basic information  -->
	<div style="display:none;" class="modal fade dtl-modal" id="job-basic-info" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Basic Information</span>
					</div>
					<div class="dtl-dis">
						<div class="row">
							<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
								<div class="form-group">
									<label>First Name</label>
									<input type="text" placeholder="First Name">
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
								<div class="form-group">
									<label>Last Name</label>
									<input type="text" placeholder="Last Name">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
								<div class="form-group">
									<label>Email </label>
									<input type="text" placeholder="Email">
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
								<div class="form-group">
									<label>Phone Number</label>
									<input type="text" placeholder="Phone Number">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
								<div class="form-group">
									<label>Skype </label>
									<input type="text" placeholder="Skype">
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
								<div class="form-group">
									<label>Current Position </label>
									<input type="text" placeholder="Current Position">
								</div>
							</div>
							
						</div>
						<div class="form-group">
							<label>Skills Hired For </label>
							<input type="text" placeholder="Skills Hired For">
						</div>
						<div class="form-group">
							<label>Industry Hired For </label>
							<span class="span-select">
								<select>
									<option>Country</option>
									<option>1</option>
									<option>2</option>
									<option>3</option>
								</select>
							</span>
						</div>
						<div class="form-group">
							<label>Professional Information about you </label>
							<textarea type="text" placeholder="Professional Information about you"></textarea>
						</div>
						
					</div>
					<div class="dtl-btn">
						<a href="#" class="save"><span>Save</span></a>
					</div>
				</div>	


            </div>
        </div>
    </div>
	
	<!---  model indivisual company information  -->
	<div style="display:none;" class="modal fade dtl-modal" id="emp-company-info" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Company Information</span>
					</div>
					<div class="dtl-dis">
						
						
						<div class="row">
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Company Name</label>
									<input type="text" placeholder="Company Name">
								</div>
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Company Industry</label>
									<span class="span-select">
										<select>
											<option>Industry </option>
											<option>Industry</option>
											<option>Industry</option>
											<option>Industry</option>
										</select>
									</span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label>Company Profile </label>
							<textarea type="text" placeholder="Company Profile"></textarea>
						</div>
						<div class="row">
							<label class="col-md-12 fw"> Company Address</label>
							<div class="col-md-4 col-sm-4 col-xs-4 fw-479">
								<div class="form-group">
									<span class="span-select">
										<select>
											<option>Country</option>
											<option>1</option>
											<option>2</option>
											<option>3</option>
										</select>
									</span>
								</div>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-4 fw-479">
								<div class="form-group">
									<span class="span-select">
										<select>
											<option>State</option>
											<option>1</option>
											<option>2</option>
											<option>3</option>
										</select>
									</span>
								</div>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-4 fw-479">
								<div class="form-group">
									<span class="span-select">
										<select>
											<option>City </option>
											<option>2015</option>
											<option>2016</option>
											<option>2017</option>
										</select>
									</span>
								</div>
							</div>
						</div>
						
					</div>
					<div class="dtl-btn">
						<a href="#" class="save"><span>Save</span></a>
					</div>
				</div>	


            </div>
        </div>
    </div>
	
	
	
	<!-- Company Information  -->
	<div style="display:none;" class="modal fade dtl-modal" id="com-info" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Company Information</span>
					</div>
					<div class="dtl-dis">
						<div class="row">
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Company Name</label>
									<input type="text" placeholder="Enter Company Name">
								</div>
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Industry </label>
									<span class="span-select">
										<select>
											<option>Select Field</option>
											<option>It Field</option>
											<option>Design</option>
											<option>Advertizing</option>
										</select>
									</span>
								</div>
								
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-6 col-sm-6 col-xs-6">
								<div class="form-group">
									<label>Team Size</label>
									<input type="text" placeholder="Company Phone number">
								</div>
								
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<div class="form-group">
									<label>Timezone</label>
									<span class="span-select">
										<select class="form-control">
											<option>Timezone</option>
											<option>januari</option>
											<option>Fabruari</option>
											<option>March</option>
											<option>April</option>
										</select>
									</span>
								</div>
							</div>
						</div>
						
						
						<div class="row total-exp">
							<label class="col-md-12 fw">
								Company Founded
							</label>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<div class="form-group">
									<span class="span-select">
										<select class="form-control">
											<option>Year</option>
											<option>2014</option>
											<option>2015</option>
											<option>2016</option>
											<option>2017</option>
										</select>	
									</span>
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<div class="form-group">
									<span class="span-select">
										<select class="form-control">
											<option>Month</option>
											<option>januari</option>
											<option>Fabruari</option>
											<option>March</option>
											<option>April</option>
										</select>	
									</span>
								</div>
							</div>
							
								
						</div>
						<div class="row">
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Company Overview</label>
									<textarea row="4" type="text" placeholder="Company Overview"></textarea>
								</div>
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
							<label>Service you hire for</label>
							<textarea type="text" placeholder="Service you hire for"></textarea>
						</div>
							</div>
						</div>
						
						
						<div class="row">
							<label class="col-md-12 fw">Total Experience</label>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<div class="form-group">
									<span class="span-select">
										<select>
											<option>1</option>
											<option>2</option>
											<option>3</option>
											<option>4</option>
											<option>5</option>
										</select>
									</span>
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<div class="form-group">
									<span class="span-select">
										<select>
											<option>1</option>
											<option>2</option>
											<option>3</option>
											<option>4</option>
											<option>5</option>
										</select>
									</span>
								</div>
							</div>
						</div>	
						<div class="form-group">
							<label>Skills you hire for</label>
							<input type="text" placeholder="Skills you hire for">
						</div>
						
						<div class="form-group">
							<label class="upload-file">
								Upload Company Logo <input type="file">
							</label>
						</div>
					</div>
					<div class="dtl-btn">
							<a href="#" class="save"><span>Save</span></a>
						</div>
				</div>	


            </div>
        </div>
    </div>
	<!-- Company Contact Information  -->
	<div style="display:none;" class="modal fade dtl-modal" id="com-contact-info" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Company Contact Information</span>
					</div>
					<div class="dtl-dis">
						
						<div class="row">
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Company Email </label>
									<input type="text" placeholder="Company Email ">
								</div>
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Company Phone number</label>
									<input type="text" placeholder="Company Phone number">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Skype</label>
									<input type="text" placeholder="Skype">
								</div>
								
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Website URL</label>
									<input type="text" placeholder="Enter Website URL">
								</div>
							</div>
						</div>
					
						<div class="row total-exp">
							<label class="col-md-12 fw">
								Company Address
							</label>
							<div class="col-md-4 col-sm-4 col-xs-4 fw-479">
								<div class="form-group">
									<span class="span-select">
										<select class="form-control">
											<option>Country</option>
											<option>2015</option>
											<option>2016</option>
											<option>2017</option>
											<option>2018</option>
										</select>
									</span>
								</div>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-4 fw-479">
								<div class="form-group">
									<span class="span-select">
										<select class="form-control">
											<option>State</option>
											<option>januari</option>
											<option>Fabruari</option>
											<option>March</option>
											<option>April</option>
										</select>
									</span>
								</div>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-4 fw-479">
								<div class="form-group">
									<span class="span-select">
										<select class="form-control">
											<option>City</option>
											<option>januari</option>
											<option>Fabruari</option>
											<option>March</option>
											<option>April</option>
										</select>
									</span>
								</div>
							</div>
						</div>
					
					</div>
					<div class="dtl-btn">
							<a href="#" class="save"><span>Save</span></a>
						</div>
				</div>	


            </div>
        </div>
    </div>
	
	
	<!-- Reviews  -->
	<div style="display:none;" class="modal fade dtl-modal" id="reviews" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Reviews</span>
					</div>
					<div class="dtl-dis">
						<div class="form-group">
							<div class="rev-img">
								<img src="<?php echo base_url('assets/n-images/detail/user-pic.jpg?ver=' . time()) ?>">
							</div>
							<div class="total-rev-top">
								<h4>Harshad Patoliya</h4>
								<span class="rating-star">
			<input id="input-21b" value="4" type="text" class="rating" data-min=0 data-max=5 data-step=0.2 data-size="sm" required title="">
								</span>
							</div>
						</div>
						<div class="form-group">
							<label>Description</label>
							<textarea type="text" placeholder="Description"></textarea>
						</div>
						<div class="form-group">
							<label class="upload-file">
								<span class="fw">Upload Photo</span> <input type="file">
							</label>
						</div>
				
					</div>
					<div class="dtl-btn bottom-btn">
						<a href="#" class="save"><span>Save</span></a>
					</div>
				</div>	


            </div>
        </div>
    </div>
	
<!-- model for popup start -->
<div class="modal fade message-box biderror" id="bidmodal" role="dialog">
	<div class="modal-dialog modal-lm">
		<div class="modal-content">
			<button type="button" class="modal-close" data-dismiss="modal">&times;</button>         
			<div class="modal-body">
				<span class="mes"></span>
			</div>
		</div>
	</div>
</div>
<!-- model for popup -->
<!-- Bid-modal-2  -->
<div class="modal fade message-box" id="bidmodal-2" role="dialog">
	<div class="modal-dialog modal-lm">
		<div class="modal-content">
			<button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
			<div class="modal-body">
				<span class="mes">
					<div id="popup-form">
						<div class="fw" id="profi_loader"  style="display:none;" style="text-align:center;" ><img alt="loader" src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) ?>" /></div>
						<form id ="userimage" name ="userimage" class ="clearfix" enctype="multipart/form-data" method="post">
							<div class="fw">
								<input type="file" name="profilepic" accept="image/gif, image/jpeg, image/png" id="upload-one">
							</div>
							<div class="col-md-7 text-center">
								<div id="upload-demo-one" style="width:350px; display: none"></div>
							</div>
							<input type="submit" class="upload-result-one" name="profilepicsubmit" id="profilepicsubmit" value="Save" >
						</form>
					</div>
				</span>
			</div>
		</div>
	</div>
</div>
<!-- Model Popup Close -->
<!-- register -->
<div class="modal fade register-model login" data-backdrop="static" data-keyboard="false" id="register" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content inner-form1">
			<!--<button type="button" class="modal-close" data-dismiss="modal">&times;</button>-->       
			<div class="modal-body">
				<div class="clearfix">
					<div class="">
						<div class="title"><h1 class="tlh1">Sign up First and Register in Employer Profile</h1></div>
						<div class="main-form">
							<form role="form" name="register_form" id="register_form" method="post">
								<div class="row">
									<div class="col-sm-6 col-md-6">
										<div class="form-group">
											<input tabindex="101" autofocus="" type="text" name="first_name" id="first_name" class="form-control input-sm" placeholder="First Name">
										</div>
									</div>
									<div class="col-sm-6 col-md-6">
										<div class="form-group">
											<input tabindex="102" type="text" name="last_name" id="last_name" class="form-control input-sm" placeholder="Last Name">
										</div>
									</div>
								</div>
								<div class="form-group">
									<input tabindex="103" type="text" name="email_reg" id="email_reg" class="form-control input-sm" placeholder="Email Address" autocomplete="new-email">
								</div>
								<div class="form-group">
									<input tabindex="104" type="password" name="password_reg" id="password_reg" class="form-control input-sm" placeholder="Password" autocomplete="new-password">
								</div>
								<div class="form-group dob">
									<label class="d_o_b"> Date Of Birth :</label>
									<span><select tabindex="105" class="day" name="selday" id="selday">
										<option value="" disabled selected value>Day</option>
										<?php
										for ($i = 1; $i <= 31; $i++) {
											?>
											<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
											<?php
										}
										?>
									</select></span>
									<span>
										<select tabindex="106" class="month" name="selmonth" id="selmonth">
											<option value="" disabled selected value>Month</option>
											//<?php
												//                  for($i = 1; $i <= 12; $i++){
												//                  
											?>
											<option value="1">Jan</option>
											<option value="2">Feb</option>
											<option value="3">Mar</option>
											<option value="4">Apr</option>
											<option value="5">May</option>
											<option value="6">Jun</option>
											<option value="7">Jul</option>
											<option value="8">Aug</option>
											<option value="9">Sep</option>
											<option value="10">Oct</option>
											<option value="11">Nov</option>
											<option value="12">Dec</option>
											<?php
													//                  }
													//                  
											?>
										</select></span>
										<span>
											<select tabindex="107" class="year" name="selyear" id="selyear">
												<option value="" disabled selected value>Year</option>
												<?php
												for ($i = date('Y'); $i >= 1900; $i--) {
													?>
													<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
													<?php
												}
												?>
											</select>
										</span>
									</div>
									<div class="dateerror" style="color:#f00; display: block;"></div>
									<div class="form-group gender-custom">
										<select tabindex="108" class="gender"  onchange="changeMe(this)" name="selgen" id="selgen">
											<option value="" disabled selected value>Gender</option>
											<option value="M">Male</option>
											<option value="F">Female</option>
										</select>
									</div>
									<p class="form-text" style="margin-bottom: 10px;">
										By Clicking on create an account button you agree our
										<a tabindex="109" title="Terms and Condition" href="<?php echo base_url('terms-and-condition'); ?>">Terms and Condition</a> and <a tabindex="110" title="Privacy policy" href="<?php echo base_url('privacy-policy'); ?>">Privacy policy</a>.
									</p>
									<p>
										<button tabindex="111" class="btn1">Create an account</button>
										<!--<p class="next">Next</p>-->
									</p>
									<div class="sign_in pt10">
										<p>
											Already have an account ? <a title="Log In" tabindex="112" onClick="login_profile();" href="javascript:void(0);"> Log In </a>
										</p>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- register -->
	<!-- Login  -->
	<div class="modal fade login" id="login" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content login-frm">
				<!--<button type="button" class="modal-close" data-dismiss="modal">&times;</button>-->       
				<div class="modal-body">
					<div class="right-main">
						<div class="right-main-inner">
							<div class="">
								<div class="title">
									<h1 class="ttc tlh2">Welcome To Aileensoul</h1>
								</div>
								<form role="form" name="login_form" id="login_form" method="post">
									<div class="form-group">
										<input type="email" value="<?php echo $email; ?>" name="email_login" id="email_login" autofocus="" class="form-control input-sm" placeholder="Email Address*">
										<div id="error2" style="display:block;">
											<?php
											if ($this->session->flashdata('erroremail')) {
												echo $this->session->flashdata('erroremail');
											}
											?>
										</div>
										<div id="errorlogin"></div> 
									</div>
									<div class="form-group">
										<input type="password" name="password_login" id="password_login" class="form-control input-sm" placeholder="Password*">
										<div id="error1" style="display:block;">
											<?php
											if ($this->session->flashdata('errorpass')) {
												echo $this->session->flashdata('errorpass');
											}
											?>
										</div>
										<div id="errorpass"></div> 
									</div>
									<p class="pt-20 ">
										<button class="btn1" onclick="login()">Login</button>
									</p>
									<p class=" text-center">
										<a title="Forgot Password" href="javascript:void(0)" data-toggle="modal" onclick="forgot_profile();" id="myBtn">Forgot Password ?</a>
									</p>
									<p class="pt15 text-center">
										Don't have an account? <a title="Create an account" class="db-479" href="javascript:void(0);" data-toggle="modal" onclick="create_profile();">Create an account</a>
									</p>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Login -->
	<!-- model for forgot password start -->
	<div class="modal fade login" id="forgotPassword" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content login-frm">
				<button type="button" class="modal-close" data-dismiss="modal" onclick="login_profile1();">&times;</button>       
				<div class="modal-body">
					<div class="right-main">
						<div class="right-main-inner">
							<div class="">
								<div id="forgotbuton"></div> 
								<div class="title">
								 <p class="ttc tlh2">Forgot Password</p>
							 </div>
							 <?php
							 $form_attribute = array('name' => 'forgot', 'method' => 'post', 'class' => 'forgot_password', 'id' => 'forgot_password');
							 echo form_open('profile/forgot_password', $form_attribute);
							 ?>
							 <div class="form-group">
								<input type="email" value="" name="forgot_email" id="forgot_email" class="form-control input-sm" placeholder="Email Address*">
								<div id="error2" style="display:block;">
									<?php
									if ($this->session->flashdata('erroremail')) {
										echo $this->session->flashdata('erroremail');
									}
									?>
								</div>
								<div id="errorlogin"></div> 
							</div>
							<p class="pt-20 text-center">
								<input class="btn btn-theme btn1" type="submit" name="submit" value="Submit" style="width:105px; margin:0px auto;" /> 
							</p>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</div>
<?php if (IS_HIRE_JS_MINIFY == '0') { ?>
	<!-- <script  src="<?php // echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script> -->
	<script  src="<?php echo base_url('assets/js/croppie.js?ver=' . time()); ?>"></script>
	<script  type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>
<?php } else { ?>
	<!-- <script  src="<?php // echo base_url('assets/js_min/bootstrap.min.js?ver=' . time()); ?>"></script> -->
	<script  src="<?php echo base_url('assets/js_min/croppie.js?ver=' . time()); ?>"></script>
	<script  type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver=' . time()); ?>"></script>
<?php } ?>
<script>
	var base_url = '<?php echo base_url(); ?>';
	var user_session = '<?php echo $this->session->userdata('aileenuser'); ?>';
	var segment3 = '<?php echo $this->uri->segment(3); ?>'
	var header_all_profile = '<?php echo $header_all_profile; ?>';
	$('#main_loader').hide();
	// $('#main_page_load').show();
	$('body').removeClass("body-loader");
</script>
<script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-hire/freelancer_hire_profile.js?ver=' . time()); ?>"></script>
<script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-hire/freelancer_hire_common.js?ver=' . time()); ?>"></script>
<?php /*if (IS_HIRE_JS_MINIFY == '0') { ?>
	<script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-hire/freelancer_hire_profile.js?ver=' . time()); ?>"></script>
	<script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-hire/freelancer_hire_common.js?ver=' . time()); ?>"></script>
<?php } else { ?>
	<script  type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/freelancer-hire/freelancer_hire_profile.js?ver=' . time()); ?>"></script>
	<script  type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/freelancer-hire/freelancer_hire_common.js?ver=' . time()); ?>"></script>
<?php } */?>
<script src="<?php echo base_url('assets/js/star-rating.js?ver=' . time()) ?>"></script>
<script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
<script>
        jQuery(document).ready(function () {
            $("#input-21f").rating({
                starCaptions: function (val) {
                    if (val < 3) {
                        return val;
                    } else {
                        return 'high';
                    }
                },
                starCaptionClasses: function (val) {
                    if (val < 3) {
                        return 'label label-danger';
                    } else {
                        return 'label label-success';
                    }
                },
                hoverOnClear: false
            });
            var $inp = $('#rating-input');

            $inp.rating({
                min: 0,
                max: 5,
                step: 1,
                size: 'lg',
                showClear: false
            });

            $('#btn-rating-input').on('click', function () {
                $inp.rating('refresh', {
                    showClear: true,
                    disabled: !$inp.attr('disabled')
                });
            });


            $inp.on('rating.change', function () {
                alert($('#rating-input').val());
            });


            $('.rb-rating').rating({
                'showCaption': true,
                'stars': '3',
                'min': '0',
                'max': '3',
                'step': '1',
                'size': 'xs',
                'starCaptions': {0: 'status:nix', 1: 'status:wackelt', 2: 'status:geht', 3: 'status:laeuft'}
            });
            $("#input-21c").rating({
                min: 0, max: 8, step: 0.5, size: "xl", stars: "8"
            });
        });
    </script>
</body>
</html>