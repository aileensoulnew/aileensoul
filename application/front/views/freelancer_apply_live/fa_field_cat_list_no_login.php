<?php $userid_login = $this->session->userdata('aileenuser'); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- start head -->
        <?php //echo $head; ?>
        <!-- END HEAD -->

        <title><?php echo $title; ?></title>
        <meta name="description" content="<?php echo $metadesc; ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
        <?php
        if (IS_JOB_CSS_MINIFY == '0') {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/job.css?ver=' . time()); ?>">
        <?php } else { ?>

            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/style-main.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/job.css?ver=' . time()); ?>">
        <?php } ?>
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver='.time()); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()) ?>">
        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()) ?>"></script>
        <style>
          .ui-autocomplete {
            max-height: 100px;
            overflow-y: auto;
            /* prevent horizontal scrollbar */
            overflow-x: hidden;
          }
          /* IE 6 doesn't support max-height
           * we use height instead, but this forces the menu to always be this tall
           */
          * html .ui-autocomplete {
            height: 100px;
          }
          </style>
    <?php $this->load->view('adsense'); ?>
</head>
    <!-- END HEAD -->

    <body class="profile-main-page">        
        <?php
        if($userid_login != ""  && $this->freelance_apply_profile_set == 1){
            echo $header_profile;
            echo $freelancer_post_header2;
        }
        else if($userid_login != "" && $this->freelance_apply_profile_set == 0)
        {
             echo $header_profile;
        }

        if($userid_login == "" || $this->freelance_apply_profile_set == 0)
        {
            $headercls = "";
            if($userid_login == "")
            {
                $headercls = " new-ld-page";
            }
            ?>
            <div class="middle-section middle-section-banner <?php echo $headercls; ?>">
            <?php
            echo $search_banner;
        } else { ?>
            <div class="middle-section">
        <?php } ?>
                <div class="container pt20 mobp0">
                    <div class="left-part">
                        <?php echo $fa_leftbar; ?>
                        <!-- <div class="custom_footer_left fw">
                            <div class="">
                                <ul>
                                    <li>
                                        <a href="#" target="_blank">
                                            <span class="custom_footer_dot"> · </span> About Us 
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" target="_blank">
                                            <span class="custom_footer_dot"> · </span> Contact Us
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" target="_blank">
                                            <span class="custom_footer_dot"> · </span> Blogs 
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" target="_blank">
                                            <span class="custom_footer_dot"> · </span> Privacy Policy 
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" target="_blank">
                                            <span class="custom_footer_dot"> · </span> Terms &amp; Condition
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" target="_blank">
                                            <span class="custom_footer_dot"> · </span> Send Us Feedback
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div> -->
                    </div>
                    <div class="custom-right-art mian_middle_post_box animated fadeInUp">
                        <!--<div class="common-form">-->
                        <!--</div>-->
                        <div class="page-title">
                            <h3>Recommended Projects</h3>
                        </div>
                        <?php if(isset($searchFA) && empty($searchFA) && $page == 0): ?>
                        <div class="user_no_post_avl ng-scope">
                            <div class="user-img-nn">
                                <div class="user_no_post_img">
                                    <img src="<?php echo base_url('assets/img/no-post.png?ver=time()');?>" alt="bui-no.png">
                                </div>
                                <div class="art_no_post_text">No Projects Available.</div>
                            </div>
                        </div>
                        <?php endif;
                        if(isset($searchFA) && !empty($searchFA)):
                            foreach($searchFA as $_searchFA): ?>
                                <div class="all-job-box freelance-recommended-post">
                                    <div class="all-job-top">
                                        <div class="job-top-detail">
                                            <h5><a href="<?php echo base_url().'freelance-jobs/'.$_searchFA['industry_name'].'/'.$_searchFA['post_slug'].'-'.$_searchFA['user_id'].'-'.$_searchFA['post_id']; ?>">
                                                <?php echo $_searchFA['post_name'];
                                                if($_searchFA['day_remain'] > 0){
                                                ?>
                                                <span>
                                                    (<?php echo $_searchFA['day_remain']; ?> days left)</span>
                                                <?php
                                                } ?>
                                                </a>
                                            </h5>
                                            <p><a href="<?php echo base_url().'freelance-jobs/'.$_searchFA['industry_name'].'/'.$_searchFA['post_slug'].'-'.$_searchFA['user_id'].'-'.$_searchFA['post_id']; ?>">
                                                <?php echo ucwords($_searchFA['fullname']); ?></a>
                                            </p>
                                            <?php 
                                            if($_searchFA['post_rate'] != "")
                                            {?>
                                                <p>Budget : <?php echo $_searchFA['post_rate'].' '.$_searchFA['post_currency'] ?> (hourly/fixed)</p>
                                            <?php 
                                            } ?>
                                        </div>
                                    </div>
                                    <div class="all-job-middle">
                                        <p class="pb5">
                                            <?php if($_searchFA['city'] != "" || $_searchFA['country'] != ""):?>
                                            <span class="location">
                                                <?php if($_searchFA['city'] != "" && $_searchFA['country'] != ""){?>
                                                <!-- IF BOTH DATA AVAILABLE OF COUNTRY AND CITY -->
                                                <span>
                                                    <img class="pr5" src="<?php echo base_url('assets/img/location.png?ver=' . time()) ?>"><?php echo $_searchFA['city'].",(".$_searchFA['country'].")"; ?>
                                                </span>
                                                <?php } elseif($_searchFA['city'] != "" && $_searchFA['country'] == ""){?>
                                                <!-- IF ONLY CITY AVAILABLE -->
                                                <span>
                                                    <img class="pr5" src="<?php echo base_url('assets/img/location.png?ver=' . time()) ?>"><?php echo $_searchFA['city']; ?>
                                                </span>
                                                <?php }elseif($_searchFA['city'] == "" && $_searchFA['country'] != ""){?>
                                                <!-- IF ONLY COUNTRY AVAILABLE -->
                                                <span>
                                                    <img class="pr5" src="<?php echo base_url('assets/img/location.png?ver=' . time()) ?>"><?php echo $_searchFA['country']; ?>
                                                </span>
                                                <?php }?>
                                            </span>
                                            <?php endif;?>
                                            <span class="exp">
                                                <span>
                                                    <img class="pr5" src="<?php echo base_url('assets/img/exp.png?ver=' . time()) ?>">
                                                    <span>
                                                        <?php echo substr($_searchFA['post_skill'], 0,35)."..."; ?>
                                                    </span>
                                                </span>
                                            </span>
                                        </p>                                
                                        <p>
                                            <?php echo substr($_searchFA['post_description'], 0,35)."..."; ?>
                                        </p>
                                        <?php if($_searchFA['industry_name'] != ""): ?>
                                        <p>
                                            Category : <span><?php echo $_searchFA['industry_name']; ?></span>
                                        </p>
                                        <?php endif; ?>
                                    </div>
                                    <div class="all-job-bottom">
                                        <span class="hw-479"><span>Applied<span class="hidden-479"> Persons</span>: <?php echo $_searchFA['AppliedCount']; ?></span>
                                        <span class="pl20">Shortlisted<span class="hidden-479"> Persons</span>: <?php echo $_searchFA['ShortListedCount']; ?></span></span>
                                        <p class="pull-right">
                                            <?php if($userid != ""): ?>
                                                <a href="<?php echo base_url('freelance-work/profile/live-post/').$_searchFA['post_id']; ?>" class="btn4">Save</a>
                                                <a href="<?php echo base_url('freelance-work/profile/live-post/').$_searchFA['post_id']; ?>" class="btn4">Apply</a>
                                            <?php else: ?>
                                                <a href="javascript:void(0)" onclick="savepopup(<?php echo $_searchFA['post_id']; ?>)" class="btn4">Save</a>
                                                <a href="javascript:void(0)" onclick="applypopup(<?php echo $_searchFA['post_id']; ?>,<?php echo $_searchFA['user_id']; ?>)" class="btn4">Apply</a>
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                </div>
                         <?php endforeach;
                        endif;?>
                        <?php echo $links; ?>
                        <div id="loader" style="display: none;">
                            <p style="text-align:center;">
                                <img src="<?php echo base_url('assets/images/loading.gif'); ?>" alt="<?php echo 'loaderimage'; ?>"/>
                            </p>
                        </div>
                    </div>
                    <div id="hideuserlist" class="right_middle_side_posrt fixed_right_display hidden-1279 animated fadeInRightBig"> 

                        <!-- <div class="all-profile-box hidden">
                            <div class="all-pro-head">
                                <h4>Profiles<a href="<?php echo base_url('profiles/') . $this->session->userdata('aileenuser_slug'); ?>" class="pull-right">All</a></h4>
                            </div>
                            <ul class="all-pr-list">
                                <li>
                                    <a href="<?php echo base_url('job-search'); ?>">
                                        <div class="all-pr-img" alt="job">
                                            <img src="<?php echo base_url('assets/img/i1.jpg'); ?>" alt="job">
                                        </div>
                                        <span>Job Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('recruiter'); ?>" >
                                        <div class="all-pr-img">
                                            <img src="<?php echo base_url('assets/img/i2.jpg'); ?>" alt="recruiter">
                                        </div>
                                        <span>Recruiter Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('freelance'); ?>" >
                                        <div class="all-pr-img">
                                            <img src="<?php echo base_url('assets/img/i3.jpg'); ?>"  alt="freelancer">
                                        </div>
                                        <span>Freelance Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('business-profile'); ?>" >
                                        <div class="all-pr-img">
                                            <img src="<?php echo base_url('assets/img/i4.jpg'); ?>" alt="business profile">
                                        </div>
                                        <span>Business Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('artist'); ?>" >
                                        <div class="all-pr-img">
                                            <img src="<?php echo base_url('assets/img/i5.jpg'); ?>" alt="artist">
                                        </div>
                                        <span>Artistic Profile</span>
                                    </a>
                                </li>
                            </ul>
                        </div> -->
                        <?php echo $right_profile_view; ?>
                        <?php echo $left_footer_list_view; ?>

                    </div>
                </div>
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
                            <button type="button" class="modal-close" data-dismiss="modal">&times;</button><div class="modal-body">
        						<div class="mid-modal-body">
        							 <?php echo $fa_leftbar; ?>
        						</div>
                            </div>
                        </div>
                    </div>
                </div>        				
            </div>   
   
    <!-- Model Popup Open -->
	
    
        <!-- Bid-modal  -->
        <div class="modal message-box biderror" id="bidmodal" role="dialog">
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


