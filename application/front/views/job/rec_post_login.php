<!DOCTYPE html>
<html>
    <head>
        <title><?php echo ucwords($title); ?></title>
        <meta name="description" content="<?php echo $metadesc; ?>" />
        <!-- start head -->
        <?php echo $head; ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <!-- END HEAD -->


        <?php
        if (IS_REC_CSS_MINIFY == '0') {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css'); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css'); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/recruiter.css'); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css'); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css'); ?>">
            <?php
        } else {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css'); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/style-main.css'); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/recruiter.css'); ?>">
			<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css'); ?>">
			<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css'); ?>">
        <?php } ?>
    <?php $this->load->view('adsense'); ?>
</head>
    <!-- END HEAD -->
  
    <body class="page-container-bg-solid detail-job-no-login page-boxed no-login freeh3 cust-job-width paddnone cus-error body-loader">
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
								<li class="hidden-991"><a href="<?php echo base_url('registration'); ?>" class="btn3">Create an account</a></li>
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
                <div class="container padding-360 mobp0 mt15">
                    <div class="row4">

                        <div class="profile-box-custom fl animated fadeInLeftBig left_side_posrt" style="position: absolute !important;"><div class="">

                                <div class="full-box-module">   
                                    <div class="profile-boxProfileCard  module">
                                        <div class="profile-boxProfileCard-cover"> 
                                            <a class="profile-boxProfileCard-bg u-bgUserColor a-block" href="javascript:void(0);" onclick="register_profile();" tabindex="-1" 
                                               aria-hidden="true" rel="noopener">
                                                <div class="bg-images no-cover-upload"> 
                                                    <?php
                                                    $image_ori = $recdata[0]['profile_background'];
                                                    $filename = $this->config->item('rec_bg_main_upload_path') . $recdata[0]['profile_background'];
                                                    $s3 = new S3(awsAccessKey, awsSecretKey);
                                                    $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                                    if ($info && $recdata[0]['profile_background'] != '') {
                                                        ?>
                                                        <img src = "<?php echo REC_BG_MAIN_UPLOAD_URL . $recdata[0]['profile_background']; ?>" name="image_src" id="image_src" alt='<?php echo $recdata[0]['profile_background']; ?>'/>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <img src="<?php echo base_url(WHITEIMAGE); ?>" class="bgImage" alt="<?php echo $recdata[0]['rec_firstname'] . ' ' . $recdata[0]['rec_lastname']; ?>" >
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="profile-boxProfileCard-content clearfix">
                                            <div class="left_side_box_img buisness-profile-txext">

                                                <a class="profile-boxProfilebuisness-avatarLink2 a-inlineBlock"  href="javascript:void(0);" onclick="register_profile();" title="<?php echo $recdata[0]['rec_firstname'] . ' ' . $recdata[0]['rec_lastname']; ?>" tabindex="-1" aria-hidden="true" rel="noopener">
                                                    <?php
                                                    $filename = $this->config->item('rec_profile_thumb_upload_path') . $recdata[0]['recruiter_user_image'];
                                                    $s3 = new S3(awsAccessKey, awsSecretKey);
                                                    $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                                    if ($recdata[0]['recruiter_user_image'] != '' && $info) {
                                                        ?>
                                                        <img src="<?php echo REC_PROFILE_THUMB_UPLOAD_URL . $recdata[0]['recruiter_user_image']; ?>" alt="<?php echo $recdata[0]['recruiter_user_image']; ?>" >
                                                        <?php
                                                    } else {


                                                        $a = $recdata[0]['rec_firstname'];
                                                        $acr = substr($a, 0, 1);

                                                        $b = $recdata[0]['rec_lastname'];
                                                        $acr1 = substr($b, 0, 1);
                                                        ?>
                                                        <div class="post-img-profile">
                                                            <?php echo ucfirst(strtolower($acr)) . ucfirst(strtolower($acr1)); ?>

                                                        </div>

                                                        <?php
                                                    }
                                                    ?>
                                                </a>
                                            </div>
                                            <div class="right_left_box_design ">
                                                <span class="profile-company-name ">
                                                    <a href="javascript:void(0);" onclick="register_profile();" title="<?php echo ucfirst(strtolower($recdata['rec_firstname'])) . ' ' . ucfirst(strtolower($recdata['rec_lastname'])); ?>">   <?php echo ucfirst(strtolower($recdata[0]['rec_firstname'])) . ' ' . ucfirst(strtolower($recdata[0]['rec_lastname'])); ?></a>
                                                </span>

                                                <div class="profile-boxProfile-name">
                                                    <a href="javascript:void(0);" onclick="register_profile();" title="<?php echo ucfirst(strtolower($recdata[0]['designation'])); ?>">
                                                        <?php
                                                        if (ucfirst(strtolower($recdata[0]['designation']))) {
                                                            echo ucfirst(strtolower($recdata[0]['designation']));
                                                        } else {
                                                            echo "Designation";
                                                        }
                                                        ?></a>
                                                </div>
                                                <ul class=" left_box_menubar">
                                                    <li <?php if ($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'profile') { ?> class="active" <?php } ?>><a class="padding_less_left" title="Details" href="javascript:void(0);" onclick="register_profile();"> Details</a>
                                                    </li>                                
                                                    <li id="rec_post_home" <?php if ($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'post') { ?> class="active" <?php } ?>><a title="Post" href="javascript:void(0);" onclick="register_profile();">Post</a>
                                                    </li>
                                                    <li <?php if ($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'save-candidate') { ?> class="active" <?php } ?>><a title="Saved Candidate" class="padding_less_right" href="javascript:void(0);" onclick="register_profile();">Saved </a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>
                                    </div>                             
                                </div>
                                <?php if ($_GET['page'] == all_jobs) { ?>
                                    
                                <?php } ?>

                                
                            <div id="hideuserlist" class=" fixed_right_display animated fadeInRightBig"> 

                                
                            </div>
							<?php $this->load->view('right_add_box'); ?>
							<?php echo $left_footer; ?>
							
                                



                            </div>

                        </div>

                       
                        <div class="inner-right-part">
                           <div class="tab-add">
								<?php $this->load->view('banner_add'); ?>
							</div>
                            <?php
                            if($postdata){ ?>
                                 <div class="page-title">
                                <h3>
                                    <?php
                                    $job_title_txt = "";
                                    $cache_time = $this->db->get_where('job_title', array('title_id' => $postdata[0]['post_name']))->row()->name;
                                    if ($cache_time) {
                                        $job_title_txt = $cache_time;
                                    } else {
                                        $job_title_txt = $postdata[0]['post_name'];
                                    }
                                    echo $job_title_txt;
                                    ?>
                                </h3>
                            </div>
                            <?php
                                foreach ($postdata as $post) {
                                    $post_last_date_txt = $post['post_last_date'];
                                    $comp_name_txt = $post['re_comp_name'];
                                    $date1=date_create(date('y-m-d'));
                                    $date2=date_create($post_last_date_txt);
                                    $diff=date_diff($date1,$date2);
                                    $remail_days = $diff->format("%r%a");
                                ?>
                                <div class="all-job-box job-detail">
                                    <div class="all-job-top">
                                        <div class="post-img">
                                            <a title="<?php echo $post['re_comp_name']; ?>">
                                                <?php
                                                $cache_time = $this->db->get_where('recruiter', array(
                                                            'user_id' => $post['user_id']
                                                        ))->row()->comp_logo;
                                                
                                               if ($cache_time) {
                                                    if (IMAGEPATHFROM == 'upload') {
                                                        if (!file_exists($this->config->item('rec_profile_thumb_upload_path') . $cache_time)) { 
                                                            ?>
                                                <img src="<?php echo  base_url('assets/images/commen-img.png') ?>" title="commonimage">
                                                   <?php     } else { ?>
                                                           <img src="<?php echo REC_PROFILE_THUMB_UPLOAD_URL . $cache_time ?>" title="<?php echo $cache_time; ?>">
                                                       <?php  }
                                                    } else {
                                                        $filename = $this->config->item('rec_profile_thumb_upload_path') . $cache_time;
                                                        $s3 = new S3(awsAccessKey, awsSecretKey);
                                                        $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                                        if ($info) { ?>
                                                           <img src="<?php echo  REC_PROFILE_THUMB_UPLOAD_URL . $cache_time ?>" title="<?php echo $cache_time; ?>">
                                                         <?php } else { ?>
                                                          <img src="<?php echo base_url('assets/images/commen-img.png') ?>" title="commonimage">
                                                       <?php  }
                                                    }
                                                } else { ?>
                                                    <img src="<?php echo base_url('assets/images/commen-img.png') ?>" title="commonimage">
                                                <?php } ?>
                                            </a>
                                        </div>
                                        <div class="job-top-detail">
                                            <?php
                                            $cache_time1 = $this->db->get_where('job_title', array('title_id' => $post['post_name']))->row()->name;
                                            if ($cache_time1) {
                                                $cache_time1;
                                            } else {
                                                $cache_time1 = $post['post_name'];
                                            }
                                            ?>
                                            <h5><a href="javascript:void(0);" onclick="register_profile();" title="<?php echo $cache_time1; ?>"><?php echo $cache_time1; ?></a></h5>  
                                            <p><a href="javascript:void(0);" onclick="register_profile();" title="<?php echo $post['re_comp_name']; ?>">
                                                    <?php
                                                    $out = strlen($post['re_comp_name']) > 40 ? substr($post['re_comp_name'], 0, 40) . "..." : $post['re_comp_name'];
                                                    echo $out;
                                                    ?>
                                                </a>
                                            </p>
                                            <p><a href="javascript:void(0);" onclick="register_profile();" title="<?php echo ucfirst(strtolower($post['rec_firstname'])) . ' ' . ucfirst(strtolower($post['rec_lastname'])); ?>"><?php echo ucfirst(strtolower($post['rec_firstname'])) . ' ' . ucfirst(strtolower($post['rec_lastname'])); ?></a></p>
                                            <p class="loca-exp">
                                                <span class="location">
                                                    <?php
                                                    $cityname_txt = $cityname = $this->db->get_where('cities', array('city_id' => $post['city']))->row()->city_name;
                                                    $statename_txt = $statename = $this->db->get_where('states', array('state_id' => $post['state']))->row()->state_name;
                                                    $countryname_txt = $countryname = $this->db->get_where('countries', array('country_id' => $post['country']))->row()->country_name;
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
                                                        $exp_txt = "";
                                                        if (($post['min_year'] != '0' || $post['max_year'] != '0') && ($post['fresher'] == 1)) {
                                                            $exp_txt = $post['min_year'] . ' Year - ' . $post['max_year'] . ' Year' . " (Required Experience) " . "(Fresher can also apply).";
                                                        } else if (($post['min_year'] != '0' || $post['max_year'] != '0')) {
                                                            $exp_txt = $post['min_year'] . ' Year - ' . $post['max_year'] . ' Year' . " (Required Experience) ";
                                                        } else {
                                                            $exp_txt = "Fresher";
                                                        }
                                                        echo $exp_txt;
                                                        ?>
                                                    </span>
                                                </span>
                                            </p>                                            
                                                <!-- <a href="javascript:void(0);"  onClick="create_profile_apply(<?php echo $post['post_id']; ?>)" class= "applypost  btn4">Save</a> -->
                                                <?php
                                                if($remail_days < 0)
                                                { ?>
                                                    <p class="pull-right job-top-btn">
                                                        <a href="javascript:void(0);" class="job-expired"><img src="<?php echo base_url() . 'assets/n-images/close-job.png'; ?>">Closed</a>
                                                    </p>
                                                <?php
                                                }
                                                else{ ?>
                                                    <p class="pull-right job-bottom-btn">
                                                        <a href="javascript:void(0);"  onClick="create_profile_apply(<?php echo $post['post_id']; ?>)" class= "applypost  btn4">Apply</a>
                                                    </p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="detail-discription">
                                        <div class="all-job-middle">
                                            <ul>
                                                <li>
                                                    <b>Job description</b>
                                                    <span>
                                                        <pre><?php echo $this->common->make_links($post['post_description']); ?></pre>
                                                    </span>
                                                </li>
                                                <li>
                                                    <b>Key skill</b>
                                                    <span>
                                                    <?php
                                                    $comma = ", ";
                                                    $k = 0;
                                                    $aud = $post['post_skill'];
                                                    $aud_res = explode(',', $aud);
                                                    $skill_txt = "";
                                                    if (!$post['post_skill']) {
                                                        $skill_txt = $post['other_skill'];
                                                    } else if (!$post['other_skill']) {
                                                        foreach ($aud_res as $skill) {
                                                            $cache_time = $this->db->get_where('skill', array('skill_id' => $skill))->row()->skill;
                                                            if ($cache_time != " ") {
                                                                if ($k != 0) {
                                                                    $skill_txt .= $comma;
                                                                }
                                                                $skill_txt .= $cache_time;
                                                                $k++;
                                                            }
                                                        }
                                                    } else if ($post['post_skill'] && $post['other_skill']) {
                                                        foreach ($aud_res as $skill) {
                                                            if ($k != 0) {
                                                                $skill_txt = $comma;
                                                            }
                                                            $cache_time3 = $this->db->get_where('skill', array('skill_id' => $skill))->row()->skill;$skill_txt .= $cache_time3;
                                                            $k++;
                                                        }
                                                        $skill_txt .= "," . $post['other_skill'];
                                                    }
                                                    echo $skill_txt;
                                                    ?>  
                                                    </span>
                                                </li>
                                                <li><b>No of openings</b>
                                                    <span><?php echo $post['post_position']; ?>
                                                    </span>
                                                </li>
                                                <li><b>Industry</b>
                                                    <span> 
                                                        <?php
                                                        $cache_time4 = $this->db->get_where('job_industry', array('industry_id' => $post['industry_type']))->row()->industry_name;
                                                        echo $cache_time4;
                                                        ?>
                                                    </span>
                                                </li>
                                                <li><b>Required education</b>
                                                    <?php if ($post['degree_name'] != '' || $post['other_education'] != '') { ?>
                                                        <?php
                                                            $comma = ", ";
                                                            $k = 0;
                                                            $edu = $post['degree_name'];
                                                            $edu_nm = explode(',', $edu);
                                                            $edu_txt = "";
                                                            if (!$post['degree_name']) {
                                                                $edu_txt = $post['other_education'];
                                                            } else if (!$post['other_education']) {
                                                                foreach ($edu_nm as $edun) {
                                                                    if ($k != 0) {
                                                                        $edu_txt .= $comma;
                                                                    }
                                                                    $cache_time = $this->db->get_where('degree', array('degree_id' => $edun))->row()->degree_name;

                                                                    $edu_txt .= $cache_time;
                                                                    $k++;
                                                                }
                                                            } else if ($post['degree_name'] && $post['other_education']) {
                                                                foreach ($edu_nm as $edun) {
                                                                    if ($k != 0) {
                                                                        $edu_txt .=$comma;
                                                                    }
                                                                    $cache_time = $this->db->get_where('degree', array('degree_id' => $edun))->row()->degree_name;
                                                                    $edu_txt .= $cache_time;
                                                                    $k++;
                                                                }
                                                                $edu_txt .= "," . $post['other_education'];
                                                            }
                                                        } else { ?>
                                                        
                                                            <?php $edu_txt .= PROFILENA; ?>
                                                        
                                                    <?php } ?>
                                                    <span>
                                                    <?php echo $edu_txt; ?>
                                                    </span>
                                                </li>
                                                <li><b>Salary</b>
                                                    <span>
                                                        <?php
                                                            $currency_txt = $currency = $this->db->get_where('currency', array('currency_id' => $post['post_currency']))->row()->currency_name;
                                                            $min_sal_txt = "";
                                                            $max_sal_txt = "";
                                                            $salary_type_txt = "";
                                                            if ($post['min_sal'] || $post['max_sal']) {
                                                                $min_sal_txt = $post['min_sal'];
                                                                $max_sal_txt = $post['max_sal'];
                                                                $salary_type_txt = $post['salary_type'];
                                                            } else {
                                                                echo PROFILENA;
                                                            }
                                                            echo $min_sal_txt. " - " . $max_sal_txt. ' ' . $currency . ' ' . $salary_type_txt;
                                                            ?>
                                                        </span>
                                                </li>
                                                <li><b>Employment Type</b>
                                                    <span>
                                                        <?php if ($post['emp_type'] != '') { 
                                                            echo $this->common->make_links($post['emp_type']) . '  Job'; 
                                                            $emp_type_txt = $this->common->make_links($post['emp_type']); 
                                                            } else {
                                                                echo PROFILENA;
                                                            }
                                                        ?> 
                                                    </span>
                                                </li>
                                                <li><b>Interview Process</b>
                                                    <span>
                                                        <?php if ($post['interview_process'] != '') { ?>
                                                            <pre>
                                                                <?php echo $this->common->make_links($post['interview_process']); ?></pre>
                                                            <?php
                                                        } else {
                                                            echo PROFILENA;
                                                        }
                                                        ?> 
                                                    </span>
                                                </li>
                                                <li><b>Company profile</b>
                                                    <span>
                                                        <?php if ($post['re_comp_profile'] != '') { ?>
                                                            <pre>
                                                                <?php echo $this->common->make_links($post['re_comp_profile']); ?></pre>
                                                            <?php
                                                        } else {
                                                            echo PROFILENA;
                                                        }
                                                        ?> 
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="all-job-bottom">
                                            <span class="job-post-date"><b>Posted on: </b><?php echo date('d-M-Y', strtotime($post['created_date'])); ?></span>
                                            <p class="pull-right">
                                                 <!-- <a href="javascript:void(0);"  onClick="create_profile_apply(<?php echo $post['post_id']; ?>)" class= "applypost  btn4">Save</a> -->
                                                 <?php
                                                if($remail_days < 0)
                                                { ?>
                                                    <a href="javascript:void(0);" class="job-expired"><img src="<?php echo base_url() . 'assets/n-images/close-job.png'; ?>">Closed</a>
                                                <?php
                                                }
                                                else{ ?>
                                                <a href="javascript:void(0);"  onClick="create_profile_apply(<?php echo $post['post_id']; ?>)" class= "applypost  btn4">Apply</a>
                                                <?php } ?>
                                            </p>

                                        </div>
                                    </div>
									
								</div>
                                <?php
                            } } else {
                            ?>

                            
                            <div class="art_no_post_avl"><h3>Post</h3><div class="art-img-nn"><div class="art_no_post_img"><img src="<?php echo base_url() . 'assets/img/job-no.png';?>" alt="bui-no.png"></div><div class="art_no_post_text">No Post</div></div></div>
                            <?php } ?>
							
							<div class="banner-add">
								<?php $this->load->view('banner_add'); ?>
							</div>
                        </div>
						
                        
                        <!--recommen candidate start-->
                        <?php if (count($recommandedpost) > 0) { ?>
                            <div class="inner-right-part">
                                <div class="page-title">
                                    <h3>
                                        Recommended job
                                    </h3>
                                </div>
								
                                <?php
                                $counter = 1;
                                foreach ($recommandedpost as $post) {
                                    /*$post_last_date = $post['post_last_date'];
                                    $date3=date_create(date('y-m-d'));
                                    $date4=date_create($post_last_date);
                                    $diff1=date_diff($date3,$date4);
                                    $job_remail_days = $diff1->format("%r%a");*/
                                    ?>
                                    <div class="all-job-box job-detail">
                                        <div class="all-job-top">
                                            <div class="post-img">
                                                <a title="<?php echo $post['re_comp_name']; ?>">
                                                    
                                                    <?php
                                                $cache_time = $this->db->get_where('recruiter', array(
                                                            'user_id' => $post['user_id']
                                                        ))->row()->comp_logo;
                                                
                                               if ($cache_time) {
                                                    if (IMAGEPATHFROM == 'upload') {
                                                        if (!file_exists($this->config->item('rec_profile_thumb_upload_path') . $cache_time)) { 
                                                            ?>
                                                           <img src="<?php echo  base_url('assets/images/commen-img.png') ?>" title="commonimage">
                                                   <?php     } else { ?>
                                                           <img src="<?php echo REC_PROFILE_THUMB_UPLOAD_URL . $cache_time ?>" title="<?php echo $cache_time; ?>">
                                                       <?php  }
                                                    } else {
                                                        $filename = $this->config->item('rec_profile_thumb_upload_path') . $cache_time;
                                                        $s3 = new S3(awsAccessKey, awsSecretKey);
                                                        $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                                        if ($info) { ?>
                                                           <img src="<?php echo  REC_PROFILE_THUMB_UPLOAD_URL . $cache_time ?>" title="<?php echo $cache_time; ?>">
                                                         <?php } else { ?>
                                                          <img src="<?php echo base_url('assets/images/commen-img.png') ?>" title="commonimage">
                                                       <?php  }
                                                    }
                                                } else { ?>
                                                    <img src="<?php echo base_url('assets/images/commen-img.png') ?>" title="commonimage">
                                                <?php } ?>
                                                    
                                                </a>
                                            </div>
                                            <div class="job-top-detail">
                                                <?php
                                                $cache_time1 = $this->db->get_where('job_title', array('title_id' => $post['post_name']))->row()->name;
                                                if ($cache_time1) {
                                                    $cache_time1;
                                                } else {
                                                    $cache_time1 = $post['post_name'];
                                                }
                                                ?>
                                                <h5><a href="javascript:void(0);" onclick="register_profile();" title="<?php echo $cache_time1; ?>"><?php echo $cache_time1; ?></a></h5> 
                                                <p><a href="javascript:void(0);" onclick="register_profile();"<?php echo $post['re_comp_name'];?>>
                                                        <?php
                                                        $out = strlen($post['re_comp_name']) > 40 ? substr($post['re_comp_name'], 0, 40) . "..." : $post['re_comp_name'];
                                                        echo $out;
                                                        ?>
                                                    </a>
                                                </p>
                                                <p><a href="javascript:void(0);" onclick="register_profile();" title="<?php echo ucfirst(strtolower($post['rec_firstname'])) . ' ' . ucfirst(strtolower($post['rec_lastname'])); ?>"><?php echo ucfirst(strtolower($post['rec_firstname'])) . ' ' . ucfirst(strtolower($post['rec_lastname'])); ?></a></p>
                                                <p class="loca-exp">
                                                    <span class="location">
                                                        <?php
                                                        $cityname = $this->db->get_where('cities', array('city_id' => $post['city']))->row()->city_name;
                                                        $countryname = $this->db->get_where('countries', array('country_id' => $post['country']))->row()->country_name;
                                                        ?>
                                                        <span><img class="pr5" src="<?php echo base_url('assets/images/location.png'); ?>" title="locationimage">
                                                            <?php
                                                            if ($cityname || $countryname) {
                                                                if ($cityname) {
                                                                    echo $cityname . ', ';
                                                                }
                                                                echo $countryname;
                                                            }
                                                            ?>
                                                        </span>
                                                    </span>
                                                </p>
                                                <p class="loca-exp">
                                                    <span class="exp">
                                                        <span><!-- <img class="pr5" src="<?php //echo base_url('assets/images/exp.png'); ?>" title="experienceimage">
                                                -->
                                                            <?php
                                                            if (($post['min_year'] != '0' || $post['max_year'] != '0') && ($post['fresher'] == 1)) {


                                                                echo $post['min_year'] . ' Year - ' . $post['max_year'] . ' Year' . " , " . "(Fresher can also apply).";
                                                            } else if (($post['min_year'] != '0' || $post['max_year'] != '0')) {
                                                                echo $post['min_year'] . ' Year - ' . $post['max_year'] . ' Year';
                                                            } else {
                                                                echo "Fresher";
                                                            }
                                                            ?>
                                                        </span>
                                                    </span>
                                                </p>
                                                <p class="pull-right job-top-btn">
                                                    <a href="javascript:void(0);"  onClick="create_profile_apply(<?php echo $post['post_id']; ?>)" class= "applypost  btn4">Apply</a>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="detail-discription">
                                            <div class="all-job-middle">
                                                <ul>
                                                    <li>
                                                        <b>Job discription</b>
                                                        <span>
                                                            <pre><?php echo $this->common->make_links($post['post_description']); ?></pre>
                                                        </span>
                                                    </li>
                                                    <li>
                                                        <b>Key skill</b>
                                                        <span>  <?php
                                                            $comma = ", ";
                                                            $k = 0;
                                                            $aud = $post['post_skill'];
                                                            $aud_res = explode(',', $aud);

                                                            if (!$post['post_skill']) {

                                                                echo $post['other_skill'];
                                                            } else if (!$post['other_skill']) {


                                                                foreach ($aud_res as $skill) {

                                                                    $cache_time = $this->db->get_where('skill', array('skill_id' => $skill))->row()->skill;

                                                                    if ($cache_time != " ") {
                                                                        if ($k != 0) {
                                                                            echo $comma;
                                                                        }echo $cache_time;
                                                                        $k++;
                                                                    }
                                                                }
                                                            } else if ($post['post_skill'] && $post['other_skill']) {
                                                                foreach ($aud_res as $skill) {
                                                                    if ($k != 0) {
                                                                        echo $comma;
                                                                    }
                                                                    $cache_time3 = $this->db->get_where('skill', array('skill_id' => $skill))->row()->skill;


                                                                    echo $cache_time3;
                                                                    $k++;
                                                                } echo "," . $post['other_skill'];
                                                            }
                                                            ?>  
                                                        </span>
                                                    </li>
                                                    <li><b>No of openings</b>
                                                        <span><?php echo $post['post_position']; ?>
                                                        </span>
                                                    </li>
                                                    <li><b>Industry</b>
                                                        <span> 
                                                            <?php
                                                            $industry_txt = $this->db->get_where('job_industry', array('industry_id' => $post['industry_type']))->row()->industry_name;
                                                            echo $industry_txt;
                                                            ?>
                                                        </span>
                                                    </li>
                                                    <li><b>Required education</b>
                                                        <?php if ($post['degree_name'] != '' || $post['other_education'] != '') { ?>
                                                            <span>
                                                                <?php
                                                                $comma = ", ";
                                                                $k = 0;
                                                                $edu = $post['degree_name'];
                                                                $edu_nm = explode(',', $edu);

                                                                if (!$post['degree_name']) {

                                                                    echo $post['other_education'];
                                                                } else if (!$post['other_education']) {


                                                                    foreach ($edu_nm as $edun) {
                                                                        if ($k != 0) {
                                                                            echo $comma;
                                                                        }
                                                                        $cache_time = $this->db->get_where('degree', array('degree_id' => $edun))->row()->degree_name;


                                                                        echo $cache_time;
                                                                        $k++;
                                                                    }
                                                                } else if ($post['degree_name'] && $post['other_education']) {
                                                                    foreach ($edu_nm as $edun) {
                                                                        if ($k != 0) {
                                                                            echo $comma;
                                                                        }
                                                                        $cache_time = $this->db->get_where('degree', array('degree_id' => $edun))->row()->degree_name;


                                                                        echo $cache_time;
                                                                        $k++;
                                                                    } echo "," . $post['other_education'];
                                                                }
                                                                ?>     

                                                            </span>
                                                        <?php } else { ?>
                                                            <span>
                                                                <?php echo PROFILENA; ?>
                                                            </span>
                                                        <?php } ?>
                                                    </li>
                                                    <li><b>Salary</b>
                                                        <span>
                                                            <?php
                                                            $currency = $this->db->get_where('currency', array('currency_id' => $post['post_currency']))->row()->currency_name;

                                                            if ($post['min_sal'] || $post['max_sal']) {
                                                                echo $post['min_sal'] . " - " . $post['max_sal'] . ' ' . $currency . ' ' . $post['salary_type'];
                                                            } else {
                                                                echo PROFILENA;
                                                            }
                                                            ?>
                                                            </span>
                                                    </li>
                                                    <li><b>Employment Type</b>
                                                        <span>
                                                            <?php 
                                                            $emp_type_txt = "";
                                                            if ($post['emp_type'] != '') { 
                                                                echo $this->common->make_links($post['emp_type']) . ' Job';
                                                                $emp_type_txt = $this->common->make_links($post['emp_type']);
                                                            } else {
                                                                echo $emp_type_txt = PROFILENA;
                                                            }?> 
                                                        </span>
                                                    </li>
                                                    <li><b>Interview Process</b>
                                                        <span>
                                                            <?php if ($post['interview_process'] != '') { ?>
                                                                <pre>
                                                                    <?php echo $this->common->make_links($post['interview_process']); ?></pre>
                                                                <?php
                                                            } else {
                                                                echo PROFILENA;
                                                            }
                                                            ?> 
                                                        </span>
                                                    </li>
                                                    <li><b>Company profile</b>
                                                        <span>
                                                            <?php if ($post['re_comp_profile'] != '') { ?>
                                                                <pre>
                                                                    <?php echo $this->common->make_links($post['re_comp_profile']); ?></pre>
                                                                <?php
                                                            } else {
                                                                echo PROFILENA;
                                                            }
                                                            ?> 
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="all-job-bottom">
                                                <span class="job-post-date"><b>Posted on:</b><?php echo date('d-M-Y', strtotime($post['created_date'])); ?></span>
                                                <p class="pull-right">
                                                    <a href="javascript:void(0);"  onClick="create_profile_apply(<?php echo $post['post_id']; ?>)" class= "applypost  btn4">Apply</a>
                                                </p>

                                            </div>
                                        </div>
										<!-- <div class="banner-add">
										<?php //$this->load->view('banner_add'); ?>
                                        </div> -->
                                    </div>
                                    <?php
                                    if($counter % 2 == 0)
                                    {
                                    ?>
                                    <div class="banner-add">
                                        <?php $this->load->view('infeed_add'); ?>
                                    </div>
                                    <?php
                                    }
                                    $counter ++;
                                }
                                ?>
                                <div class="banner-add">
                                    <?php $this->load->view('banner_add'); ?>
                                </div>
                            </div>
                        <?php } ?>
                        <!--recommen candidate end-->

                    </div>
                </div>
            </div>
        </section>
    </div>
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
		<?php $this->load->view('mobile_side_slide'); ?>
        <!--footer>        
        <?php //echo $footer;    ?>
        </footer-->

        <!-- Login  -->
        <div class="modal fade login" id="login" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content login-frm">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <div class="right-main">
                            <div class="right-main-inner">
                                <div class="">
                                    <div class="title">
                                        <h1 class="ttc">Welcome To Aileensoul</h1>
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
                                            <a href="javascript:void(0)" data-toggle="modal" onclick="forgot_profile();" id="myBtn">Forgot Password ?</a>
                                        </p>

                                        <p class="pt15 text-center">
                                            Don't have an account? <a class="db-479" href="javascript:void(0);" data-toggle="modal" onclick="register_profile();">Create an account</a>
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

        <!-- Login  For Apply Post-->
        <div class="modal fade login" id="login_apply" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content login-frm">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <div class="right-main">
                            <div class="right-main-inner">
                                <div class="">
                                    <div class="title">
                                        <h1 class="ttc tlh2">Welcome To Aileensoul</h1>
                                    </div>

                                    <form role="form" name="login_form_apply" id="login_form_apply" method="post">

                                        <div class="form-group">
                                            <input type="email" value="<?php echo $email; ?>" name="email_login_apply" id="email_login_apply" autofocus="" class="form-control input-sm email_login" placeholder="Email Address*">
                                            <div id="error2" style="display:block;">
                                                <?php
                                                if ($this->session->flashdata('erroremail')) {
                                                    echo $this->session->flashdata('erroremail');
                                                }
                                                ?>
                                            </div>
                                            <div id="errorlogin_apply"></div> 
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password_login_apply" id="password_login_apply" class="form-control input-sm password_login" placeholder="Password*">
                                            <input type="hidden" name="password_login_postid" id="password_login_postid" class="form-control input-sm post_id_login">

                                            <div id="error1" style="display:block;">
                                                <?php
                                                if ($this->session->flashdata('errorpass')) {
                                                    echo $this->session->flashdata('errorpass');
                                                }
                                                ?>
                                            </div>
                                            <div id="errorpass_apply"></div> 
                                        </div>

                                        <p class="pt-20 ">
                                            <button class="btn1" onclick="login()">Login</button>
                                        </p>

                                        <p class=" text-center">
                                            <a href="javascript:void(0)" data-toggle="modal" onclick="forgot_profile();" id="myBtn">Forgot Password ?</a>
                                        </p>

                                        <p class="pt15 text-center">
                                            Don't have an account? <a class="db-479" href="javascript:void(0);" data-toggle="modal" onclick="register_profile();">Create an account</a>
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
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                    <div class="modal-body cus-forgot">
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




        <!-- model for forgot password end -->

        <!-- register -->

        <div class="modal fade register-model login" id="register" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content inner-form1">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <div class="clearfix">
                            <div class="">
                               <div class="title"><h1 class="tlh1">Sign up First and Register in Job Profile</h1></div>
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
                                            <input type="hidden" name="password_login_postid" id="password_login_postid" class="form-control input-sm post_id_login">
                                        </div>
                                        <div class="form-group dob">
                                            <label class="d_o_b"> Date Of Birth :</label>
                                            <span> <select tabindex="105" class="day" name="selday" id="selday">
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
                                                </select></span>
                                        </div>

                                        <p class="form-text" style="margin-bottom: 10px;">
                                            By Clicking on create an account button you agree our
                                            <a tabindex="109" href="<?php echo base_url('terms-and-condition'); ?>">Terms and Condition</a> and <a tabindex="110" href="<?php echo base_url('privacy-policy'); ?>">Privacy policy</a>.
                                        </p>
                                        <p>
                                            <button tabindex="111" class="btn1">Create an account</button>
                                                                                        <!--<p class="next">Next</p>-->
                                        </p>
                                        <div class="sign_in pt10">
                                            <p>
                                                Already have an account ? <a tabindex="112" onClick="login_profile_apply(<?php echo $post['post_id']; ?>)" href="javascript:void(0);"> Log In </a>
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

        <!-- register for apply start-->

        <div class="modal fade register-model login" id="register_apply" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <div class="clearfix">
                            <div class="col-md-12 col-sm-12">
                                <h4>Join Aileensoul - It's Free</h4>
                                <div class="main-form">
                                    <form role="form" name="register_form" id="register_form" method="post">
                                        <div class="row">
                                            <div class="col-sm-6 col-md-6">
                                                <div class="form-group">
                                                    <input tabindex="5" type="text" name="first_name" id="first_name" class="form-control input-sm" placeholder="First Name">
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6">
                                                <div class="form-group">
                                                    <input tabindex="6" type="text" name="last_name" id="last_name" class="form-control input-sm" placeholder="Last Name">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <input tabindex="7" type="text" name="email_reg" id="email_reg" class="form-control input-sm" placeholder="Email Address" autocomplete="new-email">
                                        </div>
                                        <div class="form-group">
                                            <input tabindex="8" type="password" name="password_reg" id="password_reg" class="form-control input-sm" placeholder="Password" autocomplete="new-password">
                                            <input type="hidden" name="password_login_postid" id="password_login_postid" class="form-control input-sm post_id_login">
                                        </div>
                                        <div class="form-group dob">
                                            <label class="d_o_b"> Date Of Birth :</label>
                                            <select tabindex="9" class="day" name="selday" id="selday">
                                                <option value="" disabled selected value>Day</option>
                                                <?php
                                                for ($i = 1; $i <= 31; $i++) {
                                                    ?>
                                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                            <select tabindex="10" class="month" name="selmonth" id="selmonth">
                                                <option value="" disabled selected value>Month</option>
                                                
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
                                                
                                            </select>
                                            <select tabindex="11" class="year" name="selyear" id="selyear">
                                                <option value="" disabled selected value>Year</option>
                                                <?php
                                                for ($i = date('Y'); $i >= 1900; $i--) {
                                                    ?>
                                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                    <?php
                                                }
                                                ?>

                                            </select>

                                        </div>
                                        <div class="dateerror" style="color:#f00; display: block;"></div>

                                        <div class="form-group gender-custom">
                                            <select tabindex="12" class="gender"  onchange="changeMe(this)" name="selgen" id="selgen">
                                                <option value="" disabled selected value>Gender</option>
                                                <option value="M">Male</option>
                                                <option value="F">Female</option>
                                            </select>
                                        </div>

                                        <p class="form-text">
                                            By Clicking on create an account button you agree our<br class="mob-none">
                                            <a href="<?php echo base_url('terms-and-condition'); ?>">Terms and Condition</a> and <a href="<?php echo base_url('privacy-policy'); ?>">Privacy policy</a>.
                                        </p>
                                        <p>
                                            <button tabindex="13" class="btn1">Create an account</button>
                                                                                      
                                        </p>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- register for apply end -->

        <!-- script for skill textbox automatic start-->
        <?php
        if (IS_REC_JS_MINIFY == '0') {
            ?>
            <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()) ?>"></script>
            <?php
        } else {
            ?>
            <script type="text/javascript" defer="defer" src="<?php echo base_url('assets/js_min/bootstrap_validate.min.js?ver=' . time()); ?>"></script>
        <?php } ?>



        <script>

            var get_csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
            var csrf_hash = '<?php echo $this->security->get_csrf_hash(); ?>';
            var base_url = '<?php echo base_url(); ?>';
            var skill = '<?php echo $this->input->get('skills'); ?>';
            var place = '<?php echo $this->input->get('searchplace'); ?>';
            var postslug = '<?php echo $this->uri->segment(3); ?>';
            
            $('#main_loader').hide();
            // $('#main_page_load').show();
            $('body').removeClass("body-loader");

        </script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/recruiter/rec_post_login.js?ver=' . time()); ?>"></script>

        <?php
        /*if (IS_REC_JS_MINIFY == '0') {
            ?>
            <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/recruiter/rec_post_login.js?ver=' . time()); ?>"></script>
            <?php
        } else {
            ?>

            <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/recruiter/rec_post_login.js?ver=' . time()); ?>"></script>
                        <!--<script type="text/javascript" defer="defer" src="<?php // echo base_url('assets/js_min/webpage/recruiter/rec_post_login.min.js?ver=' . time());      ?>"></script>-->

        <?php }*/ ?>
        <?php
        if($remail_days < 0)
        {
        }
        else{ ?>
       <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "JobPosting",
            "title": "<?php echo $job_title_txt; ?>",
            "description": " Description: <?php echo $this->common->make_links($post['post_description']); ?>",
            "skills": "<?php echo addslashes($skill_txt); ?>",
            "industry": "<?php echo $industry_txt; ?>",
            "experienceRequirements": "<?php echo $exp_txt; ?>",
            "educationRequirements": "<?php echo $edu_txt; ?>",
            "employmentType": "<?php echo strtoupper(str_replace(" ", "_", $emp_type_txt)); ?>",
            "baseSalary": {
                "@type": "MonetaryAmount",
                "currency": "<?php echo substr($currency_txt, 0,3); ?>",
                "value": {
                    "@type": "QuantitativeValue",
                    "minValue": <?php echo ($min_sal_txt != "" ? $min_sal_txt : '""'); ?>,
                    "maxValue": <?php echo ($max_sal_txt != "" ? $max_sal_txt : '""'); ?>,
                    "unitText": "<?php echo strtoupper(substr($salary_type_txt, 4)); ?>"
                }
            },
            "datePosted": "<?php echo date('Y-m-d', strtotime($post['created_date'])); ?>",
            "validThrough": "<?php echo $post_last_date_txt; ?>",
            "jobLocation": {
                "@type": "Place",
                "address": {
                    "@type": "PostalAddress",
                    "addressLocality": "<?php echo $cityname_txt; ?>",
                    "addressRegion": "<?php echo $statename_txt; ?>",
                    "addressCountry": "<?php echo $countryname_txt; ?>"
                }
            },
            "hiringOrganization": {
                "@type": "Organization",
                "name": "<?php echo $comp_name_txt; ?>"  
            }
        }
        </script>
        <?php
        } ?>
    </body>
</html>