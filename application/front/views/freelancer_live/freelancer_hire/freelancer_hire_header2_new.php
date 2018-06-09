<?php
$userid = $this->session->userdata('aileenuser');
?>
<div id="fh_mob_search" class="modal fade mob-search-popup" role="dialog">
	<form method="get">
		<div class="new-search-input">
			<input type="search" id="tags1" class="tags" name="skills" value="" placeholder="Job Title,Skill,Company" />
			<input type="search" id="searchplace1" class="searchplace" name="searchplace" value="" placeholder="Find Location" />
		</div>
		<div class="new-search-btn">
			<button type="button" class="close-new btn">Cancel</button>
			<button type="submit" id="search_btn" class="btn btn-primary" onclick="return check();">Search</button>
		</div>
	</form>
</div>
<?php echo $header_inner_profile ?>
<div class="web-header">
    <div class="sub-header">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mob-p0">
                    <ul class="sub-menu">
                        <li class="profile">
                            <a href="<?php echo base_url('hire-freelancer'); ?>" target="_self">
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

									<span>Employer Profile</span>
								</div>
							</a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" onclick="return getmsgNotification()">
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
                                    Messages <a href="javascript:void(0)" class="pull-right" id="seemsg"></a>
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
                                <li><a href="<?php echo base_url('freelance-employer/'. $free_hire_login_slug); ?>"><span class="icon-view-profile edit_data"></span>  View Profile </a></li>
                                <li><a href="<?php echo base_url('freelance-employer/basic-information'); ?>"><span class="icon-edit-profile edit_data"></span>  Edit Profile </a></li>
                                <!-- <li><a href="#" onclick="deactivate(<?php //echo $userid; ?>)"><span class="icon-delete edit_data"></span> Deactive Profile</a></li> -->
                            </ul>
                        </li>
						<li class="post-job-sh">
							<a href="<?php echo base_url('post-freelance-project'); ?>" title="Recruiter Add Post">
								
								<svg class="not-hover" viewBox="0 0 490.337 490.337" width="17px" height="17px">
								
									<g>
										<g>
											<path d="M229.9,145.379l-47.5,47.5c-17.5,17.5-35.1,35-52.5,52.7c-4.1,4.2-7.2,9.8-8.4,15.3c-6.3,28.9-12.4,57.8-18.5,86.7    l-3.4,16c-1.6,7.8,0.5,15.6,5.8,20.9c4.1,4.1,9.8,6.4,15.8,6.4c1.7,0,3.4-0.2,5.1-0.5l17.6-3.7c28-5.9,56.1-11.9,84.1-17.7    c6.5-1.4,12-4.3,16.7-9c78.6-78.7,157.2-157.3,235.8-235.8c5.8-5.8,9-12.7,9.8-21.2c0.1-1.4,0-2.8-0.3-4.1c-0.5-2-0.9-4.1-1.4-6.1    c-1.1-5.1-2.3-10.9-4.7-16.5l0,0c-14.7-33.6-39.1-57.6-72.5-71.1c-6.7-2.7-13.8-3.6-20-4.4l-1.7-0.2c-9-1.1-17.2,1.9-24.3,9.1    C320.4,54.879,275.1,100.179,229.9,145.379z M386.4,24.679c0.2,0,0.3,0,0.5,0l1.7,0.2c5.2,0.6,10,1.2,13.8,2.8    c27.2,11,47.2,30.6,59.3,58.2c1.4,3.2,2.3,7.3,3.2,11.6c0.3,1.6,0.7,3.2,1,4.8c-0.4,1.8-1.1,3-2.5,4.3    c-78.7,78.5-157.3,157.2-235.9,235.8c-1.3,1.3-2.5,1.9-4.3,2.3c-28.1,5.9-56.1,11.8-84.2,17.7l-14.8,3.1l2.8-13.1    c6.1-28.8,12.2-57.7,18.4-86.5c0.2-0.9,1-2.3,1.9-3.3c17.4-17.6,34.8-35.1,52.3-52.5l47.5-47.5c45.3-45.3,90.6-90.6,135.8-136    C384.8,24.979,385.7,24.679,386.4,24.679z" fill="#5c5c5c"/>
											<path d="M38.9,109.379h174.6c6.8,0,12.3-5.5,12.3-12.3s-5.5-12.3-12.3-12.3H38.9c-21.5,0-38.9,17.5-38.9,38.9v327.4    c0,21.5,17.5,38.9,38.9,38.9h327.3c21.5,0,38.9-17.5,38.9-38.9v-167.5c0-6.8-5.5-12.3-12.3-12.3s-12.3,5.5-12.3,12.3v167.5    c0,7.9-6.5,14.4-14.4,14.4H38.9c-7.9,0-14.4-6.5-14.4-14.4v-327.3C24.5,115.879,31,109.379,38.9,109.379z" fill="#5c5c5c"/>
										</g>
									</g>

									</svg>

								<svg class="on-hover" width="17px" height="17px" viewBox="0 0 2133.000000 2133.000000">
									<g transform="translate(0.000000,2133.000000) scale(0.100000,-0.100000)">
									<path d="M16608 21304 c-205 -31 -416 -130 -588 -273 -90 -75 -10401 -10400
									-10457 -10471 -110 -141 -190 -285 -242 -436 -17 -49 -58 -215 -91 -369 -156
									-719 -383 -1783 -616 -2885 -140 -663 -264 -1246 -275 -1297 -84 -387 2 -730
									242 -972 205 -205 515 -309 814 -272 50 6 518 101 1040 211 1964 415 2801 591
									3178 670 213 44 429 94 480 111 121 41 289 127 390 201 59 43 1566 1544 5308
									5287 5681 5681 5279 5271 5393 5500 90 179 146 402 146 581 0 86 -9 138 -66
									390 -110 488 -146 603 -280 891 -590 1273 -1522 2213 -2779 2806 -406 191
									-626 253 -1133 318 -212 28 -333 30 -464 9z"/>
									<path d="M1520 17639 c-369 -35 -724 -200 -997 -463 -144 -138 -253 -283 -337
									-445 -75 -147 -113 -252 -153 -417 l-28 -119 0 -7360 c0 -7159 1 -7362 19
									-7450 152 -732 720 -1263 1455 -1360 91 -13 1156 -15 7326 -15 4873 0 7249 4
									7310 10 209 24 398 81 585 176 164 84 290 175 420 304 294 291 460 642 500
									1055 7 74 10 1314 10 3795 0 4055 4 3755 -62 3890 -21 43 -55 89 -102 136
									-110 110 -219 154 -382 154 -230 0 -417 -129 -506 -348 l-23 -57 -5 -3760 -5
									-3760 -27 -81 c-71 -207 -248 -372 -451 -419 -58 -13 -860 -15 -7284 -13
									l-7218 3 -75 27 c-93 34 -195 104 -261 177 -63 70 -125 194 -144 288 -13 63
									-15 936 -13 7270 l3 7198 28 78 c78 221 263 383 482 422 68 12 644 14 3938 15
									l3858 0 76 25 c95 32 165 77 230 149 241 263 160 689 -160 846 -49 23 -108 44
									-147 50 -79 12 -7732 11 -7860 -1z"/>
									</g>
								</svg>

								<span class="pr-name"><span class="none-sub-menu"> Post Project</span></span>
							</a>
						</li>
					</ul>
                </div>
                <div class="col-sm-6 col-md-6 col-xs-6 hidden-mob">
                    <div class="job-search-box1 clearfix">
                        <form action="<?php echo base_url('freelance-employer/search'); ?>" method="get">
                            <fieldset class="sec_h2">
                                <input id="tags" class="tags ui-autocomplete-input skill_keyword" name="skills" placeholder="Companies, Category, Products" autocomplete="off" type="text">
                            </fieldset>
                            <fieldset class="sec_h2">
                                <input id="searchplace" class="searchplace ui-autocomplete-input skill_keyword" name="searchplace" placeholder="Find Location" autocomplete="off" type="text">
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
</div>
<div class="mobile-header">	
    <div class="sub-header">
		<div class="container">
			<div class="row">
				<ul class="sub-menu">
					<li class="profile">
						<a href="<?php echo base_url('hire-freelancer'); ?>" target="_self">
							<span>Employer Profile</span>
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
							<li><a href="<?php echo base_url('freelance-employer/'. $free_hire_login_slug); ?>"><span class="icon-view-profile edit_data"></span>  View Profile </a></li>
							<li><a href="<?php echo base_url('freelance-employer/basic-information'); ?>"><span class="icon-edit-profile edit_data"></span>  Edit Profile </a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>	
	</div>
   
	<div class="mob-post-job">
		<a href="<?php echo base_url('post-freelance-project'); ?>" title="Recruiter Add Post">
			<svg viewBox="0 0 490.337 490.337" width="17px" height="17px">
				<g>
					<g>
						<path d="M229.9,145.379l-47.5,47.5c-17.5,17.5-35.1,35-52.5,52.7c-4.1,4.2-7.2,9.8-8.4,15.3c-6.3,28.9-12.4,57.8-18.5,86.7    l-3.4,16c-1.6,7.8,0.5,15.6,5.8,20.9c4.1,4.1,9.8,6.4,15.8,6.4c1.7,0,3.4-0.2,5.1-0.5l17.6-3.7c28-5.9,56.1-11.9,84.1-17.7    c6.5-1.4,12-4.3,16.7-9c78.6-78.7,157.2-157.3,235.8-235.8c5.8-5.8,9-12.7,9.8-21.2c0.1-1.4,0-2.8-0.3-4.1c-0.5-2-0.9-4.1-1.4-6.1    c-1.1-5.1-2.3-10.9-4.7-16.5l0,0c-14.7-33.6-39.1-57.6-72.5-71.1c-6.7-2.7-13.8-3.6-20-4.4l-1.7-0.2c-9-1.1-17.2,1.9-24.3,9.1    C320.4,54.879,275.1,100.179,229.9,145.379z M386.4,24.679c0.2,0,0.3,0,0.5,0l1.7,0.2c5.2,0.6,10,1.2,13.8,2.8    c27.2,11,47.2,30.6,59.3,58.2c1.4,3.2,2.3,7.3,3.2,11.6c0.3,1.6,0.7,3.2,1,4.8c-0.4,1.8-1.1,3-2.5,4.3    c-78.7,78.5-157.3,157.2-235.9,235.8c-1.3,1.3-2.5,1.9-4.3,2.3c-28.1,5.9-56.1,11.8-84.2,17.7l-14.8,3.1l2.8-13.1    c6.1-28.8,12.2-57.7,18.4-86.5c0.2-0.9,1-2.3,1.9-3.3c17.4-17.6,34.8-35.1,52.3-52.5l47.5-47.5c45.3-45.3,90.6-90.6,135.8-136    C384.8,24.979,385.7,24.679,386.4,24.679z" fill="#5c5c5c"/>
						<path d="M38.9,109.379h174.6c6.8,0,12.3-5.5,12.3-12.3s-5.5-12.3-12.3-12.3H38.9c-21.5,0-38.9,17.5-38.9,38.9v327.4    c0,21.5,17.5,38.9,38.9,38.9h327.3c21.5,0,38.9-17.5,38.9-38.9v-167.5c0-6.8-5.5-12.3-12.3-12.3s-12.3,5.5-12.3,12.3v167.5    c0,7.9-6.5,14.4-14.4,14.4H38.9c-7.9,0-14.4-6.5-14.4-14.4v-327.3C24.5,115.879,31,109.379,38.9,109.379z" fill="#5c5c5c"/>
					</g>
				</g>
			</svg>
		</a>
	</div>	
