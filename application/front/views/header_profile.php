<link rel="stylesheet" href="<?php echo base_url('assets/n-css/component.css') ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/header.css?ver=' . time()); ?>">
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
<div class="web-header">
    <header class="custom-header" ng-controller="headerCtrl" ng-app="headerApp">
    <div class="animated fadeInDownBig">
        <div class="container">
            <div class="row">

                <div class="col-md-6 col-sm-6 left-header">
                    <?php $this->load->view('main_logo'); ?>
                    <?php
                        $first_segment = $this->uri->segment(1);
                        $isartist_segment = strpos($first_segment, 'artist');
                        $isjob_segment = strpos($first_segment, 'jobs');
                        $isbusiness_segment = strpos($first_segment, 'business');
                        $job_page_array = array("job","job-search","recommended-jobs","jobs-by-companies","jobs-by-categories","jobs-by-skills","jobs-by-location","jobs-by-designations","jobs","job-profile","-job-vacancy-in-",'freelancer','freelance-work');
                    ?>
                    <?php if (($is_userBasicInfo == '1' || $is_userStudentInfo == '1') && ($first_segment != 'business-search' && $first_segment != 'business-profile' && $isbusiness_segment === FALSE) && ($first_segment != 'artist' && $first_segment != 'find-artist' && $isartist_segment === FALSE) && ($first_segment != 'job' && $first_segment != 'job-search'  && $isjob_segment === FALSE) && ($first_segment != 'recruiter' && $first_segment != 'freelance-employer')&& !in_array($first_segment, $job_page_array)) { ?>
                        <form ng-submit="search_submit" action="<?php echo base_url('search') ?>">
                            <input type="text" name="q" placeholder="Search.." id="search">
                        </form>
                    <?php } ?>
                </div>
                <div class="col-md-6 col-sm-6 right-header">
                    <ul>
                        <?php if ($is_userBasicInfo == '1' || $is_userStudentInfo == '1') { ?>
                            
                            <li>
                                <a ng-href="<?php echo base_url() ?>" title="Opportunity" target="_self"><img ng-src="<?php echo base_url('assets/n-images/op.png') ?>" alt="Opportunity"></a>
                            </li>
                            <li id="add-contact" class="dropdown">
                                <a href="javascript:void(0);" title="Contact Request" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" ng-click="header_contact_request()"><img ng-src="<?php echo base_url('assets/n-images/add-contact.png') ?>" alt="Contact Request">
                                    <span class="noti-box" style="display:block" ng-bind="contact_request_count" ng-if="contact_request_count != '0'"></span>
                                </a>
                                <div class="dropdown-menu">
                                    <div class="dropdown-title">
                                        Contact Request <a href="<?php echo base_url('contact-request') ?>" class="pull-right">See All</a>
                                    </div>
                                    <div class="fw" id="contact_loader"  style="display:none; text-align:center;">
                                        <img src="<?php echo base_url('assets/images/loader.gif') ?>" alt="<?php echo 'LOADERIMAGE'; ?>"/>
                                    </div>
                                    <div class="content custom-scroll">
                                        <ul class="dropdown-data add-dropdown">
                                            <li class="" ng-repeat="contact_request in contact_request_data">
                                                <a href="<?php echo base_url(); ?>{{contact_request.user_slug}}" target="_self">
                                                    <div class="dropdown-database" ng-if="contact_request.status == 'pending'">
                                                        <div class="post-img" ng-if="contact_request.user_image != ''">
                                                            <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{contact_request.user_image}}" alt="{{contact_request.fullname}}">
                                                        </div>
                                                        <div class="post-img" ng-if="contact_request.user_image == ''">
                                                            <img ng-if="contact_request.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                                            <img ng-if="contact_request.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                                        </div>
                                                        <div class="dropdown-user-detail">
                                                            <div class="user-name">
                                                                <h6><b ng-bind="contact_request.fullname | capitalize"></b></h6>
                                                                <div class="msg-discription" ng-bind="contact_request.designation | capitalize" ng-if="contact_request.designation != ''"></div>
                                                                <div class="msg-discription" ng-bind="contact_request.degree | capitalize" ng-if="contact_request.designation == ''"></div>
                                                                <div class="msg-discription" ng-if="contact_request.designation == '' && contact_request.degree == ''">Current Work</div>
                                                                <div class="msg-discription"><span class="time_ago">{{contact_request.time_string}}</span></div>
                                                            </div>
                                                        </div> 
                                                    </div>
                                                </a>
                                                <a href="<?php echo base_url(); ?>{{contact_request.user_slug}}" target="_self">
                                                    <div class="dropdown-database confirm_div" ng-if="contact_request.status == 'confirm'">
                                                        <div class="post-img" ng-if="contact_request.user_image != ''">
                                                            <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{contact_request.user_image}}" alt="{{contact_request.fullname}}">
                                                        </div>
                                                        <div class="post-img" ng-if="contact_request.user_image == ''">
                                                            <img ng-if="contact_request.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                                            <img ng-if="contact_request.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                                        </div>
                                                        <div class="dropdown-user-detail">
                                                            <b ng-bind="contact_request.fullname | capitalize"></b> confirmed your contact request.
                                                            <div class="msg-discription"><span class="time_ago">{{contact_request.time_string}}</span></div>
                                                        </div> 
                                                    </div>
                                                </a> 
                                                <div class="user-request" ng-if="contact_request.status == 'pending'">
                                                    <a href="javascript:void(0);" class="add-left-true" ng-click="confirmContactRequest(contact_request.from_id,$index)">
                                                        <i class="fa fa-check" aria-hidden="true"></i>
                                                    </a>
                                                    <a href="javascript:void(0);" class="add-right-true" ng-click="rejectContactRequest(contact_request.from_id,$index)">
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
                            <li class="dropdown hide">
                                <a href="<?php echo base_url()."message"; ?>" title="Messages" class="dropdown-toggle"><img ng-src="<?php echo base_url('assets/n-images/message.png?ver=' . time()) ?>" alt="Messages">
                                </a>
                                <a href="javascript:void(0);" title="Messages" class="dropdown-toggle hide" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img ng-src="<?php echo base_url('assets/n-images/message.png') ?>" alt="Messages">
                                    <span class="noti-box" style="display:none;">1</span>
                                </a>
                                <div class="dropdown-menu hide">
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
                            <li class="dropdown" style="display: block;">
                                <a href="javascript:void(0);" title="Notification" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" onclick = "return Notificationheader();"><img ng-src="<?php echo base_url('assets/n-images/noti.png') ?>" alt="Notification">
                                    <span id="noti_count" class="noti-box" style="display: none;"></span>
                                </a>

                                <div class="dropdown-menu">
                                    <div class="dropdown-title">
                                        Notifications <span id="seenot" class="pull-right">See All</span>
                                    </div>
                                    <div class="fw" id="not_loader"  style="display:none; text-align:center;position:  absolute;top: 50%;">
                                        <img src="<?php echo base_url('assets/images/loader.gif') ?>" alt="<?php echo 'LOADERIMAGE'; ?>"/>
                                    </div>
                                    <div class="content custom-scroll">
                                        <ul class="notification_data_in">
                                        </ul>
                                    </div>                                    
                                </div>
                            </li>
                        
                        <li class="dropdown business_popup">
                            <a href="javascript:void(0);" title="All Profile" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" ng-click="header_all_profile()"><img ng-src="<?php echo base_url('assets/n-images/all.png') ?>" alt="All Profile"></a>
                            <div class="dropdown-menu"></div>
                        </li>
                        <li class="dropdown user-id">
                            <label title="<?php echo $session_user['aileenuser_firstname']; ?>" class="dropdown-toggle user-id-custom" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <?php
                                    if ($userData['user_image'] != '')
                                    {?>
                                        <span class="usr-img profile-brd" id="header-main-profile-pic">
                                            <img ng-src="<?php echo USER_THUMB_UPLOAD_URL . $userData['user_image'] ?>" alt="<?php echo $userData['first_name'] ?>">
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
                            </label>
                            <ul class="dropdown-menu profile-dropdown">
                                <li>Account</li>
                                <li><a ng-href="<?php echo base_url().$this->session->userdata('aileenuser_slug'); ?>" href="<?php echo base_url().$this->session->userdata('aileenuser_slug'); ?>" title="View Profile"><i class="fa fa-user"></i> View Profile</a></li>
                                <li><a href="<?php echo base_url('edit-profile') ?>" title="Setting"><i class="fa fa-cog"></i> Setting</a></li>
                                <li><a href="<?php echo base_url('logout') ?>" title="Logout"><i class="fa fa-power-off"></i> Logout</a></li>
                            </ul>
                        </li>
                        <?php
                        }                        
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
</div>
<div class="mobile-header">
    <header class="">
        <div class="animated fadeInDownBig">
            <div class="container">
                <div class="left-header">
                    <h2 class="logo"><a target="_self" href="<?php echo base_url(); ?>"><img ng-src="<?php echo base_url('assets/n-images/mob-logo.png') ?>"></a></h2>
                    <?php if ($is_userBasicInfo == '1' || $is_userStudentInfo == '1') { ?>
                    <div class="search-mob-block">
                        <div class="">
                            <?php 
                            $first_segment = $this->uri->segment(1);
                            $page_arr = array('','search','contact-request');
                            if(in_array($first_segment, $page_arr)): ?>
                            <form ng-submit="search_submit" id="mobile_ser_frm" name="mobile_ser_frm" action="<?php echo base_url('search') ?>">
                                <input type="text" name="q" placeholder="Search.." id="mob_search">
                            </form>
                            <?php /*else: ?>
                            <a href="#search">
                                <input type="search" id="tags1" class="tags" name="skills" value="" placeholder="Job Title,Skill,Company" />
                            </a>
                        <?php */endif; ?>
                        </div>
                        <!-- <div id="search">
                            <form method="get">
                                <div class="new-search-input">
                                   <input type="search" id="tags1" class="tags" name="skills" value="" placeholder="Job Title,Skill,Company" />
                                   <input type="search" id="searchplace1" class="searchplace" name="searchplace" value="" placeholder="Find Location" />
                                   
                                </div>
                                <div class="new-search-btn">
                                    <button type="button" class="close-new btn">Cancel</button>
                                    <button type="submit"  id="search_btn" class="btn btn-primary" onclick="return check();">Search</button>
                                </div>
                            </form>
                        </div> -->
                    </div>
                    <div class="right-header">
                        <ul>
                            <li class="dropdown user-id">
                                <label class="dropdown-toggle user-id-custom" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    
                                        <?php
                                        if ($userData['user_image'] != '')
                                        { ?>
                                            <span class="usr-img profile-brd" id="header-main-profile-pic">
                                            <img ng-src="<?php echo USER_THUMB_UPLOAD_URL . $userData['user_image'] ?>" alt="<?php echo $userData['first_name'] ?>">
                                            </span>
                                        <?php
                                        }
                                        else
                                        { ?>
                                            <span class="usr-img">
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
                                            }?>
                                            </span>
                                            <?php
                                        } ?>                                    
                                    <span class="pr-name">
                                        <?php
                                        /*if (isset($session_user['aileenuser_firstname'])) {
                                            echo ucfirst($session_user['aileenuser_firstname']);
                                        }*/ ?>                                            
                                    </span>                                    
                                </label>                                
                                <ul class="dropdown-menu profile-dropdown">
                                    <li>Account</li>
                                    <li><a target="_self" href="<?php echo base_url().$this->session->userdata('aileenuser_slug'); ?>" title="Setting"><i class="fa fa-user"></i> View Profile</a></li>
                                    <li><a target="_self" href="<?php echo base_url('edit-profile') ?>" title="Setting"><i class="fa fa-cog"></i> Setting</a></li>
                                    <li><a target="_self" href="<?php echo base_url('logout') ?>" title="Logout"><i class="fa fa-power-off"></i> Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <?php } ?>
                </div>
                
               
            </div>
        </div>
        
    </header>
    <div class="mob-bottom-menu">
        <ul>
            <li>
                <div class="mob-btm-icon">
                <a href="<?php echo base_url() ?>" title="Opportunity" target="_self">
                    <svg class="not-hover" viewBox="0 0 486.988 486.988" width="25px" height="25px">
                            <path d="M16.822,284.968h39.667v158.667c0,9.35,7.65,17,17,17h116.167c9.35,0,17-7.65,17-17V327.468h70.833v116.167    c0,9.35,7.65,17,17,17h110.5c9.35,0,17-7.65,17-17V284.968h48.167c6.8,0,13.033-4.25,15.583-10.483    c2.55-6.233,1.133-13.6-3.683-18.417L260.489,31.385c-6.517-6.517-17.283-6.8-23.8-0.283L5.206,255.785    c-5.1,4.817-6.517,12.183-3.967,18.7C3.789,281.001,10.022,284.968,16.822,284.968z M248.022,67.368l181.333,183.6h-24.367    c-9.35,0-17,7.65-17,17v158.667h-76.5V310.468c0-9.35-7.65-17-17-17H189.656c-9.35,0-17,7.65-17,17v116.167H90.489V267.968    c0-9.35-7.65-17-17-17H58.756L248.022,67.368z" />
                            
                        </svg>
                        <svg class="on-hover" width="25px" height="25px" viewBox="0 0 2133.000000 2133.000000">
                            <g transform="translate(0.000000,2133.000000) scale(0.100000,-0.100000)">
                                <path d="M10715 20165 c-84 -19 -233 -90 -295 -142 -66 -55 -10218 -9911
                                -10262 -9962 -53 -62 -115 -187 -138 -277 -27 -106 -27 -282 -1 -387 68 -263
                                260 -456 531 -533 61 -17 129 -19 992 -22 l928 -3 2 -3542 3 -3542 23 -70 c85
                                -252 255 -422 507 -507 l70 -23 2640 -3 c1953 -2 2660 0 2715 8 278 43 513
                                254 602 540 l23 75 3 2603 2 2602 1545 0 1545 0 2 -2613 3 -2612 23 -70 c86
                                -255 261 -428 512 -507 l75 -23 2555 0 2555 0 75 23 c252 79 448 280 517 532
                                17 62 18 250 20 3597 l3 3532 1113 3 1112 4 75 22 c132 41 225 97 326 197 75
                                75 98 106 136 182 65 129 82 213 75 377 -4 105 -10 145 -30 203 -46 133 -88
                                193 -265 378 -92 96 -2303 2340 -4914 4987 -3317 3363 -4767 4826 -4810 4855
                                -76 51 -152 86 -233 108 -85 24 -273 28 -360 10z"/>
                            </g>
                        </svg>
                </a>
                </div>
            </li>
            <?php if ($is_userBasicInfo == '1' || $is_userStudentInfo == '1') { ?>
            <li id="add-contact">
                <div class="mob-btm-icon">
                    <a target="_self" href="<?php echo base_url('contact-request') ?>">
                        <svg class="not-hover" viewBox="0 0 563.43 563.43" width="25px" height="25px">
                            <path d="M280.79,314.559c83.266,0,150.803-67.538,150.803-150.803S364.055,13.415,280.79,13.415S129.987,80.953,129.987,163.756  S197.524,314.559,280.79,314.559z M280.79,52.735c61.061,0,111.021,49.959,111.021,111.021S341.851,274.776,280.79,274.776  s-111.021-49.959-111.021-111.021S219.728,52.735,280.79,52.735z" />
                            <path d="M19.891,550.015h523.648c11.102,0,19.891-8.789,19.891-19.891c0-104.082-84.653-189.198-189.198-189.198H189.198  C85.116,340.926,0,425.579,0,530.124C0,541.226,8.789,550.015,19.891,550.015z M189.198,380.708h185.034  c75.864,0,138.313,56.436,148.028,129.524H41.17C50.884,437.607,113.334,380.708,189.198,380.708z" />
                        </svg>
                        <svg class="on-hover" width="25px" height="25px" viewBox="0 0 2133.000000 2133.000000">
                            <g transform="translate(0.000000,2133.000000) scale(0.100000,-0.100000)">
                                <path d="M10323 20820 c-1257 -72 -2405 -526 -3378 -1336 -167 -139 -540 -511
                                -682 -680 -673 -802 -1102 -1730 -1272 -2749 -51 -304 -71 -570 -71 -924 0
                                -375 25 -671 85 -1006 234 -1309 935 -2517 1955 -3369 930 -778 2019 -1224
                                3227 -1322 248 -20 799 -15 1023 10 716 80 1318 253 1935 556 1160 569 2070
                                1485 2635 2652 288 595 461 1209 537 1908 23 208 26 877 5 1090 -74 757 -276
                                1448 -611 2096 -848 1637 -2446 2769 -4266 3024 -340 47 -803 68 -1122 50z"/>
                                <path d="M6875 8423 c-866 -43 -1609 -201 -2368 -505 -1768 -707 -3198 -2105
                                -3942 -3852 -373 -877 -577 -1871 -563 -2741 3 -221 5 -233 31 -310 95 -273
                                328 -465 613 -505 106 -14 19932 -14 20038 0 285 40 518 232 613 505 26 77 28
                                89 31 310 12 754 -148 1646 -434 2413 -368 988 -931 1862 -1674 2602 -1134
                                1129 -2599 1843 -4174 2035 -421 52 -176 49 -4291 50 -2101 1 -3847 0 -3880
                                -2z"/>
                            </g>
                        </svg>
                        <span class="noti-box">1</span>
                    </a>
                </div>
            </li>
            <li class="dropdown">
                <div class="mob-btm-icon">
                    <a href="#" class="">
                        <svg class="not-hover" width="25px" height="25px" viewBox="0 0 2133.000000 2133.000000">
                            <g transform="translate(0.000000,2133.000000) scale(0.100000,-0.100000)">
                                <path d="M1660 18783 c-94 -10 -265 -48 -373 -83 -271 -90 -508 -233 -716
                                -434 -278 -270 -456 -591 -539 -975 l-27 -126 0 -6500 0 -6500 27 -126 c83
                                -382 260 -703 535 -970 111 -107 164 -150 283 -229 192 -126 434 -224 671
                                -272 l114 -23 9030 0 9030 0 114 23 c388 79 725 262 996 543 234 242 385 511
                                470 832 60 228 56 -298 53 6772 l-3 6460 -27 121 c-113 503 -396 916 -818
                                1194 -188 123 -427 221 -666 272 l-109 23 -9005 1 c-4953 0 -9021 -1 -9040 -3z
                                m13280 -5488 l-4235 -4235 -105 104 c-229 225 -7176 7111 -7787 7718 l-652
                                648 8507 0 8507 0 -4235 -4235z m-9145 -1150 c1920 -1902 3720 -3686 4000
                                -3965 281 -279 524 -517 542 -528 110 -76 229 -112 370 -112 117 0 191 17 293
                                67 74 36 156 117 4578 4537 l4502 4501 0 -5985 c0 -5796 -1 -5988 -19 -6075
                                -41 -199 -120 -344 -271 -495 -151 -151 -296 -230 -495 -271 -87 -18 -343 -19
                                -8630 -19 -8287 0 -8543 1 -8630 19 -199 41 -344 120 -495 271 -151 151 -230
                                296 -271 495 -18 87 -19 279 -19 6080 l0 5990 528 -526 c290 -289 2097 -2082
                                4017 -3984z"/>
                            </g>
                        </svg>
                        <svg class="on-hover" width="25" height="25" viewBox="0 0 2133.000000 2133.000000">
                            <g transform="translate(0.000000,2133.000000) scale(0.100000,-0.100000)">
                                <path d="M1660 18783 c-150 -16 -402 -84 -539 -145 l-53 -24 1423 -1416 c783
                                -779 2952 -2931 4819 -4782 l3395 -3365 4778 4777 c2627 2627 4777 4780 4777
                                4783 0 9 -190 83 -279 109 -40 12 -117 31 -170 43 l-96 21 -9010 2 c-4955 0
                                -9026 -1 -9045 -3z"/>
                                <path d="M132 17618 c-54 -138 -77 -217 -104 -351 l-23 -112 0 -6495 0 -6495
                                27 -126 c83 -382 260 -703 535 -970 111 -107 164 -150 283 -229 192 -126 434
                                -224 671 -272 l114 -23 9030 0 9030 0 114 23 c388 79 725 262 996 543 234 242
                                385 511 470 832 60 228 56 -298 53 6772 l-3 6460 -27 121 c-27 120 -77 276
                                -121 376 l-23 53 -4965 -4969 c-2730 -2732 -5002 -5002 -5049 -5044 -136 -120
                                -267 -172 -435 -172 -108 0 -184 18 -285 67 -89 43 135 -175 -2284 2223 -4484
                                4444 -6484 6425 -7193 7128 l-771 762 -40 -102z"/>
                            </g>
                        </svg>
                        <span class="noti-box">1</span>
                    </a>
                </div>
            </li>
            <li class="dropdown">
                <div class="mob-btm-icon">
                    <a href="#" class="">
                        <svg class="not-hover" viewBox="0 0 512 512" width="25px" height="25px">
                            <path   d="M256,0c-37.554,0-68.11,30.556-68.11,68.11v20.55h35.229V68.11c0-18.131,14.755-32.881,32.881-32.881    c18.131,0,32.887,14.749,32.887,32.881v20.55h35.229V68.11C324.116,30.556,293.555,0,256,0z" />
                            <path  d="M304.147,429.205c0,26.228-21.337,47.565-47.56,47.565h-1.174c-26.222,0-47.56-21.337-47.56-47.565h-35.229    c0,45.657,37.138,82.795,82.789,82.795h1.174c45.651,0,82.789-37.138,82.789-82.795H304.147z" />
                            <path  d="M483.952,422.623l-50.043-77.851v-99.928c0-99.071-79.812-179.67-177.908-179.67c-98.102,0-177.908,80.599-177.908,179.67    v99.928l-50.043,77.845c-3.488,5.419-3.734,12.313-0.646,17.967c3.088,5.654,9.013,9.177,15.46,9.177h426.275    c6.447,0,12.371-3.523,15.454-9.171C487.686,434.936,487.44,428.043,483.952,422.623z M75.127,414.532l35.394-55.063    c1.826-2.836,2.801-6.148,2.801-9.524V244.844c0-79.642,64.006-144.44,142.679-144.44c78.679,0,142.679,64.799,142.679,144.44    v105.101c0,3.376,0.969,6.682,2.795,9.524l35.394,55.063H75.127z" />
                        </svg>
                        <svg class="on-hover" width="25px" height="25px" viewBox="0 0 2133.000000 2133.000000">
                            <g transform="translate(0.000000,2133.000000) scale(0.100000,-0.100000)">
                                <path d="M10355 21319 c-514 -59 -986 -247 -1403 -558 -153 -114 -423 -380
                                -533 -526 -328 -432 -517 -895 -580 -1420 -6 -55 -14 -250 -18 -433 l-6 -333
                                -180 -82 c-2432 -1110 -4091 -3432 -4350 -6087 -33 -339 -35 -508 -35 -2700
                                l0 -2206 -1051 -1634 c-579 -899 -1066 -1666 -1084 -1705 -51 -108 -68 -205
                                -63 -343 4 -92 11 -134 32 -197 76 -224 244 -392 471 -472 l80 -28 2830 -5
                                2829 -5 10 -35 c28 -108 122 -375 171 -486 442 -1004 1333 -1741 2400 -1983
                                291 -67 383 -75 790 -75 408 0 499 8 795 76 975 221 1810 863 2287 1758 101
                                188 226 506 279 710 l10 35 2829 5 2830 5 80 28 c227 80 395 248 471 472 54
                                159 43 378 -27 533 -15 34 -502 799 -1081 1700 l-1053 1637 -5 2315 c-6 2507
                                -4 2381 -60 2820 -335 2580 -1964 4790 -4325 5867 l-180 82 -6 343 c-7 361
                                -18 478 -65 699 -86 409 -262 787 -533 1144 -110 146 -380 412 -533 526 -421
                                315 -891 500 -1413 559 -104 11 -507 11 -610 -1z"/>
                            </g>
                        </svg>
                        <span class="noti-box">1</span>
                    </a>
                </div>
            </li>
            <li>
                <button class="bg-menu" id="showRight">
                    <svg viewBox="0 0 53 53" width="25px" height="25px">
                            <path d="M2,13.5h49c1.104,0,2-0.896,2-2s-0.896-2-2-2H2c-1.104,0-2,0.896-2,2S0.896,13.5,2,13.5z" />
                            <path d="M2,28.5h49c1.104,0,2-0.896,2-2s-0.896-2-2-2H2c-1.104,0-2,0.896-2,2S0.896,28.5,2,28.5z" />
                            <path d="M2,43.5h49c1.104,0,2-0.896,2-2s-0.896-2-2-2H2c-1.104,0-2,0.896-2,2S0.896,43.5,2,43.5z" />
                        
                    </svg>

                </button>
            </li>
            <?php } ?>
        </ul>
    </div>
    <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right mob-side-menu" id="cbp-spmenu-s2">
        <div class="all-profile-box content custom-scroll">
            <ul class="all-pr-list">
                <li><a target="_self" href="<?php echo $job_right_profile_link; ?>">Job Profile</a></li>
                <li><a target="_self" href="<?php echo $recruiter_right_profile_link; ?>">Recruiter Profile</a></li>
                <li><a target="_self" href="<?php echo $freelance_right_profile_link; ?>">Freelance Profile</a></li>
                <li><a target="_self" href="<?php echo $business_right_profile_link; ?>">Business Profile</a></li>
                <li><a target="_self" href="<?php echo $artist_right_profile_link; ?>">Artistic Profile</a></li>
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
</div>
<link rel="stylesheet" href="<?php echo base_url('assets/n-css/component.css') ?>" />
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
        $("#mob_search").keypress(function(event) {
            if (event.which == 13) {
                event.preventDefault();
                $("#mobile_ser_frm").submit();
            }
        });
    });

   function Notificationheader() {
        getNotification();
        notheader();

    }
    function getNotification() {
        // first click alert('here'); 

        $.ajax({
            url: "<?php echo base_url(); ?>notification/update_notification",
            type: "POST",
            //data: {uid: 12341234}, //this sends the user-id to php as a post variable, in php it can be accessed as $_POST['uid']
            success: function (data) {
                data = JSON.parse(data);
                //alert(data);
                //update some fields with the updated data
                //you can access the data like 'data["driver"]'
            }
        });

    }

    function notheader()
    {
        // $("#fad" + clicked_id).fadeOut(6000);
        $("#not_loader").show();

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . "notification/not_header" ?>',
            dataType: 'json',
            data: '',
            success: function (data) {
                $("#not_loader").hide();
                $('.' + 'notification_data_in').html(data.notification);
                $('#seenot').html(data.seeall);
               
            }
        });
    }

    function get_notification_unread_count()
    {
        var url = '<?php echo base_url() . "notification/get_notification_unread_count" ?>';
        $.get(url, function(data, status){
            $("#noti_count").show();
            if(parseInt(data) > 0)
            {
                $("#noti_count").html(data);
            }
            else
            {
                $("#noti_count").hide();
                $("#noti_count").html("");
            }
        });
        /*$.ajax({
            type: 'POST',
            url: '<?php //echo base_url() . "notification/get_notification_unread_count" ?>',
            dataType: 'json',
            data: '',
            success: function (data) {
                // console.log(data);
                $("#noti_count").show();
                if(parseInt(data) > 0)
                {
                    $("#noti_count").html(data);
                }
                else
                {
                    $("#noti_count").hide();
                    $("#noti_count").html("");
                }
            }
        });*/
    }
    window.setInterval(function(){
      get_notification_unread_count();
    }, 5000);
  </script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<script>
        var app = angular.module('headerApp', []);
</script>     
<script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js') ?>"></script>
<script src="<?php echo base_url('assets/js/classie.js') ?>"></script>
