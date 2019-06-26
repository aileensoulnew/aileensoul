<link rel="stylesheet" href="<?php echo base_url('assets/n-css/component.css') ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/header.css?ver=' . time()); ?>">
<?php
$session_user = $this->session->userdata();
$userData = $this->user_model->getUserData($session_user['aileenuser']);
$msg_user_data = $this->user_model->get_user_for_message($session_user['aileenuser']);
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
$first_segment = $this->uri->segment(1);
if($first_segment == "")
{
    if($userData['user_verify'] == 0):
?>
    <div class="profile-text1 animated fadeInDownBig" id="verifydiv" style="top: 44px;float: left;width: 100%;position: fixed;z-index: 9;">
        <div class="verify">
            <div class="email-verify">
                <span class="email-img"><img src="<?php echo base_url(); ?>assets/images/email.png" alt="Email"></span>
                <span class="main-txt">
                    <span class="as-p"><?php if($userData['is_new'] == 1){
                        echo "Please verify your email address! Check your inbox or spam folder in order to verify yourself.";
                    } ?> 
                    </span>
                    <?php
                    if($userData['is_new'] == 0){ ?>
                    <span class="ves_c">
                        Please Click on the Button to Verify Your Email Address.
                        <span class="fw-50"> <a class="vert_email " onclick="sendmail();" id="vert_email">Verify</a></span>
                    </span>
                <?php } ?>
                </span>
            </div>
        </div>
    </div>
<?php endif;
} ?>

