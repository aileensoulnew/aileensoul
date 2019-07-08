<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $title; ?></title>
        <meta name="description" content="<?php echo $metadesc; ?>" />
        <!-- <title ng-bind="title"></title> -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <link rel="canonical" href="<?php echo current_url(); ?>" />
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
    <body class="profile-main-page two-hd">
        <?php //$this->load->view('page_loader'); ?>
        <div id="main_page_load">

        <!-- SET BLANK VALUE IF VAR. NOT SET FROM CONTROLLER -->
        <?php $location_id = (isset($location_id)) ? $location_id : ''; ?>
        <?php $category_id = (isset($category_id)) ? $category_id : ''; ?>

        <?php 
            if($ismainregister == false){
            }else if($isbusiness_register == true && $isbusiness_deactive == false){
                echo $business_header2;
            }else{
                echo $header_profile; 
            }
        ?>
        <?php
           if($ismainregister == false){
        ?>
            <div class="main-section middle-section-banner new-ld-page">
        <?php //echo $search_banner; 
            } else if(!$isbusiness_deactive && $isbusiness_register == true) { ?>
            <div class="main-section">
        <?php } else { ?>
            <div class="main-section middle-section-banner">
        <?php //echo $search_banner;  
        } ?>
        <!-- <div class="middle-section middle-section-banner new-ld-page"> -->
                <?php if($business_profile_set == 0 && $business_profile_set == '0'){ echo $search_banner; } ?>
                <div class="container mobp0 mobmt15">
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
                            $usre_id = $this->session->userdata('aileenuser');
                            foreach($businessList as $index=>$_businessList): ?>
                                <div class="all-job-box search-business">
                                    <?php
                                    $popover = '';
                                    if($usre_id){ 
                                        $popover = 'data-toggle="popover" data-uid="'.$_businessList['user_id'].'" data-utype="2"';
                                     } ?>
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
                                                <a href="<?php echo base_url().'company/'.$_businessList['business_slug']; ?>" <?php echo $popover; ?>>
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
                                                    <a href="<?php echo base_url().'company/'.$_businessList['business_slug']; ?>" <?php echo $popover; ?>>
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
                                                    <span><?php 
                                                    if($_businessList['city'] != '')
                                                    {
                                                        echo $_businessList['city'].($_businessList['country'] != "" ? ",(".$_businessList['country'].")" : "");
                                                    }
                                                    elseif ($_businessList['city'] == '' && $_businessList['other_city']) {
                                                        echo $_businessList['other_city'].($_businessList['country'] != "" ? ",(".$_businessList['country'].")" : "");
                                                    }
                                                    else
                                                    {
                                                        echo $_businessList['country'];
                                                    }
                                                    
                                                    ?>
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
		
        <!-- <script src="<?php //echo base_url('assets/js/aos.js?ver=' . time()) ?>"></script> -->
        <script src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/owl.carousel.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/croppie.js?ver='.time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-ui.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/angular/angular.min-1.6.4.js?ver=' . time()); ?>"></script>
        <script data-semver="0.13.0" src="<?php echo base_url('assets/js/angular/ui-bootstrap-tpls-0.13.0.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/angular/angular-route-1.6.4.js?ver=' . time()); ?>"></script>
        <script>
            var base_url = '<?php echo base_url(); ?>';
            var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
            var title = '<?php echo $title; ?>';
            var header_all_profile = '<?php echo $header_all_profile; ?>';
            var category_id = '<?php echo $category_id; ?>';
            var location_id = '<?php echo $location_id; ?>';
            var q = '<?php echo $q; ?>';
            var l = '<?php echo $l; ?>';

            var bus_bg_main_upload_url = '<?php echo BUS_BG_MAIN_UPLOAD_URL; ?>';
            var bus_profile_thumb_upload_url = '<?php echo BUS_PROFILE_THUMB_UPLOAD_URL; ?>';
            var nobusimage = '<?php echo NOBUSIMAGE; ?>';
            var user_bg_main_upload_url = '<?php echo USER_BG_MAIN_UPLOAD_URL; ?>';
            var user_thumb_upload_url = '<?php echo USER_THUMB_UPLOAD_URL; ?>';
            var message_url = '<?php echo MESSAGE_URL; ?>';

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
            function details_in_popup(uid,login_user_id,utype,div_id){
                socket.emit('get user card',uid,login_user_id,utype);
                socket.on('get user card', (data) => {
                    // var times = $scope.today.getHours()+''+$scope.today.getMinutes()+''+$scope.today.getSeconds();
                    var today = new Date();
                    var hh = today.getHours() < 10 ? '0'+today.getHours() : today.getHours();
                    var mm = today.getMinutes() < 10 ? '0'+today.getMinutes() : today.getMinutes();
                    var ss = today.getSeconds() < 10 ? '0'+today.getSeconds() : today.getSeconds();
                    var times = hh+''+mm+''+ss;
                    var all_html = '';
                    if(data.user_type.toString() == '2')
                    {
                        all_html += '<div class="bus-tooltip">';
                            all_html += '<div class="user-tooltip">';
                            
                                all_html += '<div class="tooltip-cover-img">';
                                if(data.user_data.profile_background)
                                {
                                    all_html += '<img src="'+bus_bg_main_upload_url+data.user_data.profile_background+'">';
                                }
                                else
                                {
                                    all_html += '<div class="gradient-bg" style="height: 100%"></div>';   
                                }
                                all_html += '</div>';

                                all_html += '<div class="tooltip-user-detail">';
                                    all_html += '<div class="tooltip-user-img">';
                                    if(data.user_data.business_user_image)
                                    {
                                        all_html += '<img src="'+bus_profile_thumb_upload_url+data.user_data.business_user_image+'">';
                                    }
                                    else
                                    {
                                        all_html += '<img src="'+base_url+nobusimage+'">';
                                    }
                                    all_html += '</div>';
                                    
                                    all_html += '<div class="fw">';
                                        all_html += '<div class="tooltip-detail">';
                                            all_html += '<h4>'+data.user_data.company_name+'</h4>';
                                            all_html += '<p>';
                                                if(data.user_data.industry_name){
                                                    all_html += data.user_data.industry_name;
                                                }
                                                else{
                                                    all_html += "Current Work";
                                                }
                                            all_html += '</p>';

                                            all_html += '<p>';
                                                all_html += data.user_data.city_name + (data.user_data.state_name != '' ? ',' : '') + data.user_data.state_name + (data.user_data.country_name != '' ? ',' : '') + data.user_data.country_name;
                                            all_html += '</p>';
                                        all_html += '</div>';

                                        if(data.user_data.user_id != login_user_id){
                                            all_html += '<div class="tooltip-btns follow-btn-bus-'+data.user_data.user_id+'">';
                                                if(data.follow_status == '1'){
                                                    all_html += '<a class="btn-new-1 following" data-uid="'+data.user_data.user_id+''+times+'" onclick="unfollow_user_bus(this.id)" id="follow_btn_bus">Following</a>';
                                                }
                                                else
                                                {
                                                    all_html += '<a class="btn-new-1 follow" data-uid="'+data.user_data.user_id+''+times+'" onclick="follow_user_bus(this.id)" id="follow_btn_bus">Follow</a>';
                                                }
                                            all_html += '</div>';
                                        }

                                    all_html += '</div>';

                                all_html += '</div>';
                            all_html += '</div>';
                        all_html += '</div>';
                    }
                    if(data.user_type.toString() == '1')
                    {
                        all_html += '<div class="user-tooltip">';
                            all_html += '<div class="tooltip-cover-img">';
                                if(data.user_data.profile_background){
                                    all_html += '<img src="'+user_bg_main_upload_url+data.user_data.profile_background+'">';
                                }
                                else{
                                    all_html += '<div class="gradient-bg" style="height: 100%"></div>';
                                }
                            all_html += '</div>';
                            all_html += '<div class="tooltip-user-detail">';
                                all_html += '<div class="tooltip-user-img">';
                                    if(data.user_data.user_image){
                                        all_html += '<img src="'+user_thumb_upload_url+data.user_data.user_image+'">';
                                    }
                                    else
                                    {
                                        if(data.user_data.user_gender == 'M'){
                                            all_html += '<img src="'+base_url+"assets/img/man-user.jpg"+'">';
                                        }
                                        if(data.user_data.user_gender == 'F'){
                                            all_html += '<img src="'+base_url+"assets/img/female-user.jpg"+'">';
                                        }
                                    }
                                all_html += '</div>';

                                // all_html += '<h4>'+data.user_data.fullname+'</h4>';
                                all_html += '<h4><a href="'+base_url+data.user_data.user_slug+'" target="_self">'+data.user_data.fullname+'</a></h4>';
                                all_html += '<p>';
                                    if(data.user_data.title_name && !data.user_data.degree_name){
                                        all_html += (data.user_data.title_name.length > 30 ? data.user_data.title_name.substr(0,30)+'...' : data.user_data.title_name);
                                    }
                                    else if(!data.user_data.title_name && data.user_data.degree_name){
                                        all_html += (data.user_data.degree_name.length > 30 ? data.user_data.degree_name.substr(0,30)+'...' : data.user_data.degree_name);
                                    }
                                    else{
                                        all_html += "Current Work";
                                    }
                                all_html += '</p>';
                                if(data.post_count != '' || data.contact_count != '' || data.follower_count != ''){
                                    all_html += '<p>';
                                        if(data.post_count != ''){
                                            all_html += '<span><b>'+data.post_count+'</b> Posts</span>';
                                        }
                                        if(data.contact_count != ''){
                                            all_html += '<span><b>'+data.contact_count+'</b> Contacts</span>';
                                        }
                                        if(data.follower_count != ''){
                                            all_html += '<span><b>'+data.follower_count+'</b> Followers</span>';
                                        }
                                    all_html += '</p>';
                                }
                                if(data.mutual_friend.length > 0){
                                    all_html += '<ul>';
                                    for(var i=0;i<data.mutual_friend.length;i++){
                                        if(i == 2)
                                        {
                                            break;
                                        }
                                        friends = data.mutual_friend[i];
                                        all_html += '<li><div class="user-img">';
                                        if(friends.user_image){
                                            all_html += '<img src="'+user_thumb_upload_url+friends.user_image+'">';
                                        }
                                        else
                                        {                        
                                            if(friends.user_gender == 'M'){
                                                all_html += '<img src="'+base_url+"assets/img/man-user.jpg"+'">';
                                            }
                                            if(friends.user_gender == 'F'){
                                                all_html += '<img src="'+base_url+"assets/img/female-user.jpg"+'">';
                                            }
                                        }
                                        all_html += '</div></li>';
                                    }

                                    all_html += '<li class="m-contacts">';
                                        if(data.mutual_friend.length == 1){
                                            all_html += '<span><b>'+data.mutual_friend[0].fullname+'</b> is in mutual contact.</span>';
                                        }
                                        else if(data.mutual_friend.length > 1){
                                            all_html += '<span><b>'+data.mutual_friend[0].fullname+'</b> and <b>'+parseInt(data.mutual_friend.length - 1)+'</b> more mutual contacts.</span>';
                                        }
                                    all_html += '</li>';
                                    all_html += '</ul>';
                                }

                                if(data.user_data.user_id != login_user_id){
                                    all_html += '<div class="tooltip-btns">';
                                        all_html += '<ul>';
                                            all_html += '<li class="contact-btn-'+data.user_data.user_id+'">';
                                                if(data.contact_value == 'new'){
                                                    all_html += '<a class="btn-new-1" data-param="'+data.contact_id+''+times+',pending,'+data.user_data.user_id+''+times+','+times+',0" onclick="contact(this.id);" id="contact_btn_'+data.user_data.user_id+'">Add to contact</a>';
                                                }
                                                else if(data.contact_value == 'confirm'){
                                                    all_html += '<a class="btn-new-1" data-param="'+data.contact_id+''+times+',cancel,'+data.user_data.user_id+''+times+','+times+',1" onclick="contact(this.id);" id="contact_btn_'+data.user_data.user_id+'">In Contacts</a>';
                                                }
                                                else if(data.contact_value == 'pending'){
                                                    all_html += '<a class="btn-new-1" data-param="'+data.contact_id+''+times+',cancel,'+data.user_data.user_id+''+times+','+times+',0" onclick="contact(this.id);" id="contact_btn_'+data.user_data.user_id+'">Request sent</a>';
                                                }
                                                else if(data.contact_value == 'cancel'){
                                                    all_html += '<a class="btn-new-1" data-param="'+data.contact_id+''+times+',pending,'+data.user_data.user_id+''+times+','+times+',0" onclick="contact(this.id);" id="contact_btn_'+data.user_data.user_id+'">Add to contact</a>';
                                                }
                                                else if(data.contact_value == 'reject'){
                                                    all_html += '<a class="btn-new-1" data-param="'+data.contact_id+''+times+',pending,'+data.user_data.user_id+''+times+','+times+',0" onclick="contact(this.id);" id="contact_btn_'+data.user_data.user_id+'">Add to contact</a>';
                                                }
                                            all_html += '</li>';

                                            all_html += '<li class="follow-btn-user-'+data.user_data.user_id+'">';
                                                if(data.follow_status == '1'){
                                                    all_html += '<a class="btn-new-1 following" data-uid="'+data.user_data.user_id+''+times+'" onclick="unfollow_user(this.id)" id="follow_btn_bus">Following</a>';
                                                }
                                                else
                                                {
                                                    all_html += '<a class="btn-new-1 follow" data-uid="'+data.user_data.user_id+''+times+'" onclick="follow_user(this.id)" id="follow_btn_bus">Follow</a>';
                                                }
                                            all_html += '</li>';

                                            all_html += '<li>';
                                                all_html += '<a href="'+message_url+'user/'+data.user_data.user_slug+'" class="btn-new-1" target="_blank">Message</a>';
                                            all_html += '</li>';

                                        all_html += '</ul>';
                                    all_html += '</div>';
                                }

                            all_html += '</div>';
                        all_html += '</div>';
                    }
                    // console.log(data);
                    $('#'+div_id).html(all_html);
                });
                return '<div id="'+ div_id +'"><div class="user-tooltip"><div class="fw text-center" style="padding-top:85px;min-height:200px"><img src="'+base_url+'assets/images/loader.gif" alt="Loader" style="width:auto;" /></div></div></div>';
            }
            $(document).ready(function(){
                $("#pagination").on("click", "a", function(e){
                    console.log();
                    e.preventDefault();
                    $('.frm-job-company-filter').attr('action', this.href);
                    $(".frm-job-company-filter").submit();
                });
                setTimeout(function(){
                    $('[data-toggle="popover"]').popover({
                        trigger: "manual" ,
                        html: true, 
                        animation:false,
                        template: '<div class="popover cus-tooltip" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
                        content: function () {
                            // return $($(this).data('tooltip-content')).html();
                            var uid = $(this).data('uid');
                            var utype = $(this).data('utype');
                            var div_id =  "tmp-id-" + $.now();
                            return details_in_popup(uid,user_id,utype,div_id);//$(this).data('tooltip-url'),div_id);
                            // return $('#popover-content').html();
                        },
                        placement: function (context, element) {

                            var $this = $(element);
                            var offset = $this.offset();
                            var width = $this.width();
                            var height = $this.height();

                            var centerX = offset.left + width / 2;
                            var centerY = offset.top + height / 2;
                            var position = $(element).position();
                            
                            if(centerY > $(window).scrollTop())
                            {
                                scroll_top = $(window).scrollTop();
                                scroll_center = centerY;
                            }
                            if($(window).scrollTop() > centerY)
                            {
                                scroll_top = centerY;
                                scroll_center = $(window).scrollTop();
                            }
                            
                            if (parseInt(scroll_center - scroll_top) < 340){
                                return "bottom";
                            }                        
                            return "top";
                        }
                    }).on("mouseenter", function () {
                        var _this = this;
                        $(this).popover("show");
                        $(".popover").on("mouseleave", function () {
                            $(_this).popover('hide');
                        });
                    }).on("mouseleave", function () {
                        var _this = this;
                        setTimeout(function () {
                            if (!$(".popover:hover").length) {
                                $(_this).popover("hide");
                            }
                        }, 100);
                    });
                },500);
            });
        </script>
        <script src="<?php echo SOCKETSERVER; ?>/socket.io/socket.io.js"></script>
        <script type="text/javascript">
            var socket = io.connect("<?php echo SOCKETSERVER; ?>");
        </script>
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/business-live/searchBusiness.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/notification.js?ver=' . time()) ?>"></script>
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