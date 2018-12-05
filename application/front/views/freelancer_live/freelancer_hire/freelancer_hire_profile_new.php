<!DOCTYPE html>
<html lang="en" ng-app="freelanceHireProfileApp" ng-controller="freelanceHireProfileController">
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
   <link rel="stylesheet" href="<?php echo base_url('assets/n-css/ng-tags-input.min.css?ver=' . time()) ?>">
   <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/freelancer-hire.css?ver=' . time()); ?>">
   <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>" />
   <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>" />
   <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/developer.css?ver=' . time()); ?>" />
<?php $this->load->view('adsense'); ?>
</head>
<?php if (!$this->session->userdata('aileenuser')) { ?>
   <body class="page-container-bg-solid page-boxed pushmenu-push botton_footer no-login body-loader">
   <?php } ?>
   <body class="page-container-bg-solid page-boxed pushmenu-push botton_footer body-loader">
	<?php
	if ($this->session->userdata('aileenuser')){
		//echo $header;
	}
	else
	{
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
	<?php
	}
	?>
	<?php
	$fh_userid = $freelancerhiredata[0]['user_id'];
	$login_userid = $this->session->userdata('aileenuser');
	if ($this->session->userdata('aileenuser')) {
		if ($freelancerhiredata[0]['user_id'] != $this->session->userdata('aileenuser')) {
			echo $freelancer_post_header2;//freelancer_live/freelancer_post/freelancer_post_header2_new
		} else {
			echo $freelancer_hire_header2;
		}
	}

	if($freelancerhiredata[0]['is_indivdual_company'] == '2')
	{
		$is_copm_indu = 2;
	    $fullname = ucwords($freelancerhiredata[0]['comp_name']);
	    if($freelancerhiredata[0]['company_field'] != 0)
	    {
	        $designation = $this->db->get_where('industry_type', array('industry_id' => $freelancerhiredata[0]['company_field']))->row()->industry_name;
	    }
	    else
	    {
	        $designation = $freelancerhiredata[0]['company_other_field'];
	    }
	    $sub_fullname = substr($fullname, 0, 1);
	    $no_img_name = $sub_fullname;
	}
	else
	{
		$is_copm_indu = 1;
	    $fname = $freelancerhiredata[0]['fullname'];
	    $lname = $freelancerhiredata[0]['username'];
	    $fullname = ucwords($fname) . ' ' . ucwords($lname);

	    $designation = $freelancerhiredata[0]['designation'];

	    $sub_fname = substr($fname, 0, 1);
	    $sub_lname = substr($lname, 0, 1);
	    $no_img_name = $sub_fname.$sub_lname;
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
								?>
									<img alt="<?php echo $freelancerhiredata[0]['fullname'] . " " . $freelancerhiredata[0]['username']; ?>" src="<?php echo FREE_HIRE_BG_MAIN_UPLOAD_URL . $image[0]['profile_background']; ?>" name="image_src" id="image_src" / >
									<?php							
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
							if ($freelancerhiredata[0]['freelancer_hire_user_image']) {
								if (IMAGEPATHFROM == 'upload') { ?>
										<img src="<?php echo FREE_HIRE_PROFILE_MAIN_UPLOAD_URL . $freelancerhiredata[0]['freelancer_hire_user_image']; ?>" alt="<?php echo $freelancerhiredata[0]['fullname'] . " " . $freelancerhiredata[0]['username']; ?>" >
								<?php
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
											<?php echo ucfirst(strtolower($no_img_name)); ?>
										</div>
										<?php
									}
								}
							} else {
								?>
								<div class="post-img-user">
									<?php echo ucfirst(strtolower($no_img_name)); ?>
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
										<?php if($this->session->userdata('aileenuser')){ ?>
										<li <?php if (($this->uri->segment(1) == 'freelance-employer') && ($this->uri->segment(2) == 'saved-freelancer')) { ?> class="active" <?php } ?>><a title="Saved Freelancer" href="<?php echo base_url('freelance-employer/saved-freelancer'); ?>"><?php echo $this->lang->line("saved_freelancer"); ?></a>
										</li>
									<?php }
										else
										{ ?>
											<li><a title="Saved Freelancer" href="javascript:void(0);"><?php echo $this->lang->line("saved_freelancer"); ?></a>
										</li>

										<?php }
									} ?>
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
						<a title="<?php echo ucwords($fullname); ?>" href="javascript:void(0);">
							<h3> <?php echo ucwords($fullname); ?></h3>
						</a>
					</div>
							
					<div class="cus-inner-middle mob-clear mobp0">
						<div class="tab-add-991">
							<?php $this->load->view('banner_add'); ?>
						</div>
						<div class="common-form">
							<?php if($is_copm_indu == 1): ?>
							<!-- Basic information  -->
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/about.png?ver=' . time()) ?>">
									<span>Basic Information</span>
									<?php if($fh_userid == $login_userid): ?>
									<a href="#" data-target="#job-basic-info" data-toggle="modal" class="pull-right" ng-click="edit_individual_basic_info();"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
									<?php endif; ?>
								</div>
								<div id="individual-basic-info-loader" class="dtl-dis">
	                                <div class="text-center">
	                                    <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
	                                </div>
	                            </div>
	                            <div id="individual-basic-info-body" style="display: none;">
	                            	<div class="dtl-dis" ng-if="!individual_basic_info">
										<div class="no-info">
											<img src="<?php echo base_url('assets/n-images/detail/edit-profile.png?ver=' . time()) ?>">
											<span>Lorem ipsum its a dummy text and its user to for all.</span>
										</div>
									</div>
									<div class="dtl-dis" ng-if="individual_basic_info">
										<ul class="dis-list list-ul-cus">
											<li ng-if="individual_basic_info.email">
												<span>Email</span>
												<label>{{individual_basic_info.email}}</label>
											</li>
											<li ng-if="individual_basic_info.phone">
												<span>Phone Number</span>
												<label>{{individual_basic_info.phone}}</label>
											</li>
											<li ng-if="individual_basic_info.skyupid">
												<span>Skype</span>
												<label>{{individual_basic_info.skyupid}}</label>
											</li>
											<li ng-if="individual_basic_info.current_position_txt">
												<span>Current Position</span>
												<label>{{individual_basic_info.current_position_txt}}</label>
											</li>
											<li ng-if="individual_basic_info.individual_skills">
												<span>Skills Hired For</span>
												<ul class="skill-list">
													<li ng-repeat="skill in individual_basic_info.individual_skills_txt.split(',')">{{skill}}</li>
												</ul>
											</li>
											<li ng-if="individual_basic_info.individual_industry_txt !='' || individual_basic_info.individual_other_industry !=''">
												<span>Industry Hired For</span>
												<label ng-if="individual_basic_info.individual_industry != '0'">{{individual_basic_info.individual_industry_txt}}</label>
												<label ng-if="individual_basic_info.individual_industry == '0'">{{individual_basic_info.individual_other_industry}}</label>
											</li>
											<li ng-if="individual_basic_info.professional_info">
												<span>Professional Information about you</span>
												<label class="inner-dis" dd-text-collapse dd-text-collapse-max-length="200" dd-text-collapse-text="{{individual_basic_info.professional_info}}" dd-text-collapse-cond="true">{{individual_basic_info.professional_info}}</label>
											</li>
										</ul>
									</div>
								</div>
							</div>			
						
							<!-- Basic Company information  -->
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/company-details.png?ver=' . time()) ?>">
									<span>Company Information</span>
									<?php if($fh_userid == $login_userid): ?>
									<a href="#" data-target="#emp-company-info" data-toggle="modal" class="pull-right" ng-click="edit_individual_comp_info();"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
									<?php endif; ?>
								</div>
								<div id="individual-comp-info-loader" class="dtl-dis">
	                                <div class="text-center">
	                                    <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
	                                </div>
	                            </div>
	                            <div id="individual-comp-info-body" style="display: none;">
	                            	<div class="dtl-dis" ng-if="!individual_company_info">
										<div class="no-info">
											<img src="<?php echo base_url('assets/n-images/detail/edit-profile.png?ver=' . time()) ?>">
											<span>Lorem ipsum its a dummy text and its user to for all.</span>
										</div>
									</div>
									<div class="dtl-dis" ng-if="individual_company_info">
										<ul class="dis-list list-ul-cus">
											<li ng-if="individual_company_info.comp_name">
												<span>Company Name</span>
												<label>{{individual_company_info.comp_name}}</label>
											</li>
											<li ng-if="individual_company_info.company_field_txt || individual_company_info.company_other_field">
												<span>Company Industry</span>
												<label ng-if="individual_company_info.company_field > '0'">{{individual_company_info.company_field_txt}}</label>
												<label ng-if="individual_company_info.company_field == '0'">{{individual_company_info.company_other_field}}</label>
											</li>
											<li ng-if="individual_company_info.comp_name">
												<span>Company Profile</span>
												<label class="inner-dis" dd-text-collapse dd-text-collapse-max-length="200" dd-text-collapse-text="{{individual_company_info.comp_overview}}" dd-text-collapse-cond="true">{{individual_company_info.comp_overview}}</label>
											</li>
											<li>
												<span>Location</span>
												<label ng-if="individual_company_info.city_name != ''">{{individual_company_info.city_name}}{{individual_company_info.city_name != '' && individual_company_info.state_name != '' ? ',' : ''}}</label>
												<label ng-if="individual_company_info.state_name != ''"> {{individual_company_info.state_name}}{{individual_company_info.state_name != '' && individual_company_info.country_name != '' ? ',' : ''}}</label>
												<label ng-if="individual_company_info.country_name != ''"> {{individual_company_info.country_name}}</label>
											</li>
										</ul>
									</div>
								</div>
							</div>
							<?php
							endif;
							if($is_copm_indu == 2): ?>
							<!-- Company Information -->
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/company-details.png?ver=' . time()) ?>"><span>Company Information</span>
									<?php if($fh_userid == $login_userid): ?>
									<a href="#" data-target="#com-info" data-toggle="modal" class="pull-right" ng-click="edit_cmp_comp_info();"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
									<?php endif; ?>
								</div>								
								<div id="cmp-comp-info-loader" class="dtl-dis">
	                                <div class="text-center">
	                                    <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
	                                </div>
	                            </div>
	                            <div id="cmp-comp-info-body" style="display: none;">
	                            	<div class="dtl-dis" ng-if="!cmp_company_info">
										<div class="no-info">
											<img src="<?php echo base_url('assets/n-images/detail/edit-profile.png?ver=' . time()) ?>">
											<span>Lorem ipsum its a dummy text and its user to for all.</span>
										</div>
									</div>
									<div class="dtl-dis" ng-if="cmp_company_info">
										<ul class="dis-list list-ul-cus">
											<li ng-if="cmp_company_info.comp_name">
												<span>Company Name</span>
												<label>{{cmp_company_info.comp_name}}</label>
											</li>
											<li ng-if="cmp_company_info.company_field || cmp_company_info.company_other_field">
												<span>Industry</span>
												<label ng-if="cmp_company_info.company_field > '0'">{{cmp_company_info.company_field_txt}}</label>
												<label ng-if="cmp_company_info.company_field == '0' && cmp_company_info.company_other_field">{{cmp_company_info.cmp_company_info.company_other_field}}</label>
											</li>
											<li ng-if="cmp_company_info.comp_team">
												<span>Team Size</span>
												<label>{{cmp_company_info.comp_team}}</label>
											</li>										
											<li ng-if="cmp_company_info.comp_founded_year > '0' || cmp_company_info.comp_founded_month > '0'">
												<span>Company Founded</span>
												<label>{{all_months[cmp_company_info.comp_founded_month - '1']}}</label>
												<label>{{cmp_company_info.comp_founded_year}}</label>
											</li>
											<li ng-if="cmp_company_info.comp_overview">
												<span>Company Overview</span>
												<label class="inner-dis" dd-text-collapse dd-text-collapse-max-length="200" dd-text-collapse-text="{{cmp_company_info.comp_overview}}" dd-text-collapse-cond="true">{{cmp_company_info.comp_overview}}</label>
											</li>
											<li ng-if="cmp_company_info.comp_service_offer">
												<span>Services you offer</span>
												<label class="inner-dis" dd-text-collapse dd-text-collapse-max-length="200" dd-text-collapse-text="{{cmp_company_info.comp_service_offer}}" dd-text-collapse-cond="true">{{cmp_company_info.comp_service_offer}}</label>
											</li>
											<li ng-if="cmp_company_info.comp_exp_year > '0' || cmp_company_info.comp_exp_month > '0'">
												<span>Total Experience</span>
												<label>{{cmp_company_info.comp_exp_year}} Year{{cmp_company_info.comp_exp_year > '1' ? 's' : ''}}</label>
												<label>{{cmp_company_info.comp_exp_month}} Month{{cmp_company_info.comp_exp_month > '1' ? 's' : ''}}</label>
											</li>
											<li ng-if="cmp_company_info.comp_skills_offer">
												<span>Skills you offer</span>
												<ul class="skill-list">
													<li ng-repeat="skill in cmp_company_info.comp_skills_offer_txt.split(',')">{{skill}}</li>
												</ul>
											</li>
											<li ng-if="cmp_company_cont_info.city_name != '' || cmp_company_cont_info.state_name != '' || cmp_company_cont_info.country_name != ''">
												<span>Location</span>
												<label ng-if="cmp_company_cont_info.city_name != ''">{{cmp_company_cont_info.city_name}}{{cmp_company_cont_info.city_name != '' && cmp_company_cont_info.state_name != '' ? ',' : ''}}</label>
												<label ng-if="cmp_company_cont_info.state_name != ''"> {{cmp_company_cont_info.state_name}}{{cmp_company_cont_info.state_name != '' && cmp_company_cont_info.country_name != '' ? ',' : ''}}</label>
												<label ng-if="cmp_company_cont_info.country_name != ''"> {{cmp_company_cont_info.country_name}}</label>
											</li>
											<li ng-if="cmp_company_info.comp_logo">
												<span>Company Logo</span>
												<a href="<?php echo FREE_HIRE_COMP_LOGO_UPLOAD_URL; ?>{{cmp_company_info.comp_logo}}" target="_blank"><img style="width:80px;" src="<?php echo FREE_HIRE_COMP_LOGO_UPLOAD_URL; ?>{{cmp_company_info.comp_logo}}"></a>
											</li>
										</ul>
									</div>
								</div>
							</div>
							
							<!-- Company Contact Information -->
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/contact.png?ver=' . time()) ?>">
									<span>Company Contact Information</span>
									<?php if($fh_userid == $login_userid): ?>
									<a href="#" data-target="#com-contact-info" data-toggle="modal" class="pull-right" ng-click="edit_cmp_comp_con_info();"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
									<?php endif; ?>
								</div>
								<div id="cmp-comp-cont-info-loader" class="dtl-dis">
	                                <div class="text-center">
	                                    <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
	                                </div>
	                            </div>
	                            <div id="cmp-comp-cont-info-body" style="display: none;">
									<div class="dtl-dis">
										<ul class="dis-list list-ul-cus">
											<li ng-if="cmp_company_cont_info.comp_email">
												<span>Company Email </span>
												<label>{{cmp_company_cont_info.comp_email}}</label>
											</li>
											<li ng-if="cmp_company_cont_info.comp_number">
												<span>Company Phone number</span>
												<label>{{cmp_company_cont_info.comp_number}}</label>
											</li>
											<li ng-if="cmp_company_cont_info.comp_skype">
												<span>Skype</span>
												<label>{{cmp_company_cont_info.comp_skype}}</label>
											</li>
											<li ng-if="cmp_company_cont_info.comp_website">
												<span>Website URL</span>
												<label>{{cmp_company_cont_info.comp_website}}</label>
											</li>
											<li ng-if="cmp_company_cont_info.city_name != '' || cmp_company_cont_info.state_name != '' || cmp_company_cont_info.country_name != ''">
												<span>Location</span>
												<label ng-if="cmp_company_cont_info.city_name != ''">{{cmp_company_cont_info.city_name}}{{cmp_company_cont_info.city_name != '' && cmp_company_cont_info.state_name != '' ? ',' : ''}}</label>
												<label ng-if="cmp_company_cont_info.state_name != ''"> {{cmp_company_cont_info.state_name}}{{cmp_company_cont_info.state_name != '' && cmp_company_cont_info.country_name != '' ? ',' : ''}}</label>
												<label ng-if="cmp_company_cont_info.country_name != ''"> {{cmp_company_cont_info.country_name}}</label>
											</li>
										</ul>
									</div>
								</div>
							</div>
							<?php endif; ?>
							<!-- Reviews  -->
							<div class="gallery-item">
								<div class="dtl-box">
									<div class="dtl-title">
										<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/review.png?ver=' . time()) ?>"><span>Reviews</span>
										<?php if(isset($fh_login_data) && !empty($fh_login_data) && $login_userid != '' && $fh_userid != $login_userid): ?>
										<a href="#" data-target="#reviews" data-toggle="modal" class="pull-right write-review"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()); ?>"> 
											<span>Write a review</span>
										</a>
										<?php endif; ?>
									</div>
									<div id="review-loader" class="dtl-dis">
		                                <div class="text-center">
		                                    <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
		                                </div>
		                            </div>
		                            <div id="review-body" style="display: none;">
										<div class="dtl-dis">
											<div class="no-info" ng-if="review_data.length < '1'">
												<img src="<?php echo base_url('assets/n-images/detail/edit-profile.png?ver=' . time()) ?>">
												<span>Lorem ipsum its a dummy text and its user to for all.</span>
											</div>
											<div ng-if="review_data.length > '0' && review_count > '0'">
											<div class="total-rev">
												<span class="total-rat">{{avarage_review}}</span> 
												<span class="rating-star">
													<input id="rating-1" type="number" value="{{avarage_review}}">
												</span><span class="rev-count">{{review_count}} Review{{review_count > 1 ? 's' : ''}}</span>
											</div>
											</div>
											<ul class="review-list">
												<li ng-if="review_data.length > '0'" ng-repeat="review_list in review_data">
													<div class="review-left" ng-if="!review_list.user_image">
														<div class="rev-img">
															<div class="post-img-profile">
																{{review_list.first_name | limitTo:1}} {{review_list.last_name |  limitTo:1}}
															</div>
														</div>
													</div>
													<div class="review-left" ng-if="review_list.user_image">
														<img src="<?php echo FREE_POST_PROFILE_MAIN_UPLOAD_URL; ?>{{review_list.user_image}}">
													</div>
													<div class="review-right">
														<h4>{{review_list.first_name | wordFirstCase}} {{review_list.last_name | wordFirstCase}}</h4>
														<div class="rating-star-cus">
															<span class="rating-star">
															<input id="rating-{{$index}}" value="{{review_list.review_star}}" type="number" class="rating user-rating" class="rating">
																</span>
														</div>
														<div class="review-dis" ng-if="review_list.review_desc">
															{{review_list.review_desc}}
														</div>
													</div>
												</li>
											</ul>
											
										</div>
									</div>
								</div>
							</div>
							
						</div>
						<div class="banner-add">
							<?php $this->load->view('banner_add'); ?>
						</div>
					</div>
					<div class="right-add add-detail">
						<?php if($fh_userid == $login_userid): ?>
						<div class="dtl-box">
							<div class="dtl-title">
								<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/e-profile.png?ver=' . time()) ?>">
								<span>Edit Profile</span>
							</div>
							<div class="dtl-dis dtl-edit-p">
								<!-- <img src="<?php //echo base_url('assets/n-images/detail/profile-progressbar.jpg?ver=' . time()) ?>"> -->
								<div class="dtl-edit-top"></div>
		                        <div class="profile-status">
		                            <ul>
		                                <li><span class=""><img ng-if="progress_status.user_image_status == '1'" src="<?php echo base_url(); ?>assets/n-images/detail/c.png"></span>Profile pic</li>

		                                <li class="pl20"><span class=""><img ng-if="progress_status.profile_background_status == '1'" src="<?php echo base_url(); ?>assets/n-images/detail/c.png"></span>Cover pic</li>
		                                <?php if($is_copm_indu == 1){  ?>

		                                	<li class="fw"><span class=""><img ng-if="progress_status.user_fname_status == '1' && progress_status.user_lname_status == '1' && progress_status.user_email_status == '1' && progress_status.user_phone_status == '1' && progress_status.user_skyupid_status == '1' && progress_status.user_current_position_status == '1' && progress_status.user_individual_skills_status == '1' && progress_status.user_individual_industry_status == '1' && progress_status.user_professional_info_status == '1'" src="<?php echo base_url(); ?>assets/n-images/detail/c.png"></span>Basic Information</li>
		                                
		                                	<li class="fw"><span class=""><img ng-if="progress_status.user_comp_name_status == '1' && progress_status.user_company_field_status == '1' && progress_status.user_comp_overview_status == '1' && progress_status.user_country_status == '1' && progress_status.user_state_status == '1' && progress_status.user_city_status == '1'" src="<?php echo base_url(); ?>assets/n-images/detail/c.png"></span>Company Details</li>

		                                <?php } ?>
		                                <?php if($is_copm_indu == 2){  ?>

		                                	<li class="fw"><span class=""><img ng-if="progress_status.user_comp_name_status == '1' && progress_status.user_company_field_status == '1' && progress_status.user_comp_team_status == '1' && progress_status.user_comp_founded_year_status == '1' && progress_status.user_comp_founded_month_status == '1' && progress_status.user_comp_overview_status == '1' && progress_status.user_comp_service_offer_status == '1' && progress_status.user_comp_exp_year_status == '1' && progress_status.user_comp_exp_month_status == '1' && progress_status.user_comp_skills_offer_status == '1'" src="<?php echo base_url(); ?>assets/n-images/detail/c.png"></span>Basic Information</li>
		                                
		                                	<li class="fw"><span class=""><img ng-if="progress_status.user_comp_email_status == '1' && progress_status.user_comp_number_status == '1' && progress_status.user_company_country_status == '1' && progress_status.user_company_state_status == '1' && progress_status.user_company_city_status == '1'" src="<?php echo base_url(); ?>assets/n-images/detail/c.png"></span>Company Details</li>
		                                	
		                                <?php } ?>
		                            </ul>
		                        </div>
		                        <div class="dtl-edit-bottom"></div>
		                        <div class="p20">
		                            <!-- <img src="<?php //echo base_url('assets/n-images/detail/profile-progressbar.jpg?ver=' . time()) ?>"> -->
		                            <div id="profile-progress" class="edit_profile_progress" style="display: none;">
		                                <div class="count_main_progress">
		                                    <div class="circles">
		                                        <div class="second circle-1">
		                                            <div>
		                                                <strong></strong>
		                                                <span id="progress-txt"></span>
		                                            </div>
		                                        </div>
		                                    </div>
		                                </div>
		                            </div>
		                        </div>
							</div>
						</div>
						<?php endif; ?>
						<div class="right-add-box"> 
							<div class="dtl-box p10 dtl-adv cus-add-block" style="margin: 0">
								<!-- <img src="<?php //echo base_url('assets/n-images/detail/add.png?ver=' . time()) ?>"> -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<?php echo $login_footer ?>
		<?php echo $footer; ?>
		<?php if($is_copm_indu == 1): ?>
		<!---  model basic information  -->
		<div style="display:none;" class="modal fade dtl-modal" id="job-basic-info" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
	            <div class="modal-content">
	                <button type="button" class="modal-close" data-dismiss="modal">×</button>
	                <div class="modal-body-cus"> 
						<div class="dtl-title">
							<span>Basic Information</span>
						</div>
						<form name="individual_basic_info_form" id="individual_basic_info_form" ng-validate="individual_basic_info_validate">
						<div class="dtl-dis">
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
									<div class="form-group">
										<label>First Name</label>
										<input type="text" placeholder="First Name" id="individual_first_name" name="individual_first_name" maxlength="255">
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
									<div class="form-group">
										<label>Last Name</label>
										<input type="text" placeholder="Last Name" id="individual_last_name" name="individual_last_name" maxlength="255">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
									<div class="form-group">
										<label>Email </label>
										<input type="text" placeholder="Email" id="individual_email" name="individual_email" maxlength="255">
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
									<div class="form-group">
										<label>Phone Number</label>
										<input type="text" placeholder="Phone Number" id="individual_phone" name="individual_phone" ng-model="individual_phone" numbers-only  maxlength="15">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
									<div class="form-group">
										<label>Skype </label>
										<input type="text" placeholder="Skype" id="individual_skype" name="individual_skype" maxlength="255">
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
									<div class="form-group">
										<label>Current Position </label>
										<input type="text" class="form-control" id="individual_position" name="individual_position" ng-model="individual_position" ng-keyup="current_position_list()" typeahead="item as item.name for item in titleSearchResult | filter:$viewValue" autocomplete="off" placeholder="Current Position" maxlength="255">
									</div>
								</div>
								
							</div>
							<div class="form-group">
								<label>Skills Hired For </label>
								<!-- <input type="text" placeholder="Skills Hired For"> -->

                                <tags-input id="individual_skills" ng-model="individual_skills" display-property="name" placeholder="Skills Hired For" replace-spaces-with-dashes="false" template="title-template" on-tag-added="onKeyup()" ng-keyup="individual_skills_fnc()">
		                            <auto-complete source="loadSkills($query)" min-length="0" load-on-focus="false" load-on-empty="false" max-results-to-show="32" template="title-autocomplete-template"></auto-complete>
		                        </tags-input>                        
		                        <script type="text/ng-template" id="title-template">
		                            <div class="tag-template"><div class="right-panel"><span>{{$getDisplayText()}}</span><a class="remove-button" ng-click="$removeTag()">&#10006;</a></div></div>
		                        </script>
		                        <script type="text/ng-template" id="title-autocomplete-template">
		                            <div class="autocomplete-template"><div class="right-panel"><span ng-bind-html="$highlight($getDisplayText())"></span></div></div>
		                        </script>

                                <label id="individual_skills_err" for="individual_skills" class="error" style="display: none;">Please enter skills</label>
							</div>
							<div class="form-group">
								<label>Industry Hired For </label>
								<span class="span-select">
									<?php $getFieldList = $this->data_model->getNewFieldList();?>
										<select class="form-control" name="individual_industry" id="individual_industry" ng-model="individual_industry" ng-change="other_individual_industry()">
                                            <option value="">Select Company Industry</option>
	                                        <?php foreach ($getFieldList as $key => $value) { ?>
	                                            <option value="<?php echo $value['industry_id']; ?>""><?php echo $value['industry_name']; ?></option>
	                                        <?php } ?>
	                                        <option value="0">Other</option>
                                       	</select>
								</span>
							</div>
							<div id="individual_other_field_div" class="form-group" style="display: none;">
                                <label>Other Field</label>
                                <input type="text" placeholder="Enter Other Field" id="individual_other_industry" name="individual_other_industry" maxlength="255">
                            </div>
							<div class="form-group">
								<label>Professional Information about you </label>
								<textarea type="text" placeholder="Professional Information about you" id="individual_prof_info" name="individual_prof_info" ng-model="individual_prof_info" maxlength="700"></textarea>
								<span class="pull-right">{{700 - individual_prof_info.length}}</span>
							</div>
							
						</div>
						<div class="dtl-btn">
							<a id="save_individual_basic_info" href="#" ng-click="save_individual_basic_info()" class="save"><span>Save</span></a>
							<div id="individual_basic_info_loader" class="dtl-popup-loader" style="display: none;">
								<img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" >
							</div>
						</div>
						</form>
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
						<form name="individual_comp_info_form" id="individual_comp_info_form" ng-validate="individual_comp_info_validate">
						<div class="dtl-dis">
							<div class="row">
								<div class="col-md-6 col-sm-6">
									<div class="form-group">
										<label>Company Name</label>
										<input type="text" placeholder="Company Name" id="individual_comp_name" name="individual_comp_name" maxlength="255">
									</div>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="form-group">
										<label>Company Industry</label>
										<span class="span-select">
											<?php $getFieldList = $this->data_model->getNewFieldList();?>
											<select class="form-control" name="individual_comp_industry" id="individual_comp_industry" ng-model="individual_comp_industry" ng-change="other_individual_comp_industry()">
                                                <option value="">Select Company Industry</option>
                                            <?php foreach ($getFieldList as $key => $value) { ?>
                                                <option value="<?php echo $value['industry_id']; ?>""><?php echo $value['industry_name']; ?></option>
                                            <?php } ?>
                                            <option value="0">Other</option>
										</select>
										</span>
									</div>
								</div>
							</div>
							<div id="individual_other_field_div" class="row" style="display: none;">
                                <div class="col-md-6 col-sm-6"></div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                    <label>Other Field</label>
                                    <input type="text" placeholder="Enter Other Field" id="individual_other_comp_industry" name="individual_other_comp_industry" maxlength="255">
                                    </div>
                                </div>
                            </div>
							<div class="form-group">
								<label>Company Profile </label>
								<textarea type="text" placeholder="Company Profile" id="individual_comp_overview" name="individual_comp_overview" ng-model="individual_comp_overview" maxlength="700"></textarea>
								<span class="pull-right">{{700 - individual_comp_overview.length}}</span>
							</div>
							<div class="row">
								<label class="col-md-12 fw"> Company Address</label>
								<div class="col-md-4 col-sm-4 col-xs-4 fw-479">
									<div class="form-group">
										<span class="span-select">
											<select id="individual_country" name="individual_country" ng-model="individual_country" ng-change="individual_country_change()">
                                                <option value="">Country</option>         
                                                <option data-ng-repeat='country_item in country_list' value='{{country_item.country_id}}'>{{country_item.country_name}}</option>
                                            </select>
										</span>
									</div>
								</div>
								<div class="col-md-4 col-sm-4 col-xs-4 fw-479">
									<div class="form-group">
										<span class="span-select">
											<select id="individual_state" name="individual_state" ng-model="individual_state" ng-change="individual_state_change()" disabled = "disabled">
                                                <option value="">State</option>
                                                <option data-ng-repeat='state_item in individual_state_list' value='{{state_item.state_id}}'>{{state_item.state_name}}</option>
                                            </select>
                                            <img id="individual_state_loader" src="<?php echo base_url('assets/img/spinner.gif') ?>" style="   width: 20px;position: absolute;top: 6px;right: 19px;display: none;">
										</span>
									</div>
								</div>
								<div class="col-md-4 col-sm-4 col-xs-4 fw-479">
									<div class="form-group">
										<span class="span-select">
											<select id="individual_city" name="individual_city" ng-model="individual_city" disabled = "disabled">
                                                <option value="">City</option>
                                                <option data-ng-repeat='city_item in individual_city_list' value='{{city_item.city_id}}'>{{city_item.city_name}}</option>
                                            </select>
                                            <img id="individual_city_loader" src="<?php echo base_url('assets/img/spinner.gif') ?>" style="   width: 20px;position: absolute;top: 6px;right: 19px;display: none;">
										</span>
									</div>
								</div>
							</div>
							
						</div>
						<div class="dtl-btn">
							<a id="save_individual_comp_info" href="#" ng-click="save_individual_comp_info()" class="save"><span>Save</span></a>
							<div id="individual_comp_info_loader" class="dtl-popup-loader" style="display: none;">
								<img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" >
							</div>
						</div>
						</form>
					</div>
				</div>
	        </div>
	    </div>
		<?php endif; ?>

		<?php if($is_copm_indu == 2): ?>
		<!-- Company Information  -->
		<div style="display:none;" class="modal fade dtl-modal" id="com-info" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
	            <div class="modal-content">
	                <button type="button" class="modal-close" data-dismiss="modal">×</button>
	                <div class="modal-body-cus"> 
						<div class="dtl-title">
							<span>Company Information</span>
						</div>
						<form name="cmp_comp_info_form" id="cmp_comp_info_form" ng-validate="cmp_comp_info_validate">
						<div class="dtl-dis">
							<div class="row">
								<div class="col-md-6 col-sm-6">
									<div class="form-group">
										<label>Company Name</label>
										<input type="text" placeholder="Enter Company Name" id="comp_name" name="comp_name" maxlength="255">
									</div>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="form-group">
										<label>Industry </label>
										<span class="span-select">
											<?php $getFieldList = $this->data_model->getNewFieldList();?>
											<select class="form-control" name="company_field" id="company_field" ng-model="company_field" ng-change="other_field_fnc()">
                                                    <option value="">Select Field</option>
                                                <?php foreach ($getFieldList as $key => $value) { ?>
                                                    <option value="<?php echo $value['industry_id']; ?>""><?php echo $value['industry_name']; ?></option>
                                                <?php } ?>
                                                <option value="0">Other</option>
											</select>
										</span>
									</div>
									
								</div>
							</div>
							<div id="company_other_field_div" class="row" style="display: none;">
                                <div class="col-md-6 col-sm-6"></div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                    <label>Other Field</label>
                                    <input type="text" placeholder="Enter Other Field" id="company_other_field" name="company_other_field" ng-model="company_other_field" maxlength="255">
                                    </div>
                                </div>
                            </div>
							
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-6">
									<div class="form-group">
										<label>Team Size</label>
										<input type="text" placeholder="Enter Team Size" id="comp_team" name="comp_team" ng-model="comp_team" numbers-only maxlength="5">
									</div>									
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6">
									<div class="form-group">
										<label>Skills you hire for</label>
										<!-- <input type="text" placeholder="Skills you hire for" id="comp_skills_offer" id="comp_skills_offer"> -->
										<tags-input id="comp_skills_offer" ng-model="comp_skills_offer" display-property="name" placeholder="Skills you hire for" replace-spaces-with-dashes="false" template="title-template" on-tag-added="onKeyup()" ng-keyup="comp_skills_fnc()">
                                            <auto-complete source="loadSkills($query)" min-length="0" load-on-focus="false" load-on-empty="false" max-results-to-show="32" template="title-autocomplete-template"></auto-complete>
                                        </tags-input>                        
                                        <script type="text/ng-template" id="title-template">
                                            <div class="tag-template"><div class="right-panel"><span>{{$getDisplayText()}}</span><a class="remove-button" ng-click="$removeTag()">&#10006;</a></div></div>
                                        </script>
                                        <script type="text/ng-template" id="title-autocomplete-template">
                                            <div class="autocomplete-template"><div class="right-panel"><span ng-bind-html="$highlight($getDisplayText())"></span></div></div>
                                        </script>
                                        <label id="comp_skills_offer_err" for="comp_skills_offer" class="error" style="display: none;">Please enter skills</label>
                                </tags-input>
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
											<select class="form-control" id="comp_founded_year" name="comp_founded_year" ng-model="comp_founded_year" ng-change="comp_founded_year_change();">
												<option value="">Year</option>
												<?php
												$y = date("Y");
												for ($i=$y; $i > $y - 100; $i--) { ?>
													<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
												<?php
												} ?>
											</select>	
										</span>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6">
									<div class="form-group">
										<span class="span-select">
											<select class="form-control" id="comp_founded_month" name="comp_founded_month">
												<option value="">Select Month</option>
											</select>	
										</span>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 col-sm-6">
									<div class="form-group">
										<label>Company Overview</label>
										<textarea row="4" type="text" placeholder="Company Overview" id="comp_overview" name="comp_overview" ng-model="comp_overview" maxlength="700"></textarea>
										<span class="pull-right">{{700 - comp_overview.length}}</span>                    
									</div>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="form-group">
										<label>Service you hire for</label>
										<textarea type="text" placeholder="Service you hire for" id="comp_service_offer" name="comp_service_offer" ng-model="comp_service_offer" maxlength="700"></textarea>
										<span class="pull-right">{{700 - comp_service_offer.length}}</span>                    
									</div>
								</div>
							</div>
							
							
							<div class="row">
								<label class="col-md-12 fw">Total Experience</label>
								<div class="col-md-6 col-sm-6 col-xs-6">
									<div class="form-group">
										<span class="span-select">
											<select class="form-control" id="comp_exp_year" name="comp_exp_year">
												<option value="">Select Year</option>
												<?php												
												for ($j=1; $j <= 20; $j++) { ?>
													<option value="<?php echo $j; ?>"><?php echo $j; ?></option>
												<?php
												} ?>
											</select>
										</span>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6">
									<div class="form-group">
										<span class="span-select">
											<select class="form-control" id="comp_exp_month" name="comp_exp_month">
												<option value="">Select Month</option>
												<?php												
												for ($k=1; $k <= 11; $k++) { ?>
													<option value="<?php echo $k; ?>"><?php echo $k; ?></option>
												<?php
												} ?>
											</select>
										</span>
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<div class="upload-file">
									<span class="fw">Upload Company Logo</span>
									<input type="file" id="comp_logo" name="comp_logo">
									<span id="comp_logo_error" class="error" style="display: none;"></span>
								</div>
							</div>
						</div>
						<div class="dtl-btn">
							<!-- <a href="#" class="save"><span>Save</span></a> -->
							<a id="save_cmp_comp_info" href="#" ng-click="save_cmp_comp_info()" class="save"><span>Save</span></a>
							<div id="cmp_comp_info_loader" class="dtl-popup-loader" style="display: none;">
								<img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" >
							</div>
						</div>
						</form>
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
						<form name="cmp_comp_con_info_form" id="cmp_comp_con_info_form" ng-validate="cmp_comp_con_info_validate">
							<div class="dtl-dis">
								<div class="row">
									<div class="col-md-6 col-sm-6">
										<div class="form-group">
											<label>Company Email </label>
											<input type="text" placeholder="Company Email" id="cmp_company_email" name="cmp_company_email" maxlength="255">
										</div>
									</div>
									<div class="col-md-6 col-sm-6">
										<div class="form-group">
											<label>Company Phone number</label>
											<input type="text" placeholder="Company Phone number" id="cmp_company_number" name="cmp_company_number" ng-model="cmp_company_number" numbers-only maxlength="15">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6 col-sm-6">
										<div class="form-group">
											<label>Skype</label>
											<input type="text" placeholder="Skype" id="cmp_company_skype" name="cmp_company_skype" maxlength="255">
										</div>
										
									</div>
									<div class="col-md-6 col-sm-6">
										<div class="form-group">
											<label>Website <span class="link-must">(Must be http:// or https://)</span></label>
											<input type="text" placeholder="Enter Website URL" id="cmp_company_website" name="cmp_company_website" maxlength="255">
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
												<select id="company_country" name="company_country" ng-model="company_country" ng-change="comp_country_change()">
	                                                <option value="">Country</option>         
	                                                <option data-ng-repeat='country_item in country_list' value='{{country_item.country_id}}'>{{country_item.country_name}}</option>
	                                            </select>
											</span>
										</div>
									</div>
									<div class="col-md-4 col-sm-4 col-xs-4 fw-479">
										<div class="form-group">
											<span class="span-select">
												<select id="company_state" name="company_state" ng-model="company_state" ng-change="comp_state_change()" disabled = "disabled">
	                                                <option value="">State</option>
	                                                <option data-ng-repeat='state_item in company_state_list' value='{{state_item.state_id}}'>{{state_item.state_name}}</option>
	                                            </select>
	                                            <img id="company_state_loader" src="<?php echo base_url('assets/img/spinner.gif') ?>" style="   width: 20px;position: absolute;top: 6px;right: 19px;display: none;">
											</span>
										</div>
									</div>
									<div class="col-md-4 col-sm-4 col-xs-4 fw-479">
										<div class="form-group">
											<span class="span-select">
												<select id="company_city" name="company_city" ng-model="company_city" disabled = "disabled">
	                                                <option value="">City</option>
	                                                <option data-ng-repeat='city_item in company_city_list' value='{{city_item.city_id}}'>{{city_item.city_name}}</option>
	                                            </select>
	                                            <img id="company_city_loader" src="<?php echo base_url('assets/img/spinner.gif') ?>" style="   width: 20px;position: absolute;top: 6px;right: 19px;display: none;">
											</span>
										</div>
									</div>
								</div>						
							</div>
							<div class="dtl-btn">
								<!-- <a href="#" class="save"><span>Save</span></a> -->
								<a id="save_cmp_comp_con_info" href="#" ng-click="save_cmp_comp_con_info()" class="save" style="pointer-events: none;"><span>Save</span></a>
                                <div id="cmp_comp_con_info_loader" class="dtl-popup-loader" style="display: none;">
                                    <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" >
                                </div>
							</div>
						</form>
					</div>	


	            </div>
	        </div>
	    </div>
	    <?php endif; ?>
		
		<?php if(isset($fh_login_data) && !empty($fh_login_data) && $login_userid != '' && $fh_userid != $login_userid): ?>
		<!-- Reviews  -->
		<div style="display:none;" class="modal fade dtl-modal" id="reviews" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
	            <div class="modal-content">
	                <button type="button" class="modal-close" data-dismiss="modal">×</button>
	                <div class="modal-body-cus"> 
						<div class="dtl-title">
							<span>Reviews</span>
						</div>
						<form id="freelancer_hire_profile_review" name="freelancer_hire_profile_review" ng-validate="freelancer_hire_profile_review_validate">
							<div class="dtl-dis">
								<div class="form-group">
									<div class="rev-img">
										<?php if($fh_login_data['freelancer_post_user_image'] != ''):?>
										<img src="<?php echo FREE_POST_PROFILE_MAIN_UPLOAD_URL.$fh_login_data['freelancer_post_user_image']; ?>">
										<?php else: ?>
										<div class="post-img-profile">
											<?php echo ucwords(substr($fh_login_data['freelancer_post_fullname'], 0,1).' '.substr($fh_login_data['freelancer_post_username'], 0,1)); ?>
										</div>
										<?php endif; ?>
									</div>
									<div class="total-rev-top">
										<h4><?php echo ucwords($fh_login_data['freelancer_post_fullname'].' '.$fh_login_data['freelancer_post_username']); ?></h4>
										<span class="rating-star">
											<input id="review_star" value="5" type="number" class="rating" data-min=0 data-max=5 data-step=0.5 data-size="sm" required name="review_star">
										</span>
									</div>
								</div>
								<div class="form-group">
									<label>Description</label>
									<textarea type="text" placeholder="Description" id="review_desc" name="review_desc" maxlength="700" ng-model="review_desc"></textarea>
									<span class="pull-right">{{700 - review_desc.length}}</span>
								</div>
								<div class="form-group">
									<div class="upload-file">
										<span class="fw">Upload Photo</span>
										<input type="file" id="review_file" name="review_file">
										<span id="review_file_error" class="error" style="display: none;"></span>
									</div>
								</div>						
							</div>
							<div class="dtl-btn bottom-btn">
								<!-- <a href="#" class="save" ng-click="save_review();"><span>Save</span></a> -->
								<a id="save_review" href="#" ng-click="save_review()" class="save"><span>Save</span></a>
                                <div id="review_loader" class="dtl-popup-loader" style="display: none;">
                                    <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" >
                                </div>
							</div>
						</form>
					</div>	


	            </div>
	        </div>
	    </div>
		<?php endif; ?>
		
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
	</div>


	<!-- <script  src="<?php // echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script> -->
	<script  src="<?php echo base_url('assets/js/croppie.js?ver=' . time()); ?>"></script>
	<script  type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>
	<script src="<?php echo base_url('assets/js/masonry.pkgd.min.js?ver=' . time()); ?>"></script>
	<script src="<?php echo base_url('assets/js/progressloader.js?ver=' . time()); ?>"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
    <script data-semver="0.13.0" src="https://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
    <script src="<?php echo base_url('assets/js/angular-validate.min.js?ver=' . time()) ?>"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
    <script src="<?php echo base_url('assets/js/ng-tags-input.min.js?ver=' . time()); ?>"></script>
    <script src="<?php echo base_url('assets/js/angular/angular-tooltips.min.js?ver=' . time()); ?>"></script>
    <script src="<?php echo base_url('assets/js/angular-google-adsense.min.js'); ?>"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-sanitize.js"></script>
        
	<script>
		var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
		var base_url = '<?php echo base_url(); ?>';
		var user_session = '<?php echo $this->session->userdata('aileenuser'); ?>';
		var segment3 = '<?php echo $this->uri->segment(3); ?>';
		var from_user_id = '<?php echo $fh_login_data['user_id']; ?>';
		var to_user_id = '<?php echo $freelancerhiredata[0]['user_id']; ?>';
		var header_all_profile = '<?php echo $header_all_profile; ?>';
		
		var free_hire_comp_logo_upload_url = '<?php echo FREE_HIRE_COMP_LOGO_UPLOAD_URL; ?>';

		var app = angular.module("freelanceHireProfileApp", ['ngRoute', 'ui.bootstrap', 'ngTagsInput', 'ngSanitize','angular-google-adsense', 'ngValidate']);
		$('#main_loader').hide();
		// $('#main_page_load').show();
		$('body').removeClass("body-loader");
	</script>
	<script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-hire/freelancer_hire_profile_new.js?ver=' . time()); ?>"></script>
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
	<script type="text/javascript">
        $(document).ready(function () {
            $('.dtl-edit-bottom').hover(function () {
                $('.profile-status').addClass('hover-bottom');
            }, function () {
                $('.profile-status').removeClass('hover-bottom');
            });
            
            $('.dtl-edit-top').hover(function () {
                $('.profile-status').addClass('hover-top');
            }, function () {
                $('.profile-status').removeClass('hover-top');
            });
        });
    </script>	
</body>
</html>