<div class="web-header">
    <header class="custom-header" ng-controller="headerCtrl" ng-app="headerApp">
    <div class="animated fadeInDownBig">
        <div class="container">
            <div class="row">

                <div class="col-md-6 col-sm-6 left-header">
                    <?php
                    $this->load->view('main_logo');
                    $first_segment = $this->uri->segment(1);
                    if (($is_userBasicInfo == '1' || $is_userStudentInfo == '1') && ($first_segment != 'business-search' && $first_segment != 'business-profile')) { ?>
                        <form ng-submit="search_submit" action="<?php echo base_url('search') ?>">
                            <input type="text" name="q" placeholder="Search.." id="search">
                        </form>
                    <?php } ?>
                </div>
                <div class="col-md-6 col-sm-6 right-header">
                    <ul>
                        <?php if ($is_userBasicInfo == '1' || $is_userStudentInfo == '1') { ?>
                            
                            <li>
                                <a ng-href="<?php echo base_url() ?>" title="Opportunity" target="_self">
									<svg x="0px" y="0px" width="24px" height="24px" viewBox="0 0 510 510">
									<g>
										<g id="home">
											<polygon points="204,471.75 204,318.75 306,318.75 306,471.75 433.5,471.75 433.5,267.75 510,267.75 255,38.25 0,267.75     76.5,267.75 76.5,471.75   " fill="#d7ecf5"/>
										</g>
									</g>
									</svg>
								</a>
                            </li>
							<li class="dropdown">
                                <a href="<?php echo MESSAGE_URL.'user'; ?>" title="Messages" class="dropdown-toggle">
									<svg x="0px" y="0px" width="24px" height="24px" viewBox="0 0 30.743 30.744">
                                        <g>
                                        	<path d="M28.585,9.67h-0.842v9.255c0,1.441-0.839,2.744-2.521,2.744H8.743v0.44c0,1.274,1.449,2.56,2.937,2.56h12.599l4.82,2.834
                                        		L28.4,24.669h0.185c1.487,0,2.158-1.283,2.158-2.56V11.867C30.743,10.593,30.072,9.67,28.585,9.67z"/>
                                        	<path d="M22.762,3.24H3.622C1.938,3.24,0,4.736,0,6.178v11.6c0,1.328,1.642,2.287,3.217,2.435l-1.025,3.891L8.76,20.24h14.002
                                        		c1.684,0,3.238-1.021,3.238-2.462V8.393V6.178C26,4.736,24.445,3.24,22.762,3.24z M6.542,13.032c-0.955,0-1.729-0.774-1.729-1.729
                                        		s0.774-1.729,1.729-1.729c0.954,0,1.729,0.774,1.729,1.729S7.496,13.032,6.542,13.032z M13,13.032
                                        		c-0.955,0-1.729-0.774-1.729-1.729S12.045,9.574,13,9.574s1.729,0.774,1.729,1.729S13.955,13.032,13,13.032z M19.459,13.032
                                        		c-0.955,0-1.73-0.774-1.73-1.729s0.775-1.729,1.73-1.729c0.953,0,1.729,0.774,1.729,1.729S20.412,13.032,19.459,13.032z"/>
                                        </g>
                                    </svg>
                                    <span class="noti-box msg-count" style="display:none;"></span>
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
                            <li id="add-contact" class="dropdown">
                                <a href="javascript:void(0);" title="Contact Request" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" ng-click="header_contact_request()">
									<svg x="0px" y="0px" viewBox="0 0 55 55" width="24px" height="24px">
									<path d="M55,27.5C55,12.337,42.663,0,27.5,0S0,12.337,0,27.5c0,8.009,3.444,15.228,8.926,20.258l-0.026,0.023l0.892,0.752  c0.058,0.049,0.121,0.089,0.179,0.137c0.474,0.393,0.965,0.766,1.465,1.127c0.162,0.117,0.324,0.234,0.489,0.348  c0.534,0.368,1.082,0.717,1.642,1.048c0.122,0.072,0.245,0.142,0.368,0.212c0.613,0.349,1.239,0.678,1.88,0.98  c0.047,0.022,0.095,0.042,0.142,0.064c2.089,0.971,4.319,1.684,6.651,2.105c0.061,0.011,0.122,0.022,0.184,0.033  c0.724,0.125,1.456,0.225,2.197,0.292c0.09,0.008,0.18,0.013,0.271,0.021C25.998,54.961,26.744,55,27.5,55  c0.749,0,1.488-0.039,2.222-0.098c0.093-0.008,0.186-0.013,0.279-0.021c0.735-0.067,1.461-0.164,2.178-0.287  c0.062-0.011,0.125-0.022,0.187-0.034c2.297-0.412,4.495-1.109,6.557-2.055c0.076-0.035,0.153-0.068,0.229-0.104  c0.617-0.29,1.22-0.603,1.811-0.936c0.147-0.083,0.293-0.167,0.439-0.253c0.538-0.317,1.067-0.648,1.581-1  c0.185-0.126,0.366-0.259,0.549-0.391c0.439-0.316,0.87-0.642,1.289-0.983c0.093-0.075,0.193-0.14,0.284-0.217l0.915-0.764  l-0.027-0.023C51.523,42.802,55,35.55,55,27.5z M2,27.5C2,13.439,13.439,2,27.5,2S53,13.439,53,27.5  c0,7.577-3.325,14.389-8.589,19.063c-0.294-0.203-0.59-0.385-0.893-0.537l-8.467-4.233c-0.76-0.38-1.232-1.144-1.232-1.993v-2.957  c0.196-0.242,0.403-0.516,0.617-0.817c1.096-1.548,1.975-3.27,2.616-5.123c1.267-0.602,2.085-1.864,2.085-3.289v-3.545  c0-0.867-0.318-1.708-0.887-2.369v-4.667c0.052-0.52,0.236-3.448-1.883-5.864C34.524,9.065,31.541,8,27.5,8  s-7.024,1.065-8.867,3.168c-2.119,2.416-1.935,5.346-1.883,5.864v4.667c-0.568,0.661-0.887,1.502-0.887,2.369v3.545  c0,1.101,0.494,2.128,1.34,2.821c0.81,3.173,2.477,5.575,3.093,6.389v2.894c0,0.816-0.445,1.566-1.162,1.958l-7.907,4.313  c-0.252,0.137-0.502,0.297-0.752,0.476C5.276,41.792,2,35.022,2,27.5z" fill="#d7ecf5"/>

									</svg>

                                    <span class="noti-box con_req_cnt" style="display:none;" ng-bind="contact_request_count" ng-if="contact_request_count != '0'"></span>
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
                                                                <div class="msg-discription" ng-bind="contact_request.designation | capitalize" ng-if="contact_request.designation != null && contact_request.degree == null"></div>
                                                                <div class="msg-discription" ng-bind="contact_request.degree | capitalize" ng-if="contact_request.degree != null && contact_request.designation == null"></div>
                                                                <div class="msg-discription" ng-if="contact_request.designation == null && contact_request.degree == null">Current Work</div>
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
                            
                            <li class="dropdown" style="display: block;">
                                <a href="javascript:void(0);" title="Notification" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" onclick = "return Notificationheader();">
									
								<svg x="0px" y="0px" width="24px" height="24px" viewBox="0 0 510 510">
								<g>
									<g id="notifications">
										<path d="M255,510c28.05,0,51-22.95,51-51H204C204,487.05,226.95,510,255,510z M420.75,357V216.75    c0-79.05-53.55-142.8-127.5-160.65V38.25C293.25,17.85,275.4,0,255,0c-20.4,0-38.25,17.85-38.25,38.25V56.1    c-73.95,17.85-127.5,81.6-127.5,160.65V357l-51,51v25.5h433.5V408L420.75,357z" fill="#d7ecf5"/>
									</g>
								</g>

								</svg>

                                    <span id="noti_count" class="noti-box noti_count" style="display: none;"></span>
                                </a>

                                <div class="dropdown-menu">
                                    <div class="dropdown-title">
                                        Notifications <span id="seenot" class="pull-right">See All</span>
                                    </div>
                                    <div class="fw" id="not_loader"  style="display:none; text-align:center;position:  absolute;top: 50%;z-index: 9;">
                                        <img src="<?php echo base_url('assets/images/loader.gif') ?>" alt="<?php echo 'LOADERIMAGE'; ?>"/>
                                    </div>
                                    <div class="content custom-scroll">
                                        <ul class="notification_data_in">
                                        </ul>
                                    </div>                                    
                                </div>
                            </li>                       
                        
                        <li class="dropdown user-id">
                            <label title="<?php echo $session_user['aileenuser_firstname']; ?>" class="dropdown-toggle user-id-custom" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <?php
                                    if ($userData['user_image'] != '')
                                    {?>
                                        <span class="usr-img profile-brd" id="header-main-profile-pic">
                                            <img src="<?php echo USER_THUMB_UPLOAD_URL . $userData['user_image'] ?>" alt="<?php echo $userData['first_name'] ?>">
                                        </span>
                                    <?php
                                    }
                                    else
                                    {?>                                        
                                        <span class="usr-img" id="header-main-profile-pic">
                                    <?php
                                            if($userData['user_gender'] == "M")
                                            {?>
                                                <img src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                            <?php
                                            }
                                            if($userData['user_gender'] == "F")
                                            {
                                            ?>
                                                <img src="<?php echo base_url('assets/img/female-user.jpg') ?>">
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
                                <li><a ng-href="<?php echo base_url().$this->session->userdata('aileenuser_slug'); ?>" href="<?php echo base_url().$this->session->userdata('aileenuser_slug'); ?>" title="View Profile">
									<svg x="0px" y="0px" viewBox="0 0 512 512" width="15px" height="15px">
                                        <g>
                                        	<g>
                                        		<path d="M437.02,330.98c-27.883-27.882-61.071-48.523-97.281-61.018C378.521,243.251,404,198.548,404,148
                                        			C404,66.393,337.607,0,256,0S108,66.393,108,148c0,50.548,25.479,95.251,64.262,121.962
                                        			c-36.21,12.495-69.398,33.136-97.281,61.018C26.629,379.333,0,443.62,0,512h40c0-119.103,96.897-216,216-216s216,96.897,216,216
                                        			h40C512,443.62,485.371,379.333,437.02,330.98z M256,256c-59.551,0-108-48.448-108-108S196.449,40,256,40
                                        			c59.551,0,108,48.448,108,108S315.551,256,256,256z"/>
                                        	</g>
                                        </g>

                                        </svg>
									<span>View Profile</span></a>
								</li>
                                <li>
                                    <a href="<?php echo $this->business_profile_link; ?>">
                                        <svg x="0px" y="0px" viewBox="0 0 512 512" width="15px" height="15px">
                                        <g>
                                        	<g>
                                        		<path d="M469.333,106.667H362.667V85.333c0-23.531-19.135-42.667-42.667-42.667H192c-23.531,0-42.667,19.135-42.667,42.667v21.333
                                        			H42.667C19.135,106.667,0,125.802,0,149.333v277.333c0,23.531,19.135,42.667,42.667,42.667h426.667
                                        			c23.531,0,42.667-19.135,42.667-42.667V149.333C512,125.802,492.865,106.667,469.333,106.667z M170.667,85.333
                                        			C170.667,73.573,180.24,64,192,64h128c11.76,0,21.333,9.573,21.333,21.333v21.333H170.667V85.333z M490.667,426.667
                                        			c0,11.76-9.573,21.333-21.333,21.333H42.667c-11.76,0-21.333-9.573-21.333-21.333V271.4c6.301,3.674,13.527,5.934,21.333,5.934
                                        			h170.667v32c0,5.896,4.771,10.667,10.667,10.667h64c5.896,0,10.667-4.771,10.667-10.667v-32h170.667
                                        			c7.806,0,15.033-2.259,21.333-5.934V426.667z M234.667,298.667V256h42.667v42.667H234.667z M490.667,234.667
                                        			c0,11.76-9.573,21.333-21.333,21.333H298.667v-10.667c0-5.896-4.771-10.667-10.667-10.667h-64
                                        			c-5.896,0-10.667,4.771-10.667,10.667V256H42.667c-11.76,0-21.333-9.573-21.333-21.333v-85.333
                                        			c0-11.76,9.573-21.333,21.333-21.333h426.667c11.76,0,21.333,9.573,21.333,21.333V234.667z"/>
                                        	</g>
                                        </g>

                                        </svg>

                                        <span>Business Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('monetize-aileensoul-account') ?>" title="Monetization" target="_self">
                                        <i class="fa fa-money"></i>
                                        <span>Monetization</span>
                                    </a>
                                </li>
                                <li><a href="<?php echo base_url('edit-profile') ?>" title="Setting" target="_self">
									
                                        <svg x="0px" y="0px" viewBox="0 0 478.703 478.703" width="15px" height="15px">
                                        <g>
                                        	<g>
                                        		<path d="M454.2,189.101l-33.6-5.7c-3.5-11.3-8-22.2-13.5-32.6l19.8-27.7c8.4-11.8,7.1-27.9-3.2-38.1l-29.8-29.8
                                        			c-5.6-5.6-13-8.7-20.9-8.7c-6.2,0-12.1,1.9-17.1,5.5l-27.8,19.8c-10.8-5.7-22.1-10.4-33.8-13.9l-5.6-33.2
                                        			c-2.4-14.3-14.7-24.7-29.2-24.7h-42.1c-14.5,0-26.8,10.4-29.2,24.7l-5.8,34c-11.2,3.5-22.1,8.1-32.5,13.7l-27.5-19.8
                                        			c-5-3.6-11-5.5-17.2-5.5c-7.9,0-15.4,3.1-20.9,8.7l-29.9,29.8c-10.2,10.2-11.6,26.3-3.2,38.1l20,28.1
                                        			c-5.5,10.5-9.9,21.4-13.3,32.7l-33.2,5.6c-14.3,2.4-24.7,14.7-24.7,29.2v42.1c0,14.5,10.4,26.8,24.7,29.2l34,5.8
                                        			c3.5,11.2,8.1,22.1,13.7,32.5l-19.7,27.4c-8.4,11.8-7.1,27.9,3.2,38.1l29.8,29.8c5.6,5.6,13,8.7,20.9,8.7c6.2,0,12.1-1.9,17.1-5.5
                                        			l28.1-20c10.1,5.3,20.7,9.6,31.6,13l5.6,33.6c2.4,14.3,14.7,24.7,29.2,24.7h42.2c14.5,0,26.8-10.4,29.2-24.7l5.7-33.6
                                        			c11.3-3.5,22.2-8,32.6-13.5l27.7,19.8c5,3.6,11,5.5,17.2,5.5l0,0c7.9,0,15.3-3.1,20.9-8.7l29.8-29.8c10.2-10.2,11.6-26.3,3.2-38.1
                                        			l-19.8-27.8c5.5-10.5,10.1-21.4,13.5-32.6l33.6-5.6c14.3-2.4,24.7-14.7,24.7-29.2v-42.1
                                        			C478.9,203.801,468.5,191.501,454.2,189.101z M451.9,260.401c0,1.3-0.9,2.4-2.2,2.6l-42,7c-5.3,0.9-9.5,4.8-10.8,9.9
                                        			c-3.8,14.7-9.6,28.8-17.4,41.9c-2.7,4.6-2.5,10.3,0.6,14.7l24.7,34.8c0.7,1,0.6,2.5-0.3,3.4l-29.8,29.8c-0.7,0.7-1.4,0.8-1.9,0.8
                                        			c-0.6,0-1.1-0.2-1.5-0.5l-34.7-24.7c-4.3-3.1-10.1-3.3-14.7-0.6c-13.1,7.8-27.2,13.6-41.9,17.4c-5.2,1.3-9.1,5.6-9.9,10.8l-7.1,42
                                        			c-0.2,1.3-1.3,2.2-2.6,2.2h-42.1c-1.3,0-2.4-0.9-2.6-2.2l-7-42c-0.9-5.3-4.8-9.5-9.9-10.8c-14.3-3.7-28.1-9.4-41-16.8
                                        			c-2.1-1.2-4.5-1.8-6.8-1.8c-2.7,0-5.5,0.8-7.8,2.5l-35,24.9c-0.5,0.3-1,0.5-1.5,0.5c-0.4,0-1.2-0.1-1.9-0.8l-29.8-29.8
                                        			c-0.9-0.9-1-2.3-0.3-3.4l24.6-34.5c3.1-4.4,3.3-10.2,0.6-14.8c-7.8-13-13.8-27.1-17.6-41.8c-1.4-5.1-5.6-9-10.8-9.9l-42.3-7.2
                                        			c-1.3-0.2-2.2-1.3-2.2-2.6v-42.1c0-1.3,0.9-2.4,2.2-2.6l41.7-7c5.3-0.9,9.6-4.8,10.9-10c3.7-14.7,9.4-28.9,17.1-42
                                        			c2.7-4.6,2.4-10.3-0.7-14.6l-24.9-35c-0.7-1-0.6-2.5,0.3-3.4l29.8-29.8c0.7-0.7,1.4-0.8,1.9-0.8c0.6,0,1.1,0.2,1.5,0.5l34.5,24.6
                                        			c4.4,3.1,10.2,3.3,14.8,0.6c13-7.8,27.1-13.8,41.8-17.6c5.1-1.4,9-5.6,9.9-10.8l7.2-42.3c0.2-1.3,1.3-2.2,2.6-2.2h42.1
                                        			c1.3,0,2.4,0.9,2.6,2.2l7,41.7c0.9,5.3,4.8,9.6,10,10.9c15.1,3.8,29.5,9.7,42.9,17.6c4.6,2.7,10.3,2.5,14.7-0.6l34.5-24.8
                                        			c0.5-0.3,1-0.5,1.5-0.5c0.4,0,1.2,0.1,1.9,0.8l29.8,29.8c0.9,0.9,1,2.3,0.3,3.4l-24.7,34.7c-3.1,4.3-3.3,10.1-0.6,14.7
                                        			c7.8,13.1,13.6,27.2,17.4,41.9c1.3,5.2,5.6,9.1,10.8,9.9l42,7.1c1.3,0.2,2.2,1.3,2.2,2.6v42.1H451.9z"/>
                                        		<path d="M239.4,136.001c-57,0-103.3,46.3-103.3,103.3s46.3,103.3,103.3,103.3s103.3-46.3,103.3-103.3S296.4,136.001,239.4,136.001
                                        			z M239.4,315.601c-42.1,0-76.3-34.2-76.3-76.3s34.2-76.3,76.3-76.3s76.3,34.2,76.3,76.3S281.5,315.601,239.4,315.601z"/>
                                        	</g>
                                        </g>

                                        </svg>


									<span>Setting</span></a>
								</li>
                                <li><a href="<?php echo base_url('logout') ?>" title="Logout">

                                        <svg x="0px" y="0px" viewBox="0 0 511.996 511.996" width="15px" height="15px">
                                        <g>
                                        	<g>
                                        		<g>
                                        			<path d="M349.85,62.196c-10.797-4.717-23.373,0.212-28.09,11.009c-4.717,10.797,0.212,23.373,11.009,28.09
                                        				c69.412,30.324,115.228,98.977,115.228,176.035c0,106.034-85.972,192-192,192c-106.042,0-192-85.958-192-192
                                        				c0-77.041,45.8-145.694,115.192-176.038c10.795-4.72,15.72-17.298,10.999-28.093c-4.72-10.795-17.298-15.72-28.093-10.999
                                        				C77.306,99.275,21.331,183.181,21.331,277.329c0,129.606,105.061,234.667,234.667,234.667
                                        				c129.592,0,234.667-105.068,234.667-234.667C490.665,183.159,434.667,99.249,349.85,62.196z"/>
                                        			<path d="M255.989,234.667c11.782,0,21.333-9.551,21.333-21.333v-192C277.323,9.551,267.771,0,255.989,0
                                        				c-11.782,0-21.333,9.551-21.333,21.333v192C234.656,225.115,244.207,234.667,255.989,234.667z"/>
                                        		</g>
                                        	</g>
                                        </g>

                                        </svg>




									<span>Logout</span></a>
								</li>
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
                    <h2 class="logo"><a target="_self" href="<?php echo base_url(); ?>"><img src="<?php echo base_url('assets/n-images/mob-logo.png') ?>"></a></h2>
                    <?php if ($is_userBasicInfo == '1' || $is_userStudentInfo == '1') { ?>
                    <div class="search-mob-block">
                        <div class="">
                            <?php 
                            $first_segment = $this->uri->segment(1);
                            $no_ser_arr = array("freelancer","business","business-search");
                            if(!in_array($first_segment, $no_ser_arr)): ?>
                            <form ng-submit="search_submit" id="mobile_ser_frm" name="mobile_ser_frm" action="<?php echo base_url('search') ?>">
                                <input type="text" name="q" placeholder="Search.." id="mob_search">
                            </form>
                            <?php
                            endif; /*else: ?>
                            <a href="#search">
                                <input type="search" id="tags1" class="tags" name="skills" value="" placeholder="Job Title,Skill,Company" />
                            </a>
                        <?php *///endif; ?>
                        </div>
                        <!-- <div class="mob-search-btn">
                            <a data-toggle="modal" href="#" id="showBottom">
                                <span><img src="<?php //echo base_url('assets/n-images/filter.png'); ?>"></span> 
                            </a>
                        </div> -->
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
                                            <img src="<?php echo USER_THUMB_UPLOAD_URL . $userData['user_image'] ?>" alt="<?php echo $userData['first_name'] ?>">
                                            </span>
                                        <?php
                                        }
                                        else
                                        { ?>
                                            <span class="usr-img">
                                            <?php
                                            if($userData['user_gender'] == "M")
                                            {?>
                                                <img src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                            <?php
                                            }
                                            if($userData['user_gender'] == "F")
                                            {
                                            ?>
                                                <img src="<?php echo base_url('assets/img/female-user.jpg') ?>">
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
                                    <li><a target="_self" href="<?php echo base_url().$this->session->userdata('aileenuser_slug'); ?>" title="View Profile">
										
<svg x="0px" y="0px" viewBox="0 0 512 512" width="15px" height="15px">
<g>
	<g>
		<path d="M437.02,330.98c-27.883-27.882-61.071-48.523-97.281-61.018C378.521,243.251,404,198.548,404,148
			C404,66.393,337.607,0,256,0S108,66.393,108,148c0,50.548,25.479,95.251,64.262,121.962
			c-36.21,12.495-69.398,33.136-97.281,61.018C26.629,379.333,0,443.62,0,512h40c0-119.103,96.897-216,216-216s216,96.897,216,216
			h40C512,443.62,485.371,379.333,437.02,330.98z M256,256c-59.551,0-108-48.448-108-108S196.449,40,256,40
			c59.551,0,108,48.448,108,108S315.551,256,256,256z"/>
	</g>
</g>

</svg>

									<span>View Profile</span></a>
									</li>
									<li>
                                    <a href="<?php echo $this->business_profile_link; ?>">
<svg x="0px" y="0px" viewBox="0 0 512 512" width="15px" height="15px">
<g>
	<g>
		<path d="M469.333,106.667H362.667V85.333c0-23.531-19.135-42.667-42.667-42.667H192c-23.531,0-42.667,19.135-42.667,42.667v21.333
			H42.667C19.135,106.667,0,125.802,0,149.333v277.333c0,23.531,19.135,42.667,42.667,42.667h426.667
			c23.531,0,42.667-19.135,42.667-42.667V149.333C512,125.802,492.865,106.667,469.333,106.667z M170.667,85.333
			C170.667,73.573,180.24,64,192,64h128c11.76,0,21.333,9.573,21.333,21.333v21.333H170.667V85.333z M490.667,426.667
			c0,11.76-9.573,21.333-21.333,21.333H42.667c-11.76,0-21.333-9.573-21.333-21.333V271.4c6.301,3.674,13.527,5.934,21.333,5.934
			h170.667v32c0,5.896,4.771,10.667,10.667,10.667h64c5.896,0,10.667-4.771,10.667-10.667v-32h170.667
			c7.806,0,15.033-2.259,21.333-5.934V426.667z M234.667,298.667V256h42.667v42.667H234.667z M490.667,234.667
			c0,11.76-9.573,21.333-21.333,21.333H298.667v-10.667c0-5.896-4.771-10.667-10.667-10.667h-64
			c-5.896,0-10.667,4.771-10.667,10.667V256H42.667c-11.76,0-21.333-9.573-21.333-21.333v-85.333
			c0-11.76,9.573-21.333,21.333-21.333h426.667c11.76,0,21.333,9.573,21.333,21.333V234.667z"/>
	</g>
</g>

</svg>

                                        <span>Business Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('monetize-aileensoul-account') ?>" title="Monetization" target="_self">
                                        <i class="fa fa-money"></i>
                                        <span>Monetization</span>
                                    </a>
                                </li>
                                    <li><a target="_self" href="<?php echo base_url('edit-profile') ?>" title="Setting">
										<svg x="0px" y="0px" viewBox="0 0 478.703 478.703" width="15px" height="15px">
<g>
	<g>
		<path d="M454.2,189.101l-33.6-5.7c-3.5-11.3-8-22.2-13.5-32.6l19.8-27.7c8.4-11.8,7.1-27.9-3.2-38.1l-29.8-29.8
			c-5.6-5.6-13-8.7-20.9-8.7c-6.2,0-12.1,1.9-17.1,5.5l-27.8,19.8c-10.8-5.7-22.1-10.4-33.8-13.9l-5.6-33.2
			c-2.4-14.3-14.7-24.7-29.2-24.7h-42.1c-14.5,0-26.8,10.4-29.2,24.7l-5.8,34c-11.2,3.5-22.1,8.1-32.5,13.7l-27.5-19.8
			c-5-3.6-11-5.5-17.2-5.5c-7.9,0-15.4,3.1-20.9,8.7l-29.9,29.8c-10.2,10.2-11.6,26.3-3.2,38.1l20,28.1
			c-5.5,10.5-9.9,21.4-13.3,32.7l-33.2,5.6c-14.3,2.4-24.7,14.7-24.7,29.2v42.1c0,14.5,10.4,26.8,24.7,29.2l34,5.8
			c3.5,11.2,8.1,22.1,13.7,32.5l-19.7,27.4c-8.4,11.8-7.1,27.9,3.2,38.1l29.8,29.8c5.6,5.6,13,8.7,20.9,8.7c6.2,0,12.1-1.9,17.1-5.5
			l28.1-20c10.1,5.3,20.7,9.6,31.6,13l5.6,33.6c2.4,14.3,14.7,24.7,29.2,24.7h42.2c14.5,0,26.8-10.4,29.2-24.7l5.7-33.6
			c11.3-3.5,22.2-8,32.6-13.5l27.7,19.8c5,3.6,11,5.5,17.2,5.5l0,0c7.9,0,15.3-3.1,20.9-8.7l29.8-29.8c10.2-10.2,11.6-26.3,3.2-38.1
			l-19.8-27.8c5.5-10.5,10.1-21.4,13.5-32.6l33.6-5.6c14.3-2.4,24.7-14.7,24.7-29.2v-42.1
			C478.9,203.801,468.5,191.501,454.2,189.101z M451.9,260.401c0,1.3-0.9,2.4-2.2,2.6l-42,7c-5.3,0.9-9.5,4.8-10.8,9.9
			c-3.8,14.7-9.6,28.8-17.4,41.9c-2.7,4.6-2.5,10.3,0.6,14.7l24.7,34.8c0.7,1,0.6,2.5-0.3,3.4l-29.8,29.8c-0.7,0.7-1.4,0.8-1.9,0.8
			c-0.6,0-1.1-0.2-1.5-0.5l-34.7-24.7c-4.3-3.1-10.1-3.3-14.7-0.6c-13.1,7.8-27.2,13.6-41.9,17.4c-5.2,1.3-9.1,5.6-9.9,10.8l-7.1,42
			c-0.2,1.3-1.3,2.2-2.6,2.2h-42.1c-1.3,0-2.4-0.9-2.6-2.2l-7-42c-0.9-5.3-4.8-9.5-9.9-10.8c-14.3-3.7-28.1-9.4-41-16.8
			c-2.1-1.2-4.5-1.8-6.8-1.8c-2.7,0-5.5,0.8-7.8,2.5l-35,24.9c-0.5,0.3-1,0.5-1.5,0.5c-0.4,0-1.2-0.1-1.9-0.8l-29.8-29.8
			c-0.9-0.9-1-2.3-0.3-3.4l24.6-34.5c3.1-4.4,3.3-10.2,0.6-14.8c-7.8-13-13.8-27.1-17.6-41.8c-1.4-5.1-5.6-9-10.8-9.9l-42.3-7.2
			c-1.3-0.2-2.2-1.3-2.2-2.6v-42.1c0-1.3,0.9-2.4,2.2-2.6l41.7-7c5.3-0.9,9.6-4.8,10.9-10c3.7-14.7,9.4-28.9,17.1-42
			c2.7-4.6,2.4-10.3-0.7-14.6l-24.9-35c-0.7-1-0.6-2.5,0.3-3.4l29.8-29.8c0.7-0.7,1.4-0.8,1.9-0.8c0.6,0,1.1,0.2,1.5,0.5l34.5,24.6
			c4.4,3.1,10.2,3.3,14.8,0.6c13-7.8,27.1-13.8,41.8-17.6c5.1-1.4,9-5.6,9.9-10.8l7.2-42.3c0.2-1.3,1.3-2.2,2.6-2.2h42.1
			c1.3,0,2.4,0.9,2.6,2.2l7,41.7c0.9,5.3,4.8,9.6,10,10.9c15.1,3.8,29.5,9.7,42.9,17.6c4.6,2.7,10.3,2.5,14.7-0.6l34.5-24.8
			c0.5-0.3,1-0.5,1.5-0.5c0.4,0,1.2,0.1,1.9,0.8l29.8,29.8c0.9,0.9,1,2.3,0.3,3.4l-24.7,34.7c-3.1,4.3-3.3,10.1-0.6,14.7
			c7.8,13.1,13.6,27.2,17.4,41.9c1.3,5.2,5.6,9.1,10.8,9.9l42,7.1c1.3,0.2,2.2,1.3,2.2,2.6v42.1H451.9z"/>
		<path d="M239.4,136.001c-57,0-103.3,46.3-103.3,103.3s46.3,103.3,103.3,103.3s103.3-46.3,103.3-103.3S296.4,136.001,239.4,136.001
			z M239.4,315.601c-42.1,0-76.3-34.2-76.3-76.3s34.2-76.3,76.3-76.3s76.3,34.2,76.3,76.3S281.5,315.601,239.4,315.601z"/>
	</g>
</g>

</svg>

										<span>Setting</span></a>
									</li>
                                    <li><a target="_self" href="<?php echo base_url('logout') ?>" title="Logout">
										<svg x="0px" y="0px" viewBox="0 0 511.996 511.996" width="15px" height="15px">
<g>
	<g>
		<g>
			<path d="M349.85,62.196c-10.797-4.717-23.373,0.212-28.09,11.009c-4.717,10.797,0.212,23.373,11.009,28.09
				c69.412,30.324,115.228,98.977,115.228,176.035c0,106.034-85.972,192-192,192c-106.042,0-192-85.958-192-192
				c0-77.041,45.8-145.694,115.192-176.038c10.795-4.72,15.72-17.298,10.999-28.093c-4.72-10.795-17.298-15.72-28.093-10.999
				C77.306,99.275,21.331,183.181,21.331,277.329c0,129.606,105.061,234.667,234.667,234.667
				c129.592,0,234.667-105.068,234.667-234.667C490.665,183.159,434.667,99.249,349.85,62.196z"/>
			<path d="M255.989,234.667c11.782,0,21.333-9.551,21.333-21.333v-192C277.323,9.551,267.771,0,255.989,0
				c-11.782,0-21.333,9.551-21.333,21.333v192C234.656,225.115,244.207,234.667,255.989,234.667z"/>
		</g>
	</g>
</g>

</svg>


										<span>Logout</span></a>
									</li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <?php } ?>
                </div>
                
               
            </div>
        </div>
        
    </header>
    <?php if ($is_userBasicInfo == '1' || $is_userStudentInfo == '1') { ?>
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
                        <!-- <span class="noti-box">1</span> -->
                        <span class="noti-box con_req_cnt" style="display:none;" ng-bind="contact_request_count" ng-if="contact_request_count != '0'"></span>
                    </a>
                </div>
            </li>
            <li class="dropdown">
                <div class="mob-btm-icon">
                    <a href="<?php echo MESSAGE_URL.'user'; ?>" class="" title="message">
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
                        <span class="noti-box msg-count" style="display:none;"></span>
                    </a>
                </div>
            </li>
            <li class="dropdown">
                <div class="mob-btm-icon">
                    <a target="_self" href="<?php echo base_url('notification') ?>" class="">
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
                        <span class="noti-box noti_count" style="display: none;"></span>
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
    <?php } ?>
	<?php $this->load->view('mobile_side_slide'); ?>
</div>
<!-- Model Popup Start -->
<div class="modal fade message-box biderror" id="mailsendmodal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lm">
        <div class="modal-content message">
            <div class="modal-body">
                <span class="mes">
                    <div class="msg"></div>
                    <div class="pop_content">
                        <div class="model_ok_cancel">
                            <a class="btn1" id="okbtn" href="javascript:void(0);" data-dismiss="modal" title="OK">OK</a>
                        </div>
                    </div>
                </span>
            </div>
        </div>
    </div>
</div>
<!-- Model Popup End -->
<!-- <link rel="stylesheet" href="<?php echo base_url('assets/n-css/component.css') ?>" /> -->
<script>
    var userid = "<?php echo $session_user['aileenuser']; ?>";
    var is_verify = "<?php echo $userData['user_verify']; ?>";
    var int_not_count;

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
        if($('.notification_data_in').is(':visible') == false)
        {
            getNotification();
            notheader();
        }
    }

    function getNotification() {
        // first click alert('here'); 

        $.ajax({
            url: "<?php echo base_url(); ?>notification/update_notification",
            type: "POST",
            //data: {uid: 12341234}, //this sends the user-id to php as a post variable, in php it can be accessed as $_POST['uid']
            success: function (data) {
                data = JSON.parse(data);
                if(parseInt(data) > 0)
                {
                    $(".noti_count").html(data);
                }
                else
                {
                    $(".noti_count").hide();
                    $(".noti_count").html("");
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) { 
                setTimeout(function(){
                    getNotification();
                },500);
            }
        });

    }

    function notheader()
    {
        if($('.notification_data_in').is(':visible') == false)
        {
            $("#not_loader").show();
            $('.notification_data_in').hide();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() . "notification/not_header" ?>',
                dataType: 'json',
                data: '',
                success: function (data) {
                    $("#not_loader").hide();
                    $('.notification_data_in').show();
                    $('.notification_data_in').html(data.notification);
                    $('#seenot').html(data.seeall);
                   
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    setTimeout(function(){
                        notheader();
                    },500);
                }
            });
        }
    }    
    
    function sendmail() {
        $("#vert_email").attr("style","pointer-events: none;");
        $("#mailsendmodal .msg").html('Please verify your email address!<br />Check your inbox or spam folder in order to verify yourself.');
        $("#mailsendmodal").modal("show");
        var post_data = {
            'userid': userid,
        }
        $.ajax({
            type: 'POST',
            url: base_url + 'registration/sendmail',
            data: post_data,
            dataType:'json',
            success: function (response)
            {                
                $("#vert_email").removeAttr("style");
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) { 
                setTimeout(function(){
                    sendmail();
                },500);
            }
        });
    }
    /*if(is_verify == 0)
    {
        $('body').addClass("verify-body");
    }*/
</script>
<script src="<?php echo base_url('assets/js/angular/angular.min-1.6.4.js?ver=' . time()); ?>"></script>
<script>
    var app = angular.module('headerApp', []);
</script>
<script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js') ?>"></script>
<script src="<?php echo base_url('assets/js/classie.js') ?>"></script>
