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
		<title>Aileensoul</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php if ($_SERVER['HTTP_HOST'] == "www.aileensoul.com") { ?>
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
		<?php } ?>
		<?php $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>

		<link rel="canonical" href="<?php echo $actual_link ?>" />
		<meta name="google-site-verification" content="BKzvAcFYwru8LXadU4sFBBoqd0Z_zEVPOtF0dSxVyQ4" />
		<link rel="stylesheet" href="<?php echo base_url('assets/n-css/bootstrap.min.css?ver=' . time()) ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css?ver=' . time()) ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css?ver=' . time()) ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css?ver=' . time()) ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()) ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>" />
	</head>
	<body class="sitemap">
		<div class="web-header">
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
		</div>
		<div class="middle-section">
			<div class="container">
				<div class="sitemap">
					<h1>Sitemap</h1>
					<div class="site-box">
						<h3>Member Name with Characters</h3>
						<ul class="alphabet">
							<li><a class="active" href="#">A</a></li>
							<li><a href="#">b</a></li>
							<li><a href="#">c</a></li>
							<li><a href="#">d</a></li>
							<li><a href="#">e</a></li>
							<li><a href="#">f</a></li>
							<li><a href="#">g</a></li>
							<li><a href="#">h</a></li>
							<li><a href="#">i</a></li>
							<li><a href="#">j</a></li>
							<li><a href="#">k</a></li>
							<li><a href="#">l</a></li>
							<li><a href="#">m</a></li>
							<li><a href="#">n</a></li>
							<li><a href="#">o</a></li>
							<li><a href="#">p</a></li>
							<li><a href="#">q</a></li>
							<li><a href="#">r</a></li>
							<li><a href="#">s</a></li>
							<li><a href="#">t</a></li>
							<li><a href="#">u</a></li>
							<li><a href="#">v</a></li>
							<li><a href="#">w</a></li>
							<li><a href="#">x</a></li>
							<li><a href="#">y</a></li>
							<li><a href="#">z</a></li>
						</ul>
						<div class="fw pt20">
							<h3>Member Name with Characters</h3>
							<ul class="pagination">
								<li><a href="#">Previous</a></li>
								<li><a class="active" href="#">1</a></li>
								<li><a href="#">2</a></li>
								<li><a href="#">. . .</a></li>
								<li><a href="#">8</a></li>
								<li><a href="#">9</a></li>
								<li><a href="#">10</a></li>
								<li><a href="#">11</a></li>
								<li><a href="#">12</a></li>
								<li><a href="#">. . .</a></li>
								<li><a href="#">45</a></li>
								<li><a href="#">46</a></li>
								<li><a href="#">Next</a></li>
								
							</ul>
						</div>
						<div class="fw pt20">
							<ul class="mid-listing">
								<li><a href="#">Dhaval Shah (Ceo Aileensoul)</a></li>
								<li><a href="#">Nikunj Bhalodia (Tester)c</a></li>
								<li><a href="#">Santhosh Kumar Varaganti (PHP Devloper)</a></li>
								<li><a href="#">Santhosh Kumar Varaganti (PHP Devloper)</a></li>
								<li><a href="#">Vikalp Mangal (Designer)</a></li>
								<li><a href="#">Dhaval Shah (Ceo Aileensoul)</a></li>
								<li><a href="#">Nikunj Bhalodia (Tester)c</a></li>
								<li><a href="#">Santhosh Kumar Varaganti (PHP Devloper)</a></li>
								<li><a href="#">Santhosh Kumar Varaganti (PHP Devloper)</a></li>
								<li><a href="#">Vikalp Mangal (Designer)</a></li>
								<li><a href="#">Dhaval Shah (Ceo Aileensoul)</a></li>
								<li><a href="#">Nikunj Bhalodia (Tester)c</a></li>
								<li><a href="#">Santhosh Kumar Varaganti (PHP Devloper)</a></li>
								<li><a href="#">Santhosh Kumar Varaganti (PHP Devloper)</a></li>
								<li><a href="#">Vikalp Mangal (Designer)</a></li>
								<li><a href="#">Dhaval Shah (Ceo Aileensoul)</a></li>
								<li><a href="#">Nikunj Bhalodia (Tester)c</a></li>
								<li><a href="#">Santhosh Kumar Varaganti (PHP Devloper)</a></li>
								<li><a href="#">Santhosh Kumar Varaganti (PHP Devloper)</a></li>
								<li><a href="#">Vikalp Mangal (Designer)</a></li>
								<li><a href="#">Dhaval Shah (Ceo Aileensoul)</a></li>
								<li><a href="#">Nikunj Bhalodia (Tester)c</a></li>
								<li><a href="#">Santhosh Kumar Varaganti (PHP Devloper)</a></li>
								<li><a href="#">Santhosh Kumar Varaganti (PHP Devloper)</a></li>
								<li><a href="#">Vikalp Mangal (Designer)</a></li>
								<li><a href="#">Dhaval Shah (Ceo Aileensoul)</a></li>
								<li><a href="#">Nikunj Bhalodia (Tester)c</a></li>
								<li><a href="#">Santhosh Kumar Varaganti (PHP Devloper)</a></li>
								<li><a href="#">Santhosh Kumar Varaganti (PHP Devloper)</a></li>
								<li><a href="#">Vikalp Mangal (Designer)</a></li>
								<li><a href="#">Dhaval Shah (Ceo Aileensoul)</a></li>
								<li><a href="#">Nikunj Bhalodia (Tester)c</a></li>
								<li><a href="#">Santhosh Kumar Varaganti (PHP Devloper)</a></li>
								<li><a href="#">Santhosh Kumar Varaganti (PHP Devloper)</a></li>
								<li><a href="#">Vikalp Mangal (Designer)</a></li>
								<li><a href="#">Dhaval Shah (Ceo Aileensoul)</a></li>
								<li><a href="#">Nikunj Bhalodia (Tester)c</a></li>
								<li><a href="#">Santhosh Kumar Varaganti (PHP Devloper)</a></li>
								<li><a href="#">Santhosh Kumar Varaganti (PHP Devloper)</a></li>
								<li><a href="#">Vikalp Mangal (Designer)</a></li>
								<li><a href="#">Dhaval Shah (Ceo Aileensoul)</a></li>
								<li><a href="#">Nikunj Bhalodia (Tester)c</a></li>
								<li><a href="#">Santhosh Kumar Varaganti (PHP Devloper)</a></li>
								<li><a href="#">Santhosh Kumar Varaganti (PHP Devloper)</a></li>
								<li><a href="#">Vikalp Mangal (Designer)</a></li>
								<li><a href="#">Dhaval Shah (Ceo Aileensoul)</a></li>
								<li><a href="#">Nikunj Bhalodia (Tester)c</a></li>
								<li><a href="#">Santhosh Kumar Varaganti (PHP Devloper)</a></li>
								<li><a href="#">Santhosh Kumar Varaganti (PHP Devloper)</a></li>
								<li><a href="#">Vikalp Mangal (Designer)</a></li>
								<li><a href="#">Dhaval Shah (Ceo Aileensoul)</a></li>
								<li><a href="#">Nikunj Bhalodia (Tester)c</a></li>
								<li><a href="#">Santhosh Kumar Varaganti (PHP Devloper)</a></li>
								<li><a href="#">Santhosh Kumar Varaganti (PHP Devloper)</a></li>
								<li><a href="#">Vikalp Mangal (Designer)</a></li>
								<li><a href="#">Dhaval Shah (Ceo Aileensoul)</a></li>
								<li><a href="#">Nikunj Bhalodia (Tester)c</a></li>
								<li><a href="#">Santhosh Kumar Varaganti (PHP Devloper)</a></li>
								<li><a href="#">Santhosh Kumar Varaganti (PHP Devloper)</a></li>
								<li><a href="#">Vikalp Mangal (Designer)</a></li>
								<li><a href="#">Santhosh Kumar Varaganti (PHP Devloper)</a></li>
								<li><a href="#">Santhosh Kumar Varaganti (PHP Devloper)</a></li>
								<li><a href="#">Vikalp Mangal (Designer)</a></li>
								<li><a href="#">Dhaval Shah (Ceo Aileensoul)</a></li>
								<li><a href="#">Nikunj Bhalodia (Tester)c</a></li>
								<li><a href="#">Santhosh Kumar Varaganti (PHP Devloper)</a></li>
								<li><a href="#">Santhosh Kumar Varaganti (PHP Devloper)</a></li>
								<li><a href="#">Vikalp Mangal (Designer)</a></li>
								<li><a href="#">Dhaval Shah (Ceo Aileensoul)</a></li>
								<li><a href="#">Nikunj Bhalodia (Tester)c</a></li>
								<li><a href="#">Santhosh Kumar Varaganti (PHP Devloper)</a></li>
								<li><a href="#">Santhosh Kumar Varaganti (PHP Devloper)</a></li>
								<li><a href="#">Vikalp Mangal (Designer)</a></li>
								<li><a href="#">Dhaval Shah (Ceo Aileensoul)</a></li>
								<li><a href="#">Nikunj Bhalodia (Tester)c</a></li>
								<li><a href="#">Santhosh Kumar Varaganti (PHP Devloper)</a></li>
								<li><a href="#">Santhosh Kumar Varaganti (PHP Devloper)</a></li>
								<li><a href="#">Vikalp Mangal (Designer)</a></li>
								<li><a href="#">Dhaval Shah (Ceo Aileensoul)</a></li>
								<li><a href="#">Nikunj Bhalodia (Tester)c</a></li>
								<li><a href="#">Santhosh Kumar Varaganti (PHP Devloper)</a></li>
								<li><a href="#">Santhosh Kumar Varaganti (PHP Devloper)</a></li>
								<li><a href="#">Vikalp Mangal (Designer)</a></li>
								<li><a href="#">Dhaval Shah (Ceo Aileensoul)</a></li>
								<li><a href="#">Nikunj Bhalodia (Tester)c</a></li>
								<li><a href="#">Santhosh Kumar Varaganti (PHP Devloper)</a></li>
								<li><a href="#">Santhosh Kumar Varaganti (PHP Devloper)</a></li>
								<li><a href="#">Vikalp Mangal (Designer)</a></li>
								<li><a href="#">Dhaval Shah (Ceo Aileensoul)</a></li>
								<li><a href="#">Nikunj Bhalodia (Tester)c</a></li>
								<li><a href="#">Santhosh Kumar Varaganti (PHP Devloper)</a></li>
								<li><a href="#">Santhosh Kumar Varaganti (PHP Devloper)</a></li>
								<li><a href="#">Vikalp Mangal (Designer)</a></li>
								<li><a href="#">Dhaval Shah (Ceo Aileensoul)</a></li>
								<li><a href="#">Nikunj Bhalodia (Tester)c</a></li>
								<li><a href="#">Santhosh Kumar Varaganti (PHP Devloper)</a></li>
								<li><a href="#">Santhosh Kumar Varaganti (PHP Devloper)</a></li>
								<li><a href="#">Vikalp Mangal (Designer)</a></li>
								<li><a href="#">Dhaval Shah (Ceo Aileensoul)</a></li>
								<li><a href="#">Nikunj Bhalodia (Tester)c</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php echo $login_footer ?>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js?ver=<?php echo time(); ?>"></script>
		<script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
		<script src="<?php echo base_url('assets/js/owl.carousel.min.js?ver=' . time()); ?>"></script>
		<script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js?ver=' . time()); ?>"></script>
		<script>			
			// mcustom scroll bar
			(function($){
				$(window).on("load",function(){
					$(".custom-scroll").mCustomScrollbar({
						autoHideScrollbar:true,
						theme:"minimal"
					});
				});
			})(jQuery);
		</script>
	</body>
</html>