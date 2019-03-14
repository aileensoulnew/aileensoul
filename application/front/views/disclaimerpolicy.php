<!DOCTYPE html>
<?php

if(isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
    // $date = $_SERVER['HTTP_IF_MODIFIED_SINCE'];
    header("HTTP/1.1 304 Not Modified");
    exit();
}

$format = 'D, d M Y H:i:s \G\M\T';
$now = time();

$date = gmdate($format, $now);
header('Date: '.$date);
header('Last-Modified: '.$date);

$date = gmdate($format, $now+30);
header('Expires: '.$date);

header('Cache-Control: public, max-age=30');

?>
<html lang="en">
    <head>
        <title><?php echo $title; ?></title>
        <meta name="description" content="<?php echo $metadesc; ?>" />
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver='.time()); ?>">
        <!-- <meta name="robots" content="noindex, nofollow"> -->
        <meta charset="utf-8">        
        <meta name="google-site-verification" content="BKzvAcFYwru8LXadU4sFBBoqd0Z_zEVPOtF0dSxVyQ4" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />        
        <?php
        $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        ?>
        <link rel="canonical" href="<?php echo $actual_link ?>" />
      
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/common-style.css?ver='.time()); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/style-main.css?ver='.time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/blog.css?ver='.time()); ?>">

    	<link rel="stylesheet" href="<?php echo base_url('assets/n-css/component.css?ver=' . time()) ?>">
    	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver='.time()); ?>">
    	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver='.time()); ?>">
            
    	<script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()) ?>"></script>	
        <?php $this->load->view('adsense'); ?>
    </head>
    <body class="report ftr-page">
        <div class="middle-section middle-section-banner new-ld-page">            
            <header>
					<div class="">
						<div class="container">
							<div class="row">
								<div class="col-md-4 col-sm-4 left-header col-xs-4 fw-479">
									<?php $this->load->view('main_logo'); ?>
								</div>
								<div class="col-md-8 col-sm-8 right-header col-xs-8 fw-479">
									<div class="btn-right other-hdr">
										<?php if (!$this->session->userdata('aileenuser')) { ?>
											<ul class="nav navbar-nav navbar-right test-cus drop-down">
												<?php //$this->load->view('profile-dropdown'); ?>
												<li><a href="<?php echo base_url('login'); ?>" class="btn8">Login</a></li>
												<li><a href="<?php echo base_url('registration'); ?>" class="btn9">Create an account</a></li>
												<li class="mob-bar-li">
													<span class="mob-right-bar">
														<?php $this->load->view('mobile_right_bar'); ?>
													</span>
												</li>
											
											</ul>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</header>
			
			<div class="search-banner cus-search-bnr" >
				
				<div class="container">
					<div class="row">
						<h1 class="text-center">Disclaimer Policy</h1>
					</div>
				</div>
			</div>
            <section class="middle-main bg_white">
                <div class="container">
                    <div class="term_desc test_py">
                        <p>The information contained in this website is for general information purposes only. The information is provided by www.aileensoul.com, a property of Aileensoul Technologies Pvt.Ltd. While we endeavour to keep the information up to date and correct, we make no representations or warranties of any kind, express or implied, about the completeness, accuracy, reliability, suitability or availability with respect to the website or the information, products, services, or related graphics contained on the website for any purpose. Any reliance you place on such information is therefore strictly at your own risk.
                        </p>                        
                    </div>
                    <div class="term_desc test_py">
                        <p>In no event will we be liable for any loss or damage including without limitation, indirect or consequential loss or damage, or any loss or damage whatsoever arising from loss of data or profits arising out of, or in connection with, the use of this website. </p>
                       
                       
                    </div>
                    <div class="term_desc test_py">
                        <p>Through this website you are able to link to other websites which are not under the control of Aileensoul Technologies Pvt.Ltd. We have no control over the nature, content and availability of those sites. The inclusion of any links does not necessarily imply a recommendation or endorse the views expressed within them.
                        </p>                        
                    </div><div class="term_desc test_py">
                      
                        <p>Every effort is made to keep the website up and running smoothly. However, Aileensoul Technologies Pvt.Ltd takes no responsibility for, and will not be liable for, the website being temporarily unavailable due to technical issues beyond our control.
                        </p>                        
                    </div>
                </div>
            </section>
        </div>
		<?php $this->load->view('mobile_side_slide'); ?>
       <?php echo $login_footer ?>
    </body>
</html>
