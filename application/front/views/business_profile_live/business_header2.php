<link rel="stylesheet" href="<?php echo base_url('assets/n-css/component.css') ?>" />
<div id="business_mob_search" class="modal fade mob-search-popup" role="dialog">
    <form onsubmit="businesssearchMobileSubmit()" method="get" action="javascript:void(0)">
        <div class="new-search-input1">
        	<input id="m_tags" class="tags ui-autocomplete-input ccp_search" name="skills" placeholder="Search by Company, Category, or Products" autocomplete="off" type="text">
			<input id="m_searchplace" class="searchplace ui-autocomplete-input" name="searchplace" placeholder="City, State or Country" autocomplete="off" type="text">
        </div>
		<div class="new-search-btn">
			<button type="button" class="close-new btn" data-dismiss="modal">Cancel</button>
			<button type="submit" id="m_search_btn" class="btn btn-primary" onclick="return m_checval();">Search</button>
		</div>
	</form>
</div>
<?php
$userid = $this->session->userdata('aileenuser');
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

echo $header_inner_profile ?>
<div class="web-header">
    
    <?php if ($business_common_data[0]['business_step'] == 4) { ?>
    <div class="sub-header">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mob-p0">
                    <ul class="sub-menu">
                        <li class="profile">
                            <a href="<?php echo base_url('business-profile');//$business_right_profile_link; ?>">
								<div class="sub-menu-icon">
									
										<svg class="not-hover" viewBox="0 0 486.988 486.988" width="17px" height="17px">
											<path d="M16.822,284.968h39.667v158.667c0,9.35,7.65,17,17,17h116.167c9.35,0,17-7.65,17-17V327.468h70.833v116.167    c0,9.35,7.65,17,17,17h110.5c9.35,0,17-7.65,17-17V284.968h48.167c6.8,0,13.033-4.25,15.583-10.483    c2.55-6.233,1.133-13.6-3.683-18.417L260.489,31.385c-6.517-6.517-17.283-6.8-23.8-0.283L5.206,255.785    c-5.1,4.817-6.517,12.183-3.967,18.7C3.789,281.001,10.022,284.968,16.822,284.968z M248.022,67.368l181.333,183.6h-24.367    c-9.35,0-17,7.65-17,17v158.667h-76.5V310.468c0-9.35-7.65-17-17-17H189.656c-9.35,0-17,7.65-17,17v116.167H90.489V267.968    c0-9.35-7.65-17-17-17H58.756L248.022,67.368z" />
											
										</svg>
										<svg class="on-hover" width="17px" height="17px" viewBox="0 0 2133.000000 2133.000000">
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

									<span>Business Profile</span>
								</div>
							</a>
                        </li>
                        <?php if($isbusiness_deactive == false && $isbusiness_register == true){ ?>
                            <li class="dropdown Inbox_link" id="Inbox_link">
                                <a href="<?php echo MESSAGE_URL.'business'; ?>" class="dropdown-toggle">
                                	<!-- data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"  onclick="return getmsgNotification()" -->
									<div class="sub-menu-icon">
									<svg class="not-hover" width="17px" height="17px" viewBox="0 0 2133.000000 2133.000000">
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
									<svg class="on-hover" width="17" height="17" viewBox="0 0 2133.000000 2133.000000">
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
									<span class="none-sub-menu"> Message</span>
									<span class="message_count noti-box" id="message_count" style="display: none;"></span>
								</div>
                                    
                                </a>
                                <div class="dropdown-menu InboxContainer">
                                    <div class="dropdown-title">
                                        Messages <a href="javascript:void(0)" class="seemsg pull-right" id="seemsg"></a>
                                    </div>
                                    <div class="content custom-scroll">
                                        <ul class="dropdown-data msg-dropdown notification_data_in_h2">
                                            
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            
    			            <li class="dropdown user-id">
                                <a href="#" class="dropdown-toggle user-id-custom" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
									<svg class="not-hover" viewBox="0 0 384.97 384.97" width="16px" height="16px">
									<g>
										<g id="Chevron_Down_Circle">
											<path d="M192.485,0C86.185,0,0,86.173,0,192.485c0,106.3,86.185,192.485,192.485,192.485    c106.312,0,192.485-86.185,192.485-192.485C384.97,86.173,298.797,0,192.485,0z M192.485,360.909    c-92.874,0-168.424-75.55-168.424-168.424S99.611,24.061,192.485,24.061s168.797,75.55,168.797,168.424    S285.359,360.909,192.485,360.909z" fill="#5c5c5c"/>
											<path d="M268.276,149.092l-75.61,74.528l-75.61-74.54c-4.74-4.704-12.439-4.704-17.191,0c-4.74,4.704-4.74,12.319,0,17.011    l84.2,83.009c4.62,4.572,12.56,4.584,17.191,0l84.2-82.997c4.74-4.704,4.74-12.319,0-17.011    C280.715,144.4,273.028,144.4,268.276,149.092z" fill="#5c5c5c"/>
										</g>
									</g>

								</svg>
						
								<svg class="on-hover" width="17px" height="17px" viewBox="0 0 2133.000000 2133.000000">

									<g transform="translate(0.000000,2133.000000) scale(0.100000,-0.100000)">
										<path d="M10055 21319 c-2633 -154 -5074 -1248 -6935 -3109 -1870 -1870 -2958
										-4308 -3110 -6964 -13 -230 -13 -932 0 -1162 109 -1918 698 -3704 1745 -5294
										836 -1270 1973 -2378 3265 -3182 604 -376 1257 -699 1900 -938 1017 -379 2061
										-597 3164 -660 230 -13 932 -13 1162 0 2656 152 5094 1240 6964 3110 1782
										1782 2869 4112 3085 6610 27 319 35 528 35 935 0 528 -18 844 -76 1320 -373
										3068 -2093 5847 -4684 7570 -1591 1058 -3393 1655 -5324 1765 -206 12 -984 11
										-1191 -1z m-3840 -8083 c85 -27 174 -76 234 -128 20 -17 976 -959 2126 -2092
										1149 -1134 2094 -2061 2100 -2061 6 0 965 941 2131 2090 2285 2253 2162 2137
										2329 2192 69 23 97 26 205 26 108 0 136 -3 205 -26 108 -36 194 -89 274 -168
										79 -80 132 -166 168 -274 33 -101 37 -262 9 -365 -37 -136 -87 -212 -246 -372
										-80 -81 -1155 -1142 -2390 -2359 -1601 -1578 -2264 -2224 -2310 -2254 -133
										-87 -307 -127 -457 -106 -105 15 -224 57 -297 106 -82 54 -4789 4697 -4846
										4779 -179 258 -149 608 70 836 178 185 451 254 695 176z"/>
									</g>
								</svg>
								<span class="pr-name"><span class="none-sub-menu"> Account</span></span>
								</a>

                                <ul class="dropdown-menu account">
                                    <li>Business Account</li>
                                    <li><a href="<?php echo base_url('company/' . $business_login_slug_with_location); ?>">
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
										View Profile </a>
									</li>
                                    <li><a href="<?php echo base_url('business-profile/registration/business-information'); ?>">
										<svg x="0px" y="0px" width="15px" height="15px" viewBox="0 0 485.219 485.22">
										<g>
											<path d="M467.476,146.438l-21.445,21.455L317.35,39.23l21.445-21.457c23.689-23.692,62.104-23.692,85.795,0l42.886,42.897
												C491.133,84.349,491.133,122.748,467.476,146.438z M167.233,403.748c-5.922,5.922-5.922,15.513,0,21.436
												c5.925,5.955,15.521,5.955,21.443,0L424.59,189.335l-21.469-21.457L167.233,403.748z M60,296.54c-5.925,5.927-5.925,15.514,0,21.44
												c5.922,5.923,15.518,5.923,21.443,0L317.35,82.113L295.914,60.67L60,296.54z M338.767,103.54L102.881,339.421
												c-11.845,11.822-11.815,31.041,0,42.886c11.85,11.846,31.038,11.901,42.914-0.032l235.886-235.837L338.767,103.54z
												 M145.734,446.572c-7.253-7.262-10.749-16.465-12.05-25.948c-3.083,0.476-6.188,0.919-9.36,0.919
												c-16.202,0-31.419-6.333-42.881-17.795c-11.462-11.491-17.77-26.687-17.77-42.887c0-2.954,0.443-5.833,0.859-8.703
												c-9.803-1.335-18.864-5.629-25.972-12.737c-0.682-0.677-0.917-1.596-1.538-2.338L0,485.216l147.748-36.986
												C147.097,447.637,146.36,447.193,145.734,446.572z"/>
										</g>
										</svg>
										Edit Profile </a>
									</li>
                                    <!-- <li class="hidden"><a onclick="deactivate(<?php //echo $userid; ?>)"><span class="icon-delete edit_data"></span> Deactive Profile</a></li> -->
                                </ul>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="col-sm-6 col-md-6 col-xs-6 hidden-mob">
                    <div class="job-search-box1 clearfix">
                        <form onsubmit="businesssearchSubmit()" method="get" action="javascript:void(0)">
                            <fieldset class="sec_h2">
                                <input id="tags" class="tags ui-autocomplete-input ccp_search" name="skills" placeholder="Company, Category, or Products" autocomplete="off" type="text">
                            </fieldset>
                            <fieldset class="sec_h2">
                                <input id="searchplace" class="searchplace ui-autocomplete-input" name="searchplace" placeholder="City, State or Country" autocomplete="off" type="text">
                            </fieldset>
                            <fieldset class="new-search-btn">
                                <label for="search_btn" id="search_f"><i class="fa fa-search" aria-hidden="true"></i></label>
                                <input id="search_btn" style="display: none;" name="search_submit" value="Search" onclick="return checkvalue()" type="submit">
                            </fieldset>
                        </form>    
                    </div>
                </div>
            </div>
        </div>

    </div>
     <?php } ?>
</div>
<div class="mobile-header">
    <?php if ($business_common_data[0]['business_step'] == 4) { ?>
    <div class="sub-header bus-only">
		<div class="container">
			<div class="row">
				
					<ul class="sub-menu">
					<li class="profile">
						<a href="<?php echo $business_right_profile_link; ?>" target="_self">
							<div class="sub-menu-icon">
								<span>Business Profile</span>
							</div>
							
						</a>
					</li>
					<?php if($isbusiness_deactive == false && $isbusiness_register == true){ ?>
					<li class="dropdown Inbox_link" id="Inbox_link">
						<a href="<?php echo MESSAGE_URL.'business'; ?>" class="dropdown-toggle">
							<!-- data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"  onclick="return getmsgNotification()" -->
							<div class="sub-menu-icon">
								<span> Message</span>
								<span class="message_count noti-box" style="display: none;"></span>
							</div>							
						</a>
						<div class="dropdown-menu InboxContainer">
                            <div class="dropdown-title">
                                Messages <a href="javascript:void(0)" class="seemsg pull-right" id="seemsg"></a>
                            </div>
                            <div class="content custom-scroll">
                                <ul class="dropdown-data msg-dropdown notification_data_in_h2">
                                </ul>
                            </div>
                        </div>
					</li>
					
					<li class="dropdown user-id">
						<a href="#" class="dropdown-toggle user-id-custom" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
							

							<span class="pr-name"><span> Account</span></span>
						</a>
						<ul class="dropdown-menu account">
							<li>Business Account</li>
							<li><a href="<?php echo base_url('company/' . $business_login_slug_with_location); ?>">
								<span class="icon-view-profile edit_data"></span> View Profile</a></li>
							<li><a href="<?php echo base_url('business-profile/registration/business-information'); ?>"><span class="icon-edit-profile edit_data"></span>  Edit Profile </a></li>
						</ul>
					</li>
					<?php } ?>
				</ul>
			</div>
		</div>
	
	</div>

    <?php } ?>
	
</div>

<div class="sub-header-search">
	<div class="container">
		<div class="search-mob-block">
		    <a href="#" data-toggle="modal" data-target="#business_mob_search">
		        <input type="search" readonly="true" id="tags1" class="tags ccp_search" name="skills" value="" placeholder="Search..." />
		    </a>        
		</div>
	</div>
</div>

<div class="modal fade message-box biderror" id="bidmodal" role="dialog">
    <div class="modal-dialog modal-lm deactive">
        <div class="modal-content">
            <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
            <div class="modal-body">
                <span class="mes"></span>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function deactivate(clicked_id) {
        $('.biderror .mes').html("<div class='pop_content'> Are you sure you want to deactive your business profile?<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='deactivate_profile(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
        $('#bidmodal').modal('show');
    }
    function deactivate_profile(clicked_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . "business_profile/deactivate" ?>',
            data: 'id=' + clicked_id,
            success: function (data) {
                window.location = "<?php echo base_url() ?>";
            }
        });
    }
