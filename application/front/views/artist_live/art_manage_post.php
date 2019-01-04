<!DOCTYPE html>
<html lang="en" ng-app="artistDashboardApp" ng-controller="artistDashboardController">
    <head> 
        <title><?php echo $title; ?></title>
        <meta name="description" content="<?php echo $metadesc; ?>" />
        <?php echo $head; ?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/dragdrop/fileinput.css?ver='.time()); ?>">
        <link href="<?php echo base_url('assets/dragdrop/themes/explorer/theme.css?ver='.time()); ?>" media="all" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/video.css?ver='.time()); ?>">
    
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver='.time()); ?>">
       
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/artistic.css?ver='.time()); ?>">

        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/as-videoplayer/build/mediaelementplayer.css'); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>" />
        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()) ?>"></script>
        <style type="text/css">
            .two-images, .three-image, .four-image{
                height: auto !important;
            }
            .mejs__overlay-button {
                background-image: url("https://www.aileensoul.com/assets/as-videoplayer/build/mejs-controls.svg");
            }
            .mejs__overlay-loading-bg-img {
                background-image: url("https://www.aileensoul.com/assets/as-videoplayer/build/mejs-controls.svg");
            }
            .mejs__button > button {
                background-image: url("https://www.aileensoul.com/assets/as-videoplayer/build/mejs-controls.svg");
            }
       </style>
          
    <?php $this->load->view('adsense'); ?>
