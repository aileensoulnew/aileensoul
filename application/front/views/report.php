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
		<title>Report - Aileensoul</title>
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
		<link rel="stylesheet" href="<?php echo base_url('assets/n-css/bootstrap.min.css?ver=' . time()) ?>">
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
						<h1 class="text-center">Report Spam</h1>
					</div>
				</div>
			</div>
			<div class="container">
				<div class="report-middle-box">
					<p class="text-center">We believe in providing value to each of our members. If you found any issues like spam, abusive, fake news or account, phishing, malware that violates our Terms of Service, kindly report here. </p>
					<form class="report-form" id="addreport" method="post">
						<div class="form-group">
							<input type="text" placeholder="Name*" id="txtName" name="txtName">
						</div>
						<div class="form-group">
							<input type="text" placeholder="Email*" id="txtEmail" name="txtEmail">
						</div>
						<div class="form-group">
							<input type="text" placeholder="Mention URl*" id="txtUri" name="txtUri">
						</div>
						<div class="form-group">
							<textarea placeholder="Provide more detail*" id="txtDetail" name="txtDetail"></textarea>
						</div>
						<div class="form-group as-user">
							<label>Aileensoul User:</label>
							<label class="control control--radio">
								Yes
								<input name="radio" type="radio" value="1">
								<div class="control__indicator"></div>
							</label>
							<label class="control control--radio">
								No
								<input name="radio" type="radio" value="0" checked>
								<div class="control__indicator"></div>
							</label>
						</div>
						<!-- <p class="error-text hidden"></p> -->
						<div class="form-group">
							<button class="btn1" id="btnReport">Submit</button>
						</div>
					</form>
				</div>
			</div>
			<?php echo $login_footer ?>
		</div>
		<div class="modal fade message-box addreport" id="reportmodal" role="dialog">
		    <div class="modal-dialog modal-lm">
		        <div class="modal-content">
		            <button type="button" class="modal-close" data-dismiss="modal">&times;</button><div class="modal-body">
		                <span class="mes"></span>
		                <p class="message"></p>
		            </div>
		        </div>
		    </div>
		</div>
		<!--  poup modal  -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js?ver=<?php echo time(); ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>        
        <script src="<?php echo base_url('assets/js/owl.carousel.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/aos.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js?ver=' . time()); ?>"></script>
        <script>
        	var base_url = "<?php echo base_url(); ?>";
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
            $("#addreport").validate({
		        rules: {
		            txtName: {
		                required: true,
		            },
		            txtEmail: {
		                required: true,
		                email: true,
		            },
		            txtUri: {
		                required: true,
		            },
		            txtDetail: {
		                required: true,
		            }
		        },
        		messages:
                {
                    txtName: {
                        required: "Please enter name",
                    },
                    txtEmail: {
                        required: "Please enter email address",
                    },
                    txtUri: {
                        required: "Please enter URI",
                    },
                    txtDetail: {
                        required: "Please enter your detail",
                    }
                },
        		submitHandler: submitRegisterForm
		    });
		    /* register submit */
		    function submitRegisterForm()
		    {
		        var name = $("#txtName").val();
		    	var email = $("#txtEmail").val();
		    	var uri = $("#txtUri").val();
		    	var detail = $("#txtDetail").val();
		    	var addradio = $("input[name='radio']:checked"). val();

		        var post_data = {
		            'name': name,
		            'email': email,
		            'uri': uri,
		            'detail': detail,
		            'isuserregi': addradio
		        }
		        // return false;
		        $.ajax({
		            type: 'POST',
		            url: base_url + 'report/add_report',
		            data: post_data,
		            success: function (response)
		            {	
		                // if (response) {
		                    $("#txtName").val('');
		                    $("#txtEmail").val('');
		                    $("#txtUri").val('');
		                    $("#txtDetail").val('');
		                    $(".message").text("Report submitted successfully.");
		                    // $(".message").text("Report submitted successfully.");
		                    // $("#reportmodal").modal("show");
		                // } else {
		                	// $("#reportmodal").modal("show");
		                	// $(".message").text("Report not submitted successfully.");
		                // }
		            }
		        });
		        return false;
		    }
        </script>
	</body>
</html>