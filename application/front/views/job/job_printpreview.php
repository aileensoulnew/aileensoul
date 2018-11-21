<!DOCTYPE html>
<html lang="en" ng-app="userJobProfileApp" ng-controller="userJobProfileController">
    <head>
        <title><?php echo $title; ?></title>
        <meta name="description" content="<?php echo $metadesc; ?>" />
        <!-- start head -->
        <?php echo $head; ?>
        <!-- END HEAD -->        
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/job.css?ver=' . time()); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/ng-tags-input.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/component.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css') ?>">
    <?php $this->load->view('adsense'); ?>
</head>
    <!-- END HEAD -->
    <?php
    /*echo $header;
    $returnpage = $_GET['page'];
    $userid = $this->session->userdata('aileenuser');
    $id = $this->db->get_where('job_reg', array('slug' => $this->uri->segment(3)))->row()->user_id;
    if ($userid != $id) {
        echo $recruiter_header2_border;
    } else {
        echo $job_header2_border;
    }*/    
    ?>
    <body class="">
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
            <div class="container" id="paddingtop_fixed">
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
                <div class="fw">
                    <div class="container mob-plr0 pt20">
                        <div class="all-detail-custom">
                            <div class="custom-user-list">
                                <div class="gallery" id="gallery">
                                    <!-- Basic information  -->
                                    <div class="gallery-item">
                                        <div class="dtl-box">
                                            <div class="dtl-title">
                                                <img class="cus-width" src="<?php echo base_url('assets/n-images/detail/about.png?ver=' . time()) ?>">
                                                <span>Basic Information</span>
                                                <a href="#" data-target="#job-basic-info" data-toggle="modal" class="pull-right" ng-click="edit_job_basic_info();" ng-if="live_slug == segment2"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
                                            </div>
                                            <div id="job-info-loader" class="dtl-dis">
                                                <div class="text-center">
                                                    <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
                                                </div>
                                            </div>
                                            <div id="job-info-body" style="display: none;">
                                                <div id="about-detail" class="dtl-dis dtl-box-height">
                                                    <ul class="dis-list list-ul-cus">                              
                                                        <li>
                                                            <span>Job Title</span>
                                                            <label>{{job_basic_info.work_job_title_txt}}</label>
                                                        </li>
                                                        <li>
                                                            <span>Field</span>
                                                            <label ng-if="job_basic_info.field == '0'">{{job_basic_info.other_field}}</label>
                                                            <label ng-if="job_basic_info.field != '0'">{{job_basic_info.field_txt}}</label>
                                                        </li>
                                                        <li>
                                                            <span>Email</span>
                                                            <label>{{job_basic_info.email}}</label>
                                                        </li>
                                                        <li>
                                                            <span>Phone Number</span>
                                                            <label>{{job_basic_info.phnno}}</label>
                                                        </li>
                                                        
                                                        <li>
                                                            <span>Date of Birth</span>
                                                            <label>{{job_basic_info.dob_txt}}</label>
                                                        </li>
                                                        <li>
                                                            <span>Gender</span>
                                                            <label>{{job_basic_info.gender | wordFirstCase}}</label>
                                                        </li>
                                                        <li>
                                                            <span>Address</span>
                                                            <label>{{job_basic_info.address}},</label>
                                                            <br />
                                                            <label>{{job_basic_info.city_name}}, {{job_basic_info.state_name}}, {{job_basic_info.country_name}}</label>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div id="view-more-about" class="about-more" style="display: none;">
                                                <a href="#" ng-click="view_more_about();">View More <img src="<?php echo base_url(); ?>assets/n-images/detail/down-arrow.png"></a>
                                            </div>                                            
                                        </div>
                                    </div>
                                    
                                    <!-- Educational info -->
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
                                                                    <ul class="dis-list">
                                                                        <li class="select-preview">
                                                                            <span>Duration</span> 
                                                                            <label>{{user_edu.start_date_str}} to</label>
                                                                            <label ng-if="user_edu.end_date_str != '' && user_edu.end_date_str != null">{{user_edu.end_date_str}}</label> 
                                                                            <label ng-if="user_edu.end_date_str == '' || user_edu.end_date_str == null">Studying</label>
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
                                                                            <p class="screen-shot" check-file-ext check-file="{{user_edu.edu_file}}" check-file-path="<?php echo "'".addslashes(JOB_USER_EDUCATION_UPLOAD_URL)."'"; ?>">
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
                                    <!-- Educational End -->
                                    
                                    <!-- Experience Start -->
                                    <div class="gallery-item">
                                        <div class="dtl-box">
                                            <div class="dtl-title">
                                                <img class="cus-width" src="<?php echo base_url(); ?>assets/n-images/detail/exp.png">
                                                <span>Experience
                                                    <span class="exp-y-m-inner" ng-if="job_basic_info.experience == 'Fresher'">(Fresher)</span>
                                                    <span class="exp-y-m-inner" ng-if="job_basic_info.experience == 'Experience' && (exp_years > '0' || exp_months > '0')">({{exp_years}}year {{exp_months}}month)</span>
                                                    <span class="exp-y-m-inner" ng-if="job_basic_info.experience == 'Experience' && (job_basic_info.exp_m || job_basic_info.exp_y)">({{job_basic_info.exp_y}} {{job_basic_info.exp_m}})</span>
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
                                                                    <ul class="dis-list">
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
                                                                            <p class="screen-shot" check-file-ext check-file="{{user_exp.exp_file}}" check-file-path="<?php echo "'".addslashes(JOB_USER_EXPERIENCE_UPLOAD_URL)."'"; ?>">
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
                                    <!-- Experience End -->
                                    
                                    <!-- Project Start -->
                                    <div class="gallery-item">
                                        <div class="dtl-box">
                                            <div class="dtl-title">
                                                <img class="cus-width" src="<?php echo base_url(); ?>assets/n-images/detail/project.png"><span>Project</span><a href="#" data-target="#dtl-project" data-toggle="modal" ng-click="reset_project_form();" class="pull-right" ng-if="live_slug == segment2"><img src="<?php echo base_url(); ?>assets/n-images/detail/detail-add.png"></a>
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
                                                                        <p ng-if="user_proj.project_field == '0'"> {{user_proj.project_other_field}}</p>
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
                                                                    <ul class="dis-list">
                                                                        <li ng-if="user_proj.project_url != ''">
                                                                            <span>Website</span> 
                                                                            <div class="dis-list-link">
                                                                            <a href="{{user_proj.project_url}}" target="_self">{{user_proj.project_url}}</a>
                                                                            </div>
                                                                        </li>
                                                                        <li class="select-preview">
                                                                            <span>Duration</span> 
                                                                            <label>{{user_proj.start_date_str}} to</label>
                                                                            <label ng-if="user_proj.end_date_str != '' && user_proj.end_date_str != null">{{user_proj.end_date_str}}</label> 
                                                                            <label ng-if="user_proj.end_date_str == '' || user_proj.end_date_str == null">Still Working</label>
                                                                        </li>
                                                                        <li>
                                                                            <span>Team Size</span>
                                                                            {{user_proj.project_team}}
                                                                        </li>
                                                                        <li>
                                                                            <span>Your Role</span>
                                                                            {{user_proj.project_role}}
                                                                        </li>
                                                                        <li ng-if="user_proj.project_partner_name != ''">
                                                                            <span>Project Partner</span>
                                                                            {{user_proj.project_partner_name}}
                                                                        </li>
                                                                        <li>
                                                                            <span>Skills Applied</span>
                                                                            {{user_proj.project_skills_txt}}
                                                                        </li>
                                                                        <li>
                                                                            <span>Description</span>
                                                                            <label class="inner-dis" dd-text-collapse dd-text-collapse-max-length="150" dd-text-collapse-text="{{user_proj.project_desc}}" dd-text-collapse-cond="true">{{user_proj.project_desc}}</label>
                                                                        </li>
                                                                        <li ng-if="user_proj.project_file != '' && user_proj.project_file != null">
                                                                            <span>Project File</span>
                                                                            <p class="screen-shot" check-file-ext check-file="{{user_proj.project_file}}" check-file-path="<?php echo "'".addslashes(JOB_USER_PROJECT_UPLOAD_URL)."'"; ?>">
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
                                    <!-- Project End -->
                                    
                                    <!-- Preferred job detail  -->
                                    <div class="gallery-item ">
                                        <div class="dtl-box">
                                            <div class="dtl-title">
                                                <img class="cus-width" src="<?php echo base_url('assets/n-images/detail/edution.png?ver=' . time()) ?>"><span>Preferred Job Details</span><a href="#" data-target="#preferred-job" data-toggle="modal" class="pull-right" ng-if="live_slug == segment2" ng-click="edit_preferred_job_info();"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
                                            </div>
                                            <div id="preferred-job-loader" class="dtl-dis">
                                                <div class="text-center">
                                                    <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
                                                </div>
                                            </div>
                                            <div id="preferred-job-body" style="display: none;">
                                                <div id="preferred-detail" class="dtl-dis dtl-box-height">
                                                    <ul class="dis-list  list-ul-cus">
                                                        <li>
                                                            <span>Preferred Job Title</span>
                                                            <label>{{job_basic_info.work_job_title_txt}}</label>
                                                        </li>
                                                        <li>
                                                            <span>Perferred Location / Region</span>
                                                            <label>{{preferred_job_info.work_job_city_txt}}</label>
                                                        </li>
                                                        <li ng-if="preferred_job_info.preferred_travel != '' && preferred_job_info.preferred_travel > '0'">
                                                            <span>How far are you wiling to travel? (In km)</span>
                                                            <label>{{preferred_job_info.preferred_travel}} km</label>
                                                        </li>
                                                        <li>
                                                            <span>Preferred Industry</span>
                                                            <label ng-if="preferred_job_info.work_job_industry != '0'">{{preferred_job_info.work_job_industry_txt}}</label>
                                                            <label ng-if="preferred_job_info.work_job_industry == '0'">{{preferred_job_info.work_job_other_industry}}</label>
                                                        </li>
                                                        <li ng-if="preferred_job_info.exp_salary_amt != ''">
                                                            <span>Expected Salary</span>
                                                            <label>{{preferred_job_info.exp_salary_amt}}</label>
                                                            <label>{{preferred_job_info.currency_name}}</label>
                                                            <label ng-if="preferred_job_info.exp_salary_worktype == '1'">Per Hours</label>
                                                            <label ng-if="preferred_job_info.exp_salary_worktype == '2'">Per Month</label>
                                                            <label ng-if="preferred_job_info.exp_salary_worktype == '3'">Per Year</label>                 
                                                        </li>
                                                        <li ng-if="preferred_job_info.preferred_cmp_culture != ''">
                                                            <span>Company Culture</span>
                                                            <label>{{preferred_job_info.preferred_cmp_culture}}</label>
                                                        </li>
                                                        <li ng-if="preferred_job_info.preferred_work_time != ''">
                                                            <span>Work Time / Schedule</span>
                                                            <label>{{preferred_job_info.preferred_work_time}}</label>
                                                        </li>         
                                                        <li ng-if="preferred_job_info.preferred_moredetail != ''">
                                                            <span>More Details</span>
                                                            <label class="inner-dis" dd-text-collapse dd-text-collapse-max-length="150" dd-text-collapse-text="{{preferred_job_info.preferred_moredetail}}" dd-text-collapse-cond="true">{{preferred_job_info.preferred_moredetail}}</label>
                                                        </li>
                                                        
                                                    </ul>
                                                </div>
                                            </div>
                                            <div id="view-more-preferred" class="about-more" style="display: none;">
                                                <a href="javascript:void(0);" ng-click="view_more_preferred();">View More <img src="<?php echo base_url('assets/n-images/detail/down-arrow.png?ver=' . time()) ?>"></a>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    <!-- Passion and Interest  -->
                                    <div class="gallery-item ">
                                        <div class="dtl-box">
                                            <div class="dtl-title">
                                                <img class="cus-width" src="<?php echo base_url('assets/n-images/detail/edution.png?ver=' . time()) ?>">
                                                <span>Passion and Interest</span>
                                                <a href="#" data-target="#passion-intrest" data-toggle="modal" class="pull-right">
                                                    <img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>">
                                                </a>
                                            </div>
                                            <div id="passion-intrest-loader" class="dtl-dis">
                                                <div class="text-center">
                                                    <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
                                                </div>
                                            </div>
                                            <div id="passion-intrest-body" style="display: none;">
                                                <div class="dtl-dis">
                                                    <div class="no-info" ng-if="passion_user == ''">
                                                        <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                                                        <span>Highlight your details. (Let it be either personal or professional)</span>
                                                    </div>
                                                    <div class="" ng-if="passion_user != ''">     
                                                        <p dd-text-collapse dd-text-collapse-max-length="350" dd-text-collapse-text="{{passion_user}}" dd-text-collapse-cond="true">{{passion_user}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Extracurricular Activity Start -->
                                    <div class="gallery-item">
                                        <div class="dtl-box">
                                            <div class="dtl-title">
                                                <img class="cus-width" src="<?php echo base_url(); ?>assets/n-images/detail/extra-activity.png"><span>Extracurricular Activity</span><a href="#" data-target="#extra-activity" data-toggle="modal" ng-click="reset_activity_form();" class="pull-right" ng-if="live_slug == segment2"><img src="<?php echo base_url(); ?>assets/n-images/detail/detail-add.png"></a>
                                            </div>
                                            <div id="activity-loader" class="dtl-dis">
                                                <div class="text-center">
                                                    <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
                                                </div>
                                            </div>
                                            <div id="activity-body" style="display: none;">
                                                <div class="dtl-dis" ng-if="user_activity.length < '1'">
                                                    <div class="no-info">
                                                        <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                                                        <span>Enter the activities you were involved in apart from studies.</span>
                                                    </div>
                                                </div>
                                                <div class="dtl-dis dis-accor" ng-if="user_activity.length > '0'">
                                                    <div class="panel-group" id="activity-accordion" role="tablist" aria-multiselectable="true">
                                                        <div class="panel panel-default" ng-repeat="user_ea in user_activity" ng-if="$index <= view_more_activity">
                                                            <div class="panel-heading" role="tab" id="activity-{{$index}}">
                                                                <div class="panel-title">
                                                                    <div class="dis-left">
                                                                        <div class="dis-left-img">
                                                                            <span>{{user_ea.activity_participate | limitTo:1 | uppercase}}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="dis-middle">
                                                                        <h4>{{user_ea.activity_participate}}</h4>        
                                                                        <p>{{user_ea.activity_org}}</p>
                                                                    </div>
                                                                    <div class="dis-right">
                                                                        <span role="button" ng-click="edit_user_activity($index)" class="pr5" ng-if="live_slug == segment2">
                                                                            <img src="<?php echo base_url(); ?>assets/n-images/detail/detial-edit.png">
                                                                        </span>
                                                                        <span role="button" data-toggle="collapse" data-parent="#activity-accordion" href="#activity{{$index}}" aria-expanded="true" aria-controls="exp1" class="up-down collapsed">
                                                                            <img src="<?php echo base_url(); ?>assets/n-images/detail/down-arrow.png">
                                                                        </span>
                                                                    </div>
                                 
                                                                </div>
                                                            </div>
                                                            <div id="activity{{$index}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="activity-{{$index}}">
                                                                <div class="panel-body">
                                                                    <ul class="dis-list">
                                                                        <li class="select-preview">
                                                                            <span>Duration</span> 
                                                                            <label>{{user_ea.start_date_str}} to</label>
                                                                            <label ng-if="user_ea.end_date_str != '' && user_ea.end_date_str != null">{{user_ea.end_date_str}}</label> 
                                                                            <label ng-if="user_ea.end_date_str == '' || user_ea.end_date_str == null">Currently active</label>
                                                                        </li>
                                                                        <li>
                                                                            <span>Description</span>
                                                                            <label class="inner-dis" dd-text-collapse dd-text-collapse-max-length="150" dd-text-collapse-text="{{user_ea.activity_desc}}" dd-text-collapse-cond="true">{{user_ea.activity_desc}}</label>
                                                                        </li>
                                                                        <li ng-if="user_ea.activity_file != '' && user_ea.activity_file != null">
                                                                            <span>Document</span>
                                                                            <p class="screen-shot" check-file-ext check-file="{{user_ea.activity_file}}" check-file-path="<?php echo "'".addslashes(JOB_USER_ACTIVITY_UPLOAD_URL)."'"; ?>">
                                                                            </p>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="view-more-activity" class="about-more" ng-if="user_activity.length > '3'">
                                                            <a href="#" ng-click="activity_view_more()">View More <img src="<?php echo base_url(); ?>assets/n-images/detail/down-arrow.png"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Extracurricular Activity End -->
                                    
                                    <!-- Achievements & Awards Start -->
                                    <div class="gallery-item">
                                        <div class="dtl-box">
                                            <div class="dtl-title">
                                                <img class="cus-width" src="<?php echo base_url(); ?>assets/n-images/detail/achi-awards.png"><span>Achievements & Awards</span><a href="#" data-target="#Achiv-awards" data-toggle="modal" ng-click="reset_awards_form();" class="pull-right" ng-if="live_slug == segment2"><img src="<?php echo base_url(); ?>assets/n-images/detail/detail-add.png"></a>
                                            </div>
                                            <div id="awards-loader" class="dtl-dis">
                                                <div class="text-center">
                                                    <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
                                                </div>
                                            </div>
                                            <div id="awards-body" style="display: none;">
                                                <div class="dtl-dis" ng-if="user_award.length < '1'">
                                                    <div class="no-info">
                                                        <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                                                        <span>Showcase the honour you have achieved to profile.</span>
                                                    </div>
                                                </div>
                                                <div class="dtl-dis dis-accor" ng-if="user_award.length > '0'">
                                                    <div class="panel-group" id="award-accordion" role="tablist" aria-multiselectable="true">
                                                        <div class="panel panel-default" ng-repeat="user_awrd in user_award" ng-if="$index <= view_more_award">
                                                            <div class="panel-heading" role="tab" id="award-{{$index}}">
                                                                <div class="panel-title">
                                                                    <div class="dis-left">
                                                                        <div class="dis-left-img">
                                                                            <span>{{user_awrd.award_title | limitTo:1 | uppercase}}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="dis-middle">
                                                                        <h4>{{user_awrd.award_title}}</h4>        
                                                                        <p>{{user_awrd.award_org}}</p>
                                                                    </div>
                                                                    <div class="dis-right">
                                                                        <span role="button" ng-click="edit_user_award($index)" class="pr5" ng-if="live_slug == segment2">
                                                                            <img src="<?php echo base_url(); ?>assets/n-images/detail/detial-edit.png">
                                                                        </span>
                                                                        <span role="button" data-toggle="collapse" data-parent="#award-accordion" href="#award{{$index}}" aria-expanded="true" aria-controls="exp1" class="up-down collapsed">
                                                                            <img src="<?php echo base_url(); ?>assets/n-images/detail/down-arrow.png">
                                                                        </span>
                                                                    </div>
                                 
                                                                </div>
                                                            </div>
                                                            <div id="award{{$index}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="award-{{$index}}">
                                                                <div class="panel-body">
                                                                    <ul class="dis-list">
                                                                        <li class="select-preview">
                                                                            <span>Date</span> 
                                                                            <label>{{user_awrd.award_date_str}}</label>
                                                                        </li>
                                                                        <li>
                                                                            <span>Description</span>
                                                                            <label class="inner-dis" dd-text-collapse dd-text-collapse-max-length="150" dd-text-collapse-text="{{user_awrd.award_desc}}" dd-text-collapse-cond="true">{{user_awrd.award_desc}}</label>
                                                                        </li>
                                                                        <li ng-if="user_awrd.award_file != '' && user_awrd.award_file != null">
                                                                            <span>Document</span>
                                                                            <p class="screen-shot" check-file-ext check-file="{{user_awrd.award_file}}" check-file-path="<?php echo "'".addslashes(JOB_USER_AWARD_UPLOAD_URL)."'"; ?>">
                                                                            </p>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="view-more-award" class="about-more" ng-if="user_award.length > '3'">
                                                            <a href="#" ng-click="award_view_more()">View More <img src="<?php echo base_url(); ?>assets/n-images/detail/down-arrow.png"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Achievements & Awards End -->
                                    
                                    <!-- Additional Course Start -->
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
                                                                    <ul class="dis-list">
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
                                                                            <p class="screen-shot" check-file-ext check-file="{{user_course.addicourse_file}}" check-file-path="<?php echo "'".addslashes(JOB_USER_ADDICOURSE_UPLOAD_URL)."'"; ?>">
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
                                    <!-- Additional Course End -->
                                    
                                    <!-- Professional summary -->
                                    <div class="gallery-item ">
                                        <div class="dtl-box">
                                            <div class="dtl-title">
                                                <img class="cus-width" src="<?php echo base_url('assets/n-images/detail/edution.png?ver=' . time()) ?>"><span>Professional Summary</span><a href="#" data-target="#prof-summary" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
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
                                    
                                    <!-- Research Start -->
                                    <div class="gallery-item">
                                        <div class="dtl-box">
                                            <div class="dtl-title">
                                                <img class="cus-width" src="<?php echo base_url(); ?>assets/n-images/detail/research.png"><span>Research</span><a href="#" ng-click="reset_research_form();" data-target="#research" data-toggle="modal" class="pull-right" ng-if="live_slug == segment2"><img src="<?php echo base_url(); ?>assets/n-images/detail/detail-add.png"></a>
                                            </div>
                                            <div id="research-loader" class="dtl-dis">
                                                <div class="text-center">
                                                    <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
                                                </div>
                                            </div>
                                            <div id="research-body" style="display: none;">
                                                <div class="dtl-dis" ng-if="user_research.length < '1'">
                                                    <div class="no-info">
                                                        <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                                                        <span>Show your analytics skills by adding your research work.</span>
                                                    </div>
                                                </div>
                                                <div class="dtl-dis dis-accor" ng-if="user_research.length > '0'">
                                                    <div class="panel-group" id="research-accordion" role="tablist" aria-multiselectable="true">
                                                        <div class="panel panel-default" ng-repeat="u_research in user_research" ng-if="$index <= view_more_research">
                                                            <div class="panel-heading" role="tab" id="research-{{$index}}">
                                                                <div class="panel-title">
                                                                    <div class="dis-left">
                                                                        <div class="dis-left-img">
                                                                            <span>{{u_research.research_title | limitTo:1 | uppercase}}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="dis-middle">
                                                                        <h4>{{u_research.research_title}}</h4>        
                                                                        <p ng-if="u_research.research_field == '0'">{{u_research.research_other_field}}</p>
                                                                        <p ng-if="u_research.research_field != '0'">{{u_research.research_field_txt}}</p>
                                                                    </div>
                                                                    <div class="dis-right">
                                                                        <span role="button" ng-click="edit_user_research($index)" class="pr5" ng-if="live_slug == segment2">
                                                                            <img src="<?php echo base_url(); ?>assets/n-images/detail/detial-edit.png">
                                                                        </span>
                                                                        <span role="button" data-toggle="collapse" data-parent="#research-accordion" href="#research{{$index}}" aria-expanded="true" aria-controls="exp1" class="up-down collapsed">
                                                                            <img src="<?php echo base_url(); ?>assets/n-images/detail/down-arrow.png">
                                                                        </span>
                                                                    </div>
                                 
                                                                </div>
                                                            </div>
                                                            <div id="research{{$index}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="research-{{$index}}">
                                                                <div class="panel-body">
                                                                    <ul class="dis-list">
                                                                        <li>
                                                                            <span>Publishing Date</span> 
                                                                            <label>{{u_research.research_publish_date_str}}</label>
                                                                        </li>                                                
                                                                        <li ng-if="u_research.research_url != '' && u_research.research_url != null">
                                                                            <span>Website</span>
                                                                            <div class="dis-list-link">
                                                                            <a href="{{u_research.research_url}}" target="_self">{{u_research.research_url}}</a>
                                                                            </div>
                                                                        </li>
                                                                        <li>
                                                                            <span>Description</span>
                                                                            <label class="inner-dis" dd-text-collapse dd-text-collapse-max-length="150" dd-text-collapse-text="{{u_research.research_desc}}" dd-text-collapse-cond="true">{{u_research.research_desc}}</label>
                                                                        </li>
                                                                        <li ng-if="u_research.research_document != '' && u_research.research_document != null">
                                                                            <span>Document</span>
                                                                            <p class="screen-shot" check-file-ext check-file="{{u_research.research_document}}" check-file-path="<?php echo "'".addslashes(JOB_USER_RESEARCH_UPLOAD_URL)."'"; ?>">
                                                                            </p>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="view-more-research" class="about-more" ng-if="user_research.length > '3'">
                                                            <a href="#" ng-click="research_view_more()">View More <img src="<?php echo base_url(); ?>assets/n-images/detail/down-arrow.png"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Research End -->
                                    
                                    <!-- Patent Start -->
                                    <div class="gallery-item">
                                        <div class="dtl-box">
                                            <div class="dtl-title">
                                                <img class="cus-width" src="<?php echo base_url(); ?>assets/n-images/detail/patent.png"><span>Patent</span><a href="#" data-target="#patent" data-toggle="modal" class="pull-right" ng-click="reset_patent_form();" ng-if="live_slug == segment2"><img src="<?php echo base_url(); ?>assets/n-images/detail/detail-add.png"></a>
                                            </div>
                                            <div id="patent-loader" class="dtl-dis">
                                                <div class="text-center">
                                                    <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
                                                </div>
                                            </div>
                                            <div id="patent-body" style="display: none;">
                                                <div class="dtl-dis" ng-if="user_patent.length < '1'">
                                                    <div class="no-info">
                                                        <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                                                        <span>Do you have an innovative mind? Show your inventions.</span>
                                                    </div>
                                                </div>
                                                <div class="dtl-dis dis-accor" ng-if="user_patent.length > '0'">
                                                    <div class="panel-group" id="patent-accordion" role="tablist" aria-multiselectable="true">
                                                        <div class="panel panel-default" ng-repeat="user_ptn in user_patent" ng-if="$index <= view_more_patent">
                                                            <div class="panel-heading" role="tab" id="patent-{{$index}}">
                                                                <div class="panel-title">
                                                                    <div class="dis-left">
                                                                        <div class="dis-left-img">
                                                                            <span>{{user_ptn.patent_title | limitTo:1 | uppercase}}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="dis-middle">
                                                                        <h4>{{user_ptn.patent_title}}</h4>        
                                                                        <p>{{user_ptn.patent_creator}}</p>
                                                                    </div>
                                                                    <div class="dis-right">
                                                                        <span role="button" ng-click="edit_user_patent($index)" class="pr5" ng-if="live_slug == segment2">
                                                                            <img src="<?php echo base_url(); ?>assets/n-images/detail/detial-edit.png">
                                                                        </span>
                                                                        <span role="button" data-toggle="collapse" data-parent="#patent-accordion" href="#patent{{$index}}" aria-expanded="true" aria-controls="exp1" class="up-down collapsed">
                                                                            <img src="<?php echo base_url(); ?>assets/n-images/detail/down-arrow.png">
                                                                        </span>
                                                                    </div>
                                 
                                                                </div>
                                                            </div>
                                                            <div id="patent{{$index}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="patent-{{$index}}">
                                                                <div class="panel-body">
                                                                    <ul class="dis-list">
                                                                        <li>
                                                                            <span>Patent Number</span> 
                                                                            <label>{{user_ptn.patent_number}}</label>
                                                                        </li>
                                                                        <li>
                                                                            <span>Published Date</span> 
                                                                            <label>{{user_ptn.patent_date_str}}</label>
                                                                        </li>
                                                                        <li>
                                                                            <span>Patent Office</span>
                                                                            <label>{{user_ptn.patent_office}}</label>
                                                                        </li>
                                                                        <li ng-if="user_ptn.patent_url != '' && user_ptn.patent_url != null">
                                                                            <span>Patent link</span>
                                                                            <div class="dis-list-link">
                                                                            <a href="{{user_ptn.patent_url}}" target="_self">{{user_ptn.patent_url}}</a>
                                                                            </div>
                                                                        </li>
                                                                        <li>
                                                                            <span>Description</span>
                                                                            <label class="inner-dis" dd-text-collapse dd-text-collapse-max-length="150" dd-text-collapse-text="{{user_ptn.patent_desc}}" dd-text-collapse-cond="true">{{user_ptn.patent_desc}}</label>
                                                                        </li>
                                                                        <li ng-if="user_ptn.patent_file != '' && user_ptn.patent_file != null">
                                                                            <span>Document</span>
                                                                            <p class="screen-shot" check-file-ext check-file="{{user_ptn.patent_file}}" check-file-path="<?php echo "'".addslashes(JOB_USER_PATENT_UPLOAD_URL)."'"; ?>">
                                                                            </p>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="view-more-patent" class="about-more" ng-if="user_patent.length > '3'">
                                                            <a href="#" ng-click="patent_view_more()">View More <img src="<?php echo base_url(); ?>assets/n-images/detail/down-arrow.png"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Patent End -->
                                    
                                    <!-- Publication Start -->
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
                                                                    <ul class="dis-list">
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
                                                                            <p class="screen-shot" check-file-ext check-file="{{user_pub.pub_file}}" check-file-path="<?php echo "'".addslashes(USER_PUBLICATION_UPLOAD_URL)."'"; ?>">
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
                                    <!-- Publication End -->
                                    
                                    <!-- Software  -->
                                    <div class="gallery-item ">
                                        <div class="dtl-box">
                                            <div class="dtl-title">
                                                <img class="cus-width" src="<?php echo base_url('assets/n-images/detail/edution.png?ver=' . time()) ?>"><span>Software</span><a href="#" data-target="#software" data-toggle="modal" class="pull-right" ng-if="live_slug == segment2"><img src="<?php echo base_url('assets/n-images/detail/detail-add.png?ver=' . time()) ?>"></a>
                                            </div>
                                            <div id="software-loader" class="dtl-dis">
                                                <div class="text-center">
                                                    <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
                                                </div>
                                            </div>
                                            <div id="software-body" style="display: none;">
                                                <div class="dtl-dis">
                                                     <div class="no-info" ng-if="user_software.length < '1'">
                                                        <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                                                        <span>No Software.</span>
                                                    </div>
                                                    <ul class="skill-list" ng-if="user_software.length > '0'">
                                                        <li ng-repeat="software in user_software">{{software}}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="right-add add-detail">                                
                                <div class="right-add-box"> 
                                    <div class="dtl-box p10 dtl-adv">
                                    </div>
                                </div>
                                <div class="rsp-dtl-box">
                                    <div class="dtl-box">
                                        <div class="dtl-title">
                                            <img class="cus-width" src="<?php echo base_url('assets/n-images/detail/e-profile.png?ver=' . time()) ?>"><span>Edit Profile</span>
                                        </div>
                                        <div class="dtl-dis dtl-edit-p">
                                            <div class="dtl-edit-top"></div>
                                            <div class="profile-status">
                                                <ul>
                                                    <li><span class=""></span>Profile pic</li>
                                                    <li class="pl20"><span class=""><img src="<?php echo base_url('assets/n-images/detail/c.png?ver=' . time()) ?>"></span>Cover pic</li>
                                                    
                                                    <li><span class=""></span>Experience</li>
                                                    <li class="pl20"><span class=""><img src="<?php echo base_url('assets/n-images/detail/c.png?ver=' . time()) ?>"></span>About</li>
                                                    <li><span class=""><img src="<?php echo base_url('assets/n-images/detail/c.png?ver=' . time()) ?>"></span>skills</li>
                                                    
                                                    <li class="pl20"><span class=""></span>Social</li>
                                                    <li><span class=""><img src="<?php echo base_url('assets/n-images/detail/c.png?ver=' . time()) ?>"></span>Idol</li>
                                                    <li class="fw"><span class=""><img src="<?php echo base_url('assets/n-images/detail/c.png?ver=' . time()) ?>"></span>Educational info</li>
                                                    <li class="fw"><span class=""></span>Profile overview</li>
                                                </ul>
                                            </div>
                                            <div class="dtl-edit-bottom"></div>
                                            <div class="p20">
                                                <img src="<?php echo base_url('assets/n-images/detail/profile-progressbar.jpg?ver=' . time()) ?>">
                                            </div>                                                
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
                                
                                <!-- language  -->
                                <div class="rsp-dtl-box ">
                                    <div class="dtl-box">
                                        <div class="dtl-title">
                                            <img class="cus-width" src="<?php echo base_url('assets/n-images/detail/edution.png?ver=' . time()) ?>"><span>Language</span><a href="#" data-target="#language" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/detail-add.png?ver=' . time()) ?>"></a>
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
                                                    <span>No Language.</span>
                                                </div>
                                                <ul ng-if="user_languages.length > 0" class="known-language">
                                                    <!-- <li><span class="pr5">Hindi</span> - <span class="pl5">Basic</span></li>
                                                    <li><span class="pr5">English</span> - <span class="pl5">Intermediate</span></li>
                                                    <li><span class="pr5">Gujrati</span> - <span class="pl5">Expert</span></li> -->
                                                    <li ng-repeat="user_lang in user_languages">
                                                        <span class="pr5">{{user_lang.language_name}}</span> - <span class="pl5">{{user_lang.proficiency}}</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>                    
                                
                                
                                <!-- resume  -->
                                <div class="rsp-dtl-box ">
                                    <div class="dtl-box">
                                        <div class="dtl-title">
                                            <img class="cus-width" src="<?php echo base_url('assets/n-images/detail/edution.png?ver=' . time()) ?>"><span>Resume</span><a href="#" data-target="#resume" data-toggle="modal" class="pull-right" ng-click="reset_user_resume();"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
                                        </div>
                                        <div id="resume-loader" class="dtl-dis">
                                            <div class="text-center">
                                                <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
                                            </div>
                                        </div>
                                        <div id="resume-body" style="display: none;">
                                            <div class="dtl-dis resume-img">
                                                <div class="no-info" ng-if="user_resume == ''">
                                                    <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                                                    <span>No Resume.</span>
                                                </div>
                                                <a href="<?php echo JOB_USER_RESUME_UPLOAD_URL; ?>{{user_resume}}" ng-if="user_resume != ''" target="_self">
                                                    <img src="<?php echo base_url('assets/n-images/detail/file-up-cus.png?ver=' . time()) ?>">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Hobbies  -->
                                <div class="rsp-dtl-box ">
                                    <div class="dtl-box">
                                        <div class="dtl-title">
                                            <img class="cus-width" src="<?php echo base_url('assets/n-images/detail/edution.png?ver=' . time()) ?>"><span>Hobbies</span><a href="#" data-target="#hobbies" data-toggle="modal" class="pull-right" ng-if="live_slug == segment2"><img src="<?php echo base_url('assets/n-images/detail/detail-add.png?ver=' . time()) ?>"></a>
                                        </div>
                                        <div id="hobbies-loader" class="dtl-dis">
                                            <div class="text-center">
                                                <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
                                            </div>
                                        </div>
                                        <div id="hobbies-body" style="display: none;">
                                            <div class="dtl-dis">
                                                <div class="no-info" ng-if="user_hobbies.length < '1'">
                                                    <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                                                    <span>No Hobbies.</span>
                                                </div>
                                                <ul class="skill-list" ng-if="user_hobbies.length > '0'">
                                                    <li ng-repeat="hobbies in user_hobbies">{{hobbies}}</li>
                                                </ul>
                                                <!-- <ul class="skill-list">
                                                    <li>Cricket</li>
                                                    <li>Hockey</li>
                                                    <li>Football</li>
                                                    <li>Basketball</li>
                                                    <li>Tenish</li>
                                                </ul> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
				    <div class="clearfix"></div>
                </div>
            </div>
        </section>

        <!-- All Model Start -->
        <!---  model basic information  -->
        <div style="display:none;" class="modal fade dtl-modal" id="job-basic-info" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">×</button>
                    <div class="modal-body-cus"> 
                        <div class="dtl-title">
                            <span>Basic Information</span>
                        </div>
                        <form name="basic_info_form" id="basic_info_form" ng-validate="basic_info_validate">
                            <div class="dtl-dis">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label>First Name</label>
                                            <input type="text" placeholder="First Name" id="basic_fname" name="basic_fname">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Last Name</label>
                                            <input type="text" placeholder="Last Name" id="basic_lname" name="basic_lname">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Email </label>
                                            <input type="text" placeholder="Email" id="basic_email" name="basic_email">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Phone Number</label>
                                            <input type="text" placeholder="Phone Number" id="basic_phone" name="basic_phone">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Job Title</label>
                                    <!-- <input type="text" placeholder="Job Title"> -->
                                    <input type="text" placeholder="Enter Job Title" id="basic_jobtitle" name="basic_jobtitle" ng-model="basic_jobtitle" ng-keyup="basic_job_title_list()" typeahead="item as item.name for item in titleSearchResult | filter:$viewValue" autocomplete="off">
                                </div>
                                
                                <div class="row">
                                    
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Field</label>
                                            <span class="span-select">
                                                <?php $getFieldList = $this->data_model->getNewFieldList();?>
                                                <select name="basic_field" id="basic_field" ng-model="basic_field" ng-change="basic_other_field_fnc()">
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
                                            <label>Gender </label>
                                            <span class="span-select">
                                                <select id="basic_gender" name="basic_gender" ng-model="basic_gender" >
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                    <option value="other">Other</option>
                                                </select>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div id="basic_other_field_div" class="row" style="display: none;">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                        <label>Other Field</label>
                                        <input type="text" placeholder="Enter Other Field" id="basic_other_field" name="basic_other_field" ng-model="basic_other_field">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6"></div>
                                </div>
                                <div class="form-group dtl-dob">
                                    <label>Date of Birth</label>
                                    <div class="row">
                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                            <span class="span-select">
                                                <select id="dob_month" name="dob_month" ng-model="dob_month" ng-change="dob_fnc('','','')">
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
                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                            <span class="span-select">
                                                <select id="dob_day" name="dob_day" ng-model="dob_day" ng-click="dob_error()">
                                                </select>
                                            </span>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                            <span class="span-select">
                                                <select id="dob_year" name="dob_year" ng-model="dob_year" ng-change="dob_fnc('','','')" ng-click="dob_error()">
                                                </select>
                                            </span>
                                        </div>
                                        <div class="col-md-12 col-sm-12">
                                            <span id="dateerror" class="error" style="display: none;"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group dtl-dob">
                                    <label>Current Location</label>
                                    <div class="row">
                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                            <span class="span-select">
                                                <select id="basic_country" name="basic_country" ng-model="basic_country" ng-change="basic_country_change()">
                                                    <option value="">Country</option>         
                                                    <option data-ng-repeat='country_item in exp_country_list' value='{{country_item.country_id}}'>{{country_item.country_name}}</option>
                                                </select>
                                            </span>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                            <span class="span-select">
                                                <select id="basic_state" name="basic_state" ng-model="basic_state" ng-change="basic_state_change()" disabled = "disabled">
                                                    <option value="">State</option>
                                                    <option data-ng-repeat='state_item in basic_state_list' value='{{state_item.state_id}}'>{{state_item.state_name}}</option>
                                                </select>
                                                <img id="basic_state_loader" src="<?php echo base_url('assets/img/spinner.gif') ?>" style="   width: 20px;position: absolute;top: 6px;right: 19px;display: none;">
                                            </span>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                            <span class="span-select">
                                                <select id="basic_city" name="basic_city" ng-model="basic_city" disabled = "disabled">
                                                    <option value="">City</option>
                                                    <option data-ng-repeat='city_item in basic_city_list' value='{{city_item.city_id}}'>{{city_item.city_name}}</option>
                                                </select>
                                                <img id="basic_city_loader" src="<?php echo base_url('assets/img/spinner.gif') ?>" style="   width: 20px;position: absolute;top: 6px;right: 19px;display: none;">
                                            </span>
                                        </div>
                                    </div>                                
                                </div>
                                <div class="form-group">
                                    <label></label>
                                    <input type="text" placeholder="Postal Address" id="basic_address" name="basic_address">
                                </div>
                            </div>
                            <div class="dtl-btn">
                                <!-- <a href="#" class="save"><span>Save</span></a> -->
                                <a id="save_basic_info" href="#" ng-click="save_basic_info()" class="save"><span>Save</span></a>
                                <div id="basic_info_loader" class="dtl-popup-loader" style="display: none;">
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

                                            <!-- <tags-input id="exp_designation" name="exp_designation" ng-model="exp_designation" display-property="name" placeholder="Enter Designation" replace-spaces-with-dashes="false" template="title-template" on-tag-added="onKeyup()" min-length="1" ng-keyup="exp_designation_fnc()">
                                                <auto-complete source="loadJobtitle($query)" load-on-focus="false" load-on-empty="false" max-results-to-show="32" template="title-autocomplete-template"></auto-complete>
                                            </tags-input>                        
                                            <script type="text/ng-template" id="title-template">
                                                <div class="tag-template"><div class="right-panel"><span>{{$getDisplayText()}}</span><a class="remove-button" ng-click="$removeTag()">&#10006;</a></div></div>
                                            </script>
                                            <script type="text/ng-template" id="title-autocomplete-template">
                                                <div class="autocomplete-template"><div class="right-panel"><span ng-bind-html="$highlight($getDisplayText())"></span></div></div>
                                            </script> -->
                                            
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
        

        <!---  model Preferred Job Details  -->
        <div style="display:none;" class="modal fade dtl-modal" id="preferred-job" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">×</button>
                    <div class="modal-body-cus"> 
                        <div class="dtl-title">
                            <span>Preferred Job Details</span>
                        </div>
                        <form name="preferred_form" id="preferred_form" ng-validate="preferred_validate">
                            <div class="dtl-dis">
                                <div class="form-group">
                                    <label>Preferred Job Title</label>
                                    <!-- <input type="text" placeholder="Preferred Job Title"> -->
                                    <input type="text" placeholder="Preferred Job Title" id="preferred_jobtitle" name="preferred_jobtitle" ng-model="preferred_jobtitle" ng-keyup="preferred_job_title_list()" typeahead="item as item.name for item in preferred_job_title_res | filter:$viewValue" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label>Perferred Location / Region</label>
                                    <!-- <input type="text" placeholder="Perferred Location / Region">    -->
                                    <tags-input id="preferred_location" ng-model="edit_preferred_location" display-property="city" placeholder="Perferred Location / Region" replace-spaces-with-dashes="false" template="title-template" ng-keyup="preferred_location_fnc()" on-tag-added="onKeyup()">
                                        <auto-complete source="loadCities($query)" min-length="0" load-on-focus="false" load-on-empty="false" max-results-to-show="32" template="title-autocomplete-template"></auto-complete>
                                    </tags-input>                        
                                    <script type="text/ng-template" id="title-template">
                                        <div class="tag-template"><div class="right-panel"><span>{{$getDisplayText()}}</span><a class="remove-button" ng-click="$removeTag()">&#10006;</a></div></div>
                                    </script>
                                    <script type="text/ng-template" id="title-autocomplete-template">
                                        <div class="autocomplete-template"><div class="right-panel"><span ng-bind-html="$highlight($getDisplayText())"></span></div></div>
                                    </script>
                                </div>                           
                                
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Preferred Industry</label>
                                            <span class="span-select">
                                                <?php $getFieldList = $this->data_model->getNewFieldList();?>
                                                <select name="preferred_field" id="preferred_field" ng-model="preferred_field" ng-change="preferred_other_field_fnc()">
                                                    <option value="" disabled="">Select Field</option>
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
                                            <label>How far are you wiling to travel?(km)</label>
                                            <!-- <input type="text" id="preferred_travel" name="preferred_travel" placeholder="How far are you wiling to travel?">  -->
                                            <select id="preferred_travel" name="preferred_travel">
                                                <option value="1">0 to 100</option>
                                                <option value="2">101 to 500</option>
                                                <option value="3">501 to 1000</option>
                                                <option value="4">Any Where</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div id="preferred_other_field_div" class="row" style="display: none;">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                            <label>Other Field</label>
                                            <input type="text" placeholder="Enter Other Field" id="preferred_other_field" name="preferred_other_field" ng-model="preferred_other_field">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6"></div>
                                    </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <label>Company Culture</label>
                                            <span class="span-select">
                                                <select id="preferred_cmp_culture" name="preferred_cmp_culture">
                                                    <option value="Traditional">Traditional</option>
                                                    <option value="Corporate">Corporate</option>
                                                    <option value="Start-Up">Start-Up</option>
                                                    <option value="Free Spirit">Free Spirit</option>
                                                    <option value="Don't Specify">Don't Specify</option>
                                                    <option value="others">others</option>
                                                </select>
                                            </span> 
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <label>Work Time / Schedule</label>
                                            <span class="span-select">
                                                <select id="preferred_work_time" name="preferred_work_time">
                                                    <option value="Day">Day</option>
                                                    <option value="Night">Night</option>
                                                    <option value="Flexible">Flexible</option>
                                                </select>
                                            </span> 
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group dtl-dob">
                                    <label>Expected Salary</label>
                                    <div class="row">
                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                            <input type="text" placeholder="Amount" id="exp_salary_amt" name="exp_salary_amt" maxlength="10">
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                            <span class="span-select">
                                                <?php $currency = $this->data_model->get_currency_list();?>
                                                <select name="preferred_currency" id="preferred_currency" ng-model="preferred_currency">
                                                    <option value="" disabled="">Select Currency</option>
                                                    <?php foreach ($currency as $key => $value) { ?>
                                                        <option value="<?php echo $value['currency_id']; ?>""><?php echo $value['currency_name']; ?></option>
                                                    <?php } ?>
                                                </select>                                            
                                            </span>
                                        </div>
                                        
                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                            <span class="span-select">
                                                <select id="exp_salary_worktype" name="exp_salary_worktype">
                                                    <option value="1">Per hour</option>
                                                    <option value="2">Monthly</option>
                                                    <option value="3">Yearly</option>
                                                </select>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>More Details</label>
                                    <textarea type="text" placeholder="Description" id="preferred_moredetail" name="preferred_moredetail"></textarea>
                                </div>
                            </div>
                            <div class="dtl-btn">
                                <!-- <a href="#" class="save"><span>Save</span></a> -->
                                <a id="save_preferred_job" href="#" ng-click="save_preferred_job()" class="save"><span>Save</span></a>
                                <div id="preferred_job_loader" class="dtl-popup-loader" style="display: none;">
                                <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" >
                                </div>
                            </div>
                        </form>
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
                        <form name="user_resume_form" id="user_resume_form" ng-validate="user_resume_validate">
                            <div class="dtl-dis">
                                <div class="form-group">
                                    <!-- <label class="upload-file">
                                        Upload File <input type="file">
                                    </label> -->
                                    <label>Upload File</label>
                                    <input type="file" id="user_resume_file" name="user_resume_file">
                                    <span id="user_resume_error" class="error" style="display: none;"></span>
                                </div>
                        
                            </div>
                            <div class="dtl-btn bottom-btn">
                                <!-- <a href="#" class="save"><span>Save</span></a> -->
                                <a id="save_user_resume" href="#" ng-click="save_user_resume()" class="save"><span>Save</span></a>
                                <div id="user_resume_loader" class="dtl-popup-loader" style="display: none;">
                                <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" >
                                </div>
                            </div>
                        </form>
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
                                <tags-input id="hobby_txt" ng-model="hobby_txt" display-property="hobby" placeholder="Enter hobbies" replace-spaces-with-dashes="false" template="title-template">
                                </tags-input>
                            </div>                    
                        </div>
                        <div class="dtl-btn bottom-btn">
                            <!-- <a href="#" class="save"><span>Save</span></a> -->
                            <a id="user_hobby_save" href="#" ng-click="save_user_hobbies()" class="save"><span>Save</span></a>
                            <div id="user_hobby_loader" class="dtl-popup-loader" style="display: none;">
                                <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader">
                            </div>
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
                                <!-- <textarea type="text" placeholder="Passion and Intrest"></textarea> -->
                                <textarea name="passion_user" id="passion_user" ng-model="passion_user" type="text" placeholder="Passion and Intrest" maxlength="700">{{passion_user}}</textarea>
                                <span class="pull-right">{{700 - passion_user.length}}</span>
                            </div>
                    
                        </div>
                        <div class="dtl-btn bottom-btn">
                            <!-- <a href="#" class="save"><span>Save</span></a> -->
                            <a id="passion_user_save" href="#" ng-click="save_passion_user()" class="save"><span>Save</span></a>
                            <div id="passion_user_loader" class="dtl-popup-loader" style="display: none;">
                                <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader">
                            </div>
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
                                                <input type="text" name="language[]" ng-model="language[100].lngtxt" ng-keyup="get_languages(100)" class="form-control language" placeholder="Enter Language"  id="language" typeahead="item as item.language_name for item in lang_search_result | filter:$viewValue"  autocomplete="off" ng-value="primari_lang.language_name" value="{{primari_lang.language_name}}">
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
                                                    <input type="text" name="language[]" ng-model="language[$index].lngtxt" ng-keyup="get_languages($index)" class="form-control language" placeholder="Enter Language"  id="language" typeahead="item as item.language_name for item in lang_search_result | filter:$viewValue" autocomplete="off" ng-value="field.language_name" value="{{field.language_name}}">
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
                                <!-- <textarea type="text" placeholder=""></textarea> -->
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
                                <tags-input id="software_txt" ng-model="software_txt" display-property="software" placeholder="Professional Summary" replace-spaces-with-dashes="false" template="title-template">
                                </tags-input>
                            </div>                    
                        </div>
                        <div class="dtl-btn bottom-btn">
                            <!-- <a href="#" class="save"><span>Save</span></a> -->
                            <a id="user_software_save" href="#" ng-click="save_user_software()" class="save"><span>Save</span></a>
                            <div id="user_software_loader" class="dtl-popup-loader" style="display: none;">
                                <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader">
                            </div>
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
                                <label>Project Description</label>
                                <textarea type="text" placeholder="Enter Project Details" id="project_desc" name="project_desc" minlength="50" maxlength="700"></textarea>
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
        <div class="modal fade message-box biderror" id="delete-project-model" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>         
                    <div class="modal-body">
                        <span class="mes">
                            <div class='pop_content'>
                                <span>Are you sure you want to delete project ?</span>
                                <p class='poppup-btns pt20'>
                                    <span id="project-delete-btn">
                                        <a id="delete_user_project" href="#" ng-click="delete_user_project()" class="btn1">
                                            <span>Delete</span>
                                        </a> 
                                        <a class='btn1' href="#" data-dismiss="modal">Cancel</a>
                                    </span>
                                    <img id="user_project_del_loader" src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" style="display: none;padding: 16px 15px 15px;">
                                </p>
                            </div>
                        </span>
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
        
        <!---  model Extracurricular Activity  -->
        <div style="display:none;" class="modal fade dtl-modal" id="extra-activity" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">×</button>
                    <div class="modal-body-cus"> 
                        <div class="dtl-title">
                            <span>Extracurricular Activity</span>
                        </div>
                        <form name="activity_form" id="activity_form" ng-validate="activity_validate">
                        <div class="dtl-dis">
                            <div class="form-group">
                                <label>Participated In</label>
                                <input type="text" placeholder="Enter Title" id="activity_participate" name="activity_participate">
                            </div>
                            <div class="form-group">
                                <label>Organization</label>
                                <input type="text" placeholder="Enter Organization" id="activity_org" name="activity_org">
                            </div>
                            <div class="">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        
                                        <label>Start Date</label>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                            <div class="form-group">
                                                <span class="span-select">
                                                    <select id="activity_s_year" name="activity_s_year" ng-model="activity_s_year" ng-change="activity_start_year();">
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
                                                    <select id="activity_s_month" name="activity_s_month">
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
                                                    <select id="activity_e_year" name="activity_e_year">
                                                    </select>
                                                </span>
                                            </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                            <div class="form-group">
                                                <span class="span-select">
                                                    <select id="activity_e_month" name="activity_e_month">
                                                        <option value="">Month</option>
                                                    </select>
                                                </span>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12">
                                        <span id="activitydateerror" class="error" style="display: none;"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea type="text" placeholder="Enter Description" id="activity_desc" name="activity_desc"></textarea>
                            </div>
                            
                            <div class="form-group">
                                <div class="upload-file">
                                    <label>Upload File (Extracurricular Activity Certificate)</label>
                                    <input type="file" id="activity_file" name="activity_file">
                                    <span id="activity_file_error" class="error" style="display: none;"></span>
                                </div>
                            </div>
                            
                        </div>
                        <div class="dtl-btn">
                            <!-- <a href="#" class="save"><span>Save</span></a> -->
                            <a id="user_activity_save" href="#" ng-click="save_user_activity()" class="save"><span>Save</span></a>
                            <div id="user_activity_loader" class="dtl-popup-loader" style="display: none;">
                            <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" >
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade message-box biderror" id="delete-activity-model" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>         
                    <div class="modal-body">
                        <span class="mes">
                            <div class='pop_content'>
                                <span>Are you sure you want to delete extracurricular activity ?</span>
                                <p class='poppup-btns pt20'>
                                    <span id="activity-delete-btn">
                                        <a id="delete_user_activity" href="#" ng-click="delete_user_activity()" class="btn1">
                                            <span>Delete</span>
                                        </a> 
                                        <a class='btn1' href="#" data-dismiss="modal">Cancel</a>
                                    </span>
                                    <img id="user_activity_del_loader" src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" style="display: none;padding: 16px 15px 15px;">
                                </p>
                            </div>
                        </span>
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
                        <form name="award_form" id="award_form" ng-validate="award_validate">
                        <div class="dtl-dis">
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" placeholder="Enter Title" id="award_title" name="award_title">
                            </div>
                            <div class="form-group">
                                <label>Organization</label>
                                <input type="text" placeholder="Enter Organization" id="award_org" name="award_org">
                            </div>
                            <div class="">
                                <label>Date</label>
                                <div class="row">
                                    <div class="col-md-4 col-sm-4 col-xs-4 fw-479">
                                    <div class="form-group">
                                        <span class="span-select">
                                            <select id="award_month" name="award_month" ng-model="award_month" ng-change="award_date_fnc('','','')">
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
                                            <select id="award_day" name="award_day" ng-model="award_day" ng-click="award_error()"></select>
                                        </span>
                                    </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-4 fw-479">
                                    <div class="form-group">
                                        <span class="span-select">
                                            <select id="award_year" name="award_year" ng-model="award_year" ng-change="award_date_fnc('','','')" ng-click="award_error()">
                                            </select>
                                        </span>
                                    </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12">
                                        <span id="awarddateerror" class="error" style="display: none;"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea type="text" placeholder="Enter Description" id="award_desc" name="award_desc"></textarea>
                            </div>                    
                            <div class="form-group">
                                <div class="upload-file">
                                    <label>Upload File (Achievements & Awards Certificate)</label>
                                    <input type="file" id="award_file" name="award_file">
                                    <span id="award_file_error" class="error" style="display: none;"></span>
                                </div>
                            </div>
                            
                        </div>
                        <div class="dtl-btn">
                            <!-- <a href="#" class="save"><span>Save</span></a> -->
                            <a id="user_award_save" href="#" ng-click="save_user_award()" class="save"><span>Save</span></a>
                            <div id="user_award_loader"  class="dtl-popup-loader" style="display: none;">
                            <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" >
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade message-box biderror" id="delete-award-model" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>         
                    <div class="modal-body">
                        <span class="mes">
                            <div class='pop_content'>
                                <span>Are you sure you want to delete achievement & award ?</span>
                                <p class='poppup-btns pt20'>
                                    <span id="award-delete-btn">
                                        <a id="delete_user_award" href="#" ng-click="delete_user_award()" class="btn1">
                                            <span>Delete</span>
                                        </a> 
                                        <a class='btn1' href="#" data-dismiss="modal">Cancel</a>
                                    </span>
                                    <img id="user_award_del_loader" src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" style="display: none;padding: 16px 15px 15px;">
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
                                <label>Description</label>
                                <textarea type="text" placeholder="Enter Description" id="pub_desc" name="pub_desc" minlength="10" maxlength="700"></textarea>
                            </div>                    
                            <div class="form-group">
                                <div class="upload-file">
                                    <label>Upload File (Publication Certificate)</label>
                                    <input type="file" id="pub_file" name="pub_file">
                                    <span id="pub_file_error" class="error" style="display: none;">File size must be less than 10MB.</span>
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
        
        <!---  model Patent  -->
        <div style="display:none;" class="modal fade dtl-modal" id="patent" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">×</button>
                    <div class="modal-body-cus"> 
                        <div class="dtl-title">
                            <span>Patent</span>
                        </div>
                        <form name="patent_form" id="patent_form" ng-validate="patent_validate">
                            <div class="dtl-dis">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <label>Patent Title</label>
                                            <input type="text" placeholder="Enter Title" id="patent_title" name="patent_title" ng-model="patent_title">
                                        </div>                                
                                    </div>
                                </div>
                                <div class="">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Patent Creator / Innovator</label>
                                            <input type="text" placeholder="Enter Name" id="patent_creator" name="patent_creator" ng-model="patent_creator">
                                        </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Patent Number</label>
                                            <input type="text" placeholder="Enter Number" id="patent_number" name="patent_number" ng-model="patent_number">
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <label>Patent Date</label>
                                    <div class="row">
                                        <div class="col-md-4 col-sm-4 col-xs-4 fw-479">
                                        <div class="form-group">
                                            <span class="span-select">
                                                <select id="patent_month" name="patent_month" ng-model="patent_month" ng-change="patent_date_fnc('','','')">
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
                                                <select id="patent_day" name="patent_day" ng-model="patent_day" ng-click="patent_date_error()"></select>
                                            </span>
                                        </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-4 fw-479">
                                        <div class="form-group">
                                            <span class="span-select">
                                                <select id="patent_year" name="patent_year" ng-model="patent_year" ng-change="patent_date_fnc('','','')" ng-click="patent_date_error()">
                                                </select>
                                            </span>
                                        </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12">
                                            <span id="patentdateerror" class="error" style="display: none;"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Patent Office</label>
                                            <input type="text" placeholder="Enter Office Name" id="patent_office" name="patent_office" ng-model="patent_office">
                                        </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Patent URL <span class="link-must">(Must be http:// or https://)</span></label>
                                            <input type="text" placeholder="Enter URL" id="patent_url" name="patent_url" ng-model="patent_url">
                                            
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea type="text" placeholder="Enter Description" id="patent_desc" name="patent_desc" ng-model="patent_desc"></textarea>
                                </div>
                                <div class="form-group">
                                    <div class="upload-file">
                                        <label>Upload File</label>
                                        <input type="file" id="patent_file" name="patent_file">
                                        <span id="patent_file_error" class="error" style="display: none;">File size must be less than 10MB.</span>
                                    </div>
                                </div>                        
                            </div>
                            <div class="dtl-btn">
                                <!-- <a href="#" class="save"><span>Save</span></a> -->
                                <a id="user_patent_save" href="#" ng-click="save_user_patent()" class="save"><span>Save</span></a>
                                <div id="user_patent_loader"  class="dtl-popup-loader" style="display: none;">
                                <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" >
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade message-box biderror" id="delete-patent-model" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>         
                    <div class="modal-body">
                        <span class="mes">
                            <div class='pop_content'>
                                <span>Are you sure you want to delete patent ?</span>
                                <p class='poppup-btns pt20'>
                                    <span id="patent-delete-btn">
                                        <a id="delete_user_patent" href="#" ng-click="delete_user_patent()" class="btn1">
                                            <span>Delete</span>
                                        </a> 
                                        <a class='btn1' href="#" data-dismiss="modal">Cancel</a>
                                    </span>
                                    <img id="user_patent_del_loader" src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" style="display: none;padding: 16px 15px 15px;">
                                </p>
                            </div>
                        </span>
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
                            <form name="research_form" id="research_form" ng-validate="research_validate">
                                <div class="dtl-dis">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" placeholder="Enter Title" id="research_title" name="research_title" ng-model="research_title" minlength="20" maxlength="200">
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label>Field</label>
                                                <span class="span-select">
                                                    <?php $getFieldList = $this->data_model->getNewFieldList();?>
                                                    <select name="research_field" id="research_field" ng-model="research_field" ng-change="other_field_research()">
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
                                                <label>URL <span class="link-must">(Must be http:// or https://)</span></label>
                                                <input type="text" placeholder="Enter URL" id="research_url" name="research_url" ng-model="research_url">
                                              
                                            </div>
                                        </div>
                                    </div>

                                    <div id="research_other_field_div" class="row" style="display: none;">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label>Other Field</label>
                                                <input type="text" placeholder="Enter other field" id="research_other_field" name="research_other_field" ng-model="research_other_field">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">                                    
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Details</label>
                                        <textarea placeholder="Enter Details" id="research_desc" name="research_desc" ng-model="research_desc" minlength="20" maxlength="700"></textarea>
                                    </div>
                                    
                                    <div class="">
                                        <label>Publishing Date</label>
                                        <div class="row">
                                            <div class="col-md-4 col-sm-4 col-xs-4 fw-479">
                                            <div class="form-group">
                                                <span class="span-select">
                                                    <select id="research_month" name="research_month" ng-model="research_month" ng-change="research_pub_fnc('','','')">
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
                                                    <select id="research_day" name="research_day" ng-model="research_day" ng-click="research_error()">
                                                </select>                                    
                                                </span>
                                            </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-4 fw-479">
                                            <div class="form-group">
                                                <span class="span-select">                                            
                                                    <select id="research_year" name="research_year" ng-model="research_year" ng-change="research_pub_fnc('','','')" ng-click="research_error()">
                                                    </select>
                                                </span>
                                            </div>
                                            </div>
                                            <div class="col-md-12 col-sm-12">
                                                <span id="recdateerror" class="error" style="display: none;"></span>
                                            </div>
                                        </div>                            
                                    </div>                    
                                    
                                    <div class="form-group">
                                        <div class="upload-file">
                                            <label>Upload File</label>
                                            <input type="file" id="research_document" name="research_document">
                                            <span id="research_file_error" class="error" style="display: none;">File size must be less than 10MB.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="dtl-btn">
                                    <!-- <a href="#" class="save"><span>Save</span></a> -->
                                    <a id="user_research_save" href="#" ng-click="save_user_research()" class="save"><span>Save</span></a>
                                    <div id="user_research_loader" class="dtl-popup-loader" style="display: none;"><img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" >
                                    </div>
                                </div>
                            </form>
                    </div>  


                </div>
            </div>
        </div>
        <div class="modal fade message-box biderror" id="delete-research-model" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>         
                    <div class="modal-body">
                        <span class="mes">
                            <div class='pop_content'>
                                <span>Are you sure you want to delete research ?</span>
                                <p class='poppup-btns pt20'>
                                    <span id="research-delete-btn">
                                        <a id="delete_user_research" href="#" ng-click="delete_user_research()" class="btn1">
                                            <span>Delete</span>
                                        </a> 
                                        <a class='btn1' href="#" data-dismiss="modal">Cancel</a>
                                    </span>
                                    <div id="user_research_del_loader" class="dtl-popup-loader" style="display: none;">
                                    <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" >
                                    </div>
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
        <!-- All Model End -->


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
        <!-- script for skill textbox automatic start-->

        <script src="<?php echo base_url('assets/js/croppie.js?ver=' . time()); ?>"></script> 
        <!-- script for skill textbox automatic end (option 2)-->
        <script src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>

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
            var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
            var live_slug = '<?php echo $live_slug; ?>';
            var base_url = '<?php echo base_url(); ?>';
            var count_profile_value = '<?php echo $count_profile_value; ?>';
            var count_profile = '<?php echo $count_profile; ?>';
            var user_data_slug = '<?php echo $get_url; ?>';
            var segment2 = '<?php echo $get_url; ?>';
            var user_slug = '<?php echo $get_url; ?>';
            var header_all_profile = '<?php echo $header_all_profile; ?>';
            var profile_pic = "";

            var job_user_experience_upload_url = '<?php echo JOB_USER_EXPERIENCE_UPLOAD_URL; ?>';
            var job_user_education_upload_url = '<?php echo JOB_USER_EDUCATION_UPLOAD_URL; ?>';
            var job_user_project_upload_url = '<?php echo JOB_USER_PROJECT_UPLOAD_URL; ?>';
            var job_user_patent_upload_url = '<?php echo JOB_USER_PATENT_UPLOAD_URL; ?>';
            var job_user_research_upload_url = '<?php echo JOB_USER_RESEARCH_UPLOAD_URL; ?>';
            var user_idol_upload_url = '<?php echo USER_IDOL_UPLOAD_URL; ?>';
            var user_publication_upload_url = '<?php echo USER_PUBLICATION_UPLOAD_URL; ?>';
            var job_user_award_upload_url = '<?php echo JOB_USER_AWARD_UPLOAD_URL; ?>';
            var job_user_activity_upload_url = '<?php echo JOB_USER_ACTIVITY_UPLOAD_URL; ?>';
            var job_user_addicourse_upload_url = '<?php echo JOB_USER_ADDICOURSE_UPLOAD_URL; ?>';
            var job_user_resume_upload_url = '<?php echo JOB_USER_RESUME_UPLOAD_URL; ?>';

            var app = angular.module("userJobProfileApp", ['ngRoute', 'ui.bootstrap', 'ngTagsInput', 'ngSanitize','angular-google-adsense', 'ngValidate']);
        </script>
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/job/job_printpreview.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/job/cover_profile_common.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/job/search_common.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/job/progressbar_common.js?ver=' . time()); ?>"></script>
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