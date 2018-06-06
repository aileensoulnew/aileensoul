<?php
$userid = $this->session->userdata('aileenuser');
?>
<div class="web-header">
	<?php echo $header_inner_profile ?>
	<div class="sub-header">
		<div class="container">
			<div class="row">
				<div class="col-md-6 mob-p0">
					<ul class="sub-menu">
						<li class="profile">
							<?php
							if($job_deactive == 0  && $this->job_profile_set == 1)
							{ ?>
							<a href="<?php echo base_url('recommended-jobs'); ?>">
							<?php }
							else{ ?>
							<a href="<?php echo base_url('job-search'); ?>">
							<?php } ?>
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

									<span>Job Profile</span>
								</div>
							</a>
						</li>
						<?php
						if($job_deactive == 0  && $this->job_profile_set == 1)
						{ ?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" onclick="return getmsgNotification();">
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
									<span id="message_count" class="noti-box">1</span>
								</div>
								
							</a>
							<div class="dropdown-menu">
								<div class="dropdown-title">
									Messages <a id="seemsg" href="javascript:void(0)" class="pull-right"></a>
								</div>
								<div class="content custom-scroll">
									<ul class="dropdown-data msg-dropdown notification_data_in_h2">
									</ul>
								</div>
							</div>
						</li>
						<li class="dropdown user-id">
							<a href="#" class="dropdown-toggle user-id-custom" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
								
								<svg class="not-hover" viewBox="0 0 563.43 563.43" width="17px" height="17px">
									<path d="M280.79,314.559c83.266,0,150.803-67.538,150.803-150.803S364.055,13.415,280.79,13.415S129.987,80.953,129.987,163.756  S197.524,314.559,280.79,314.559z M280.79,52.735c61.061,0,111.021,49.959,111.021,111.021S341.851,274.776,280.79,274.776  s-111.021-49.959-111.021-111.021S219.728,52.735,280.79,52.735z" />
									<path d="M19.891,550.015h523.648c11.102,0,19.891-8.789,19.891-19.891c0-104.082-84.653-189.198-189.198-189.198H189.198  C85.116,340.926,0,425.579,0,530.124C0,541.226,8.789,550.015,19.891,550.015z M189.198,380.708h185.034  c75.864,0,138.313,56.436,148.028,129.524H41.17C50.884,437.607,113.334,380.708,189.198,380.708z" />
								</svg>
								<svg class="on-hover" width="17px" height="17px" viewBox="0 0 2133.000000 2133.000000">
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

								<span class="pr-name"><span class="none-sub-menu"> Account</span></span>
							</a>

							<ul class="dropdown-menu account">
								<li>Account</li>
								<li><a href="<?php echo base_url('job-profile/'.$jobdata[0]['slug']); ?>"><span class="icon-view-profile edit_data"></span>  View Profile </a></li>
								<li><a href="<?php echo base_url('job-profile/basic-information'); ?>"><span class="icon-edit-profile edit_data"></span>  Edit Profile </a></li>
								<!-- <li><a href="#" onclick="deactivate(<?php //echo $userid; ?>)"><span class="icon-delete edit_data"></span> Deactive Profile</a></li> -->
							</ul>
						</li>
						<?php } ?>
					</ul>
				</div>
				<div class="col-sm-6 col-md-6 col-xs-6 hidden-mob">
					<div class="job-search-box1 clearfix">
						<form onsubmit="jobsearchSubmit()" action="javascript:void(0)" method="get">
							<fieldset class="sec_h2">
								<input id="job_keyword" class="tags ui-autocomplete-input" name="job_keyword" ng-model="keyword" placeholder="Companies, Category, Products" autocomplete="off" type="text">
							</fieldset>
							<fieldset class="sec_h2">
								<input id="job_location" class="searchplace ui-autocomplete-input" name="job_location" ng-model="city" placeholder="Find Location" autocomplete="off" type="text">
							</fieldset>
							<fieldset class="new-search-btn">
								<label for="search_btn" id="search_f"><i class="fa fa-search" aria-hidden="true"></i></label>
								<input id="search_btn" style="display: none;" name="search_submit" value="Search" type="submit">
							</fieldset>
						</form>    
					</div>
				</div>
			</div>
		</div>

	</div>
