<?php
$session_user = $this->session->userdata('aileenuser'); 
if(isset($session_user) && !empty($session_user))
    $cls="";
else
    $cls="mob-side-hdr";?>
<div class="mob-side-menu <?php echo $cls; ?>">
<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="cbp-spmenu-s2">
        <div class="all-profile-box content custom-scroll">
            <ul class="all-pr-list">
                <?php if(empty($session_user)): ?>
				<li><a target="_self" title="Login" href="<?php echo base_url('login'); ?>">Login</a></li>
                <li><a target="_self" title="Create an Account" href="<?php echo base_url('registration'); ?>">Sign Up</a></li>
                <?php endif; ?>
                <li><a target="_self" href="<?php echo $job_right_profile_link; ?>">Job Profile</a></li>
                <li><a target="_self" href="<?php echo $recruiter_right_profile_link; ?>">Recruiter Profile</a></li>
                <li><a target="_self" title="Freelance Employer" href="<?php echo $freelance_hire_right_profile_link; ?>">Freelance Employer Profile</a></li>
				<li><a target="_self" title="Freelance Hire" href="<?php echo $freelance_apply_right_profile_link; ?>">Freelancer Profile</a></li>
                <li><a target="_self" href="<?php echo $business_right_profile_link; ?>">Business Profile</a></li>
                <li><a target="_self" href="<?php echo $artist_right_profile_link; ?>">Artistic Profile</a></li>
                <li><a title="About Us" href="<?php echo base_url('about-us'); ?>">About</a></li>
                <li><a title="Blog" href="<?php echo base_url('blog'); ?>">Blog</a></li>
                <li><a title="Faq" tabindex="0" href="<?php echo base_url('faq'); ?>">FAQ</a></li>
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
<script>
/*var menuRight = document.getElementById( 'cbp-spmenu-s2' ),
showRight = document.getElementById( 'showRight' ),
body = document.body;
showRight.onclick = function() {
    classie.toggle( this, 'active' );
    classie.toggle( menuRight, 'cbp-spmenu-open' );
    disableOther( 'showRight' );
};

function disableOther( button ) {
    if( button !== 'showRight' ) {
        classie.toggle( showRight, 'disabled' );
    }
}*/

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
</script>