</script>
<script type="text/javascript">
    function Notification_contact() {
        contactperson();
        update_contact_count();
    }
    function contactperson() {
        $.ajax({
            url: "<?php echo base_url(); ?>business_profile/contact_notification",
            type: "POST",
            dataType: 'json',
            data: '',
            success: function (data) {
                $('.notification_data_in_con').html(data.contactdata);
                $('#seecontact').html(data.seeall);
            }
        });
    }
    function update_contact_count() {
        $.ajax({
            url: "<?php echo base_url(); ?>business_profile/update_contact_count",
            type: "POST",
            success: function (data) {
                /*$('span[id^=addcontact_count]').html('');
                $('span[id^=addcontact_count]').css({
                    "background-color": "",
                    "padding": "0px"
                });*/
                $('#addcontactLink').html("");
                if (parseInt(data) > 0) {                    
                    $('#addcontactLink').html(data);
                }
                $('#addcontactLink').removeClass('noti-box');
            }
        });
    }
    function contactapprove(toid, status) {
        $.ajax({
            url: "<?php echo base_url(); ?>business_profile/contact_approve",
            type: "POST",
            data: 'toid=' + toid + '&status=' + status,
            dataType: "json",
            success: function (data) {
                //$('.mCS_no_scrollbar').html(data.contactdata);
                $('.mCustomScrollbar').html(data.contactdata);
                $('.contactcount').html(data.contactcount);
                var segment = '<?php echo $this->uri->segment(2); ?>';
                if (segment == 'contacts') {
                    var slug = '<?php echo $slug_id; ?>';
                    $('.art-img-nn').hide();
                    business_contacts_header(slug);
                }
                var not_contact_count = $('.addcontact-left').length;
                if (not_contact_count == 0) {
                    var data_html = "<li><div class='art-img-nn' id='art-blank'><div class='art_no_post_img'><img src='<?php echo base_url('img/No_Contact_Request.png?ver=' . time()); ?>' alt='No Contact Request'></div><div class='art_no_post_text'>No Contact Request Available.</div></div></li>";
                    $('#notification_main_in').html(data_html);
                    $('#seecontact').hide();
                }
                if (data.co_notification.co_notification_count != 0) {
                    var co_notification_count = data.co_notification.co_notification_count;
                    var co_to_id = data.co_notification.co_to_id;
                    show_contact_notification(co_notification_count, co_to_id);
                }
            }
        });
    }