<?php echo $footer; 
if($userid_login == ""){?>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
    <?php }
    if (IS_JOB_JS_MINIFY == '0') {
        ?>
        <!-- <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script> -->
        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()) ?>"></script>
<?php } else { ?>


        <!-- <script src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver=' . time()); ?>"></script> -->
        <script type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver=' . time()) ?>"></script>

<?php } ?>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
    <script data-semver="0.13.0" src="https://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
    <script src="<?php echo base_url('assets/js/jquery-ui.min-1.12.1.js?ver=' . time()) ?>"></script>
    <script src="<?php echo base_url('assets/js/angular-validate.min.js?ver=' . time()) ?>"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
    <script src="<?php echo base_url('assets/js/ng-tags-input.min.js?ver=' . time()); ?>"></script>
    <script src="<?php echo base_url('assets/js/angular/angular-tooltips.min.js?ver=' . time()); ?>"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-sanitize.js"></script>
    <script>
        var base_url = '<?php echo base_url(); ?>';

        var skill = '<?php echo $keyword; ?>';
        //var skill = skill.replace(/\-/g, ' ');

        var search_location = '<?php echo $search_location; ?>';
        //var place = place.replace(/\-/g, ' ');

        var csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
        var csrf_hash = '<?php echo $this->security->get_csrf_hash(); ?>';
        var skill = '<?php echo $keyword; ?>';
        var search_location = '<?php echo $search_location; ?>';
        var login_user_id = "<?php echo $userid_login; ?>";
        var app = angular.module('', ['ngRoute','ui.bootstrap']);
        var header_all_profile = '<?php echo $header_all_profile; ?>';
        var filter_url = "<?php echo $filter_url; ?>";
        // $(document).ready(function(){
        //     $(window).scrollTop(500);
        // });
            $(document).ready(function($) {
                $("li.user-id label").click(function(e){
                    $(".dropdown").removeClass("open");
                    $(this).next('ul.dropdown-menu').toggle();
                    e.stopPropagation();
                });
                $(".right-header ul li.dropdown a").click(function(e){                          
                    $('.right-header ul.dropdown-menu').hide();
                });
            });
            $(document).click(function(){
                $('.right-header ul.dropdown-menu').hide();
            });
            
            /*$('#job_reg').on('hidden.bs.modal', function (e) {
                $("#job_apply").val('');
                $("#job_apply_userid").val('');
                $("#job_save").val('');
            });*/
    </script>    
    <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>  
    <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-apply/fa_field_cat_list_no_login.js?ver=' . time()); ?>"></script>
</body>
</html>