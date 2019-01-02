<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php echo $head; ?>
        <?php if (IS_HIRE_CSS_MINIFY == '0') { ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/freelancer-hire.css?ver=' . time()); ?>">
        <?php } else { ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/freelancer-hire.css?ver=' . time()); ?>">
        <?php } ?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>" />
        <style type="text/css">
            #popup-form img{display: block;}
        </style>
    <?php $this->load->view('adsense'); ?>
</head>
    <body class="page-container-bg-solid page-boxed pushmenu-push botton_footer body-loader">
        <?php $this->load->view('page_loader'); ?>
        <div id="main_page_load" style="display: block;">

            <?php //echo $header; ?>
            <?php echo $freelancer_hire_header2;

            if($freelancr_user_data[0]['is_indivdual_company'] == '2')
            {
                $is_copm_indu = 2;
                $fullname = ucwords($freelancr_user_data[0]['comp_name']);
                if($freelancr_user_data[0]['company_field'] != 0)
                {
                    $designation = $this->db->get_where('industry_type', array('industry_id' => $freelancr_user_data[0]['company_field']))->row()->industry_name;
                }
                else
                {
                    $designation = $freelancr_user_data[0]['company_other_field'];
                }
                $sub_fullname = substr($fullname, 0, 1);
                $no_img_name = $sub_fullname;
            }
            else
            {
                $is_copm_indu = 1;
                $fname = $freelancr_user_data[0]['fullname'];
                $lname = $freelancr_user_data[0]['username'];
                $fullname = ucwords($fname) . ' ' . ucwords($lname);

                $designation = $freelancr_user_data[0]['designation'];

                $sub_fname = substr($fname, 0, 1);
                $sub_lname = substr($lname, 0, 1);
                $no_img_name = $sub_fname.$sub_lname;
            }
            ?>
            <section class="custom-row">
                <div class="container" id="paddingtop_fixed">
                    <div class="row" id="row1" style="display:none;">
                        <div class="col-md-12 text-center">
                            <div id="upload-demo"></div>
                        </div>
                        <div class="col-md-12 cover-pic" >
                            <button class="btn btn-success cancel-result" onclick=""><?php echo $this->lang->line("cancel"); ?></button>

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
                                ?>

                                <img alt="<?php echo $freelancr_user_data[0]['fullname'] . " " . $freelancr_user_data[0]['username']; ?>" src="<?php echo FREE_HIRE_BG_MAIN_UPLOAD_URL . $image[0]['profile_background']; ?>" name="image_src" id="image_src" />
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
                <div class="container tablate-container  art-profile">    
                    <?php if ($returnpage == '') { ?>
                        <div class="upload-img">
                            <label class="cameraButton"><span class="tooltiptext"><?php echo $this->lang->line("upload_cover_photo"); ?></span><i class="fa fa-camera" aria-hidden="true"></i>
                                <input type="file" id="upload" name="upload" accept="image/*;capture=camera" onclick="showDiv()">
                            </label>
                        </div>
                        <!-- cover image end-->
                    <?php } ?>
                    <div class="profile-photo">
                        <div class="profile-pho">
                            <div class="user-pic padd_img">
                                <?php                                
                                if ($freelancr_user_data[0]['freelancer_hire_user_image']) {
                                    if (IMAGEPATHFROM == 'upload') {
                                            ?>
                                            <img src="<?php echo FREE_HIRE_PROFILE_MAIN_UPLOAD_URL . $freelancr_user_data[0]['freelancer_hire_user_image']; ?>" alt="<?php echo $freelancr_user_data[0]['fullname'] . " " . $freelancr_user_data[0]['username']; ?>" >
                                            <?php
                                        
                                    } else {
                                        $filename = $this->config->item('free_hire_profile_main_upload_path') . $freelancr_user_data[0]['freelancer_hire_user_image'];
                                        $s3 = new S3(awsAccessKey, awsSecretKey);
                                        $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                        if ($info) {
                                            ?>
                                            <img src="<?php echo FREE_HIRE_PROFILE_MAIN_UPLOAD_URL . $freelancr_user_data[0]['freelancer_hire_user_image']; ?>" alt="<?php echo $freelancr_user_data[0]['fullname'] . " " . $freelancr_user_data[0]['username']; ?>" >
                                            <?php
                                        } else {
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
                                <a title="Update Profile Picture" href="javascript:void(0);" class="cusome_upload" onclick="updateprofilepopup();"><img alt="Update Profile Picture"  src="<?php echo base_url('assets/img/cam.png'); ?>"><?php echo $this->lang->line("update_profile_picture"); ?></a>
                            </div>
                        </div>
                        <div class="job-menu-profile mob-block">
                            <a title="<?php echo ucwords($fullname); ?>" href="javascript:void(0);">
                                <h3> <?php echo ucwords($fullname); ?></h3>
                            </a>
                            
                        </div>         
                        <div class="profile-main-rec-box-menu profile-box-art col-md-12 padding_les">
                            <div class=" right-side-menu art-side-menu padding_less_right  right-menu-jr">    <?php
                                $userid = $this->session->userdata('aileenuser');
                                if ($freelancr_user_data[0]['user_id'] == $userid) {
                                    ?>     
                                    <ul class="current-user pro-fw">
                                    <?php } else { ?>
                                        <ul class="pro-fw4">
                                        <?php } ?>                                    
                                        <li <?php if (($this->uri->segment(1) == 'freelance-employer') && ($this->uri->segment(2) != 'projects') && ($this->uri->segment(2) != 'saved-freelancer') && ($this->uri->segment(3) == '')) { ?> class="active" <?php } ?>><a title="Employer Details" href="<?php echo base_url('freelance-employer/'. $free_hire_login_slug); ?>">Employer Details</a>
                                        </li>
                                        <?php if (($this->uri->segment(1) == 'freelance-employer') && ($this->uri->segment(2) == 'projects' || $this->uri->segment(2) == 'employer-details' || $this->uri->segment(1) == 'post-freelance-project' || $this->uri->segment(2) == 'saved-freelancer') && ($this->uri->segment(3) == $this->session->userdata('aileenuser') || $this->uri->segment(3) == '')) { ?>
                                            <li rel="stylesheet" type="text/css" href="" <?php if (($this->uri->segment(1) == 'freelance-employer') && ($this->uri->segment(2) == 'projects')) { ?> class="active" <?php } ?>><a title="Projects" href="<?php echo base_url('freelance-employer/projects'); ?>">Projects</a>
                                            </li>
                                            <li <?php if (($this->uri->segment(1) == 'freelance-employer') && ($this->uri->segment(2) == 'saved-freelancer')) { ?> class="active" <?php } ?>><a title="Saved Freelancer" href="<?php echo base_url('freelance-employer/saved-freelancer'); ?>">Saved Freelancer</a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container mobp0">
                    <div class="job-menu-profile mob-none job_edit_menu">
                        <a title="<?php echo ucwords($fullname); ?>" href="javascript:void(0);">
                            <h3><?php echo ucwords($fullname); ?></h3>
                        </a>                        
                    
                    </div>
                    <div class="cus-inner-middle mob-clear mobp0">
						<div class="tab-add-991">
							<?php $this->load->view('banner_add'); ?>
						</div>
                        <div class="common-form">
                            <div class="job-saved-box">
                                <h3><?php echo $this->lang->line("saved_freelancer"); ?></h3>
                                <div class="contact-frnd-post">
                                    <!--.......AJAX DATA.......-->
                                    <div class="fw" id="loader" style="text-align:center;"><img alt="loader" src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) ?>" /></div>
                                </div>
                            </div>
                        </div>
						<div class="banner-add">
							<?php $this->load->view('banner_add'); ?>
						</div>
                    </div>
					<div class="right-add">
						<?php $this->load->view('right_add_box');
                        if ($freelancr_user_data[0]['user_id'] == $this->session->userdata('aileenuser')) {?>
                            <div class="right-add-box">
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
                        <?php } ?>

					</div>
                </div>
            </section>
            <?php echo $login_footer ?>
            <?php echo $footer; ?>
        </div>
    <!-- model for popup start -->
    <div class="modal fade message-box biderror" id="bidmodal" role="dialog">
        <div class="modal-dialog modal-lm">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">&times;</button>         
                <div class="modal-body">
                    <!--<img class="icon" src="images/dollar-icon.png" alt="" />-->
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
                                    <div id="upload-demo-one" style="width:350px"></div>
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
    <?php if (IS_HIRE_JS_MINIFY == '0') { ?>
        <script  src="<?php echo base_url('assets/js/croppie.js?ver=' . time()); ?>"></script>
        <script  type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>">
        </script>
    <?php } else { ?>
        <script  src="<?php echo base_url('assets/js_min/croppie.js?ver=' . time()); ?>"></script>
        <script  type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver=' . time()); ?>">
        </script>
    <?php } ?>
    <script>
        var base_url = '<?php echo base_url(); ?>';
        var no_saved = '<?php echo $this->lang->line("no_saved_freelancer"); ?>';    
        var header_all_profile = '<?php echo $header_all_profile; ?>';
        var fh_slug = "<?php echo $free_hire_login_slug; ?>";
    </script>               
    <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
    <script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-hire/freelancer_save.js?ver=' . time()); ?>"></script>
    <script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-hire/freelancer_hire_common.js?ver=' . time()); ?>"></script>
    <script src="<?php echo base_url('assets/js/progressloader.js?ver=' . time()); ?>"></script>
</body>
</html>