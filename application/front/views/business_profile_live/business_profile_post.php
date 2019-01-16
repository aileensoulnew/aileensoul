<?php
$s3 = new S3(awsAccessKey, awsSecretKey);
$mobile_agent = $this->agent->mobile;
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <meta name="description" content="<?php echo $metadesc; ?>" />
        <?php echo $head; ?>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/dragdrop/fileinput.css?ver=' . time()); ?>">
        <link href="<?php echo base_url('assets/dragdrop/themes/explorer/theme.css?ver=' . time()); ?>" media="all" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/business.css?ver=' . time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/as-videoplayer/build/mediaelementplayer.css?ver=' . time()); ?>" />
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>" />
        
        <style type="text/css">
            .two-images, .three-image, .four-image{
                height: auto !important;
            }
            .mejs__overlay-button {
                background-image: url("https://www.aileensoul.com/assets/as-videoplayer/build/mejs-controls.svg");
            }
            .mejs__overlay-loading-bg-img {
                background-image: url("https://www.aileensoul.com/assets/as-videoplayer/build/mejs-controls.svg");
            }
            .mejs__button > button {
                background-image: url("https://www.aileensoul.com/assets/as-videoplayer/build/mejs-controls.svg");
            }
        </style>
    <?php $this->load->view('adsense'); ?>
