<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <meta name="description" content="<?php echo $metadesc; ?>" />
        <!-- start head -->
        <?php echo $head; ?>
        <!-- END HEAD -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/job.css?ver=' . time()); ?>">        
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/component.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css') ?>">
    <?php $this->load->view('adsense'); ?>
</head>
    <!-- END HEAD -->
    
    <body class="page-container-bg-solid page-boxed botton_footer">
        <?php 
            $userid = $this->session->userdata('aileenuser');
            $id = $this->db->get_where('job_reg', array('slug' => $this->uri->segment(2)))->row()->user_id;
            if ($userid != $id) {
                echo $recruiter_header2;
            }
            else{
                echo $job_header2;
            }
        ?>
        <section class="custom-row">
            <div class="container  " id="paddingtop_fixed">
                <div class="row" id="row1" style="display:none;">
                    <div class="col-md-12 text-center">
                        <div id="upload-demo"></div>
                    </div>
                    <div class="col-md-12 cover-pic" >
                        <button class="btn btn-success  cancel-result" onclick="" >Cancel</button>
                        <button class="btn btn-success set-btn upload-result " onclick="myFunction()">Save</button>
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
                    <div class="">
                        <div class="" id="row2">

                            <?php
                            $userid = $this->session->userdata('aileenuser');

                            $id = $this->db->get_where('job_reg', array('slug' => $this->uri->segment_array()[count($this->uri->segment_array())]))->row()->user_id;

                            if ($userid == $id) {
                                $user_id = $userid;
                            } else {
                                $user_id = $id;
                            }
                            $contition_array = array('user_id' => $user_id, 'is_delete' => '0', 'status' => '1');
                            $image = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'profile_background', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                            $image_ori = $image[0]['profile_background'];

                            $filename = $this->config->item('job_bg_main_upload_path') . $image[0]['profile_background'];
                            $s3 = new S3(awsAccessKey, awsSecretKey);
                            $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                            if ($info && $image[0]['profile_background'] != '') {
                                ?>
                                <img src = "<?php echo JOB_BG_MAIN_UPLOAD_URL . $image[0]['profile_background']; ?>" name="image_src" id="image_src" alt="<?php echo $image[0]['profile_background']; ?>"/>
                                    <?php
                                } else {
                                    ?>
                                <div class="bg-images no-cover-upload">
                                    <img src="<?php echo base_url(WHITEIMAGE); ?>" name="image_src" id="image_src" alt="Noimage">
                                </div>
                                <?php }
                                ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container tablate-container art-profile  ">
                <?php
                $userid = $this->session->userdata('aileenuser');

                $id = $this->db->get_where('job_reg', array('slug' => $this->uri->segment(2)))->row()->user_id;
                if ($userid == $id) {
                    ?>
                    <div class="upload-img ">
                        <label class="cameraButton"> <span class="tooltiptext">Upload Cover Photo</span><i class="fa fa-camera" aria-hidden="true"></i>
                            <input type="file" id="upload" name="upload" accept="image/*;capture=camera" onclick="showDiv()">
                        </label>
                    </div>
                <?php } ?>
                <div class="profile-photo">
                    <div class="profile-pho">
                        <div class="user-pic padd_img">
                        <?php
                        $filename = $this->config->item('job_profile_thumb_upload_path') . $job[0]['job_user_image'];
                        $s3 = new S3(awsAccessKey, awsSecretKey);
                        $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                        if ($job[0]['job_user_image'] != '' && $info) {
                            ?>
                                <img src="<?php echo JOB_PROFILE_THUMB_UPLOAD_URL . $job[0]['job_user_image']; ?>" alt="<?php echo $job[0]['job_user_image']; ?>" >
                            <?php } else { ?>
                                <?php
                            
                                $a = $job[0]['fname'];
                                $acronym = substr($a, 0, 1);
                                $b = $job[0]['lname'];
                                $acronym1 = substr($b, 0, 1);
                                ?>
                                <div class="post-img-user">
                                    <?php echo ucfirst(strtolower($acronym)) . ucfirst(strtolower($acronym1)); ?>
                                </div>
                            <?php } ?>
                            <?php if ($userid == $id) { ?>
                                <a href="javascript:void(0);" class="cusome_upload" onclick="updateprofilepopup();"><img  src="<?php echo base_url(); ?>assets/img/cam.png" alt="<?php echo "Update Profile Picture"; ?>"> Update Profile Picture</a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="job-menu-profile  mob-block">
                        <a  href="javascript: void(0);">
                            <h5 class="profile-head-text"> <?php echo $job[0]['fname'] . ' ' . $job[0]['lname']; ?></h5>
                        </a>
                        <!-- text head start -->
                        <div class="profile-text" >
                            <?php
                            if ($userid == $id) {
                                if ($job[0]['designation'] == '') {
                                    ?>
                                    <a id="designation" class="designation" title="Designation">Current Work</a>
                                <?php } else {
                                    ?> 
                                    <a id="designation" class="designation" title="<?php echo ucwords($job[0]['designation']); ?>"><?php echo ucwords($job[0]['designation']); ?></a>
                                    <?php
                                }
                            } else {


                                if ($job[0]['designation'] == '') {
                                    ?>
                                    <a id="designation" style="cursor: default;"> <?php echo "Current Work"; ?> </a> 
                                <?php } else { ?>
                                    <a id="designation" style="cursor: default;"> <?php echo ucwords($job[0]['designation']); ?> </a> <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <?php echo $job_menubar; ?>   
                </div>
            </div>
            <div class="container res-job-print mobp0">
                <div class="job-menu-profile job_edit_menu mob-none">
                    <a  href="javascript: void(0);" title="<?php echo $job[0]['fname'] . ' ' . $job[0]['lname']; ?>">
                        <h3 class="profile-head-text">
                        <?php echo ucfirst($job[0]['fname']) . ' ' . ucfirst($job[0]['lname']); ?> 
                        </h3>
                    </a>
                    <div class="profile-text" >
                        <?php
                        if ($userid == $id) {
                            if ($job[0]['designation'] == '') {
                                ?>
                                <a id="designation" class="designation" title="Designation">Current Work</a>
                            <?php } else {
                                ?> 
                                <a id="designation" class="designation" title="<?php echo ucwords($job[0]['designation']); ?>"><?php echo ucwords($job[0]['designation']); ?></a>
                                <?php
                            }
                        } else {
                            if ($job[0]['designation'] == '') {
                                ?>
                                <a id="designation" style="cursor:default;"> <?php echo "Current Work"; ?> </a> 
                            <?php } else { ?>
                                <a id="designation" style="cursor:default;"> <?php echo ucwords($job[0]['designation']); ?> </a> <?php
                            }
                        }
                        ?>
                    </div>
                </div>

                <div class="cus-inner-middle mob-clear mobp0">
					
				</div>
                </div>
				<div class="fw">
					<div class="container mob-plr0 pt20">
			<div class="all-detail-custom">
				<div class="custom-user-list">
					<div class="gallery" id="gallery">
						<!-- Basic information  -->
						<div class="gallery-item">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/about.png?ver=' . time()) ?>"><span>Basic Information</span><a href="#" data-target="#job-basic-info" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
								</div>
								<div class="dtl-dis dtl-box-height">
									<ul class="dis-list">
										
										<li>
											<span>Job Title</span>
											Sr. Multimedia Designer
										</li>
										<li>
											<span>Industry</span>
											IT Field
										</li>
										<li>
											<span>Email</span>
											harshad2406patoliya@gmail.com
										</li>
										<li>
											<span>Phone Number</span>
											+91 951005589
										</li>
										
										<li>
											<span>Date of Birth</span>
											24 June 1990
										</li>
										<li>
											<span>Gender</span>
											Male
										</li>
										<li>
											<span>Address</span>
											f-204, Viswas city-2, rc tech road,
											ghatlodia,
											ahmedabad
										</li>
										
										
										
										
									</ul>
								</div>
								<div class="about-more">
									<a href="#">View More <img src="<?php echo base_url('assets/n-images/detail/down-arrow.png?ver=' . time()) ?>"></a>
								</div>
								
							</div>
						</div>
						
						<!-- Edution  -->
						<div class="gallery-item ">
							<div class="dtl-box edu-info">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/edution.png?ver=' . time()) ?>"><span>Educational Info</span><a href="#" data-target="#educational-info" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/detail-add.png?ver=' . time()) ?>"></a>
								</div>
								<div class="dtl-dis dis-accor">
									<div class="panel-group" id="edu-accordion" role="tablist" aria-multiselectable="true">
										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="eduOne">
												<div class="panel-title">
													<div class="dis-left">
														<div class="dis-left-img">
															<span>V</span>
														</div>
													</div>
													<div class="dis-middle">
														<h4>Vinay mandir high school</h4>
														<p>Bechalr of engineering</p>
													</div>
													<div class="dis-right">
														<a href="#" data-target="#educational-info" data-toggle="modal" class="pr5"><img src="<?php echo base_url('assets/n-images/detail/detial-edit.png?ver=' . time()) ?>"></a>
														<a role="button" data-toggle="collapse" data-parent="#edu-accordion" href="#edu1" aria-expanded="true" aria-controls="project1">
															<img src="<?php echo base_url('assets/n-images/detail/down-arrow.png?ver=' . time()) ?>">
														</a>
													</div>
                 
												</div>
											</div>
											<div id="edu1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="eduOne">
												<div class="panel-body">
													<ul class="dis-list">
														<li>
															<span>Duration</span>
															Feb 2015 to June 2017
														</li>
														<li>
															<span>Board / University</span>
															Gujrat University
															
														</li>
														<li>
															<span>Course / Field of Study / Stream</span>
															Coputer Science
														</li>
														
														
														<li>
															<span>Degree Certificate</span>
															<p class="screen-shot">
																<img src="n-images/art-img.jpg">
															</p>
														</li>
													</ul>
												</div>
											</div>
										</div>
										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="edutwo">
												<div class="panel-title">
													<div class="dis-left">
														<div class="dis-left-img">
															<span>V</span>
														</div>
													</div>
													<div class="dis-middle">
														<h4>Vivekanand high school</h4>
														<p>Gseb board</p>
													</div>
													<div class="dis-right">
														<a href="#" data-target="#educational-info" data-toggle="modal" class="pr5"><img src="<?php echo base_url('assets/n-images/detail/detial-edit.png?ver=' . time()) ?>"></a>
														<a role="button" data-toggle="collapse" data-parent="#edu-accordion" href="#edu2" aria-expanded="true" aria-controls="project2">
															<img src="<?php echo base_url('assets/n-images/detail/down-arrow.png?ver=' . time()) ?>">
														</a>
													</div>
                 
												</div>
											</div>
											<div id="edu2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="edutwo">
												<div class="panel-body">
													<ul class="dis-list">
														<li>
															<span>Duration</span>
															Feb 2015 to June 2017
														</li>
														<li>
															<span>Board / University</span>
															Gujrat University
															
														</li>
														<li>
															<span>Course / Field of Study / Stream</span>
															Coputer Science
														</li>
														
														
														<li>
															<span>Degree Certificate</span>
															<p class="screen-shot">
																<img src="n-images/art-img.jpg">
															</p>
														</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<!-- Experience  -->
						
						<div class="gallery-item">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/exp.png?ver=' . time()) ?>"><span>Experience (4year 5month)</span><a href="#" data-target="#experience" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/detail-add.png?ver=' . time()) ?>"></a>
								</div>
								<div class="dtl-dis dis-accor">
									<div class="panel-group" id="exp-accordion" role="tablist" aria-multiselectable="true">
										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="expOne">
												<div class="panel-title">
													<div class="dis-left">
														<div class="dis-left-img">
															<span>V</span>
														</div>
													</div>
													<div class="dis-middle">
														<h4>Verv System PVT LTD</h4>
														<p>Working as Sr.multimedia dsigner </p>
														
													</div>
													<div class="dis-right">
														<a href="#" data-target="#experience" data-toggle="modal" class="pr5"><img src="<?php echo base_url('assets/n-images/detail/detial-edit.png?ver=' . time()) ?>"></a>
														<a role="button" data-toggle="collapse" data-parent="#exp-accordion" href="#exp1" aria-expanded="true" aria-controls="exp1">
															<img src="<?php echo base_url('assets/n-images/detail/down-arrow.png?ver=' . time()) ?>">
														</a>
													</div>
                 
												</div>
											</div>
											<div id="exp1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="expOne">
												<div class="panel-body">
													<ul class="dis-list">
														<li>
															<span>Time Period</span>
															Jun 2015 to March 2015
															
														</li>
														<li>
															<span>Company Location</span>
															Ahmedabad, India
															
														</li>
														<li>
															<span>Website</span>
															<a href="#">www.vervsystem.com</a>
														</li>
														<li>
															<span>Description</span>
															Lorem Ipsum is simply dummy text of the printing and typesetting indus try. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it       
															<a class="dis-more" href="#"><b>See More..</b> </a>
														</li>
														<li>
															<span>Document</span>
															<p class="screen-shot">
																<img src="n-images/art-img.jpg">
															</p>
														</li>
													</ul>
												</div>
											</div>
										</div>
										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="exptwo">
												<div class="panel-title">
													<div class="dis-left">
														<div class="dis-left-img">
															<span>V</span>
														</div>
													</div>
													<div class="dis-middle">
														<h4>Verv System PVT LTD</h4>
														<p>Working as Sr.multimedia dsigner </p>
														
													</div>
													<div class="dis-right">
														<a href="#" data-target="#experience" data-toggle="modal" class="pr5"><img src="<?php echo base_url('assets/n-images/detail/detial-edit.png?ver=' . time()) ?>"></a>
														<a role="button" data-toggle="collapse" data-parent="#exp-accordion" href="#exp2" aria-expanded="true" aria-controls="exp2">
															<img src="<?php echo base_url('assets/n-images/detail/down-arrow.png?ver=' . time()) ?>">
														</a>
													</div>
                 
												</div>
											</div>
											<div id="exp2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="exptwo">
												<div class="panel-body">
													<ul class="dis-list">
														<li>
															<span>Time Period</span>
															Jun 2015 to March 2015
															
														</li>
														<li>
															<span>Company Location</span>
															Ahmedabad, India
														</li>
														<li>
															<span>Website</span>
															<a href="#">www.vervsystem.com</a>
														</li>
														<li>
															<span>Description</span>
															Lorem Ipsum is simply dummy text of the printing and typesetting indus try. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it       
															<a class="dis-more" href="#"><b>See More..</b> </a>
														</li>
														<li>
															<span>Document</span>
															<p class="screen-shot">
																<img src="n-images/art-img.jpg">
															</p>
														</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<!-- project  -->
						<div class="gallery-item">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/project.png?ver=' . time()) ?>"><span>Project</span><a href="#" data-target="#dtl-project" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/detail-add.png?ver=' . time()) ?>"></a>
								</div>
								<div class="dtl-dis dis-accor">
									<div class="panel-group" id="project-accordion" role="tablist" aria-multiselectable="true">
										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="projectOne">
												<div class="panel-title">
													<div class="dis-left">
														<div class="dis-left-img">
															<span>A</span>
														</div>
													</div>
													<div class="dis-middle">
														<h4>Aileensoul (project name)</h4>
														<p>IT Field</p>
													</div>
													<div class="dis-right">
														<a href="#" data-target="#dtl-project" data-toggle="modal" class="pr5"><img src="<?php echo base_url('assets/n-images/detail/detial-edit.png?ver=' . time()) ?>"></a>
														<a role="button" data-toggle="collapse" data-parent="#project-accordion" href="#project1" aria-expanded="true" aria-controls="project1">
															<img src="<?php echo base_url('assets/n-images/detail/down-arrow.png?ver=' . time()) ?>">
														</a>
													</div>
                 
												</div>
											</div>
											<div id="project1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="projectOne">
												<div class="panel-body">
													<ul class="dis-list">
														<li>
															<span>Website</span>
															<a href="#">WWW.vervsystem.com</a>
														</li>
														<li>
															<span>Duration</span>
															Feb 2015 to June 2017 (2 year 4 month)
														</li>
														<li>
															<span>Team Size</span>
															15
														</li>
														<li>
															<span>Your Role</span>
															Project Manager
														</li>
														<li>
															<span>Project Partner</span>
															shreenathji production, dhaval & co.
														</li>
														
														<li>
															<span>Skills Applied</span>
															PHP, HTML, CSS, Photo shop.
														</li>
														
														<li>
															<span>Description</span>
															Lorem Ipsum is simply dummy text of the printing and typesetting indus try. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it       
															<a class="dis-more" href="#"><b>See More..</b> </a>
														</li>
														<li>
															<span>Project File</span>
															<p class="screen-shot">
																<img src="n-images/art-img.jpg">
															</p>
														</li>
													</ul>
												</div>
											</div>
										</div>
										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="projecttwo">
												<div class="panel-title">
													<div class="dis-left">
														<div class="dis-left-img">
															<span>H</span>
														</div>
													</div>
													<div class="dis-middle">
														<h4>health jump</h4>
														<p>IT Field</p>
													</div>
													<div class="dis-right">
														<a href="#" data-target="#dtl-project" data-toggle="modal" class="pr5"><img src="<?php echo base_url('assets/n-images/detail/detial-edit.png?ver=' . time()) ?>"></a>
														<a role="button" data-toggle="collapse" data-parent="#project-accordion" href="#project2" aria-expanded="true" aria-controls="project2">
															<img src="<?php echo base_url('assets/n-images/detail/down-arrow.png?ver=' . time()) ?>">
														</a>
													</div>
                 
												</div>
											</div>
											<div id="project2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="projecttwo">
												<div class="panel-body">
													<ul class="dis-list">
														<li>
															<span>Duration</span>
															Feb 2015 to June 2017 (2 year 4 month)
														</li>
														<li>
															<span>Team Size</span>
															15
														</li>
														<li>
															<span>Site link</span>
															<a href="#">WWW.vervsystem.com</a>
														</li>
														<li>
															<span>Project Partner</span>
															shreenathji production, dhaval & co.
														</li>
														<li>
															<span>Your Role</span>
															Project Manager
														</li>
														<li>
															<span>Skills Applied</span>
															PHP, HTML, CSS, Photo shop.
														</li>
														
														<li>
															<span>Description</span>
															Lorem Ipsum is simply dummy text of the printing and typesetting indus try. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it       
															<a class="dis-more" href="#"><b>See More..</b> </a>
														</li>
														<li>
															<span>Screenshot</span>
															<p class="screen-shot">
																<img src="n-images/art-img.jpg">
															</p>
														</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<!-- Preferred job detail  -->
						<div class="gallery-item ">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/edution.png?ver=' . time()) ?>"><span>Preferred Job Details</span><a href="#" data-target="#preferred-job" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/detail-add.png?ver=' . time()) ?>"></a>
								</div>
								<div class="dtl-dis dtl-box-height">
									<ul class="dis-list">
										<li><span>Preferred Job Title</span>
											Sr. Multimedia Designer
										</li>
										<li><span>Perferred Location / Region</span>
											Ahmedabad , Gandhinagar, Rajkot
										</li>
										<li><span>How far are you wiling to travel? (In miles)</span>
											5 miles
										</li>
										<li><span>Preferred Industry</span>
											IT field
										</li>
										<li><span>Expected Salary</span>
											7000 dollar per month
										</li>
										<li><span>Company Culture</span>
											Free Spirit
										</li>
										<li><span>Work Time / Schedule</span>
											Flexible
										</li>
										<li><span>Lorem ipsum</span>
											<p>I am willing to relocate</p>
											<p>I am Actively looking for work</p>
											<p>I am Passively looking for work</p> 
										</li>
										
										<li><span>More Details</span>
											Lorem ipsum is a dummy text its a use for the same. and its working with the same part of the population.
										</li>
										
									</ul>
								</div>
								<div class="about-more">
									<a href="#">View More <img src="<?php echo base_url('assets/n-images/detail/down-arrow.png?ver=' . time()) ?>"></a>
								</div>
							</div>
						</div>
						
						
						<!-- Passion and Interest  -->
						<div class="gallery-item ">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/edution.png?ver=' . time()) ?>"><span>Passion and Interest</span><a href="#" data-target="#passion-intrest" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/detail-add.png?ver=' . time()) ?>"></a>
								</div>
								<div class="dtl-dis">
									<p>Lorem ipsum is a dummy text its a use for the same. and its working with the same part of the population. </p>
								</div>
							</div>
						</div>
						
						<!-- Extracurricular activity  -->
						<div class="gallery-item">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/extra-activity.png?ver=' . time()) ?>"><span>Extracurricular Activity</span><a href="#" data-target="#extra-acticity" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/detail-add.png?ver=' . time()) ?>"></a>
								</div>
								<div class="dtl-dis dis-accor">
									<div class="panel-group" id="acticity-accordion" role="tablist" aria-multiselectable="true">
										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="acticityOne">
												<div class="panel-title">
													<div class="dis-left">
														<div class="dis-left-img">
															<span>U</span>
														</div>
													</div>
													<div class="dis-middle">
														<h4>Umpiring in cricket</h4>
														<p>Gujrat Cricket association</p>
													</div>
													<div class="dis-right">
														<a href="#" data-target="#extra-acticity" data-toggle="modal" class="pr5"><img src="<?php echo base_url('assets/n-images/detail/detial-edit.png?ver=' . time()) ?>"></a>
														<a role="button" data-toggle="collapse" data-parent="#acticity-accordion" href="#acticity1" aria-expanded="true" aria-controls="acticity1">
															<img src="<?php echo base_url('assets/n-images/detail/down-arrow.png?ver=' . time()) ?>">
														</a>
													</div>
                 
												</div>
											</div>
											<div id="acticity1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="acticityOne">
												<div class="panel-body">
													<ul class="dis-list">
														<li>
															<span>Duration</span>
															Feb 2015 to Currently active
														</li>
														
														<li>
															<span>Description</span>
															Lorem Ipsum is simply dummy text of the printing and typesetting indus try. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it       
															<a class="dis-more" href="#"><b>See More..</b> </a>
														</li>
														<li>
															<span>Document</span>
															<p class="screen-shot">
																<img src="n-images/art-img.jpg">
															</p>
														</li>
													</ul>
												</div>
											</div>
										</div>
										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="acticitytwo">
												<div class="panel-title">
													<div class="dis-left">
														<div class="dis-left-img">
															<span>K</span>
														</div>
													</div>
													<div class="dis-middle">
														<h4>Khel maha khumbh</h4>
														<p>Sports outhority of gujarat</p>
													</div>
													<div class="dis-right">
														<a href="#" data-target="#extra-acticity" data-toggle="modal" class="pr5"><img src="<?php echo base_url('assets/n-images/detail/detial-edit.png?ver=' . time()) ?>"></a>
														<a role="button" data-toggle="collapse" data-parent="#acticity-accordion" href="#acticity2" aria-expanded="true" aria-controls="acticity2">
															<img src="<?php echo base_url('assets/n-images/detail/down-arrow.png?ver=' . time()) ?>">
														</a>
													</div>
                 
												</div>
											</div>
											<div id="acticity2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="acticitytwo">
												<div class="panel-body">
													<ul class="dis-list">
														<li>
															<span>Duration</span>
															Feb 2015 to Currently active
														</li>
														
														<li>
															<span>Description</span>
															Lorem Ipsum is simply dummy text of the printing and typesetting indus try. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it       
															<a class="dis-more" href="#"><b>See More..</b> </a>
														</li>
														<li>
															<span>Document</span>
															<p class="screen-shot">
																<img src="n-images/art-img.jpg">
															</p>
														</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<!-- Achievements and Awards  -->
						<div class="gallery-item">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/achi-awards.png?ver=' . time()) ?>"><span>Achievements & Awards</span><a href="#" data-target="#Achiv-awards" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/detail-add.png?ver=' . time()) ?>"></a>
								</div>
								<div class="dtl-dis dis-accor">
									<div class="panel-group" id="awards-accordion" role="tablist" aria-multiselectable="true">
										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="awardsOne">
												<div class="panel-title">
													<div class="dis-left">
														<div class="dis-left-img">
															<span>G</span>
														</div>
													</div>
													<div class="dis-middle">
														<h4>Gujrat yang talant awards</h4>
														<p>Gujrat Sarkar</p>
													</div>
													<div class="dis-right">
														<a href="#" data-target="#Achiv-awards" data-toggle="modal" class="pr5"><img src="<?php echo base_url('assets/n-images/detail/detial-edit.png?ver=' . time()) ?>"></a>
														<a role="button" data-toggle="collapse" data-parent="#awards-accordion" href="#awards1" aria-expanded="true" aria-controls="awards1">
															<img src="<?php echo base_url('assets/n-images/detail/down-arrow.png?ver=' . time()) ?>">
														</a>
													</div>
                 
												</div>
											</div>
											<div id="awards1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="awardsOne">
												<div class="panel-body">
													<ul class="dis-list">
														<li>
															<span>Date</span>
															24 June 2018
														</li>
														
														<li>
															<span>Description</span>
															Lorem Ipsum is simply dummy text of the printing and typesetting indus try. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it       
															<a class="dis-more" href="#"><b>See More..</b> </a>
														</li>
														<li>
															<span>Document</span>
															<p class="screen-shot">
																<img src="n-images/art-img.jpg">
															</p>
														</li>
													</ul>
												</div>
											</div>
										</div>
										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="awardstwo">
												<div class="panel-title">
													<div class="dis-left">
														<div class="dis-left-img">
															<span>B</span>
														</div>
													</div>
													<div class="dis-middle">
														<h4>Best Employe of the year</h4>
														<p>Aileensoul pvt ltd</p>
													</div>
													<div class="dis-right">
														<a href="#" data-target="#Achiv-awards" data-toggle="modal" class="pr5"><img src="<?php echo base_url('assets/n-images/detail/detial-edit.png?ver=' . time()) ?>"></a>
														<a role="button" data-toggle="collapse" data-parent="#awards-accordion" href="#awards2" aria-expanded="true" aria-controls="awards2">
															<img src="<?php echo base_url('assets/n-images/detail/down-arrow.png?ver=' . time()) ?>">
														</a>
													</div>
                 
												</div>
											</div>
											<div id="awards2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="awardstwo">
												<div class="panel-body">
													<ul class="dis-list">
														<li>
															<span>Date</span>
															24 June 2018
														</li>
														
														<li>
															<span>Description</span>
															Lorem Ipsum is simply dummy text of the printing and typesetting indus try. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it       
															<a class="dis-more" href="#"><b>See More..</b> </a>
														</li>
														<li>
															<span>Document</span>
															<p class="screen-shot">
																<img src="n-images/art-img.jpg">
															</p>
														</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<!-- Additional Caurse  -->
						
						<div class="gallery-item">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/add-course.png?ver=' . time()) ?>"><span>Additional Caurse</span><a href="#" data-target="#additional-course" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/detail-add.png?ver=' . time()) ?>"></a>
								</div>
								<div class="dtl-dis dis-accor">
									<div class="panel-group" id="course-accordion" role="tablist" aria-multiselectable="true">
										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="courseOne">
												<div class="panel-title">
													<div class="dis-left">
														<div class="dis-left-img">
															<span>M</span>
														</div>
													</div>
													<div class="dis-middle">
														<h4>Master of performing art</h4>
														<p>Upasna Technology</p>
													</div>
													<div class="dis-right">
														<a href="#" data-target="#additional-course" data-toggle="modal" class="pr5"><img src="<?php echo base_url('assets/n-images/detail/detial-edit.png?ver=' . time()) ?>"></a>
														<a role="button" data-toggle="collapse" data-parent="#course-accordion" href="#course1" aria-expanded="true" aria-controls="course1">
															<img src="<?php echo base_url('assets/n-images/detail/down-arrow.png?ver=' . time()) ?>">
														</a>
													</div>
                 
												</div>
											</div>
											<div id="course1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="courseOne">
												<div class="panel-body">
													<ul class="dis-list">
														<li>
															<span>Duration</span>
															June 2016 to april 2018
														</li>
														<li>
															<span>Website</span>
															<a href="#">WWW.loremipsum.com</a>
														</li>
														
														<li>
															<span>Document</span>
															<p class="screen-shot">
																<img src="n-images/art-img.jpg">
															</p>
														</li>
													</ul>
												</div>
											</div>
										</div>
										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="coursetwo">
												<div class="panel-title">
													<div class="dis-left">
														<div class="dis-left-img">
															<span>I</span>
														</div>
													</div>
													<div class="dis-middle">
														<h4>Indian Air force</h4>
														<p>Air force india</p>
													</div>
													<div class="dis-right">
														<a href="#" data-target="#additional-course" data-toggle="modal" class="pr5"><img src="<?php echo base_url('assets/n-images/detail/detial-edit.png?ver=' . time()) ?>"></a>
														<a role="button" data-toggle="collapse" data-parent="#course-accordion" href="#course2" aria-expanded="true" aria-controls="course2">
															<img src="<?php echo base_url('assets/n-images/detail/down-arrow.png?ver=' . time()) ?>">
														</a>
													</div>
                 
												</div>
											</div>
											<div id="course2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="coursetwo">
												<div class="panel-body">
													<ul class="dis-list">
														<li>
															<span>Duration</span>
															June 2016 to april 2018
														</li>
														<li>
															<span>Website</span>
															<a href="#">WWW.loremipsum.com</a>
														</li>
														
														<li>
															<span>Document</span>
															<p class="screen-shot">
																<img src="n-images/art-img.jpg">
															</p>
														</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						
						
						<!-- Professional summary -->
						<div class="gallery-item ">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/edution.png?ver=' . time()) ?>"><span>Professional Summary</span><a href="#" data-target="#prof-summary" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/detail-add.png?ver=' . time()) ?>"></a>
								</div>
								<div class="dtl-dis">
									<p>Lorem ipsum its a dummy text and its user to for all.Lorem ipsum its a dummy text and its user to for all.Lorem ipsum its a dummy text and its user to for all.Lorem ipsum its a dummy text and its user to for all.</p>
								</div>
							</div>
						</div>
						
						<!-- Research -->
						<div class="gallery-item">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/research.png?ver=' . time()) ?>"><span>Research</span><a href="#" data-target="#research" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/detail-add.png?ver=' . time()) ?>"></a>
								</div>
								<div class="dtl-dis dis-accor">
									<div class="panel-group" id="research-accordion" role="tablist" aria-multiselectable="true">
										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="researchOne">
												<div class="panel-title">
													<div class="dis-left">
														<div class="dis-left-img">
															<span>R</span>
														</div>
													</div>
													<div class="dis-middle">
														<h4>Research Title</h4>
														<p>IT Field</p>
													</div>
													<div class="dis-right">
														<a href="#" data-target="#research" data-toggle="modal" class="pr5"><img src="<?php echo base_url('assets/n-images/detail/detial-edit.png?ver=' . time()) ?>"></a>
														<a role="button" data-toggle="collapse" data-parent="#research-accordion" href="#research1" aria-expanded="true" aria-controls="research1">
															<img src="<?php echo base_url('assets/n-images/detail/down-arrow.png?ver=' . time()) ?>">
														</a>
													</div>
                 
												</div>
											</div>
											<div id="research1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="researchOne">
												<div class="panel-body">
													<ul class="dis-list">
														<li>
															<span>Publishing Date</span>
															11 June 2018
														</li>
														<li>
															<span>Website</span>
															<a href="#">WWW.loremipsum.com</a>
														</li>
														<li>
															<span>Description</span>
															Lorem Ipsum is simply dummy text of the printing and typesetting indus try. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it       
															<a class="dis-more" href="#"><b>See More..</b> </a>
														</li>
														<li>
															<span>Document</span>
															<p class="screen-shot">
																<img src="n-images/art-img.jpg">
															</p>
														</li>
													</ul>
												</div>
											</div>
										</div>
										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="researchtwo">
												<div class="panel-title">
													<div class="dis-left">
														<div class="dis-left-img">
															<span>R</span>
														</div>
													</div>
													<div class="dis-middle">
														<h4>Research Title</h4>
														<p>IT Field</p>
													</div>
													<div class="dis-right">
														<a href="#" data-target="#research" data-toggle="modal" class="pr5"><img src="<?php echo base_url('assets/n-images/detail/detial-edit.png?ver=' . time()) ?>"></a>
														<a role="button" data-toggle="collapse" data-parent="#research-accordion" href="#research2" aria-expanded="true" aria-controls="research2">
															<img src="<?php echo base_url('assets/n-images/detail/down-arrow.png?ver=' . time()) ?>">
														</a>
													</div>
                 
												</div>
											</div>
											<div id="research2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="researchtwo">
												<div class="panel-body">
													<ul class="dis-list">
														<li>
															<span>Publishing Date</span>
															11 June 2018
														</li>
														<li>
															<span>Website</span>
															<a href="#">WWW.loremipsum.com</a>
														</li>
														<li>
															<span>Description</span>
															Lorem Ipsum is simply dummy text of the printing and typesetting indus try. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it       
															<a class="dis-more" href="#"><b>See More..</b> </a>
														</li>
														<li>
															<span>Document</span>
															<p class="screen-shot">
																<img src="n-images/art-img.jpg">
															</p>
														</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<!-- Patent -->
						<div class="gallery-item">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/patent.png?ver=' . time()) ?>"><span>Patent</span><a href="#" data-target="#patent" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/detail-add.png?ver=' . time()) ?>"></a>
								</div>
								<div class="dtl-dis dis-accor">
									<div class="panel-group" id="patent-accordion" role="tablist" aria-multiselectable="true">
										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="patentOne">
												<div class="panel-title">
													<div class="dis-left">
														<div class="dis-left-img">
															<span>P</span>
														</div>
													</div>
													<div class="dis-middle">
														<h4>Patent Name</h4>
														<p>Harshad Patoliya</p>
														
													</div>
													<div class="dis-right">
														<a href="#" data-target="#patent" data-toggle="modal" class="pr5"><img src="<?php echo base_url('assets/n-images/detail/detial-edit.png?ver=' . time()) ?>"></a>
														<a role="button" data-toggle="collapse" data-parent="#patent-accordion" href="#patent1" aria-expanded="true" aria-controls="patent1">
															<img src="<?php echo base_url('assets/n-images/detail/down-arrow.png?ver=' . time()) ?>">
														</a>
													</div>
                 
												</div>
											</div>
											<div id="patent1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="patentOne">
												<div class="panel-body">
													<ul class="dis-list">
														<li>
															<span>Patent Number</span>
															123456
														</li>
														<li>
															<span>Patent Status</span>
															Status
														</li>
														<li>
															<span>Patent Date</span>
															15 July 2018
														</li>
														<li>
															<span>Patent Office</span>
															Ahmedabad
														</li>
														
														<li>
															<span>Patent link</span>
															<a href="#">WWW.Loremipsum.com</a>
														</li>
														<li>
															<span>Description</span>
															Lorem Ipsum is simply dummy text of the printing and typesetting indus try. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it       
															<a class="dis-more" href="#"><b>See More..</b> </a>
														</li>
														<li>
															<span>Document</span>
															<p class="screen-shot">
																<img src="n-images/art-img.jpg">
															</p>
														</li>
													</ul>
												</div>
											</div>
										</div>
										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="patenttwo">
												<div class="panel-title">
													<div class="dis-left">
														<div class="dis-left-img">
															<span>P</span>
														</div>
													</div>
													<div class="dis-middle">
														<h4>Patent Name</h4>
														<p>Harshad Patoliya</p>
														
													</div>
													<div class="dis-right">
														<a href="#" data-target="#patent" data-toggle="modal" class="pr5"><img src="<?php echo base_url('assets/n-images/detail/detial-edit.png?ver=' . time()) ?>"></a>
														<a role="button" data-toggle="collapse" data-parent="#patent-accordion" href="#patent2" aria-expanded="true" aria-controls="patent2">
															<img src="<?php echo base_url('assets/n-images/detail/down-arrow.png?ver=' . time()) ?>">
														</a>
													</div>
                 
												</div>
											</div>
											<div id="patent2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="patenttwo">
												<div class="panel-body">
													<ul class="dis-list">
														<li>
															<span>Patent Number</span>
															123456
														</li>
														<li>
															<span>Patent Status</span>
															Status
														</li>
														<li>
															<span>Patent Date</span>
															15 July 2018
														</li>
														<li>
															<span>Patent Office</span>
															Ahmedabad
														</li>
														
														<li>
															<span>Patent link</span>
															<a href="#">WWW.Loremipsum.com</a>
														</li>
														<li>
															<span>Description</span>
															Lorem Ipsum is simply dummy text of the printing and typesetting indus try. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it       
															<a class="dis-more" href="#"><b>See More..</b> </a>
														</li>
														<li>
															<span>Document</span>
															<p class="screen-shot">
																<img src="n-images/art-img.jpg">
															</p>
														</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<!-- Publication -->
						<div class="gallery-item">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/publication.png?ver=' . time()) ?>"><span>Publication</span><a href="#" data-target="#publication" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/detail-add.png?ver=' . time()) ?>"></a>
								</div>
								<div class="dtl-dis dis-accor">
									<div class="panel-group" id="publication-accordion" role="tablist" aria-multiselectable="true">
										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="publicationOne">
												<div class="panel-title">
													<div class="dis-left">
														<div class="dis-left-img">
															<span>F</span>
														</div>
													</div>
													<div class="dis-middle">
														<h4>How to learn easy maths</h4>
														<p>Harshad Patoliya</p>
													</div>
													<div class="dis-right">
														<a href="#" data-target="#publication" data-toggle="modal" class="pr5"><img src="<?php echo base_url('assets/n-images/detail/detial-edit.png?ver=' . time()) ?>"></a>
														<a role="button" data-toggle="collapse" data-parent="#publication-accordion" href="#publication1" aria-expanded="true" aria-controls="publication1">
															<img src="<?php echo base_url('assets/n-images/detail/down-arrow.png?ver=' . time()) ?>">
														</a>
													</div>
                 
												</div>
											</div>
											<div id="publication1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="publicationOne">
												<div class="panel-body">
													<ul class="dis-list">
														<li>
															<span>Published Date</span>
															12 june 2016
														</li>
														<li>
															<span>Publisher / Publication</span>
															Bhavik Publication
														</li>
														<li>
															<span>Website</span>
															<a href="#">WWW.Loremipsum.com</a>
														</li>
														<li>
															<span>Description</span>
															Lorem Ipsum is simply dummy text of the printing and typesetting indus try. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it       
															<a class="dis-more" href="#"><b>See More..</b> </a>
														</li>
														<li>
															<span>Document</span>
															<p class="screen-shot">
																<img src="n-images/art-img.jpg">
															</p>
														</li>
													</ul>
												</div>
											</div>
										</div>
										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="publicationtwo">
												<div class="panel-title">
													<div class="dis-left">
														<div class="dis-left-img">
															<span>H</span>
														</div>
													</div>
													<div class="dis-middle">
														<h4>Hard Work</h4>
														<p>Harshad Patoliya</p>
													</div>
													<div class="dis-right">
														<a href="#" data-target="#publication" data-toggle="modal" class="pr5"><img src="<?php echo base_url('assets/n-images/detail/detial-edit.png?ver=' . time()) ?>"></a>
														<a role="button" data-toggle="collapse" data-parent="#publication-accordion" href="#publication2" aria-expanded="true" aria-controls="publication2">
															<img src="<?php echo base_url('assets/n-images/detail/down-arrow.png?ver=' . time()) ?>">
														</a>
													</div>
                 
												</div>
											</div>
											<div id="publication2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="publicationtwo">
												<div class="panel-body">
													<ul class="dis-list">
														<li>
															<span>Published Date</span>
															11 June 2018
														</li>
														<li>
															<span>Publisher / Publication</span>
															Bhavik Publication
														</li>
														<li>
															<span>Website</span>
															<a href="#">WWW.Loremipsum.com</a>
														</li>
														<li>
															<span>Description</span>
															Lorem Ipsum is simply dummy text of the printing and typesetting indus try. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it       
															<a class="dis-more" href="#"><b>See More..</b> </a>
														</li>
														<li>
															<span>Document</span>
															<p class="screen-shot">
																<img src="n-images/art-img.jpg">
															</p>
														</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<!-- Software  -->
						<div class="gallery-item ">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/edution.png?ver=' . time()) ?>"><span>Software</span><a href="#" data-target="#software" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/detail-add.png?ver=' . time()) ?>"></a>
								</div>
								<div class="dtl-dis">
									<ul class="skill-list">
										<li>Photoshop</li>
										<li>Coraldrow</li>
										<li>Dreamviewer</li>
										<li>Notepad ++</li>
									</ul>
								</div>
							</div>
						</div>
						
						
					</div>
				</div>
				<div class="right-add">
				
					
					<div class="row">
					<div class="dtl-box p10 dtl-adv">
						<img src="<?php echo base_url('assets/n-images/detail/add.png?ver=' . time()) ?>">
					</div>
					<div class="rsp-dtl-box">
						<div class="dtl-box">
							<div class="dtl-title">
								<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/e-profile.png?ver=' . time()) ?>"><span>Edit Profile</span>
							</div>
							<div class="dtl-dis dtl-edit-p">
								<img src="<?php echo base_url('assets/n-images/detail/profile-progressbar.jpg?ver=' . time()) ?>">
								
							</div>
						</div>
					</div>
					
					<!-- skills  -->
					<div class="rsp-dtl-box">
						<div class="dtl-box">
							<div class="dtl-title">
								<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/skill.png?ver=' . time()) ?>"><span>Skills</span><a href="#" data-target="#skills" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
							</div>
							<div class="dtl-dis">
								<ul class="skill-list">
									<li>HTML</li>
									<li>CSS</li>
									<li>Photoshop</li>
									<li>Html 5</li>
									<li>Css 3</li>
									<li>Less Css</li>
								</ul>
							</div>
						</div>
					</div>
					
					<!-- Social Link  -->
					<div class="rsp-dtl-box">
					
						<div class="dtl-box">
							<div class="dtl-title">
								<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/website.png?ver=' . time()) ?>"><span>Website</span><a href="#" data-target="#social-link" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
							</div>
							<div class="dtl-dis">
								<h4>Social</h4>
								<ul class="social-link-list">
									<li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/fb.png?ver=' . time()) ?>"></a></li>
									<li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/in.png?ver=' . time()) ?>"></a></li>
									<li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/pin.png?ver=' . time()) ?>"></a></li>
									<li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/insta.png?ver=' . time()) ?>"></a></li>
									<li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/you.png?ver=' . time()) ?>"></a></li>
									<li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/git.png?ver=' . time()) ?>"></a></li>
									<li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/twt.png?ver=' . time()) ?>"></a></li>
								</ul>
								<h4 class="pt20 fw">Personal</h4>
								<ul class="social-link-list">
									<li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/pr-web.png?ver=' . time()) ?>"></a></li>
									<li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/pr-web.png?ver=' . time()) ?>"></a></li>
								</ul>
							</div>
						</div>
					</div>
					
					<!-- language  -->
						<div class="rsp-dtl-box ">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/edution.png?ver=' . time()) ?>"><span>Language</span><a href="#" data-target="#language" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/detail-add.png?ver=' . time()) ?>"></a>
								</div>
								<div class="dtl-dis">
									<ul class="known-language">
										<li><span class="pr5">Hindi</span> - <span class="pl5">Basic</span></li>
										<li><span class="pr5">English</span> - <span class="pl5">Intermediate</span></li>
										<li><span class="pr5">Gujrati</span> - <span class="pl5">Expert</span></li>
									</ul>
								</div>
							</div>
						</div>
					
					</div>
					
					<!-- resume  -->
						<div class="rsp-dtl-box ">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/edution.png?ver=' . time()) ?>"><span>Resume</span><a href="#" data-target="#resume" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/detail-add.png?ver=' . time()) ?>"></a>
								</div>
								<div class="dtl-dis resume-img">
									<a href="#"><img src="<?php echo base_url('assets/n-images/detail/documents.png?ver=' . time()) ?>"></a>
								</div>
							</div>
						</div>
					
					<!-- Hobbies  -->
						<div class="rsp-dtl-box ">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/edution.png?ver=' . time()) ?>"><span>Hobbies</span><a href="#" data-target="#hobbies" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/detail-add.png?ver=' . time()) ?>"></a>
								</div>
								<div class="dtl-dis">
									<ul class="skill-list">
										<li>Cricket</li>
										<li>Hockey</li>
										<li>Football</li>
										<li>Basketball</li>
										<li>Tenish</li>
									</ul>
								</div>
							</div>
						</div>
					
				</div>
			</div>
		</div>
				</div>
               
				<div class="clearfix"></div>
			</div>
        </section>
		
		
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
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>First Name</label>
									<input type="text" placeholder="First Name">
								</div>
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Last Name</label>
									<input type="text" placeholder="Last Name">
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Email </label>
									<input type="text" placeholder="Email">
								</div>
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Phone Number</label>
									<input type="text" placeholder="Phone Number">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label>Job Title</label>
							<input type="text" placeholder="Job Title">
						</div>
						
						<div class="row">
							
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Industry </label>
									<span class="span-select">
										<select>
											<option>Industry</option>
											<option>IT field</option>
											<option>Other</option>
										</select>
									</span>
								</div>
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Gender </label>
									<span class="span-select">
										<select>
											<option>Male</option>
											<option>Female</option>
											<option>Other</option>
										</select>
									</span>
								</div>
							</div>
						</div>
						<div class="form-group dtl-dob">
							<label>Date of Birth</label>
							<div class="row">
								<div class="col-md-4 col-sm-4 col-xs-4">
									<span class="span-select">
										<select>
											<option>Day</option>
											<option>1</option>
											<option>2</option>
											<option>3</option>
										</select>
									</span>
								</div>
								<div class="col-md-4 col-sm-4 col-xs-4">
									<span class="span-select">
										<select>
											<option>Month</option>
											<option>1</option>
											<option>2</option>
											<option>3</option>
										</select>
									</span>
								</div>
								<div class="col-md-4 col-sm-4 col-xs-4">
									<span class="span-select">
										<select>
											<option>Year</option>
											<option>2015</option>
											<option>2016</option>
											<option>2017</option>
										</select>
									</span>
								</div>
							</div>
						</div>
						<div class="form-group dtl-dob">
							<label>Address / Location</label>
							<div class="row">
								<div class="col-md-4 col-sm-4 col-xs-4">
									<span class="span-select">
										<select>
											<option>Country</option>
											<option>America</option>
											<option>India</option>
											<option>Japan</option>
										</select>
									</span>
								</div>
								<div class="col-md-4 col-sm-4 col-xs-4">
									<span class="span-select">
										<select>
											<option>State</option>
											<option>Gujrat</option>
											<option>Delhi</option>
											<option>Rajsthaan</option>
										</select>
									</span>
								</div>
								<div class="col-md-4 col-sm-4 col-xs-4">
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
						<div class="form-group">
							<label></label>
							<input type="text" placeholder="Address / Location">
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
						<span>Experience</span>
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
									<label>Designation / Role</label>
									<input type="text" placeholder="Enter Designation">
								</div>
							</div>
						</div>
						<div class="row">
									<div class="col-md-6 col-sm-6">
										<div class="form-group">
											<label>Company Website</label>
											<input type="text" placeholder="Enter Company Website">
										</div>
									</div>
									<div class="col-md-6 col-sm-6">
										<div class="form-group">
											<label>Field </label>
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
					
						<div class="form-group">
							<label>Company Location</label>
							<input type="text" placeholder="Enter Company Location">
						</div>
						
						<div class="row">
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Start Date</label>
									<div class="row">
										<div class="col-md-6 col-sm-6 col-xs-6">
											<span class="span-select">
												<select>
													<option>Year</option>
													<option>2012</option>
													<option>2013</option>
													<option>2014</option>
													<option>2015</option>
												</select>
											</span>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-6">
											<span class="span-select">
												<select>
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
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>End Date</label>
									<div class="row">
										<div class="col-md-6 col-sm-6 col-xs-6">
											<span class="span-select">
												<select>
													<option>Year</option>
													<option>2012</option>
													<option>2013</option>
													<option>2014</option>
													<option>2015</option>
												</select>
											</span>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-6">
											<span class="span-select">
												<select>
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
							</div>
						</div>
						<div class="form-group">
							<label class="control control--checkbox">
								<input type="checkbox">I currently work here.
								<div class="control__indicator">
								</div>
							</label>
						</div>
						<div class="form-group">
							<label>Description/Roles and Responsibilities</label>
							<textarea row="4" type="text" placeholder="Description">
							</textarea>
						</div>
						<div class="form-group">
							<label class="upload-file">
								Upload File (work experience certificate) <input type="file">
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
	
	<!---  model Educational   -->
	<div style="display:none;" class="modal fade dtl-modal" id="educational-info" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Educational Info</span>
					</div>
					<div class="dtl-dis">
						<div class="form-group">
							<label>School / College Name</label>
							<input type="text" placeholder="School / College Name">
						</div>
						<div class="form-group">
							<label>Board / University</label>
							<input type="text" placeholder="Board / University">
						</div>
						<div class="row">
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Degree / Qualification </label>
									<input type="text" placeholder="Degree / Qualification ">	
								</div>
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Course / Field of Study / Stream </label>
									<input type="text" placeholder="Course / Field of Study / Stream">
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Start Date</label>
									<div class="row">
										<div class="col-md-6 col-sm-6 col-xs-6">
											<span class="span-select">
												<select>
													<option>Year</option>
													<option>2012</option>
													<option>2013</option>
													<option>2014</option>
													<option>2015</option>
												</select>
											</span>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-6">
											<span class="span-select">
												<select>
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
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>End Date</label>
									<div class="row">
										<div class="col-md-6 col-sm-6 col-xs-6">
											<span class="span-select">
												<select>
													<option>Year</option>
													<option>2012</option>
													<option>2013</option>
													<option>2014</option>
													<option>2015</option>
												</select>
											</span>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-6">
											<span class="span-select">
												<select>
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
							</div>
						</div>
						
						<div class="form-group">
							<label class="control control--checkbox">
								<input type="checkbox">If You are not graduate click here.
								<div class="control__indicator"></div>
							</label>
						</div>
						<div class="form-group">
							<label class="upload-file">
								Upload File (Educational Certificate)<input type="file">
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
	

	<!---  model Preferred Job Details  -->
	<div style="display:none;" class="modal fade dtl-modal" id="preferred-job" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Preferred Job Details</span>
					</div>
					<div class="dtl-dis">
						<div class="form-group">
							<label>Preferred Job Title</label>
							<input type="text" placeholder="Preferred Job Title">
						</div>
						<div class="form-group">
							<label>Perferred Location / Region</label>
							<input type="text" placeholder="Perferred Location / Region">	
						</div>
						
						
						<div class="row">
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Preferred Industry</label>
									<span class="span-select">
										<select>
											<option>Project Field</option>
											<option>It Field</option>
											<option>Design</option>
											<option>Advertizing</option>
										</select>
									</span>	
								</div>
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>How far are you wiling to travel?</label>
									<input type="text" placeholder="How far are you wiling to travel?">	
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 col-sm-6 col-xs-6">
								<div class="form-group">
									<label>Company Culture</label>
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
							<div class="col-md-6 col-sm-6 col-xs-6">
								<div class="form-group">
									<label>Work Time / Schedule</label>
									<span class="span-select">
										<select>
											<option>Day</option>
											<option>Night</option>
											<option>Flexible</option>
											
										</select>
									</span>	
								</div>
							</div>
						</div>
						<div class="form-group dtl-dob">
							<label>Expected Salary</label>
							<div class="row">
								<div class="col-md-4 col-sm-4 col-xs-4">
									<input type="text" placeholder="Amount">
								</div>
								<div class="col-md-4 col-sm-4 col-xs-4">
									<span class="span-select">
										<select>
											<option>Currency</option>
											<option>Rs</option>
											<option>Dollar</option>
											<option>Pound</option>
										</select>
									</span>
								</div>
								
								<div class="col-md-4 col-sm-4 col-xs-4">
									<span class="span-select">
										<select>
											<option>Per hour</option>
											<option>Monthly</option>
											<option>Yearly</option>
										</select>
									</span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div>
								<label class="control control--checkbox">
									<input type="checkbox">I am willing to relocate
									<div class="control__indicator">
									</div>
								</label>
							</div>
							<div>
								<label class="control control--checkbox">
									<input type="checkbox">I am Actively looking for work
									<div class="control__indicator">
									</div>
								</label>
							</div>
							<div>
								<label class="control control--checkbox">
									<input type="checkbox">I am Passively looking for work
									<div class="control__indicator">
									</div>
								</label>
							</div>
						</div>
						
						
						<div class="form-group">
							<label>More Details</label>
							<textarea type="text" placeholder="Description">
							</textarea>
						</div>
						
						
					</div>
					<div class="dtl-btn">
							<a href="#" class="save"><span>Save</span></a>
						</div>
				</div>	


            </div>
        </div>
    </div>
	
	<!-- Resume  -->
	<div style="display:none;" class="modal fade dtl-modal" id="resume" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Resume</span>
					</div>
					<div class="dtl-dis">
						<div class="form-group">
							<label class="upload-file">
								Upload File <input type="file">
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
	
	<!-- hobbies  -->
	<div style="display:none;" class="modal fade dtl-modal" id="hobbies" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Hobbies</span>
					</div>
					<div class="dtl-dis">
						<div class="form-group">
							
							<input type="text" placeholder="hobbies">
						</div>
				
					</div>
					<div class="dtl-btn bottom-btn">
						<a href="#" class="save"><span>Save</span></a>
					</div>
				</div>	


            </div>
        </div>
    </div>
	
	<!-- Passion and Interest  -->
	<div style="display:none;" class="modal fade dtl-modal" id="passion-intrest" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Passion and Interest</span>
					</div>
					<div class="dtl-dis">
						<div class="form-group">
							
							<textarea type="text" placeholder="Passion and Intrest"></textarea>
						</div>
				
					</div>
					<div class="dtl-btn bottom-btn">
							<a href="#" class="save"><span>Save</span></a>
						</div>
				</div>	


            </div>
        </div>
    </div>
	
	<!-- Language  -->
	<div style="display:none;" class="modal fade dtl-modal" id="language" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Language</span>
					</div>
					<div class="dtl-dis">
						<div class="fw pb20">
							
							<div class="row">
								<div class="">
									<div class="width-45">
										<div class="form-group">
											<label>Language</label>
											<input placeholder="language" type="text">
										</div>
									</div>
									<div class="width-45">
										<div class="form-group">
											<label>Proficiency</label>
											<span class="span-select">
												<select>
													<option>Basic</option>
													<option>Intermediate</option>
													<option>Expert</option>
												</select>
											</span>
										</div>
									</div>
									<div class="width-10">
										<label></label>
										<a href="#" class="pull-right"><img class="dlt-img" src="<?php echo base_url('assets/n-images/detail/dtl-delet.png?ver=' . time()) ?>"></a>
										
									</div>
									<div class="fw dtl-more-add">
										<a href="#"><span class="pr10">Add More languages </span><img src="<?php echo base_url('assets/n-images/detail/inr-add.png?ver=' . time()) ?>"></a>
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
	
	<!-- Professional Summary  -->
	<div style="display:none;" class="modal fade dtl-modal" id="prof-summary" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Professional Summary</span>
					</div>
					<div class="dtl-dis">
						<div class="form-group">
							
							<textarea type="text" placeholder="Professional Summary"></textarea>
						</div>
				
					</div>
					<div class="dtl-btn bottom-btn">
							<a href="#" class="save"><span>Save</span></a>
						</div>
				</div>	


            </div>
        </div>
    </div>
	
	<!-- Software  -->
	<div style="display:none;" class="modal fade dtl-modal" id="software" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Software</span>
					</div>
					<div class="dtl-dis">
						<div class="form-group">
							
							<input type="text" placeholder="Professional Summary">
						</div>
				
					</div>
					<div class="dtl-btn bottom-btn">
							<a href="#" class="save"><span>Save</span></a>
						</div>
				</div>	


            </div>
        </div>
    </div>
	
	
	
	<!---  model Projects  -->
	<div style="display:none;" class="modal fade dtl-modal" id="dtl-project" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Projects</span>
					</div>
					<div class="dtl-dis">
						<div class="row">
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Project Name / Title</label>
									<input type="text" placeholder="Project Name / Title">
								</div>
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Team Size</label>
									<input type="text" placeholder="Enter Company Location">	
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Role</label>
									<input type="text" placeholder="Role">	
								</div>
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Skills Applied</label>
									<input type="text" placeholder="Skills Applied">	
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Project Field </label>
									<span class="span-select">
										<select>
											<option>Project Field</option>
											<option>It Field</option>
											<option>Design</option>
											<option>Advertizing</option>
										</select>
									</span>	
								</div>
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Project URL</label>
									<input type="text" placeholder="Project URL">	
								</div>
							</div>
						</div>
				
						<div class="form-group">
							<label>Tag Project Partner</label>
							<input type="text" placeholder="Tag Project Partner">
						</div>
						<div class="row">
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Start Date</label>
									<div class="row">
										<div class="col-md-6 col-sm-6 col-xs-6">
											<span class="span-select">
												<select>
													<option>Year</option>
													<option>2012</option>
													<option>2013</option>
													<option>2014</option>
													<option>2015</option>
												</select>
											</span>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-6">
											<span class="span-select">
												<select>
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
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>End Date</label>
									<div class="row">
										<div class="col-md-6 col-sm-6 col-xs-6">
											<span class="span-select">
												<select>
													<option>Year</option>
													<option>2012</option>
													<option>2013</option>
													<option>2014</option>
													<option>2015</option>
												</select>
											</span>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-6">
											<span class="span-select">
												<select>
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
							</div>
						</div>
						<div class="form-group">
							<label>Project Details / Description</label>
							<textarea type="text" placeholder="Description">
							</textarea>
						</div>
						<div class="form-group">
							<label class="upload-file">
								Upload File (Project certificate) <input type="file">
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
	
	
	<!---  model Additional Course  -->
	<div style="display:none;" class="modal fade dtl-modal" id="additional-course" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Additional Course</span>
					</div>
					<div class="dtl-dis">
						<div class="form-group">
							<label>Course Name</label>
							<input type="text" placeholder="Course Name">
						</div>
						<div class="form-group">
							<label>Organization</label>
							<input type="text" placeholder="Organization">
						</div>
						<div class="row">
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Start Date</label>
									<div class="row">
										<div class="col-md-6 col-sm-6 col-xs-6">
											<span class="span-select">
												<select>
													<option>Year</option>
													<option>2012</option>
													<option>2013</option>
													<option>2014</option>
													<option>2015</option>
												</select>
											</span>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-6">
											<span class="span-select">
												<select>
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
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>End Date</label>
									<div class="row">
										<div class="col-md-6 col-sm-6 col-xs-6">
											<span class="span-select">
												<select>
													<option>Year</option>
													<option>2012</option>
													<option>2013</option>
													<option>2014</option>
													<option>2015</option>
												</select>
											</span>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-6">
											<span class="span-select">
												<select>
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
							</div>
						</div>
						<div class="form-group">
							<label>URL</label>
							<input type="text" placeholder="Enter URL">
						</div>
						
						<div class="form-group">
							<label class="upload-file">
								Upload File (Additional Course Certificate) <input type="file">
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
	
	<!---  model Extracurricular Activity  -->
	<div style="display:none;" class="modal fade dtl-modal" id="extra-acticity" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Extracurricular Activity</span>
					</div>
					<div class="dtl-dis">
						<div class="form-group">
							<label>Participated In</label>
							<input type="text" placeholder="Participated In">
						</div>
						<div class="form-group">
							<label>Organization</label>
							<input type="text" placeholder="Organization">
						</div>
						<div class="row">
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Start Date</label>
									<div class="row">
										<div class="col-md-6 col-sm-6 col-xs-6">
											<span class="span-select">
												<select>
													<option>Year</option>
													<option>2012</option>
													<option>2013</option>
													<option>2014</option>
													<option>2015</option>
												</select>
											</span>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-6">
											<span class="span-select">
												<select>
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
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>End Date</label>
									<div class="row">
										<div class="col-md-6 col-sm-6 col-xs-6">
											<span class="span-select">
												<select>
													<option>Year</option>
													<option>2012</option>
													<option>2013</option>
													<option>2014</option>
													<option>2015</option>
												</select>
											</span>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-6">
											<span class="span-select">
												<select>
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
							</div>
						</div>
						<div class="form-group">
							<label>Description</label>
							<textarea type="text" placeholder="Description"></textarea>
						</div>
						
						<div class="form-group">
							<label class="upload-file">
								Upload File (Extracurricular Activity Certificate) <input type="file">
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
	
	<!---  model Achievements & Awards  -->
	<div style="display:none;" class="modal fade dtl-modal" id="Achiv-awards" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Achievements & Awards</span>
					</div>
					<div class="dtl-dis">
						<div class="form-group">
							<label>Title</label>
							<input type="text" placeholder="Title">
						</div>
						<div class="form-group">
							<label>Organization</label>
							<input type="text" placeholder="Organization">
						</div>
						<div class="row">
							<label class="col-md-12 fw">Awards Date</label>
							<div class="col-md-4 col-sm-4 col-xs-4">
								<div class="form-group">
									<span class="span-select">
										<select>
											<option>Date</option>
											<option>1</option>
											<option>2</option>
											<option>3</option>
											<option>4</option>
										</select>
									</span>
								</div>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-4">
								<div class="form-group">
									<span class="span-select">
										<select>
											<option>Month</option>
											<option>januari</option>
											<option>Fabruari</option>
											<option>March</option>
											<option>April</option>
										</select>
									</span>
								</div>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-4">
								<div class="form-group">
									<span class="span-select">
										<select>
											<option>2016</option>
											<option>2017</option>
											<option>2018</option>
											<option>2019</option>
											<option>2020</option>
										</select>
									</span>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label>Description</label>
							<textarea type="text" placeholder="Description"></textarea>
						</div>
						
						<div class="form-group">
							<label class="upload-file">
								Upload File (Achievements & Awards Certificate) <input type="file">
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
	
	<!---  model Publication  -->
	<div style="display:none;" class="modal fade dtl-modal" id="publication" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Publication</span>
					</div>
					<div class="dtl-dis">
						<div class="form-group">
							<label>Title</label>
							<input type="text" placeholder="Title">
						</div>
						<div class="row">
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Author</label>
									<input type="text" placeholder="Author">	
								</div>
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>URL</label>
									<input type="text" placeholder="URL">	
								</div>
							</div>
						</div>
						<div class="form-group">
							<label>Publisher / Publication</label>
							<input type="text" placeholder="Publisher / Publication">
						</div>
						<div class="row">
							<label class="col-md-12 fw">Published Date</label>
							<div class="col-md-4 col-sm-4 col-xs-4">
								<div class="form-group">
									<span class="span-select">
										<select>
											<option>Date</option>
											<option>1</option>
											<option>2</option>
											<option>3</option>
											<option>4</option>
										</select>
									</span>
								</div>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-4">
								<div class="form-group">
									<span class="span-select">
										<select>
											<option>Month</option>
											<option>januari</option>
											<option>Fabruari</option>
											<option>March</option>
											<option>April</option>
										</select>
									</span>
								</div>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-4">
								<div class="form-group">
									<span class="span-select">
										<select>
											<option>2016</option>
											<option>2017</option>
											<option>2018</option>
											<option>2019</option>
											<option>2020</option>
										</select>
									</span>
								</div>
							</div>
						</div>
						
						
						
						<div class="form-group">
							<label>Description</label>
							<textarea type="text" placeholder="Description"></textarea>
						</div>
						
						<div class="form-group">
							<label class="upload-file">
								Upload File (Publication Certificate) <input type="file">
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
	
	<!---  model Patent  -->
	<div style="display:none;" class="modal fade dtl-modal" id="patent" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Patent</span>
					</div>
					<div class="dtl-dis">
						<div class="row">
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Patent Title</label>
									<input type="text" placeholder="Patent Title">	
								</div>
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Patent Number</label>
									<input type="text" placeholder="Patent Number">	
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Patent Creator / Innovator</label>
									<input type="text" placeholder="Patent Creator / Innovator">	
								</div>
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Patent Status</label>
									<input type="text" placeholder="Patent Status">
								</div>
							</div>
						</div>
						<div class="row">
							<label class="col-md-12 fw">Patent Date</label>
							<div class="col-md-4 col-sm-4 col-xs-4">
								<div class="form-group">
									<span class="span-select">
										<select>
											<option>Date</option>
											<option>1</option>
											<option>2</option>
											<option>3</option>
											<option>4</option>
										</select>
									</span>
								</div>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-4">
								<div class="form-group">
									<span class="span-select">
										<select>
											<option>Month</option>
											<option>januari</option>
											<option>Fabruari</option>
											<option>March</option>
											<option>April</option>
										</select>
									</span>
								</div>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-4">
								<div class="form-group">
									<span class="span-select">
										<select>
											<option>2016</option>
											<option>2017</option>
											<option>2018</option>
											<option>2019</option>
											<option>2020</option>
										</select>
									</span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Patent Office</label>
									<input type="text" placeholder="Patent Office">	
								</div>
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Patent URL</label>
									<input type="text" placeholder="Patent URL">	
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label>Description</label>
							<textarea type="text" placeholder="Description"></textarea>
						</div>
						<div class="form-group">
							<label class="upload-file">
								Upload File <input type="file">
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
	
	<!---  model Research  -->
	<div style="display:none;" class="modal fade dtl-modal" id="research" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Research</span>
					</div>
					<div class="dtl-dis">
						<div class="form-group">
							<label>Title</label>
							<input type="text" placeholder="Title">
						</div>
						<div class="row">
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>Field</label>
									<span class="span-select">
										<select>
											<option>Select Field</option>
											<option>IT Field</option>
											<option>IT Field 2</option>
											<option>IT Field 3</option>
											<option>IT Field 4</option>
										</select>
									</span>	
								</div>
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label>URL</label>
									<input type="text" placeholder="URL">	
								</div>
							</div>
						</div>
						<div class="form-group">
							<label>Details</label>
							<textarea type="text" placeholder="Details"></textarea>
						</div>
						<div class="row">
							<label class="col-md-12 fw">Publishing Date</label>
							<div class="col-md-4 col-sm-4 col-xs-4">
								<div class="form-group">
									<span class="span-select">
										<select>
											<option>Date</option>
											<option>1</option>
											<option>2</option>
											<option>3</option>
											<option>4</option>
										</select>
									</span>
								</div>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-4">
								<div class="form-group">
									<span class="span-select">
										<select>
											<option>Month</option>
											<option>januari</option>
											<option>Fabruari</option>
											<option>March</option>
											<option>April</option>
										</select>
									</span>
								</div>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-4">
								<div class="form-group">
									<span class="span-select">
										<select>
											<option>2016</option>
											<option>2017</option>
											<option>2018</option>
											<option>2019</option>
											<option>2020</option>
										</select>
									</span>
								</div>
							</div>
						</div>
						
						
						
						
						<div class="form-group">
							<label class="upload-file">
								Upload File <input type="file">
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
	
	<!---  model Skills  -->
	<div style="display:none;" class="modal fade dtl-modal" id="skills" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Skills</span>
					</div>
					<div class="dtl-dis">
						<div class="form-group">
							<label>Skills</label>
							<input type="text" placeholder="Enter Skills">
						</div>
					</div>
					<div class="dtl-btn bottom-btn">
							<a href="#" class="save"><span>Save</span></a>
						</div>
				</div>	


            </div>
        </div>
    </div>
	
	
	<!---  model Social Links  -->
	<div style="display:none;" class="modal fade dtl-modal" id="social-link" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Social Links</span>
					</div>
					<div class="dtl-dis">
						<div class="fw pb20">
							
							<div class="row">
								<div class="">
									<div class="col-md-3 col-sm-3 col-xs-4 mob-pr0">
										<div class="form-group">
											<label>Website</label>
											<span class="span-select">
												<select>
													<option>Facebook</option>
													<option>Google</option>
													<option>Instagram</option>
												</select>
											</span>
										</div>
									</div>
									<div class="col-md-8 col-sm-8 col-xs-7">
										<div class="form-group">
											<label>URL</label>
											<input type="text" placeholder="URL">
										</div>
									</div>
									
									<div class="col-md-1 col-sm-1 col-xs-1 pl0">
										<label></label>
										<a href="#" class="pull-right"><img class="dlt-img" src="<?php echo base_url('assets/n-images/detail/dtl-delet.png?ver=' . time()) ?>"></a>
										
									</div>
									<div class="fw dtl-more-add">
										<a href="#"><span class="pr10">Add More Links </span><img src="<?php echo base_url('assets/n-images/detail/inr-add.png?ver=' . time()) ?>"></a>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-11 col-sm-11 col-xs-11">
								<div class="form-group">
									<label>Add Personal Website</label>
									<input type="text" placeholder="Add Personal Website">
								</div>
							</div>
							<div class="col-md-1 col-sm-1 col-xs-1 pl0">
								<label></label>
									<a href="#" class="pull-right"><img class="dlt-img" src="<?php echo base_url('assets/n-images/detail/dtl-delet.png?ver=' . time()) ?>"></a>
							</div>
							<div class="fw dtl-more-add pt15">
										<a href="#"><span class="pr10">Add More Links </span><img src="<?php echo base_url('assets/n-images/detail/inr-add.png?ver=' . time()) ?>"></a>
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
	
	<!---  model Basic Information  -->
	<div style="display:none;" class="modal fade dtl-modal" id="user-info-edit" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Basic Information</span>
					</div>
					<div class="dtl-dis">
						<div class="form-group">
							<p class="student-or-not">If Student then Make your Profile <a href="#"> Here!</a> 
								
							</p> 
							<p class="student-info-popup">
								<a href="#">
									<svg viewBox="0 0 65 65" xml:space="preserve" width="17px" height="17px">
										<g>
											<g>
												<path d="M32.5,0C14.58,0,0,14.579,0,32.5S14.58,65,32.5,65S65,50.421,65,32.5S50.42,0,32.5,0z M32.5,61C16.785,61,4,48.215,4,32.5    S16.785,4,32.5,4S61,16.785,61,32.5S48.215,61,32.5,61z" fill="#5c5c5c"></path>
												<circle cx="33.018" cy="19.541" r="3.345" fill="#5c5c5c"></circle>
												<path d="M32.137,28.342c-1.104,0-2,0.896-2,2v17c0,1.104,0.896,2,2,2s2-0.896,2-2v-17C34.137,29.237,33.241,28.342,32.137,28.342z    " fill="#5c5c5c"></path>
											</g>
										</g>

									</svg>
								</a>
								<span class="student-info-box">
									If you are a student then fill “Educational Information” form to get relevant opportunities based on your interest, or else if you have graduated/working then fill the following form to get appropriate opportunities.
								</span>
							</p>
						</div>
						<div class="form-group">
							<label>What's your current position?</label>
							<input type="text" placeholder="Enter Job Title / Designation">
						</div>
						<div class="form-group">
							<label>What’s your current location?</label>
							<input type="text" placeholder="Enter City Name">
						</div>
						<div class="form-group">
							<label>What is your field? </label>
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
					
					<div class="dtl-btn">
						<a href="#" class="save"><span>Save</span></a>
					</div>
					
					<div class="dtl-title fw">
						<span>Educational Information</span>
					</div>
					<div class="dtl-dis">
						<div class="form-group">
							<label>What are you studying right now?</label>
							<input type="text" placeholder="Pursuing: Engineering, Medicine, Desiging, MBA, Accounting, BA, 5th, 10th, 12th ..">
						</div>
						<div class="form-group">
							<label>Where are you from?</label>
							<input type="text" placeholder="Enter City Name">
						</div>
						<div class="form-group">
							<label>University / College / School</label>
							<input type="text" placeholder="Enter University / College / school ">
						</div>
						
						<div class="form-group">
							<label>Interested field </label>
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
					<div class="dtl-two-btn">
						<div class="col-md-6 col-sm-6 col-xs-6 p0">
							<div class="dtl-btn">
								<a href="#" class="back"><span>Back</span></a>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6 p0">
							<div class="dtl-btn">
								<a href="#" class="save"><span>Save</span></a>
							</div>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
	
        <!-- Bid-modal-2  -->
        <div class="modal fade message-box" id="bidmodal-2" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>         
                    <div class="modal-body">
                        <div class="mes">
                            <div id="popup-form">

                                <div class="fw" id="loader_popup"  style="text-align:center; display:none;"><img src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) ?>" alt="loaerimage"></div>

                                <form id ="userimage" name ="userimage" class ="clearfix" enctype="multipart/form-data" method="post">

                                    <div class="fw">
                                        <input type="file" name="profilepic" accept="image/gif, image/jpeg, image/png" id="upload-one">
                                    </div>

                                    <div class="col-md-7 text-center">
                                        <div id="upload-demo-one" style="width:350px; display:none;"></div>
                                    </div>

                                    <input type="submit" class="upload-result-one" name="profilepicsubmit" id="profilepicsubmit" value="Save" >

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Model Popup Close -->
        <!-- Bid-modal  -->
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
        <!-- Model Popup Close -->

            <?php echo $login_footer ?>   
            <?php echo $footer; ?>
            <script src="<?php echo base_url('assets/js/croppie.js?ver=' . time()); ?>"></script> 
            <!-- script for skill textbox automatic end (option 2)-->
            <script src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()) ?>"></script>
            <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>

            <script src="<?php echo base_url('assets/js/progressloader.js?ver=' . time()); ?>"></script>
            <script>
                var base_url = '<?php echo base_url(); ?>';
                var count_profile_value = '<?php echo $count_profile_value; ?>';
                var count_profile = '<?php echo $count_profile; ?>';
                var header_all_profile = '<?php echo $header_all_profile; ?>';
                var profile_pic = "";
            </script>
            <script src="<?php echo base_url('assets/js/webpage/job/job_printpreview.js?ver=' . time()); ?>"></script>
            <script src="<?php echo base_url('assets/js/webpage/job/cover_profile_common.js?ver=' . time()); ?>"></script>
            <script src="<?php echo base_url('assets/js/webpage/job/search_common.js?ver=' . time()); ?>"></script>
            <script src="<?php echo base_url('assets/js/webpage/job/progressbar_common.js?ver=' . time()); ?>"></script>
			<script src='https://cdnjs.cloudflare.com/ajax/libs/masonry/3.2.2/masonry.pkgd.min.js'></script>	
	<script>
		var masonryLayout = function masonryLayout(containerElem, itemsElems, columns) {
  containerElem.classList.add('masonry-layout', 'columns-' + columns);
  var columnsElements = [];

  for (var i = 1; i <= columns; i++) {
    var column = document.createElement('div');
    column.classList.add('masonry-column', 'column-' + i);
    containerElem.appendChild(column);
    columnsElements.push(column);
  }

  for (var m = 0; m < Math.ceil(itemsElems.length / columns); m++) {
    for (var n = 0; n < columns; n++) {
      var item = itemsElems[m * columns + n];
      columnsElements[n].appendChild(item);
      item.classList.add('masonry-item');
    }
  }
};

masonryLayout(document.getElementById('gallery'),
document.querySelectorAll('.gallery-item'), 2);

</script>
    </body>
</html>