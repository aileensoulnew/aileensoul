<!DOCTYPE html>
<?php
	if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
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
	header('Cache-Control: public, max-age=30');
?>
<html lang="en">
    <head>
        <title>Faq - Aileensoul</title>
        <meta name="description" content="Feel free to share your views and thoughts about Aileensoul.com services." />
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
        <?php
        if ($_SERVER['HTTP_HOST'] == "www.aileensoul.com") {
            ?>
            <script>
                (function (i, s, o, g, r, a, m) {
                    i['GoogleAnalyticsObject'] = r;
                    i[r] = i[r] || function () {
                        (i[r].q = i[r].q || []).push(arguments)
                    }, i[r].l = 1 * new Date();
                    a = s.createElement(o),
                            m = s.getElementsByTagName(o)[0];
                    a.async = 1;
                    a.src = g;
                    m.parentNode.insertBefore(a, m)
                })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
                ga('create', 'UA-91486853-1', 'auto');
                ga('send', 'pageview');
            </script>
            <meta name="msvalidate.01" content="41CAD663DA32C530223EE3B5338EC79E" />
            <?php
        }
        ?>
        <?php
        $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        ?>
        <link rel="canonical" href="<?php echo $actual_link ?>" />
        <meta name="google-site-verification" content="BKzvAcFYwru8LXadU4sFBBoqd0Z_zEVPOtF0dSxVyQ4" />
        <link rel="stylesheet" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/aos.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>" />
    </head>
    <body class="report">      
        <div class="middle-section middle-section-banner new-ld-page">
			<div class="search-banner cus-search-bnr" >
				<header>
					<div class="header">
						<div class="container">
							<div class="row">
								<div class="col-md-6 col-sm-6 left-header fw-479">
									<h2 class="logo"><a href="#">Aileensoul</a></h2>
								</div>
								<div class="col-md-6 col-sm-6 no-login-right fw-479">
								 	<?php if (!$this->session->userdata('aileenuser')) { ?>
                                        <a href="<?php echo base_url('login'); ?>" class="btn8">Login</a>
                                        <a href="<?php echo base_url('registration'); ?>" class="btn9">Create an account</a>
                                    <?php } ?>
								</div>
							</div>
						</div>
					</div>
				</header>
				<div class="container">
					<div class="row">
						<h1 class="text-center">Frequently Asked Questions</h1>
					</div>
				</div>
			</div>
            <div class="container">
				<div class="report-middle-box">						
					<ul class="faq">
						<li>
							<a href="<?php echo base_url('how-to-use-job-profile-in-aileensoul'); ?>">
								How to use Job profile in Aileensoul? 
								<span class="pull-right">
									<img src="<?php echo base_url('assets/n-images/more-link.png') ?>">
								</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('how-to-use-recruiter-profile-in-aileensoul'); ?>">
								How to use Recruiter profile in Aileensoul? 
								<span class="pull-right">
									<img src="<?php echo base_url('assets/n-images/more-link.png') ?>">
								</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('how-to-use-freelance-profile-in-aileensoul'); ?>">
								How to use Freelancer profile in Aileensoul?
								<span class="pull-right">
									<img src="<?php echo base_url('assets/n-images/more-link.png') ?>">
								</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('how-to-use-business-profile-in-aileensoul'); ?>">
								How to use Business profile in Aileensoul?
								<span class="pull-right">
									<img src="<?php echo base_url('assets/n-images/more-link.png') ?>">
								</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('how-to-use-artistic-profile-in-aileensoul'); ?>">
								How to use Artistic profile in Aileensoul?
								<span class="pull-right">
									<img src="<?php echo base_url('assets/n-images/more-link.png') ?>">
								</span>
							</a>
						</li>
					</ul>
				</div>
			</div>
			<?php echo $login_footer ?>
		</div>
		<!--  poup modal  -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js?ver=<?php echo time(); ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>        
        <script src="<?php echo base_url('assets/js/owl.carousel.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/aos.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js?ver=' . time()); ?>"></script>
        <script>
            // mcustom scroll bar
            (function ($) {
                $(window).on("load", function () {
                    $(".custom-scroll").mCustomScrollbar({
                        autoHideScrollbar: true,
                        theme: "minimal"
                    });
                });
            })(jQuery);
        </script>
		<script>
		  AOS.init({
			easing: 'ease-in-out-sine'
		  });
		  setInterval(addItem, 100);
		  var itemsCounter = 1;
		  var container = document.getElementById('aos-demo');
		  function addItem () {
			if (itemsCounter > 42) return;
			var item = document.createElement('div');
			item.classList.add('aos-item');
			item.setAttribute('data-aos', 'fade-up');
			item.innerHTML = '<div class="aos-item__inner"><h3>' + itemsCounter + '</h3></div>';
			// container.appendChild(item);
			itemsCounter++;
		  }
    </script>
    </body>
</html>