</head>
    <body class="page-container-bg-solid page-boxed pushmenu-push body-loader">
        <?php $this->load->view('page_loader'); ?>
        <div id="main_page_load" style="display: block;">
        <?php echo $header; ?>
        <?php echo $business_header2; ?>
        <?php // echo $business_header2_border; ?>
        <section>
            <div class="user-midd-section bui_art_left_box" id="paddingtop_fixed">
                <div class="container art_container padding-360">
                    <div class="profile-box-custom fl animated fadeInLeftBig left_side_posrt" >
                        <div class="left_fixed">
                            <?php echo $business_left; ?>
                            <?php
                            if ($follow_user_suggest_count > 0) {
                                ?>
                                <div class="full-box-module_follow fw">
                                    <div class="common-form">
                                        <h3 class="user_list_head">User List
                                        </h3>
                                        <div class="seeall">
                                            <a href="<?php echo base_url('company/' . $business_common_data[0]['business_slug']) . '/userlist'; ?>">View all
                                            </a>
                                        </div>
                                    </div>
                                    <div class="profile-boxProfileCard_follow fw  module">
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
							<?php $this->load->view('right_add_box'); ?>
                          <?php echo $left_footer; ?>
                        </div>
                        <br>
                        <div id="result"></div>   
                    </div>
                    <?php
                    if ($this->session->flashdata('error')) {
                        echo $this->session->flashdata('error');
                    }
                    ?>
                    <div class=" custom-right-art mian_middle_post_box animated fadeInUp">
                        <div class="right_side_posrt fl"> 
							
                            <div class="post-editor col-md-12">
                                <div class="main-text-area col-md-12">
                                    <div class="popup-img"> 
                                        <?php if ($business_common_data[0]['business_user_image']) { ?>
                                            <?php
                                            if (IMAGEPATHFROM == 'upload') {
                                                if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_common_data[0]['business_user_image'])) {
                                                    ?>
                                                    <img  src="<?php echo base_url(NOBUSIMAGE); ?>"  alt="">
                                                <?php } else {
                                                    ?>
                                                    <img src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL . $business_common_data[0]['business_user_image'] . '?ver=' . time(); ?>"  alt="<?php echo $business_common_data[0]['company_name']; ?>">
                                                    <?php
                                                }
                                            } else {
                                                $filename = $this->config->item('bus_profile_thumb_upload_path') . $business_common_data[0]['business_user_image'];
                                                $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                                if (!$info) {
                                                    ?>
                                                    <img src="<?php echo base_url(NOBUSIMAGE); ?>"  alt="No Image">
                                                <?php } else {
                                                    ?>
                                                    <img  src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL . $business_common_data[0]['business_user_image'] . '?ver=' . time(); ?>"  alt="<?php echo $business_common_data[0]['company_name']; ?>">
                                                    <?php
                                                }
                                            }
                                        } else {
                                            ?>
                                            <img  src="<?php echo base_url(NOBUSIMAGE); ?>"  alt="No Business Image">
                                        <?php } ?>
                                    </div>
                                    <div id="myBtn"  class="editor-content popup-text" onclick="return modelopen();">
                                        <span> <?php echo $this->lang->line("post_your_product"); ?></span> 
                                        <div class="padding-left padding_les_left camer_h">
                                            <i class="fa fa-camera"></i> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bs-example">
                                <div class="progress progress-striped" id="progress_div">
                                    <div class="progress-bar" style="width: 0%;">
                                        <span class="sr-only">0%</span>
                                    </div>
                                </div>
                            </div>
							
                            <div class="custom-user-list-cus">
                                <div class="mob-progressbar fw">
                                    <p>Complete your profile to get connected with more people.</p>
                                    <p class="mob-edit-pro">
                                        <a href="<?php echo base_url()."company/".$business_common_data[0]['business_slug']."/details"; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit Profile</a>
                                    </p>
                                    <div class="progress skill-bar ">
                                        <div class="progress-bar progress-bar-custom" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                                            <span class="skill"><i class="val">0%</i></span>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                if ($follow_user_suggest_count > 0) {
                                    ?>
                                    <div class="full-box-module_follow fw">
                                        <div class="common-form">
                                            <h3 class="user_list_head">User List
                                            </h3>
                                            <div class="seeall">
                                                <a href="<?php echo base_url('company/' . $business_common_data[0]['business_slug']) . '/userlist'; ?>">View all
                                                </a>
                                            </div>
                                        </div>
                                        <div class="profile-boxProfileCard_follow fw  module">
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="business-all-post">
                                <div class="nofoundpost"></div>
                            </div>
							<!-- <div class="banner-add">
								<?php //$this->load->view('banner_add'); ?>
							</div> -->
                            <div class="fw" id="loader" style="text-align:center; display: none;"><img src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) . '?ver=' . time() ?>" alt="Loader" /></div>
                        </div>
                    </div>
                    
					<div id="hideuserlist" class="right_middle_side_posrt fixed_right_display animated fadeInRightBig"> 
                        <?php $this->load->view('right_add_box'); ?>
                        <div id="profile-progress" class="edit_profile_progress right-add-box" style="display: none;">
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
            </div>
        </section>
        </div>
        <div id="myModal" class="modal-post" data-backdrop="static" data-keyboard="false">
            <div class="modal-content-post">
                <span class="close1">&times;
                </span>
                <div class="post-editor col-md-12 post-edit-popup" id="close">
                    <?php echo form_open_multipart(base_url('business-profile/bussiness-profile-post-add'), array('id' => 'artpostform', 'name' => 'artpostform', 'class' => 'clearfix upload-image-form', 'onsubmit' => "return imgval(event)")); ?>
                    <div class="main-text-area col-md-12" >
                        <div class="popup-img-in"> 
                            <?php
                            if ($business_common_data[0]['business_user_image'] != '') {
                                ?>
                                <?php
                                if (IMAGEPATHFROM == 'upload') {
                                    if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_common_data[0]['business_user_image'])) {
                                        ?>
                                        <img  src="<?php echo base_url(NOBUSIMAGE); ?>"  alt="No Image">
                                    <?php } else {
                                        ?>
                                        <img src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL . $business_common_data[0]['business_user_image'] . '?ver=' . time(); ?>"  alt="<?php echo $business_common_data[0]['company_name']; ?>">
                                        <?php
                                    }
                                } else {
                                    $filename = $this->config->item('bus_profile_thumb_upload_path') . $business_common_data[0]['business_user_image'];
                                    $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                    if (!$info) {
                                        ?>
                                        <img  src="<?php echo base_url(NOBUSIMAGE); ?>"  alt="No Image">
                                    <?php } else {
                                        ?>
                                        <img src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL . $business_common_data[0]['business_user_image'] . '?ver=' . time(); ?>"  alt="<?php echo $business_common_data[0]['company_name']; ?>">
                                        <?php
                                    }
                                }
                            } else {
                                ?>
                                <img  src="<?php echo base_url(NOBUSIMAGE); ?>"  alt="No Image">
                                <?php
                            }
                            ?>
                        </div>
                        <div id="myBtn1"  class="editor-content col-md-10 popup-text" >
                            <textarea id="test-upload-product" placeholder="<?php echo $this->lang->line("post_your_product"); ?>"  onKeyPress=check_length(this.form); onKeyUp=check_length(this.form); onKeyDown=check_length(this.form); onblur=check_length(this.form);  name=my_text rows=4 cols=30 class="post_product_name" style=" position: relative;" tabindex="1"></textarea>
                            <div class="fifty_val">                       
                                <input size=1 value=50 name=text_num class="text_num"  disabled="disabled"> 
                            </div>
                            <div class="camera_in padding-left padding_les_left camer_h">
                                <i class=" fa fa-camera" >
                                </i> 
                            </div>
                        </div>
                    </div>
                    <div class="row"></div>
                    <div  id="text"  class="editor-content col-md-12 popup-textarea" >
                        <textarea id="test-upload-des" name="product_desc" class="description" placeholder="Enter Description" tabindex="2"></textarea>
                    </div>
                    <div class="print_privew_post"></div>
                    <div class="preview"></div>
                    <div id="data-vid" class="large-8 columns"></div>
                    <h2 id="name-vid"></h2>
                    <p id="size-vid"></p>
                    <p id="type-vid"></p>
                    <div class="popup-social-icon">
                        <ul class="editor-header">
                            <li>
                                <div class="col-md-12"> 
                                    <div class="form-group">
                                        <input id="file-1" type="file" class="file" name="postattach[]"  multiple class="file" data-overwrite-initial="false" data-min-file-count="2" style="display: none;">
                                    </div>
                                </div>
                                <label for="file-1">
                                    <i class="fa fa-camera upload_icon"><span class="upload_span_icon"> Photo </span></i>
                                    <i class="fa fa-video-camera upload_icon"><span class="upload_span_icon"> Video</span>  </i> 
                                    <i class="fa fa-music upload_icon"> <span class="upload_span_icon">  Audio </span> </i>
                                    <i class="fa fa-file-pdf-o upload_icon"><span class="upload_span_icon"> PDF </span></i>
                                </label>
                            </li>
                        </ul>
                    </div>
                    <div class="fr margin_btm">
                        <button type="submit"  value="Submit">Post</button>    
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
        <div class="modal fade message-box biderror" id="bidmodal" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;
                    </button>       
                    <div class="modal-body">
                        <span class="mes"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade message-box biderror" id="posterrormodal" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="posterror-modal-close" data-dismiss="modal">&times;
                    </button>       
                    <div class="modal-body">
                        <span class="mes"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade message-box" id="likeusermodal" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close1" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade message-box" id="post" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" id="post"data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade message-box" id="postedit" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" id="postedit"data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes">
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <?php echo $footer; ?>

        <script>
            var base_url = '<?php echo base_url(); ?>';
            var no_business_post_html = '<?php echo $no_business_post_html ?>';
            var business_slug = '<?php echo $business_common_data[0]['business_slug'] ?>';
        </script>

        <script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
        <script type = "text/javascript" src="<?php echo base_url('assets/js/jquery.form.3.51.js?ver=' . time()) ?>"></script> 
        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/croppie.js?ver='.time()); ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/js/plugins/sortable.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/js/fileinput.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/js/locales/fr.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/js/locales/es.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/themes/explorer/theme.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/as-videoplayer/build/mediaelement-and-player.js?ver=' . time()); ?>"></script>
         <script>
             var header_all_profile = '<?php echo $header_all_profile; ?>';
        </script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/progressloader.js?ver=' . time()); ?>">
        </script>
         <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/as-videoplayer/demo.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/business-profile/common.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/business-profile/home.js?ver=' . time()); ?>"></script>        
        <script type="text/javascript">
            function open_popup(clicked_id)
            {
                var dropDownClass = document.getElementById('myDropdown' + clicked_id).className;
                dropDownClass = dropDownClass.split(" ").pop(-1);
                if (dropDownClass != 'show') {
                    $('.dropdown-content1').removeClass('show');
                    $('#myDropdown' + clicked_id).addClass('show');
                } else {
                    $('.dropdown-content1').removeClass('show');
                }
                $(document).on('keydown', function (e) {
                    if (e.keyCode === 27) {
                        document.getElementById('myDropdown' + clicked_id).classList.toggle("hide");
                        $(".dropdown-content1").removeClass('show');
                    }
                });
            }

        </script>

        <!-- out side click disable of post popup -->
       
    </body>
</html>
