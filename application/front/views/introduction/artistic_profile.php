<!DOCTYPE html>
<?php
if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
    // $date = $_SERVER['HTTP_IF_MODIFIED_SINCE'];
    header("HTTP/1.1 304 Not Modified");
    exit();
}

$format = 'D, d M Y H:i:s \G\M\T';
$now = time();

$date = gmdate($format, $now);
header('Date: ' . $date);
header('Last-Modified: ' . $date);

$date = gmdate($format, $now + 30);
header('Expires: ' . $date);

//header('Cache-Control: public, max-age=30');
?>
<html lang="en">
    <head>
        <title><?php echo $title; ?></title>
        <meta name="description" content="<?php echo $metadesc; ?>" />
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">
        <!-- <meta name="robots" content="noindex, nofollow"> -->
        <meta charset="utf-8">
        
        <meta name="google-site-verification" content="BKzvAcFYwru8LXadU4sFBBoqd0Z_zEVPOtF0dSxVyQ4" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" /> 
		<link rel="stylesheet" href="<?php echo base_url('assets/n-css/component.css?ver=' . time()); ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()); ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>">
		
        <?php
        $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        ?>
        <link rel="canonical" href="<?php echo $actual_link ?>" />
        <?php if (IS_OUTSIDE_CSS_MINIFY == '0') { ?>      
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()); ?>">
            <link rel="stylesheet" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/blog.css?ver=' . time()); ?>">
        <?php } else { ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/common-style.css?ver=' . time()); ?>">
            <link rel="stylesheet" href="<?php echo base_url('assets/css_min/style-main.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/blog.css?ver=' . time()); ?>">
        <?php } ?>
        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()) ?>"></script>
    <?php $this->load->view('adsense'); ?>
