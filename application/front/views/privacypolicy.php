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
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>">
        <?php
        if (IS_OUTSIDE_CSS_MINIFY == '0') {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/common-style.css?ver='.time()); ?>">
			<link rel="stylesheet" href="<?php echo base_url('assets/n-css/component.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/style-main.css?ver='.time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/blog.css?ver='.time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/font-awesome.min.css?ver='.time()); ?>">
            <?php
        } else {
            ?>
              <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/common-style.css?ver='.time()); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css_min/style-main.css?ver='.time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/blog.css?ver='.time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/font-awesome.min.css?ver='.time()); ?>">
        <?php } ?>
        
        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()) ?>"></script>
    <?php $this->load->view('adsense'); ?>
</head>
    <body class="custom-tp privacy-cust outer-page ftr-page report">
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
					</div>
				</header>
            <div class="search-banner cus-search-bnr" >
				
				<div class="container">
					<div class="row">
						<h1 class="text-center">Privacy Policy</h1>
					</div>
				</div>
			</div>
            <section class="middle-main bg_white">
                <div class="container">
                    <div class="pr-pol term_desc">
						<p>This Privacy Policy applies to <a target="_self" href="https://www.aileensoul.com">Aileensoul.com</a></p>
						<p>Aileensoul.com recognizes the importance of maintaining your privacy. We value your privacy and appreciate your trust in us. Our Privacy Policy is intended to clearly describes how we treat user information we collect, use, protect, and with whom it is shared, this will let you make an informed decision about which information you should share with us.</p>
						<h4 class="pt20 pb10">Introduction</h4>
						<p>Aileensoul provides a free platform to each and every person in this world to hire, get a job (Full time or Freelance), grow their business network, show artistic talent and make a career. Also, a platform to learn, post information, questions, and discover great opportunities. Some data are visible to only register members whereas some to visitors (who are not a member).</p>
						<p>This Privacy Policy applies to current and former visitors to our website and to our online users. By visiting and/or using our website, you agree to this Privacy Policy. Make sure you read the whole privacy policy till the end to better understand our services.</p>
						<p>Aileensoul works as a data controller. Aileensoul.com is a property of Aileensoul Technologies Private Limited, an Indian Company registered under the Companies Act, 2013 having its registered office at E- 912, titanium city centre, near Sachin tower, 100 ft. Anandnagar Road, Satellite, Ahmedabad, Gujarat.</p>
						<ul class="policy-list">
							<li>
								<h4><span>1.</span> <span class="h4-title">Information We Collect</span></h4>
								<p>
									We receive, collect and store any information you enter on our website or provide us in any other way. In addition, we collect the Internet protocol (IP) address used to connect your computer to the Internet; login; e-mail address; password; computer and connection information. We use software tools to measure and collect session information, including page response times, length of visits to certain pages, page interaction information, and methods used to browse away from the page. We also collect personally identifiable information (including name, email, password, communications, comments, feedback, product reviews, recommendations, and personal profile).
								</p>
								<b>The information you provide to us</b>
								<ul class="step-ul">
									<li>
										<b>From User</b>
										<p>We collect personal identification details like your name, email, phone number, gender, date of birth, street, city, state, pin code, country and IP address when you create an account on our website or ask us a question through phone or email or on our website or apply for any job posts or respond to our survey.</p>
									</li>
									<li>
										<b id="profile-info">Profile Information</b>
										<p>We collect your educational, work, company, and other details from any of the 5 profile option (Job profile, Recruiter Profile, Artistic Profile, Freelance Profile, and Business Profile) that you opt-in. Some profile details can be viewed by any of the registered members and the non-registered member i.e visitors. You can edit the details which should be shown on any of your profile from account settings.</p>
									</li>
									<li>
										<b>Posting and Uploading</b>
										<p>You can post or upload anything (photos, videos, audio, PDFs, questions, articles and job opportunities) which can be deleted from that particular post from your side. You can retain that data from us within 7 days or else it will be lost permanently.</p>
									</li>
									<li>
										<b>Messages</b>
										<p>We provide private messaging facilities that let you communicate with others. This information is stored with us but we don’t look at the content of it. Remember that even if you delete the message content from your side, the recipients will have their copy.</p>
									</li>
									
								</ul>
								<b id="info-cookie">Information Collected via Cookies</b>
								<p>In order to improve our services, we may collect information about your IP address, the type of mobile device you are using and the browser you're using or the version of the operating system your computer or device is running. We might look at what site you came from, duration of time spent on our website, pages accessed or what site you visit when you leave us.</p>
								<p>All these information are collected through cookie which is stored on your device. We use both persistent cookies and session cookies; persistent cookies remain on your device until you delete them, whilst session cookies automatically expire when you close your browser. We use cookies to understand your preferences while using our services and to serve ads based on your prior visits to your website or other websites. </p>
								<p>We use third-party vendors tracking tools like Google Analytics and Google Adsense that use cookie or web beacons to collect above-mentioned information. From our side, we use a persistent cookie that helps us identifying existing user, so it makes easy for the user to use our Service without signing in again.</p>
								<p>Google's use of advertising cookies enables it and its partners to serve ads to users based on their visit to our sites and/or other sites on the Internet.</p>
								<p>Users may opt out of Google personalized advertising by visiting <a target="_blank" href="https://www.google.com/settings/ads">Ads Settings</a></p>
								<p>To opt-out from Google Analytics cookies install an <a target="_blank" href="https://tools.google.com/dlpage/gaoptout">opt-out browser add-on.</a> </p>
								<p>To opt-out from the third party advertising visit <a target="_blank" href="http://optout.aboutads.info">optout.aboutads.info</a> and <a target="_blank" href="http://optout.networkadvertising.org">www.networkadvertising.org/choices</a>.</p>
								<p>Visit the following link to see how to manage and delete individual browser cookies</p>
								<ul>
									<li><a target="_blank" href="https://support.google.com/chrome/answer/95647?hl=en">Google Chrome</a></li>
									<li><a target="_blank" href="https://support.microsoft.com/en-us/help/260971/description-of-cookies">Internet Explorer</a></li>
									<li><a target="_blank" href="https://support.mozilla.org/en-US/kb/cookies-information-websites-store-on-your-computer">Mozilla Firefox</a></li>
									<li><a target="_blank" href="https://support.apple.com/kb/PH5042?locale=en_US">Safari (Desktop)</a></li>
									<li><a target="_blank" href="https://support.apple.com/en-us/HT201265">Safari (Mobile)</a></li>
									<li><a target="_blank" href="https://support.google.com/nexus/answer/54068?visit_id=1-636629140754579757-1107555236&hl=en&rd=1">Android Browser</a></li>
									<li><a target="_blank" href="https://www.opera.com/help">Opera</a></li>
									<li><a target="_blank" href="https://www.opera.com/help/mobile/android#privacy">Opera Mobile</a></li>
								</ul>
							</li>
							<li>
								<h4><span>2.</span> <span class="h4-title">How We Use Your Data</span></h4>
								<p>We use your information to provide you with our best services.</p>
								<ul class="no-step-ul">
									<li>
										<b>Networking Suggestions</b>
										<p>Our platform helps you search, connect and engage with others (This applies to each 5 profile mentioned in <a href="#profile-info">Profile Information</a>). It’s your choice to accept or decline anybody request. The users who are connected to each other can view each other connections. We use your data to provide you with a contact request, enable others to find you, send an invite and connect. </p>
									</li>
									<li>
										<b>Career Opportunities</b>
										<p>Our platform helps you in finding a job, and be found by the recruiters. Your profile will be visible to a recruiter who is looking to hire for a full-time job or freelance jobs or be hired by you. We use your data to show you jobs/work that best matches your skills and you to recruiters. Note that keeping your profile up to date will help you in finding better opportunities.</p>
									</li>
									<li>
										<b>Keeping You Updated</b>
										<p>Our services provide relevant knowledge, news, and information to individual from their connection and based on the data that we collect through registration form in their feeds.</p>
									</li>
									<li>
										<b>Communication, Support and Marketing</b>
										<p>We will use your email, and phone number to contact you for verification, or for other promotional purposes, or for customer assistance and technical support. We might send you information about new features or products, security, or other service-related notices. These might be our own offers or products, recommendations (Job or People), reminders or third-party offers or products we think you might find interesting. </p>
									</li>
									<li>
										<b>Advertising</b>
										<p>We use the information we have about you to show you personalized ads as mentioned in <a href="#info-cookie">Information collected via cookies</a> sections. </p>
									</li>
									<li>
										<b>Development</b>
										<p>We use the information to improve our products and services. We might use your information to customize your experience with us. This could include displaying content based on your preferences.</p>
									</li>
									<li>
										<b>Security</b>
										<p class="last-p">We may use the information to protect our company, our customers, or our websites from any fraud or any violations as per our <a target="_blank" href="https://www.aileensoul.com/terms-and-condition">terms and conditions.</a></p>
									</li>
								</ul>
							</li>
							<li>
								<h4><span>3.</span> <span class="h4-title">How We Share Your Data</span></h4>
								<ul class="no-step-ul">
									<li>
										<b>Sharing on Our Platform</b>
										<p>Our services include making profiles, sharing posts, articles, questions, and opportunities, like, follow and comment.</p>
										<p>Your profile is visible to other registered members on our website. This makes other to easily connect and know you. Some profile that includes business and artistic profiles are fully visible to visitors and in search engines. </p>
										<p>The article and question you share on our platform can be viewed by anyone and discovered in search engines. Members and Visitors can view your name or profile photo (if posted) associated with that posts.</p>
										<p>Any data you post in your either Artistic or Business profile is visible to members and visitors who view your dashboard page.</p>
										<p>Liking and commenting on another’s content make your name or photo (if uploaded on profile) viewable by others.</p>
										<p>The job opportunity that you post on our website is visible to both members and visitors with your name or photo (if uploaded on profile) which increases the chances of being viewed by more job seekers.</p>
										<p>You are visible on follower list of a person or a business that you follow.</p>
									</li>
									<li>
										<b>Service Providers</b>
										<p>We use Amazon web services to host our website and Google Analytics to understand how the user uses our services. We share data to third parties as subjected in this Privacy Policy and not to use for any other purposes. This policy does not apply to the privacy practices of those websites. For more information on how they use data read <a target="_blank" href="https://aws.amazon.com/privacy/">Amazon Privacy</a> and <a target="_blank" href="https://policies.google.com/technologies/partner-sites">Google Privacy pages.</a></p>
									</li>
									<li>
										<b>Legal </b>
										<p>We may share information if we think we have to in order to comply with the law or is necessary. We will share information to respond to a court order or subpoena. We may also share it if a government agency or investigatory body requests. Or, we might also share information when we are investigating potential fraud to prove our integrity. We may notify you about legal disclosures if permitted by law.</p>
									</li>
									<li>
										<b>Business Partner or Sale</b>
										<p class="last-p">We may share information with our business partners. This includes a third party who provide or sponsor an event, or who operates a venue where we hold events. Our partners use the information we give them as described in their privacy policies. Also, if part of our business is sold we may give our customer list as part of that transaction and the permission to use our data in a way as mentioned in this privacy policy.</p>
									</li>
								</ul>
							</li>
							<li>
								<h4><span>4.</span> <span class="h4-title">Your Rights Regarding the Use of Your Personal Information</span></h4>
								<p>We provide the user with the right to change their data from account settings. We even give our user with an option to contact us regarding changing or correcting details, erase or delete or deactivating account, to object or limit or restrict us from using personal data (if we don’t hold any legal rights), ask a copy of personal information that is associated with their account that we hold via email.</p>
								<p>We also provide you with a choice to stop receiving our promotional emails. You can opt-out by following the unsubscribe instructions mentioned in the email itself. It may take about ten days to process your request. Note that even if you opt out of getting marketing messages, we can still send you messages regarding security, legal and privacy updates.</p>
								<p class="last-p">Please refer the <a href="#contact-info">Contact Information</a> section to contact us.</p>
							</li>
							<li>
								<h4><span>5.</span> <span class="h4-title">How We Protect Your Information</span></h4>
								<p>We implement security measures designed to protect your information from unauthorized access. Your account is protected by your account password and we urge you to take steps to keep your personal information safe by not disclosing your password and by logging out of your account after each session. We further protect your information from potential security breaches by implementing certain technological security measures including encryption, firewalls and secure socket layer technology (HTTPS).</p>
								<p class="last-p">However, these measures do not guarantee that your information will not be accessed, disclosed, altered or destroyed by breach of such firewalls and secure server software. By using our Service, you acknowledge that you understand and agree to assume these risks.</p>
							</li>
							<li>
								<h4><span>6.</span> <span class="h4-title">Links to Other Websites</span></h4>
								<p>As part of the Service, we may have links to other websites or applications. However, we are not responsible for the privacy practices employed by those websites or the information or content they contain.</p>
								<p class="last-p">This Privacy Policy applies solely to information collected by us through the Site and the Service. Therefore, this Privacy Policy does not apply to your use of a third party website accessed by selecting a link on our Site or via our Service. To the extent that you access or use the Service through or on another website or application, then the privacy policy of that other website or application will apply to your access or use of that site or application. We encourage our users to read the privacy statements of other websites before proceeding to use them.</p>
							</li>
							<li>
								<h4><span>7.</span> <span class="h4-title">Lawful Basis for Processing Personal Data</span></h4>
								<p class="last-p">We collect data that are necessary to provide you relevant services and are covered by laws. If you use our Services, you consent to the collection, use and sharing of your personal data under this Privacy Policy (which includes usage of Cookies and other documents referenced in this Privacy Policy) and agree to our Terms & Conditions. We provide you choices that allow you to opt-out or control how we use and share your data.</p>
							</li>
							<li>
								<h4 id="contact-info"><span>8.</span> <span class="h4-title">Contact Information</span></h4>
								<p class="last-p">If you have any queries, questions about this Policy or other privacy concerns, you can also email us at <a href="mailto:info@aileensoul.com ">info@aileensoul.com</a> <a href="mailto:inquiry@aileensoul.com">inquiry@aileensoul.com</a> , <a href="mailto:aileensoulinquiry@gmail.com">aileensoulinquiry@gmail.com</a></p>
							</li>
							<li>
								<h4><span>9.</span> <span class="h4-title">Changes to Privacy Policy</span></h4>
								<p class="last-p">This Privacy Policy was last updated on 25.05.2018. We reserve the right to modify this privacy policy. From time to time we may change our privacy practices, so please check our site periodically for updates. We will notify you of any material changes to this policy as required by law. We will also post a notification on our website or send a notice on email address specified in your account.</p>
							</li>
							<li>
								<h4><span>10.</span><span class="h4-title"> Jurisdiction</span></h4>
								<p class="last-p">If you choose to visit the website, your visit and any dispute over privacy are subject to this Policy and the website's terms of use. In addition to the foregoing, any disputes arising under this Policy shall be governed by the laws of Government of India.</p>
							</li>
						</ul>
					</div>
                </div>
            </section>
        </div>
		<?php $this->load->view('mobile_side_slide'); ?>
        <?php
            echo $login_footer
        ?>
    </body>
</html>
