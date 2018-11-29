<!DOCTYPE html>
<html ng-app="userRecProfileApp" ng-controller="userRecProfileController">
<head>
	<title><?php echo $title; ?></title>
	<meta name="description" content="<?php echo $metadesc; ?>" />
	<?php echo $head; ?>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/recruiter.css'); ?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/n-css/ng-tags-input.min.css?ver=' . time()) ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>" />
    <style type="text/css">
		.keyskill_border_active {
			border: 3px solid #f00 !important;
		}
		#skills-error{
			margin-top: 40px !important;
		}
		#minmonth-error{
			margin-top: 40px; margin-right: 9px;
		}
		#minyear-error{
			margin-top: 42px !important;margin-right: 9px;
		}
		#maxmonth-error{
			margin-top: 42px !important;margin-right: 9px;
		}
		#maxyear-error{
			margin-top: 42px !important;margin-right: 9px;
		}
		#minmonth-error{
			margin-top: 39px !important;
		}
		#minyear-error{
			margin-top: auto !important;
		}
		#maxmonth-error{
			margin-top: 39px !important;
		}
		#maxyear-error{
			margin-top: auto !important;
		}
		#example2-error{
			margin-top: 40px !important
		}
	</style>
    <?php $this->load->view('adsense');?>
	</head>
	<body class="page-container-bg-solid page-boxed pushmenu-push botton_footer">
		<?php //echo $header; ?>
		<?php
	$returnpage = $_GET['page'];
	$userid     = $this->session->userdata('aileenuser');
	if ($this->uri->segment(3) != $userid) {
	    echo $job_header2;
	} elseif ($recdata['re_step'] == 3) {
	    echo $recruiter_header2;
	} elseif ($returnpage == 'notification') { }
	?>
	<div id="preloader"></div>
	<!-- START CONTAINER -->
	<section>
		<!-- MIDDLE SECTION START -->
		<div class="container mt-22" id="paddingtop_fixed">
			<div class="row" id="row1" style="display:none;">
				<div class="col-md-12 text-center">
					<div id="upload-demo" ></div>
				</div>
				<div class="col-md-12 cover-pic">
					<button class="btn btn-success  cancel-result" onclick="">Cancel</button>
					<button class="btn btn-success  upload-result set-btn" onclick="myFunction()">Save</button>
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
					<div id="upload-demo-i"></div>
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

					$contition_array = array('user_id' => $user_id, 'is_delete' => '0', 're_status' => '1');
					$image = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'profile_background', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
					
					$image_ori = $image[0]['profile_background'];
					$filename = $this->config->item('rec_bg_main_upload_path') . $image[0]['profile_background'];
					// print_r(REC_BG_MAIN_UPLOAD_URL.$image[0]['profile_background']);exit();
					// $s3                 = new S3(awsAccessKey, awsSecretKey);
					// $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
					if ($image[0]['profile_background'] != '') {
					    ?>
						<img src = "<?php echo REC_BG_MAIN_UPLOAD_URL . $image[0]['profile_background']; ?>" name="image_src" id="image_src" alt="<?php echo $image[0]['profile_background']; ?>"/>
					<?php
					} else {
					?>
						<div class="bg-images no-cover-upload">
					   		<img src="<?php echo base_url(WHITEIMAGE); ?>" name="image_src" id="image_src" alt="<?php echo 'NOIMAGE'; ?>" />
				    	</div>
				    <?php } ?>
				</div>
			</div>
		</div>
		<div class="container tablate-container art-profile">
			<?php if ($this->uri->segment(3) == $userid) { ?>
			<div class="upload-img">
				<label class="cameraButton"><span class="tooltiptext_rec">Upload Cover Photo</span><i class="fa fa-camera" aria-hidden="true"></i>
					<input type="file" id="upload" name="upload" accept="image/*;capture=camera" onclick="showDiv()">
				</label>
			</div>
			<?php } ?>
			<div class="profile-photo">
				<!--PROFILE PIC CODE START-->
				<div class="profile-pho">
					<div class="user-pic padd_img">
						<?php 
						// print_r($recdata);exit();
						$filename = $this->config->item('rec_profile_thumb_upload_path').$recdata['recruiter_user_image'];
						// $s3 = new S3(awsAccessKey, awsSecretKey);
						// $this->data['info']     = $info     = $s3->getObjectInfo(bucket, $filename);
						if ($recdata['recruiter_user_image'] != '') { ?>
							<img src="<?php echo REC_PROFILE_THUMB_UPLOAD_URL . $recdata['recruiter_user_image']; ?>" alt="<?php echo $recdata['recruiter_user_image']; ?>" >
						<?php
						} else {
					    $a    = $recdata['rec_firstname'];
					    $acr  = substr($a, 0, 1);
					    $b    = $recdata['rec_lastname'];
					    $acr1 = substr($b, 0, 1); ?>
						<div class="post-img-user">
							<?php echo ucfirst(strtolower($acr)) . ucfirst(strtolower($acr1)); ?>
						</div>
					<?php } ?>
					<?php if ($this->uri->segment(3) == $userid) { ?>
						<a class="cusome_upload" title="Update profile pictuure" href="javascript:void(0);" onclick="updateprofilepopup();"><img src="<?php echo base_url(); ?>assets/img/cam.png" alt="cameraimage"> Update Profile Picture</a>
					<?php } ?>
					</div>
				</div>

				<!--PROFILE PIC CODE END-->
				<div class="job-menu-profile mob-block">
					<a href="javascript:void(0);" title="<?php echo $recdata['rec_firstname'] . ' ' . $recdata['rec_lastname']; ?>"><h3><?php echo $recdata['rec_firstname'] . ' ' . $recdata['rec_lastname']; ?></h3></a>
					<!-- text head start -->
					<div class="profile-text" >
						<?php
						if ($this->uri->segment(3) == $userid) {
							if ($recdata['designation'] == '') { ?>
								<a id="designation" class="designation" title="Designation">Designation</a>
							<?php } else { ?>
								<a id="designation" class="designation" title="<?php echo ucfirst(strtolower($recdata['designation'])); ?>"><?php echo ucfirst(strtolower($recdata['designation'])); ?></a>
								<?php
							}
						} else {
							if ($recdata['designation'] == '') {
								?>
								<a id="designation"  title="Designation">Designation</a>
							<?php } else { ?>
								<a id="designation"  title="<?php echo ucfirst(strtolower($recdata['designation'])); ?>"> <?php echo ucfirst(strtolower($recdata['designation'])); ?></a>
							<?php }
						} ?>
					</div>
				</div>
				<!-- menubar -->
				<div class="profile-main-rec-box-menu profile-box-art col-md-12 padding_les">
					<div class=" right-side-menu art-side-menu padding_less_right job_edit_pr right-menu-jr">
						<?php
						$userid = $this->session->userdata('aileenuser');
						if ($recdata['user_id'] == $userid) { ?>
							<ul class="current-user pro-fw">
						<?php } else { ?>
							<ul class="pro-fw4">
						<?php } ?>
								<li <?php if ($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'profile') { ?> class="active" <?php } ?>>
									<?php if ($this->uri->segment(3) != $userid) { ?>
										<a title="Details" href="<?php echo base_url('recruiter/profile/' . $this->uri->segment(3)); ?>">Details</a>
									<?php } else { ?>
										<a title="Details" href="<?php echo base_url('recruiter/profile'); ?>">Details</a>
									<?php }?>
								</li>
								<?php if (($this->uri->segment(1) == 'recruiter') && ($this->uri->segment(2) == 'post' || $this->uri->segment(2) == 'profile' || $this->uri->segment(2) == 'add-post' || $this->uri->segment(2) == 'save-candidate') && ($this->uri->segment(3) == $this->session->userdata('aileenuser') || $this->uri->segment(3) == '' || $this->uri->segment(3) != '')) {?>

								<li <?php if ($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'post') {?> class="active" <?php }?>>
									<?php if ($this->uri->segment(3) != $userid) {?>
									<a title="Post" href="<?php echo base_url('recruiter/post/' . $this->uri->segment(3)); ?>">Post</a>
									<?php } else {?>
									<a title="Post" href="<?php echo base_url('recruiter/post'); ?>">Post</a>
									<?php }?>
								</li>
								<?php }?>
								<?php if (($this->uri->segment(1) == 'recruiter') && ($this->uri->segment(2) == 'post' || $this->uri->segment(2) == 'profile' || $this->uri->segment(2) == 'add-post' || $this->uri->segment(2) == 'save-candidate') && ($this->uri->segment(3) == $this->session->userdata('aileenuser') || $this->uri->segment(3) == '')) {?>

								<li <?php if ($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'save-candidate') {?> class="active" <?php }?>><a title="Saved Candidate" href="<?php echo base_url('recruiter/saved-candidate'); ?>">Saved </a>
								</li>
							<?php }?>
							</ul>
							<?php
							if ($this->uri->segment(3) != "" && $this->uri->segment(3) != $userid)
							{ ?>
								<div class="flw_msg_btn fr">
									<ul>
										<li>
										<?php
										$returnpage = $_GET['page'];
										if ($this->uri->segment(3) != $userid) {
											$msg_url = MESSAGE_URL . 'job/recruiter-' . $recdata['slug'];
											?>
											<a href="<?php echo $msg_url; ?>" title="Message">Message</a>
										</li>
									</ul>
								</div>
							<?php }
							} ?>
					</div>
				</div>
			</div>
		</div>

		<!-- menubar -->
		<div class="container rec_res rec-dtl">
			<div class="job-menu-profile  mob-none job_edit_menu new-fw-name">
				<a href="javascript:void(0);" title="<?php echo $recdata['rec_firstname'] . ' ' . $recdata['rec_lastname']; ?>"><h3><?php echo $recdata['rec_firstname'] . ' ' . $recdata['rec_lastname']; ?></h3></a>
				<!-- text head start -->
				<div class="profile-text" >
					<?php
					if ($this->uri->segment(3) == $userid) {
						if ($recdata['designation'] == "") { ?>
							<a id="designation" class="designation" title="Designation">Designation</a>
							<?php
						} else { ?>
							<a id="designation" class="designation" title="<?php echo ucfirst(strtolower($recdata['designation'])); ?>"><?php echo ucfirst(strtolower($recdata['designation'])); ?></a>
						<?php }
					} else {
						if ($recdata['designation'] == '') { ?>
							<a id="designation"  title="Designation">Designation</a>
						<?php } else {?>
							<a id="designation"  title="<?php echo ucfirst(strtolower($recdata['designation'])); ?>"> <?php echo ucfirst(strtolower($recdata['designation'])); ?></a>
						<?php }
					} ?>
				</div>
			</div>
			<!-- text head end -->
			<div class="cus-inner-middle mob-clear mobp0">
				<div class="tab-add-991">
					<?php $this->load->view('banner_add');?>
				</div>
				<div class="common-form">
					<!-- Basic information  -->
					<div class="dtl-box">
						<div class="dtl-title">
							<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/about.png?ver=' . time()) ?>"><span>Basic Information</span>
							<?php if ($this->uri->segment(3) == $userid) { ?>
							<a href="#" data-target="#job-basic-info" data-toggle="modal" class="pull-right" ng-click="edit_rec_basic_info();"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
							<?php } ?>
						</div>
						<div id="rec-info-loader" class="dtl-dis">
                            <div class="text-center">
                                <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
                            </div>
                        </div>
                        <div id="rec-info-body" style="display: none;">
							<div class="dtl-dis">
								<ul class="dis-list list-ul-cus">
									<li ng-if="rec_basic_info.title_name">
										<span>Current Position</span>
										<label>{{rec_basic_info.title_name}}</label>
									</li>
									<li ng-if="rec_basic_info.rec_role_res">
										<span>Role & Responsibilities</span>
										<label>{{rec_basic_info.rec_role_res}}</label>
									</li>
									<li ng-if="rec_basic_info.rec_exp_year > '0' || rec_basic_info.rec_exp_month > '0'">
										<span>Total Experience</span>
										<label ng-if="rec_basic_info.rec_exp_year > '0'">{{rec_basic_info.rec_exp_year}} Year{{rec_basic_info.rec_exp_year > '1' ? 's' : ''}}</label>
										<label ng-if="rec_basic_info.rec_exp_month > '0'">{{rec_basic_info.rec_exp_month}} Month{{rec_basic_info.rec_exp_month > '1' ? 's' : ''}}</label>
										
									</li>
									<li ng-if="rec_basic_info.rec_skills != ''">
										<span>Skills Hired For</span>
										<ul class="skill-list" ng-if="rec_skills_list.length > '0'">
											<li ng-repeat="rec_skills in rec_skills_list">{{rec_skills}}</li>
										</ul>
									</li>
									<li ng-if="rec_basic_info.rec_field > '-1'">
										<span>Industry Hired For</span>
										<label>{{rec_basic_info.rec_field_txt}}</label>
									</li>
									<li ng-if="rec_basic_info.rec_hire_level">
										<span>Hired Levels</span>
										<label ng-if="rec_basic_info.rec_hire_level == '1'">Intern</label>
										<label ng-if="rec_basic_info.rec_hire_level == '2'">Entry-level</label>
										<label ng-if="rec_basic_info.rec_hire_level == '3'">Associate</label>
										<label ng-if="rec_basic_info.rec_hire_level == '4'">Mid-senior</label>
										<label ng-if="rec_basic_info.rec_hire_level == '5'">Director</label>
										<label ng-if="rec_basic_info.rec_hire_level == '6'">Executive</label>
									</li>
								</ul>
							</div>
						</div>
					</div>

					<!-- Company Details  -->
					<div class="dtl-box">
						<div class="dtl-title">
							<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/company-details.png?ver=' . time()) ?>"><span>Company Details</span>
							<?php if ($this->uri->segment(3) == $userid) { ?>
							<a href="#" data-target="#experience" data-toggle="modal" class="pull-right" ng-click="edit_rec_comp_info();"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
							<?php } ?>
						</div>
						<div id="rec-comp-loader" class="dtl-dis">
                            <div class="text-center">
                                <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
                            </div>
                        </div>
                        <div id="rec-comp-body" style="display: none;">
							<div class="dtl-dis">
								<ul class="dis-list">
									<li ng-if="rec_comp_data.re_comp_name">
										<span>Company Name</span>
										<label>{{rec_comp_data.re_comp_name}}</label>
									</li>
									<li ng-if="rec_comp_data.re_comp_email">
										<span>Company Email Id</span>
										<label>{{rec_comp_data.re_comp_email}}</label>
									</li ng-if="rec_comp_data.re_comp_phone">
									<li ng-if="rec_comp_data.re_comp_phone > '0'">
										<span>Company Phone number</span>
										<label>{{rec_comp_data.re_comp_phone}}</label>
									</li>
									<li ng-if="rec_comp_data.re_comp_site">
										<span>Company Website URL</span>
										<a href="{{rec_comp_data.re_comp_site}}">{{rec_comp_data.re_comp_site}}</a>
									</li>
									<li ng-if="rec_comp_data.re_comp_size > '0'">
										<span>Company Size</span>
										<label>{{rec_comp_data.re_comp_size}}</label>
									</li>
									<li ng-if="rec_comp_data.re_comp_field > '-1'">
										<span>Industry Type </span>
										<label ng-if="rec_comp_data.re_comp_field != '0'">{{rec_comp_data.re_comp_field_txt}}</label>
										<label ng-if="rec_comp_data.re_comp_field == '0'">{{rec_comp_data.re_comp_other_field}}</label>
									</li>
									<li ng-if="rec_comp_data.re_comp_culture > '0'">
										<span>Company Culture</span>
										<label ng-if="rec_comp_data.re_comp_culture == '2'">Traditional</label>
										<label ng-if="rec_comp_data.re_comp_culture == '3'">Corporate</label>
										<label ng-if="rec_comp_data.re_comp_culture == '4'">Start-Up</label>
										<label ng-if="rec_comp_data.re_comp_culture == '5'">Free Spirit</label>
										<label ng-if="rec_comp_data.re_comp_culture == '6'">Don't Specify</label>
										<label ng-if="rec_comp_data.re_comp_culture == '1'">Others</label>
									</li>
									<li>
										<span>Company Location</span>
										<label>{{rec_comp_data.city_name}}
										{{rec_comp_data.city_name != '' && rec_comp_data.state_name != '' ? ', ':''}}
										{{rec_comp_data.state_name}}
										{{rec_comp_data.state_name != '' && rec_comp_data.country_name != '' ? ', ':''}}
										{{rec_comp_data.country_name}}</label>
									</li>
									<li ng-if="rec_comp_data.re_comp_profile != ''">
										<span>Company Profile</span>
										<label>{{rec_comp_data.re_comp_profile}}</label>
									</li>
									<li ng-if="rec_comp_data.re_comp_other_activity != ''">
										<span>Other Activities</span>
										<ul class="skill-list" ng-if="re_comp_other_activity_list.length > '0'">
											<li ng-repeat="rec_activity in re_comp_other_activity_list">{{rec_activity}}</li>
										</ul>
									</li>
									<li ng-if="rec_comp_data.comp_logo && rec_comp_data.comp_logo != 'null'">
										<span>Company Logo</span>
										<a href="<?php echo REC_PROFILE_THUMB_UPLOAD_URL; ?>{{rec_comp_data.comp_logo}}" target="_self">
										<img style="width:50px;" src="<?php echo REC_PROFILE_THUMB_UPLOAD_URL; ?>{{rec_comp_data.comp_logo}}"></a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="banner-add">
					<?php $this->load->view('banner_add');?>
				</div>
			</div>
			<div class="right-add add-detail">
				<?php if ($this->uri->segment(3) == $userid) { ?>
				<div class="dtl-box">
					<div class="dtl-title">
						<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/e-profile.png?ver=' . time()) ?>"><span>Edit Profile</span>
					</div>
					<div class="dtl-dis dtl-edit-p">
						<div class="dtl-edit-top"></div>
                        <div class="profile-status">
                            <ul>
                                <li><span class=""><img ng-if="progress_status.user_image_status == '1'" src="<?php echo base_url(); ?>assets/n-images/detail/c.png"></span>Profile pic</li>

                                <li class="pl20"><span class=""><img ng-if="progress_status.profile_background_status == '1'" src="<?php echo base_url(); ?>assets/n-images/detail/c.png"></span>Cover pic</li>
                                
                                <li class="fw"><span class=""><img ng-if="progress_status.user_fname_status == '1' && progress_status.user_lname_status == '1' && progress_status.user_jobtitle_status == '1' && progress_status.user_field_status == '1' && progress_status.user_skill_status == '1' && progress_status.user_roleres_status == '1' && progress_status.user_hirelevel_status == '1' && progress_status.user_expyear_status == '1' && progress_status.user_expmonth_status == '1'" src="<?php echo base_url(); ?>assets/n-images/detail/c.png"></span>Basic Information</li>
                                
                                <li class="fw"><span class=""><img ng-if="progress_status.user_compname_status == '1' && progress_status.user_compemail_status == '1' && progress_status.user_compphone_status == '1' && progress_status.user_compsize_status == '1' && progress_status.user_compfield_status == '1' && progress_status.user_compculture_status == '1' && progress_status.user_compcounrty_status == '1' && progress_status.user_compstate_status == '1' && progress_status.user_compcity_status == '1' && progress_status.user_compprofile_status == '1'" src="<?php echo base_url(); ?>assets/n-images/detail/c.png"></span>Company Details</li>

                                
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
				<?php } ?>
				<div class="right-add-box"> 
					<div class="dtl-box p10 dtl-adv cus-add-block" style="margin: 0">
					</div>
				</div>
				<?php //$this->load->view('right_add_box');?>
			</div>
			<div class="clearfix"></div>
		</div>
		<!-- MIDDLE SECTION END-->
	</section>
	<!-- END CONTAINER -->

	<!---  model basic information  -->
	<div style="display:none;" class="modal fade dtl-modal" id="job-basic-info" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus">
					<div class="dtl-title">
						<span>Basic Information</span>
					</div>
					<form name="rec_info_form" id="rec_info_form" ng-validate="rec_info_validate">
						<div class="dtl-dis">
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
									<div class="form-group">
										<label>First Name</label>
										<input type="text" placeholder="First Name" id="rec_firstname" name="rec_firstname">
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
									<div class="form-group">
										<label>Last Name</label>
										<input type="text" placeholder="Last Name" id="rec_lastname" name="rec_lastname">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 col-sm-6">
									<div class="form-group">
										<label>Current Position</label>
										<!-- <input type="text" placeholder="Current Position" id="rec_jotitle" name="rec_jotitle"> -->
										<input type="text" placeholder="Enter Job Title" id="rec_jotitle" name="rec_jotitle" ng-model="rec_jotitle" ng-keyup="rec_job_title_list()" typeahead="item as item.name for item in titleSearchResult | filter:$viewValue" autocomplete="off">
									</div>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="form-group">
										<label>Industry Hired For</label>
										<span class="span-select">
											<?php $getFieldList = $this->data_model->getNewFieldList();?>
	                                        <select name="rec_field" id="rec_field" ng-model="rec_field" ng-change="rec_other_field_fnc()">
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
							<div id="rec_other_field_div" class="row" style="display: none;">
								<div class="col-md-6 col-sm-6"></div>
	                            <div class="col-md-6 col-sm-6">
	                                <div class="form-group">
	                                <label>Other Field</label>
	                                <input type="text" placeholder="Enter Other Field" id="rec_other_field" name="rec_other_field" ng-model="rec_other_field">
	                                </div>
	                            </div>                            
	                        </div>
							<div class="form-group">
								<label>Skills Hired For</label>
								<!-- <input type="text" placeholder="Skills Hired"> -->
								<tags-input id="rec_skill_list" ng-model="rec_skill_list" display-property="name" placeholder="Enter Skills" replace-spaces-with-dashes="false" template="title-template" on-tag-added="onKeyup()" ng-keyup="rec_skills_fnc()">
                                    <auto-complete source="loadSkills($query)" min-length="0" load-on-focus="false" load-on-empty="false" max-results-to-show="32" template="title-autocomplete-template"></auto-complete>
                                </tags-input>                        
                                <script type="text/ng-template" id="title-template">
                                    <div class="tag-template"><div class="right-panel"><span>{{$getDisplayText()}}</span><a class="remove-button" ng-click="$removeTag()">&#10006;</a></div></div>
                                </script>
                                <script type="text/ng-template" id="title-autocomplete-template">
                                    <div class="autocomplete-template"><div class="right-panel"><span ng-bind-html="$highlight($getDisplayText())"></span></div></div>
                                </script>
                                <label id="rec_skill_err" for="rec_skill_list" class="error" style="display: none;">Please enter skills</label>
							</div>
							<div class="form-group">
								<label>Role & Responsibilities</label>
								<textarea type="text" placeholder="Role & Responsibilities" id="rec_role_res" name="rec_role_res"></textarea>
							</div>
							<div class="form-group">
								<label>Hired Levels</label>
								<span class="span-select">
									<select id="rec_hire_level" name="rec_hire_level">
										<option value="">Select Hired Levels</option>
										<option value="1">Intern</option>
										<option value="2">Entry-level</option>
										<option value="3">Associate</option>
										<option value="4">Mid-senior</option>
										<option value="5">Director</option>
										<option value="6">Executive</option>
									</select>
								</span>
							</div>
							<div class="">
								<div class="form-group">
									<label>Total Experience</label>
									<div class="row">
										<div class="col-md-6 col-sm-6 col-xs-6">
											<span class="span-select">
												<select id="rec_exp_year" name="rec_exp_year">
													<option value="">Year</option>
													<?php for($y=1;$y<=20;$y++){ ?>
														<option value="<?php echo $y; ?>"><?php echo $y; ?></option>
													<?php } ?>
												</select>
											</span>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-6">
											<span class="span-select">
												<select id="rec_exp_month" name="rec_exp_month">
													<option value="">Month</option>
													<?php for($m=1;$m<=11;$m++){ ?>
														<option value="<?php echo $m; ?>"><?php echo $m; ?></option>
													<?php } ?>
												</select>
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="dtl-btn">
							<!-- <a href="#" class="save"><span>Save</span></a> -->
							<a id="save_rec_info" href="#" ng-click="save_rec_info()" class="save"><span>Save</span></a>
                            <div id="rec_info_loader" class="dtl-popup-loader" style="display: none;">
                                <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" >
                            </div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!---  model Experience  -->
	<div style="display:none;" class="modal fade dtl-modal" id="experience" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus">
					<div class="dtl-title">
						<span>Company Details</span>
					</div>
					<form name="rec_comp_form" id="rec_comp_form" ng-validate="rec_comp_validate">
						<div class="dtl-dis">
							<div class="form-group">
								<label>Company Name</label>
								<input type="text" placeholder="Enter Company Name" id="re_comp_name" name="re_comp_name">
							</div>

							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
									<div class="form-group">
										<label>Company Email Id</label>
										<input type="text" placeholder="Enter Company Website" id="re_comp_email" name="re_comp_email">
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
									<div class="form-group">
										<label>Company Phone number</label>
										<input type="text" placeholder="Enter Phone number" id="re_comp_phone" name="re_comp_phone">
									</div>
								</div>

							</div>
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
									<div class="form-group">
										<label>Company Website <span class="link-must">(Must be http:// or https://)</span></label>
										<input type="text" placeholder="Enter Company Website" id="re_comp_site" name="re_comp_site">
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
									<div class="form-group">
										<label>Company Size</label>
										<input type="text" placeholder="Enter Company Size" id="re_comp_size" name="re_comp_size">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 col-sm-6">
									<div class="form-group">
										<label>Industry Type </label>
										<span class="span-select">
											<?php $getFieldList = $this->data_model->getNewFieldList();?>
	                                        <select name="re_comp_field" id="re_comp_field" ng-model="re_comp_field" ng-change="re_comp_other_field_fnc()">
	                                                <option value="">Select Field</option>
	                                            <?php foreach ($getFieldList as $key => $value) { ?>
	                                                <option value="<?php echo $value['industry_id']; ?>""><?php echo $value['industry_name']; ?></option>
	                                            <?php } ?>
	                                            <option value="0">Other</option>
	                                        </select>
										</span>
									</div>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="form-group">
										<label>Company Culture </label>
										<span class="span-select">
											<select id="re_comp_culture" name="re_comp_culture">
												<option value="">Select Company Culture</option>
												<option value="2">Traditional</option>
												<option value="3">Corporate</option>
												<option value="4">Start-Up</option>
												<option value="5">Free Spirit</option>
												<option value="6">Don't Specify</option>
												<option value="1">Others</option>
											</select>
										</span>
									</div>
								</div>
							</div>
							<div id="re_comp_field_div" class="row" style="display: none;">
	                            <div class="col-md-6 col-sm-6">
	                                <div class="form-group">
	                                <label>Other Field</label>
	                                <input type="text" placeholder="Enter Other Field" id="re_comp_other_field" name="re_comp_other_field" ng-model="re_comp_other_field">
	                                </div>
	                            </div>                            
								<div class="col-md-6 col-sm-6"></div>
	                        </div>

							<div class="dtl-dob ">
								<label>Company Location</label>
								<div class="row">
									<div class="col-md-4 col-sm-4 col-xs-4 fw-479">
										<div class="form-group">
											<span class="span-select">
												<select id="re_comp_country" name="re_comp_country" ng-model="re_comp_country" ng-change="re_comp_country_change()">
                                                    <option value="">Country</option>         
                                                    <option data-ng-repeat='country_item in rec_country_list' value='{{country_item.country_id}}'>{{country_item.country_name}}</option>
                                                </select>
											</span>
										</div>
									</div>
									<div class="col-md-4 col-sm-4 col-xs-4 fw-479">
										<div class="form-group">
											<span class="span-select">
												<select id="re_comp_state" name="re_comp_state" ng-model="re_comp_state" ng-change="re_comp_state_change()" disabled = "disabled">
                                                    <option value="">State</option>
                                                    <option data-ng-repeat='state_item in re_comp_state_list' value='{{state_item.state_id}}'>{{state_item.state_name}}</option>
                                                </select>
                                                <img id="re_comp_state_loader" src="<?php echo base_url('assets/img/spinner.gif') ?>" style="   width: 20px;position: absolute;top: 6px;right: 19px;display: none;">
											</span>
										</div>
									</div>
									<div class="col-md-4 col-sm-4 col-xs-4 fw-479">
										<div class="form-group">
											<span class="span-select">
												<select id="re_comp_city" name="re_comp_city" ng-model="re_comp_city" disabled = "disabled">
                                                    <option value="">City</option>
                                                    <option data-ng-repeat='city_item in re_comp_city_list' value='{{city_item.city_id}}'>{{city_item.city_name}}</option>
                                                </select>
                                                <img id="re_comp_city_loader" src="<?php echo base_url('assets/img/spinner.gif') ?>" style="   width: 20px;position: absolute;top: 6px;right: 19px;display: none;">
											</span>
										</div>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label>Company Profile</label>
								<textarea type="text" placeholder="Company Profile" id="re_comp_profile" name="re_comp_profile"></textarea>
							</div>
							<div class="form-group">
								<label>Other Activities</label>
								<!-- <input type="text" placeholder="Company Profile"> -->
								<tags-input id="re_comp_other_activity_txt" ng-model="re_comp_other_activity_txt" display-property="activity" placeholder="Company Other Activities" replace-spaces-with-dashes="false" template="title-template" ng-keyup="re_comp_other_activity_fnc()"></tags-input>
								<label id="re_comp_other_activity_err" for="re_comp_other_activity_txt" class="error" style="display: none;">Please enter other activity</label>
							</div>
							<div class="form-group">
								<div class="upload-file">
									<label>Upload Company Logo</label>
									<input type="file" id="re_comp_logo" name="re_comp_logo">
									<span id="re_comp_logo_error" class="error" style="display: none;"></span>
								</div>
							</div>
						</div>
						<div class="dtl-btn">
							<!-- <a href="#" class="save"><span>Save</span></a> -->
							<a id="save_rec_comp_info" href="#" ng-click="save_rec_comp_info()" class="save"><span>Save</span></a>
                            <div id="rec_comp_info_loader" class="dtl-popup-loader" style="display: none;">
                                <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" >
                            </div>
						</div>
					</form>
				</div>

            </div>
        </div>
    </div>


	<!--PROFILE PIC MODEL START-->
	<div class="modal fade message-box" id="bidmodal-2" role="dialog">
		<div class="modal-dialog modal-lm">
			<div class="modal-content">
				<button type="button" class="modal-close" data-dismiss="modal">&times;</button>
				<div class="modal-body">
					<span class="mes">
						<div id="popup-form">
							<div class="fw" id="profi_loader" style="display:none;text-align:center;" >
								<img src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) ?>" alt="<?php echo 'LOADERIMAGE'; ?>"/>
							</div>
							<form id="userimage" name="userimage" class="clearfix" enctype="multipart/form-data" method="post">
								<div class="fw">
									<input type="file" name="profilepic" accept="image/gif, image/jpeg, image/png" id="upload-one" >
								</div>
								<div class="col-md-7 text-center">
									<div id="upload-demo-one" style="display:none;" style="width:350px"></div>
								</div>
								<input type="submit" class="upload-result-one" name="profilepicsubmit" id="profilepicsubmit" value="Save" >
							</form>
						</div>
					</span>
				</div>
			</div>
		</div>
	</div>
	<!--PROFILE PIC MODEL END-->

	<!-- BEGIN FOOTER -->
	<?php echo $login_footer ?>
	<?php echo $footer; ?>
	<!-- END FOOTER -->

	<!-- FIELD VALIDATION JS START -->
	<script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>
	<script src="<?php echo base_url('assets/js/croppie.js?ver=' . time()); ?>"></script>

	<script src="<?php echo base_url('assets/js/progressloader.js?ver=' . time()); ?>"></script>
    <script src="<?php echo base_url('assets/js/masonry.pkgd.min.js?ver=' . time()); ?>"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
    <script data-semver="0.13.0" src="https://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
    <script src="<?php echo base_url('assets/js/angular-validate.min.js?ver=' . time()) ?>"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
    <script src="<?php echo base_url('assets/js/ng-tags-input.min.js?ver=' . time()); ?>"></script>
    <script src="<?php echo base_url('assets/js/angular/angular-tooltips.min.js?ver=' . time()); ?>"></script>
    <script src="<?php echo base_url('assets/js/angular-google-adsense.min.js'); ?>"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-sanitize.js"></script>

	<script type="text/javascript">
		var header_all_profile = '<?php echo $header_all_profile; ?>';
		var base_url = '<?php echo base_url(); ?>';
		var jobdata = <?php echo json_encode($jobtitle); ?>;
		var user_id = <?php echo $this->uri->segment(3); ?>;
		var rec_profile_thumb_upload_url = "<?php echo REC_PROFILE_THUMB_UPLOAD_URL; ?>";
		var get_csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
		var get_csrf_hash = '<?php echo $this->security->get_csrf_hash(); ?>';
		var app = angular.module("userRecProfileApp", ['ngRoute', 'ui.bootstrap', 'ngTagsInput', 'ngSanitize','angular-google-adsense', 'ngValidate']);
	</script>
	<script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>

	<!-- FIELD VALIDATION JS END -->
	<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/recruiter/rec_profile_new.js'); ?>"></script>
	
	<?php
	if ($this->uri->segment(3) != $userid) { ?>
		<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/job/search_common.js?ver=' . time()); ?>"></script>
	<?php } else {?>
		<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/recruiter/search.js'); ?>"></script>
	<?php }?>
	
	<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/recruiter/rec_profile.js'); ?>"></script>
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