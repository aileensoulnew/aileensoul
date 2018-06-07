<link rel="stylesheet" href="<?php echo base_url('assets/n-css/component.css') ?>" />

<?php
$session_user = $this->session->userdata();
$userData = $this->user_model->getUserData($session_user['aileenuser']);
$browser = $this->agent->browser();
$browserVersion = $this->agent->version();
if($browser == "Internet Explorer")
{
    if(explode(".", $browserVersion)[0] < 11)
    {
        echo "<div class='update-browser'>For a better experience, update your browser.</div>";
    }
}
if($browser == "Chrome")
{            
    if(explode(".", $browserVersion)[0] < 65)
    {
        echo "<div class='update-browser'>For a better experience, update your browser.</div>";
    }
}
if($browser == "Firefox")
{            
    if(explode(".", $browserVersion)[0] < 55)
    {
        echo "<div class='update-browser'>For a better experience, update your browser.</div>";
    }
}
?>
<header ng-controller="headerCtrl" ng-app="headerApp">
    <div class="animated fadeInDownBig">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6 left-header">                    
                    <h2 class="logo">
                        <a ng-href="<?php echo base_url('/') ?>" title="Aileensoul" target="_self"><img ng-src="<?php echo base_url('assets/img/logo-name.png?ver=' . time()) ?>" alt="Aileensoul"></a>
                    </h2>
                    <?php
                        $first_segment = $this->uri->segment(1);
                        $isartist_segment = strpos($first_segment, 'artist');
                        $isbusiness_segment = strpos($first_segment, 'business');
                        // $isbusiness_segment = strpos($first_segment, 'jobs');
                        if(isset($userData) && !empty($userData) && $this->job_profile_set == 1){                            
                            $isjobs = strpos($first_segment, '-jobs');
                            $isjobs_in = strpos($first_segment, 'jobs-in-');
                            $isjob_vacancy = strpos($first_segment, '-job-vacancy-in-');
                            $isjobs_open = strpos($first_segment, 'jobs-opening-at-');
                        }
                        // $job_page_array = array("job","job-search","recommended-jobs","jobs-by-companies","jobs-by-categories","jobs-by-skills","jobs-by-location","jobs-by-designations","jobs","job-profile");
                        $job_page_array = array("job","job-search","recommended-jobs","jobs-by-companies","jobs-by-categories","jobs-by-skills","jobs-by-location","jobs-by-designations","jobs","job-profile","-job-vacancy-in-","freelance-jobs-by-fields","freelance-jobs-by-categories");
                    ?>
                    <?php if (($is_userBasicInfo == '1' || $is_userStudentInfo == '1') && ($first_segment != 'business-search' && $first_segment != 'business-profile' && $first_segment != 'business' && $first_segment != 'company' && $isbusiness_segment === FALSE) && ($first_segment != 'find-artist') && ($first_segment != 'artist') && $isartist_segment === FALSE && !in_array($first_segment, $job_page_array) && ($isjobs === FALSE && $isjobs_in === FALSE && $isjob_vacancy === FALSE && $isjobs_open === FALSE )) { ?>
                        <form ng-submit="search_submit" action="<?php echo base_url('searchh') ?>">
                            <input type="text" name="q" placeholder="Search.." id="search">
                        </form>
                    <?php } ?>
                </div>
                <div class="col-md-6 col-sm-6 right-header">
                    <ul>
                        <?php if ($is_userBasicInfo == '1' || $is_userStudentInfo == '1') { ?>
                            
                            <li>
                                <a ng-href="<?php echo base_url() ?>" title="Opportunity" target="_self"><img ng-src="<?php echo base_url('assets/n-images/op.png?ver=' . time()) ?>" alt="Opportunity"></a>
                            </li>
                            <li id="add-contact" class="dropdown">
                                <a href="javascript:void(0);" title="Contact Request" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" ng-click="header_contact_request()"><img ng-src="<?php echo base_url('assets/n-images/add-contact.png') ?>" alt="Contact Request">
                                    <span class="noti-box" style="display:block" ng-bind="contact_request_count" ng-if="contact_request_count != '0'"></span>
                                </a>
                                <div class="dropdown-menu">
                                    <div class="dropdown-title">
                                        Contact Request <a href="<?php echo base_url('contact-request') ?>" class="pull-right">See All</a>
                                    </div>
                                    <div class="content custom-scroll">
                                        <ul class="dropdown-data add-dropdown">
                                            <li class="" ng-repeat="contact_request in contact_request_data">
                                                <a href="#">
                                                    <div class="dropdown-database" ng-if="contact_request.status == 'pending'">
                                                        <div class="post-img">
                                                            <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{contact_request.user_image}}" alt="{{contact_request.fullname}}" ng-if="contact_request.user_image != ''">
                                                            <img ng-src="<?php echo NOBUSIMAGE2 ?>" ng-if="contact_request.user_image == ''">
                                                        </div>
                                                        <div class="dropdown-user-detail">
                                                            <div class="user-name">
                                                                <h6><b ng-bind="contact_request.fullname | capitalize"></b></h6>
                                                                <div class="msg-discription" ng-bind="contact_request.designation | capitalize" ng-if="contact_request.designation != ''"></div>
                                                                <div class="msg-discription" ng-bind="contact_request.degree | capitalize" ng-if="contact_request.designation == ''"></div>
                                                                <div class="msg-discription" ng-if="contact_request.designation == '' && contact_request.degree == ''">Current Work</div>
                                                            </div>
                                                        </div> 
                                                    </div>
                                                    <div class="dropdown-database confirm_div" ng-if="contact_request.status == 'confirm'">
                                                        <div class="post-img">
                                                            <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{contact_request.user_image}}" alt="{{contact_request.fullname}}" ng-if="contact_request.user_image != ''">
                                                            <img ng-src="<?php echo NOBUSIMAGE2 ?>" ng-if="contact_request.user_image == ''">
                                                        </div>
                                                        <div class="dropdown-user-detail">
                                                            <b ng-bind="contact_request.fullname | capitalize"></b> confirmed your contact request.
                                                            <div class="msg-discription"><span class="time_ago">2 Month Ago</span></div>
                                                        </div> 
                                                    </div>
                                                </a> 
                                                <div class="user-request" ng-if="contact_request.status == 'pending'">
                                                    <a href="javascript:void(0);" class="add-left-true" ng-click="confirmContactRequest(contact_request.from_id, $index)">
                                                        <i class="fa fa-check" aria-hidden="true"></i>
                                                    </a>
                                                    <a href="javascript:void(0);" class="add-right-true" ng-click="rejectContactRequest(contact_request.from_id, $index)">
                                                        <i class="fa fa-times" aria-hidden="true"></i>
                                                    </a>
                                                </div>
                                            </li>
                                            <li ng-if="contact_request_data.length == 0">
                                                <div class="no-data-content">
                                                    <p><img src="<?php echo base_url('assets/img/No_Contact_Request.png');?>"></p>
                                                    <p class="pt20">No Contact Notification</p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li class="dropdown">
                                <a href="#" title="Messages" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img ng-src="<?php echo base_url('assets/n-images/message.png?ver=' . time()) ?>" alt="Messages">
                                    <span class="noti-box" style="display:none;">1</span>
                                </a>
                                <div class="dropdown-menu">
                                    <div class="dropdown-title">
                                        Messages <a href="#" class="pull-right">See All</a>
                                    </div>
                                    <div class="content custom-scroll">
                                        <ul class="dropdown-data msg-dropdown">
                                            <li class="">
                                                <a href="#">
                                                    <div class="dropdown-database">
                                                        <div class="post-img">
                                                            <img ng-src="<?php echo base_url('assets/') ?>n-images/user-pic.jpg" alt="No Business Image">
                                                        </div>
                                                        <div class="dropdown-user-detail">
                                                            <h6><b>Atosa Ahmedabad</b></h6>
                                                            <div class="msg-discription">Hello how are you</div>
                                                            <span class="day-text">1 month ago</span>
                                                        </div> 
                                                    </div>
                                                </a> 
                                            </li>
                                            <li class="">
                                                <a href="#">
                                                    <div class="dropdown-database">
                                                        <div class="post-img">
                                                            <img ng-src="<?php echo base_url('assets/') ?>n-images/user-pic.jpg" alt="No Business Image">
                                                        </div>
                                                        <div class="dropdown-user-detail">
                                                            <h6><b>Atosa Ahmedabad</b></h6>
                                                            <div class="msg-discription">Hello how are you</div>

                                                            <span class="day-text">1 month ago</span>

                                                        </div> 
                                                    </div>
                                                </a> 
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li class="dropdown">
                                <a href="#" title="Notification" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img ng-src="<?php echo base_url('assets/n-images/noti.png?ver=' . time()) ?>" alt="Notification"></a>

                                <div class="dropdown-menu">
                                    <div class="dropdown-title">
                                        Notifications <a href="notification.html" class="pull-right">See All</a>
                                    </div>
                                    <div class="content custom-scroll">
                                        <ul class="dropdown-data noti-dropdown">
                                            <li class="">
                                                <a href="#">
                                                    <div class="dropdown-database">
                                                        <div class="post-img">
                                                            <img ng-src="<?php echo base_url('assets/') ?>n-images/user-pic.jpg" alt="No Business Image">
                                                        </div>
                                                        <div class="dropdown-user-detail">
                                                            <h6>
                                                                <b>   Atosa Ahmedabad</b> 
                                                                <span class="">Started following you in business profile.</span>
                                                            </h6>
                                                            <div>

                                                                <span class="day-text">1 month ago</span>
                                                            </div>
                                                        </div> 
                                                    </div>
                                                </a> 
                                            </li>
                                            <li class="">
                                                <a href="#">
                                                    <div class="dropdown-database">
                                                        <div class="post-img">
                                                            <img ng-src="<?php echo base_url('assets/') ?>n-images/user-pic.jpg" alt="No Business Image">
                                                        </div>
                                                        <div class="dropdown-user-detail">
                                                            <h6>
                                                                <b>   Atosa Ahmedabad</b> 
                                                                <span class="">Started following you in business profile.</span>
                                                            </h6>
                                                            <div>

                                                                <span class="day-text">1 month ago</span>
                                                            </div>
                                                        </div> 
                                                    </div>
                                                </a> 
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <?php
                        }
                        $session_user = $this->session->userdata();
                        ?>
                            <li class="dropdown business_popup" >
                                <a href="javascript:void(0);" title="All Profile" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" ng-click="header_all_profile()"><img ng-src="<?php echo base_url('assets/n-images/all.png') ?>" alt="All Profile"></a>
                                <div class="dropdown-menu"></div>
                            </li>
                        <li class="dropdown user-id">
                            <a href="javascript:void(0);" title="<?php echo $session_user['aileenuser_firstname']; ?>" class="dropdown-toggle user-id-custom" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <?php
                                    if ($session_user['aileenuser_userimage'] != '')
                                    {?>
                                        <span class="usr-img profile-brd" id="header-main-profile-pic">
                                            <img ng-src="<?php echo USER_THUMB_UPLOAD_URL . $session_user['aileenuser_userimage'] ?>" alt="<?php echo $session_user['aileenuser_firstname'] ?>">
                                        </span>
                                    <?php
                                    }
                                    else
                                    {?>                                        
                                        <span class="usr-img" id="header-main-profile-pic">
                                    <?php
                                            if($userData['user_gender'] == "M")
                                            {?>
                                                <img ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                            <?php
                                            }
                                            if($userData['user_gender'] == "F")
                                            {
                                            ?>
                                                <img ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                            <?php
                                            }
                                    ?>
                                        </span>
                                        <?php
                                    } ?>
                                <span class="pr-name"><?php
                                    if (isset($userData['first_name'])) {
                                        echo ucfirst($userData['first_name']);
                                    }
                                    ?></span>
                            </a>
                            <ul class="dropdown-menu profile-dropdown">
                                <li>Account</li>
                                <li><a href="<?php echo base_url().$this->session->userdata('aileenuser_slug'); ?>" title="Setting"><i class="fa fa-user"></i> View Profile</a></li>
                                <li><a href="<?php echo base_url('edit-profile') ?>" title="Setting"><i class="fa fa-cog"></i> Setting</a></li>
                                <li><a href="<?php echo base_url('logout') ?>" title="Logout"><i class="fa fa-power-off"></i> Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right mob-side-menu" id="cbp-spmenu-s2">
		<div class="all-profile-box content custom-scroll">
			<ul class="all-pr-list">
				<li><a href="<?php echo $job_right_profile_link; ?>">Job Profile</a></li>
				<li><a href="<?php echo $recruiter_right_profile_link; ?>">Recruiter Profile</a></li>
				<li><a href="<?php echo $freelance_right_profile_link; ?>">Freelance Profile</a></li>
				<li><a href="<?php echo $business_right_profile_link; ?>">Business Profile</a></li>
				<li><a href="<?php echo $artist_right_profile_link; ?>">Artistic Profile</a></li>
				<!--li>
					<ul class="mob-footer-side"-->
						
                        <li><a title="About Us" href="<?php echo base_url('about-us'); ?>"  target="_blank">About</a></li>
						<li><a title="Blog" href="<?php echo base_url('blog'); ?>" target="_blank">Blog</a></li>
						<li><a title="Faq" tabindex="0" href="<?php echo base_url('faq'); ?>" target="_blank">FAQ</a></li>
						<li><a title="Advertise With Us" href="<?php echo base_url('advertise-with-us'); ?>" target="_blank">Advertise With Us</a></li>
						<!-- <li><a title="Sitemap" tabindex="0" href="<?php //echo base_url('sitemap'); ?>" target="_blank">Sitemap</a></li> -->
						<li><a title="Report" tabindex="0" href="<?php echo base_url('report-abuse'); ?>" target="_blank">Report</a></li>
						<li><a title="Contact Us" href="<?php echo base_url('contact-us'); ?>"  target="_blank">Contact</a></li>
						<li><a title="Send Us Feedback" href="<?php echo base_url('feedback'); ?>" target="_blank">Feedback</a></li>
						<li><a href="<?php echo base_url('terms-and-condition'); ?>" title="Terms and Condition" target="_blank">Terms and Condition</a></li>
                        <li><a href="<?php echo base_url('privacy-policy'); ?>" title="Privacy policy" target="_blank">Privacy Policy</a></li>
                        <li><a title="Disclaimer Policy" href="<?php echo base_url('disclaimer-policy'); ?>"  target="_blank">Disclaimer Policy</a></li>
					<!--/ul>
				</li-->
			</ul>
		</div>
	</nav>
<script>
   var menuRight = document.getElementById( 'cbp-spmenu-s2' ),
    showRight = document.getElementById( 'showRight' ),
    body = document.body;

   showRight.onclick = function() {
    classie.toggle( this, 'active' );
    classie.toggle( menuRight, 'cbp-spmenu-open' );
    disableOther( 'showRight' );
   };
  
   function disableOther( button ) {
    
    if( button !== 'showRight' ) {
     classie.toggle( showRight, 'disabled' );
    }
   }
   
   $(function () {
    $('a[href="#search"]').on('click', function (event) {
     event.preventDefault();
     $('#search').addClass('open');
     $('#search > form > input[type="search"]').focus();
    });
    $('#search, #search button.close-new').on('click keyup', function (event) {
     if (event.target == this || event.target.className == 'close' || event.keyCode == 27) {
      $(this).removeClass('open');
     }
    });
   });
  </script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<script>
        var app = angular.module('headerApp', []);
</script>     
<script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
<script src="<?php echo base_url('assets/js/classie.js?ver=' . time()) ?>"></script>