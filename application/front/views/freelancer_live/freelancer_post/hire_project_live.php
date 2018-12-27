<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <meta name="description" content="<?php echo $metadesc; ?>" />
        <!-- start head -->
        <?php echo $head; ?>
        <!-- END HEAD -->        
        
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/freelancer-hire.css?ver=' . time()); ?>">         
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()) ?>">
    <?php $this->load->view('adsense'); ?>
</head>
    <!-- END HEAD -->
    <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">
    
    <body class="page-container-bg-solid page-boxed no-login freeh3 detail-job-no-login body-loader">
        <?php $this->load->view('page_loader'); ?>
        <div id="main_page_load" style="display: block;">    
            <header>
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
										<li class="hidden-991"><a href="<?php echo base_url('login'); ?>" class="btn2">Login</a></li>
										<li class="hidden-991"><a href="<?php echo base_url(); ?>freelancer/create-account" class="btn3">Create Freelancer Account</a></li>
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
            </header>
            <section>
                <div class="no-login-padding">
					<div class="ld-sub-header detail-sub-header">
						<div class="container">
							<div class="web-ld-sub">
                            <ul class="">
                                <li><a href="<?php echo base_url('freelance-jobs'); ?>">Freelancer Profile</a></li>
                                <li><a href="<?php echo base_url('freelance-jobs-by-fields'); ?>">Freelance Job by Fields</a></li>
                                <li><a href="<?php echo base_url('freelance-jobs-by-categories'); ?>">Freelance Job by Categories</a></li>
                                <li><a href="<?php echo base_url('how-to-use-freelance-profile-in-aileensoul'); ?>">How Freelancer Profile Works</a></li>
                                <li><a href="<?php echo base_url('blog'); ?>">Blog</a></li>
                            </ul>
                        </div>
                        <div class="mob-ld-sub">
                            <ul class="">
                                <li class="tab-first-li">
                                    <a href="javascript:void(0);">Freelance Jobs</a>
                                    <ul>
                                        <li><a href="<?php echo base_url('freelance-jobs'); ?>">Freelancer Profile</a></li>
                                        <li><a href="<?php echo base_url('freelance-jobs-by-fields'); ?>">Freelance Job by Fields</a></li>
                                        <li><a href="<?php echo base_url('freelance-jobs-by-categories'); ?>">Freelance Job by Categories</a></li>
                                        <li><a href="<?php echo base_url('how-to-use-freelance-profile-in-aileensoul'); ?>">How Freelancer Profile Works</a></li>
                                        <li><a href="<?php echo base_url('blog'); ?>">Blog</a></li>
                                    </ul>
                                    
                                </li>
                                <li><a href="<?php echo base_url('login'); ?>">Login</a></li>
                                <li><a href="<?php echo base_url('business-profile/create-account'); ?>"><span class="hidden-479">Create Freelancer Profile</span><span class="visible-479">Sign Up</span></a></li>
                            </ul>
                        </div>
						</div>
					</div>
                    <div class="container padding-360 mobp0 mt15">
                        <div class="row4">

                            <div class="profile-box-custom fl animated fadeInLeftBig left_side_posrt"><div class="">

                                    <div class="full-box-module">   
                                        <div class="profile-boxProfileCard  module">
                                            <div class="profile-boxProfileCard-cover"> 
                                                <a class="profile-boxProfileCard-bg u-bgUserColor a-block" href="javascript:void(0);" onclick="register_profile();" tabindex="-1" 
                                                   aria-hidden="true" rel="noopener">
                                                    <div class="bg-images no-cover-upload"> 
                                                        <?php
                                                        if ($freelancr_user_data[0]['profile_background'] != '') {
                                                            ?>

                                                            <!-- box image start -->
                                                            <img src="<?php echo FREE_HIRE_BG_THUMB_UPLOAD_URL . $freelancr_user_data[0]['profile_background']; ?>" class="bgImage" alt="<?php echo $freelancr_user_data[0]['fullname'] . ' ' . $freelancr_user_data[0]['username']; ?>">
                                                            <!-- box image end -->
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <img src="<?php echo base_url(WHITEIMAGE); ?>" class="bgImage" alt="<?php echo $freelancr_user_data[0]['fullname'] . ' ' . $freelancr_user_data[0]['username']; ?>" >
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="profile-boxProfileCard-content clearfix">
                                                <div class="left_side_box_img buisness-profile-txext">

                                                    <a class="profile-boxProfilebuisness-avatarLink2 a-inlineBlock"  href="javascript:void(0);" onclick="register_profile();" title="<?php echo $freelancr_user_data[0]['rec_firstname'] . ' ' . $freelancr_user_data[0]['rec_lastname']; ?>" tabindex="-1" aria-hidden="true" rel="noopener">
                                                        <?php
                                                        $fname = $freelancr_user_data[0]['fullname'];
                                                        $lname = $freelancr_user_data[0]['username'];
                                                        $sub_fname = substr($fname, 0, 1);
                                                        $sub_lname = substr($lname, 0, 1);

                                                        if ($freelancr_user_data[0]['freelancer_hire_user_image']) {
                                                            if (IMAGEPATHFROM == 'upload') {
                                                                if (!file_exists($this->config->item('free_hire_profile_main_upload_path') . $freelancr_user_data[0]['freelancer_hire_user_image'])) {
                                                                    ?>
                                                                    <div class="post-img-profile">
                                                                        <?php echo ucfirst(strtolower($sub_fname)) . ucfirst(strtolower($sub_lname)); ?>
                                                                    </div>
                                                                <?php } else {
                                                                    ?>
                                                                    <img src="<?php echo FREE_HIRE_PROFILE_MAIN_UPLOAD_URL . $freelancr_user_data[0]['freelancer_hire_user_image']; ?>" alt="<?php echo $freelancr_user_data[0]['fullname'] . " " . $freelancr_user_data[0]['username']; ?>" > 
                                                                    <?php
                                                                }
                                                            } else {
                                                                $filename = $this->config->item('free_hire_profile_main_upload_path') . $freelancr_user_data[0]['freelancer_hire_user_image'];
                                                                $s3 = new S3(awsAccessKey, awsSecretKey);
                                                                $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                                                if ($info) {
                                                                    ?>
                                                                    <img src="<?php echo FREE_HIRE_PROFILE_MAIN_UPLOAD_URL . $freelancr_user_data[0]['freelancer_hire_user_image']; ?>" alt="<?php echo $freelancr_user_data[0]['fullname'] . " " . $freelancr_user_data[0]['username']; ?>" >
                                                                <?php } else {
                                                                    ?>
                                                                    <div class="post-img-profile">
                                                                        <?php echo ucfirst(strtolower($sub_fname)) . ucfirst(strtolower($sub_lname)); ?>
                                                                    </div> 
                                                                    <?php
                                                                }
                                                            }
                                                        } else {
                                                            ?>
                                                            <div class="post-img-profile">
                                                                <?php echo ucfirst(strtolower($sub_fname)) . ucfirst(strtolower($sub_lname)); ?>
                                                            </div>
                                                            <?php
                                                        }
                                                        ?>
                                                    </a>
                                                </div>
                                                <div class="right_left_box_design ">
                                                    <span class="profile-company-name ">
                                                        <a href="javascript:void(0);" onclick="register_profile();" title="<?php echo ucfirst(strtolower($freelancr_user_data['fullname'])) . ' ' . ucfirst(strtolower($freelancr_user_data['username'])); ?>">   <?php echo ucfirst(strtolower($freelancr_user_data[0]['fullname'])) . ' ' . ucfirst(strtolower($freelancr_user_data[0]['username'])); ?></a>
                                                    </span>


                                                    <div class="profile-boxProfile-name">
                                                        <a href="javascript:void(0);" onclick="register_profile();" title="<?php echo ucfirst(strtolower($freelancr_user_data[0]['designation'])); ?>">
                                                            <?php
                                                            if (ucfirst(strtolower($freelancr_user_data[0]['designation']))) {
                                                                echo ucfirst(strtolower($freelancr_user_data[0]['designation']));
                                                            } else {
                                                                echo "Designation";
                                                            }
                                                            ?></a>
                                                    </div>
                                                    <ul class=" left_box_menubar">
                                                        <li <?php if ($this->uri->segment(1) == 'freelance-hire' && $this->uri->segment(2) == 'employer-details') { ?> class="active" <?php } ?>><a class="padding_less_left" title="Details" href="javascript:void(0);" onclick="register_profile();"> <?php echo $this->lang->line("details"); ?></a>
                                                        </li>                                
                                                        <li id="rec_post_home" <?php if ($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'post') { ?> class="active" <?php } ?>><a title="Projects" href="javascript:void(0);" onclick="register_profile();"><?php echo $this->lang->line("Projects"); ?></a>
                                                        </li>
                                                        <li <?php if ($this->uri->segment(1) == 'freelance-hire' && $this->uri->segment(2) == 'freelancer-save') { ?> class="active" <?php } ?>><a title="Saved Freelancer" class="padding_less_right" href="javascript:void(0);" onclick="register_profile();">Saved</a>
                                                        </li>

                                                    </ul>
                                                </div>
                                            </div>
                                        </div> 
																				
                                    </div>
									<?php $this->load->view('right_add_box'); ?>
									<?php echo $left_footer; ?>
                                    
                                </div>

                            </div>
                            <?php

                            function text2link($text) {
                                $text = preg_replace('/(((f|ht){1}t(p|ps){1}:\/\/)[-a-zA-Z0-9@:%_\+.~#?&\/\/=]+)/i', '<a href="\\1" target="_blank" rel="nofollow">\\1</a>', $text);
                                $text = preg_replace('/([[:space:]()[{}])(www.[-a-zA-Z0-9@:%_\+.~#?&\/\/=]+)/i', '\\1<a href="http://\\2" target="_blank" rel="nofollow">\\2</a>', $text);
                                $text = preg_replace('/([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})/i', '<a href="mailto:\\1" rel="nofollow" target="_blank">\\1</a>', $text);
                                return $text;
                            }
                            ?>      



                            <?php
                            if (count($postdata) > 0) {
                                foreach ($postdata as $post) {
                                    $post_date_txt = $post['created_date'];
                                    $post_last_date_txt = $post['post_last_date'];
                                    $post_name_txt = $post['post_name'];
                                    $date1=date_create(date('y-m-d'));
                                    $date2=date_create($post_last_date_txt);
                                    $diff=date_diff($date1,$date2);
                                    $remail_days = $diff->format("%r%a");
                                    ?>
                                    <div class="inner-right-part">
										<div class="tab-add">
											<?php $this->load->view('banner_add'); ?>
										</div>
                                        <div class="page-title">
                                            <h1 class="cat-title">
                                                <?php
                                                echo $postdata[0]['post_name'];
                                                ?>
                                            </h1>
                                        </div>
                                        <div class="all-job-box job-detail">
                                            <div class="all-job-top">
                                                <div class="job-top-detail free-apply-img">
                                                    <h5><a href="javascript:void(0);" onclick="register_profile();"><?php echo $post['post_name']; ?></a></h5>

                                                    <?php
                                                    $firstname = $this->db->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->fullname;
                                                    $lastname = $this->db->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->username;
                                                    ?>
                                                    <p>
                                                        <a href="javascript:void(0);" onclick="register_profile();"><?php echo ucfirst(strtolower($firstname)) . ' ' . ucfirst(strtolower($lastname)); ?></a></a></p>
                                                    <p class="loca-exp">
                                                        <span class="location">
                                                            <?php $city = $this->db->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->city; ?>
                                                            <?php $country = $this->db->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->country; ?>

                                                            <?php          
                                                            $cityObj = $this->db->get_where('cities', array('city_id' => $city))->row();
                                                            $statename = $statename_txt = $this->db->get_where('states', array('state_id' => $cityObj->state_id))->row()->state_name;
                                                            $cityname = $cityname_txt = $cityObj->city_name;
                                                            $countryname = $countryname_txt = $this->db->get_where('countries', array('country_id' => $country))->row()->country_name;
                                                            ?>
                                                            <span>

                                                                <?php
                                                                if ($cityname || $countryname) {
                                                                    if ($cityname) {
                                                                        echo $cityname . ', ';
                                                                    }
                                                                    echo $countryname . " (Location)";
                                                                }
                                                                ?>
                                                            </span>
                                                        </span>
                                                    </p>
                                                    <p class="loca-exp">
                                                        <span class="exp">
                                                            <span>
                                                                <?php
                                                                $post_exp_year_txt = "";
                                                                if ($post['post_exp_month'] || $post['post_exp_year']) {
                                                                    if ($post['post_exp_year']) {
                                                                        $post_exp_year_txt .= $post['post_exp_year'];
                                                                    }
                                                                    if ($post['post_exp_month']) {
                                                                        if ($post['post_exp_year'] == '' || $post['post_exp_year'] == '0') {
                                                                            $post_exp_year_txt .= 0;
                                                                        }
                                                                        $post_exp_year_txt .= ".";
                                                                        $post_exp_year_txt .= $post['post_exp_month'];
                                                                    }
                                                                    $post_exp_year_txt .= " Year";
                                                                    echo $post_exp_year_txt." (Required Experience)";
                                                                }
                                                                ?> 
                                                            </span>
                                                        </span>
                                                    </p>
                                                    
                                                        <?php
                                                        if($remail_days < 0)
                                                        { ?>
                                                        <p class="pull-right job-top-btn">
                                                        <a href="javascript:void(0);" class="job-expired">
                                                            <img src="<?php echo base_url('assets/n-images/close-job.png'); ?>">Closed</a>
                                                        </p>
                                                        <?php
                                                        }
                                                        else
                                                        {?>
                                                        <p class="pull-right job-bottom-btn">
                                                            <a href="javascript:void(0);" onClick="create_profile_apply(<?php echo $post['post_id']; ?>)" class= "applypost  btn4"> Apply</a>
                                                        </p>
                                                        <?php } ?>
                                                </div>
                                            </div>
                                            <div class="detail-discription">
                                                <div class="all-job-middle">
                                                    <ul>
                                                        <li>
                                                            <b>Project description</b>
                                                            <span>
                                                                <pre><?php echo $post_description = $this->common->make_links($post['post_description']); ?></pre>
                                                            </span>
                                                        </li>
                                                        <li>
                                                            <b>Key skill</b>
                                                            <span>
                                                            <?php
                                                                $comma = " , ";
                                                                $k = 0;
                                                                $aud = $post['post_skill'];
                                                                $aud_res = explode(',', $aud);
                                                                $skills_txt = "";
                                                                if (!$post['post_skill']) {
                                                                    $skills_txt = $post['post_other_skill'];
                                                                } else if (!$post['post_other_skill']) {
                                                                    foreach ($aud_res as $skill) {
                                                                        if ($k != 0) {
                                                                            $skills_txt .= $comma;
                                                                        }
                                                                        $skills_txt .= $this->db->get_where('skill', array('skill_id' => $skill))->row()->skill;
                                                                        $k++;
                                                                    }
                                                                } else if ($post['post_skill'] && $post['post_other_skill']) {

                                                                    foreach ($aud_res as $skill) {
                                                                        if ($k != 0) {
                                                                            $skills_txt .= $comma;
                                                                        }
                                                                        $skills_txt .= $this->db->get_where('skill', array('skill_id' => $skill))->row()->skill;
                                                                        $k++;
                                                                    } 
                                                                    $skills_txt .= "," . $post['post_other_skill'];
                                                                }
                                                                echo $skills_txt;
                                                                ?>
                                                            </span>
                                                        </li>
                                                        <li><b>Field of Requirements</b>
                                                            <span> 
                                                                <?php
                                                                $cat_arr = $this->db->get_where('category', array('category_id' => $post['post_field_req']))->row();
                                                                echo $category_txt = $cat_arr->category_name;
                                                                $category_slug = $cat_arr->category_slug; ?>
                                                            </span>
                                                        </li>
                                                        <li><b>Rate</b>
                                                            <span>
                                                                <?php
                                                                $post_rate_txt = "";
                                                                $currency_name_txt = "";
                                                                $post_rate_type_txt = "";

                                                                if ($post['post_rate']) {
                                                                    $post_rate_txt = $post['post_rate'];
                                                                    echo "&nbsp";
                                                                    $currency_name_txt = $this->db->get_where('currency', array('currency_id' => $post['post_currency']))->row()->currency_name;
                                                                    echo "&nbsp";
                                                                    if ($post['post_rating_type'] == '0') {
                                                                        $post_rate_type_txt = "Hourly";
                                                                    } else if ($post['post_rating_type'] == '1') {
                                                                        $post_rate_type_txt = "Fixed";
                                                                    }
                                                                    echo $post_rate_txt."&nbsp".$currency_name_txt."&nbsp".$post_rate_type_txt;
                                                                } else {
                                                                    echo PROFILENA;
                                                                }
                                                                ?>
                                                            </span>
                                                        </li>

                                                        <li><b>Estimated Time</b>
                                                            <span>
                                                                <?php
                                                                if ($post['post_est_time']) {
                                                                    echo $post['post_est_time'];
                                                                } else {
                                                                    echo PROFILENA;
                                                                }
                                                                ?>   
                                                            </span>
                                                        </li>

                                                    </ul>
                                                </div>
                                                <div class="all-job-bottom">
                                                    <span class="job-post-date"><b>Posted on:  </b><?php echo date('d-M-Y', strtotime($post['created_date'])); ?></span>
                                                    <p class="pull-right">
                                                        <?php
                                                        if($remail_days < 0)
                                                        { ?>
                                                        <a href="javascript:void(0);" class="job-expired">
                                                            <img src="<?php echo base_url('assets/n-images/close-job.png'); ?>">Closed</a>
                                                        <?php
                                                        }
                                                        else
                                                        { ?>
                                                        <a href="javascript:void(0);" onClick="create_profile_apply(<?php echo $post['post_id']; ?>)" class= "applypost btn4"> Apply</a>
                                                    <?php } ?>
                                                    </p>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- sortlisted employe -->

                                        <?php if ($shortlist) {
                                            ?>
                                            <div class="sort-emp-mainbox">
                                                <h3>
                                                    Shortlisted Freelancer
                                                </h3>

                                                <div class="sort-emp">
                                                    <?php foreach ($shortlist as $user) { ?>
                                                        <div class="sort-emp-box">
                                                            <div class="sort-emp-img">
                                                                <?php
                                                                $fname = $user['freelancer_post_fullname'];
                                                                $lname = $user['freelancer_post_username'];
                                                                $sub_fname = substr($fname, 0, 1);
                                                                $sub_lname = substr($lname, 0, 1);
                                                                if ($user['freelancer_post_user_image']) {
                                                                    if (IMAGEPATHFROM == 'upload') {
                                                                        if (!file_exists($this->config->item('free_post_profile_main_upload_path') . $user['freelancer_post_user_image'])) {
                                                                            ?>
                                                                            <div class="post-img-user">
                                                                                <?php echo ucfirst(strtolower($sub_fname)) . ucfirst(strtolower($sub_lname)); ?>
                                                                            </div>
                                                                        <?php } ?>
                                                                        <img src="<?php echo FREE_POST_PROFILE_THUMB_UPLOAD_URL . $user['freelancer_post_user_image']; ?>" alt="<?php echo $user['freelancer_post_fullname'] . " " . $user['freelancer_post_username']; ?>" >
                                                                        <?php
                                                                    } else {
                                                                        $filename = $this->config->item('free_post_profile_main_upload_path') . $user['freelancer_post_user_image'];
                                                                        $s3 = new S3(awsAccessKey, awsSecretKey);
                                                                        $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                                                        if ($info) {
                                                                            ?>
                                                                            <img src="<?php echo FREE_POST_PROFILE_THUMB_UPLOAD_URL . $user['freelancer_post_user_image']; ?>" alt="<?php echo $user['freelancer_post_fullname'] . " " . $user['freelancer_post_username']; ?>" >
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
                                                            </div>
                                                            <div class="sort-emp-detail">
                                                                <div><a><?php echo $user['freelancer_post_fullname'] . " " . $user['freelancer_post_username']; ?></a></div>
                                                                <p><?php
                                                                    if ($user['designation']) {
                                                                        echo $user['designation'];
                                                                    } else {
                                                                        echo "Designation";
                                                                    }
                                                                    ?></p>
                                                            </div>
                                                            <!--                                                        <div class="sort-emp-msg">
                                                                                                                        <a href="javascript:void(0);" class="">Message</a>
                                                                                                                    </div>-->
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        
											<div class="banner-add">
                                                <?php $this->load->view('banner_add'); ?>
                                            </div>
                                    </div>
                                    <!-- end sortlisted employe -->

                                    <?php
                                }
                            } else {
                                ?>
                                <div class="inner-right-part cust-border">
                                    <div class="art-img-nn">
                                        <div class="art_no_post_img">
                                            <img alt="No Projects" src="<?php echo base_url() . 'assets/img/job-no.png' ?>">

                                        </div>
                                        <div class="art_no_post_text">
                                            No  Projects Available.
                                        </div>
										
                                    </div>
									
                                </div>
                            <?php } ?>

							



                            <!--recommen candidate start-->
                            <?php if (count($recommandedpost) > 0) { ?>
                                <div class="inner-right-part">
                                    <div class="page-title">
                                        <h3>
                                            Recommended Project
                                        </h3>
                                    </div>

                                    <?php
                                    foreach ($recommandedpost as $post) {
                                        ?>
                                        <div class="all-job-box job-detail">
                                            <div class="all-job-top">
                                                <div class="job-top-detail">
                                                    <h5><a href="javascript:void(0);" onclick="register_profile();"><?php echo $post['post_name']; ?></a></h5>

                                                    <?php
                                                    $firstname = $this->db->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->fullname;
                                                    $lastname = $this->db->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->username;
                                                    ?>
                                                    <p>
                                                        <a href="javascript:void(0);" onclick="register_profile();"><?php echo ucfirst(strtolower($firstname)) . ' ' . ucfirst(strtolower($lastname)); ?></a>

                                                    </p>
                                                    <p class="loca-exp">
                                                        <span class="location">
                                                            <?php $city = $this->db->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->city; ?>
                                                            <?php $country = $this->db->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->country; ?>

                                                            <?php
                                                            $cityObj = $this->db->get_where('cities', array('city_id' => $city))->row();
                                                            $statename = $this->db->get_where('states', array('state_id' => $cityObj->state_id))->row()->state_name;
                                                            $cityname = $cityObj->city_name;
                                                            $countryname = $this->db->get_where('countries', array('country_id' => $country))->row()->country_name;
                                                            ?>
                                                            <span>

                                                                <?php
                                                                if ($cityname || $countryname) {
                                                                    if ($cityname) {
                                                                        echo $cityname . ', ';
                                                                    }
                                                                    echo $countryname . " (Location)";
                                                                }
                                                                ?>
                                                            </span>
                                                        </span>
                                                    </p>
                                                    <p class="loca-exp">
                                                        <span class="exp">
                                                            <span>

                                                                <?php
                                                                if ($post['post_exp_month'] || $post['post_exp_year']) {
                                                                    if ($post['post_exp_year']) {
                                                                        echo $post['post_exp_year'];
                                                                    }
                                                                    if ($post['post_exp_month']) {
                                                                        if ($post['post_exp_year'] == '' || $post['post_exp_year'] == '0') {
                                                                            echo 0;
                                                                        }
                                                                        echo ".";
                                                                        echo $post['post_exp_month'];
                                                                    }
                                                                    echo " Year" . " (Required Experience)";
                                                                }
                                                                ?> 
                                                            </span>
                                                        </span>
                                                    </p>
                                                    <p class="pull-right job-top-btn">
                                                        <a href="javascript:void(0);" onClick="create_profile_apply(<?php echo $post['post_id']; ?>)" class= "applypost  btn4"> Apply</a>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="detail-discription">
                                                <div class="all-job-middle">
                                                    <ul>
                                                        <li>
                                                            <b>Project description</b>
                                                            <span>
                                                                <pre><?php echo $this->common->make_links($post['post_description']); ?></pre>
                                                            </span>
                                                        </li>
                                                        <li>
                                                            <b>Key skill</b>
                                                            <span>  <?php
                                                                $comma = " , ";
                                                                $k = 0;
                                                                $aud = $post['post_skill'];
                                                                $aud_res = explode(',', $aud);

                                                                if (!$post['post_skill']) {

                                                                    echo $post['post_other_skill'];
                                                                } else if (!$post['post_other_skill']) {
                                                                    foreach ($aud_res as $skill) {
                                                                        if ($k != 0) {
                                                                            echo $comma;
                                                                        }
                                                                        $cache_time = $this->db->get_where('skill', array('skill_id' => $skill))->row()->skill;
                                                                        echo $cache_time;
                                                                        $k++;
                                                                    }
                                                                } else if ($post['post_skill'] && $post['post_other_skill']) {

                                                                    foreach ($aud_res as $skill) {
                                                                        if ($k != 0) {
                                                                            echo $comma;
                                                                        }
                                                                        $cache_time = $this->db->get_where('skill', array('skill_id' => $skill))->row()->skill;
                                                                        echo $cache_time;
                                                                        $k++;
                                                                    } echo "," . $post['post_other_skill'];
                                                                }
                                                                ?>     

                                                            </span>
                                                        </li>
                                                        <li><b>Field of Requirements</b>
                                                            <span> 
                                                                <?php echo $this->db->get_where('category', array('category_id' => $post['post_field_req']))->row()->category_name; ?>
                                                            </span>
                                                        </li>
                                                        <li><b>Rate</b>
                                                            <span>  <?php
                                                                if ($post['post_rate']) {
                                                                    echo $post['post_rate'];
                                                                    echo "&nbsp";
                                                                    echo $this->db->get_where('currency', array('currency_id' => $post['post_currency']))->row()->currency_name;
                                                                    echo "&nbsp";

                                                                    if ($post['post_rating_type'] == '0') {
                                                                        echo "Hourly";
                                                                    } else if ($post['post_rating_type'] == '1') {
                                                                        echo "Fixed";
                                                                    }
                                                                } else {
                                                                    echo PROFILENA;
                                                                }
                                                                ?>
                                                            </span>
                                                        </li>

                                                        <li><b>Estimated Time</b>
                                                            <span>
                                                                <?php
                                                                if ($post['post_est_time']) {
                                                                    echo $post['post_est_time'];
                                                                } else {
                                                                    echo PROFILENA;
                                                                }
                                                                ?>   
                                                            </span>
                                                        </li>

                                                    </ul>
                                                </div>
                                                <div class="all-job-bottom">
                                                    <span class="job-post-date"><b>Posted on:  </b><?php echo date('d-M-Y', strtotime($post['created_date'])); ?></span>
                                                    <p class="pull-right">
                                                        <a href="javascript:void(0);" onClick="create_profile_apply(<?php echo $post['post_id']; ?>)" class= "applypost  button"> Apply</a>
                                                    </p>

                                                </div>
                                            </div>
                                        </div>
										
                                    <?php }
                                    ?>
									
                                </div>

                            <?php } ?>
							

                        </div>
                    </div>

            </section>
            <!-- Model Popup Open -->
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

            <!--footer>        
            <?php //echo $footer;     ?>
            </footer-->
        </div>
		<?php $this->load->view('mobile_side_slide'); ?>
        <!-- script for skill textbox automatic start-->
       
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
        <script  src="<?php echo base_url('assets/js/croppie.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()) ?>"></script>
            
        <script>
            var get_csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
            var csrf_hash = '<?php echo $this->security->get_csrf_hash(); ?>';
            var base_url = '<?php echo base_url(); ?>';
            var skill = '<?php echo $this->input->get('skills'); ?>';
            var place = '<?php echo $this->input->get('searchplace'); ?>';
            $('#main_loader').hide();
            // $('#main_page_load').show();
            $('body').removeClass("body-loader");
        </script>
        <?php
        /*if (IS_APPLY_JS_MINIFY == '0') {
            ?>
            <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-hire/project_live_login.js?ver=' . time()); ?>"></script>
            <?php
        } else {
            ?>
            <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/freelancer-hire/project_live_login.js?ver=' . time()); ?>"></script>
        <?php }*/ ?>
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-hire/project_live_login.js?ver=' . time()); ?>"></script>

        <?php
        if($remail_days < 0)
        {
        }
        else{ ?>
        <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "JobPosting",
            "title": "<?php echo $post_name_txt; ?>",
            "description": " Description: <?php echo addslashes($post_description); ?>",
            "skills": "<?php echo addslashes($skills_txt); ?>",
            "industry": "<?php echo addslashes($category_txt); ?>",
            "experienceRequirements": "<?php echo $post_exp_year_txt; ?>",
            "employmentType": "OTHER",
            "baseSalary": {
                "@type": "MonetaryAmount",
                "currency": "<?php echo substr($currency_name_txt,0,3); ?>",
                "value": {
                    "@type": "QuantitativeValue",
                    "value": <?php echo ($post_rate_txt != "" ? $post_rate_txt : '""'); ?>,
                    "unitText": "<?php echo strtoupper($post_rate_type_txt); ?>"
                }
            },
            "datePosted": "<?php echo date('Y-m-d', strtotime($post_date_txt)); ?>",
            "validThrough": "<?php echo date('Y-m-d', strtotime($post_last_date_txt)); ?>",
            "jobLocation": {
                "@type": "Place",
                "address": {
                    "@type": "PostalAddress",
                    "addressLocality": "<?php echo $cityname_txt; ?>",
                    "addressRegion": "<?php echo $statename_txt; ?>",
                    "addressCountry": "<?php echo $countryname_txt; ?>"
                },
                "additionalProperty": {
                    "@type": "PropertyValue",
                    "value": "TELECOMMUTE"
                }
            },
            "hiringOrganization": {
                "@type": "Organization",
                "name": "<?php echo ucfirst(strtolower($firstname)) . ' ' . ucfirst(strtolower($lastname)); ?>"
            }
        } 
        </script>
        <?php if($this->session->userdata('aileenuser') == ""): ?>
        <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "BreadcrumbList",
            "itemListElement":
            [
                {
                    "@type": "ListItem",
                    "position": 1,
                    "item":
                    {
                        "@id": "<?php echo base_url(); ?>",
                        "name": "Aileensoul"
                    }
                },
                {
                    "@type": "ListItem",
                    "position": 2,
                    "item":
                    {
                        "@id": "<?php echo base_url('freelance-jobs'); ?>",
                        "name": "Freelance Jobs"
                    }
                },               
                {
                    "@type": "ListItem",
                    "position": 3,
                    "item":
                    {
                        "@id": "<?php echo base_url('freelance-jobs-by-fields'); ?>",
                        "name": "Freelance Jobs by Field"
                    }
                },               
                {
                    "@type": "ListItem",
                    "position": 4,
                    "item":
                    {
                        "@id": "<?php echo base_url().'freelance-jobs/'.$category_slug; ?>",
                        "name": "Freelance <?php echo addslashes($category_txt); ?> Jobs"
                    }
                },               
                {
                    "@type": "ListItem",
                    "position": 5,
                    "item":
                    {
                        "@id": "<?php echo current_url(); ?>",
                        "name": "<?php echo $post_name_txt; ?>"
                    }
                }
            ]
        }
        </script>
        <?php endif; ?>
    <?php } ?>
    </body>
</html>