</head>
<!-- END HEADER -->
<body class="page-container-bg-solid page-boxed body-loader art-dash">
    <?php $this->load->view('page_loader'); ?>
    <div id="main_page_load" style="display: block;">    
        <?php echo $artistic_header2; ?>
        <section class="custom-row">
        <?php echo $artistic_common; ?>
            <div class="text-center tab-block">
                <div class="container mob-inner-page">
                   <a href="<?php echo site_url('artist/p/' . $get_url . '/photos'); ?>" title="Photo">
                        Photo
                    </a>
                   <a href="<?php echo site_url('artist/p/' . $get_url . '/videos'); ?>" title="Video">
                        Video
                    </a>
                   <a href="<?php echo site_url('artist/p/' . $get_url . '/audios'); ?>" title="Audio">
                        Audio
                    </a>
                    <a href="<?php echo site_url('artist/p/' . $get_url . '/pdf') ?>" title="Pdf">
                        PDf
                    </a>
                </div>
            </div>
			
  
            <div class="user-midd-section">
                <div class="container art_container padding-360 manage-post-custom">        
                    <div class="profile-box-custom left_side_posrt">
                        <!--div class="full-box-module business_data">
                            <div class="profile-boxProfileCard  module">
                               <div class="head_details1">
                                    <span>
                                        <a href="<?php echo base_url('artist/p/' . $this->uri->segment(3) .'/details'); ?>" title="Information">
                                            <h5>
                                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                Information
                                            </h5>
                                        </a>
                                    </span>
                                </div>
                                <table class="business_data_table">
                                    <tr>
                                        <td class="business_data_td1"><i class="fa fa-trophy" aria-hidden="true"></i></td>
                                        <td class="business_data_td2 123">
                                            {{artist_basic_info.art_category_txt}}
                                            <?php
                                           
                                            /*$art_othercategory = $this->db->select('other_category')->get_where('art_other_category', array('other_category_id' => $artisticdata[0]['other_skill']))->row()->other_category;

                                            $category = $artisticdata[0]['art_skill'];
                                            $category = explode(',' , $category);

                                            foreach ($category as $catkey => $catval) {
                                               $art_category = $this->db->select('art_category')->get_where('art_category', array('category_id' => $catval))->row()->art_category;
                                               $categorylist[] = ucwords($art_category);
                                             } 

                                            $listfinal1 = array_diff($categorylist, array('Other'));
                                            $listFinal = implode(',', $listfinal1);
                                               
                                            if(!in_array(26, $category)){
                                             echo $listFinal;
                                           }else if($artisticdata[0]['art_skill'] && $artisticdata[0]['other_skill']){

                                            $trimdata = $listFinal .','.ucwords($art_othercategory);
                                            echo trim($trimdata, ',');
                                           }
                                           else{
                                             echo ucwords($art_othercategory);  
                                          }*/
                                            ?>   
                                        </td>
                                    </tr>                                    
                                    <?php /*if($artisticdata[0]['art_yourart']){?>
                                    <tr>
                                        <td class="business_data_td1 detaile_map"><i class="fa fa-lightbulb-o" aria-hidden="true"></i></td>
                                        <td class="business_data_td2"><span><?php echo $artisticdata[0]['art_yourart']; ?></span></td>
                                    </tr>
                                     <?php }?>

                                    <?php if($artisticdata[0]['art_desc_art']){?>
                                    <tr>
                                        <td class="business_data_td1 detaile_map"><i class="fa fa-file-text" aria-hidden="true"></i></td>
                                        <td class="business_data_td2"><span><?php echo $this->common->make_links($artisticdata[0]['art_desc_art']); ?></span></td>
                                    </tr>
                                    <?php }?>
                                    <tr>
                                        <td class="business_data_td1 detaile_map"><i class="fa fa-envelope" aria-hidden="true"></i></td>
                                        <td class="business_data_td2">
        									<a href="mailto:<?php echo $artisticdata[0]['art_email']; ?>" title="<?php echo $artisticdata[0]['art_email']; ?>"><?php echo $artisticdata[0]['art_email']; ?></a>
        								</td>
                                    </tr>
                                    <tr>
                                        <td class="business_data_td1  detaile_map" ><i class="fa fa-map-marker" aria-hidden="true"></i></td>
                                        <td class="business_data_td2">
                                            <span>
                                                <?php
                                                if ($artisticdata[0]['art_city']) {
                                                    echo $this->db->select('city_name')->select('city_name')->get_where('cities', array('city_id' => $artisticdata[0]['art_city']))->row()->city_name;
                                                    echo",";
                                                }
                                                ?> 
                                                <?php
                                                if ($artisticdata[0]['art_country']) {
                                                    echo $this->db->select('country_name')->select('country_name')->get_where('countries', array('country_id' => $artisticdata[0]['art_country']))->row()->country_name;
                                                }
                                                ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php */ ?>
                                </table>
                            </div>
                        </div-->
                        
						
						
        				<div class="left-info-box art-info move-middle">
							<div class="dash-left-title">
								<h3><i class="fa fa-info-circle"></i> Information</h3>
							</div>
            				<div class="dash-info-box" ng-if="user_bio != ''">
            					<h4>								
                                    <svg viewBox="0 0 60 60" width="17px" height="17px" stroke-width="0.5" stroke="#5c5c5c">
                                        <g>
                                        	<path d="M38.914,0H6.5v60h47V14.586L38.914,0z M39.5,3.414L50.086,14H39.5V3.414z M8.5,58V2h29v14h14v42H8.5z" fill="#5c5c5c"/>
                                        	<path d="M42.5,21h-16c-0.552,0-1,0.447-1,1s0.448,1,1,1h16c0.552,0,1-0.447,1-1S43.052,21,42.5,21z" fill="#5c5c5c"/>
                                        	<path d="M22.875,18.219l-4.301,3.441l-1.367-1.367c-0.391-0.391-1.023-0.391-1.414,0s-0.391,1.023,0,1.414l2,2   C17.987,23.901,18.243,24,18.5,24c0.22,0,0.441-0.072,0.624-0.219l5-4c0.432-0.346,0.501-0.975,0.156-1.406   C23.936,17.943,23.306,17.874,22.875,18.219z" fill="#5c5c5c"/>
                                        	<path d="M42.5,32h-16c-0.552,0-1,0.447-1,1s0.448,1,1,1h16c0.552,0,1-0.447,1-1S43.052,32,42.5,32z" fill="#5c5c5c"/>
                                        	<path d="M22.875,29.219l-4.301,3.441l-1.367-1.367c-0.391-0.391-1.023-0.391-1.414,0s-0.391,1.023,0,1.414l2,2   C17.987,34.901,18.243,35,18.5,35c0.22,0,0.441-0.072,0.624-0.219l5-4c0.432-0.346,0.501-0.975,0.156-1.406   C23.936,28.943,23.306,28.874,22.875,29.219z" fill="#5c5c5c"/>
                                        	<path d="M42.5,43h-16c-0.552,0-1,0.447-1,1s0.448,1,1,1h16c0.552,0,1-0.447,1-1S43.052,43,42.5,43z" fill="#5c5c5c"/>
                                        	<path d="M22.875,40.219l-4.301,3.441l-1.367-1.367c-0.391-0.391-1.023-0.391-1.414,0s-0.391,1.023,0,1.414l2,2   C17.987,45.901,18.243,46,18.5,46c0.22,0,0.441-0.072,0.624-0.219l5-4c0.432-0.346,0.501-0.975,0.156-1.406   C23.936,39.943,23.306,39.874,22.875,40.219z" fill="#5c5c5c"/>
                                        </g>
                                    </svg>
                                Bio</h4>
                                <p class="inner-dis" dd-text-collapse dd-text-collapse-max-length="100" dd-text-collapse-text="{{user_bio}}" dd-text-collapse-cond="true">{{user_bio}}</p>
                            </div>
                            <div class="dash-info-box" ng-if="user_bio != ''">
            					<h4>
                                    <svg width="17px" height="18px" viewBox="0 0 400 400"><g id="svgg"><path id="path0" d="M61.704 0.211 C 36.639 2.851,21.936 20.830,17.529 54.227 C 16.272 63.754,16.117 66.948,16.117 83.193 C 16.117 161.458,45.160 256.982,89.011 322.947 C 129.769 384.259,177.916 410.230,225.522 396.583 C 265.036 385.256,303.703 345.261,334.407 283.960 C 339.877 273.039,343.886 264.236,343.499 263.996 C 343.331 263.892,343.747 262.565,344.462 260.917 C 345.586 258.330,355.517 232.150,356.099 230.238 C 356.228 229.816,356.717 228.642,357.186 227.629 C 363.466 214.064,374.493 170.599,378.798 142.441 C 388.707 77.627,384.295 32.929,366.079 13.579 C 350.647 -2.815,329.327 -4.165,280.890 8.184 C 276.585 9.282,270.368 10.864,267.076 11.700 C 246.134 17.018,217.879 20.946,200.307 20.985 C 180.255 21.028,150.604 16.645,126.157 10.023 C 96.952 2.112,75.158 -1.205,61.704 0.211 M78.281 21.339 C 92.080 22.953,102.554 25.027,116.400 28.887 C 149.976 38.247,185.748 43.044,210.130 41.458 C 232.463 40.005,252.636 36.822,273.830 31.409 C 304.818 23.495,316.447 21.171,327.552 20.674 C 350.398 19.651,359.219 30.788,362.604 64.927 C 363.120 70.134,363.121 91.350,362.606 98.695 C 356.973 179.011,331.813 255.588,292.021 313.521 C 263.714 354.733,237.079 374.709,205.526 378.391 C 161.957 383.475,112.499 337.145,77.550 258.508 C 75.943 254.894,74.483 251.846,74.305 251.736 C 73.739 251.386,67.562 236.238,64.100 226.708 C 52.745 195.452,44.495 161.908,40.394 130.315 C 32.357 68.399,37.409 31.705,55.104 23.469 C 61.376 20.549,67.061 20.027,78.281 21.339 M109.900 111.881 C 92.689 114.121,82.398 120.392,78.891 130.775 C 73.028 148.137,92.928 168.238,121.735 174.051 C 157.984 181.366,184.137 167.763,178.182 144.690 C 175.139 132.900,157.039 118.869,139.678 114.840 C 138.074 114.468,135.364 113.829,133.656 113.421 C 126.079 111.610,116.665 111.000,109.900 111.881 M275.211 111.793 C 271.679 112.191,260.536 114.558,256.789 115.706 C 245.083 119.292,234.570 126.150,226.866 135.226 C 217.560 146.189,219.502 161.158,231.264 169.130 C 247.245 179.962,279.707 178.036,301.694 164.952 C 321.242 153.319,327.373 136.765,316.986 123.659 C 310.368 115.309,291.513 109.953,275.211 111.793 M124.482 133.087 C 137.457 134.886,145.321 138.072,153.161 144.705 C 157.804 148.632,158.853 150.456,157.164 151.658 C 152.635 154.883,138.351 156.561,130.468 154.794 C 117.574 151.904,114.035 150.601,107.856 146.468 C 104.567 144.268,99.342 139.425,98.905 138.172 C 97.519 134.197,111.887 131.340,124.482 133.087 M291.486 133.044 C 295.679 133.930,300.543 135.995,300.953 137.063 C 301.691 138.986,294.158 145.663,287.299 149.165 C 281.877 151.933,272.484 154.571,265.197 155.371 C 255.511 156.434,240.780 152.950,241.934 149.869 C 242.893 147.307,250.340 141.303,256.208 138.361 C 265.432 133.737,282.549 131.157,291.486 133.044 M255.557 236.639 C 252.424 238.121,251.082 239.931,249.576 244.708 C 236.404 286.487,164.136 287.158,150.531 245.627 C 147.978 237.832,141.896 234.588,135.533 237.626 C 127.439 241.490,128.252 252.558,137.662 266.585 C 169.824 314.525,255.731 303.718,269.694 249.974 C 271.799 241.873,267.639 235.764,260.015 235.764 C 257.784 235.764,257.138 235.891,255.557 236.639 " stroke="none" fill="#5c5c5c" fill-rule="evenodd"></path><path id="path1" d="" stroke="none" fill="#605c5c" fill-rule="evenodd"></path><path id="path2" d="" stroke="none" fill="#605c5c" fill-rule="evenodd"></path><path id="path3" d="" stroke="none" fill="#605c5c" fill-rule="evenodd"></path><path id="path4" d="" stroke="none" fill="#605c5c" fill-rule="evenodd"></path></g></svg>
                                Category</h4>
                                <p>{{artist_basic_info.art_category_txt}}</p>
                            </div>
            				<div class="dash-info-box">
            					<h4>
                                    <svg viewBox="0 0 31.012 31.012" width="18px" height="17px" stroke-width="0.5" stroke="#5c5c5c">
                                        <g> 
                                        	<path d="M28.512,26.529H2.5c-1.378,0-2.5-1.121-2.5-2.5V6.982c0-1.379,1.122-2.5,2.5-2.5h26.012c1.378,0,2.5,1.121,2.5,2.5v17.047   C31.012,25.408,29.89,26.529,28.512,26.529z M2.5,5.482c-0.827,0-1.5,0.673-1.5,1.5v17.047c0,0.827,0.673,1.5,1.5,1.5h26.012   c0.827,0,1.5-0.673,1.5-1.5V6.982c0-0.827-0.673-1.5-1.5-1.5H2.5z" fill="#5c5c5c"></path>
                                        	<path d="M15.506,18.018c-0.665,0-1.33-0.221-1.836-0.662L0.891,6.219c-0.208-0.182-0.23-0.497-0.048-0.705   c0.182-0.21,0.498-0.23,0.706-0.049l12.778,11.137c0.64,0.557,1.72,0.556,2.358,0L29.46,5.466c0.207-0.183,0.522-0.162,0.706,0.049   c0.182,0.208,0.16,0.523-0.048,0.705L17.342,17.355C16.836,17.797,16.171,18.018,15.506,18.018z" fill="#5c5c5c"></path>
                                        </g>
                                    </svg>
                                Email id</h4>
            					<p>{{artist_basic_info.art_email}}</p>
            				</div>
            				<div class="dash-info-box">
            					<h4>
								<svg viewBox="0 0 54.757 54.757" width="16px" height="17x" stroke-width="0.5" stroke="#5c5c5c">
                                    <g>
                                    	<path d="M27.557,12c-3.859,0-7,3.141-7,7s3.141,7,7,7s7-3.141,7-7S31.416,12,27.557,12z M27.557,24c-2.757,0-5-2.243-5-5   s2.243-5,5-5s5,2.243,5,5S30.314,24,27.557,24z" fill="#5c5c5c"></path>
                                    	<path d="M40.94,5.617C37.318,1.995,32.502,0,27.38,0c-5.123,0-9.938,1.995-13.56,5.617c-6.703,6.702-7.536,19.312-1.804,26.952   L27.38,54.757L42.721,32.6C48.476,24.929,47.643,12.319,40.94,5.617z M41.099,31.431L27.38,51.243L13.639,31.4   C8.44,24.468,9.185,13.08,15.235,7.031C18.479,3.787,22.792,2,27.38,2s8.901,1.787,12.146,5.031   C45.576,13.08,46.321,24.468,41.099,31.431z" fill="#5c5c5c"></path>
                                    </g>
                                </svg>Location </h4>
                                <p ng-if="artist_basic_info.country_name || artist_basic_info.state_name || artist_basic_info.city_name">
                                    {{artist_basic_info.city_name != '' ? artist_basic_info.city_name : ''}}
                                    {{artist_basic_info.city_name != '' && artist_basic_info.state_name != '' ? ',' : ''}}
                                    {{artist_basic_info.state_name != '' ? artist_basic_info.state_name : ''}}
                                    {{artist_basic_info.state_name != '' && artist_basic_info.country_name != '' ? ',' : ''}}
                                    {{artist_basic_info.country_name != '' ? artist_basic_info.country_name : ''}}
                                </p>
            				</div>

                            <div class="dash-info-box" ng-if="user_experience.length > '0'">
            					<h4>
    								<svg id="Layer_1" viewBox="0 0 512 512" width="17px" height="16px" stroke-width="0.5" stroke="#5c5c5c">
                                        <g>
                                        	<g>
                                        		<path d="M469.333,106.667H362.667V85.333c0-23.531-19.135-42.667-42.667-42.667H192c-23.531,0-42.667,19.135-42.667,42.667v21.333    H42.667C19.135,106.667,0,125.802,0,149.333v277.333c0,23.531,19.135,42.667,42.667,42.667h426.667    c23.531,0,42.667-19.135,42.667-42.667V149.333C512,125.802,492.865,106.667,469.333,106.667z M170.667,85.333    C170.667,73.573,180.24,64,192,64h128c11.76,0,21.333,9.573,21.333,21.333v21.333H170.667V85.333z M490.667,426.667    c0,11.76-9.573,21.333-21.333,21.333H42.667c-11.76,0-21.333-9.573-21.333-21.333V271.4c6.301,3.674,13.527,5.934,21.333,5.934    h170.667v32c0,5.896,4.771,10.667,10.667,10.667h64c5.896,0,10.667-4.771,10.667-10.667v-32h170.667    c7.806,0,15.033-2.259,21.333-5.934V426.667z M234.667,298.667V256h42.667v42.667H234.667z M490.667,234.667    c0,11.76-9.573,21.333-21.333,21.333H298.667v-10.667c0-5.896-4.771-10.667-10.667-10.667h-64    c-5.896,0-10.667,4.771-10.667,10.667V256H42.667c-11.76,0-21.333-9.573-21.333-21.333v-85.333    c0-11.76,9.573-21.333,21.333-21.333h426.667c11.76,0,21.333,9.573,21.333,21.333V234.667z" fill="#5c5c5c"></path>
                                        	</g>
                                        </g>
                                    </svg>
                                Experience</h4>
                                <ul>
            						<li ng-repeat="user_exp in user_experience">{{user_exp.designation}} at {{user_exp.exp_company_name}}</li>
            					</ul>
            				</div>

                            <div class="dash-info-box" ng-if="user_award.length > '0'">
            					<h4>								
                                    <svg viewBox="0 0 512 512" width="17px" height="16px">
                                        <g>
                                            <path fill="#5c5c5c" d="m476.4,38.7c-13.3-17.6-33.9-27.7-56.6-27.7h-327.6c-22.7,0-43.3,10.1-56.6,27.7-12.5,16.5-16.4,37.3-10.8,56.9 21.4,75.5 110.8,129.2 164.1,146.4l56.6,56.6v60.5h-136.4c-5.8,0-10.4,4.7-10.4,10.4v121c0,5.8 4.7,10.4 10.4,10.4h293.8c5.8,0 10.4-4.7 10.4-10.4v-121c0-5.8-4.7-10.4-10.4-10.4h-136.5v-60.5l56.6-56.6c53.4-17.2 142.7-70.9 164.2-146.4 5.6-19.6 1.7-40.4-10.8-56.9zm-83.9,441.4h-273v-100.1h273v100.1zm-347.7-390.2c-3.8-13.3-1.1-27.5 7.4-38.6 18-23.6 46.7-19.4 46.7-19.4-2.5,62.8 17.3,123.9 55.6,172.9-44.9-23.6-95.2-63.8-109.7-114.9zm276.6,124.2l-65.4,65.5-65.4-65.4c-48.2-48.2-73.7-114.2-70.8-182.3h272.5c2.9,68-22.6,134-70.9,182.2zm145.8-124.2c-14.5,51-64.7,91.3-109.7,114.8 38.3-49 58.1-110.1 55.6-172.8 0,0 29.3-4 46.7,19.4 8.4,11.3 11.2,25.3 7.4,38.6z"/>
                                        </g>
                                    </svg>
                                Achievements & Awards </h4>
            					<ul>
            						<li ng-repeat="_user_award in user_award">{{_user_award.award_title}} ({{_user_award.award_date | limitTo:4}})</li>
            					</ul>
            				</div>
							
							<div class="dash-info-box" ng-if="art_talent_cat">
            					<h4>
                                    <svg width="17px" height="16px" viewBox="0 0 475.299 475.299" stroke-width="3" stroke="#5c5c5c">
                                        <g>
                                        	<path d="M458.159,86.986H169.971c-9.453,0-17.14,7.688-17.14,17.141v75.12H17.141C7.688,179.247,0,186.935,0,196.385v174.783   c0,9.458,7.688,17.145,17.141,17.145h288.185c9.458,0,17.14-7.687,17.14-17.145v-75.119h135.694c9.45,0,17.14-7.684,17.14-17.139   V104.127C475.291,94.674,467.605,86.986,458.159,86.986z M305.656,371.168c0,0.181-0.145,0.334-0.331,0.334l-288.509-0.334   l0.331-175.112l288.509,0.329V371.168z M458.481,278.91c0,0.181-0.146,0.329-0.332,0.329l-135.685-0.153v-82.701   c0-9.45-7.694-17.138-17.145-17.138H169.826l0.141-75.451l288.51,0.331V278.91H458.481z" fill="#5c5c5c"/>
                                        </g>
                                    </svg>
                                Type of Talent</h4>
                                <ul class="skill-list">
            						<li ng-repeat="tal_cat in art_talent_cat.split(',')">{{tal_cat}}</li>
            					</ul>
            				</div>

            				<div class="dash-info-box" ng-if="art_speciality_data.art_spl_tags || art_speciality_data.art_spl_desc">
            					<h4>
                                    <svg viewBox="0 0 487.222 487.222" width="17px" height="16px">
                                        <g>
                                        	<path d="M486.554,186.811c-1.6-4.9-5.8-8.4-10.9-9.2l-152-21.6l-68.4-137.5c-2.3-4.6-7-7.5-12.1-7.5l0,0c-5.1,0-9.8,2.9-12.1,7.6   l-67.5,137.9l-152,22.6c-5.1,0.8-9.3,4.3-10.9,9.2s-0.2,10.3,3.5,13.8l110.3,106.9l-25.5,151.4c-0.9,5.1,1.2,10.2,5.4,13.2   c2.3,1.7,5.1,2.6,7.9,2.6c2.2,0,4.3-0.5,6.3-1.6l135.7-71.9l136.1,71.1c2,1,4.1,1.5,6.2,1.5l0,0c7.4,0,13.5-6.1,13.5-13.5   c0-1.1-0.1-2.1-0.4-3.1l-26.3-150.5l109.6-107.5C486.854,197.111,488.154,191.711,486.554,186.811z M349.554,293.911   c-3.2,3.1-4.6,7.6-3.8,12l22.9,131.3l-118.2-61.7c-3.9-2.1-8.6-2-12.6,0l-117.8,62.4l22.1-131.5c0.7-4.4-0.7-8.8-3.9-11.9   l-95.6-92.8l131.9-19.6c4.4-0.7,8.2-3.4,10.1-7.4l58.6-119.7l59.4,119.4c2,4,5.8,6.7,10.2,7.4l132,18.8L349.554,293.911z" fill="#5c5c5c"></path>
                                        </g>
                                    </svg>
                                Specialities</h4>
                                <ul class="skill-list" ng-if="art_speciality_data.art_spl_tags != ''">
            						<li ng-repeat="speciality in art_speciality_data.art_spl_tags.split(',')">{{speciality}}</li>
                                </ul>
                            </div>
                        </div>

                        <a class="fw" href="<?php echo site_url('artist/p/' . $get_url . '/photos'); ?>" title="Photos">
                            <div class="full-box-module business_data" id="autorefresh">
                                <div class="profile-boxProfileCard  module buisness_he_module" style="">
                                    <div class="head_details">
                                        <h5><i class="fa fa-camera" aria-hidden="true"></i>Photos</h5>
                                    </div>  
                                    <div class="art_photos">
                                         <div class="fw" id="loader" style="text-align:center;"><img src="<?php echo base_url('assets/images/loader.gif?ver='.time()) ?>" alt="<?php echo "loader.gif"; ?>"/></div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a class="fw" href="<?php echo site_url('artist/p/' . $get_url . '/videos'); ?>" title="Video">
                            <div class="full-box-module business_data">
                                <div class="profile-boxProfileCard  module">
                                    <table class="business_data_table">
                                        <div class="head_details">
                                             <h5><i class="fa fa-video-camera" aria-hidden="true"></i>  Video</h5>
                                        </div>  
                                        <div class="art_videos">
                                             <div class="fw" id="loader" style="text-align:center;"><img src="<?php echo base_url('assets/images/loader.gif?ver='.time()) ?>" alt="<?php echo "loader.gif"; ?>"/></div>
                                        </div>
                                    </table>
                                </div>
                            </div>
                        </a>
                        <div class="full-box-module business_data fw">
                            <div class="profile-boxProfileCard  module">
                                <table class="business_data_table">
                                     <a href="<?php echo site_url('artist/p/' . $get_url . '/audios'); ?>"> 
                                    <div class="head_details">
                                         <h5><i class="fa fa-music" aria-hidden="true"></i>  Audio</h5>
                                    </div>
                                     </a>
                                    <div class="art_audios">
                                         <div class="fw" id="loader" style="text-align:center;"><img src="<?php echo base_url('assets/images/loader.gif?ver='.time()) ?>" alt="<?php echo "loader.gif"; ?>"/></div>
                                    </div>
                                </table>
                            </div>
                        </div>
                     
                        <a class="fw" href="<?php echo site_url('artist/p/' . $get_url . '/pdf') ?>" title="Pdf">
                            <div class="full-box-module business_data">
                                <div class="profile-boxProfileCard  module pdf_box">
                                    <table class="business_data_table">
                                        <div class="head_details">
                                             <h5><i class="fa fa-file-pdf-o" aria-hidden="true"></i>  PDF</h5>
                                        </div>
                                        <div class="art_pdf">
                                             <div class="fw" id="loader" style="text-align:center;"><img src="<?php echo base_url('assets/images/loader.gif?ver='.time()) ?>" alt="<?php echo "loader.gif"; ?>"/></div>
                                        </div>
                                    </table>
                                </div>
                            </div>
        				</a>
        				<?php $this->load->view('right_add_box'); ?>
        				
        				<?php echo $left_footer; ?>
                        
                    </div>
                    
        			
        			
        			<!-- popup start -->
                    <div class=" custom-right-art mian_middle_post_box animated fadeInUp custom-right-business"  >
            			<div class="tab-add">
            				<?php $this->load->view('banner_add'); ?>
            			</div> 
                        <?php
                        if($login_art_data[0]['user_id'] == $artisticdata[0]['user_id']):
                        ?>
						<div class="mob-progressbar">
							<p>Complete your profile to get connected with more people.</p>
							<p class="mob-edit-pro">
								<a href="<?php echo artist_dashboard. $get_url.'/details'; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit Profile</a>
							</p>
							<div class="progress skill-bar ">
								<div class="progress-bar progress-bar-custom" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100" style="width:0%;">
									<span class="skill"><i class="val">0%</i></span>
								</div>
							</div>
						</div>
                        <?php
                        endif;
                        ?>
						<div id="move-availability" class="">
						</div>
						<div id="move-middle" class="">
						</div>
						
						<div id="move-website" class="">
						</div>
                        <!-- The Modal -->
                        <div id="myModal3" class="modal-post">
                            <!-- Modal content -->
                            <div class="modal-content-post">
                                <span class="close3">&times;</span>
                                <div class="post-editor col-md-12 post-edit-popup" id="close">
                                    <?php echo form_open_multipart(base_url('artist/art_post_insert/' . 'manage/' . $artisticdata[0]['user_id']), array('id' => 'artpostform', 'name' => 'artpostform', 'class' => 'clearfix upload-image-form', 'onsubmit' => "return imgval(event);")); ?>
                                    <div class="main-text-area col-md-12" >
                                        <div class="popup-img-in ">
                                            <?php 
                                            if (IMAGEPATHFROM == 'upload') {
                                                if($artisticdata[0]['art_user_image']){
                                                    if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $artisticdata[0]['art_user_image'])) { ?>
                                                        <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="<?php echo "NOARTIMAGE"; ?>">
                                                    <?php } else { ?>
                                                        <img  src="<?php echo ART_PROFILE_THUMB_UPLOAD_URL . $artisticdata[0]['art_user_image']; ?>"  alt="<?php echo $artisticdata[0]['art_user_image']; ?>">
                                                    <?php }
                                                } else{ ?>
                                                    <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="<?php echo "NOARTIMAGE"; ?>">
                                                <?php 
                                                } 
                                            }
                                            else
                                            {
                                                $filename = $this->config->item('art_profile_thumb_upload_path') . $artisticdata[0]['art_user_image'];
                                                $s3 = new S3(awsAccessKey, awsSecretKey);
                                                $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                                if ($info) { ?>
                                                    <img  src="<?php echo ART_PROFILE_THUMB_UPLOAD_URL . $artisticdata[0]['art_user_image']; ?>"  alt="<?php echo $artisticdata[0]['art_user_image']; ?>">
                                                    <?php
                                                }
                                                else
                                                { ?>
                                                    <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="<?php echo "NOARTIMAGE"; ?>">
                                                <?php
                                                }
                                            }?>
                                        </div>
                                        <div id="myBtn3"    class="editor-content col-md-10 popup-text" >
                                            <textarea id= "test-upload-product" placeholder="Post Your Art...."  onKeyPress=check_length(this.form); onKeyDown=check_length(this.form);  onkeyup=check_length(this.form); onblur=check_length(this.form); name=my_text rows=4 cols=30 class="post_product_name"></textarea>
                                            <div class="fifty_val">  
                                                <input size=1 class="text_num" tabindex="-500" value=50 name=text_num readonly> 
                                            </div>
                                            <div class="camera_in padding-left padding_les_left camer_h">
                                                <i class=" fa fa-camera" ></i> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row"></div>
                                    <div  id="text"  class="editor-content col-md-12 popup-textarea" >
                                        <textarea id="test-upload-des" name="product_desc" class="description" placeholder="Enter Description"></textarea>
                                        <output id="list"></output>
                                    </div>
                                    <div class="popup-social-icon">
                                        <ul class="editor-header">
                                            <li>
                                                <div class="col-md-12"> <div class="form-group">
                                                        <input id="file-1" type="file" class="file" name="postattach[]"  multiple class="file" data-overwrite-initial="false" data-min-file-count="2" style="visibility:hidden;">
                                                    </div></div>
                                                <label for="file-1">
                                                       <i class=" fa fa-camera upload_icon"  ><span class="upload_span_icon"> Photo</span></i>
                                                       <i class=" fa fa-video-camera upload_icon"  ><span class="upload_span_icon"> Video </span></i>
                                                       <i class="fa fa-music upload_icon "  ><span class="upload_span_icon"> Audio </span></i>
                                                       <i class=" fa fa-file-pdf-o upload_icon"  > <span class="upload_span_icon">PDF </span></i>
                                                 </label>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="fr">
                                        <button type="submit"  value="Submit" style="margin: 0px;">Post</button>    </div>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                        </div>
                        <!-- popup end -->
                        <div class="bs-example">
                            <div class="progress progress-striped" id="progress_div">
                                <div class="progress-bar" style="width: 0%;">
                                    <span class="sr-only">0%</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="art-all-post">
                        </div>

            			 <div class="banner-add">
            				<?php $this->load->view('banner_add'); ?>
            			</div>
                        <div class="fw" id="loader" style="text-align:center;">
                            <img src="<?php echo base_url('assets/images/loader.gif?ver='.time()) ?>" alt="<?php echo "loader.gif"; ?>"/>
                        </div>
                    </div>           
        			
        			<div class="right-part right-scroll">
						<div class="right-info-box art-info av-cus move-availability">
							<div class="dash-info-box" ng-if="art_imp_data  == '1' || art_imp_data  == '2' || art_imp_data  == '3'">
            					<!-- <h4>Availability </h4> -->
                                <span ng-if="art_imp_data == '1'"><span class="job-active"></span>Open for work</span>
                                <span ng-if="art_imp_data == '2'"><span class="job-passive"></span>Open for Collaboration</span>
            					<span ng-if="art_imp_data == '3'"><span class="job-not"></span>Not now</span>
            				</div>
						</div>
        				<?php $this->load->view('right_add_box');
                        if($login_art_data[0]['user_id'] == $artisticdata[0]['user_id']):
                        ?>   
                        <div id="profile-progress" class="edit_profile_progress right-add-box" style="display: none;">
                            <div class="count_main_progress">
                                <div class="circles">  
                                    <div class="second circle-1">
                                        <div>
                                            <strong></strong>
                                            <span id="progress-txt"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
						<div class="move-website">
        				<div class="right-info-box" ng-if="user_social_links.length > '0' || user_personal_links.length > '0'">
							
							<div class="dtl-dis">
                                <div class="social-links" ng-if="user_social_links.length > '0'">
                                    <h4>Social</h4>
                                    <ul class="social-link-list">
                                        <li ng-repeat="social_links in user_social_links">
                                            <a href="{{social_links.user_links_txt}}" target="_self">
                                                <img ng-if="social_links.user_links_type == 'Facebook'" src="<?php echo base_url(); ?>assets/n-images/detail/fb.png">
                                                <img ng-if="social_links.user_links_type == 'Google'" src="<?php echo base_url(); ?>assets/n-images/detail/g-plus.png">
                                                <img ng-if="social_links.user_links_type == 'LinkedIn'" src="<?php echo base_url(); ?>assets/n-images/detail/in.png">
                                                <img ng-if="social_links.user_links_type == 'Pinterest'" src="<?php echo base_url(); ?>assets/n-images/detail/pin.png">
                                                <img ng-if="social_links.user_links_type == 'Instagram'" src="<?php echo base_url(); ?>assets/n-images/detail/insta.png">
                                                <img ng-if="social_links.user_links_type == 'GitHub'" src="<?php echo base_url(); ?>assets/n-images/detail/git.png">
                                                <img ng-if="social_links.user_links_type == 'Twitter'" src="<?php echo base_url(); ?>assets/n-images/detail/twt.png">
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="social-links" ng-if="user_personal_links.length > '0'">
                                    <h4 class="pt20">Personal</h4>
                                    <ul class="social-link-list">
                                        <li ng-repeat="user_p_links in user_personal_links">
                                            <a href="{{user_p_links.user_links_txt}}" target="_self">
                                                <img src="<?php echo base_url(); ?>assets/n-images/detail/pr-web.png">
                                            </a>
                                        </li>
                                    </ul>
                                </div>
							</div>
						</div>
						</div>
					</div>
                </div>
            </div>
        </section>
        <div class="modal fade message-box" id="bidmodal-2" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>         
                    <div class="modal-body">
                        <span class="mes">
                            <div id="popup-form">
                             <form id ="userimage" name ="userimage" class ="clearfix" enctype="multipart/form-data" method="post">
                               <div class=" ">

                               <div class="fw" id="loaderfollow" style="text-align:center; display: none;"><img src="<?php echo base_url('assets/images/loader.gif?ver='.time()) ?>" alt="<?php echo "loader.gif"; ?>" /></div>

                                        <input type="file" name="profilepic" accept="image/gif, image/jpeg, image/png" id="upload-one">
                                    </div>
                                    <div class="col-md-7 text-center">
                                        <div id="upload-demo-one" style="width:350px; display: none"></div>
                                    </div>
                                <input type="submit"  class="upload-result-one" name="profilepicsubmit" id="profilepicsubmit" value="Save">
                                </form>
                            </div>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade message-box biderror" id="bidmodal-limit" role="dialog">
            <div class="modal-dialog modal-lm deactive">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal" id="common-limit">&times;</button>       
                    <div class="modal-body">
                        <span class="mes"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade message-box biderror" id="profileimage" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal" id="profileimage">&times;</button>       
                    <div class="modal-body">
                        <span class="mes"></span>
                    </div>
                </div>
            </div>
        </div>
         <div class="modal fade message-box" id="postedit" role="dialog">
                <div class="modal-dialog modal-lm">
                    <div class="modal-content">
                        <button type="button" class="modal-close" id="postedit"data-dismiss="modal">&times;</button>       
                        <div class="modal-body">
                            <span class="mes">
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        <div class="modal fade message-box" id="likeusermodal" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes">
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade message-box" id="post" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" id="post" data-dismiss="modal">&times;</button>     <div class="modal-body">
                        <span class="mes">
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade message-box" id="image" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" id="image" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes">
                        </span>
                    </div>
                </div>
            </div>
        </div>  
        <div class="modal fade message-box biderror" id="bidmodaleditpost" role="dialog"  >
            <div class="modal-dialog modal-lm" >
                <div class="modal-content">
                   <button type="button" class="modal-close editpost" data-dismiss="modal">&times;</button>       
                   <div class="modal-body">
                      <span class="mes"></span>
                   </div>
                </div>
             </div>
        </div>
    </div>
    <?php echo $footer; ?>

    <script src="<?php echo base_url('assets/js/croppie.js?ver='.time()); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver='.time()); ?>"></script>
    <script src="<?php echo base_url('assets/dragdrop/js/plugins/sortable.js?ver='.time()); ?>"></script>
    <script src="<?php echo base_url('assets/dragdrop/js/fileinput.js?ver='.time()); ?>"></script>
    <script src="<?php echo base_url('assets/dragdrop/js/locales/fr.js?ver='.time()); ?>"></script>
    <script src="<?php echo base_url('assets/dragdrop/js/locales/es.js?ver='.time()); ?>"></script>
    <script src="<?php echo base_url('assets/dragdrop/themes/explorer/theme.js?ver='.time()); ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.form.3.51.js?ver='.time()); ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.validate.min.js?ver='.time()); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/as-videoplayer/build/mediaelement-and-player.js?ver=' . time()); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/as-videoplayer/demo.js?ver=' . time()); ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery-ui.min-1.12.1.js?ver=' . time()) ?>"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
    <script data-semver="0.13.0" src="https://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
    <script src="<?php echo base_url('assets/js/angular-validate.min.js?ver=' . time()) ?>"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
    <script src="<?php echo base_url('assets/js/ng-tags-input.min.js?ver=' . time()); ?>"></script>
    <script src="<?php echo base_url('assets/js/angular/angular-tooltips.min.js?ver=' . time()); ?>"></script>
    <script src="<?php echo base_url('assets/js/angular-google-adsense.min.js'); ?>"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-sanitize.js"></script>

    <script type="text/javascript">
    var base_url = '<?php echo base_url(); ?>';   
    var isdeactive = '<?php echo $isartistactivate; ?>';   
    var data= <?php echo json_encode($demo); ?>;
    var data1 = <?php echo json_encode($city_data); ?>;
    var complex = <?php echo json_encode($selectdata); ?>;
    var textarea = document.getElementById("textarea");
    var slug = '<?php echo $artid; ?>';
    var art_slug = '<?php echo artist_dashboard. $get_url; ?>';
    var header_all_profile = '<?php echo $header_all_profile; ?>';
    var user_slug = '<?php echo $get_url; ?>';
    var app = angular.module("artistDashboardApp", ['ngRoute', 'ui.bootstrap', 'ngTagsInput', 'ngSanitize','angular-google-adsense', 'ngValidate']);
    </script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/progressloader.js?ver=' . time()); ?>"></script>
    <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist/artistic_common.js?ver='.time()); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist/dashboard.js?ver='.time()); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist/dashboard_new.js?ver='.time()); ?>"></script>
	<script>
			$(document).ready(function () {
				if (screen.width <= 1279) {
					$(".move-website").appendTo($("#move-website"));
					$(".move-availability").appendTo($("#move-availability"));
					
				}
			});
			$(document).ready(function () {
				if (screen.width <= 991) {
					$(".move-middle").appendTo($("#move-middle"));
				}
			});
		</script>
</body>
</html>