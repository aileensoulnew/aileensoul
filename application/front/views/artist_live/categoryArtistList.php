<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- <title ng-bind="title"></title> -->
        <title><?php echo $title; ?></title>
        <meta name="description" content="<?php echo $metadesc; ?>" />
        <meta charset="utf-8">
        <!-- <meta name="robots" content="noindex, nofollow"> -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>"> 
		<link rel="stylesheet" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()) ?>">		
        <link rel="stylesheet" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/aos.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()) ?>">
		<?php
           if($isartistactivate == true && $artist_isregister){
               
        ?>
			<link rel="stylesheet" href="<?php echo base_url('assets/css/header.css?ver=' . time()) ?>">
			
		   <?php } ?>

        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()) ?>">
		<script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
    <?php $this->load->view('adsense'); ?>
</head>
    <body class="profile-main-page">
        <?php //$this->load->view('page_loader'); ?>
        <div id="main_page_load">
            <!-- SET BLANK IF VAR NOT DECLARE FROM CONTROLLER -->
            <?php   
                $location_id = (isset($location_id)) ? $location_id : ''; 
                $category_id = (isset($category_id)) ? $category_id : ''; 
                $session_user_id = $this->session->userdata('aileenuser');
                if ($ismainregister == false) {
                    // $this->load->view('artist_live/login_header');
                }else if($isartistactivate == true && $artist_isregister == true && $session_user_id){
                    echo $artistic_header2;
                }else{
                    echo $header_profile;
                }
            ?>
    		<?php
               if($ismainregister == false ){
            ?>
                <div class="middle-section middle-section-banner new-ld-page">
            <?php echo $search_banner; 
                } else if($isartistactivate == true && $artist_isregister == true) { ?>
                <div class="middle-section">
            <?php } else { ?>
                <div class="middle-section middle-section-banner">
            <?php echo $search_banner;  
            } ?>
                <div class="container pt20 mobp0 mobmt15">
                    <div class="left-part">
                        <?php echo $artist_left; ?>
						<?php $this->load->view('right_add_box'); ?>
						<?php echo $left_footer_list_view; ?> 
                    </div>
                    <div class="middle-part">
                        <div class="page-title">
                            <h3>Search Result</h3>
                        </div>
						<div class="tab-add">
							<?php $this->load->view('banner_add'); ?>
						</div>
						
						<?php 
                        if(isset($artistList) && !empty($artistList)):
                            foreach($artistList as $_artistList):
                         ?>
                        <div class="all-job-box search-business">
                            <div class="search-business-top">
                                <div class="bus-cover no-cover-upload">
                                    <a href="<?php echo artist_dashboard.$_artistList['slug']; ?>">
                                        <?php if($_artistList['profile_background'] != ""){?>
                                        <img src="<?php echo ART_BG_MAIN_UPLOAD_URL.$_artistList['profile_background']; ?>">
                                    <?php }else{ ?>
                                        <img src="<?php echo BASEURL . WHITEIMAGE ?>">
                                    <?php } ?>
                                    </a>                                    
                                </div>
                                <div class="all-job-top">
                                    <div class="post-img">
                                        <a href="<?php echo artist_dashboard.$_artistList['slug']; ?>">
                                            <?php if($_artistList['art_user_image'] != ""){?>
                                            <img src="<?php echo ART_PROFILE_MAIN_UPLOAD_URL.$_artistList['art_user_image']; ?>">
                                            <?php }else{ ?>
                                            <img src="<?php echo BASEURL . NOARTIMAGE ?>">
                                            <?php } ?>
                                        </a>                                        
                                    </div>
                                    <div class="job-top-detail">
                                        <h5>
                                            <a href="<?php echo artist_dashboard.$_artistList['slug']; ?>"><?php echo ucwords($_artistList['fullname']); ?>
                                            </a>
                                        </h5>
                                        <?php if($_artistList['art_category'] != ""){?>
                                        <h5>
                                            <a href="<?php echo artist_dashboard.$_artistList['slug']; ?>">
                                                <?php echo ucwords($_artistList['art_category']); ?>
                                            </a>
                                        </h5>
                                        <?php
                                        }
                                        else{?>
                                        <h5>
                                            <a href="<?php echo artist_dashboard.$_artistList['slug']; ?>">
                                                <?php echo ucwords($_artistList['other_skill']); ?>
                                            </a>
                                        </h5>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="all-job-middle">
                                <ul class="search-detail">
                                    <li>
                                        <span class="img">
                                            <img class="pr10" src="<?php echo base_url('assets/n-images/location.png') ?>">
                                        </span>
                                        <p class="detail-content">
                                            <span><?php echo $_artistList['city'].($_artistList['city'] != "" ? ',('.$_artistList['country'].')' : $_artistList['country']); ?></span>      
                                        </p>
                                    </li>
                                    <?php if($_artistList['art_desc_art'] != ""): ?>
                                    <li>
                                        <span class="img"><img class="pr10" src="<?php echo base_url('assets/n-images/exp.png') ?>"></span>
                                        <p class="detail-content"><?php echo substr($_artistList['art_desc_art'], 0,110) ?>...<a href="<?php echo artist_dashboard.$_artistList['slug']; ?>"> Read more</a>
                                        </p>
                                    </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
							
						</div>
						
                        <!-- NO RESULT FOUND DIV -->
                        <?php endforeach;
                        endif;
                        if(isset($artistList) && empty($artistList) && $page == 0): ?>	
                        <div class="art-img-nn user_no_post_avl" ng-if="ArtistList.length <= 0">
                            <div class="art_no_post_img">
                                <img alt="No Saved freelancer" src="<?php echo base_url('assets/img/free-no1.png') ?>">
                            </div>
                            <div class="art_no_post_text">No Result Found..</div>
                        </div>
                        <?php endif; ?>
						<div class="banner-add">
								<?php $this->load->view('banner_add'); ?>
							</div>
                        <?php echo $links; ?>
                        <div id="loader" class="hidden">
                            <p style="text-align:center;">
                                <img alt="loader" class="loader" src="<?php echo base_url('assets/images/loading.gif') ?>">
                            </p>
                        </div>
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
                                    <?php echo $artist_left; ?>
        							<!-- <div class="left-search-box list-type-bullet">
        								<div class="">
        									<h3>Top Categories</h3>
        								</div>
        								<ul class="search-listing">
        									<li ng-repeat="category in artistCategory">
        										<label class="control control--checkbox">
        											<span>{{category.art_category | capitalize}}
        												<span class="pull-right">({{category.count}})</span>
        											</span>
        											<input class="categorycheckbox" type="checkbox" name="{{category.art_category}}" value="{{category.category_id}}" style="height: 12px;" [attr.checked]="(category.isselected) ? 'checked' : null" autocomplete="false">
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
        											<span> {{location.art_location | capitalize}}
        												<span class="pull-right">({{location.total}})</span>
        											</span>
        											<input class="locationcheckbox" type="checkbox" name="{{location.art_location}}" value="{{location.location_id}}" style="height: 12px;" [attr.checked]="(location.isselected) ? 'checked' : null" autocomplete="false">
        											<div class="control__indicator"></div>
        										</label>
        									</li>
        								</ul>
        								<p class="text-left p10"><a href="<?php echo artist_location_list ?>">View More Locations</a></p>
        							</div> -->
        						</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</div>
        <?php $this->load->view('mobile_side_slide'); ?>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/owl.carousel.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/aos.js?ver=' . time()) ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
        <script src="<?php echo base_url('assets/js/jquery-ui.min.js'); ?>"></script>
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
        <script src="<?php echo base_url('assets/js/webpage/artist-live/searchArtist.js?ver=' . time()) ?>"></script>
        <!-- <script src="<?php //echo base_url('assets/js/webpage/artist-live/categoryArtistList.js?ver=' . time()) ?>"></script> -->
    </body>
</html> 