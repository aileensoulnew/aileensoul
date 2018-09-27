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
		<title>Unsubscribe | Aileensoul</title>
		<meta name="description" content=""/>
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
	<?php //$this->load->view('adsense'); ?>
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
							</div>
						</div>
					</div>
				</header>
			
			<div class="search-banner cus-search-bnr" >
				
				<div class="container">
					<div class="row">
						<h1 class="text-center">Unsubscribe</h1>
					</div>
				</div>
			</div>
			
			<div class="container">
				<div class="report-middle-box">					
					<form class="report-form" id="addunsubscribe" method="post" action="javascript:void(0);">
						<div class="form-group">
							<textarea placeholder="Why you want to unsubscribe?" id="reason" name="reason" maxlength="2000"></textarea>
						</div>						
						<!-- <p class="error-text hidden"></p> -->
						<div class="form-group">
							<button class="btn1" onclick="submitRegisterForm();" id="btnReport">Unsubscribe</button>
						</div>
					</form>
				</div>
			</div>
			<div class="container">
				<div class="banner-add">
					<?php $this->load->view('banner_add'); ?>
				</div>
			</div>
			<?php //$this->load->view('mobile_side_slide'); ?>
			<?php echo $login_footer ?>
		</div>
		<div class="modal fade message-box addreport" id="unsubscribemodel" role="dialog" data-keyboard="false" data-backdrop="static">
		    <div class="modal-dialog modal-lm">
		        <div class="modal-content">
		            <!-- <button type="button" class="modal-close" data-dismiss="modal">&times;</button> -->
		            <div class="post-popup-box">
			            <div class="post-box">
				            <div class="post-text">
				                <div class="mes"></div>		                
				            </div>
				            <div class="post-box-bottom">
				                <p class="pull-right">
			                        <button type="button" id="close_model" class="btn1" data-dismiss="modal" value="Close">Close</button>
			                    </p>
				            </div>
				        </div>
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
        	var key1 = "<?php echo $encrypt_key; ?>";
        	var key2 = "<?php echo $user_slug; ?>";
        	var key3 = "<?php echo $user_id; ?>";
            // mcustom scroll bar
            (function ($) {
                $(window).on("load", function () {
                    $(".custom-scroll").mCustomScrollbar({
                        autoHideScrollbar: true,
                        theme: "minimal"
                    });
                });
            })(jQuery);
		    function submitRegisterForm()
		    {
		        var reason = $("#reason").val();		    	
		        $.ajax({
		            type: 'POST',
		            url: base_url + 'registration/unsubscribe_reason',
		            data: {'reason':reason,'key1':key1,'key2':key2,'key3':key3},
		            success: function (result)
		            {
		            	var content = "";
		            	if(result > 0)
		            	{
		            		content = '<div class="pop_content" style="color: #1b8ab9;">Unsubscribe successfully.</div>';
		            	}
		            	else if(result == 0)
		            	{
		            		content = '<div class="pop_content" style="color: red;">Already Unsubscribed.</div>';
		            	}
		            	else if(result == -1)
		            	{
		            		content = '<div class="pop_content" style="color: red;">Please try again later.</div>';
		            	}
		            	$("#unsubscribemodel .mes").html(content);
		            	$("#unsubscribemodel").modal('show');
	                    
		            }
		        });
		        return false;
		    }
		    // $('#unsubscribemodel').modal({ keyboard: false })
		    $('#close_model').click(function () {
		    	window.location = base_url;
			});
        </script>
	</body>
</html>