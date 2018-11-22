<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title; ?></title>
	<meta name="description" content="<?php echo $metadesc; ?>" />
	<?php echo $head; ?> 
	<?php
	if (IS_REC_CSS_MINIFY == '0') {
		?>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css'); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/recruiter.css'); ?>">
	<?php
		} else {
	?>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css'); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/recruiter.css'); ?>">
	<?php } ?>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>" />
<?php $this->load->view('adsense'); ?>
</head>
<body class="page-container-bg-solid page-boxed pushmenu-push botton_footer">
		<?php //echo $header; ?>
		<?php
		$returnpage= $_GET['page'];
		$userid = $this->session->userdata('aileenuser');
		if ($this->uri->segment(3) != $userid){
		   echo $job_header2; 
	   	}
	   	elseif($recdata['re_step'] == 3){
		  	echo $recruiter_header2; 
	  	}
		elseif($returnpage == 'notification'){

		}
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
						$s3 = new S3(awsAccessKey, awsSecretKey);
						$this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
						if ($info && $image[0]['profile_background'] != '') {
					?>
					<img src = "<?php echo REC_BG_MAIN_UPLOAD_URL . $image[0]['profile_background']; ?>" name="image_src" id="image_src" alt="<?php echo $image[0]['profile_background']; ?>"/>
					<?php
						} else {
					?>
					<div class="bg-images no-cover-upload">
					   <img src="<?php echo base_url(WHITEIMAGE); ?>" name="image_src" id="image_src" alt="<?php echo 'NOIMAGE'; ?>" />
				    </div>
				   		<?php }
				   ?>
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
					   <?php  $filename = $this->config->item('rec_profile_thumb_upload_path') . $recdata['recruiter_user_image'];
					   $s3 = new S3(awsAccessKey, awsSecretKey);
					   $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
					   if ($recdata['recruiter_user_image'] != '' && $info) { ?>
					   <img src="<?php echo REC_PROFILE_THUMB_UPLOAD_URL . $recdata['recruiter_user_image']; ?>" alt="<?php echo $recdata['recruiter_user_image']; ?>" >
					   <?php
				   } else {
					$a = $recdata['rec_firstname'];
					$acr = substr($a, 0, 1);
					$b = $recdata['rec_lastname'];
					$acr1 = substr($b, 0, 1);
					?>
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
						if ($recdata['designation'] == '') {
							?>
							<a id="designation" class="designation" title="Designation">Designation</a>
						<?php } else {
						?> 
						<a id="designation" class="designation" title="<?php echo ucfirst(strtolower($recdata['designation'])); ?>"><?php echo ucfirst(strtolower($recdata['designation'])); ?></a>
					<?php
						}
					} else {
							if ($recdata['designation'] == '') {
								?>
								<a id="designation"  title="Designation">Designation</a>
				  	<?php } else {  ?>
								<a id="designation"  title="<?php echo ucfirst(strtolower($recdata['designation'])); ?>"> <?php echo ucfirst(strtolower($recdata['designation'])); ?></a> <?php
							}
						}
					?>
					</div>
				</div>
				<!-- menubar -->
				<div class="profile-main-rec-box-menu profile-box-art col-md-12 padding_les">
					<div class=" right-side-menu art-side-menu padding_less_right job_edit_pr right-menu-jr">    <?php
							$userid = $this->session->userdata('aileenuser');
							if ($recdata['user_id'] == $userid) {
							?>     
							<ul class="current-user pro-fw">
								<?php } else { ?>
								<ul class="pro-fw4">
									<?php } ?>  
									<li <?php if ($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'profile') { ?> class="active" <?php } ?>>
										<?php if ($this->uri->segment(3) != $userid) { ?>
										<a title="Details" href="<?php echo base_url('recruiter/profile/' . $this->uri->segment(3)); ?>">Details</a>
										<?php } else { ?>
										<a title="Details" href="<?php echo base_url('recruiter/profile'); ?>">Details</a>
										<?php } ?>
									</li>
									<?php if (($this->uri->segment(1) == 'recruiter') && ($this->uri->segment(2) == 'post' || $this->uri->segment(2) == 'profile' || $this->uri->segment(2) == 'add-post' || $this->uri->segment(2) == 'save-candidate') && ($this->uri->segment(3) == $this->session->userdata('aileenuser') || $this->uri->segment(3) == '' || $this->uri->segment(3) != '')) { ?>

									<li <?php if ($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'post') { ?> class="active" <?php } ?>>
										<?php if ($this->uri->segment(3) != $userid) { ?>
										<a title="Post" href="<?php echo base_url('recruiter/post/' . $this->uri->segment(3)); ?>">Post</a>
										<?php } else { ?>
										<a title="Post" href="<?php echo base_url('recruiter/post'); ?>">Post</a>
										<?php } ?>
									</li>
									<?php } ?>   
									<?php if (($this->uri->segment(1) == 'recruiter') && ($this->uri->segment(2) == 'post' || $this->uri->segment(2) == 'profile' || $this->uri->segment(2) == 'add-post' || $this->uri->segment(2) == 'save-candidate') && ($this->uri->segment(3) == $this->session->userdata('aileenuser') || $this->uri->segment(3) == '')) { ?>

									<li <?php if ($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'save-candidate') { ?> class="active" <?php } ?>><a title="Saved Candidate" href="<?php echo base_url('recruiter/saved-candidate'); ?>">Saved </a>
									</li> 
									<?php } ?>               
								</ul>
								<?php if ($this->uri->segment(3) != "" && $this->uri->segment(3) != $userid) { ?>
								<div class="flw_msg_btn fr">
									<ul>      
										<li>
											<?php
											$returnpage = $_GET['page'];
											if ($this->uri->segment(3) != $userid) {
												// $msg_url = base_url('chat/abc/1/2/' . $this->uri->segment(3));//Old
												$msg_url = MESSAGE_URL.'job/recruiter-'.$recdata['slug'];
												?>
												<a href="<?php echo $msg_url; ?>" title="Message">Message</a>
												<?php } /*else { ?>
												<a href="<?php echo base_url('chat/abc/2/1/' . $this->uri->segment(3)); ?>" title="Message">Message</a>
												<?php }*/ ?>
											</li> 
										</ul>
									</div>
									<?php } ?>  
								</div>
							</div>  
						</div>            
					</div>
				
					<!-- menubar --> 
					<div class="container rec_res rec-dtl">
						<div class="job-menu-profile  mob-none job_edit_menu new-rec-name">
							<a href="javascript:void(0);" title="<?php echo $recdata['rec_firstname'] . ' ' . $recdata['rec_lastname']; ?>"><h3><?php echo $recdata['rec_firstname'] . ' ' . $recdata['rec_lastname']; ?></h3></a>
							<!-- text head start -->
							<div class="profile-text" >

								<?php
								if ($this->uri->segment(3) == $userid) {
									if ($recdata['designation'] == "") {
										?>

										<a id="designation" class="designation" title="Designation">Designation</a>
										<?php
									} else {
										?> 
										
										<a id="designation" class="designation" title="<?php echo ucfirst(strtolower($recdata['designation'])); ?>"><?php echo ucfirst(strtolower($recdata['designation'])); ?></a>
										<?php
									}
								} else {
								 if ($recdata['designation'] == '') {
									?>
									
									<a id="designation"  title="Designation">Designation</a>

									<?php } else {  ?>
									<a id="designation"  title="<?php echo ucfirst(strtolower($recdata['designation'])); ?>"> <?php echo ucfirst(strtolower($recdata['designation'])); ?></a> <?php
								}
							}
							?>

						</div>

						
					</div>
					<!-- text head end -->

					<div class="cus-inner-middle mob-clear mobp0">
						<div class="tab-add-991">
							<?php $this->load->view('banner_add'); ?>
						</div>
						<div class="common-form">

							
						<!-- Basic information  -->
						
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/about.png?ver=' . time()) ?>"><span>Basic Information</span><a href="#" data-target="#job-basic-info" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
								</div>
								<div class="dtl-dis">
									<ul class="dis-list">
										
										<li>
											<span>Current Position</span>
											Sr. Multimedia Designer
										</li>
										<li>
											<span>Role & Responsibilities</span>
											Manage team
										</li>
										<li>
											<span>Total Experience</span>
											5 years 5 month
										</li>
										<li>
											<span>Skills Hired For</span>
											<ul class="skill-list">
												<li>HTML</li>
												<li>PHP</li>
												<li>CSS</li>
											</ul>
											 
										</li>
										<li>
											<span>Industry Hired For</span>
											IT sector
										</li>
										<li>
											<span>Hired Levels</span>
											Director
										</li>
								
										
								
										
									</ul>
								</div>
								
								
							</div>
						
						
						
						<!-- Company Details  -->
						
						
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/company-details.png?ver=' . time()) ?>"><span>Company Details</span><a href="#" data-target="#experience" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
								</div>
								<div class="dtl-dis">
									<ul class="dis-list">
										
										<li>
											<span>Company Name</span>
											Verve system pvt ltd
										</li>
										<li>
											<span>Company Email Id</span>
											info@verve.com
										</li>
										<li>
											<span>Company Phone number</span>
											+91 9874563210
										</li>
										<li>
											<span>Company Website URL</span>
											<a href="#">www.vervesystem.com</a>
										</li>
										<li>
											<span>Company Size</span>
											108
										</li>
										<li>
											<span>Industry Type </span>
											IT Sector
										</li>
										<li>
											<span>Company Culture </span>
											Corporate
										</li>
										<li>
											<span>Company Location</span>
											Ahmedabad , Gujarat , India
										</li>
										<li>
											<span>Company Profile</span>
											With jQuery, I am looking to find the anchor tag in div i.e. div1 anchor tag. I need to add a class to it on button click. Follow Answer ...
										</li>
										<li>
											<span>Other Activities</span>
											<ul class="skill-list">
												<li>Plying game</li>
												<li>Annual function</li>
												<li>Csr activity</li>
											</ul>
										</li>
										<li>
											<span>Company Logo</span>
											<img style="width:50px;" src="<?php echo base_url('assets/n-images/detail/website.png?ver=' . time()) ?>">
										</li>
										
								
										
								
										
									</ul>
								</div>
								
							</div>
							
						</div>
						<div class="banner-add">
							<?php $this->load->view('banner_add'); ?>
							
						</div>
					</div>
					<div class="right-add">
						<div class="dtl-box p10 dtl-adv">
								<img src="<?php echo base_url('assets/n-images/detail/add.png?ver=' . time()) ?>">
							</div>
						<?php $this->load->view('right_add_box'); ?>
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
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Current Position </label>
									<input type="text" placeholder="Current Position">
								</div>
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Industry Hired For</label>
									<span class="span-select">
										<select>
											<option>industry name</option>
											<option>IT sector</option>
											<option>Factory</option>
											<option>Industry</option>
										</select>
									</span>
									
								</div>
							</div>
						</div>
						<div class="form-group">
							<label>Skills Hired For</label>
							<input type="text" placeholder="Role & Responsibilities">
						</div>
						<div class="form-group">
							<label>Role & Responsibilities</label>
							<textarea type="text" placeholder="Role & Responsibilities"></textarea>
						</div>
						<div class="form-group">
									<label>Hired Levels</label>
									<span class="span-select">
										<select>
											<option>Intern</option>
											<option>Entry-level</option>
											<option>Associate</option>
											<option>Mid-senior</option>
											<option>Director</option>
											<option>Executive</option>
										</select>
									</span>
									
								</div>
						
							<div class="">
								<div class="form-group">
									<label>Total Experience</label>
									<div class="row">
										<div class="col-md-6 col-sm-6 col-xs-6">
											<span class="span-select">
												<select>
													<option>Year</option>
													<option>1</option>
													<option>2</option>
													<option>3</option>
													<option>4</option>
													<option>5</option>
												</select>
											</span>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-6">
											<span class="span-select">
												<select>
													<option>Month</option>
													<option>1</option>
													<option>2</option>
													<option>3</option>
													<option>4</option>
												</select>
											</span>
										</div>
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
	
	<!---  model Experience  -->
	<div style="display:none;" class="modal fade dtl-modal" id="experience" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Company Details</span>
					</div>
					<div class="dtl-dis">
						<div class="form-group">
							<label>Company Name</label>
							<input type="text" placeholder="Enter Company Name">
						</div>
						
						<div class="row">
							<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
								<div class="form-group">
									<label>Company Email Id</label>
									<input type="text" placeholder="Enter Company Website">
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
								<div class="form-group">
									<label>Company Phone number</label>
									<input type="text" placeholder="Enter Company Website">
								</div>
							</div>
							
						</div>
						<div class="row">
							<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
								<div class="form-group">
									<label>Company Website URL</label>
									<input type="text" placeholder="Enter Company Website">
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
								<div class="form-group">
									<label>Company Size</label>
									<input type="text" placeholder="Enter Company Website">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Industry Type </label>
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
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Company Culture </label>
									<span class="span-select">
										<select>
											<option>Traditional</option>
											<option>Corporate</option>
											<option>Start-Up</option>
											<option>Free Spirit</option>
											<option>Don't Specify</option>
											<option>others</option>
										</select>
									</span>
								</div>
							</div>
						</div>
					
						
						<div class="dtl-dob ">
							<label>Company Location</label>
							<div class="row">
								<div class="col-md-4 col-sm-4 col-xs-4 fw-479">
								<div class="form-group">
									<span class="span-select">
										<select>
											<option>Country</option>
											<option>America</option>
											<option>India</option>
											<option>Japan</option>
										</select>
									</span>
								</div>
								</div>
								<div class="col-md-4 col-sm-4 col-xs-4 fw-479">
								<div class="form-group">
									<span class="span-select">
										<select>
											<option>State</option>
											<option>Gujrat</option>
											<option>Delhi</option>
											<option>Rajsthaan</option>
										</select>
									</span>
								</div>
								</div>
								<div class="col-md-4 col-sm-4 col-xs-4 fw-479">
								<div class="form-group">
									<span class="span-select">
										<select>
											<option>City</option>
											<option>Ahmedabad</option>
											<option>Rajkot</option>
											<option>Junagadh</option>
										</select>
									</span>
								</div>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label>Company Profile</label>
							<textarea type="text" placeholder="Company Profile"></textarea>
						</div>
						<div class="form-group">
							<label>Other Activities</label>
							<input type="text" placeholder="Company Profile">
						</div>
						<div class="form-group">
							<label class="upload-file">
								Upload Company Logo<input type="file">
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
	
	
<!--PROFILE PIC MODEL START-->
<div class="modal fade message-box" id="bidmodal-2" role="dialog">
   <div class="modal-dialog modal-lm">
	<div class="modal-content">
	 <button type="button" class="modal-close" data-dismiss="modal">&times;</button>      
	 <div class="modal-body">
	  <span class="mes">
	   <div id="popup-form">

		<div class="fw" id="profi_loader"  style="display:none;" style="text-align:center;" ><img src="<?php echo base_url('assets/images/loader.gif?ver='.time()) ?>" alt="<?php echo 'LOADERIMAGE'; ?>"/></div>
		<form id ="userimage" name ="userimage" class ="clearfix" enctype="multipart/form-data" method="post">
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


