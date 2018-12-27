<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $title; ?></title>
        <meta name="description" content="<?php echo $metadesc; ?>" />
        <!-- <title ng-bind="title"></title> -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">   
        <link rel="stylesheet" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()) ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()) ?>">

        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()) ?>">
        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()) ?>"></script>
    <?php $this->load->view('adsense'); ?>
</head>
    <body class="profile-main-page">
        <?php //$this->load->view('page_loader'); ?>
        <div id="main_page_load">

        <!-- SET BLANK VALUE IF VAR. NOT SET FROM CONTROLLER -->
        <?php $location_id = (isset($location_id)) ? $location_id : ''; ?>
        <?php $category_id = (isset($category_id)) ? $category_id : ''; ?>

        <?php 
            if($ismainregister == false){
                // $this->load->view('business_live/login_header');
            }else if($isbusiness_register == true && $isbusiness_deactive == false){
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
                <?php if($business_profile_set == 0 && $business_profile_set == '0'){ echo $search_banner; } ?>
                <div class="container pt20 mobp0 mobmt15">
                    <div class="left-part">
                        <?php echo $business_left; ?>
						<?php $this->load->view('right_add_box'); ?>
						<?php echo $left_footer; ?>
                    </div>
                    <div class="middle-part">
						<div class="tab-add-991">
							<?php $this->load->view('banner_add'); ?>
						</div>
                        <div class="page-title">
                            <h1 class="cat-title">
                                <?php
                                if($category_txt != "" && $location_txt != "")
                                {
                                    echo $search_txt = $category_txt." Companies in ".$location_txt; 
                                    $item3_url = base_url()."business";
                                    $item3_txt = "All Business";
                                }
                                elseif($location_txt != "")
                                {
                                    echo "Companies in ".$search_txt = $location_txt;
                                    $item3_url = base_url()."business-by-location";
                                    $item3_txt = "Business by Location";
                                }
                                elseif ($category_txt != "") {
                                    $search_txt = $category_txt;
                                    echo $category_txt." Companies";
                                    $item3_url = base_url()."business-by-categories";
                                    $item3_txt = "Business by Category";
                                } ?></h1>
                        </div>
                        <?php 
                        if(isset($businessList) && !empty($businessList)):
                            foreach($businessList as $_businessList): ?>
                        <div class="all-job-box search-business">
                            <div class="search-business-top">
                                <div class="bus-cover no-cover-upload">
                                    <a href="<?php echo base_url().'company/'.$_businessList['business_slug']; ?>">
                                        <?php if($_businessList['profile_background'] != ""){ ?>
                                            <img src="<?php echo BUS_BG_MAIN_UPLOAD_URL.$_businessList['profile_background']; ?>">
                                        <?php }
                                        else{ ?>
                                            <img src="<?php echo BASEURL . WHITEIMAGE ?>">
                                        <?php }
                                        ?>
                                    </a>                                    
                                </div>
                                <div class="all-job-top">
                                    <div class="post-img">
                                        <a href="<?php echo base_url().'company/'.$_businessList['business_slug']; ?>">
                                            <?php if($_businessList['business_user_image'] != ""){ ?>
                                                <img src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL.$_businessList['business_user_image'] ?>">
                                            <?php }
                                        else{ ?>
                                            <img src="<?php echo BASEURL . NOBUSIMAGE ?>">
                                        <?php }
                                        ?>
                                        </a>                                        
                                    </div>
                                    <div class="job-top-detail">
                                        <h5>
                                            <a href="<?php echo base_url().'company/'.$_businessList['business_slug']; ?>">
                                                <?php echo $_businessList['company_name']; ?>
                                            </a>
                                        </h5>
                                        <?php if($_businessList['industry_name'] != ""): ?>
                                            <h5>
                                                <a href="<?php echo base_url().'company/'.$_businessList['business_slug']; ?>">
                                                    <?php echo ucwords($_businessList['industry_name']); ?>
                                                </a>
                                            </h5>
                                        <?php
                                        else: ?>
                                            <h5>
                                                <a href="<?php echo base_url().'company/'.$_businessList['business_slug']; ?>">
                                                    <?php echo ucwords($_businessList['other_industrial']); ?>
                                                </a>                                                
                                            </h5>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="all-job-middle">
                                <ul class="search-detail">
                                    <?php 
                                    if($_businessList['contact_website'] != ""): ?>
                                    <li>
                                        <span class="img"><img class="pr10" src="<?php echo base_url('assets/n-images/website.png') ?>"></span> <p class="detail-content"><a href="<?php echo $_businessList['contact_website']; ?>" target="_self"><?php echo $_businessList['contact_website']; ?></a></p>
                                    </li>
                                    <?php endif; ?>
                                    <li>
                                        <span class="img"><img class="pr10" src="<?php echo base_url('assets/n-images/location.png') ?>"></span>
                                        <p class="detail-content">
                                            <span><?php echo $_businessList['city'].($_businessList['country'] != "" ? ",(".$_businessList['country'].")" : "");?>
                                            </span>
                                        </p>
                                    </li>
                                    <?php 
                                    if($_businessList['details'] != ""): ?>
                                    <li>
                                        <span class="img"><img class="pr10" src="<?php echo base_url('assets/n-images/exp.png') ?>"></span><p class="detail-content view-more-expand" style="position: relative;">
                                            <?php echo $_businessList['details']; ?>
                                            <?php if(strlen($_businessList['details']) > 100): ?><a class="read-more-post" href="<?php echo base_url().'company/'.$_businessList['business_slug']; ?>" style="bottom: 3px;">&nbsp;...Read more</a>
                                            <?php endif; ?>
                                        </p>
                                    </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                        <?php 
                            endforeach;
                        endif;
                        if(isset($businessList) && empty($businessList) && $page == 0):?>
                        <!-- NO RESULT FOUND DIV -->
                        <div class="job-contact-frnd">
                            <!-- AJAX DATA... -->
                            <div class="text-center rio">
                                <h1 class="page-heading  product-listing" style="border:0px;margin-bottom: 11px;">Oops No Data Found.</h1>
                                <p style="text-transform:none !important;border:0px;margin-left:4%;">We couldn't find what you were looking for.</p>
                            </div>
                        </div>
                        <?php endif; ?>
						
                        <div id="loader" class="hidden">
                            <p style="text-align:center;">
                                <img alt="loader" class="loader" src="<?php echo base_url('assets/images/loading.gif') ?>">
                            </p>
                        </div>
						<div class="banner-add">
							<?php $this->load->view('banner_add'); ?>
						</div>
                        <?php echo $links; ?>
                    </div>
                    <div class="right-part">
                       <?php $this->load->view('right_add_box'); ?>
    					
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
                            <button type="button" class="modal-close" data-dismiss="modal">&times;</button>         
                            <div class="mid-modal-body">
        						<div class="mid-modal-body">
                                    <?php echo $business_left; ?>
        							<!-- <div class="left-search-box list-type-bullet">
        								<div class="">
        									<h3>Top Categories</h3>
        								</div>
        								<ul class="search-listing custom-scroll">
        									<li ng-repeat="category in businessCategory">
        										<label class="control control--checkbox">
        											<span>{{category.industry_name | capitalize}}
        												<span class="pull-right">({{category.count}})</span>
        											</span>
        											<input class="categorycheckbox" type="checkbox" name="{{category.industry_name}}" value="{{category.industry_id}}" style="height: 12px;" [attr.checked]="(category.isselected) ? 'checked' : null" autocomplete="false">
        										   <div class="control__indicator"></div>

        										</label>
        										
        									</li>
        								</ul>
        								<p class="text-left p10">
        									<a href="<?php echo business_category_list; ?>">View More Categories</a>
        								</p>
        							</div>
        							<div class="left-search-box list-type-bullet">
        								<div class="">
        									<h3>Top Locations</h3>
        								</div>                        
        								<ul class="search-listing" style="list-style: none;">
        									<li ng-repeat="location in businessLocation">
        										<label class="control control--checkbox">
        											<span>{{location.city_name | capitalize}}
        												<span class="pull-right">({{location.count}})</span>
        											</span>
        											<input class="locationcheckbox" type="checkbox" name="{{location.city_name}}" value="{{location.city_id}}" style="height: 12px;" [attr.checked]="(location.isselected) ? 'checked' : null" autocomplete="false">
        											<div class="control__indicator"></div>
        										</label>
        									</li>
        								</ul>
        								<p class="text-left p10">
        									<a href="<?php echo business_location_list; ?>">View More Locations</a>
        								</p>
        							</div> -->
        						</div>
                            </div>
                        </div>
                    </div>
                </div>
	        </div>
		</div>
        <?php // $this->load->view('mobile_side_slide'); ?>
		
        <script src="<?php echo base_url('assets/js/aos.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/owl.carousel.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/croppie.js?ver='.time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-ui.min.js'); ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
        <script data-semver="0.13.0" src="https://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
        <script>
            var base_url = '<?php echo base_url(); ?>';
            var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
            var title = '<?php echo $title; ?>';
            var header_all_profile = '<?php echo $header_all_profile; ?>';
            var category_id = '<?php echo $category_id; ?>';
            var location_id = '<?php echo $location_id; ?>';
            var q = '<?php echo $q; ?>';
            var l = '<?php echo $l; ?>';
            var filter_url = '<?php echo $filter_url; ?>';
            var app = angular.module('', ['ui.bootstrap']);

            function applyJobFilter() {
                // console.log(111);
                pagenum = 1;
                $(".frm-job-company-filter").on("change", "input:checkbox", function(event){
                    $('.frm-job-company-filter').attr('action', filter_url);
                    this.form.submit();
                    event.preventDefault();
                });
            }
            $(document).ready(function(){
                $("#pagination").on("click", "a", function(e){
                    console.log();
                    e.preventDefault();
                    $('.frm-job-company-filter').attr('action', this.href);
                    $(".frm-job-company-filter").submit();
                });
            });
        </script>               
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/business-live/searchBusiness.js?ver=' . time()) ?>"></script>
        <!-- <script src="<?php //echo base_url('assets/js/webpage/business-live/categoryBusinessList.js?ver=' . time()) ?>"></script> -->
        <?php 
            if($isbusiness_register == true && $isbusiness_deactive == false){
        ?>
            <script src="<?php echo base_url('assets/js/webpage/business-profile/common.js?ver=' . time()) ?>"></script>
        <?php
            }
        if($this->session->userdata('aileenuser') == ""):
        ?>
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
                        "@id": "<?php echo base_url(); ?>business-search",
                        "name": "Business"
                    }
                },
                {
                    "@type": "ListItem",
                    "position": 3,
                    "item":
                    {
                        "@id": "<?php echo $item3_url; ?>",
                        "name": "<?php echo $item3_txt; ?>"                
                    }
                },
                {
                    "@type": "ListItem",
                    "position": 4,
                    "item":
                    {
                        "@id": "<?php echo current_url(); ?>",
                        "name": "<?php echo $search_txt; ?>"
                    }
                }
            ]
        }
        </script>
        <?php endif; ?>
    </body>
</html>