</script>
<script type="text/javascript">
    $(document).on('keydown', function (e) {
        if (e.keyCode === 27) {
            $('#bidmodal').modal('hide');
        }
    });
    $(document).on('keydown', function (e) {
        if (e.keyCode === 27) {
            $("#dropdown-content_hover").hide();
        }
    });
</script>
<script type="text/javascript" charset="utf-8">
    function addmsg1(type, msg)
    {
        if (msg == 0)
        {
            $(".message_count").html('');
            $(".message_count").removeAttr("style");
            $('.message_count').removeClass('count_add');
            $('#InboxLink').removeClass('msg_notification_available');
            $(".message_count").hide();
            // document.getElementById('message_count').style.display = "none";
        } else
        {
            $('.message_count').html(msg);
            $('#InboxLink').addClass('msg_notification_available');
            $('.message_count').addClass('count_add');
            $('.message_count').show();
            // document.getElementById('message_count').style.display = "block";
        }
    }
    function waitForMsg1()
    {
        $.ajax({
            type: "GET",
            url: "<?php echo base_url(); ?>notification/select_msg_noti/6",
            async: true,
            cache: false,
            timeout: 50000,
            success: function (data) {
                addmsg1("new", data);
                setTimeout(
                        waitForMsg1,
                        10000
                        );
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
            }
        });
    }
    ;
    $(document).ready(function () {
        // waitForMsg1();
    });
    $(document).ready(function () {
        $menuLeft = $('.pushmenu-left');
        $nav_list = $('#nav_list');
        $nav_list.click(function () {
            $(this).toggleClass('active');
            $('.pushmenu-push').toggleClass('pushmenu-push-toright');
            $menuLeft.toggleClass('pushmenu-open');
        });
    });

