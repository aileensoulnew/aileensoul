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
               
				<div class="clearfix"></div>
			</div>
        </section>
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
    </body>
</html>