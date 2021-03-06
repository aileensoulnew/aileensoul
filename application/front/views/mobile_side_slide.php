<?php
$session_user = $this->session->userdata('aileenuser'); 
if(isset($session_user) && !empty($session_user))
    $cls="";
else
    $cls="mob-side-hdr";?>
<div class="mob-side-menu <?php echo $cls; ?>">
<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="cbp-spmenu-s2">
		<div class="mob-side-close-btn">
			<svg viewBox="0 0 21.9 21.9" width="19px" height="19px">
			  <path d="M14.1,11.3c-0.2-0.2-0.2-0.5,0-0.7l7.5-7.5c0.2-0.2,0.3-0.5,0.3-0.7s-0.1-0.5-0.3-0.7l-1.4-1.4C20,0.1,19.7,0,19.5,0  c-0.3,0-0.5,0.1-0.7,0.3l-7.5,7.5c-0.2,0.2-0.5,0.2-0.7,0L3.1,0.3C2.9,0.1,2.6,0,2.4,0S1.9,0.1,1.7,0.3L0.3,1.7C0.1,1.9,0,2.2,0,2.4  s0.1,0.5,0.3,0.7l7.5,7.5c0.2,0.2,0.2,0.5,0,0.7l-7.5,7.5C0.1,19,0,19.3,0,19.5s0.1,0.5,0.3,0.7l1.4,1.4c0.2,0.2,0.5,0.3,0.7,0.3  s0.5-0.1,0.7-0.3l7.5-7.5c0.2-0.2,0.5-0.2,0.7,0l7.5,7.5c0.2,0.2,0.5,0.3,0.7,0.3s0.5-0.1,0.7-0.3l1.4-1.4c0.2-0.2,0.3-0.5,0.3-0.7  s-0.1-0.5-0.3-0.7L14.1,11.3z" fill="#5c5c5c"/>
			</svg>
			

		</div>
        <div class="all-profile-box content custom-scroll">
            <ul class="all-pr-list">
                <?php if(empty($session_user)): ?>
				<li><a target="_self" title="Login" href="<?php echo base_url('login'); ?>">Login</a></li>
                <li><a target="_self" title="Create an Account" href="<?php echo base_url('registration'); ?>">Sign Up</a></li>
                <?php endif; ?>
                <li><a target="_self" href="<?php echo $business_right_profile_link; ?>">Business Profile</a></li>                
                <li><a title="About Us" href="<?php echo base_url('about-us'); ?>">About</a></li>
                <li><a title="Blog" href="<?php echo base_url('blog'); ?>">Blog</a></li>
                <!-- <li><a title="Faq" tabindex="0" href="<?php //echo base_url('faq'); ?>">FAQ</a></li> -->
                <li><a title="Advertise With Us" href="<?php echo base_url('advertise-with-us'); ?>">Advertise With Us</a></li>
                <li><a title="Sitemap" tabindex="0" href="<?php echo base_url('sitemap'); ?>">Sitemap</a></li>
                <li><a title="Report" tabindex="0" href="<?php echo base_url('report-abuse'); ?>">Report</a></li>
                <li><a title="Contact Us" href="<?php echo base_url('contact-us'); ?>">Contact</a></li>
                <li><a title="Send Us Feedback" href="<?php echo base_url('feedback'); ?>">Feedback</a></li>
                <li><a href="<?php echo base_url('terms-and-condition'); ?>" title="Terms and Condition">Terms and Condition</a></li>
                <li><a href="<?php echo base_url('privacy-policy'); ?>" title="Privacy policy">Privacy Policy</a></li>
                <li><a title="Disclaimer Policy" href="<?php echo base_url('disclaimer-policy'); ?>">Disclaimer Policy</a></li>
						
            </ul>
        </div>
    </nav>
</div>
<script src="<?php echo base_url('assets/js/classie.js?ver=' . time()) ?>"></script>
<script type="text/javascript">
    $('#showRight').click(function(e){
        e.stopPropagation();
        $('#cbp-spmenu-s2').toggleClass('cbp-spmenu-open');
        $('body').toggleClass('spmenu-open');
    });
    $('#cbp-spmenu-s2').click(function(e){
        e.stopPropagation();
    });
    $('body,html').click(function(e){
        $('#cbp-spmenu-s2').removeClass('cbp-spmenu-open');
        $('body').removeClass('spmenu-open');
    });
    $(".mob-side-close-btn").click(function(){
        $(".mob-side-menu .cbp-spmenu.cbp-spmenu-vertical.cbp-spmenu-right").removeClass("cbp-spmenu-open");
        $("body").removeClass("spmenu-open");
    });
</script>