</script>
<script type="text/javascript">
    $(document).ready(function () {
        var InboxContainer = $('#InboxContainer').attr('class');
        if (InboxContainer == 'dropdown2_content show') {
            var segment = '<?php echo "" . $this->uri->segment(1) . "" ?>';
            if (segment != "chat") {
                // chatmsg();
            }
        }
        $('.Inbox_link').on('click', function () {
            // chatmsg();
        });
    });
    function chatmsg()
    {
        /*$.ajax({
         type: 'POST',
         url: '<?php //echo base_url() . "chat/userajax/5/5" ?>',
         dataType: 'json',
         data: '',
         success: function (data) {
         
         $('#userlist').html(data.leftbar);
         $('.notification_data_in_h2').html(data.headertwo);
         $('#seemsg').html(data.seeall);
         setTimeout(
         chatmsg,
         25000
         );
         },
         error: function (XMLHttpRequest, textStatus, errorThrown) {
         }
         });*/

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . "chat/userajax/5/5" ?>',
            dataType: 'json',
            data: '',
            success: function (data) {
                $('#userlist').html(data.leftbar);
                $('.notification_data_in_h2').html(data.headertwo);
                $('.seemsg').html(data.seeall);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
            }
        });

    };
    function getmsgNotification() {
        msgNotification();
    }

    function msgNotification() {
        $.ajax({
            url: "<?php echo base_url(); ?>notification/update_msg_noti/6",
            type: "POST",
            success: function (data) {
                data = JSON.parse(data);
            }
        });
    }
    function msgheader()
    {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . "notification/msg_header/" . $this->uri->segment(3) . "" ?>',
            data: 'message_from_profile=5&message_to_profile=5',
            success: function (data) {
                $('#' + 'notificationsmsgBody').html(data);
            }
        });

    }
