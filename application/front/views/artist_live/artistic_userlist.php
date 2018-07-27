<!DOCTYPE html>
<html ng-app="userListApp" ng-controller="userController">
<head>
    <title><?php echo $title; ?></title>
    <?php echo $head; ?>


    <?php
    if (IS_ART_CSS_MINIFY == '0') {
        ?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver='.time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/artistic.css?ver='.time()); ?>">
    <?php }else{?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver='.time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/artistic.css?ver='.time()); ?>">
    <?php } ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>" />
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>" />
            <body   class="page-container-bg-solid page-boxed">
                <?php echo $header; ?>
                <?php echo $artistic_header2; ?>
                <section class="custom-row">
                    <div class="container" id="paddingtop_fixed">
                    </div>
                    <div class="user-midd-section art-inner bui_art_left_box">
                        <div class="container mobp0">
                            <div class="profile-box-custom fl animated fadeInLeftBig left_side_posrt" >
                                <?php echo $left_artistic; ?>

                                <div class="left-search-box list-type-bullet">
                                    <div class="">
                                        <h3>Top Categories</h3>
                                    </div>
                                    <ul class="search-listing">
                                        <li ng-repeat="category in artistCategory">
                                            <label class="control control--checkbox">
                                                <span>{{category.art_category | capitalize}}
													<span class="pull-right">({{category.count}})</span>
												</span>
                                                <input class="category-filter categorycheckbox" type="checkbox" name="{{category.art_category}}" value="{{category.category_id}}" style="height: 12px;" [attr.checked]="(category.isselected) ? 'checked' : null" autocomplete="false">
												<div class="control__indicator"></div>
                                            </label>
                                        </li>
                                    </ul>
                                    <p class="text-left p10"><a href="<?php echo artist_category_list ?>">View More Categories</a></p>
                                </div>

                                <div class="left-search-box list-type-bullet">
                                    <div class="">
                                        <h3>Top Locations</h3>
                                    </div>                        
                                    <ul class="search-listing" style="list-style: none;">
                                        <li ng-repeat="location in artistLocation">
                                            <label class="control control--checkbox">
                                                <span>{{location.art_location | capitalize}}
													<span class="pull-right">({{location.total}})</span>
												</span>
                                                <input class="locationcheckbox" type="checkbox" name="{{location.art_location}}" value="{{location.location_id}}" style="height: 12px;" [attr.checked]="(location.isselected) ? 'checked' : null" autocomplete="false">
                                               <div class="control__indicator"></div>
                                            </label>
                                        </li>
                                    </ul>
                                    <p class="text-left p10"><a href="<?php echo artist_location_list ?>">View More Locations</a></p>
                                </div>
								<?php $this->load->view('right_add_box'); ?>

                                <?php echo $left_footer; ?> 
                            </div>

                            <div class=" custom-right-art mian_middle_post_box animated fadeInUp">
                                <div class="">  
									<div class="tab-add">
										<?php $this->load->view('banner_add'); ?>
									</div>
                                    <div class="right_side_posrt fl"> 
                                        <div>
                                            <?php
                                            if ($this->session->flashdata('error')) {
                                                echo '<div class="alert alert-danger">' . $this->session->flashdata('error') . '</div>';
                                            }
                                            if ($this->session->flashdata('success')) {
                                                echo '<div class="alert alert-success">' . $this->session->flashdata('success') . '</div>';
                                            }
                                            ?>
                                        </div> 
                                        <div class="common-form">
                                            <div class="job-saved-box">
                                                <h3>Userlist</h3>
                                                <div class="contact-frnd-post">
                                                    <div class="job-contact-frnd ">
                                                    </div>
                                                    <div class="fw" id="loader" style="text-align:center;"><img src="<?php echo base_url('assets/images/loader.gif?ver='.time()) ?>" alt="<?php echo "loader.gif"; ?>"/></div>
                                                    <div class="col-md-1">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div id="hideuserlist" class="right_middle_side_posrt fixed_right_display animated fadeInRightBig"> 
								<?php $this->load->view('right_add_box'); ?>
                            </div>

                        </div>
                    </div>
                </section>

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
                                        <?php echo form_open_multipart(base_url('artist/user_image_insert'), array('id' => 'userimage', 'name' => 'userimage', 'class' => 'clearfix')); ?>
                                        <input type="file" name="profilepic" accept="image/gif, image/jpeg, image/png" id="profilepic">
                                        <input type="hidden" name="hitext" id="hitext" value="6">
                                        <div class="popup_previred">
                                            <img id="preview" src="#" alt="your image" >
                                        </div>
                                        <input type="submit" name="profilepicsubmit" id="profilepicsubmit" value="Save">
                                        <?php echo form_close(); ?>
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Model Popup Close -->

                <?php echo $footer; ?>
                <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
                <script data-semver="0.13.0" src="https://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
                <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
        
                <?php
                if (IS_ART_JS_MINIFY == '0') { ?>
                    <script  src="<?php echo base_url('assets/js/croppie.js?ver='.time()); ?>"></script>
                    <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver='.time()); ?>"></script>
                    <?php }else{?>
                        <script  src="<?php echo base_url('assets/js_min/croppie.js?ver='.time()); ?>"></script>
                        <script src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver='.time()); ?>"></script>
                        <?php }?>
                        <script type="text/javascript">
                            var base_url = '<?php echo base_url(); ?>';   
                            var data = <?php echo json_encode($demo); ?>;
                            var data1 = <?php echo json_encode($de); ?>;
                            var data= <?php echo json_encode($demo); ?>;
                            var data1 = <?php echo json_encode($city_data); ?>;
                           var app = angular.module('userListApp', ['ui.bootstrap']);
                        </script>

                        <?php
                        if (IS_ART_JS_MINIFY == '0') { ?>
                            <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist/userlist.js?ver='.time()); ?>"></script>
                            <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist/artistic_common.js?ver='.time()); ?>"></script>
                            <?php }else{?>

                                <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist/userlist.js?ver='.time()); ?>"></script>
                                <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/artist/artistic_common.js?ver='.time()); ?>"></script>

                                <?php }?>
                                <script>
                                   var header_all_profile = '<?php echo $header_all_profile; ?>';
                               </script>
                               <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
                           </body>
                           </html>