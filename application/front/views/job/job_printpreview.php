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
                                                <a href="#" data-target="#job-basic-info" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
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
                                                                        <span role="button" data-toggle="collapse" data-parent="#edu-accordion" href="#edu{{$index}}" aria-expanded="true" aria-controls="exp1">
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
                                                                            <img src="<?php echo base_url('assets/n-images/art-img.jpg?ver=' . time()) ?>">
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
                                                                        <span role="button" data-toggle="collapse" data-parent="#project-accordion" href="#project{{$index}}" aria-expanded="true" aria-controls="exp1">
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
                                                <img class="cus-width" src="<?php echo base_url('assets/n-images/detail/edution.png?ver=' . time()) ?>">
                                                <span>Passion and Interest</span>
                                                <a href="#" data-target="#passion-intrest" data-toggle="modal" class="pull-right">
                                                    <img src="<?php echo base_url('assets/n-images/detail/detail-add.png?ver=' . time()) ?>">
                                                </a>
                                            </div>
                                            <div class="dtl-dis">
                                                <p>Lorem ipsum is a dummy text its a use for the same. and its working with the same part of the population. </p>
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
                                                                        <span role="button" data-toggle="collapse" data-parent="#activity-accordion" href="#activity{{$index}}" aria-expanded="true" aria-controls="exp1">
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

            var user_experience_upload_url = '<?php echo USER_EXPERIENCE_UPLOAD_URL; ?>';
            var job_user_education_upload_url = '<?php echo JOB_USER_EDUCATION_UPLOAD_URL; ?>';
            var job_user_project_upload_url = '<?php echo JOB_USER_PROJECT_UPLOAD_URL; ?>';
            var user_patent_upload_url = '<?php echo USER_PATENT_UPLOAD_URL; ?>';
            var user_research_upload_url = '<?php echo USER_RESEARCH_UPLOAD_URL; ?>';
            var user_idol_upload_url = '<?php echo USER_IDOL_UPLOAD_URL; ?>';
            var user_publication_upload_url = '<?php echo USER_PUBLICATION_UPLOAD_URL; ?>';
            var user_award_upload_url = '<?php echo USER_AWARD_UPLOAD_URL; ?>';
            var job_user_activity_upload_url = '<?php echo JOB_USER_ACTIVITY_UPLOAD_URL; ?>';
            var user_addicourse_upload_url = '<?php echo USER_ADDICOURSE_UPLOAD_URL; ?>';

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