<?php
if (IS_REC_JS_MINIFY == '0') {
	?>
	<script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script> 
	<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>
	<script src="<?php echo base_url('assets/js/croppie.js?ver='.time()); ?>"></script>
	<?php
} else {
	?>
	<script src="<?php echo base_url('assets/js_min/bootstrap.min.js'); ?>"></script> 
	<script type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver=' . time()); ?>"></script>
	<script src="<?php echo base_url('assets/js_min/croppie.js?ver='.time()); ?>"></script>
	<?php } ?>
	<script type="text/javascript">
		var header_all_profile = '<?php echo $header_all_profile; ?>';
	</script>
	<script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
	<script>
		var base_url = '<?php echo base_url(); ?>';
		var jobdata = <?php echo json_encode($jobtitle); ?>;
		var get_csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
		var get_csrf_hash = '<?php echo $this->security->get_csrf_hash(); ?>';
	</script>

	<!-- FIELD VALIDATION JS END -->
	<?php
	if (IS_REC_JS_MINIFY == '0') {
	   if ($this->uri->segment(3) != $userid){   ?>
	   <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/job/search_common.js?ver='.time()); ?>"></script>
	   <?php }else{ ?>
	   <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/recruiter/search.js'); ?>"></script>
	   <?php } ?>
	   <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/recruiter/rec_profile.js'); ?>"></script>
	   <?php
   } else {
	 
	  if ($this->uri->segment(3) != $userid){   ?>
	  <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/job/search_common.js?ver='.time()); ?>"></script>
	  <?php }else{ ?>
	  <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/recruiter/search.js'); ?>"></script>
	  <?php } ?>
	  <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/recruiter/rec_profile.js'); ?>"></script>
	  <?php } ?>
	  


	  <style type="text/css">

	  .keyskill_border_active {
		border: 3px solid #f00 !important;

	}
	#skills-error{margin-top: 40px !important;}

	#minmonth-error{    margin-top: 40px; margin-right: 9px;}
	#minyear-error{margin-top: 42px !important;margin-right: 9px;}
	#maxmonth-error{margin-top: 42px !important;margin-right: 9px;}
	#maxyear-error{margin-top: 42px !important;margin-right: 9px;}

	#minmonth-error{margin-top: 39px !important;}
	#minyear-error{margin-top: auto !important;}
	#maxmonth-error{margin-top: 39px !important;}
	#maxyear-error{margin-top: auto !important;}
	#example2-error{margin-top: 40px !important}


</style>
</body>
</html>