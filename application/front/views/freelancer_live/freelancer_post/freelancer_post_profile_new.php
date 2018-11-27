<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <meta name="description" content="<?php echo $metadesc; ?>" />
        <?php echo $head; ?>
        <?php
        if (IS_APPLY_CSS_MINIFY == '0') {
            ?>
            
            <?php
        } else {
            ?>
            
        <?php } ?>

        <?php if (!$this->session->userdata('aileenuser')) { ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css'); ?>">
        <?php } ?>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/freelancer-apply.css?ver=' . time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>" />
    <?php $this->load->view('adsense'); ?>
</head>
    <?php if (!$this->session->userdata('aileenuser')) { ?>
        <body class="page-container-bg-solid page-boxed botton_footer no-login">
        <?php } else { ?>
        <body class="page-container-bg-solid page-boxed botton_footer">
        <?php } ?>
        <?php
        if ($this->session->userdata('aileenuser')) {
            if ($freelancerpostdata['0']['user_id'] != $this->session->userdata('aileenuser')) {
            echo $header_inner_profile;
            }
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
                                <a title="Create an account" href="javascript:void(0);" onclick="register_profile();" class="btn3">Create an account</a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

        <?php } ?>
        <?php
        if ($this->session->userdata('aileenuser')) {
            if ($freelancerpostdata['0']['user_id'] != $this->session->userdata('aileenuser')) {
                echo $freelancer_hire_header2;
            } else {
                echo $freelancer_post_header2;
            }
        }
        ?>
        <section class="custom-row">
            <div class="container" id="paddingtop_fixed">
                <div class="row" id="row1" style="display:none;">
                    <div class="col-md-12 text-center">
                        <div id="upload-demo" ></div>
                    </div>
                    <div class="col-md-12 cover-pic" >
                        <button class="btn btn-success  cancel-result set-btn" ><?php echo $this->lang->line("cancel"); ?></button>
                        <button class="btn btn-success set-btn upload-result"><?php echo $this->lang->line("save"); ?></button>
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
                        if ($this->uri->segment(2) == $userid) {
                            $user_id = $userid;
                        } elseif ($this->uri->segment(2) == "") {
                            $user_id = $userid;
                        } else {
                            if (is_numeric($this->uri->segment(2))) {
                                $user_id = $this->uri->segment(2);
                            } else {
                                $user_id = $this->db->get_where('freelancer_post_reg', array('freelancer_apply_slug' => $this->uri->segment(2), 'status' => '1'))->row()->user_id;
                            }
                        }
                        $contition_array = array('user_id' => $user_id, 'is_delete' => '0', 'status' => '1');
                        $image = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'profile_background', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                        $image_ori = $image[0]['profile_background'];
                        if ($image_ori) {
                            ?>

                            <img alt="<?php echo $freelancerpostdata[0]['freelancer_post_fullname'] . " " . $freelancerpostdata[0]['freelancer_post_username']; ?>" src="<?php echo FREE_POST_BG_MAIN_UPLOAD_URL . $image[0]['profile_background']; ?>" name="image_src" id="image_src" / >
                            <?php
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
            <div class="container tablate-container art-profile">    
                <?php if ($freelancerpostdata['0']['user_id'] == $this->session->userdata('aileenuser')) { ?>
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
                            $fname = $freelancerpostdata[0]['freelancer_post_fullname'];
                            $lname = $freelancerpostdata[0]['freelancer_post_username'];
                            $sub_fname = substr($fname, 0, 1);
                            $sub_lname = substr($lname, 0, 1);
                            if ($freelancerpostdata[0]['freelancer_post_user_image']) {

                                if (IMAGEPATHFROM == 'upload') {

                                    if (!file_exists($this->config->item('free_post_profile_main_upload_path') . $freelancerpostdata[0]['freelancer_post_user_image'])) {
                                        ?>
                                        <div class="post-img-user">
                                            <?php echo ucfirst(strtolower($sub_fname)) . ucfirst(strtolower($sub_lname)); ?>
                                        </div>
                                    <?php } else {
                                        ?>
                                        <img src="<?php echo FREE_POST_PROFILE_MAIN_UPLOAD_URL . $freelancerpostdata[0]['freelancer_post_user_image']; ?>" alt="<?php echo $freelancerpostdata[0]['freelancer_post_fullname'] . " " . $freelancerpostdata[0]['freelancer_post_username']; ?>" >        
                                        <?php
                                    }
                                } else {

                                    $filename = $this->config->item('free_post_profile_main_upload_path') . $freelancerpostdata[0]['freelancer_post_user_image'];
                                    $s3 = new S3(awsAccessKey, awsSecretKey);
                                    $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                    if ($info) {
                                        ?>
                                        <img src="<?php echo FREE_POST_PROFILE_MAIN_UPLOAD_URL . $freelancerpostdata[0]['freelancer_post_user_image']; ?>" alt="<?php echo $freelancerpostdata[0]['freelancer_post_fullname'] . " " . $freelancerpostdata[0]['freelancer_post_username']; ?>" >
                                    <?php } else { ?>
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
                            <?php if ($freelancerpostdata['0']['user_id'] == $this->session->userdata('aileenuser')) { ?>
                                <a title="Update Profile Picture" href="javascript:void(0);" class="cusome_upload" onclick="updateprofilepopup();"><img alt="Update Profile Picture"  src="<?php echo base_url('assets/img/cam.png'); ?>"><?php echo $this->lang->line("update_profile_picture"); ?></a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="job-menu-profile mob-block">
                        <a title="<?php echo ucwords($freelancerpostdata[0]['freelancer_post_fullname']) . ' ' . ucwords($freelancerpostdata[0]['freelancer_post_username']); ?>" href="javascript:void(0);">   <h3> <?php echo ucwords($freelancerpostdata[0]['freelancer_post_fullname']) . ' ' . ucwords($freelancerpostdata[0]['freelancer_post_username']); ?></h3></a>
                        <div class="profile-text">
                            <?php
                            if ($freelancerpostdata['0']['user_id'] == $this->session->userdata('aileenuser')) {
                                if ($freelancerpostdata[0]['designation'] == "") {
                                    ?> 
                                    <a id="designation" class="designation" title="Designation"><?php echo $this->lang->line("designation"); ?></a>
                                    <?php
                                } else {
                                    ?> 
                                    <a id="designation" class="designation" title="<?php echo ucwords($freelancerpostdata[0]['designation']); ?>"><?php echo ucwords($freelancerpostdata[0]['designation']); ?></a>
                                    <?php
                                }
                            } else {
                                if ($freelancerpostdata[0]['designation'] == '') {
                                    ?>
                                    <?php echo $this->lang->line("designation"); ?>
                                <?php } else { ?>
                                    <?php echo ucwords($freelancerpostdata[0]['designation']); ?>
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
                            $login_slug = $this->db->select('freelancer_apply_slug')->get_where('freelancer_post_reg', array('user_id' => $userid, 'status' => '1'))->row()->freelancer_apply_slug;
                            if ($freelancerpostdata[0]['user_id'] == $userid)
                            { ?>
                                <ul class="current-user pro-fw">
                            <?php
                            } else { ?>
                                <ul class="pro-fw4">
                            <?php
                                }
                                    /*if (is_numeric($this->uri->segment(2))) {
                                        $slug = $this->db->select('freelancer_apply_slug')->get_where('freelancer_post_reg', array('user_id' => $this->uri->segment(2), 'status' => '1'))->row()->freelancer_apply_slug;
                                    } else {
                                        $slug = $this->uri->segment(2);
                                    }*/
                                    $slug = $this->uri->segment(2);
                                    ?>  
                                    <li <?php echo (($this->uri->segment(1) == 'freelancer') && ($this->uri->segment(2) == $slug) ? 'class="active"' : '');?>>
                                        <?php if ($freelancerpostdata['0']['user_id'] != $this->session->userdata('aileenuser')) { ?>
                                            <a title="Freelancer Details" href="<?php echo base_url('freelancer/'.$slug); ?>">Details</a><?php } else { ?><a title="Freelancer Details" href="<?php echo base_url('freelancer/'.$slug); ?>"><?php echo $this->lang->line("freelancer_details"); ?></a><?php } ?>
                                    </li>
                                    <?php
                                    $id = $this->db->get_where('freelancer_post_reg', array('freelancer_apply_slug' => $this->uri->segment(2), 'status' => '1'))->row()->user_id;
                                    if (($this->uri->segment(1) == 'freelancer') && ($this->uri->segment(2) == $login_slug || $this->uri->segment(2) == 'home' || $this->uri->segment(2) == 'freelancer_save_post' || $this->uri->segment(2) == 'applied-projects') && ($id == $this->session->userdata('aileenuser') || $this->uri->segment(2) == '')) {
                                        ?>
                                        <li <?php if (($this->uri->segment(1) == 'freelancer') && ($this->uri->segment(2) == 'saved-projects')) { ?> class="active" <?php } ?>><a title="Saved Post" href="<?php echo base_url('freelancer/saved-projects'); ?>"><?php echo $this->lang->line("saved_projects"); ?></a> </li>
                                        <li <?php if (($this->uri->segment(1) == 'freelancer') && ($this->uri->segment(2) == 'applied-projects')) { ?> class="active" <?php } ?>><a title="Applied  Post" href="<?php echo base_url('freelancer/applied-projects'); ?>"><?php echo $this->lang->line("applied_projects"); ?></a> </li>
                                    <?php } ?>
                                </ul>

                                <?php
                                if (is_numeric($this->uri->segment(2))) {
                                    $id = $this->uri->segment(2);
                                } else {
                                    $id = $this->db->get_where('freelancer_post_reg', array('freelancer_apply_slug' => $this->uri->segment(2), 'status' => '1'))->row()->user_id;
                                }
                                $userid = $this->session->userdata('aileenuser');

                                $contition_array = array('from_id' => $userid, 'to_id' => $id, 'save_type' => '2');
                                $data = $this->common->select_data_by_condition('save', $contition_array, $data = 'status', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                                if ($this->session->userdata('aileenuser')) {
                                    if ($userid != $id) {
                                        if ($this->uri->segment(2) != "") {
                                            ?>
                                            <div class="flw_msg_btn fr">
                                                <ul>
                                                    <?php
                                                    if ($data[0]['status'] == '1' || $data[0]['status'] == '') {

                                                        if ($_GET['post_id']) {
                                                            ?> 
                                                            <li>
                                                                <a title="shortlist" id="<?php echo $id; ?>" onClick="shortlistpopup(<?php echo $id; ?>)" href="javascript:void(0);" class="<?php echo 'saveduser' . $id ?>"> Shortlist </a> 

                                                            </li>
                                                        <?php } else { ?>
                                                            <li>
                                                                <a title="save" id="<?php echo $id; ?>" onClick="savepopup(<?php echo $id; ?>)" href="javascript:void(0);" class="<?php echo 'saveduser' . $id ?>">
                                                                    <?php echo $this->lang->line("save"); ?>
                                                                </a> 

                                                            </li> <?php
                                                        }
                                                    } elseif ($data[0]['status'] == '0') {
                                                        ?>
                                                        <li> 
                                                            <a title="Saved" class="saved butt_rec <?php echo 'saveduser' . $id; ?> "><?php echo $this->lang->line("saved"); ?></a>
                                                        </li> <?php } else {
                                                        ?>
                                                        <li> 
                                                            <a title="Shortlisted" class="saved butt_rec <?php echo 'saveduser' . $id; ?> ">Shortlisted</a>
                                                        </li> 
                                                    <?php }
                                                    ?>
                                                    <li>
                                                        <input type="hidden" id="<?php echo 'hideenpostid'; ?>" value= "<?php echo $_GET['page']; ?>">
                                                        <?php
                                                        if ($this->session->userdata('aileenuser')) {
                                                            if ($freelancerpostdata['0']['user_id'] != $this->session->userdata('aileenuser')) {
                                                                // $msg_url = base_url('chat/abc/3/4/' . $row['user_id']);//Old
                                                                $msg_url = MESSAGE_URL.'fh/fa-'.$freelancerpostdata['0']['freelancer_apply_slug'];
                                                                ?>
                                                                <a title="Message" href="<?php echo $msg_url; ?>"><?php echo $this->lang->line("message"); ?></a>
                                                            <?php } else {
                                                                // $msg_url = base_url('chat/abc/4/3/' . $id);//Old
                                                                $msg_url = MESSAGE_URL.'fa/fh-'.$freelancerpostdata['0']['freelancer_apply_slug'];
                                                                ?>
                                                                <a title="Message" href="<?php echo $msg_url; ?>"><?php echo $this->lang->line("message"); ?></a>
                                                            <?php
                                                            }
                                                        }
                                                        ?>

                                                    </li>
                                                </ul>
                                            </div>
                                            <?php
                                        }
                                    }
                                }
                                ?>

                        </div>
                    </div>
                </div>
            </div>
            
			<div class="container tab-plr0">
                <div class="job-menu-profile mob-none pt-20 job_edit_menu">
                    <a title="<?php echo ucwords($freelancerpostdata[0]['freelancer_post_fullname']) . ' ' . ucwords($freelancerpostdata[0]['freelancer_post_username']); ?>" href="javascript:void(0);">   <h3> <?php echo ucwords($freelancerpostdata[0]['freelancer_post_fullname']) . ' ' . ucwords($freelancerpostdata[0]['freelancer_post_username']); ?></h3></a>
                    <div class="profile-text pt5">
                        <?php
                        if ($freelancerpostdata['0']['user_id'] == $this->session->userdata('aileenuser')) {
                            if ($freelancerpostdata[0]['designation'] == "") {
                                ?> 
                                <a id="designation" class="designation" title="Designation"><?php echo $this->lang->line("designation"); ?></a>
                                <?php
                            } else {
                                ?> 
                                <a id="designation" class="designation" title="<?php echo $freelancerpostdata[0]['designation']; ?>"><?php echo $freelancerpostdata[0]['designation']; ?></a>
                                <?php
                            }
                        } else {
                            if ($freelancerpostdata[0]['designation'] == "") {
                                ?>
                                <?php echo $this->lang->line("designation"); ?>
                            <?php } else { ?>
                                <?php echo ucwords($freelancerpostdata[0]['designation']); ?>

                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
             
				
            </div>
		<div class="container tab-plr0 pt20">
			<div class="all-detail-custom">
				<div class="custom-user-list">
					<div class="edit-custom-move">
					</div>
					<div class="gallery" id="gallery">
						
						<!--  01 Company Overview -->
						<div class="gallery-item ">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/prof-sum.png?ver=' . time()) ?>"><span>Company Overview</span><a href="#" data-target="#prof-summary" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
								</div>
								<div class="dtl-dis">
									<p>Lorem ipsum its a dummy text and its user to for all.Lorem ipsum its a dummy text and its user to for all.Lorem ipsum its a dummy text and its user to for all.Lorem ipsum its a dummy text and its user to for all.</p>
								</div>
							</div>
						</div>
						
						<!--  02 Edit profile -->
						<div class="gallery-item edit-profile-move">
						</div>
						
						<!--  03 Blank div -->
						<div class="gallery-item">
						</div>
						
						<!--  04 Company Information -->
						<div class="gallery-item">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/company-info.png?ver=' . time()) ?>"><span>Company Information</span><a href="#" data-target="#com-info" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
								</div>
								<div class="dtl-dis dtl-box-height">
									<ul class="dis-list">
										
										<li>
											<span>Company Name</span>
											Verv System pvt ltd
										</li>
										<li>
											<span>Industry</span>
											IT Field
										</li>
										<li>
											<span>Company Email </span>
											harshad2406patoliya@gmail.com
										</li>
										<li>
											<span>Company Phone number</span>
											+91 951005589
										</li>
										<li>
											<span>Skype</span>
											harshad2406
										</li>
										<li>
											<span>Website URL</span>
											www.vervsystem.com
										</li>
										<li>
											<span>Team Size</span>
											105
										</li>
										
										<li>
											<span>Timezone</span>
											GMT 21:45
										</li>
										<li>
											<span>Company Founded</span>
											June 2008
										</li>
										<li>
											<span>Company Overview</span>
											Lorem ipsum its a dummy text and its user to for all.Lorem ipsum its a dummy text and its user to for all.Lorem ipsum its a dummy text and its user to for all.Lorem ipsum its a dummy text and its user to for all.. <a href="#">Read More</a>
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
											5 Year 7 Month
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
											Ahmedabad, Gujrat , India
										</li>
										<li>
											<span>Company Logo</span>
											<a href="#"><img style="width:80px;" src="<?php echo base_url('assets/n-images/detail/pr-web.png?ver=' . time()) ?>"></a>
										</li>
										
									</ul>
								</div>
								<div class="about-more">
									<a href="#">View More <img src="<?php echo base_url('assets/n-images/detail/down-arrow.png?ver=' . time()) ?>"></a>
								</div>
							</div>
						</div>
						
						<!--  05 skill -->
						<div class="gallery-item skill-move">
						</div>
						
						<!--  06 Social link (website) -->
						<div class="gallery-item social-link-move">
						</div>
						
						<!--  07 Portfolio / project  -->
						<div class="gallery-item">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/bus-portfolio.png?ver=' . time()) ?>"><span>Portfolio</span><a href="#" data-target="#dtl-project" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
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
																<img src="<?php echo base_url('assets/n-images/detail/art-img.png?ver=' . time()) ?>">
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
																<img src="<?php echo base_url('assets/n-images/detail/art-img.jpg?ver=' . time()) ?>">
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
						
						<!--  08 Tagline -->
						<div class="gallery-item ">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/tagline.png?ver=' . time()) ?>"><span>Tagline</span><a href="#" data-target="#tagline" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
								</div>
								<div class="dtl-dis">
									<p>Lorem ipsum its a dummy text and its user to for all.Lorem ipsum its a dummy text and its user to for all.</p>
								</div>
							</div>
						</div>
						
						<!--  09 Rate -->
						<div class="gallery-item ">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/rate.png?ver=' . time()) ?>"><span>Rate</span><a href="#" data-target="#rate" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
								</div>
								<div class="dtl-dis">
									<p>450 rs Per hour</p>
									<p>Work On Fixed Rate.</p>
								</div>
							</div>
						</div>
						
						
						
						<!--  10 Availability -->
						<div class="gallery-item ">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/availability.png?ver=' . time()) ?>"><span>Availability</span><a href="#" data-target="#availability" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
								</div>
								<div class="dtl-dis">
									<ul class="dis-list">
										
										<li>
											<span>Duration per week</span>
											0 to 25 hrs/week
										</li>
										<li>
											<span>Status</span>
											Available
										</li>
									</ul>
								</div>
							</div>
						</div>
						
						<!--  11 Reviews  -->
						<div class="gallery-item">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/review.png?ver=' . time()) ?>"><span>Reviews</span>
									
									<a href="#" data-target="#reviews" data-toggle="modal" class="pull-right write-review"><img src="<?php echo base_url('assets/n-images/detail/write.png?ver=' . time()) ?>"> <span>Write a review</span></a>
								</div>
								<div class="dtl-dis">
									<div class="total-rev">
										<span class="total-rat">4.8</span> <span class="rating-star">
			<div class="rating-container rating-sm rating-animate"><div class="clear-rating clear-rating-active" title="Clear"><i class="glyphicon glyphicon-minus-sign"></i></div><div class="rating-stars" title="Four Stars"><span class="empty-stars"><span class="star"><i class="glyphicon glyphicon-star-empty"></i></span><span class="star"><i class="glyphicon glyphicon-star-empty"></i></span><span class="star"><i class="glyphicon glyphicon-star-empty"></i></span><span class="star"><i class="glyphicon glyphicon-star-empty"></i></span><span class="star"><i class="glyphicon glyphicon-star-empty"></i></span></span><span class="filled-stars" style="width: 80%;"><span class="star"><i class="glyphicon glyphicon-star"></i></span><span class="star"><i class="glyphicon glyphicon-star"></i></span><span class="star"><i class="glyphicon glyphicon-star"></i></span><span class="star"><i class="glyphicon glyphicon-star"></i></span><span class="star"><i class="glyphicon glyphicon-star"></i></span></span><input id="input-21b" value="4" type="text" class="rating rating-input" data-min="0" data-max="5" data-step="0.2" data-size="sm" required="" title=""></div><div class="caption"><span class="label label-primary badge-primary">Four Stars</span></div></div>
												</span>
												<span class="rev-count">59 Reviews</span>
												
												
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
			<div class="rating-container rating-sm rating-animate"><div class="clear-rating clear-rating-active" title="Clear"><i class="glyphicon glyphicon-minus-sign"></i></div><div class="rating-stars" title="Two Stars"><span class="empty-stars"><span class="star"><i class="glyphicon glyphicon-star-empty"></i></span><span class="star"><i class="glyphicon glyphicon-star-empty"></i></span><span class="star"><i class="glyphicon glyphicon-star-empty"></i></span><span class="star"><i class="glyphicon glyphicon-star-empty"></i></span><span class="star"><i class="glyphicon glyphicon-star-empty"></i></span></span><span class="filled-stars" style="width: 40%;"><span class="star"><i class="glyphicon glyphicon-star"></i></span><span class="star"><i class="glyphicon glyphicon-star"></i></span><span class="star"><i class="glyphicon glyphicon-star"></i></span><span class="star"><i class="glyphicon glyphicon-star"></i></span><span class="star"><i class="glyphicon glyphicon-star"></i></span></span><input id="input-21b" value="2" type="text" class="rating rating-input" data-min="0" data-max="5" data-step="0.2" data-size="sm" required="" title=""></div><div class="caption"><span class="label label-warning badge-warning">Two Stars</span></div></div>
												</span>
												</div>
												<div class="review-dis">
													Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam feugiat turpis a erat sagittis pharetra. Etiam sapien nulla, tincidunt id libero non, iaculis elementum ex. Aenean commodo vitae felis ut dictum.
												</div>
											</div>
										</li>
										
									</ul>
									<div class="form-group">
										
									</div>
									
								</div>
							</div>
						</div>
						
					
						<!--  12 Additional Caurse  -->
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
																<img src="<?php echo base_url('assets/n-images/detail/art-img.jpg?ver=' . time()) ?>">
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
																<img src="<?php echo base_url('assets/n-images/detail/art-img.jpg?ver=' . time()) ?>">
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
						
						<!--  13 Publication -->
						<div class="gallery-item">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/publication.png?ver=' . time()) ?>"><span>Publication</span><a href="#" data-target="#publication" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
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
																<img src="<?php echo base_url('assets/n-images/detail/art-img.jpg?ver=' . time()) ?>">
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
														<a href="#" data-target="#publication" data-toggle="modal" class="pr5"><img src="<?php echo base_url('assets/n-images/detail/detial-edit.png?ver=' . time()) ?>/"></a>
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
																<img src="<?php echo base_url('assets/n-images/detail/art-img.jpg?ver=' . time()) ?>">
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
						
						
						
						
					</div>
				</div>
			<div class="right-add">
				
					
				<div class="row">
					<div class="dtl-box p10 dtl-adv">
						<img src="<?php echo base_url('assets/n-images/detail/add.png?ver=' . time()) ?>">
					</div>
					
					<!-- edit profile  -->
					<div class="rsp-dtl-box">
						<div class="dtl-box" id="edit-profile-move">
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
						<div class="dtl-box" id="skill-move">
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
					
						<div class="dtl-box" id="social-link-move">
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
									<li><a href="#"><img src="<?php echo base_url(); ?>n-images/detail/git.png"></a></li>
									<li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/twt.png?ver=' . time()) ?>"></a></li>
								</ul>
								<h4 class="pt20 fw">Personal</h4>
								<ul class="social-link-list">
									<li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/pr-web.png?ver=' . time()) ?>"></a></li>
									<li><a href="#"><img src="<?php echo base_url(); ?>n-images/detail/pr-web.png"></a></li>
								</ul>
							</div>
						</div>
					</div>
					
					
					
				</div>
			</div>
			</div>
		</div>
            <div class="clearfix"></div>
			
        </section>
		<div class="bottom-ftr-none">
        <?php echo $login_footer ?>
        <?php echo $footer; ?>
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
							<label>Services you offer</label>
							<textarea type="text" placeholder="Services you offer"></textarea>
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
							<label>Skills you offer</label>
							<input type="text" placeholder="Skills you offer">
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
	
	<!-- modal Reviews  -->
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
	
	<!-- Rate  -->
	<div style="display:none;" class="modal fade dtl-modal" id="rate" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Rate</span>
					</div>
					<div class="dtl-dis">
						<div class="row">
							<div class="col-md-4 col-sm-4 col-xs-4 fw-479">
								<div class="form-group">
									<label>Currency</label>
									<span class="span-select">
										<select class="form-control">
											<option>rs</option>
											<option>$</option>
											<option>Pound</option>
										</select>
									</span>
								</div>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-4 fw-479">
								<div class="form-group">
									<label>Amount</label>
									<input type="text" placeholder="Amount">
								
								</div>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-4 fw-479">
								<div class="form-group">
									<label>Per</label>
									<span class="span-select">
										<select class="form-control">
											<option>Per hour</option>
											<option>Per Week</option>
											<option>Per Month</option>
										</select>
									</span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control control--checkbox">
								<input type="checkbox">Work On Fixed Rate.
								<div class="control__indicator">
								</div>
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
	
	
	<!-- Availability  -->
	<div style="display:none;" class="modal fade dtl-modal" id="availability" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Availability</span>
					</div>
					<div class="dtl-dis">
						<div class="row">
							<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
								<div class="form-group">
									<label>Duration per week</label>
									<span class="span-select">
										<select class="form-control">
											<option>0 to 25 hrs/week</option>
											<option>B/w 25 to 50 hrs/week</option>
											<option> More 50 hrs/week </option>
										</select>
									</span>
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
								<div class="form-group">
									<label>Status</label>
									<span class="span-select">
										<select class="form-control">
											<option>Available</option>
											<option>Will Look</option>
											<option>Not Available </option>
											<option>Currently on Leave </option>
										</select>
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="dtl-btn bottom-btn">
							<a href="#" class="save"><span>Save</span></a>
						</div>
				</div>	


            </div>
        </div>
    </div>
	
	<!-- Tagline  -->
	<div style="display:none;" class="modal fade dtl-modal" id="tagline" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Tagline</span>
					</div>
					<div class="dtl-dis">
						<div class="form-group">
							
							<textarea type="text" placeholder="Tagline"></textarea>
						</div>
				
					</div>
					<div class="dtl-btn bottom-btn">
							<a href="#" class="save"><span>Save</span></a>
						</div>
				</div>	


            </div>
        </div>
    </div>
	
	
	<!-- Profile Summary  -->
	<div style="display:none;" class="modal fade dtl-modal" id="prof-summary" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Profile Summary</span>
					</div>
					<div class="dtl-dis">
						<div class="form-group">
							
							<textarea type="text" placeholder="Profile Summary"></textarea>
						</div>
				
					</div>
					<div class="dtl-btn bottom-btn">
							<a href="#" class="save"><span>Save</span></a>
						</div>
				</div>	


            </div>
        </div>
    </div>
	
	
	<!---  model Projects / Portfolio -->
	<div style="display:none;" class="modal fade dtl-modal" id="dtl-project" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Portfolio</span>
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
						<div class="fw pb20">
							
							<div class="row">
								<div class="">
									<div class="width-45">
										<div class="form-group">
											<label>Skills</label>
											<input placeholder="Skills" type="text">
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
										<a href="#"><span class="pr10">Add More Skills </span><img src="<?php echo base_url('assets/n-images/detail/inr-add.png?ver=' . time()) ?>"></a>
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
                                    <?php //echo form_open_multipart(base_url('freelancer/user_image_insert'), array('id' => 'userimage', 'name' => 'userimage', 'class' => 'clearfix'));                    ?>
                                    <div class="fw">
                                        <input type="file" name="profilepic" accept="image/gif, image/jpeg, image/png" id="upload-one">
                                    </div>
                                    <div class="col-md-7 text-center">
                                        <div id="upload-demo-one" style="width:350px"></div>
                                    </div>
                                    <input type="submit" class="upload-result-one" name="profilepicsubmit" id="profilepicsubmit" value="Save" >
                                </form>
                                <?php //echo form_close();                    ?>
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
                                                    //<?php
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
                                            <span><select tabindex="108" class="gender"  onchange="changeMe(this)" name="selgen" id="selgen">
                                                    <option value="" disabled selected value>Gender</option>
                                                    <option value="M">Male</option>
                                                    <option value="F">Female</option>
                                                </select>
                                            </span>
                                        </div>

                                        <p class="form-text" style="margin-bottom: 10px;">
                                            By Clicking on create an account button you agree our
                                            <a tabindex="109" title="Terms and Condition" href="<?php echo base_url('terms-and-condition'); ?>">Terms and Condition</a> and <a tabindex="110" title="Privacy policy" href="<?php echo base_url('privacy-policy'); ?>">Privacy policy</a>.
                                        </p>
                                        <p>
                                            <button tabindex="111" class="btn1">Create an account</button>

                                        </p>
                                        <div class="sign_in pt10">
                                            <p>
                                                Already have an account ? <a title=" Log In" tabindex="112" onClick="login_profile();" href="javascript:void(0);"> Log In </a>
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
                                            Don't have an account? <a title="Create an account" class="db-479" href="javascript:void(0);" data-toggle="modal" onclick="register_profile();">Create an account</a>
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

        <?php
        if (IS_APPLY_JS_MINIFY == '0') {
            ?>
            <script  src="<?php echo base_url('assets/js/croppie.js?ver=' . time()); ?>"></script>
            <!-- <script  src="<?php //echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script> -->
            <script  type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js/progressloader.js?ver=' . time()); ?>">
            </script>
            <?php
        } else {
            ?>
            <script  src="<?php echo base_url('assets/js_min/croppie.js?ver=' . time()); ?>"></script>
            <!-- <script  src="<?php //echo base_url('assets/js_min/bootstrap.min.js?ver=' . time()); ?>"></script> -->
            <script  type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js_min/progressloader.js?ver=' . time()); ?>">
            </script>
        <?php } ?>
        
        <script>
            var base_url = '<?php echo base_url(); ?>';
            var user_session = '<?php echo $this->session->userdata('aileenuser'); ?>';
            var segment3 = '<?php echo $this->uri->segment(2); ?>'
            var count_profile_value = '<?php echo $count_profile_value; ?>';
            var count_profile = '<?php echo $count_profile; ?>';
            //var header_all_profile = '<?php echo $header_all_profile; ?>';

        var app = angular.module('headerApp', []);
        </script>
        <script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-apply/freelancer_post_profile.js?ver=' . time()); ?>"></script>
        <?php
        if (IS_APPLY_JS_MINIFY == '0') {
            ?>
                                        <!--<script  type="text/javascript" src="<?php //echo base_url('assets/js/webpage/freelancer-apply/freelancer_post_profile.js?ver=' . time()); ?>"></script>-->
            <script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-apply/freelancer_apply_common.js?ver=' . time()); ?>"></script>
            <script async type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-apply/progressbar.js?ver=' . time()); ?>"></script>
            <?php
        } else {
            ?>
            <!--<script  type="text/javascript" src="<?php //echo base_url('assets/js_min/webpage/freelancer-apply/freelancer_post_profile.js?ver=' . time()); ?>"></script>-->
            <script  type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/freelancer-apply/freelancer_apply_common.js?ver=' . time()); ?>"></script>
            <script async type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/freelancer-apply/progressbar.js?ver=' . time()); ?>"></script>
        <?php } ?>
        <script>
            var header_all_profile = '<?php echo $header_all_profile; ?>';
        </script>               
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
		<script src='https://cdnjs.cloudflare.com/ajax/libs/masonry/3.2.2/masonry.pkgd.min.js'></script>
		<script src="<?php echo base_url('assets/js/star-rating.js?ver=' . time()) ?>"></script>
		
		<script>
		$(document).ready(function () {
		if (screen.width > 768) {
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
		}
		});

			
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
			$(document).ready(function () {
				if (screen.width <= 1199) {
					$("#edit-profile-move").appendTo($(".edit-profile-move"));
					$("#social-link-move").appendTo($(".social-link-move"));
					$("#skill-move").appendTo($(".skill-move"));
					$("#social-link-move").appendTo($(".social-link-move"));
					$("#menu-move").appendTo($(".menu-move"));
					$(".remove-blank").remove();
				}
				if (screen.width < 768) {
					$("#edit-profile-move").appendTo($(".edit-custom-move"));
				}
			});
		</script>
    </body>
</html>