</div>
<div class="sub-header-search">
	<div class="container">
		<div class="search-mob-block">
			<a href="#" data-toggle="modal" data-target="#fh_mob_search">
				<input type="search" id="tags1" class="tags" name="skills" value="" placeholder="Job Title,Skill,Company" />
			</a>
		</div>
	</div>
</div>


<!-- Bid-modal  -->
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
<!-- Model Popup Close -->
<script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>" ></script>
<script src="<?php echo base_url('assets/js/classie.js?ver=' . time()); ?>"></script>
<script type="text/javascript">
    function deactivate(clicked_id) {
        $('.biderror .mes').html("<div class='pop_content'> Are you sure you want to deactive your Freelancer Hire profile?<div class='model_ok_cancel'><a title='yes' class='okbtn' id=" + clicked_id + " onClick='deactivate_profile(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a title='No' class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
        $('#bidmodal').modal('show');
    }
    function deactivate_profile(clicked_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . "freelance-hire/deactivate" ?>',
            data: 'id=' + clicked_id,
            success: function (data) {
                window.location = "<?php echo base_url() ?>";

            }
        });
    }
</script>


<!-- all popup close close using esc start -->
<script type="text/javascript">
    $(document).on('keydown', function (e) {
        if (e.keyCode === 27) {
            $("#dropdown-content_hover").hide();
        }
    });
    $(document).on('keydown', function (e) {
        if (e.keyCode === 27) {
         
            $('#bidmodal').modal('hide');
        }
    });

