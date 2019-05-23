<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- <title ng-bind="title"></title> -->
        <title><?php echo $title; ?></title>
        <meta name="description" content="<?php echo $metadesc; ?>" />
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="canonical" href="<?php echo current_url(); ?>" />
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/aos.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()) ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()) ?>">
        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()) ?>"></script>
        
        <?php $this->load->view('adsense'); ?>
    </head>
    <body class="profile-main-page without-reg bus-main">
        <?php //$this->load->view('page_loader'); ?>
            <div id="main_page_load">

        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-ui.min-1.12.1.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/croppie.js?ver=' . time()) ?>"></script>
        <?php 
            if($ismainregister == false){                
            }else if($isbusiness_register == true && $isbusiness_deactive){
                echo $business_header2;
            }else{
                echo $header_profile; 
            }
        ?>
        <?php
           if($ismainregister == false){
        ?>
            <div class="middle-section middle-section-banner new-ld-page">
        <?php //echo $search_banner; 
            } else if(!$isbusiness_deactive && $isbusiness_register == true) { ?>
            <div class="middle-section">
        <?php } else { ?>
            <div class="middle-section middle-section-banner">
        <?php //echo $search_banner;  
        } ?>

        <!-- <div class="middle-section middle-section-banner new-ld-page"> -->
            <!-- SEARCH BANNER for BUSINESS -->
            <?php if(!$isbusinessactivate){ ?>
                <?php if(!$business_profile_set){ echo $search_banner; } ?>
            <?php } else { ?>
                <div class="sub-fix-head">
                    <div class="container">
                        <p><span>Do you want to reactive ? </span><a class="pull-right btn-1" href="<?php echo base_url('business/reactivateacc'); ?>">Reactivate </a></p>
                    </div>
                </div>
            <?php } ?>
			<div class="container">
				<div class="banner-add">
					<?php $this->load->view('banner_add'); ?>
				</div>
			</div>

            <!-- TOP CATEGORY LIST -->
            <div class="job-cat-lp">
                <div class="container" >
                    <div class="center-title">
                        <h2>Business by Category</h2>
                    </div>
                    <div class="row pt20">
                        <?php
                        if(isset($businessCategory) && !empty($businessCategory)):
                            foreach($businessCategory as $_businessCategory): ?>
                        <div class="col-md-3 col-sm-6 col-xs-6 mob-cus-box">
                            <div class="all-cat-box">
                                <a href="<?php echo base_url().$_businessCategory['industry_slug'].'-business'; ?>">
                                    <div class="cus-cat-middle">
                                        <img src="<?php echo BUSINESS_CAT_IMG.$_businessCategory['industry_image']; ?>" onError="this.onerror=null;this.src='<?php echo base_url('assets/n-images/cat-1.png') ?>';">
                                        <!-- <img src="<?php //echo base_url('assets/n-images/cat-1.png?ver='.time()) ?>" alt="<?php //echo $_businessCategory['industry_name']; ?>"> -->
                                        <p><?php echo $_businessCategory['industry_name']; ?></p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <?php endforeach;
                        endif; ?>
                    </div>
				
					<div class="banner-add">
						<?php $this->load->view('banner_add'); ?>
					</div>
			
                    <div class="p20 fw">
                        <p class="p20 text-center"><a class="btn-1" href="<?php echo base_url('business-by-categories') ?>">View More</a></p>
                    </div>
                </div>
            </div>

            <!-- TOP LOCATION LIST -->
            <div class="job-cat-lp">
                <div class="container">
                    <div class="center-title">
                        <h2>Business by Location</h2>
                    </div>
                    <div class="row pt20">
                        <?php
                        if(isset($businessLocation) && !empty($businessLocation)):
                            foreach($businessLocation as $_businessLocation): ?>
                            <div class="col-md-3 col-sm-6 col-xs-6 mob-cus-box">
                                <div class="all-cat-box">
                                    <a href="<?php echo base_url().'business-in-'.$_businessLocation['slug']; ?>">
                                        <div class="cus-cat-middle">
                                            <img src="<?php echo CITY_IMG_PATH.$_businessLocation['city_image'];?>" onError="this.onerror=null;this.src='<?php echo CITY_IMG_PATH.'default_city.png'; ?>';">
                                            <p><?php echo $_businessLocation['city_name']; ?></p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach;
                        endif; ?>
                    </div>
					<div class="banner-add">
						<?php $this->load->view('banner_add'); ?>
					</div>
			
                    <div class="p20 fw">
                        <p class="p20 text-center"><a href="<?php echo base_url('business-by-location') ?>" class="btn-1">View More</a></p>
                    </div>
                </div>
            </div>

            <!-- HOW ABOUT PROFILE -->
            <div class="how-about-profile">
                <div class="container">
                    <div class="center-title">
                        <h2>How Can Aileensoul Business Profile Help You in Growing Network?</h2>
                    </div>
                    <div class="row">
                       
                        <div class="col-md-8 col-sm-10 col-md-push-2 col-sm-push-1 text-center ">
                            <p>In the emerging phase of start-ups and entrepreneurship more and more people are getting inclined towards having his/her own business venture. </p>
                            <p>Aileensoul recognises the need of time and offers a discreetly designed Business profile which allows the users to increase their business contacts as well as smoothly promote their new established business. </p>
                            <p>Digital marketing is on spur and hence Aileensoul through its business profile helps the users by freely providing a platform to enrich their business through various means. One can upload images, audios, pdf files and videos in this profile. The notification bar of business profile keeps the users aware of all the ongoing trends and details of his/her arena. Hence, keeping people connected to each other.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CREATE BUSINESS OR REACTIVE -->
            <div class="content-bnr bus-bnr-prlx">
                <div class="bnr-box">
                    <div class="content-bnt-text">
                        <h2>Grow Business Network Plus Be Found at Any Time by Listing Your Business Online</h2>
                        <p>
                            <?php if($this->session->userdata('aileenuser')){ ?>
                                <?php if($isbusinessdeactivate == false || !($isbusinessdeactivate)){ ?>
                                    <a class="btn5" href="<?php echo $business_profile_link ?>">Create Business Profile</a>
                                <?php }else{ ?>
                                    <a class="btn5" href="<?php echo base_url('business-profile/registration/business-information') ?>">Reactive Business Profile</a>
                                <?php } ?>   
                            <?php } else{ ?>   
                                    <a class="btn5" href="<?php echo base_url('business-profile/create-account'); ?>">Create Business Profile</a>
                            <?php } ?>   
                        </p>
                    </div>
                </div>
            </div>
			<div class="container">
				<div class="banner-add">
					<?php $this->load->view('banner_add'); ?>
				</div>
			</div>
            <!-- HOW IT WORKS -->
            <div class="how-it-work">
                <div class="container">
                    <div class="center-title">
                        <h2>How it Works</h2>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            <div class="hiw-box">
                                <img src="<?php echo base_url('assets/n-images/reg.png?ver='.time()) ?>">
                                <p>Register</p>
                                <span>List your business for free and fill your business detail to get found online.</span>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="hiw-box">
                                <img src="<?php echo base_url('assets/n-images/connect.png?ver='.time()) ?>">
                                <p>Grow Network</p>
                                <span>Build and grow your business network by connecting with other business.</span>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="hiw-box last-child">
                                <img src="<?php echo base_url('assets/n-images/stay-update.png?ver='.time()) ?>">
                                <p>Stay Updated</p>
                                <span>Get all the daily news about the business you follow.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- RELATED ARTICLE -->
            <div class="related-article">
                <div class="container">
                    <div class="center-title">
                        <h3>Related Article</h3>
                    </div>
                    <div class="row pt20">
                        <?php
                        if(isset($business_related_list) && !empty($business_related_list)):
                            foreach($business_related_list as $_business_related_list): ?>
                            <div class="col-md-4 col-sm-4">
                                <div class="also-like-box">
    								<div class="rec-img">
    									<a href="<?php echo base_url().'blog/'.$_business_related_list['blog_slug']; ?>" target="_self">
    									<img src="<?php echo base_url($this->config->item('blog_main_upload_path')).$_business_related_list['image']; ?>">
    									</a>
    								</div>
                                    <div class="also-like-bottom">
                                        <p><a href="<?php echo base_url().'blog/'.$_business_related_list['blog_slug']; ?>"><?php echo $_business_related_list['title']; ?></a></p>
                                    </div>
                                </div>
                            </div>
                        <?php
                            endforeach;
                        endif; ?>
                    </div>
					<div class="banner-add">
						<?php $this->load->view('banner_add'); ?>
					</div>
                </div>
				
            </div>
        </div>
		<div class="bottom-ftr-none">
            <?php echo $login_footer; ?>
		</div>
        <?php if($this->session->userdata('aileenuser') == "")
        {
            $this->load->view('mobile_side_slide'); 
        }?>
        </div>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/owl.carousel.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/aos.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/angular/angular.min-1.6.4.js?ver=' . time()); ?>"></script>
        <script data-semver="0.13.0" src="<?php echo base_url('assets/js/angular/ui-bootstrap-tpls-0.13.0.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/angular/angular-route-1.6.4.js?ver=' . time()); ?>"></script>
        <script>
            var base_url = '<?php echo base_url(); ?>';
            var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
            var title = '<?php echo $title; ?>';
            var header_all_profile = '<?php echo $header_all_profile; ?>';
            var q = '';
            var l = '';
            var app = angular.module('', ['ui.bootstrap']);

            $(window).on("load",function(){
                $(".custom-scroll").mCustomScrollbar({
                    autoHideScrollbar:true,
                    theme:"minimal"
                });
            });
            
        </script>
        <script src="http://chat.aileensoul.localhost/socket.io/socket.io.js"></script>
        <script type="text/javascript">
            var socket = io.connect("<?php echo SOCKETSERVER; ?>");
        </script>
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/business-live/searchBusiness.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/notification.js?ver=' . time()) ?>"></script>
        <?php if($this->session->userdata('aileenuser') == ""): ?>
        <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "BreadcrumbList",
            "itemListElement":
            [
                {
                    "@type": "ListItem",
                    "position": 1,
                    "item":
                    {
                        "@id": "<?php echo base_url(); ?>",
                        "name": "Aileensoul"
                    }
                },
                {
                    "@type": "ListItem",
                    "position": 2,
                    "item":
                    {
                        "@id": "<?php echo current_url(); ?>",
                        "name": "Business"
                    }
                }
            ]
        }
        </script>
        <?php endif; ?>
    </body>
</html>