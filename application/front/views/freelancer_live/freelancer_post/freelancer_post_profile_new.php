<!-- 
    Edit Profile:
    Individual : Not Display popup -  Company Information,Company Overview
    Comapny : Not Display popup - Basic Info, Educational, Experience,Profile Summary)
 -->
<!DOCTYPE html>
<html lang="en" ng-app="freelanceApplyProfileApp" ng-controller="freelanceApplyProfileController">
    <head>
        <title><?php echo $title; ?></title>
        <meta name="description" content="<?php echo $metadesc; ?>" />
        <?php echo $head; ?>
        <?php if (!$this->session->userdata('aileenuser')) { ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css'); ?>">
        <?php } ?>
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/ng-tags-input.min.css?ver=' . time()) ?>">
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

        <?php }
        $fh_profile = 0;
        $fa_profile = 0;
        if ($this->session->userdata('aileenuser')) {
            if ($freelancerpostdata['0']['user_id'] != $this->session->userdata('aileenuser')) {
                echo $freelancer_hire_header2;
                $fh_profile = 1;
            } else {
                echo $freelancer_post_header2;
                $fa_profile = 1;
            }
        }
        $segment_array = $this->uri->segment_array();
        $user_slug = $segment_array[count($segment_array)];

        if($freelancerpostdata[0]['is_indivdual_company'] == '1')
        {
            $first_name = ucwords($freelancerpostdata[0]['freelancer_post_fullname']);
            $last_name = ucwords($freelancerpostdata[0]['freelancer_post_username']);
            $fullname = $first_name.' '.$last_name;
            $name_no_img = strtoupper(substr($first_name, 0,1).' '.substr($last_name, 0,1));
            $is_indivdual_company = 1;
        }
        else
        {
            $fullname = ucwords($freelancerpostdata[0]['comp_name']);
            $name_no_img = strtoupper(substr($fullname, 0,1));
            $is_indivdual_company = 2;
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
                            if ($freelancerpostdata[0]['freelancer_post_user_image']) {

                                if (IMAGEPATHFROM == 'upload') {
                                    ?>
                                    <img src="<?php echo FREE_POST_PROFILE_MAIN_UPLOAD_URL . $freelancerpostdata[0]['freelancer_post_user_image']; ?>" alt="<?php echo $fullname; ?>" >
                                    <?php
                                } else {

                                    $filename = $this->config->item('free_post_profile_main_upload_path') . $freelancerpostdata[0]['freelancer_post_user_image'];
                                    $s3 = new S3(awsAccessKey, awsSecretKey);
                                    $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                    if ($info) {
                                        ?>
                                        <img src="<?php echo FREE_POST_PROFILE_MAIN_UPLOAD_URL . $freelancerpostdata[0]['freelancer_post_user_image']; ?>" alt="<?php echo $fullname; ?>" >
                                    <?php } else { ?>
                                        <div class="post-img-user">
                                            <?php echo ucfirst($name_no_img); ?>
                                        </div>
                                        <?php
                                    }
                                }
                            } else {
                                ?>
                                <div class="post-img-user">
                                    <?php echo ucfirst($name_no_img); ?>
                                </div>
                            <?php } ?>
                            <?php if ($freelancerpostdata['0']['user_id'] == $this->session->userdata('aileenuser')) { ?>
                                <a title="Update Profile Picture" href="javascript:void(0);" class="cusome_upload" onclick="updateprofilepopup();"><img alt="Update Profile Picture"  src="<?php echo base_url('assets/img/cam.png'); ?>"><?php echo $this->lang->line("update_profile_picture"); ?></a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="job-menu-profile mob-block">
                        <a title="<?php echo ucwords($fullname); ?>" href="javascript:void(0);">
                            <h3><?php echo ucwords($fullname); ?></h3>
                        </a>
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
                    <a title="<?php echo ucwords($fullname); ?>" href="javascript:void(0);">   <h3> <?php echo ucwords($fullname); ?></h3></a>
                </div>
             
				
            </div>
		<div class="container tab-plr0 pt20">
			<div class="all-detail-custom">
				<div class="custom-user-list">
					<div class="edit-custom-move">
					</div>
					<div class="gallery" id="gallery">

                        <?php if($is_indivdual_company == '1'): ?>
                        <!-- Basic information  -->
                        <div class="gallery-item">
                            <div class="dtl-box">
                                <div class="dtl-title">
                                    <img class="cus-width" src="<?php echo base_url().'assets/'; ?>n-images/detail/about.png"><span>Basic Information</span><a href="#" data-target="#job-basic-info" data-toggle="modal" class="pull-right"><img src="<?php echo base_url().'assets/'; ?>n-images/detail/edit.png"></a>
                                </div>
                                <div class="dtl-dis dtl-box-height">
                                    <ul class="dis-list">
                                        
                                        <li>
                                            <span>Job Title</span>
                                            Sr. Multimedia Designer
                                        </li>
                                        <li>
                                            <span>Field</span>
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
                                            <span>Skype</span>
                                            harshad2406
                                        </li>
                                        <li>
                                            <span>Timezone</span>
                                            GMT 21:45
                                        </li>
                                        
                                        <li>
                                            <span>Location</span>
                                            Ahmedabad, Gujrat , India
                                        </li>
                                        
                                    </ul>
                                </div>
                                <div class="about-more">
                                    <a href="#">View More <img src="<?php echo base_url().'assets/'; ?>n-images/detail/down-arrow.png"></a>
                                </div>
                                
                            </div>
                        </div>
                        
                        <!-- Educational  -->
                        <div class="gallery-item">
                            <div class="dtl-box">
                                <div class="dtl-title">
                                    <img class="cus-width" src="<?php echo base_url(); ?>assets/n-images/detail/edution.png"><span>Educational Info</span><a href="#" data-target="#educational-info" data-toggle="modal" ng-click="reset_edu_form();" class="pull-right" ng-if="live_slug == segment2"><img src="<?php echo base_url(); ?>assets/n-images/detail/detail-add.png"></a>
                                </div>
                                <div id="edution-loader" class="dtl-dis">
                                    <div class="text-center">
                                        <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
                                    </div>
                                </div>
                                <div id="edution-body" style="display: none;">
                                    <div class="dtl-dis" ng-if="user_education.length < 1">
                                        <div class="no-info">
                                            <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                                            <span>Showcase what degrees you have! From which school or university you have graduated.</span>
                                        </div>
                                    </div>
                                    <div class="dtl-dis dis-accor" ng-if="user_education.length > 0">
                                        <div class="panel-group" id="edu-accordion" role="tablist" aria-multiselectable="true">
                                            <div class="panel panel-default" ng-repeat="user_edu in user_education" ng-if="$index <= view_more_edu">
                                                <div class="panel-heading" role="tab" id="edu-{{$index}}">
                                                    <div class="panel-title">
                                                        <div class="dis-left">
                                                            <div class="dis-left-img">
                                                                <span>{{user_edu.edu_school_college | limitTo:1 | uppercase}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="dis-middle">
                                                            <h4>{{user_edu.edu_school_college}}</h4>
                                                            <p ng-if="user_edu.edu_degree == '0'">{{user_edu.edu_other_degree}}</p>
                                                            <p ng-if="user_edu.edu_degree != '0'">{{user_edu.degree_name}}</p>
                                                        </div>
                                                        <div class="dis-right">
                                                            <span role="button" ng-click="edit_user_edu($index)" class="pr5" ng-if="live_slug == segment2">
                                                                <img src="<?php echo base_url(); ?>assets/n-images/detail/detial-edit.png">
                                                            </span>
                                                            <span role="button" data-toggle="collapse" data-parent="#edu-accordion" href="#edu{{$index}}" aria-expanded="true" aria-controls="exp1" class="up-down collapsed">
                                                                <img src="<?php echo base_url(); ?>assets/n-images/detail/down-arrow.png">
                                                            </span>
                                                        </div>
                     
                                                    </div>
                                                </div>
                                                <div id="edu{{$index}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="edu-{{$index}}">
                                                    <div class="panel-body">
                                                        <ul class="dis-list list-ul-cus">
                                                            <li class="select-preview">
                                                                <span>Duration</span> 
                                                                <label ng-if="user_edu.start_date_str">{{user_edu.start_date_str}} to</label>
                                                                <label ng-if="user_edu.end_date_str != null && end_date_str != ''">{{user_edu.end_date_str}}</label> 
                                                                <label ng-if="user_edu.end_date_str == null || end_date_str == ''">Pursuing</label>
                                                            </li>
                                                            <li class="select-preview">
                                                                <span>Board / University</span>
                                                                <label ng-if="user_edu.edu_university == '0'">{{user_edu.edu_other_university}}</label>
                                                                <label ng-if="user_edu.edu_university != '0'">{{user_edu.university_name}}</label>
                                                            </li>
                                                            <li class="select-preview">
                                                                <span>Course / Field of Study / Stream</span>
                                                                <label ng-if="user_edu.edu_stream == '0'">{{user_edu.edu_other_stream}}</label>
                                                                <label ng-if="user_edu.edu_stream != '0'">{{user_edu.stream_name}}</label>
                                                            </li>
                                                            <li ng-if="user_edu.edu_file != '' && user_edu.edu_file != null">
                                                                <span>Document</span>
                                                                <p class="screen-shot" check-file-ext check-file="{{user_edu.edu_file}}" check-file-path="<?php echo "'".addslashes(FREE_APPLY_EDUCATION_UPLOAD_URL)."'"; ?>">
                                                                </p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="view-more-edu" class="about-more" ng-if="user_education.length > 3">
                                                <a href="javascript:void(0);" ng-click="edu_view_more()">View More <img src="<?php echo base_url(); ?>assets/n-images/detail/down-arrow.png"></a>
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
                                    <img class="cus-width" src="<?php echo base_url(); ?>assets/n-images/detail/exp.png">
                                    <span>Experience
                                        <!-- <span class="exp-y-m-inner" style="display:none;" ng-if="job_basic_info.experience == 'Fresher'">(Fresher)</span>
                                        <span class="exp-y-m-inner" style="display:none;" ng-if="job_basic_info.experience == 'Experience' && (exp_years > '0' || exp_months > '0')">(
                                            <span ng-if="exp_years > '0'">{{exp_years}} year{{exp_years > '1' ? 's' : ''}}</span>
                                            <span ng-if="exp_months > '0'">{{exp_months}} month{{exp_months > '1' ? 's' : ''}}</span>
                                             )
                                         </span>
                                        <span class="exp-y-m-inner" style="display:none;" ng-if="job_basic_info.experience == 'Experience' && (job_basic_info.exp_m || job_basic_info.exp_y)">({{job_basic_info.exp_y}} {{job_basic_info.exp_m}})</span> -->
                                        <span class="exp-y-m-inner" style="display:none;" ng-if="(exp_years > '0' || exp_months > '0')">(
                                            <span ng-if="exp_years > '0'">{{exp_years}} year{{exp_years > '1' ? 's' : ''}}</span>
                                            <span ng-if="exp_months > '0'">{{exp_months}} month{{exp_months > '1' ? 's' : ''}}</span>
                                             )
                                         </span>
                                    </span>
                                        <a href="#" ng-if="live_slug == segment2" ng-click="reset_exp_form()" data-target="#experience" data-toggle="modal" class="pull-right" ng-if="live_slug == segment2"><img src="<?php echo base_url(); ?>assets/n-images/detail/detail-add.png"></a>
                                </div>
                                <div id="exp-loader" class="dtl-dis">
                                    <div class="text-center">
                                        <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
                                    </div>
                                </div>
                                <div id="exp-body" style="display: none;">
                                    <div class="dtl-dis" ng-if="user_experience.length < '1'">
                                        <div class="no-info">
                                            <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                                            <span>Either you started working or already working somewhere or own a business. Add your experiences!</span>
                                        </div>
                                    </div>
                                    <div class="dtl-dis dis-accor" ng-if="user_experience.length > '0'">
                                        <div class="panel-group" id="exp-accordion" role="tablist" aria-multiselectable="true">
                                            <div class="panel panel-default" ng-repeat="user_exp in user_experience" ng-if="$index <= view_more_exp">
                                                <div class="panel-heading" role="tab" id="exp-{{$index}}">
                                                    <div class="panel-title">
                                                        <div class="dis-left">
                                                            <div class="dis-left-img">
                                                                <span>{{user_exp.exp_company_name | limitTo:1 | uppercase}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="dis-middle">
                                                            <h4>{{user_exp.exp_company_name}}</h4>
                                                            <p>{{user_exp.designation}}</p>
                                                        </div>
                                                        <div class="dis-right">
                                                            <span role="button" ng-click="edit_user_exp($index)" class="pr5" ng-if="live_slug == segment2">
                                                                <img src="<?php echo base_url(); ?>assets/n-images/detail/detial-edit.png">
                                                            </span>
                                                            <span role="button" data-toggle="collapse" data-parent="#exp-accordion" href="#exp{{$index}}" aria-expanded="true" aria-controls="exp1" class="up-down collapsed">
                                                                <img src="<?php echo base_url(); ?>assets/n-images/detail/down-arrow.png">
                                                            </span>
                                                        </div>
                     
                                                    </div>
                                                </div>
                                                <div id="exp{{$index}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="exp-{{$index}}">
                                                    <div class="panel-body">
                                                        <ul class="dis-list list-ul-cus">
                                                            <li class="select-preview">
                                                                <span>Time Period</span> 
                                                                <label>{{user_exp.start_date_str}} to</label>
                                                                <label ng-if="user_exp.end_date_str != '' && user_exp.end_date_str != null">{{user_exp.end_date_str}}</label> 
                                                                <label ng-if="user_exp.end_date_str == '' || user_exp.end_date_str == null">Still Working</label>
                                                            </li>
                                                            <li>
                                                                <span>Company Location</span>
                                                                {{user_exp.city_name}},{{user_exp.state_name}},{{user_exp.country_name}} 
                                                            </li>
                                                            <li ng-if="user_exp.exp_company_website != '' && user_exp.exp_company_website != null">
                                                                <span>Website</span>
                                                                <a href="{{user_exp.exp_company_website}}" target="_self">{{user_exp.exp_company_website}}</a>
                                                            </li>
                                                            <li>
                                                                <span>Description</span>
                                                                <label class="inner-dis" dd-text-collapse dd-text-collapse-max-length="150" dd-text-collapse-text="{{user_exp.exp_desc}}" dd-text-collapse-cond="true">{{user_exp.exp_desc}}</label>
                                                            </li>
                                                            <li ng-if="user_exp.exp_file != '' && user_exp.exp_file != null">
                                                                <span>Document</span>
                                                                <p class="screen-shot" check-file-ext check-file="{{user_exp.exp_file}}" check-file-path="<?php echo "'".addslashes(FREE_APPLY_EXPERIENCE_UPLOAD_URL)."'"; ?>">
                                                                    <!-- <img src="<?php echo base_url(); ?>assets/n-images/art-img.jpg"> -->
                                                                </p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="view-more-exp" class="about-more" ng-if="user_experience.length > '3'">
                                                <a href="#" ng-click="exp_view_more()">View More <img src="<?php echo base_url(); ?>assets/n-images/detail/down-arrow.png"></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
						
                        <!-- Profile Summary -->
                        <div class="gallery-item ">
                            <div class="dtl-box">
                                <div class="dtl-title">
                                    <img class="cus-width" src="<?php echo base_url().'assets/'; ?>n-images/detail/edution.png"><span>Profile Summary</span><a href="#" data-target="#prof-summary" data-toggle="modal" class="pull-right"><img src="<?php echo base_url().'assets/'; ?>n-images/detail/edit.png"></a>
                                </div>
                                <div id="prof-summary-loader" class="dtl-dis">
                                    <div class="text-center">
                                        <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
                                    </div>
                                </div>
                                <div id="prof-summary-body" style="display: none;">
                                    <div class="dtl-dis">
                                        <div class="no-info" ng-if="prof_summary == ''">
                                            <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                                            <span>Highlight your details. (Let it be either personal or professional)</span>
                                        </div>
                                        <div class="" ng-if="prof_summary != ''">
                                            <h4>Description</h4>
                                            <p dd-text-collapse dd-text-collapse-max-length="350" dd-text-collapse-text="{{prof_summary}}" dd-text-collapse-cond="true">{{prof_summary}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if($is_indivdual_company == '2'): ?>
						<!--  01 Company Overview -->
						<div class="gallery-item ">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/prof-sum.png?ver=' . time()) ?>"><span>Company Overview</span><a href="#" data-target="#company-overview" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
								</div>
                                <div id="company-overview-loader" class="dtl-dis">
                                    <div class="text-center">
                                        <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
                                    </div>
                                </div>
                                <div id="company-overview-body" style="display: none;">
                                    <div class="dtl-dis">
                                        <div class="no-info" ng-if="company_overview == ''">
                                            <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                                            <span>Highlight your details. (Let it be either personal or professional)</span>
                                        </div>
                                        <div class="" ng-if="company_overview != ''">
                                            <h4>Description</h4>
                                            <p dd-text-collapse dd-text-collapse-max-length="350" dd-text-collapse-text="{{company_overview}}" dd-text-collapse-cond="true">{{company_overview}}</p>
                                        </div>
                                    </div>
                                </div>								
							</div>
						</div>
                        <?php endif; ?>
						
						<!--  02 Edit profile -->
						<div class="gallery-item edit-profile-move">
						</div>
						
						<!--  03 Blank div -->
						<div class="gallery-item">
						</div>
                        <?php if($is_indivdual_company == '2'): ?>
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
                        <?php endif; ?>
						
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
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/bus-portfolio.png?ver=' . time()) ?>"><span>Portfolio</span><a href="#" data-target="#dtl-project" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/detail-add.png?ver=' . time()) ?>"></a>
								</div>
								<div id="project-loader" class="dtl-dis">
                                    <div class="text-center">
                                        <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
                                    </div>
                                </div>
                                <div id="project-body" style="display: none;">
                                    <div class="dtl-dis" ng-if="user_projects.length < 1">
                                        <div class="no-info">
                                            <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                                            <span>Add projects you have worked. Let it be an add-on to your experience.</span>
                                        </div>
                                    </div>
                                    <div class="dtl-dis dis-accor" ng-if="user_projects.length > 0">
                                        <div class="panel-group" id="project-accordion" role="tablist" aria-multiselectable="true">
                                            <div class="panel panel-default" ng-repeat="user_proj in user_projects" ng-if="$index <= view_more_proj">
                                                <div class="panel-heading" role="tab" id="project-{{$index}}">
                                                    <div class="panel-title">
                                                        <div class="dis-left">
                                                            <div class="dis-left-img">
                                                                <span>{{user_proj.project_title | limitTo:1 | uppercase}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="dis-middle">
                                                            <h4>{{user_proj.project_title}}</h4>
                                                            <p ng-if="user_proj.project_field == '0' && user_proj.project_other_field != ''"> {{user_proj.project_other_field}}</p>
                                                            <p ng-if="user_proj.project_field != '0'"> {{user_proj.project_field_txt}}</p>
                                                        </div>
                                                        <div class="dis-right">
                                                            <span role="button" ng-click="edit_user_project($index)" class="pr5" ng-if="live_slug == segment2">
                                                                <img src="<?php echo base_url(); ?>assets/n-images/detail/detial-edit.png">
                                                            </span>
                                                            <span role="button" data-toggle="collapse" data-parent="#project-accordion" href="#project{{$index}}" aria-expanded="true" aria-controls="exp1" class="up-down collapsed">
                                                                <img src="<?php echo base_url(); ?>assets/n-images/detail/down-arrow.png">
                                                            </span>
                                                        </div>
                     
                                                    </div>
                                                </div>
                                                <div id="project{{$index}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="project-{{$index}}">
                                                    <div class="panel-body">
                                                        <ul class="dis-list list-ul-cus">
                                                            <li ng-if="user_proj.project_url != ''">
                                                                <span>Website</span> 
                                                                <div class="dis-list-link">
                                                                <a href="{{user_proj.project_url}}" target="_self">{{user_proj.project_url}}</a>
                                                                </div>
                                                            </li>
                                                            <li class="select-preview">
                                                                <span>Duration</span> 
                                                                <label ng-if="user_proj.start_date_str">{{user_proj.start_date_str}} to</label>
                                                                <label ng-if="user_proj.project_end_date != '' && user_proj.end_date_str != '' && user_proj.end_date_str != null">{{user_proj.end_date_str}}</label> 
                                                                <label ng-if="user_proj.project_end_date != '' && (user_proj.end_date_str == '' || user_proj.end_date_str == null)">Still Working</label>
                                                            </li>
                                                            <li ng-if="user_proj.project_team > '0'">
                                                                <span>Team Size</span>
                                                                {{user_proj.project_team}}
                                                            </li>
                                                            <li ng-if="user_proj.project_role">
                                                                <span>Your Role</span>
                                                                {{user_proj.project_role}}
                                                            </li>
                                                            <li ng-if="user_proj.project_partner_name != ''">
                                                                <span>Project Partner</span>
                                                                {{user_proj.project_partner_name}}
                                                            </li>
                                                            <li ng-if="user_proj.project_skills_txt">
                                                                <span>Skills Applied</span>
                                                                {{user_proj.project_skills_txt}}
                                                            </li>
                                                            <li ng-if="user_proj.project_desc">
                                                                <span>Description</span>
                                                                <label class="inner-dis" dd-text-collapse dd-text-collapse-max-length="150" dd-text-collapse-text="{{user_proj.project_desc}}" dd-text-collapse-cond="true">{{user_proj.project_desc}}</label>
                                                            </li>
                                                            <li ng-if="user_proj.project_file != '' && user_proj.project_file != null">
                                                                <span>Project File</span>
                                                                <p class="screen-shot" check-file-ext check-file="{{user_proj.project_file}}" check-file-path="<?php echo "'".addslashes(FREE_APPLY_PROJECT_UPLOAD_URL)."'"; ?>">
                                                                </p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="view-more-proj" class="about-more" ng-if="user_projects.length > 3">
                                                <a href="#" ng-click="proj_view_more()">View More <img src="<?php echo base_url(); ?>assets/n-images/detail/down-arrow.png"></a>
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
										<span class="total-rat">4.8</span>
                                        <span class="rating-star">
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
                                    <img class="cus-width" src="<?php echo base_url(); ?>assets/n-images/detail/add-course.png"><span>Additional Course</span><a href="#" data-target="#additional-course" data-toggle="modal" ng-click="reset_addicourse_form();" class="pull-right" ng-if="live_slug == segment2"><img src="<?php echo base_url(); ?>assets/n-images/detail/detail-add.png"></a>
                                </div>
                                <div id="addicourse-loader" class="dtl-dis">
                                    <div class="text-center">
                                        <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
                                    </div>
                                </div>
                                <div id="addicourse-body" style="display: none;">
                                    <div class="dtl-dis" ng-if="user_addicourse.length < '1'">
                                        <div class="no-info">
                                            <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                                            <span>Highlight the other online or offline courses you have pursued.</span>
                                        </div>
                                    </div>
                                    <div class="dtl-dis dis-accor" ng-if="user_addicourse.length > '0'">
                                        <div class="panel-group" id="addicourse-accordion" role="tablist" aria-multiselectable="true">
                                            <div class="panel panel-default" ng-repeat="user_course in user_addicourse" ng-if="$index <= view_more_ac">
                                                <div class="panel-heading" role="tab" id="addicourse-{{$index}}">
                                                    <div class="panel-title">
                                                        <div class="dis-left">
                                                            <div class="dis-left-img">
                                                                <span>{{user_course.addicourse_name | limitTo:1 | uppercase}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="dis-middle">
                                                            <h4>{{user_course.addicourse_name}}</h4>        
                                                            <p>{{user_course.addicourse_org}}</p>
                                                        </div>
                                                        <div class="dis-right">
                                                            <span role="button" ng-click="edit_user_addicourse($index)" class="pr5" ng-if="live_slug == segment2">
                                                                <img src="<?php echo base_url(); ?>assets/n-images/detail/detial-edit.png">
                                                            </span>
                                                            <span role="button" data-toggle="collapse" data-parent="#addicourse-accordion" href="#addicourse{{$index}}" aria-expanded="true" aria-controls="exp1" class="up-down collapsed">
                                                                <img src="<?php echo base_url(); ?>assets/n-images/detail/down-arrow.png">
                                                            </span>
                                                        </div>
                     
                                                    </div>
                                                </div>
                                                <div id="addicourse{{$index}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="addicourse-{{$index}}">
                                                    <div class="panel-body">
                                                        <ul class="dis-list list-ul-cus">
                                                            <li>
                                                                <span>Duration</span> 
                                                                <label>{{user_course.start_date_str}} to</label>
                                                                <label ng-if="user_course.end_date_str != '' && user_course.end_date_str != null">{{user_course.end_date_str}}</label> 
                                                                <label ng-if="user_course.end_date_str == '' || user_course.end_date_str == null">Studying</label>
                                                            </li>
                                                            <li ng-if="user_course.addicourse_url != ''">
                                                                <span>Website</span> 
                                                                <div class="dis-list-link">
                                                                <a href="{{user_course.addicourse_url}}" target="_self">{{user_course.addicourse_url}}</a>
                                                                </div>
                                                            </li>
                                                            <li ng-if="user_course.addicourse_file != '' && user_course.addicourse_file != null">
                                                                <span>Document</span>
                                                                <p class="screen-shot" check-file-ext check-file="{{user_course.addicourse_file}}" check-file-path="<?php echo "'".addslashes(FREE_APPLY_ADDICOURSE_UPLOAD_URL)."'"; ?>">
                                                                </p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="view-more-addicourse" class="about-more" ng-if="user_addicourse.length > '3'">
                                                <a href="#" ng-click="ac_view_more()">View More <img src="<?php echo base_url(); ?>assets/n-images/detail/down-arrow.png"></a>
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
                                    <img class="cus-width" src="<?php echo base_url(); ?>assets/n-images/detail/publication.png"><span>Publication</span><a href="#" data-target="#publication" data-toggle="modal" ng-click="reset_publication_form();" class="pull-right" ng-if="live_slug == segment2"><img src="<?php echo base_url(); ?>assets/n-images/detail/detail-add.png"></a>
                                </div>
                                <div id="publication-loader" class="dtl-dis">
                                    <div class="text-center">
                                        <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
                                    </div>
                                </div>
                                <div id="publication-body" style="display: none;">
                                    <div class="dtl-dis" ng-if="user_publication.length < '1'">
                                        <div class="no-info">
                                            <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                                            <span>Are you know by a piece of work? Add that details here.</span>
                                        </div>
                                    </div>
                                    <div class="dtl-dis dis-accor" ng-if="user_publication.length > '0'">
                                        <div class="panel-group" id="publication-accordion" role="tablist" aria-multiselectable="true">
                                            <div class="panel panel-default" ng-repeat="user_pub in user_publication" ng-if="$index <= view_more_publication">
                                                <div class="panel-heading" role="tab" id="publication-{{$index}}">
                                                    <div class="panel-title">
                                                        <div class="dis-left">
                                                            <div class="dis-left-img">
                                                                <span>{{user_pub.pub_title | limitTo:1 | uppercase}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="dis-middle">
                                                            <h4>{{user_pub.pub_title}}</h4>        
                                                            <p>{{user_pub.pub_author}}</p>
                                                        </div>
                                                        <div class="dis-right">
                                                            <span role="button" ng-click="edit_user_publication($index)" class="pr5" ng-if="live_slug == segment2">
                                                                <img src="<?php echo base_url(); ?>assets/n-images/detail/detial-edit.png">
                                                            </span>
                                                            <span role="button" data-toggle="collapse" data-parent="#publication-accordion" href="#publication{{$index}}" aria-expanded="true" aria-controls="exp1" class="up-down collapsed"> 
                                                                <img src="<?php echo base_url(); ?>assets/n-images/detail/down-arrow.png">
                                                            </span>
                                                        </div>
                     
                                                    </div>
                                                </div>
                                                <div id="publication{{$index}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="publication-{{$index}}">
                                                    <div class="panel-body">
                                                        <ul class="dis-list list-ul-cus">
                                                            <li class="select-preview">
                                                                <span>Published Date</span> 
                                                                <label>{{user_pub.pub_date_str}}</label>
                                                            </li>
                                                            <li class="select-preview">
                                                                <span>Publisher / Publication</span>
                                                                <label>{{user_pub.pub_publisher}}</label>
                                                            </li>
                                                            <li ng-if="user_pub.pub_url != '' && user_pub.pub_url != null">
                                                                <span>Website</span>
                                                                <div class="dis-list-link">
                                                                <a href="{{user_pub.pub_url}}" target="_self">{{user_pub.pub_url}}</a>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <span>Description</span>
                                                                <label class="inner-dis" dd-text-collapse dd-text-collapse-max-length="150" dd-text-collapse-text="{{user_pub.pub_desc}}" dd-text-collapse-cond="true">{{user_pub.pub_desc}}</label>
                                                            </li>
                                                            <li ng-if="user_pub.pub_file != '' && user_pub.pub_file != null">
                                                                <span>Document</span>
                                                                <p class="screen-shot" check-file-ext check-file="{{user_pub.pub_file}}" check-file-path="<?php echo "'".addslashes(FREE_APPLY_PUBLICATION_UPLOAD_URL)."'"; ?>">
                                                                </p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="view-more-publication" class="about-more" ng-if="user_publication.length > '3'">
                                                <a href="#" ng-click="publication_view_more()">View More <img src="<?php echo base_url(); ?>assets/n-images/detail/down-arrow.png"></a>
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
						<div id="skill-move" class="dtl-box">
                            <div class="dtl-title">
                                <img class="cus-width" src="<?php echo base_url(); ?>assets/n-images/detail/skill.png"><span>Skills</span><a href="#" data-target="#skills" data-toggle="modal" class="pull-right" ng-click="reset_user_skills();" ng-if="live_slug == segment2"><img src="<?php echo base_url(); ?>assets/n-images/detail/edit.png"></a>
                            </div>
                            <div id="skill-loader" class="dtl-dis">
                                <div class="text-center">
                                    <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
                                </div>
                            </div>
                            <div id="skill-body" style="display: none;">
                                <div class="dtl-dis">
                                    <div class="no-info" ng-if="user_skills.length < '1'">
                                        <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                                        <span>At what you are good. Add your expertise to profile.</span>
                                    </div>
                                    <ul class="skill-list" ng-if="user_skills.length > '0'">
                                        <li ng-repeat="skills in user_skills">{{skills.name}}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
					</div>
					
					<!-- Social Link  -->
					<div class="rsp-dtl-box">
                        <div id="social-link-move" class="dtl-box">
                            <div class="dtl-title">
                                <img class="cus-width" src="<?php echo base_url(); ?>assets/n-images/detail/website.png"><span>Website</span><a href="#" data-target="#social-link" data-toggle="modal" class="pull-right" ng-if="live_slug == segment2"><img src="<?php echo base_url(); ?>assets/n-images/detail/edit.png"></a>
                            </div>
                            <div id="social-link-loader" class="dtl-dis">
                                <div class="text-center">
                                    <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
                                </div>
                            </div>
                            <div id="social-link-body" style="display: none;">
                                <div class="dtl-dis">
                                    <div class="no-info" ng-if="user_social_links.length < '1' && user_personal_links.length < '1'">
                                        <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                                        <span>Enter your social profile links. Let people stay connected with you on other platforms too.</span>
                                    </div>
                                    <div class="social-links" ng-if="user_social_links.length > '0'">
                                        <h4>Social</h4>
                                        <ul class="social-link-list">
                                            <li ng-repeat="social_links in user_social_links">
                                                <a href="{{social_links.user_links_txt}}" target="_self">
                                                    <img ng-if="social_links.user_links_type == 'Facebook'" src="<?php echo base_url(); ?>assets/n-images/detail/fb.png">
                                                    <img ng-if="social_links.user_links_type == 'Google'" src="<?php echo base_url(); ?>assets/n-images/detail/g-plus.png">
                                                    <img ng-if="social_links.user_links_type == 'LinkedIn'" src="<?php echo base_url(); ?>assets/n-images/detail/in.png">
                                                    <img ng-if="social_links.user_links_type == 'Pinterest'" src="<?php echo base_url(); ?>assets/n-images/detail/pin.png">
                                                    <img ng-if="social_links.user_links_type == 'Instagram'" src="<?php echo base_url(); ?>assets/n-images/detail/insta.png">
                                                    <img ng-if="social_links.user_links_type == 'GitHub'" src="<?php echo base_url(); ?>assets/n-images/detail/git.png">
                                                    <img ng-if="social_links.user_links_type == 'Twitter'" src="<?php echo base_url(); ?>assets/n-images/detail/twt.png">
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="social-links" ng-if="user_personal_links.length > '0'">
                                        <h4 class="pt20 fw">Personal</h4>
                                        <ul class="social-link-list">
                                            <li ng-repeat="user_p_links in user_personal_links">
                                                <a href="{{user_p_links.user_links_txt}}" target="_self">
                                                    <img src="<?php echo base_url(); ?>assets/n-images/detail/pr-web.png">
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
					</div>

                    <!--  Languages -->
                    <div class="rsp-dtl-box ">
                        <div id="language-move" class="dtl-box">
                            <div class="dtl-title">
                                <img class="cus-width" src="<?php echo base_url('assets/n-images/detail/language.png?ver=' . time()) ?>"><span>Language</span><a href="#" data-target="#language" data-toggle="modal" class="pull-right" ng-if="live_slug == segment2"><img src="<?php echo base_url('assets/n-images/detail/detail-add.png?ver=' . time()) ?>"></a>
                            </div>
                            <div id="language-loader" class="dtl-dis">
                                <div class="text-center">
                                    <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
                                </div>
                            </div>
                            <div id="language-body" style="display: none;">
                                <div class="dtl-dis">
                                    <div class="no-info" ng-if="user_languages.length < '1'">
                                        <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                                        <span>Add languages that you know. Open door of overseas opportunities.</span>
                                    </div>
                                    <ul ng-if="user_languages.length > 0" class="known-language">
                                        <li ng-repeat="user_lang in user_languages">
                                            <span class="pr5">{{user_lang.language_name}}</span> - <span class="pl5">{{user_lang.proficiency}}</span>
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
            <div class="clearfix"></div>
			
        </section>
		<div class="bottom-ftr-none">
        <?php echo $login_footer ?>
        <?php echo $footer; ?>
		</div>

        <?php if($is_indivdual_company == '1'): ?>
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
                                        <label>Job Title </label>
                                        <input type="text" placeholder="Job Title">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Field </label>
                                        <span class="span-select">
                                            <select>
                                                <option>Field</option>
                                                <option>IT field</option>
                                                <option>Other</option>
                                            </select>
                                        </span>
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
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Skype </label>
                                        <input type="text" placeholder="Skype">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Time Zone </label>
                                        <span class="span-select">
                                            <select>
                                                <option>Time Zone</option>
                                                <option>Time Zone</option>
                                                <option>Time Zone</option>
                                            </select>
                                        </span>
                                    </div>
                                </div>
                                
                            </div>
                            
                            
                            <div class="row">
                                <label class="col-md-12 fw">Address</label>
                                <div class="col-md-4 col-sm-4 col-xs-4 hw-479">
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
                                <div class="col-md-4 col-sm-4 col-xs-4 hw-479">
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
        
        <!---  model Experience  -->
        <div style="display:none;" class="modal fade dtl-modal" id="experience" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" ng-click="reset_exp_form()" class="modal-close" data-dismiss="modal">×</button>
                    <div class="modal-body-cus"> 
                        <div class="dtl-title">
                            <span>Experience</span>
                        </div>
                        <form name="experience_form" id="experience_form" ng-validate="experience_validate">
                            <!-- <input type="hidden" name="edit_exp" id="edit_exp" ng-model="edit_exp" ng-value="0"> -->
                            <div class="dtl-dis">
                                
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                            <label>Company Name</label>
                                            <input type="text" placeholder="Enter Company Name" id="exp_company_name" name="exp_company_name" ng-model="exp_company_name">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Designation / Role</label>
                                            <!-- <input type="text" placeholder="Enter Designation"> -->
                                            <input type="text" placeholder="Enter Designation" id="exp_designation" name="exp_designation" ng-model="exp_designation" ng-keyup="exp_job_title_list()" typeahead="item as item.name for item in titleSearchResult | filter:$viewValue" autocomplete="off">
                                            </div>
                                        </div>
                                        
                                    </div>
                               
                                <div class="">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                            <label>Website <span class="link-must">(Must be http:// or https://)</span></label>
                                            <input type="text" placeholder="Enter Company Website" id="exp_company_website" name="exp_company_website" ng-model="exp_company_website">
                                            
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                            <label>Field </label>
                                            <span class="span-select">
                                                <?php $getFieldList = $this->data_model->getNewFieldList();?>
                                                <select name="exp_field" id="exp_field" ng-model="exp_field" ng-change="other_field_fnc()">
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
                                    <div id="exp_other_field_div" class="row" style="display: none;">
                                        <div class="col-md-6 col-sm-6"></div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                            <label>Other Field</label>
                                            <input type="text" placeholder="Enter Other Field" id="exp_other_field" name="exp_other_field" ng-model="exp_other_field">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <label>Company Location</label>
                                    <!-- <input type="text" placeholder="Enter Company Location"> -->
                                    <div class="row">
                                        <div class="col-md-4 col-sm-4 col-xs-4 fw-479">
                                            <div class="form-group">
                                            <span class="span-select">
                                                <select id="exp_country" name="exp_country" ng-model="exp_country" ng-change="exp_country_change()">
                                                    <option value="">Country</option>         
                                                    <option data-ng-repeat='country_item in exp_country_list' value='{{country_item.country_id}}'>{{country_item.country_name}}</option>
                                                </select>
                                            </span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-4 fw-479">
                                            <div class="form-group">
                                            <span class="span-select">
                                                <select id="exp_state" name="exp_state" ng-model="exp_state" ng-change="exp_state_change()" disabled = "disabled">
                                                    <option value="">State</option>
                                                    <option data-ng-repeat='state_item in exp_state_list' value='{{state_item.state_id}}'>{{state_item.state_name}}</option>
                                                </select>
                                                <img id="exp_state_loader" src="<?php echo base_url('assets/img/spinner.gif') ?>" style="   width: 20px;position: absolute;top: 6px;right: 19px;display: none;">
                                            </span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-4 fw-479">
                                            <div class="form-group">
                                            <span class="span-select">
                                                <select id="exp_city" name="exp_city" ng-model="exp_city" disabled = "disabled">
                                                    <option value="">City</option>
                                                    <option data-ng-repeat='city_item in exp_city_list' value='{{city_item.city_id}}'>{{city_item.city_name}}</option>
                                                </select>
                                                <img id="exp_city_loader" src="<?php echo base_url('assets/img/spinner.gif') ?>" style="   width: 20px;position: absolute;top: 6px;right: 19px;display: none;">
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <label>Start Date</label>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-6 col-xs-6">
                                                    <div class="form-group">
                                                    <span class="span-select">
                                                        <select id="exp_s_year" name="exp_s_year" ng-model="exp_s_year" ng-change="exp_start_year();">
                                                            <option value="">Year</option>
                                                            <?php
                                                            $year = date("Y",NOW());
                                                            for ($i=$year; $i >= 1950; $i--) { ?>
                                                                <option value="<?=$i?>"><?=$i?></option>
                                                            <?php
                                                            } ?>
                                                        </select>
                                                    </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-6">
                                                    <div class="form-group">
                                                    <span class="span-select">
                                                        <select id="exp_s_month" name="exp_s_month" ng-model="exp_s_month">
                                                            <option value="">Month</option>
                                                        </select>
                                                    </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="exp_end_date" class="col-md-6 col-sm-6" ng-show='!exp_isworking'>
                                            <label>End Date</label>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-6 col-xs-6">
                                                    <div class="form-group">
                                                    <span class="span-select">
                                                        <select id="exp_e_year" name="exp_e_year" ng-model="exp_e_year">
                                                        </select>
                                                    </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-6">
                                                    <div class="form-group">
                                                    <span class="span-select">
                                                        <select id="exp_e_month" name="exp_e_month" ng-model="exp_e_month">
                                                            <option value="">Month</option> 
                                                        </select>
                                                    </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12">
                                            <span id="expdateerror" class="error" style="display: none;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control control--checkbox">
                                            <input type="checkbox" ng-model="exp_isworking" id="exp_isworking" class="exp_isworking">I currently work here.
                                            <div class="control__indicator">
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea row="4" type="text" placeholder="Enter Roles and Responsibility" id="exp_desc" name="exp_desc" ng-model="exp_desc"></textarea>
                                </div>
                                <div class="form-group">
                                    <div class="upload-file">
                                        <label>Upload File (work experience certificate)</label>
                                        <input type="file" id="exp_file" name="exp_file">
                                        <span id="exp_file_error" class="error" style="display: none;"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="dtl-btn">
                                <a id="save_user_exp" href="#" ng-click="save_user_exp()" class="save"><span>Save</span></a>
                                <div id="user_exp_loader" class="dtl-popup-loader" style="display: none;">
                                <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" >
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade message-box biderror" id="delete-exp-model" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>         
                    <div class="modal-body">
                        <span class="mes">
                            <div class='pop_content'>
                                <span>Are you sure you want to delete work experience ?</span>
                                <p class='poppup-btns pt20'>
                                    <span id="exp-delete-btn">
                                        <a id="delete_user_exp" href="#" ng-click="delete_user_exp()" class="btn1">
                                            <span>Delete</span>
                                        </a> 
                                        <a class='btn1' href="#" data-dismiss="modal">Cancel</a>
                                    </span>
                                    <img id="user_exp_del_loader" src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" style="display: none;padding: 16px 15px 15px;">
                                </p>
                            </div>
                        </span>
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
                        <form name="edu_form" id="edu_form" ng-validate="edu_validate">
                            <div class="dtl-dis">
                                <div class="form-group">
                                    <label>School / College Name</label>
                                    <input type="text" placeholder="Enter School / College Name" id="edu_school_college" name="edu_school_college" minlength="3" maxlength="200">
                                </div>
                                <div class="form-group">
                                    <label>Board / University</label>
                                    <span class="span-select">
                                        <select id="edu_university" name="edu_university" ng-model="edu_university" ng-change="edu_university_change();">
                                            <option value="">Select Board / University</option>    
                                            <option data-ng-repeat='university_item in university_data' value='{{university_item.university_id}}'>{{university_item.university_name}}</option>
                                            <option value="0">Other</option>    
                                        </select>
                                    </span>
                                </div>
                                <div id="other_university" class="form-group" style="display: none;">
                                    <input type="text" placeholder="Other Board / University" id="edu_other_university" name="edu_other_university" maxlength="200" minlength="3">
                                </div>
                                <div class="">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                            <label>Degree / Qualification </label>
                                            <!-- <input type="text" placeholder="Degree / Qualification "> -->
                                            <span class="span-select">
                                            <select id="edu_degree" name="edu_degree" ng-model="edu_degree" ng-change="edu_degree_change();">
                                                <option value="">Select Degree / Qualification</option>    
                                                <option data-ng-repeat='degree_item in degree_data' value='{{degree_item.degree_id}}'>{{degree_item.degree_name}}</option>
                                                <option value="0">Other</option>    
                                            </select>
                                            </span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Course / Field of Study / Stream </label>
                                            <!-- <input type="text" placeholder="Course / Field of Study / Stream"> -->
                                            <span class="span-select">
                                            <select id="edu_stream" name="edu_stream" ng-model="edu_stream" ng-change="edu_stream_change()" disabled = "disabled">
                                                <option value="">Select Course / Field of Study / Stream</option>
                                                <option data-ng-repeat='stream_item in stream_data' value='{{stream_item.stream_id}}'>{{stream_item.stream_name}}</option>
                                            </select>
                                            </span>
                                            <img id="edu_stream_loader" src="<?php echo base_url('assets/img/spinner.gif') ?>" style="   width: 20px;position: absolute;top: 33px;right: 33px;display: none;">
                                        </div>
                                        </div>
                                    </div>

                                    <div id="other_edu" class="row" style="display: none;">
                                        <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Other Degree / Qualification </label>
                                            <input type="text" placeholder="Degree / Qualification" id="edu_other_degree" name="edu_other_degree">
                                        </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Other Course / Field of Study / Stream </label>
                                            <input type="text" placeholder="Course / Field of Study / Stream" id="edu_other_stream" name="edu_other_stream">
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <label>Start Date</label>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-6 col-xs-6">
                                                <div class="form-group">
                                                    <span class="span-select">
                                                        <select id="edu_s_year" name="edu_s_year" ng-model="edu_s_year" ng-change="edu_start_year();">
                                                            <option value="">Year</option>
                                                            <?php
                                                            $year = date("Y",NOW());
                                                            for ($ey=$year; $ey >= 1950; $ey--) { ?>
                                                                <option value="<?=$ey?>"><?=$ey?></option>
                                                            <?php
                                                            } ?>
                                                        </select>
                                                    </span>
                                                </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-6">
                                                <div class="form-group">
                                                    <span class="span-select">
                                                        <select id="edu_s_month" name="edu_s_month">
                                                            <option value="">Month</option>
                                                        </select>
                                                    </span>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6" ng-show='!edu_nograduate'>
                                            <label>End Date</label>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-6 col-xs-6">
                                                <div class="form-group">
                                                    <span class="span-select">
                                                        <select id="edu_e_year" name="edu_e_year" ng-model="edu_e_year">
                                                        </select>
                                                    </span>
                                                </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-6">
                                                <div class="form-group">
                                                    <span class="span-select">
                                                        <select id="edu_e_month" name="edu_e_month">
                                                            <option value="">Month</option> 
                                                        </select>
                                                    </span>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12">
                                            <span id="edudateerror" class="error" style="display: none;"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control control--checkbox">
                                        <input type="checkbox" ng-model="edu_nograduate" id="edu_nograduate" name="edu_nograduate">If You are not graduate click here.
                                        <div class="control__indicator"></div>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <div class="upload-file">
                                        <label>Upload File (Educational Certificate)</label>
                                        <input type="file" id="edu_file" name="edu_file">
                                        <span id="edu_file_error" class="error" style="display: none;"></span>
                                    </div>
                                </div>                    
                            </div>
                            <div class="dtl-btn">
                                <!-- <a href="#" class="save"><span>Save</span></a> -->
                                <a id="edu_save" href="#" ng-click="save_user_education()" class="save"><span>Save</span></a>
                                <div id="edu_loader" class="dtl-popup-loader" style="display: none;">
                                <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade message-box biderror" id="delete-edu-model" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>         
                    <div class="modal-body">
                        <span class="mes">
                            <div class='pop_content'>
                                <span>Are you sure you want to delete educational information ?</span>
                                <p class='poppup-btns pt20'>
                                    <span id="edu-delete-btn">
                                        <a id="delete_user_edu" href="#" ng-click="delete_user_edu()" class="btn1">
                                            <span>Delete</span>
                                        </a> 
                                        <a class='btn1' href="#" data-dismiss="modal">Cancel</a>
                                    </span>
                                    <img id="user_edu_del_loader" src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" style="display: none;padding: 16px 15px 15px;">
                                </p>
                            </div>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if($is_indivdual_company == '2'): ?>
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
        <?php endif; ?>
    	
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
                                                <input type="text" name="language[]" ng-model="language[100].lngtxt" ng-keyup="get_languages(100)" class="form-control language" placeholder="Enter Language"  id="language1" typeahead="item as item.language_name for item in lang_search_result | filter:$viewValue"  autocomplete="off" ng-value="primari_lang.language_name" value="{{primari_lang.language_name}}">
                                            </div>
                                        </div>
                                        <div class="width-45">
                                            <div class="form-group">
                                                <label>Proficiency</label>
                                                <span class="span-select">
                                                    <select class="proficiency" name="proficiency">
                                                        <option value="" disabled>Select Proficiency</option>
                                                        <option value="Basic" ng-selected="primari_lang.proficiency == 'Basic'">Basic</option>
                                                        <option value="Intermediate" ng-selected="primari_lang.proficiency == 'Intermediate'">Intermediate</option>
                                                        <option value="Expert" ng-selected="primari_lang.proficiency == 'Expert'">Expert</option>
                                                    </select>
                                                </span>
                                            </div>
                                        </div>
                                        <!-- <div class="width-10">
                                            <label></label>
                                            <a href="#" class="pull-right"><img class="dlt-img" src="<?php //echo base_url('assets/n-images/detail/dtl-delet.png?ver=' . time()) ?>"></a>
                                        </div> -->
                                        <div class="" data-ng-repeat="field in languageSet.language track by $index">                                        
                                            <div class="width-45">
                                                <div class="form-group">
                                                    <label>Language</label>
                                                    <!-- <input type="text" placeholder="Language" class="language" name="language"> -->
                                                    <input type="text" name="language[]" ng-model="language[$index].lngtxt" ng-keyup="get_languages($index)" class="form-control language" placeholder="Enter Language"  id="language2" typeahead="item as item.language_name for item in lang_search_result | filter:$viewValue" autocomplete="off" ng-value="field.language_name" value="{{field.language_name}}">
                                                </div>
                                            </div>
                                            <div class="width-45">
                                                <div class="form-group">
                                                    <label>Proficiency</label>
                                                    <span class="span-select">
                                                        <select class="proficiency" name="proficiency[]">
                                                            <option value="" disabled>Select Proficiency</option>
                                                            <option value="Basic" ng-selected="field.proficiency == 'Basic'">Basic</option>
                                                            <option value="Intermediate" ng-selected="field.proficiency == 'Intermediate'">Intermediate</option>
                                                            <option value="Expert" ng-selected="field.proficiency == 'Expert'">Expert</option>
                                                        </select>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="width-10">
                                                <a href="#" class="pull-right" ng-click="removeLanguage($index)"><img class="dlt-img" src="<?php echo base_url(); ?>assets/n-images/detail/dtl-delet.png"></a>
                                            </div>
                                        </div>
                                        <div class="fw dtl-more-add">
                                            <a href="#" ng-click="addNewLanguage()"><span class="pr10">Add More languages </span><img src="<?php echo base_url('assets/n-images/detail/inr-add.png?ver=' . time()) ?>"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>                    
                        </div>
                        <div class="dtl-btn">
                            <!-- <a href="#" class="save"><span>Save</span></a> -->
                            <a id="save_user_language" href="#" ng-click="save_user_language()" class="save"><span>Save</span></a>
                            <div id="user_language_loader" class="dtl-popup-loader" style="display: none;">
                            <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" >
                            </div>
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


        <?php if($is_indivdual_company == '1'): ?>
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
    							<textarea name="prof_summary" id="prof_summary" ng-model="prof_summary" type="text" placeholder="Professional Summary" maxlength="700">{{prof_summary}}</textarea>
                                <span class="pull-right">{{700 - prof_summary.length}}</span>
    						</div>
    				
    					</div>
    					<div class="dtl-btn bottom-btn">
                            <!-- <a href="#" class="save"><span>Save</span></a> -->
                            <a id="prof_summary_save" href="#" ng-click="save_prof_summary()" class="save"><span>Save</span></a>
                            <div id="prof_summary_loader" class="dtl-popup-loader" style="display: none;">
                                <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader">
                            </div>
                        </div>
    				</div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if($is_indivdual_company == '2'): ?>
            <!-- Profile Summary  -->
        <div style="display:none;" class="modal fade dtl-modal" id="company-overview" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">×</button>
                    <div class="modal-body-cus"> 
                        <div class="dtl-title">
                            <span>Company Overview</span>
                        </div>
                        <div class="dtl-dis">
                            <div class="form-group">
                                <textarea name="company_overview" id="company_overview" ng-model="company_overview" type="text" placeholder="Professional Summary" maxlength="700">{{company_overview}}</textarea>
                                <span class="pull-right">{{700 - company_overview.length}}</span>
                            </div>
                    
                        </div>
                        <div class="dtl-btn bottom-btn">
                            <!-- <a href="#" class="save"><span>Save</span></a> -->
                            <a id="company_overview_save" href="#" ng-click="save_company_overview()" class="save"><span>Save</span></a>
                            <div id="company_overview_loader" class="dtl-popup-loader" style="display: none;">
                                <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader">
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
        <?php endif; ?>
    	
    	
    	<!---  model Projects / Portfolio -->
    	<div style="display:none;" class="modal fade dtl-modal" id="dtl-project" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    		<div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">×</button>
                    <div class="modal-body-cus"> 
    					<div class="dtl-title">
    						<span>Portfolio</span>
    					</div>
    					<form name="project_form" id="project_form" ng-validate="project_validate">
                            <div class="dtl-dis">
                                <div class="">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                            <label>Project Title</label>
                                            <input type="text" placeholder="Enter Project Name" id="project_title" name="project_title" maxlength="200">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                            <label>Team Size</label>
                                            <input type="text" placeholder="Enter Team size" id="project_team" name="project_team" maxlength="3">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="">
                                    <div class="row">                            
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                            <label>Role</label>
                                            <input type="text" placeholder="Enter Role" id="project_role" name="project_role" maxlength="200">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                            <label>Skills Applied</label>
                                            <tags-input id="project_skill_list" ng-model="project_skill_list" display-property="name" placeholder="Enter Skills" replace-spaces-with-dashes="false" template="title-template" on-tag-added="onKeyup()" ng-keyup="project_skills_fnc()">
                                                <auto-complete source="loadSkills($query)" min-length="0" load-on-focus="false" load-on-empty="false" max-results-to-show="32" template="title-autocomplete-template"></auto-complete>
                                            </tags-input>                        
                                            <script type="text/ng-template" id="title-template">
                                                <div class="tag-template"><div class="right-panel"><span>{{$getDisplayText()}}</span><a class="remove-button" ng-click="$removeTag()">&#10006;</a></div></div>
                                            </script>
                                            <script type="text/ng-template" id="title-autocomplete-template">
                                                <div class="autocomplete-template"><div class="right-panel"><span ng-bind-html="$highlight($getDisplayText())"></span></div></div>
                                            </script>
                                            <label id="project_skill_err" for="project_skill_list" class="error" style="display: none;">Please enter skills</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>                   
                                
                                <div class="">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                            <label>Project Field</label>
                                            <span class="span-select">
                                                <?php $getFieldList = $this->data_model->getNewFieldList();?>
                                                <select name="project_field" id="project_field" ng-model="project_field" ng-change="other_project_field_fnc()">
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
                                            <label>Project URL <span class="link-must">(Must be http:// or https://)</span></label>
                                            <input type="text" placeholder="Enter Project URL" id="project_url" name="project_url">
                                            </div>
                                        </div>
                                    </div>
                                    <div id="proj_other_field_div" class="row" style="display: none;">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                            <label>Other Field</label>
                                            <input type="text" placeholder="Enter Other Field" id="project_other_field" name="project_other_field" maxlength="200">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Tag Project Partner</label>
                                    <!-- <input type="text" placeholder="Tag Project Partner" id="project_partner" name="project_partner"> -->
                                    <tags-input id="project_partner" ng-model="project_partner" display-property="p_name" placeholder="Tag Project Partner" replace-spaces-with-dashes="false" template="title-template" min-length="1">
                                    </tags-input>
                                </div>
                                <div class="">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <label>Start Date</label>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-6 col-xs-6">
                                                    <div class="form-group">
                                                    <span class="span-select">
                                                        <select id="project_s_year" name="project_s_year" ng-model="project_s_year" ng-change="project_start_year();">
                                                            <option value="">Year</option>
                                                            <?php
                                                            $year = date("Y",NOW());
                                                            for ($pi=$year; $pi >= 1950; $pi--) { ?>
                                                                <option value="<?=$pi?>"><?=$pi?></option>
                                                            <?php
                                                            } ?>
                                                        </select>
                                                    </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-6">
                                                    <div class="form-group">
                                                    <span class="span-select">
                                                        <select id="project_s_month" name="project_s_month">
                                                            <option value="">Month</option>
                                                        </select>
                                                    </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <label>End Date</label>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-6 col-xs-6">
                                                    <div class="form-group">
                                                    <span class="span-select">
                                                        <select id="project_e_year" name="project_e_year" ng-model="project_e_year">
                                                        </select>
                                                    </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-6">
                                                    <div class="form-group">
                                                    <span class="span-select">
                                                        <select id="project_e_month" name="project_e_month">
                                                            <option value="">Month</option> 
                                                        </select>
                                                    </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12">
                                            <span id="projdateerror" class="error" style="display: none;"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Project Description<span>(Min 50)</span></label>
                                    <textarea type="text" placeholder="Enter Project Details" id="project_desc" name="project_desc" ng- minlength="50" maxlength="700"></textarea>
                                    <span class="pull-right">700</span>                                
                                </div>
                                <div class="form-group">
                                    <div class="upload-file">
                                        <label>Upload File (Project certificate)</label>
                                        <input type="file" id="project_file" name="project_file">
                                        <span id="project_file_error" class="error" style="display: none;"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="dtl-btn">
                                <!-- <a href="#" class="save"><span>Save</span></a> -->
                                <a id="project_save" href="#" ng-click="save_user_project()" class="save"><span>Save</span></a>
                                <div id="prject_loader" style="display: none;" class="dtl-popup-loader">
                                <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader">
                                </div>
                            </div>
                        </form>
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
                        <form name="addicourse_form" id="addicourse_form" ng-validate="addicourse_validate">
                            <div class="dtl-dis">
                                <div class="form-group">
                                    <label>Course Name</label>
                                    <input type="text" placeholder="Enter Course Name" id="addicourse_name" name="addicourse_name">
                                </div>
                                <div class="form-group">
                                    <label>Organization</label>
                                    <input type="text" placeholder="Enter Organization" id="addicourse_org" name="addicourse_org">
                                </div>
                                <div class="">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            
                                            <label>Start Date</label>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-6 col-xs-6">
                                                    <div class="form-group">
                                                    <span class="span-select">
                                                        <select id="addicourse_s_year" name="addicourse_s_year" ng-model="addicourse_s_year" ng-change="addicourse_start_year();">
                                                            <option value="">Year</option>
                                                            <?php
                                                            $year = date("Y",NOW());
                                                            for ($i=$year; $i >= 1950; $i--) { ?>
                                                                <option value="<?=$i?>"><?=$i?></option>
                                                            <?php
                                                            } ?>
                                                        </select>
                                                    </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-6">
                                                    <div class="form-group">
                                                    <span class="span-select">
                                                        <select id="addicourse_s_month" name="addicourse_s_month">
                                                            <option value="">Month</option> 
                                                        </select>
                                                    </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <label>End Date</label>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-6 col-xs-6">
                                                <div class="form-group">
                                                    <span class="span-select">
                                                        <select id="addicourse_e_year" name="addicourse_e_year">
                                                        </select>
                                                    </span>
                                                </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-6">
                                                <div class="form-group">
                                                    <span class="span-select">
                                                        <select id="addicourse_e_month" name="addicourse_e_month">
                                                            <option value="">Month</option>
                                                        </select>
                                                    </span>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12">
                                            <span id="addicoursedateerror" class="error" style="display: none;"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>URL <span class="link-must">(Must be http:// or https://)</span></label>
                                    <input type="text" placeholder="Enter URL" id="addicourse_url" name="addicourse_url">
                                    
                                </div>
                                
                                <div class="form-group">
                                    <div class="upload-file">
                                        <label>Upload File (Additional Course Certificate)</label>
                                        <input type="file" id="addicourse_file" name="addicourse_file">
                                        <span id="addicourse_file_error" class="error" style="display: none;"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="dtl-btn">
                                <!-- <a href="#" class="save"><span>Save</span></a> -->
                                <a id="user_addicourse_save" href="#" ng-click="save_user_addicourse()" class="save"><span>Save</span></a>
                                <div id="user_addicourse_loader" class="dtl-popup-loader" style="display: none;">
                                <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader">
                                </div>
                            </div>
                        </form>
                    </div>  


                </div>
            </div>
        </div>
        <div class="modal fade message-box biderror" id="delete-addicourse-model" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>         
                    <div class="modal-body">
                        <span class="mes">
                            <div class='pop_content'>
                                <span>Are you sure you want to delete additional course ?</span>
                                <p class='poppup-btns pt20'>
                                    <span id="addicourse-delete-btn">
                                        <a id="delete_user_addicourse" href="#" ng-click="delete_user_addicourse()" class="btn1">
                                            <span>Delete</span>
                                        </a> 
                                        <a class='btn1' href="#" data-dismiss="modal">Cancel</a>
                                    </span>
                                    <img id="user_addicourse_del_loader" src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" style="display: none;padding: 16px 15px 15px;">
                                </p>
                            </div>
                        </span>
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
                        <form name="publication_form" id="publication_form" ng-validate="publication_validate">
                        <div class="dtl-dis">
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" placeholder="Enter Title" id="pub_title" name="pub_title" minlength="3" maxlength="200">
                            </div>
                            <div class="">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                        <label>Author</label>
                                        <input type="text" placeholder="Enter Author" id="pub_author" name="pub_author"  minlength="3" maxlength="200">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>URL <span class="link-must">(Must be http:// or https://)</span></label>
                                        <input type="text" placeholder="Enter URL" id="pub_url" name="pub_url" maxlength="200">
                                        
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Publisher / Publication</label>
                                <input type="text" placeholder="Enter Publisher / Publication" id="pub_publisher" name="pub_publisher" minlength="3" maxlength="200">
                            </div>
                            
                            <div class="form-group">
                                <label>Publication Date</label>                            
                                <div class="row">                            
                                    <div class="col-md-4 col-sm-4 col-xs-4 fw-479">
                                    <div class="form-group">
                                        <span class="span-select">
                                            <select id="publication_month" name="publication_month" ng-model="publication_month" ng-change="publication_date_fnc('','','')">
                                                <option value="">Month</option>
                                                <option value="01">Jan</option>
                                                <option value="02">Feb</option>
                                                <option value="03">Mar</option>
                                                <option value="04">Apr</option>
                                                <option value="05">May</option>
                                                <option value="06">Jun</option>
                                                <option value="07">Jul</option>
                                                <option value="08">Aug</option>
                                                <option value="09">Sep</option>
                                                <option value="10">Oct</option>
                                                <option value="11">Nov</option>
                                                <option value="12">Dec</option>
                                            </select>
                                        </span>
                                    </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-4 fw-479">
                                    <div class="form-group">
                                        <span class="span-select">
                                            <select id="publication_day" name="publication_day" ng-model="publication_day" ng-click="publication_error()"></select>
                                        </span>
                                    </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-4 fw-479">
                                    <div class="form-group">
                                        <span class="span-select">
                                            <select id="publication_year" name="publication_year" ng-model="publication_year" ng-change="publication_date_fnc('','','')" ng-click="publication_error()">
                                            </select>
                                        </span>
                                    </div>                            
                                    </div>                            
                                </div>
                            </div>                    
                            <div class="form-group">
                                <label>Description(Min 50)</label>
                                <textarea type="text" placeholder="Enter Description" id="pub_desc" name="pub_desc" minlength="50" maxlength="700"></textarea>
                                <span class="pull-right">700</span>
                            </div>                    
                            <div class="form-group">
                                <div class="upload-file">
                                    <label>Upload File (Publication Certificate)</label>
                                    <input type="file" id="pub_file" name="pub_file">
                                    <span id="pub_file_error" class="error" style="display: none;"></span>
                                </div>
                            </div>                    
                        </div>
                        <div class="dtl-btn">
                            <!-- <a href="#" class="save"><span>Save</span></a> -->
                            <a id="user_publication_save" href="#" ng-click="save_user_publication()" class="save"><span>Save</span></a>
                            <div  id="user_publication_loader" class="dtl-popup-loader" style="display: none;">
                            <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" >
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade message-box biderror" id="delete-publication-model" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>         
                    <div class="modal-body">
                        <span class="mes">
                            <div class='pop_content'>
                                <span>Are you sure you want to delete publication ?</span>
                                <p class='poppup-btns pt20'>
                                    <span id="publication-delete-btn">
                                        <a id="delete_user_publication" href="#" ng-click="delete_user_publication()" class="btn1">
                                            <span>Delete</span>
                                        </a> 
                                        <a class='btn1' href="#" data-dismiss="modal">Cancel</a>
                                    </span>
                                    <img id="user_publication_del_loader" src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" style="display: none;padding: 16px 15px 15px;">
                                </p>
                            </div>
                        </span>
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
                        <div class="dtl-dis post-field">
                            <div class="form-group">
                                <label>Skills</label>
                                <!-- <input type="text" placeholder="Enter Skills"> -->
                                <tags-input id="user_skill_list" ng-model="edit_user_skills" display-property="name" placeholder="Enter Skills" replace-spaces-with-dashes="false" template="title-template" on-tag-added="onKeyup()">
                                    <auto-complete source="loadSkills($query)" min-length="0" load-on-focus="false" load-on-empty="false" max-results-to-show="32" template="title-autocomplete-template"></auto-complete>
                                </tags-input>                        
                                <script type="text/ng-template" id="title-template">
                                    <div class="tag-template"><div class="right-panel"><span>{{$getDisplayText()}}</span><a class="remove-button" ng-click="$removeTag()">&#10006;</a></div></div>
                                </script>
                                <script type="text/ng-template" id="title-autocomplete-template">
                                    <div class="autocomplete-template"><div class="right-panel"><span ng-bind-html="$highlight($getDisplayText())"></span></div></div>
                                </script>
                            </div>
                        </div>
                        <div class="dtl-btn">                        
                            <a id="user_skills_save" href="#" ng-click="save_user_skills()" class="save"><span>Save</span></a>
                            <div id="user_skills_loader"  class="dtl-popup-loader" style="display: none;">
                            <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" >
                            </div>
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
                                        <div class="" data-ng-repeat="field in social_linksset.social_links track by $index">
                                        <div class="col-md-3 col-sm-3 col-xs-4 mob-pr0">
                                            <div class="form-group">
                                                <label>Website</label>
                                                <span class="span-select">
                                                    <select id="link_type{{$index}}" name="link_type" class="link_type">
                                                        <option value="Facebook" ng-selected="field.user_links_type == 'Facebook'">Facebook</option>
                                                        <option value="Google" ng-selected="field.user_links_type == 'Google'">Google</option>
                                                        <option value="Instagram" ng-selected="field.user_links_type == 'Instagram'">Instagram</option>
                                                        <option value="LinkedIn" ng-selected="field.user_links_type == 'LinkedIn'">LinkedIn</option>
                                                        <option value="Pinterest" ng-selected="field.user_links_type == 'Pinterest'">Pinterest</option>
                                                        <option value="GitHub" ng-selected="field.user_links_type == 'GitHub'">GitHub</option>
                                                        <option value="Twitter" ng-selected="field.user_links_type == 'Twitter'">Twitter</option>
                                                    </select>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <label>URL</label>
                                                <input type="text" placeholder="Enter URL" id="link_url{{$index}}" class="link_url" name="link_url" ng-keyup="check_socialurl($index)" ng-value="field.user_links_txt">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-1 col-sm-1 col-xs-1 pl0">
                                            
                                            <a href="#" class="pull-right" ng-click="removeSocialLinks($index)"><img class="dlt-img" src="<?php echo base_url(); ?>assets/n-images/detail/dtl-delet.png"></a>
                                        </div>
                                        </div>
                                        <div class="fw dtl-more-add" id="add-new-link">
                                            <a href="#" ng-click="addNewSocialLinks()"><span class="pr10">Add Social Links</span><img src="<?php echo base_url(); ?>assets/n-images/detail/inr-add.png"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div data-ng-repeat="field in personal_linksset.personal_links track by $index">
                                    <div class="form-group">
                                        <div class="col-md-11 col-sm-11 col-xs-11">
                                            <label>Add Personal Website</label>
                                            <input type="text" placeholder="Enter Website Link" id="personal_link_url{{$index}}" class="personal_link_url" name="personal_link_url" ng-keyup="check_personalurl($index)" ng-value="field.user_links_txt">
                                            <span class="personal-link-info">URL must start with http:// or https://</span>
                                        </div>
                                        <div class="col-md-1 col-sm-1 col-xs-1 pl0">
                                            
                                            <a href="#" class="pull-right" ng-click="removePersonalLinks($index)"><img class="dlt-img" src="<?php echo base_url(); ?>assets/n-images/detail/dtl-delet.png"></a>
                                        </div>
                                    </div>
                                </div>
                                <div id="add-personla-link" class="fw dtl-more-add pt15">
                                    <a href="#" ng-click="addNewPersonalLinks()"><span class="pr10">Add Personal Website Links </span>
                                        <img src="<?php echo base_url(); ?>assets/n-images/detail/inr-add.png">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="dtl-btn">
                                <!-- <a href="#" class="save"><span>Save</span></a> -->
                                <a id="user_links_save" href="#" ng-click="save_user_links()" class="save"><span>Save</span></a>
                                <div id="user_links_loader" class="dtl-popup-loader" style="display: none;">
                                <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" >
                                </div>
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
                 // for($i = 1; $i <= 12; $i++){
                 
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
                 // }
                 
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

   
        <script  src="<?php echo base_url('assets/js/croppie.js?ver=' . time()); ?>"></script>
        <script  type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>       
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

        <script>
            var base_url = '<?php echo base_url(); ?>';
            var user_session = '<?php echo $this->session->userdata('aileenuser'); ?>';
            var segment3 = '<?php echo $this->uri->segment(2); ?>'
            var count_profile_value = '<?php echo $count_profile_value; ?>';
            var count_profile = '<?php echo $count_profile; ?>';
            var user_slug = '<?php echo $user_slug; ?>';
            var header_all_profile = '<?php echo $header_all_profile; ?>';

            var free_apply_education_upload_url = '<?php echo FREE_APPLY_EDUCATION_UPLOAD_URL; ?>';
            var free_apply_experience_upload_url = '<?php echo FREE_APPLY_EXPERIENCE_UPLOAD_URL; ?>';
            var free_apply_addicourse_upload_url = '<?php echo FREE_APPLY_ADDICOURSE_UPLOAD_URL; ?>';
            var free_apply_publication_upload_url = '<?php echo FREE_APPLY_PUBLICATION_UPLOAD_URL; ?>';
            var free_apply_project_upload_url = '<?php echo FREE_APPLY_PROJECT_UPLOAD_URL; ?>';

            var app = angular.module("freelanceApplyProfileApp", ['ngRoute', 'ui.bootstrap', 'ngTagsInput', 'ngSanitize','angular-google-adsense', 'ngValidate']);
        </script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-apply/freelancer_post_profile.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-apply/freelancer_post_profile_new.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-apply/freelancer_apply_common.js?ver=' . time()); ?>"></script>
        <!-- <script type="text/javascript" src="<?php //echo base_url('assets/js/webpage/freelancer-apply/progressbar.js?ver=' . time()); ?>"></script> -->
        
		<script src="<?php echo base_url('assets/js/star-rating.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
		
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