</script>
<!-- all popup close close using esc end -->
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
            $('#message_count').addClass('count_add');
            document.getElementById('message_count').style.display = "block";
            //alert("welcome");
        }
    }

    function waitForMsg1()
    {
        $.ajax({
            type: "GET",
            url: "<?php echo base_url(); ?>notification/select_msg_noti/4",

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
<!-- script for fetch all unread message notification end-->

<!-- script for update all read msg notification start-->
<script type="text/javascript">
    
     $(document).ready(function () {
      
   var segment = '<?php echo "" . $this->uri->segment(1) . "" ?>';
   if(segment != "chat"){ chatmsg(); };
           });  // khyati chnages  start
 function chatmsg()
    {             
             // khyati chnages  start
       
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() . "chat/userajax/3/4" ?>',
                dataType: 'json',
                data: '',
                success: function (data) { //alert(data);

                    $('#userlist').html(data.leftbar);
                    $('.notification_data_in_h2').html(data.headertwo);
                    $('#seemsg').html(data.seeall);
                 setTimeout(
                        chatmsg,
                       10000000000000
                        );
                },
             error: function (XMLHttpRequest, textStatus, errorThrown) {
            }           
            });
          
            };

    function getmsgNotification() {
        msgNotification();
        //msgheader();
    }

    function msgNotification() {
        // first click alert('here'); 
        $.ajax({
            url: "<?php echo base_url(); ?>notification/update_msg_noti/4",
            type: "POST",
            //data: {uid: 12341234}, //this sends the user-id to php as a post variable, in php it can be accessed as $_POST['uid']
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
            data: 'message_from_profile=3&message_to_profile=4',
            success: function (data) {
                $('.' + 'notification_data_in_h2').html(data);
            }
        });

    }
</script>