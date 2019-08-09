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
		<title>Report Abuse | Aileensoul</title>
		<meta name="description" content="Saw any spam, phishing or misleading information on Aileensoul Platform? Fill the form to report us to keep the platform safe and informative for everyone."/>
		<link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
		
		<?php
		$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		?>
		<link rel="canonical" href="<?php echo $actual_link ?>" />
		<meta name="google-site-verification" content="BKzvAcFYwru8LXadU4sFBBoqd0Z_zEVPOtF0dSxVyQ4" />
		<link rel="stylesheet" href="<?php echo base_url('assets/n-css/component.css?ver=' . time()) ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()) ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css?ver=' . time()) ?>">
	 	<link rel="stylesheet" href="<?php echo base_url('assets/css/aos.css?ver=' . time()) ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css?ver=' . time()) ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css?ver=' . time()) ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()) ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()); ?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>" />
		
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
						<h1 class="text-center">Report Spam</h1>
					</div>
				</div>
			</div>
			<!-- <div class="container">
				<div class="banner-add">
					<?php //$this->load->view('banner_add'); ?>
				</div>
			</div> -->
			<div class="container">
				<div class="report-middle-box">
					<p class="text-center">We believe in providing value to each of our members. If you found any issues like spam, abusive, fake news or account, phishing, malware that violates our 
					<a href="<?php echo base_url('terms-and-condition'); ?>" title="Terms and Condition" target="_blank">Terms of Service</a>, kindly report here. </p>
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
								<input name="radio" type="radio" value="0">
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
			<!-- <div class="container">
				<div class="banner-add">
					<?php //$this->load->view('banner_add'); ?>
				</div>
			</div> -->
			<?php $this->load->view('mobile_side_slide'); ?>
			<?php echo $login_footer ?>
		</div>
		<div class="modal fade message-box custom-message cust-err" id="reportmodal" role="dialog">
		    <div class="modal-dialog modal-lm">
		        <div class="modal-content">
		            <button type="button" class="modal-close" data-dismiss="modal">&times;</button><div class="modal-body">
		                <span class="mes"></span>		                
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
		        $("#btnReport").attr("disabled","disabled")
		        $.ajax({
		            type: 'POST',
		            url: base_url + 'report/add_report',
		            data: post_data,
		            success: function (response)
		            {	
		                // if (response) {
		                	$("#btnReport").removeAttr("disabled")
		                    $("#txtName").val('');
		                    $("#txtEmail").val('');
		                    $("#txtUri").val('');
		                    $("#txtDetail").val('');
		                    // $(".message").text("Report submitted successfully.");
		                    // $(".message").text("Report submitted successfully.");
		                    $('.message-box .mes').html('<div class="contactus">Report submitted successfully.</div>');
		                    $("#reportmodal").modal("show");
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