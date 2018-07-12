
<!DOCTYPE html>
<html  ng-app="freelancerHireListApp" ng-controller="freelancerHireListController">
    <head>
        <title><?php echo $title; ?></title>
        <meta name="description" content="<?php echo $metadesc; ?>" />
        <?php echo $head; ?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/freelancer-hire.css?ver=' . time()); ?>">
        <?php /*if (IS_HIRE_CSS_MINIFY == '0') { ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/freelancer-hire.css?ver=' . time()); ?>">
        <?php } else { ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/freelancer-hire.css?ver=' . time()); ?>">
        <?php }*/ ?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>" />
    <?php $this->load->view('adsense'); ?>
</head>
    <body class="page-container-bg-solid page-boxed pushmenu-push">
        <?php $this->load->view('page_loader'); ?>
        <div id="main_page_load" style="display: none;">
        <?php //echo $header; ?>
        <?php echo $freelancer_hire_header2; ?>
        <section>
            <div class="user-midd-section" id="paddingtop_fixed">
                <div class="container padding-360">
                    <div class="row4">
                        <div class="profile-box-custom fl animated fadeInLeftBig left_side_posrt">
                            <div class="">
                                <div class="full-box-module">   
                                    <div class="profile-boxProfileCard  module">
                                        <div class="profile-boxProfileCard-cover"> 
                                            <a class="profile-boxProfileCard-bg u-bgUserColor a-block"
                                               href="<?php echo base_url('freelance-employer/'. $free_hire_login_slug); ?>"  tabindex="-1" aria-hidden="true" rel="noopener" 
                                               title="<?php echo $freehiredata['fullname'] . " " . $freehiredata['username']; ?>">

                                                <?php if ($freehiredata['profile_background'] != '') { ?>
                                                    <div class="data_img">
                                                        <img src="<?php echo FREE_HIRE_BG_THUMB_UPLOAD_URL . $freehiredata['profile_background']; ?>" class="bgImage" alt="<?php echo $freehiredata['fullname'] . " " . $freehiredata['username']; ?>" >
                                                    </div>
                                                <?php } else { ?>
                                                    <div class="data_img bg-images no-cover-upload">
                                                        <img alt="No Image" src="<?php echo base_url(WHITEIMAGE); ?>" class="bgImage">
                                                    </div>
                                                <?php } ?>
                                            </a>
                                        </div>
                                        <div class="profile-boxProfileCard-content clearfix">
                                            <div class="left_side_box_img buisness-profile-txext">

                                                <a class="profile-boxProfilebuisness-avatarLink2 a-inlineBlock" href="<?php echo base_url('freelance-employer/'. $free_hire_login_slug); ?>"  tabindex="-1" aria-hidden="true" rel="noopener" title="<?php echo $freehiredata['fullname'] . " " . $freehiredata['username']; ?>">
                                                    <?php
                                                    $fname = $freehiredata['fullname'];
                                                    $lname = $freehiredata['username'];
                                                    $sub_fname = substr($fname, 0, 1);
                                                    $sub_lname = substr($lname, 0, 1);

                                                    if ($freehiredata['freelancer_hire_user_image']) {
                                                        if (IMAGEPATHFROM == 'upload') {
                                                            if (!file_exists($this->config->item('free_hire_profile_main_upload_path') . $freehiredata['freelancer_hire_user_image'])) {
                                                                ?>
                                                                <div class="post-img-profile">
                                                                    <?php echo ucfirst(strtolower($sub_fname)) . ucfirst(strtolower($sub_lname)); ?>
                                                                </div>
                                                            <?php } else {
                                                                ?>
                                                                <img src="<?php echo FREE_HIRE_PROFILE_MAIN_UPLOAD_URL . $freehiredata['freelancer_hire_user_image']; ?>" alt="<?php echo $freehiredata['fullname'] . " " . $freehiredata['username']; ?>" > 
                                                                <?php
                                                            }
                                                        } else {
                                                            $filename = $this->config->item('free_hire_profile_main_upload_path') . $freehiredata['freelancer_hire_user_image'];
                                                            $s3 = new S3(awsAccessKey, awsSecretKey);
                                                            $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                                            if ($info) {
                                                                ?>
                                                                <img src="<?php echo FREE_HIRE_PROFILE_MAIN_UPLOAD_URL . $freehiredata['freelancer_hire_user_image']; ?>" alt="<?php echo $freehiredata['fullname'] . " " . $freehiredata['username']; ?>" >
                                                            <?php } else {
                                                                ?>
                                                                <div class="post-img-profile">
                                                                    <?php echo ucfirst(strtolower($sub_fname)) . ucfirst(strtolower($sub_lname)); ?>
                                                                </div> 
                                                                <?php
                                                            }
                                                        }
                                                    } else {
                                                        ?>
                                                        <div class="post-img-profile">
                                                            <?php echo ucfirst(strtolower($sub_fname)) . ucfirst(strtolower($sub_lname)); ?>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                </a>
                                            </div>
                                            <div class="right_left_box_design ">
                                                <span class="profile-company-name ">
                                                    <a href="<?php echo base_url('freelance-employer/'. $free_hire_login_slug); ?>" title="<?php echo $freehiredata['fullname'] . " " . $freehiredata['username']; ?>"> <?php echo ucwords($freehiredata['fullname']) . ' ' . ucwords($freehiredata['username']); ?></a>  
                                                </span>
                                                <?php $category = $this->db->get_where('industry_type', array('industry_id' => $businessdata[0]['industriyal'], 'status' => '1'))->row()->industry_name; ?>
                                                <div class="profile-boxProfile-name">
                                                    <a href="<?php echo base_url('freelance-employer/'. $free_hire_login_slug); ?>" title="<?php echo $freehiredata['fullname'] . " " . $freehiredata['username']; ?>"><?php
                                                        if ($freehiredata['designation']) {
                                                            echo $freehiredata['designation'];
                                                        } else {
                                                            echo "Designation";
                                                        }
                                                        ?></a>
                                                </div>
                                                <ul class=" left_box_menubar">
                                                    <li <?php if (($this->uri->segment(1) == 'freelance-employer') && ($this->uri->segment(3) == '')) { ?> class="active" <?php } ?>><a title="Employer Details"  class="padding_less_left" href="<?php echo base_url('freelance-employer/'. $free_hire_login_slug); ?>" ><?php echo $this->lang->line("details"); ?></a></li>
                                                    <li><a title="Projects" href="<?php echo base_url('freelance-employer/projects'); ?>"><?php echo $this->lang->line("Projects"); ?></a></li>
                                                    <li <?php if (($this->uri->segment(1) == 'freelance-employer') && ($this->uri->segment(2) == 'saved-freelancer')) { ?> class="active" <?php } ?>><a title="Saved Freelancer"  class="padding_less_right" href="<?php echo base_url('freelance-employer/saved-freelancer'); ?>"><?php echo $this->lang->line("saved"); ?></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>                             
                                </div>
                                <div class="left-search-box list-type-bullet">
                                    <div class="">
                                        <h3>Top Categories</h3>
                                    </div>
                                    <div class="content custom-scroll">
                                        <ul class="search-listing">
                                            <li ng-repeat="category in categoryFilterList">
                                                <label class="control control--checkbox">
                                                    <span><span class="mi-cat-width">{{category.category_name | capitalize}}</span>
                                                        <span class="pull-right">({{category.count}})</span>
                                                    </span>
                                                    <input class="categorycheckbox filtercheckbox" type="checkbox" name="{{category.category_name}}" value="{{category.category_id}}" style="height: 12px;" [attr.checked]="(category.isselected) ? 'checked' : null" autocomplete="false">
                                                    <div class="control__indicator"></div>
                                                </label>
                                            </li>                                        
                                        </ul>
                                    </div>
                                    <!-- <p class="text-right p10"><a href="#">More Categories</a></p> -->
                                </div>
                                <div class="left-search-box list-type-bullet">
                                    <div class="">
                                        <h3>Top Cities</h3>
                                    </div>
                                    <div class="content custom-scroll">
                                        <ul class="search-listing">
                                            <li ng-repeat="cities in cityFilterList">
                                                <label class="control control--checkbox">
                                                    <span><span class="mi-cat-width">{{cities.city_name | capitalize}}</span>
                                                        <span class="pull-right">({{cities.count}})</span>
                                                    </span>
                                                    <input class="citiescheckbox filtercheckbox" type="checkbox" name="{{cities.city_name}}" value="{{cities.city_id}}" style="height: 12px;" [attr.checked]="(cities.isselected) ? 'checked' : null" autocomplete="false">
                                                    <div class="control__indicator"></div>
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- <p class="text-right p10"><a href="#">More Cities</a></p> -->
                                </div>
                                <div class="left-search-box list-type-bullet">
                                    <div class="">
                                        <h3>Skills</h3>
                                    </div>
                                    <div class="content custom-scroll">
                                        <ul class="search-listing">
                                            <li ng-repeat="skill in skillFilterList">
                                                <label class="control control--checkbox">
                                                    <span><span class="mi-cat-width">{{skill.skill | capitalize}}</span>
                                                        <span class="pull-right">({{skill.count}})</span>
                                                    </span>
                                                    <input class="skillcheckbox filtercheckbox" type="checkbox" name="{{skill.skill}}" value="{{skill.skill_id}}" style="height: 12px;" [attr.checked]="(skill.isselected) ? 'checked' : null" autocomplete="false">
                                                    <div class="control__indicator"></div>
                                                </label>
                                            </li>      
                                        </ul>
                                    </div>
                                </div>
                                <div class="left-search-box">
                                    <div class="accordion" id="accordion3">
                                        <div class="accordion-group">
                                            <div class="accordion-heading">
                                                <h3><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapsetwo" aria-expanded="true">Required Experience</a></h3>
                                            </div>
                                            <div id="collapsetwo" class="accordion-body collapse in" aria-expanded="true" style="">
                                                <div class="accordion-inner">
                                                    <ul class="search-listing">
                                                        <li ng-repeat="experience in experienceFilterList">
                                                            <label class="control control--checkbox">
                                                                <span>{{experience.name | capitalize}}
                                                                </span>
                                                                <input class="experiencecheckbox filtercheckbox" type="checkbox" name="{{experience.name}}" value="{{experience.id}}" style="height: 12px;" [attr.checked]="(experience.isselected) ? 'checked' : null" autocomplete="false">
                                                                <div class="control__indicator"></div>
                                                            </label>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    
                                    </div>
                                </div>



                                <?php echo $left_footer; ?>

                                
                            </div>

                        </div>
                        <?php

                        function text2link($text) {
                            $text = preg_replace('/(((f|ht){1}t(p|ps){1}:\/\/)[-a-zA-Z0-9@:%_\+.~#?&\/\/=]+)/i', '<a href="\\1" target="_blank" rel="nofollow">\\1</a>', $text);
                            $text = preg_replace('/([[:space:]()[{}])(www.[-a-zA-Z0-9@:%_\+.~#?&\/\/=]+)/i', '\\1<a href="http://\\2" target="_blank" rel="nofollow">\\2</a>', $text);
                            $text = preg_replace('/([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})/i', '<a href="mailto:\\1" rel="nofollow" target="_blank">\\1</a>', $text);
                            return $text;
                        }
                        ?>

                        <!-- middle div stat -->
                        <div class="custom-right-art mian_middle_post_box animated fadeInUp">
                            <?php if ($this->session->flashdata('error')) { ?>  
                                    <p class="alert alert-success"><?php echo $this->session->flashdata('error'); ?></p>
                            <?php } ?>
                            <div class="common-form rec-recmn-post">
                                <div class="job-saved-box">
                                    <h3><?php echo $this->lang->line("recommended_freelancer"); ?></h3>
                                    <div class="contact-frnd-post">

                                        <div class="job-contact-frnd">
                                            <!--AJAX DATA...........-->

                                            <!-- body tag inner data end -->

                                        </div>
                                        <div class="fw" id="loader" style="text-align:center;"><img alt="loader" src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) ?>" /></div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- middle div  -->
                        <div id="hideuserlist" class="right_middle_side_posrt fixed_right_display animated fadeInRightBig"> 

                            

                        </div>


                    </div>
                </div>
            </div>
        </section>
        </div>
        <?php echo $footer; ?>
		<div>
			<div class="mob-filter" data-target="#filter" data-toggle="modal">
				<svg width="25.000000pt" height="25.000000pt" viewBox="0 0 300.000000 300.000000">
					<g transform="translate(0.000000,300.000000) scale(0.100000,-0.100000)"
					fill="#1b8ab9" stroke="none">
					<path d="M489 2781 l-29 -29 0 -221 0 -221 -110 0 c-115 0 -161 -12 -174 -45
					-3 -9 -6 -163 -6 -341 l0 -325 25 -24 c23 -24 30 -25 144 -25 l121 0 2 -646 3
					-646 24 -19 c33 -27 92 -25 119 4 l22 23 0 642 0 642 124 0 c107 0 127 3 147
					19 l24 19 3 331 3 332 -30 29 c-29 30 -30 30 -150 30 l-121 0 0 225 0 226 -25
					24 c-34 35 -78 33 -116 -4z m271 -851 l0 -210 -210 0 -210 0 0 210 0 210 210
					0 210 0 0 -210z"/>
					<path d="M1445 2785 l-25 -24 0 -641 0 -640 -119 0 c-105 0 -121 -2 -145 -21
					l-26 -20 0 -338 0 -338 23 -21 c21 -20 34 -22 145 -22 l122 0 0 -224 c0 -211
					1 -225 21 -250 16 -21 29 -26 64 -26 35 0 48 5 64 26 20 25 21 39 21 250 l0
					224 123 0 c181 0 167 -33 167 382 l0 337 -26 20 c-24 19 -40 21 -145 21 l-119
					0 0 640 0 641 -25 24 c-33 34 -87 34 -120 0z m275 -1685 l0 -210 -215 0 -215
					0 0 210 0 210 215 0 215 0 0 -210z"/>
					<path d="M2405 2785 l-25 -24 0 -226 0 -225 -121 0 c-120 0 -121 0 -150 -30
					l-30 -29 3 -332 3 -331 24 -19 c20 -16 40 -19 147 -19 l124 0 0 -643 0 -644
					23 -21 c29 -28 86 -29 118 -3 l24 19 3 646 2 646 121 0 c114 0 121 1 144 25
					l25 24 0 325 c0 178 -3 332 -6 341 -13 33 -59 45 -174 45 l-110 0 0 221 0 221
					-29 29 c-38 37 -82 39 -116 4z m265 -855 l0 -210 -210 0 -210 0 0 210 0 210
					210 0 210 0 0 -210z"/>
					</g>
					</svg>
			</div>
		</div>
		<div id="filter" class="modal mob-modal fade" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>         
                    <div class="mid-modal-body">
						<div class="mid-modal-body">
							 <div class="left-search-box list-type-bullet">
                                    <div class="">
                                        <h3>Top Categories</h3>
                                    </div>
                                    <div class="content custom-scroll">
                                        <ul class="search-listing">
                                            <li ng-repeat="category in categoryFilterList">
                                                <label class="control control--checkbox">
                                                    <span><span class="mi-cat-width">{{category.category_name | capitalize}}</span>
                                                        <span class="pull-right">({{category.count}})</span>
                                                    </span>
                                                    <input class="categorycheckbox filtercheckbox" type="checkbox" name="{{category.category_name}}" value="{{category.category_id}}" style="height: 12px;" [attr.checked]="(category.isselected) ? 'checked' : null" autocomplete="false">
                                                    <div class="control__indicator"></div>
                                                </label>
                                            </li>                                        
                                        </ul>
                                    </div>
                                    <!-- <p class="text-right p10"><a href="#">More Categories</a></p> -->
                                </div>
                                <div class="left-search-box list-type-bullet">
                                    <div class="">
                                        <h3>Top Cities</h3>
                                    </div>
                                    <div class="content custom-scroll">
                                        <ul class="search-listing">
                                            <li ng-repeat="cities in cityFilterList">
                                                <label class="control control--checkbox">
                                                    <span><span class="mi-cat-width">{{cities.city_name | capitalize}}</span>
                                                        <span class="pull-right">({{cities.count}})</span>
                                                    </span>
                                                    <input class="citiescheckbox filtercheckbox" type="checkbox" name="{{cities.city_name}}" value="{{cities.city_id}}" style="height: 12px;" [attr.checked]="(cities.isselected) ? 'checked' : null" autocomplete="false">
                                                    <div class="control__indicator"></div>
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- <p class="text-right p10"><a href="#">More Cities</a></p> -->
                                </div>
                                <div class="left-search-box list-type-bullet">
                                    <div class="">
                                        <h3>Skills</h3>
                                    </div>
                                    <div class="content custom-scroll">
                                        <ul class="search-listing">
                                            <li ng-repeat="skill in skillFilterList">
                                                <label class="control control--checkbox">
                                                    <span><span class="mi-cat-width">{{skill.skill | capitalize}}</span>
                                                        <span class="pull-right">({{skill.count}})</span>
                                                    </span>
                                                    <input class="skillcheckbox filtercheckbox" type="checkbox" name="{{skill.skill}}" value="{{skill.skill_id}}" style="height: 12px;" [attr.checked]="(skill.isselected) ? 'checked' : null" autocomplete="false">
                                                    <div class="control__indicator"></div>
                                                </label>
                                            </li>      
                                        </ul>
                                    </div>
                                </div>
                                <div class="left-search-box">
                                    <div class="accordion" id="accordion3">
                                        <div class="accordion-group">
                                            <div class="accordion-heading">
                                                <h3><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapsetwo" aria-expanded="true">Required Experience</a></h3>
                                            </div>
                                            <div id="collapsetwo" class="accordion-body collapse in" aria-expanded="true" style="">
                                                <div class="accordion-inner">
                                                    <ul class="search-listing">
                                                        <li ng-repeat="experience in experienceFilterList">
                                                            <label class="control control--checkbox">
                                                                <span>{{experience.name | capitalize}}
                                                                </span>
                                                                <input class="experiencecheckbox filtercheckbox" type="checkbox" name="{{experience.name}}" value="{{experience.id}}" style="height: 12px;" [attr.checked]="(experience.isselected) ? 'checked' : null" autocomplete="false">
                                                                <div class="control__indicator"></div>
                                                            </label>
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
        <div class="modal fade message-box biderror custom-message" id="otherfiled" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content message">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>
                    <h2>Add Field</h2>         
                    <input type="text" name="other_field" id="other_field" onkeypress="return remove_validation()">
                    <div class="fw"><a title="OK" id="field" class="btn">OK</a></div>
                </div>
            </div>
        </div>
        <!-- ADD POST POPUP -->
        <div class="modal fade new-modal" id="postmodal" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>
                    <div class="modal-body">
                        <p>
                            To get most out of this filter, Post your requirement 
                            <a href="<?php echo base_url().'post-freelance-project'; ?>">here</a>
                            to get better candidate recommendations. 
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
        <script data-semver="0.13.0" src="https://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
        <script src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>
        <script>
            var base_url = '<?php echo base_url(); ?>';
            var otherfiled = '<?php echo $otherfiled; ?>';
            var totalpost = '<?php echo $login_user_totalpost; ?>';
            var header_all_profile = '<?php echo $header_all_profile; ?>';
            var app = angular.module('freelancerHireListApp', ['ui.bootstrap']);
        </script>  
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/croppie.js?ver='.time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-hire/recommen_candidate.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-hire/freelancer_hire_common.js?ver=' . time()); ?>"></script>

        <!-- <script>
             var header_all_profile = '<?php //echo $header_all_profile; ?>';
        </script>
        <script src="<?php //echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
 -->
        <?php //if (IS_HIRE_JS_MINIFY == '0') { ?>
            
        <?php //} else { ?>
            <!-- <script src="<?php //echo base_url('assets/js_min/croppie.js?ver='.time()); ?>"></script> -->
            <!--<script async type="text/javascript" src="<?php //echo base_url('assets/js_min/webpage/freelancer-hire/recommen_candidate.js?ver=' . time()); ?>"></script>-->
            <!--<script async type="text/javascript" src="<?php //echo base_url('assets/js_min/webpage/freelancer-hire/freelancer_hire_common.js?ver=' . time()); ?>"></script>-->
        <?php //} ?>
    </body>
</html>