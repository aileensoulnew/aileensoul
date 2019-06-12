<!DOCTYPE html>
<html>
<head>
<title>Welcome Mail</title>
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
	.btn:hover{/*opacity:0.8;*/}
</style>
</head>
<body>
	
	<div style="max-width:600px; margin:0 auto;">
		<table width="100%" style="background:#fff; border:1px solid #d2d2d2; border-radius:10px;" cellpadding="0" cellspacing="0">
			<tr>
				<td style="border-bottom:1px solid #ddd; padding:30px 20px; text-align:center;">
					<table width="100%" cellpadding="0" cellspacing="0">
						<tr>
							<td>
								<img src="<?php echo base_url(); ?>assets/img/mail/m-logo.png">
								<p style="color:#5c5c5c; font-size:45px;">WELCOME</p>
								<p style="color:#5c5c5c; font-size:22px;letter-spacing:4.5px;"> TO AILEENSOUL</p>
								<p style="padding-top:20px; font-size:16px; line-height:1.5;">
									We provide platform & opportunities<br>
									to every person in the world to make their career.
								</p>
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
								<p>Hello <?php echo ucwords($user_data['first_name']); ?>,</p>
								<p style="padding-top:20px;">We are happy to have you on board. Let's get started.</p>
							</td>
						</tr>
						<tr>
							<td style="padding-top:30px; text-align:center;">
								<a href="<?php echo base_url(); ?>login?utm_source=email&utm_medium=email&utm_campaign=welcome_button1" class="btn">Explore Aileensoul</a>
							</td>
						</tr>
						<tr>
							<td style="padding-top:30px;">
								<p style="font-size:18px; line-height:1.5;">As you're new here, let me give you a sneak peek at things you can do on Aileensoul Platform.</p>
							</td>
						</tr>
						<tr>
							<td>
								<table width="100%" cellpadding="0" cellspacing="0">
									<tr>
										<td style="padding-top:30px;">
											<table width="100%" cellpadding="0" cellspacing="0">
												<tr>
													<td style="width:90px; vertical-align:top; padding-top:3px;">
														<img src="<?php echo base_url(); ?>assets/img/mail/m-op.png">
													</td>
													<td>
														<p style="font-size:17px; font-weight:bold;">Post Opportunity</p>
														<p style="line-height:1.5; padding-top:5px;">Increase the visibility of your career opportunities by posting it directly in feeds.</p>
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<!-- <tr>
										<td style="padding-top:30px;">
											<table width="100%" cellpadding="0" cellspacing="0">
												<tr>
													<td style="width:90px; vertical-align:top; padding-top:3px;">
														<img src="<?php //echo base_url(); ?>assets/img/mail/m-job.png">
													</td>
													<td>
														<p style="font-size:17px; font-weight:bold;">Get Job</p>
														<p style="line-height:1.5; padding-top:5px;"><a href="<?php //echo base_url(); ?>job-search?utm_source=email&utm_medium=email&utm_campaign=welcome_job">Search job</a> opportunities, apply, connect with recruiters and get hired.</p>
													</td>
												</tr>
											</table>
										</td>
									</tr> 
									<tr>
										<td style="padding-top:30px;">
											<table width="100%" cellpadding="0" cellspacing="0">
												<tr>
													<td style="width:90px; vertical-align:top; padding-top:3px;">
														<img src="<?php //echo base_url(); ?>assets/img/mail/m-rec.png">
													</td>
													<td>
														<p style="font-size:17px; font-weight:bold;">Hire People</p>
														<p style="line-height:1.5; padding-top:5px;"><a href="<?php //echo base_url(); ?>recruiter?utm_source=email&utm_medium=email&utm_campaign=welcome_recruiter">Post your job</a> or search and recruit the best talent from aileensoul.</p>
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td style="padding-top:30px;">
											<table width="100%" cellpadding="0" cellspacing="0">
												<tr>
													<td style="width:90px; vertical-align:top; padding-top:3px;">
														<img src="<?php //echo base_url(); ?>assets/img/mail/m-get-free.png">
													</td>
													<td>
														<p style="font-size:17px; font-weight:bold;">Get Freelance Work</p>
														<p style="line-height:1.5; padding-top:5px;">Search <a href="<?php //echo base_url(); ?>freelance-jobs?utm_source=email&utm_medium=email&utm_campaign=welcome_freelancer">freelance jobs</a>, save, apply and get the job.</p>
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td style="padding-top:30px;">
											<table width="100%" cellpadding="0" cellspacing="0">
												<tr>
													<td style="width:90px; vertical-align:top; padding-top:3px;">
														<img src="<?php //echo base_url(); ?>assets/img/mail/m-hire-free.png">
													</td>
													<td>
														<p style="font-size:17px; font-weight:bold;">Hire Freelancers</p>
														<p style="line-height:1.5; padding-top:5px;">Post your requirement; Get best recommendations, and <a href="<?php //echo base_url(); ?>freelance-employer?utm_source=email&utm_medium=email&utm_campaign=welcome_employer">hire freelancers.</a></p>
													</td>
												</tr>
											</table>
										</td>
									</tr>-->
									<tr>
										<td style="padding-top:30px;">
											<table width="100%" cellpadding="0" cellspacing="0">
												<tr>
													<td style="width:90px; vertical-align:top; padding-top:3px;">
														<img src="<?php echo base_url(); ?>assets/img/mail/m-bus.png">
													</td>
													<td>
														<p style="font-size:17px; font-weight:bold;">Business Listing</p>
														<p style="line-height:1.5; padding-top:5px;"><a href="<?php echo base_url(); ?>business-search?utm_source=email&utm_medium=email&utm_campaign=welcome_business">List your business</a> and get found online.</p>
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td style="padding-top:30px;">
											<table width="100%" cellpadding="0" cellspacing="0">
												<tr>
													<td style="width:90px; vertical-align:top; padding-top:3px;">
														<img src="<?php echo base_url(); ?>assets/img/mail/m-bus-net.png">
													</td>
													<td>
														<p style="font-size:17px; font-weight:bold;">Grow Business Network</p>
														<p style="line-height:1.5; padding-top:5px;">Find, connect, interact and see what's happening in other sectors.</p>
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<!--<tr>
										<td style="padding-top:30px;">
											<table width="100%" cellpadding="0" cellspacing="0">
												<tr>
													<td style="width:90px; vertical-align:top; padding-top:3px;">
														<img src="<?php //echo base_url(); ?>assets/img/mail/m-art.png">
													</td>
													<td>
														<p style="font-size:17px; font-weight:bold;">Show Your Talent</p>
														<p style="line-height:1.5; padding-top:5px;">Find, <a href="<?php //echo base_url(); ?>find-artist?utm_source=email&utm_medium=email&utm_campaign=welcome_artist">connect with other artist</a> and showcase your art and talent.</p>
													</td>
												</tr>
											</table>
										</td>
									</tr>-->
									<tr>
										<td style="padding-top:30px;">
											<table width="100%" cellpadding="0" cellspacing="0">
												<tr>
													<td style="width:90px; vertical-align:top; padding-top:3px;">
														<img src="<?php echo base_url(); ?>assets/img/mail/m-net.png">
													</td>
													<td>
														<p style="font-size:17px; font-weight:bold;">Build Network</p>
														<p style="line-height:1.5; padding-top:5px;">Find and connect with others, and expand your network and knowledge.</p>
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td style="padding-top:30px;">
											<table width="100%" cellpadding="0" cellspacing="0">
												<tr>
													<td style="width:90px; vertical-align:top; padding-top:3px;">
														<img src="<?php echo base_url(); ?>assets/img/mail/m-ask.png">
													</td>
													<td>
														<p style="font-size:17px; font-weight:bold;">Ask Questions</p>
														<p style="line-height:1.5; padding-top:5px;">Ask any question and get the answers.</p>
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td style="padding-top:30px;">
											<table width="100%" cellpadding="0" cellspacing="0">
												<tr>
													<td style="width:90px; vertical-align:top; padding-top:3px;">
														<img src="<?php echo base_url(); ?>assets/img/mail/m-article.png">
													</td>
													<td>
														<p style="font-size:17px; font-weight:bold;">Post Article</p>
														<p style="line-height:1.5; padding-top:5px;">Want a platform to post your article? Aileensoul provides that platform too. Write, post and share your content with others.</p>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td style="padding-top:30px; text-align:center;">
								<a href="<?php echo base_url(); ?>login?utm_source=email&utm_medium=email&utm_campaign=welcome_button2" class="btn">Get Started Now</a>
							</td>
						</tr>
						<tr>
							<td style="padding-top:30px; text-align:center; padding-bottom:30px; border-bottom:1px solid #d2d2d2;">
								<p>Why let opportunity on hold when you don't have to pay for anything?</p>
							</td>
						</tr>
						<tr>
							<td style="padding-top:25px; text-align:center; padding-bottom:15px;">
								<a href="https://www.facebook.com/aileensouldotcom?utm_source=email&utm_medium=email&utm_campaign=welcome_fb" style="margin:0 15px;"><img src="<?php echo base_url(); ?>assets/img/mail/m-fb.png"></a>
								<a href="https://twitter.com/aileen_soul?utm_source=email&utm_medium=email&utm_campaign=welcome_twitter" style="margin:0 15px;"><img src="<?php echo base_url(); ?>assets/img/mail/m-twt.png"></a>
								<a href="https://www.linkedin.com/company/aileensoul/?utm_source=email&utm_medium=email&utm_campaign=welcome_linkedin" style="margin:0 15px;"><img src="<?php echo base_url(); ?>assets/img/mail/m-in.png"></a>
							</td>
						</tr>
						<tr>
							<td style="text-align:center; padding-bottom:15px; font-size:12px;">
								<a href="<?php echo base_url(); ?>terms-and-condition?utm_source=email&utm_medium=email&utm_campaign=welcome_tc" style="margin:0 15px; color:#5c5c5c; text-decoration:none;">Terms & Conditions</a>
								<a href="<?php echo base_url(); ?>privacy-policy?utm_source=email&utm_medium=email&utm_campaign=welcome_privacy" style="margin:0 15px; color:#5c5c5c; text-decoration:none;">Privacy Policy</a>
								<a href="<?php echo base_url(); ?>feedback?utm_source=email&utm_medium=email&utm_campaign=welcomefeedback" style="margin:0 15px; color:#5c5c5c; text-decoration:none;">Feedback</a>
							</td>
						</tr>
						<tr>
							<td style="text-align:center; padding-bottom:15px; font-size:12px;">
								<p>Aileensoul Technologies Private Limited Satellite, Ahmedabad, India.</p>
							</td>
						</tr>
						<tr>
							<td style="text-align:center; padding-bottom:15px; font-size:12px;">
								<p>This email was sent with the intention to give you timely updates. If you don't want to receive any further insiders information, you can <a href="<?php echo $unsubscribe_link; ?>?utm_source=email&utm_medium=email&utm_campaign=welcome_unsubscribe" style="color:#5c5c5c;"> unsubscribe.</p>
							</td>
						</tr>
						
					</table>
				</td>
			</tr>
		
			
			
		</table>

	</div>
</body>
</html>