</head>
    <body class="outer-page">
        <div class="main-inner">
            <div class="profile-bnr">
                <img src="<?php echo base_url('assets/img/ap.jpg'); ?>" alt="banner-image">

                <header class="profile-header">
                    <div class="container">
                        <div class="row">
								<div class="col-md-4 col-sm-4 left-header col-xs-4 fw-479">
									<div class="logo"><a href="<?php echo base_url(); ?>"><img style="height:30px; width:auto;" src="<?php echo base_url('assets/img/logo2.png?ver=' . time()); ?>" alt="logo"></a></div>
								</div>
								<div class="col-md-8 col-sm-8 right-header col-xs-8 fw-479">
									<div class="btn-right other-hdr">
										<?php if (!$this->session->userdata('aileenuser')) { ?>
											<ul class="nav navbar-nav navbar-right test-cus drop-down">
												<?php $this->load->view('profile-dropdown'); ?>
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
                </header>
                <div class="container">
                    <div class="prof-title" style="left:41%;">
                        <!--h1>Freelancer Profile</h1-->
                    </div>
                </div>
            </div>		
			<div class="fw pt20">
				<div class="container pt20">
                        <?php
                        /*if (!$this->session->userdata('aileenuser') || $is_profile['is_artistic'] != '1') {
                            ?>
                            <div class="text-center introduce_button"><a href="<?php echo base_url('artist-profile/signup') ?>" target="_blank" title="Create Artistic Profile" class="btn-new1">Create Artistic Profile</a></div>
                        <?php } else {
                            ?>
                            <div class="text-center introduce_button"><a href="<?php echo base_url('artist') ?>" target="_blank" title="Take me in" class="btn-new1">Take me in</a></div>  
                        <?php }*/
                        ?>
				</div>
			</div>
            <section class="middle-main bg_white">
				<div class="banner-add">
					<?php $this->load->view('banner_add'); ?>
				</div>
                <div class="container">
                    <div class="profiles-details">
                        <div class="top-detail text-center">

                            <p>Aileensoul is a comprehensive and far-reaching digital platform that provides artistic souls with a rare opportunity to showcase their skills and talent online. Launched with an aim to provide career-related services and opportunities to people from different walks of life, the website comes with an built-in ‘Artistic Profile’ (one of its several service profiles) to provide the necessary platform to practitioners of fine arts and performing arts that can help them self-promote and sell their art to Aileensoul’s highly diversified communities and registered users. The platform also enables artists and performers to exploit its string of networking forums to form connections and seize opportunities that can be helpful in making their craft more mainstream and less elusive. </p>
                        </div>

                        <div class="row dis-box">
                            <h2>Aileensoul - A Dream Come True for Freelancers and Employers Alike</h2>
                            <div class="col-md-6 col-sm-12 pb20">
                                <img style="width:100%;" src="<?php echo base_url('assets/img/art1.jpg?ver=' . time()); ?>" alt="artistic-image">
                            </div>
                            <div class="col-md-6 col-sm-12 pb20">
                                <p>One of the common challenges faced by many budding artists is the dilemma of how to get their precious work out there for the awareness and attention of the general public as well as the art communities. Unavailability of a powerful platform to present one’s art and talent to the outside world has been the reason for many a talented and creative soul to completely give up on their artistic passions or take up art as a mere hobby or a supplementary activity that is best pursued during one’s spare time.<br>
                                    Aileensoul is a free platform that allows artists and performers to connect and collaborate with its growing community of fellow artists and individuals with diverse skills, interests, educational and professional backgrounds. It enables artists to bring their creative work to the notice of its geographically dispersed and multicultural audience in the form of photo, video, audio and PDF uploads.  Knowing that artists need an uninhibited environment and open communication for their creativity to flourish, Aileensoul gives the creative personalities a free hand to display their art in their own way and in a manner that demonstrates how serious they are about treading the challenging yet fulfilling path of an artist with unswerving commitment and purpose.

                                </p>
                            </div>
                        </div>
                        <div class="row dis-box">
                            <h1>How to Register With Aileensoul’s Artistic Profile?</h1>
                            <div class="col-md-6 col-sm-12 pb20 pull-right">
                                <img style="width:100%;" src="<?php echo base_url('assets/img/art2.jpg?ver=' . time()); ?>" alt="artistic-image">
                            </div>
                            <div class="col-md-6 col-sm-12 pb20 pull-left">
                                <p>To create an artistic profile on Aileensoul’s platform, you first need to sign up with the website and then click on the ‘Register’ button under its ‘Artistic Profile’ to land on the next page where you have to provide your personal details and select your art category from a dropdown menu. Depending on your inherent skills and talent, you may choose from a wide selection of vocations, such as singer, photographer, musician, writer, artist, stand-up comedian etc. If you are blessed with many skills, then you can even select more than one option to display your multifaceted personality! Click on ‘Register’ to complete the process and you are ready to grab eyes and ears alike with your videos and audios!    
                                </p>
                            </div>
                        </div>
                        <div class="row dis-box">
                            <h2>Additional Features of Aileensoul’s Artistic Profile:</h2>
                            <div class="col-md-6 col-sm-12 pb20">
                                <img style="width:100%;" src="<?php echo base_url('assets/img/art3.jpg?ver=' . time()); ?>" alt="artistic-image">
                            </div>
                            <div class="col-md-6 col-sm-12 pb20">
                                <p>Aileensoul’s ‘Artistic Profile’ is not just a quick and easy way for artists to spread the word about their art and talent online without incurring any expense, but also an innovative and efficient way to stay abreast of the current happenings in their world with regular newsfeed of their chosen artistic categories and the various art forms that they advocate and follow. Not to forget the platform’s in-built provision to look up the work of an existing artist who is registered with Aileensoul or its elaborate dashboard that enables individuals to check who all are following their art and whose art or talent is being followed by them.  

                                </p>
                            </div>
                        </div>
					<div class="fw">
                        <?php
                        /*if (!$this->session->userdata('aileenuser') || $is_profile['is_artistic'] != '1') {
                            ?>
                            <div class="text-center pb20 introduce_button"><a href="<?php echo base_url('artist-profile/signup') ?>" target="_blank" title="Create Artistic Profile" class="btn-new1">Create Artistic Profile</a></div>
                        <?php } else {
                            ?>
                            <div class="text-center pb20 introduce_button"><a href="<?php echo base_url('artist') ?>" target="_blank" title="Take me in" class="btn-new1">Take me in</a></div>  
                        <?php }*/
                        ?>
					</div>
                    </div>
                </div>
				<div class="banner-add">
					<?php $this->load->view('banner_add'); ?>
				</div>

            </section>
        </div>
		<?php $this->load->view('mobile_side_slide'); ?>
        <?php echo $login_footer ?>
    </body>
</html>
