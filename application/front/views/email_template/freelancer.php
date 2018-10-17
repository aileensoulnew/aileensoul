<!DOCTYPE html>
<html>
<head>
<title>Freelancer</title>
<style>
	table{font-family:arial; color:#5c5c5c;}
	p{margin:0;}
	h3{margin:0;}
	.btn{
		border:1px solid #1b8ab9;
		font-size:16px;
		color:#1b8ab9;
		padding:10px 30px;
		text-decoration:none;
		border-radius:20px;
		display:inline-block;
	}
	.inr-tbl{font-size:14px;}
	.inr-tbl th, .inr-tbl td{text-align:left; border:1px solid #d2d2d2; border-bottom:0; padding:10px; border-left:0;}
	.inr-tbl th:first-child, .inr-tbl td:first-child{border-left:1px solid #d2d2d2;}
	.inr-tbl tr:last-child td{border-bottom:1px solid #d2d2d2;}
	.inr-tbl td a{color:#5c5c5c; text-decoration:none;}
</style>
</head>
<body>
	<div style="max-width:600px; margin:0 auto;">
		<table width="100%" cellpadding="0" cellspacing="0">
			<tr>
				<td style="text-align:center; padding-bottom:30px;">
					<p style="font-size:30px; color:#1b8ab9;"><img style="width:30px;margin-right:10px; vertical-align:middle; margin-top:-5px;" src="<?php echo base_url(); ?>assets/img/mail/m-logo.png">
					<span>Aileensoul</span></p>
				</td>
			</tr>
		</table>
		<table width="100%" style="background:#fff; border:1px solid #d2d2d2; border-radius:10px;" cellpadding="0" cellspacing="0">
			<tr>
				<td style="text-align:center;">
					<table width="100%" cellpadding="0" cellspacing="0" >
						<tr>
							<td style="">
								<img style="border-top-left-radius:10px; border-bottom:1px solid #d2d2d2; border-top-right-radius:10px;" src="<?php echo base_url(); ?>assets/img/mail/freelancer.jpg">
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td style="padding:0 30px;">
					<table width="100%" cellpadding="0" cellspacing="0">
						<tr>
							<td style="padding-top:30px;">
								<p>Hi <?php echo $firstname; ?>,</p>
								<p style="padding-top:20px; line-height:1.5; font-size:18px;">Welcome to Aileensoul!</p>
								<p style="padding-top:20px; line-height:1.5;">You have successfully created the freelance profile. Here are few tips to get work fast:</p>
							</td>
						</tr>
						
						<tr>
							<td>
								<table width="100%" cellpadding="0" cellspacing="0">
									<tr>
										<td style="padding-top:30px; vertical-align:top;">
											<img style="margin-right:20px; vertical-align:middle;" src="<?php echo base_url(); ?>assets/img/mail/free-1.png">
										</td>
										<td style="padding-top:30px; vertical-align:top;">
											<p style="font-weight:bold;">Update your profile:</p>
											<p style="line-height:1.5;">By making your profile strong, you can stand out from rest of the freelancers. Entering your best skills will provide you more work options.</p>
										</td>
									</tr>
									<tr>
										<td style="padding-top:30px; vertical-align:top;">
											<img style="margin-right:20px; vertical-align:middle;" src="<?php echo base_url(); ?>assets/img/mail/free-2.png">
										</td>
										<td style="padding-top:30px; vertical-align:top;">
											<p style="font-weight:bold;">Find Right Jobs: </p>
											<p style="line-height:1.5;">Use search filters and enter either skills or keyword to find the freelance work that you're interested in.</p>
										</td>
									</tr>
									<tr>
										<td style="padding-top:30px; vertical-align:top;">
											<img style="margin-right:20px; vertical-align:middle;" src="<?php echo base_url(); ?>assets/img/mail/free-3.png">
										</td>
										<td style="padding-top:30px; vertical-align:top;">
											<p style="font-weight:bold;">Pitch exceptionally:</p>
											<p style="line-height:1.5;">Message your best bids to the client. Make your words clear to the point.</p>
										</td>
									</tr>
									<tr>
										<td style="padding-top:30px; vertical-align:top;">
											<img style="margin-right:20px; vertical-align:middle;" src="<?php echo base_url(); ?>assets/img/mail/free-4.png">
										</td>
										<td style="padding-top:30px; vertical-align:top;">
											<p style="font-weight:bold;">Search Daily:</p>
											<p style="line-height:1.5;">Hundreds of jobs are posted every day, so find, apply, and bid each day.</p>
										</td>
									</tr>
								</table>
							</td> 
						</tr>
						<tr> 
							<td style="padding-top:30px; text-align:center;">
								<a href="<?php echo base_url(); ?>recommended-freelance-work?utm_source=email&utm_medium=email&utm_campaign=wc_freelancer_applybutton" class="btn">Start Applying Now</a>
							</td>
						</tr>
						<tr> 
							<td style="padding-top:30px;">
								<p style="font-size:18px;">View more freelance jobs on Aileensoul</p>
							</td>
						</tr>
						
						<tr> 
							<td style="padding-top:10px;">
								<table class="inr-tbl" width="100%" cellpadding="0" cellspacing="0">
					
									<tr>
										<td><a href="<?php echo base_url(); ?>freelance-jobs/Html?utm_source=email&utm_medium=email&utm_campaign=wc_freelancer_html">HTML Jobs</a></td>
										<td><a href="<?php echo base_url(); ?>freelance-jobs/Php?utm_source=email&utm_medium=email&utm_campaign=wc_freelancer_php">PHP Jobs</a></td>
									</tr>
									<tr>
										<td><a href="<?php echo base_url(); ?>freelance-jobs/Javascript?utm_source=email&utm_medium=email&utm_campaign=wc_freelancer_javascript">Javascript Jobs</a></td>
										<td><a href="<?php echo base_url(); ?>freelance-jobs/Css?utm_source=email&utm_medium=email&utm_campaign=wc_freelancer_css">Css Jobs</a></td>
									</tr>
									<tr>
										<td><a href="<?php echo base_url(); ?>freelance-jobs/Content-writing?utm_source=email&utm_medium=email&utm_campaign=wc_freelancer_applybutton">Content Writing Jobs</a></td>
										<td><a href="<?php echo base_url(); ?>freelance-jobs/Seo?utm_source=email&utm_medium=email&utm_campaign=wc_freelancer_seo">SEO Jobs</a></td>
									</tr>
									<tr>
										<td><a href="<?php echo base_url(); ?>freelance-jobs/Digital-Marketing?utm_source=email&utm_medium=email&utm_campaign=wc_freelancer_digital_marketing">Digital Marketing Jobs</a></td>
										<td><a href="<?php echo base_url(); ?>freelance-jobs/Ajax?utm_source=email&utm_medium=email&utm_campaign=wc_freelancer_ajax">Ajax Jobs</a></td>
									</tr>
									<tr>
										<td><a href="<?php echo base_url(); ?>freelance-jobs/Website-Design?utm_source=email&utm_medium=email&utm_campaign=wc_freelancer_website_design">Website Design Jobs</a></td>
										<td><a href="<?php echo base_url(); ?>freelance-jobs/Jquery-prototype?utm_source=email&utm_medium=email&utm_campaign=wc_freelancer_jquery_prototype">Jquery Prototype Jobs</a></td>
									</tr>
									<tr>
										<td><a href="<?php echo base_url(); ?>freelance-jobs/Social-Media-Marketing?utm_source=email&utm_medium=email&utm_campaign=wc_freelancer_social_media_marketing">Social Media Marketing Jobs</a></td>
										<td><a href="<?php echo base_url(); ?>freelance-jobs-by-categories?utm_source=email&utm_medium=email&utm_campaign=wc_freelancer_more">More Jobs...</a></td>
									</tr>
									
								</table>
							</td>
						</tr>
						<tr>
							<td style="padding-top:30px; padding-bottom:30px; border-bottom:1px solid #d2d2d2; line-height:1.5;">
								<p>For any further queries or suggestions, you can send your valuable feedback <a href="<?php echo base_url(); ?>feedback?utm_source=email&utm_medium=email&utm_campaign=wc_freelancer_feedbackline" style="color:#1b8ab9; text-decoration:none;">here</a>.</p>
								
								<p style="padding-top:20px;">Team Aileensoul</p>
							</td>
						</tr>
						<tr>
							<td style="padding-top:25px; text-align:center; padding-bottom:15px;">
								<a href="https://www.facebook.com/aileensouldotcom?utm_source=email&utm_medium=email&utm_campaign=wc_freelancer_fb" style="margin:0 15px;"><img src="<?php echo base_url(); ?>assets/img/mail/m-fb.png"></a>
								<a href="https://twitter.com/aileen_soul?utm_source=email&utm_medium=email&utm_campaign=wc_freelancer_twitter" style="margin:0 15px;"><img src="<?php echo base_url(); ?>assets/img/mail/m-twt.png"></a>
								<a href="https://www.linkedin.com/company/aileensoul/?utm_source=email&utm_medium=email&utm_campaign=wc_freelancer_linkedin" style="margin:0 15px;"><img src="<?php echo base_url(); ?>assets/img/mail/m-in.png"></a>
							</td>
						</tr>
						<tr>
							<td style="text-align:center; padding-bottom:15px; font-size:12px;">
								<a href="<?php echo base_url(); ?>terms-and-condition?utm_source=email&utm_medium=email&utm_campaign=wc_freelancer_tc" style="margin:0 15px; color:#5c5c5c; text-decoration:none;">Terms & Conditions</a>
								<a href="<?php echo base_url(); ?>privacy-policy?utm_source=email&utm_medium=email&utm_campaign=wc_freelancer_privacy" style="margin:0 15px; color:#5c5c5c; text-decoration:none;">Privacy Policy</a>
								<a href="<?php echo base_url(); ?>feedback?utm_source=email&utm_medium=email&utm_campaign=wc_freelancer_feedback" style="margin:0 15px; color:#5c5c5c; text-decoration:none;">Feedback</a>
							</td>
						</tr>
						<tr>
							<td style="text-align:center; padding-bottom:15px; font-size:12px;">
								<p>Aileensoul Technologies Private Limited Satellite, Ahmedabad, India.</p>
							</td>
						</tr>
						<tr>
							<td style="text-align:center; padding-bottom:15px; font-size:12px;">
								<p>This email was sent with the intention to give you timely updates. If you don't want to receive any further insiders information, you can <a href="<?php echo $unsubscribe_link; ?>?utm_source=email&utm_medium=email&utm_campaign=wc_freelancer_unsubscribe" style="color:#5c5c5c;"> unsubscribe.</p>
							</td>
						</tr>
						
					</table>
				</td>
			</tr>
		</table>

	</div>
</body>
</html>