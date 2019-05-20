<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php echo $head; ?>
        <?php
        if (IS_BUSINESS_CSS_MINIFY == '0') {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/business.css?ver=' . time()); ?>">
            <?php
        } else {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/business.css?ver=' . time()); ?>">
        <?php } ?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>" />
    <?php $this->load->view('adsense'); ?>
</head>
    <body class="page-container-bg-solid page-boxed pushmenu-push botton_footer body-loader">
        <?php $this->load->view('page_loader'); ?>
        <div id="main_page_load" style="display: block;">
            <?php echo $header; ?>
            <?php echo $business_header2; ?> 
            <section>
                <?php echo $business_common; ?>
                <div class="user-midd-section">
                    <div class="container mobp0">
                        <div class="bus-inner">
                            <div class="custom-user-list bus-art-cus-left">
                                <div class="common-form">
									<div class="tab-add-991">
										<?php $this->load->view('banner_add'); ?>
									</div>
                                    <div class="job-saved-box">
                                        <h3> Followers</h3>
                                        <div class="contact-frnd-post">
                                            <!-- AJAX DATA... -->
                                            <div class="col-md-1">
                                            </div>
                                        </div>
										<div class="banner-add">
											<?php $this->load->view('banner_add'); ?>
										</div>
                                        <div class="fw" id="loader" style="text-align:center;"><img src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) ?>" alt="Loader"/></div>
                                    </div>
									
                                </div>
                            </div>
							<div class="right-add">
								<?php $this->load->view('right_add_box'); ?>
							</div>
						</div>
                    </div>
                </div>
            </section>        
            <?php echo $login_footer ?>
            <?php echo $footer; ?>
        </div>
        <div class="modal fade message-box" id="query" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="profile-modal-close" id="query" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes">
                        </span>
                    </div>
                </div>
            </div>
        </div>
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
        <div class="modal fade message-box" id="bidmodal-2" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes">
                            <div id="popup-form">
                                <?php echo form_open_multipart(base_url('business_profile/user_image_insert'), array('id' => 'userimage', 'name' => 'userimage', 'class' => 'clearfix')); ?>
                                <input type="file" name="profilepic" accept="image/gif, image/jpeg, image/png" id="profilepic">
                                <input type="hidden" name="hitext" id="hitext" value="7">
                                <div class="popup_previred">
                                    <img id="preview" src="#" alt="your image"/>
                                </div>
                                <input type="submit" name="profilepicsubmit" id="profilepicsubmit" value="Save" >
                                <?php echo form_close(); ?>
                            </div>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <script>
            var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
            var base_url = '<?php echo base_url(); ?>';
            var slug_id = '<?php echo $slug_id; ?>';
            var my_profile = '<?php echo $my_profile; ?>';
            var header_all_profile = '<?php echo $header_all_profile; ?>';
        </script>
        <script src="http://chat.aileensoul.localhost/socket.io/socket.io.js"></script>
        <script type="text/javascript">
            var socket = io.connect('http://chat.aileensoul.localhost:3000/');
        </script>
        <script src="<?php echo base_url('assets/js/croppie.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/business-profile/followers.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" defer="defer" src="<?php echo base_url('assets/js/webpage/business-profile/common.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/notification.js?ver=' . time()) ?>"></script>
    </body>
</html>