</script>
<script type="text/javascript">
    $(document).ready(function () {
        document.getElementById('tags1').value = null;
        // document.getElementById('searchplace1').value = null;
    });
</script>

<script>
    function businesssearchSubmit(){
        var keyword = $("#tags").val().toLowerCase().split(' ').join('+');
        var city = $("#searchplace").val().toLowerCase().split(' ').join('+');
        // REPLACE , WITH - AND REMOVE IN FROM KEYWORD ARRAY
        var keyworddata = [];
        if(keyword != ""){
            keyworddata = keyword.split(",");
            // remove in from array
            if(keyworddata.indexOf("in") > -1 && city != ""){
                keyworddata.splice(keyworddata.indexOf("in"),1);
            }
            keyword = keyworddata.join('-').toString();
        }
        var citydata = [];
        if(city != ""){
            citydata = city.split(",");
            // remove in from array
            // if(citydata.indexOf("in") > -1 && city != ""){
            //     citydata.splice(citydata.indexOf("in"),1);
            // }
            city = citydata.join('-').toString();
        }
        if (keyword == '' && city == '') {
            return false;
        } else if (keyword != '' && city == '') {
            window.location.href = base_url + 'business/search/' + keyword;
        } else if (keyword == '' && city != '') {
            window.location.href = base_url + 'business/search/business-in-' + city;
        } else {
            window.location.href = base_url + 'business/search/' + keyword + '-business-in-' + city;
        }
    }

    function businesssearchMobileSubmit(){
        var keyword = $("#m_tags").val().toLowerCase().split(' ').join('+');
        var city = $("#m_searchplace").val().toLowerCase().split(' ').join('+');
        // REPLACE , WITH - AND REMOVE IN FROM KEYWORD ARRAY
        var keyworddata = [];
        if(keyword != ""){
            keyworddata = keyword.split(",");
            // remove in from array
            if(keyworddata.indexOf("in") > -1 && city != ""){
                keyworddata.splice(keyworddata.indexOf("in"),1);
            }
            keyword = keyworddata.join('-').toString();
        }
        var citydata = [];
        if(city != ""){
            citydata = city.split(",");
            // remove in from array
            // if(citydata.indexOf("in") > -1 && city != ""){
            //     citydata.splice(citydata.indexOf("in"),1);
            // }
            city = citydata.join('-').toString();
        }
        if (keyword == '' && city == '') {
            return false;
        } else if (keyword != '' && city == '') {
            window.location.href = base_url + 'business/search/' + keyword;
        } else if (keyword == '' && city != '') {
            window.location.href = base_url + 'business/search/business-in-' + city;
        } else {
            window.location.href = base_url + 'business/search/' + keyword + '-business-in-' + city;
        }
    }

    function m_checval(){
    	var keyword = $("#m_tags").val();
    	var city = $("#m_searchplace").val();
    	if(keyword == "" && city == ""){
    		return false;
    	}
    }

    $(document).on('click','.mob_close', function (event) {
    	if (event.target == this || event.target.className == 'close' || event.keyCode == 27) {
            $('#search').removeClass('open');
        }
    });
    function unread_message_count_business()
	{
	    var url = '<?php echo base_url() . "notification/unread_message_count_business" ?>';
	    $.get(url, function(data, status){
	        data = JSON.parse(data);
	        if(data.unread_user > 0)
	        {
	            $(".message_count").show();
	            $(".message_count").text(data.unread_user);
	        }
	        else
	        {
	            $(".message_count").hide();
	            $(".message_count").text('');   
	        }

	        setTimeout(function(){
	            //unread_message_count_business();
	        }, 5000);
	    })
	    .fail(function() {
	        setTimeout(function(){
	            //unread_message_count_business();
	        }, 5000);
	    });	    
	}
	setTimeout(function(){
	    //unread_message_count_business();
	}, 1000);
</script>

<script src="<?php echo base_url('assets/js/classie.js?ver=' . time()) ?>"></script>
