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
<div ng-controller="headerCtrl" ng-app="headerApp">
<div class="web-header">
<header>
    <div class="animated fadeInDownBig">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6 left-header">                    
                    <?php $this->load->view('main_logo'); ?>
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
                        $job_page_array = array("job","job-search","recommended-jobs","jobs-by-companies","jobs-by-categories","jobs-by-skills","jobs-by-location","jobs-by-designations","jobs","job-profile","-job-vacancy-in-","freelance-jobs-by-fields","freelance-jobs-by-categories","recruiter","recommended-candidates","post-job","hire-freelancer","freelance-employer","freelancer","post-freelance-project","recommended-freelance-work");
                    ?>
                    <?php if (($is_userBasicInfo == '1' || $is_userStudentInfo == '1') && ($first_segment != 'business-search' && $first_segment != 'business-profile' && $first_segment != 'business' && $first_segment != 'company' && $isbusiness_segment === FALSE) && ($first_segment != 'find-artist') && ($first_segment != 'artist') && $isartist_segment === FALSE && !in_array($first_segment, $job_page_array) && ($isjobs === FALSE && $isjobs_in === FALSE && $isjob_vacancy === FALSE && $isjobs_open === FALSE )) { ?>
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
                                <a href="<?php echo MESSAGE_URL; ?>" title="Messages" class="dropdown-toggle">
									
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

                                </a>

                                <a href="<?php echo MESSAGE_URL; ?>" title="Messages" class="dropdown-toggle hide" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img ng-src="<?php echo base_url('assets/n-images/message.png?ver=' . time()) ?>" alt="Messages">
                                    <span class="noti-box" style="display:none;">1</span>
                                </a>
                                <div class="dropdown-menu hide">
                                    <div class="dropdown-title">
                                        Messages <a href="#" target="_self" class="pull-right">See All</a>
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
                                <a href="javascript:void(0);" title="Contact Request" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" ng-click="header_contact_request()">
									<svg x="0px" y="0px" viewBox="0 0 55 55" width="24px" height="24px">
									<path d="M55,27.5C55,12.337,42.663,0,27.5,0S0,12.337,0,27.5c0,8.009,3.444,15.228,8.926,20.258l-0.026,0.023l0.892,0.752  c0.058,0.049,0.121,0.089,0.179,0.137c0.474,0.393,0.965,0.766,1.465,1.127c0.162,0.117,0.324,0.234,0.489,0.348  c0.534,0.368,1.082,0.717,1.642,1.048c0.122,0.072,0.245,0.142,0.368,0.212c0.613,0.349,1.239,0.678,1.88,0.98  c0.047,0.022,0.095,0.042,0.142,0.064c2.089,0.971,4.319,1.684,6.651,2.105c0.061,0.011,0.122,0.022,0.184,0.033  c0.724,0.125,1.456,0.225,2.197,0.292c0.09,0.008,0.18,0.013,0.271,0.021C25.998,54.961,26.744,55,27.5,55  c0.749,0,1.488-0.039,2.222-0.098c0.093-0.008,0.186-0.013,0.279-0.021c0.735-0.067,1.461-0.164,2.178-0.287  c0.062-0.011,0.125-0.022,0.187-0.034c2.297-0.412,4.495-1.109,6.557-2.055c0.076-0.035,0.153-0.068,0.229-0.104  c0.617-0.29,1.22-0.603,1.811-0.936c0.147-0.083,0.293-0.167,0.439-0.253c0.538-0.317,1.067-0.648,1.581-1  c0.185-0.126,0.366-0.259,0.549-0.391c0.439-0.316,0.87-0.642,1.289-0.983c0.093-0.075,0.193-0.14,0.284-0.217l0.915-0.764  l-0.027-0.023C51.523,42.802,55,35.55,55,27.5z M2,27.5C2,13.439,13.439,2,27.5,2S53,13.439,53,27.5  c0,7.577-3.325,14.389-8.589,19.063c-0.294-0.203-0.59-0.385-0.893-0.537l-8.467-4.233c-0.76-0.38-1.232-1.144-1.232-1.993v-2.957  c0.196-0.242,0.403-0.516,0.617-0.817c1.096-1.548,1.975-3.27,2.616-5.123c1.267-0.602,2.085-1.864,2.085-3.289v-3.545  c0-0.867-0.318-1.708-0.887-2.369v-4.667c0.052-0.52,0.236-3.448-1.883-5.864C34.524,9.065,31.541,8,27.5,8  s-7.024,1.065-8.867,3.168c-2.119,2.416-1.935,5.346-1.883,5.864v4.667c-0.568,0.661-0.887,1.502-0.887,2.369v3.545  c0,1.101,0.494,2.128,1.34,2.821c0.81,3.173,2.477,5.575,3.093,6.389v2.894c0,0.816-0.445,1.566-1.162,1.958l-7.907,4.313  c-0.252,0.137-0.502,0.297-0.752,0.476C5.276,41.792,2,35.022,2,27.5z" fill="#d7ecf5"/>

									</svg>
                                    <span class="noti-box" style="display:block" ng-bind="contact_request_count" ng-if="contact_request_count != '0'"></span>
                                </a>
                                <div class="dropdown-menu">
                                    <div class="dropdown-title">
                                        Contact Request <a href="<?php echo base_url('contact-request') ?>" class="pull-right">See All</a>
                                    </div>
                                    <div class="content custom-scroll">
                                        <ul class="dropdown-data add-dropdown">
                                            <li class="" ng-repeat="contact_request in contact_request_data">
                                                <a href="#" target="_self">
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
                                                        <div class="post-img" ng-if="contact_request.user_image != ''">
                                                            <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{contact_request.user_image}}" alt="{{contact_request.fullname}}" ng-if="contact_request.user_image != ''">          
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
                            
                            <li class="dropdown" style="display: block;">
                                <a href="#" title="Notification" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" onclick = "return Notificationheader();" aria-expanded="false">
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
                                    <div class="fw" id="not_loader"  style="display:none; text-align:center;position:  absolute;top: 50%;">
                                        <img src="<?php echo base_url('assets/images/loader.gif') ?>" alt="<?php echo 'LOADERIMAGE'; ?>"/>
                                    </div>
                                    <div class="content custom-scroll">
                                        <ul class="notification_data_in">
                                        </ul>
                                    </div> 
                                </div>
                            </li>
                            <?php
                        }
                        $session_user = $this->session->userdata();
                        ?>
                            <li class="dropdown business_popup" >
                                <a href="javascript:void(0);" title="All Profile" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" ng-click="header_all_profile()">
									<svg x="0px" y="0px" viewBox="0 0 56 56" width="22px" height="22px">
								<g>
									<path d="M8,40c-4.411,0-8,3.589-8,8s3.589,8,8,8s8-3.589,8-8S12.411,40,8,40z" fill="#d7ecf5"/>
									<path d="M28,40c-4.411,0-8,3.589-8,8s3.589,8,8,8s8-3.589,8-8S32.411,40,28,40z" fill="#d7ecf5"/>
									<path d="M48,40c-4.411,0-8,3.589-8,8s3.589,8,8,8s8-3.589,8-8S52.411,40,48,40z" fill="#d7ecf5"/>
									<path d="M8,20c-4.411,0-8,3.589-8,8s3.589,8,8,8s8-3.589,8-8S12.411,20,8,20z" fill="#d7ecf5"/>
									<path d="M28,20c-4.411,0-8,3.589-8,8s3.589,8,8,8s8-3.589,8-8S32.411,20,28,20z" fill="#d7ecf5"/>
									<path d="M48,20c-4.411,0-8,3.589-8,8s3.589,8,8,8s8-3.589,8-8S52.411,20,48,20z" fill="#d7ecf5"/>
									<path d="M8,0C3.589,0,0,3.589,0,8s3.589,8,8,8s8-3.589,8-8S12.411,0,8,0z" fill="#d7ecf5"/>
									<path d="M28,0c-4.411,0-8,3.589-8,8s3.589,8,8,8s8-3.589,8-8S32.411,0,28,0z" fill="#d7ecf5"/>
									<path d="M48,16c4.411,0,8-3.589,8-8s-3.589-8-8-8s-8,3.589-8,8S43.589,16,48,16z" fill="#d7ecf5"/>
								</g>

								</svg>
								</a>
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
                                <li><a target="_self" href="<?php echo base_url().$this->session->userdata('aileenuser_slug'); ?>" title="View Profile">
									<svg  x="0px" y="0px" width="15px" height="15px" viewBox="0 0 438.529 438.529">
									<g>
										<g>
											<path d="M219.265,219.267c30.271,0,56.108-10.71,77.518-32.121c21.412-21.411,32.12-47.248,32.12-77.515
												c0-30.262-10.708-56.1-32.12-77.516C275.366,10.705,249.528,0,219.265,0S163.16,10.705,141.75,32.115
												c-21.414,21.416-32.121,47.253-32.121,77.516c0,30.267,10.707,56.104,32.121,77.515
												C163.166,208.557,189.001,219.267,219.265,219.267z"/>
											<path d="M419.258,335.036c-0.668-9.609-2.002-19.985-3.997-31.121c-1.999-11.136-4.524-21.457-7.57-30.978
												c-3.046-9.514-7.139-18.794-12.278-27.836c-5.137-9.041-11.037-16.748-17.703-23.127c-6.666-6.377-14.801-11.465-24.406-15.271
												c-9.617-3.805-20.229-5.711-31.84-5.711c-1.711,0-5.709,2.046-11.991,6.139c-6.276,4.093-13.367,8.662-21.266,13.708
												c-7.898,5.037-18.182,9.609-30.834,13.695c-12.658,4.093-25.361,6.14-38.118,6.14c-12.752,0-25.456-2.047-38.112-6.14
												c-12.655-4.086-22.936-8.658-30.835-13.695c-7.898-5.046-14.987-9.614-21.267-13.708c-6.283-4.093-10.278-6.139-11.991-6.139
												c-11.61,0-22.222,1.906-31.833,5.711c-9.613,3.806-17.749,8.898-24.412,15.271c-6.661,6.379-12.562,14.086-17.699,23.127
												c-5.137,9.042-9.229,18.326-12.275,27.836c-3.045,9.521-5.568,19.842-7.566,30.978c-2,11.136-3.332,21.505-3.999,31.121
												c-0.666,9.616-0.998,19.466-0.998,29.554c0,22.836,6.949,40.875,20.842,54.104c13.896,13.224,32.36,19.835,55.39,19.835h249.533
												c23.028,0,41.49-6.611,55.388-19.835c13.901-13.229,20.845-31.265,20.845-54.104C420.264,354.502,419.932,344.652,419.258,335.036
												z"/>
										</g>
									</g>
									</svg>
									<span>View Profile</span></a>
								</li>
                                <li><a target="_self" href="<?php echo base_url('edit-profile') ?>" title="Setting">
									<svg x="0px" y="0px" width="15px" height="15px" viewBox="0 0 268.765 268.765">
									<g id="Settings">
										<g>
											<path style="fill-rule:evenodd;clip-rule:evenodd;" d="M267.92,119.461c-0.425-3.778-4.83-6.617-8.639-6.617
												c-12.315,0-23.243-7.231-27.826-18.414c-4.682-11.454-1.663-24.812,7.515-33.231c2.889-2.641,3.24-7.062,0.817-10.133
												c-6.303-8.004-13.467-15.234-21.289-21.5c-3.063-2.458-7.557-2.116-10.213,0.825c-8.01,8.871-22.398,12.168-33.516,7.529
												c-11.57-4.867-18.866-16.591-18.152-29.176c0.235-3.953-2.654-7.39-6.595-7.849c-10.038-1.161-20.164-1.197-30.232-0.08
												c-3.896,0.43-6.785,3.786-6.654,7.689c0.438,12.461-6.946,23.98-18.401,28.672c-10.985,4.487-25.272,1.218-33.266-7.574
												c-2.642-2.896-7.063-3.252-10.141-0.853c-8.054,6.319-15.379,13.555-21.74,21.493c-2.481,3.086-2.116,7.559,0.802,10.214
												c9.353,8.47,12.373,21.944,7.514,33.53c-4.639,11.046-16.109,18.165-29.24,18.165c-4.261-0.137-7.296,2.723-7.762,6.597
												c-1.182,10.096-1.196,20.383-0.058,30.561c0.422,3.794,4.961,6.608,8.812,6.608c11.702-0.299,22.937,6.946,27.65,18.415
												c4.698,11.454,1.678,24.804-7.514,33.23c-2.875,2.641-3.24,7.055-0.817,10.126c6.244,7.953,13.409,15.19,21.259,21.508
												c3.079,2.481,7.559,2.131,10.228-0.81c8.04-8.893,22.427-12.184,33.501-7.536c11.599,4.852,18.895,16.575,18.181,29.167
												c-0.233,3.955,2.67,7.398,6.595,7.85c5.135,0.599,10.301,0.898,15.481,0.898c4.917,0,9.835-0.27,14.752-0.817
												c3.897-0.43,6.784-3.786,6.653-7.696c-0.451-12.454,6.946-23.973,18.386-28.657c11.059-4.517,25.286-1.211,33.281,7.572
												c2.657,2.89,7.047,3.239,10.142,0.848c8.039-6.304,15.349-13.534,21.74-21.494c2.48-3.079,2.13-7.559-0.803-10.213
												c-9.353-8.47-12.388-21.946-7.529-33.524c4.568-10.899,15.612-18.217,27.491-18.217l1.662,0.043
												c3.853,0.313,7.398-2.655,7.865-6.588C269.044,139.917,269.058,129.639,267.92,119.461z M134.595,179.491
												c-24.718,0-44.824-20.106-44.824-44.824c0-24.717,20.106-44.824,44.824-44.824c24.717,0,44.823,20.107,44.823,44.824
												C179.418,159.385,159.312,179.491,134.595,179.491z"/>
										</g>
									</g>
									</svg>

									<span>Setting</span></a>
								</li>
                                <li><a target="_self" href="<?php echo base_url('logout') ?>" title="Logout">
									<svg x="0px" y="0px" width="15px" height="15px" viewBox="0 0 44.816 44.816">
									<g>
										<g>
											<path d="M22.404,21.173c2.126,0,3.895-1.724,3.895-3.85V3.849C26.299,1.724,24.53,0,22.404,0c-2.126,0-3.895,1.724-3.895,3.849
												v13.475C18.51,19.449,20.278,21.173,22.404,21.173z"/>
											<path d="M30.727,3.33c-0.481-0.2-1.03-0.147-1.466,0.142c-0.434,0.289-0.695,0.776-0.695,1.298v5.113
												c0,0.56,0.301,1.076,0.784,1.354c4.192,2.407,6.918,6.884,6.918,11.999c0,7.654-6.217,13.882-13.87,13.882
												c-7.654,0-13.86-6.228-13.86-13.882c0-5.113,2.813-9.589,6.931-11.997c0.478-0.279,0.773-0.794,0.773-1.348V4.769
												c0-0.521-0.261-1.009-0.695-1.298c-0.435-0.29-0.984-0.342-1.466-0.142C6.257,6.593,0.845,14.276,0.845,23.236
												c0,11.92,9.653,21.58,21.572,21.58c11.917,0,21.555-9.66,21.555-21.58C43.971,14.276,38.554,6.593,30.727,3.33z"/>
										</g>
									</g>

									</svg>


									<span>Logout</span></a>
								</li>
                            </ul>
                        </li>
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
                    <h2 class="logo">
                        <a target="_self" href="<?php echo base_url(); ?>">
                            <img src="<?php echo base_url('assets/n-images/mob-logo.png') ?>">
                        </a>
                    </h2>
                    <?php if ($is_userBasicInfo == '1' || $is_userStudentInfo == '1') { ?>
                    <div class="search-mob-block">
                        <div class="">
                            <?php 
                            $first_segment = $this->uri->segment(1);
                            $page_arr = array('','search','contact-request');
                            $no_ser_arr = array("freelance-profile","recommended-candidates","hire-freelancer","job-profile","recruiter","business-profile","job","job-search","recommended-jobs","jobs-by-companies","jobs-by-categories","jobs-by-skills","jobs-by-location","jobs-by-designations","jobs","job-profile","-job-vacancy-in-","freelance-jobs-by-fields","freelance-jobs-by-categories","recruiter","recommended-candidates","post-job","hire-freelancer","freelance-employer","freelancer","post-freelance-project","recommended-freelance-work","artist-profile","artist","business");
                            if(!in_array($first_segment, $no_ser_arr))
                            {
                            //if(in_array($first_segment, $page_arr)): ?>
                            <form ng-submit="search_submit" id="mobile_ser_frm" name="mobile_ser_frm" action="<?php echo base_url('search') ?>">
                                <input type="text" name="q" placeholder="Search.." id="mob_search">
                            </form>
                            <?php /*else: ?>
                            <a href="#search">
                                <input type="search" id="tags1" class="tags" name="skills" value="" placeholder="Job Title,Skill,Company" />
                            </a>
                        <?php */ //endif;
                            } ?>
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
										<svg  x="0px" y="0px" width="15px" height="15px" viewBox="0 0 438.529 438.529">
									<g>
										<g>
											<path d="M219.265,219.267c30.271,0,56.108-10.71,77.518-32.121c21.412-21.411,32.12-47.248,32.12-77.515
												c0-30.262-10.708-56.1-32.12-77.516C275.366,10.705,249.528,0,219.265,0S163.16,10.705,141.75,32.115
												c-21.414,21.416-32.121,47.253-32.121,77.516c0,30.267,10.707,56.104,32.121,77.515
												C163.166,208.557,189.001,219.267,219.265,219.267z"/>
											<path d="M419.258,335.036c-0.668-9.609-2.002-19.985-3.997-31.121c-1.999-11.136-4.524-21.457-7.57-30.978
												c-3.046-9.514-7.139-18.794-12.278-27.836c-5.137-9.041-11.037-16.748-17.703-23.127c-6.666-6.377-14.801-11.465-24.406-15.271
												c-9.617-3.805-20.229-5.711-31.84-5.711c-1.711,0-5.709,2.046-11.991,6.139c-6.276,4.093-13.367,8.662-21.266,13.708
												c-7.898,5.037-18.182,9.609-30.834,13.695c-12.658,4.093-25.361,6.14-38.118,6.14c-12.752,0-25.456-2.047-38.112-6.14
												c-12.655-4.086-22.936-8.658-30.835-13.695c-7.898-5.046-14.987-9.614-21.267-13.708c-6.283-4.093-10.278-6.139-11.991-6.139
												c-11.61,0-22.222,1.906-31.833,5.711c-9.613,3.806-17.749,8.898-24.412,15.271c-6.661,6.379-12.562,14.086-17.699,23.127
												c-5.137,9.042-9.229,18.326-12.275,27.836c-3.045,9.521-5.568,19.842-7.566,30.978c-2,11.136-3.332,21.505-3.999,31.121
												c-0.666,9.616-0.998,19.466-0.998,29.554c0,22.836,6.949,40.875,20.842,54.104c13.896,13.224,32.36,19.835,55.39,19.835h249.533
												c23.028,0,41.49-6.611,55.388-19.835c13.901-13.229,20.845-31.265,20.845-54.104C420.264,354.502,419.932,344.652,419.258,335.036
												z"/>
										</g>
									</g>
									</svg>
									<span>View Profile</span></a>
									</li>
                                    <li><a target="_self" href="<?php echo base_url('edit-profile') ?>" title="Setting">
										<svg x="0px" y="0px" width="15px" height="15px" viewBox="0 0 268.765 268.765">
										<g id="Settings">
											<g>
												<path style="fill-rule:evenodd;clip-rule:evenodd;" d="M267.92,119.461c-0.425-3.778-4.83-6.617-8.639-6.617
													c-12.315,0-23.243-7.231-27.826-18.414c-4.682-11.454-1.663-24.812,7.515-33.231c2.889-2.641,3.24-7.062,0.817-10.133
													c-6.303-8.004-13.467-15.234-21.289-21.5c-3.063-2.458-7.557-2.116-10.213,0.825c-8.01,8.871-22.398,12.168-33.516,7.529
													c-11.57-4.867-18.866-16.591-18.152-29.176c0.235-3.953-2.654-7.39-6.595-7.849c-10.038-1.161-20.164-1.197-30.232-0.08
													c-3.896,0.43-6.785,3.786-6.654,7.689c0.438,12.461-6.946,23.98-18.401,28.672c-10.985,4.487-25.272,1.218-33.266-7.574
													c-2.642-2.896-7.063-3.252-10.141-0.853c-8.054,6.319-15.379,13.555-21.74,21.493c-2.481,3.086-2.116,7.559,0.802,10.214
													c9.353,8.47,12.373,21.944,7.514,33.53c-4.639,11.046-16.109,18.165-29.24,18.165c-4.261-0.137-7.296,2.723-7.762,6.597
													c-1.182,10.096-1.196,20.383-0.058,30.561c0.422,3.794,4.961,6.608,8.812,6.608c11.702-0.299,22.937,6.946,27.65,18.415
													c4.698,11.454,1.678,24.804-7.514,33.23c-2.875,2.641-3.24,7.055-0.817,10.126c6.244,7.953,13.409,15.19,21.259,21.508
													c3.079,2.481,7.559,2.131,10.228-0.81c8.04-8.893,22.427-12.184,33.501-7.536c11.599,4.852,18.895,16.575,18.181,29.167
													c-0.233,3.955,2.67,7.398,6.595,7.85c5.135,0.599,10.301,0.898,15.481,0.898c4.917,0,9.835-0.27,14.752-0.817
													c3.897-0.43,6.784-3.786,6.653-7.696c-0.451-12.454,6.946-23.973,18.386-28.657c11.059-4.517,25.286-1.211,33.281,7.572
													c2.657,2.89,7.047,3.239,10.142,0.848c8.039-6.304,15.349-13.534,21.74-21.494c2.48-3.079,2.13-7.559-0.803-10.213
													c-9.353-8.47-12.388-21.946-7.529-33.524c4.568-10.899,15.612-18.217,27.491-18.217l1.662,0.043
													c3.853,0.313,7.398-2.655,7.865-6.588C269.044,139.917,269.058,129.639,267.92,119.461z M134.595,179.491
													c-24.718,0-44.824-20.106-44.824-44.824c0-24.717,20.106-44.824,44.824-44.824c24.717,0,44.823,20.107,44.823,44.824
													C179.418,159.385,159.312,179.491,134.595,179.491z"/>
											</g>
										</g>
										</svg>

										<span>Setting</span></a>
									</li>
                                    <li><a target="_self" href="<?php echo base_url('logout') ?>" title="Logout">
										<svg x="0px" y="0px" width="15px" height="15px" viewBox="0 0 44.816 44.816">
										<g>
											<g>
												<path d="M22.404,21.173c2.126,0,3.895-1.724,3.895-3.85V3.849C26.299,1.724,24.53,0,22.404,0c-2.126,0-3.895,1.724-3.895,3.849
													v13.475C18.51,19.449,20.278,21.173,22.404,21.173z"/>
												<path d="M30.727,3.33c-0.481-0.2-1.03-0.147-1.466,0.142c-0.434,0.289-0.695,0.776-0.695,1.298v5.113
													c0,0.56,0.301,1.076,0.784,1.354c4.192,2.407,6.918,6.884,6.918,11.999c0,7.654-6.217,13.882-13.87,13.882
													c-7.654,0-13.86-6.228-13.86-13.882c0-5.113,2.813-9.589,6.931-11.997c0.478-0.279,0.773-0.794,0.773-1.348V4.769
													c0-0.521-0.261-1.009-0.695-1.298c-0.435-0.29-0.984-0.342-1.466-0.142C6.257,6.593,0.845,14.276,0.845,23.236
													c0,11.92,9.653,21.58,21.572,21.58c11.917,0,21.555-9.66,21.555-21.58C43.971,14.276,38.554,6.593,30.727,3.33z"/>
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
                    </a>
                </div>
            </li>
            <li class="dropdown">
                <div class="mob-btm-icon">
                    <a href="<?php echo MESSAGE_URL; ?>" class="" alt="message">
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
                        <!-- <span class="noti-box">1</span> -->
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
	<?php $this->load->view('mobile_side_slide'); ?>
	</div>
</div>
<script>
   /*var menuRight = document.getElementById( 'cbp-spmenu-s2' ),
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
   }*/
   
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
            $(".noti_count").show();
            if(parseInt(data) > 0)
            {
                $(".noti_count").html(data);
            }
            else
            {
                $(".noti_count").hide();
                $(".noti_count").html("");
            }
        });

        /*$.ajax({
            type: 'POST',
            url: '<?php //echo base_url() . "notification/get_notification_unread_count" ?>',
            dataType: 'json',
            data: '',
            success: function (data) {
                console.clear();
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
        $(document).on('click','a[href="#search"]', function(){
            event.preventDefault();
            $('#search').addClass('open');
            $('#search > form > input[type="search"]').focus();
        });

        $(document).on('click keyup','#search, #search button.close-new', function (event) {
            if (event.target == this || event.target.className == 'close' || event.keyCode == 27) {
                $(this).removeClass('open');
            }
        });
</script>     
<script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
<script src="<?php echo base_url('assets/js/classie.js?ver=' . time()) ?>"></script>