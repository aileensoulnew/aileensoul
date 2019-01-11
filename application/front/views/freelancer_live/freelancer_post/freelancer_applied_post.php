<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php echo $head; ?>
        <?php
        if (IS_APPLY_CSS_MINIFY == '0') {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/freelancer-apply.css?ver=' . time()); ?>">
            <?php
        } else {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/freelancer-apply.css?ver=' . time()); ?>">
        <?php } ?>
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css'); ?>">
        <?php $this->load->view('adsense'); ?>
    </head>
    <body class="page-container-bg-solid page-boxed botton_footer body-loader">
        <?php $this->load->view('page_loader'); ?>
        <div id="main_page_load" style="display: block;">
            <?php //echo $header; ?>
            <?php echo $freelancer_post_header2;
            if($freelancerpostdata[0]['is_indivdual_company'] == '1')
            {
                $first_name = ucwords($freelancerpostdata[0]['freelancer_post_fullname']);
                $last_name = ucwords($freelancerpostdata[0]['freelancer_post_username']);
                $fullname = $first_name.' '.$last_name;
                $name_no_img = strtoupper(substr($first_name, 0,1).substr($last_name, 0,1));
                $is_indivdual_company = 1;
            }
            else
            {
                $fullname = ucwords($freelancerpostdata[0]['comp_name']);
                $name_no_img = strtoupper(substr($fullname, 0,1));
                $is_indivdual_company = 2;
            }
            $userid = $this->session->userdata('aileenuser');
            $login_slug = $this->db->select('freelancer_apply_slug')->get_where('freelancer_post_reg', array('user_id' => $userid, 'status' => '1'))->row()->freelancer_apply_slug;
                                ?>
            <section class="custom-row">
                <div class="container" id="paddingtop_fixed">
                    <div class="row" id="row1" style="display:none;">
                        <div class="col-md-12 text-center">
                            <div id="upload-demo" ></div>
                        </div>
                        <div class="col-md-12 cover-pic" >
                            <button class="btn btn-success cancel-result"><?php echo $this->lang->line("cancel"); ?></button>
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
                            if ($this->uri->segment(3) == $userid) {
                                $user_id = $userid;
                            } elseif ($this->uri->segment(3) == "") {
                                $user_id = $userid;
                            } else {
                                $user_id = $this->uri->segment(3);
                            }
                            $contition_array = array('user_id' => $user_id, 'is_delete' => '0', 'status' => '1');
                            $image = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'profile_background', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                            $image_ori = $image[0]['profile_background'];
                            if ($image_ori) {
                                ?>
                                <img alt="<?php echo $freepostdata['freelancer_post_fullname'] . " " . $freepostdata['freelancer_post_username']; ?>" src="<?php echo FREE_POST_BG_MAIN_UPLOAD_URL . $image[0]['profile_background']; ?>" name="image_src" id="image_src" />
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
                    <div class="upload-img">
                        <label class="cameraButton"><span class="tooltiptext"><?php echo $this->lang->line("upload_cover_photo"); ?></span><i class="fa fa-camera" aria-hidden="true"></i>
                            <input type="file" id="upload" name="upload" accept="image/*;capture=camera" onclick="showDiv()">
                        </label>
                    </div>
                    <div class="profile-photo">
                        <div class="profile-pho">
                            <div class="user-pic padd_img">
                                <?php                                
                                if ($freepostdata['freelancer_post_user_image']) {
                                    if (IMAGEPATHFROM == 'upload') { ?>
                                        <img src="<?php echo FREE_POST_PROFILE_MAIN_UPLOAD_URL . $freepostdata['freelancer_post_user_image']; ?>" alt="<?php echo $fullname; ?>" >
                                    <?php
                                    } else {
                                        $filename = $this->config->item('free_post_profile_main_upload_path') . $freepostdata['freelancer_post_user_image'];
                                        $s3 = new S3(awsAccessKey, awsSecretKey);
                                        $info = $s3->getObjectInfo(bucket, $filename);
                                        if ($info) {
                                            ?>
                                            <img src="<?php echo FREE_POST_PROFILE_MAIN_UPLOAD_URL . $freepostdata['freelancer_post_user_image']; ?>" alt="<?php echo $fullname; ?>" >
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
                                <a title="Update Profile Picture" href="javascript:void(0);" class="cusome_upload" onclick="updateprofilepopup();"><img alt="Update Profile Picture"  src="<?php echo base_url('assets/img/cam.png'); ?>"><?php echo $this->lang->line("update_profile_picture"); ?></a>
                            </div>

                        </div>
                        <div class="job-menu-profile mob-block ">
                            <a title="<?php echo ucwords($fullname); ?>" href="javascript:void(0);">
                                <h3><?php echo ucwords($fullname); ?></h3>
                            </a>                            
                        </div>
                        <div class="profile-main-rec-box-menu profile-box-art col-md-12 padding_les">
                            <div class=" right-side-menu art-side-menu padding_less_right  right-menu-jr">
                                <?php                                
                                if ($freepostdata['user_id'] == $userid) {
                                    ?>     
                                    <ul class="current-user pro-fw">
                                    <?php } else { ?>
                                        <ul class="pro-fw4">
                                        <?php } ?>  
                                        <li <?php if (($this->uri->segment(1) == 'freelancer') && ($this->uri->segment(2) == 'freelancer-details')) { ?> class="active" <?php } ?>><a title="Freelancer Details" href="<?php echo base_url('freelancer/'.$login_slug); ?>">
                                                <?php echo $this->lang->line("freelancer_details"); ?></a>
                                        </li>
                                        <?php if (($this->uri->segment(1) == 'freelancer') && ($this->uri->segment(2) == 'freelancer-details' || $this->uri->segment(2) == 'home' || $this->uri->segment(2) == 'saved-projects' || $this->uri->segment(2) == 'applied-projects') && ($this->uri->segment(3) == $this->session->userdata('aileenuser') || $this->uri->segment(3) == '')) { ?>
                                            <li <?php if (($this->uri->segment(1) == 'freelancer') && ($this->uri->segment(2) == 'saved-projects')) { ?> class="active" <?php } ?>><a title="Saved Post" href="<?php echo base_url('freelancer/saved-projects'); ?>"><?php echo $this->lang->line("saved_projects"); ?></a>
                                            </li>
                                            <li <?php if (($this->uri->segment(1) == 'freelancer') && ($this->uri->segment(2) == 'applied-projects')) { ?> class="active" <?php } ?>><a title="Applied Post" href="<?php echo base_url('freelancer/applied-projects'); ?>"><?php echo $this->lang->line("applied_projects"); ?></a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container padding_set_res mobp0">
                    <div class="job-menu-profile mob-none job_edit_menu">
                        <a title="<?php echo ucwords($fullname); ?>" href="javascript:void(0);">
                            <h3> <?php echo ucwords($fullname); ?></h3>
                        </a>                        
                    </div>
                    <div class="cus-inner-middle mob-clear mobp0">
						<div class="tab-add-991">
							<?php $this->load->view('banner_add'); ?>
						</div>
                        <div class="mob-progressbar fw">
                            <p>Complete your profile to get connected with more people.</p>
                            <p class="mob-edit-pro">
                                <a href="<?php echo base_url('freelancer/').$login_slug; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit Profile</a>
                            </p>
                            <div class="progress skill-bar ">
                                <div class="progress-bar progress-bar-custom" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                                    <span class="skill"><i class="val">0%</i></span>
                                </div>
                            </div>
                        </div>
                        <div class="page-title">
                            <h3>Applied Projects</h3>
                        </div>
                        <div class="job-contact-frnd1">
                        </div>
						<div class="banner-add">
							<?php $this->load->view('banner_add'); ?>
						</div>
                        <div id="loader" style="display: none;"><p style="text-align:center;"><img alt="loader" class="loader" src="<?php echo base_url('assets/images/loading.gif'); ?>"/></p></div>
                    </div>
                    <div class="right-add">
                        <?php $this->load->view('right_add_box'); ?>
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
                <div class="clearfix"></div>
            </section>
            <?php echo $login_footer ?>
            <?php echo $footer; ?>
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
            <!-- model for popup start -->
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
        </div>
        <!-- <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()) ?>"></script> -->
        <script  src="<?php echo base_url('assets/js/croppie.js?ver=' . time()); ?>"></script>
        <script  type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/progressloader.js?ver=' . time()); ?>">
        </script>

        <script>
            var base_url = '<?php echo base_url(); ?>';
            var count_profile_value = '<?php echo $count_profile_value; ?>';
            var count_profile = '<?php echo $count_profile; ?>';
            var header_all_profile = '<?php echo $header_all_profile; ?>';
            var freelancer_apply_slug = '<?php echo $freelancerpostdata[0]['freelancer_apply_slug']; ?>';
        </script>
        <script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-apply/freelancer_applied_post.js?ver=' . time()); ?>"></script>
        <script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-apply/freelancer_apply_common.js?ver=' . time()); ?>"></script>
        <script async type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-apply/progressbar.js?ver=' . time()); ?>"></script>
    </body>
</html>