</div>
<div class="mobile-header">
	<header class="">
		<div class="animated fadeInDownBig">
			<div class="container">

				<div class="left-header">
					<h2 class="logo"><a href="#"><img src="<?php echo base_url('assets/n-images/mob-logo.png?ver=' . time()) ?>"></a></h2>
					<div class="search-mob-block">
						
							<a href="#search">
								<input type="search" id="tags1" class="tags" name="skills" value="" placeholder="Job Title,Skill,Company" />
							</a>
						
						<div id="search">
							
							<form onsubmit="jobsearchSubmit()" action="javascript:void(0)" method="get">
								<div class="new-search-input">
									<input type="search" id="job_keyword" class="tags" name="job_keyword" value="" ng-model="keyword" placeholder="Job Title,Skill,Company" />
									<input type="search" ng-model="city" id="job_location" class="searchplace" name="job_location" value="" placeholder="Find Location" />
								</div>
				<div class="new-search-btn">
									<button type="button" class="close-new btn">Cancel</button>
									<button type="submit" id="search_btn" class="btn btn-primary" onclick="return check();">Search</button>
				</div>
							</form>
						</div>
					</div>
					<div class="right-header">
						<ul>
							<li class="dropdown user-id">
								<a href="#" class="dropdown-toggle user-id-custom" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="usr-img"><img src="<?php echo base_url('assets/img/user-pic.jpg?ver=' . time()) ?>"></span><span class="pr-name"></span></a>

								<ul class="dropdown-menu profile-dropdown">
									<li>Account</li>
									<li><a href="#"><i class="fa fa-cog"></i> Setting</a></li>
									<li><a href="#"><i class="fa fa-power-off"></i> Logout</a></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</header>
	<div class="sub-header">
		<div class="container">
			<div class="row">
				<ul class="sub-menu">
					<li class="profile">
						<a href="#">
							<span>Job Profile</span>
						</a>
					</li>
					<li class="dropdown">
						<a href="#">
							<span>Message</span> <span class="noti-box">1</span>
						</a>
					</li>
					<li class="dropdown user-id">
						<a href="#" class="dropdown-toggle user-id-custom" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
							<span class="pr-name"> Account</span>
						</a>
						<ul class="dropdown-menu account">
							<li>Account</li>
							<li><a href="<?php echo artist_dashboard. $arturl; ?>"><span class="icon-view-profile edit_data"></span>  View Profile </a></li>
							<li><a href="#"><i class="fa fa-cog"></i> Setting</a></li>
							<li><a href="#"><i class="fa fa-power-off"></i> Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	
	</div>
	<div class="mob-bottom-menu">
		<ul>
			<li>
				<div class="mob-btm-icon">
					<a href="<?php echo base_url() ?>" class="">
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
			
			<li>
				<div class="mob-btm-icon">
					<a href="#" class="">
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
			
			<li>
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
			
			<li>
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
		
		</ul>
	</div>

	
</div>

<div class="modal fade message-box biderror custom-message cust-err" id="bidmodal" role="dialog">
	<div class="modal-dialog modal-lm deactive">
	   <div class="modal-content message">
			<button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
			<div class="modal-body">
				<span class="mes"></span>
			</div>
		</div>
	</div>
</div> 
<script type="text/javascript">
	var segment = '<?php echo $this->uri->segment(1); ?>';
	$(document).ready(function() {
	 if (segment != "chat") {
		 chatmsg();
	 };
 });

 function chatmsg() {
	 $.ajax({
		 type: 'POST',
		 url: base_url + 'chat/userajax/1/2',
		 dataType: 'json',
		 data: '',
		 beforeSend: function() {
			 $('#msg_not_loader').show();
		 },
		 complete: function() {
			 $('#msg_not_loader').show();
		 },
		 success: function(data) { //alert(data);
			 $('#userlist').html(data.leftbar);
			 $('.notification_data_in_h2').html(data.headertwo);
			 $('#seemsg').html(data.seeall);
			 setTimeout(chatmsg, 100000);
		 },
		 error: function(XMLHttpRequest, textStatus, errorThrown) {}
	 });
 };

 function getmsgNotification() {
	 msgNotification();
 }

 function msgNotification() {
	 $.ajax({
		 url: base_url + "notification/update_msg_noti/1",
		 type: "POST",
		 success: function(data) {
			 data = JSON.parse(data);
		 }
	 });
 }
</script>
<script type="text/javascript" charset="utf-8">

	function addmsg1(type, msg)
	{
		if (msg == 0)
		{ 
			$("#message_count").html('');
			$("#message_count").removeAttr("style");
			$('#InboxLink').removeClass('msg_notification_available');
			document.getElementById('message_count').style.display = "none";
		} else
		{
			$('#message_count').html(msg);
			$('#InboxLink').addClass('msg_notification_available');
			$('#message_count').addClass('count_add noti-box');
			document.getElementById('message_count').style.display = "block";
			//alert("welcome");
		}
	}

	function waitForMsg1()
	{
		$.ajax({
			type: "GET",
			url: "<?php echo base_url(); ?>notification/select_msg_noti/1",

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
		waitForMsg1();

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
	//Deactivate Job Profile Start
	function deactivate(clicked_id) { 
		$('.biderror .mes').html("<div class='pop_content'> Are you sure you want to deactive your job profile?<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='deactivate_profile(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
		$('#bidmodal').modal('show');
	}

	function deactivate_profile(clicked_id){
		$.ajax({
			type: 'POST',
			url: base_url +'job/deactivate',
			data: 'id=' + clicked_id,
			success: function (data) {
				window.location= base_url;

			}
		});
	}

	function jobsearchSubmit(){
    
        var keyword = $("input[name='job_keyword']").val().toLowerCase().split(' ').join('+');
        var city = $("input[name='job_location']").val().toLowerCase().split(' ').join('+');

        var work_timing_fil = "";
        $('.work_timing-filter').each(function(){
            if(this.checked){
                var currentid = $(this).val();
                work_timing_fil += (work_timing_fil == "") ? currentid : "-" + currentid;
            }
        });        
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

        if(keyword[keyword.length - 1] == "-")
        {            
            keyword = keyword.slice(0,-1);
        }

        if (keyword == '' && city == '') {
            return false;
        } else if (keyword != '' && city == '') {
            window.location.href = base_url + 'jobs/search/' + keyword + '-jobs?work_timing='+work_timing_fil;
        } else if (keyword == '' && city != '') {
            window.location.href = base_url + 'jobs/search/jobs-in-' + city+'?work_timing='+work_timing_fil;
        } else {
            window.location.href = base_url + 'jobs/search/' + keyword + '-jobs-in-' + city+'?work_timing='+work_timing_fil;
        }
    }
</script>