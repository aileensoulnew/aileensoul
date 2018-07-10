<?php
if($this->session->userdata('aileenuser') != "") {
    $class = "login_footer";
}
else
{
    $class = "no_login_footer";
}
if ($this->uri->segment(1) == '' || $this->uri->segment(1) == 'main' || $this->uri->segment(1) == 'profiles') {
    ?>
    <footer class="footer <?php echo $class; ?>">
        <?php
    } else {
        ?>
        <footer class="<?php echo $class; ?>">    
            <?php
        }
        ?>
        <div class="container pt5">
            <div class="row">

                <div class="fw text-center">
                    <ul class="footer-ul">
                        <?php
                        if (!$this->session->userdata('aileenuser')) {
                            ?>
                            <li><a target="_self" title="Login" href="<?php echo base_url('login'); ?>">Login</a></li>
                            <li><a target="_self" title="Create an Account" href="<?php echo base_url('registration'); ?>">Sign Up</a></li>
                            <?php
                        }
                        ?>
                        <li><a target="_self" title="Job Profile" href="<?php echo $job_right_profile_link; ?>">Job Profile</a></li>
                        <li><a target="_self" title="Recruiter Profile" href="<?php echo $recruiter_right_profile_link; ?>">Recruiter Profile</a></li>
						<li><a target="_self" title="Freelance Employer" href="<?php echo $freelance_hire_right_profile_link; ?>">Freelance Employer Profile</a></li>
                        <li><a target="_self" title="Freelance Hire" href="<?php echo $freelance_apply_right_profile_link; ?>">Freelancer Profile</a></li>
						
                        <!--<li><a title="Freelance Jobs" href="<?php //echo base_url('freelance-jobs'); ?>">Freelance Jobs</a></li> 
                        <li><a title="Freelance Profile" href="<?php //echo base_url('how-to-use-freelance-profile-in-aileensoul'); ?>">Freelance Profile</a></li> -->
                        <li><a target="_self" title="Business Profile" href="<?php echo $business_right_profile_link; ?>">Business Profile</a></li>
                        <li><a target="_self" title="Artistic Profile" href="<?php echo $artist_right_profile_link; ?>">Artistic Profile</a></li>
                        <li><a target="_self" title="About Us" href="<?php echo base_url('about-us'); ?>">About</a></li>
						<li><a target="_self" title="Blog" href="<?php echo base_url('blog'); ?>">Blog</a></li>
						<li><a target="_self" title="Faq" tabindex="0" href="<?php echo base_url('faq'); ?>">FAQ</a></li>
						<li><a target="_self" title="Advertise With Us" href="<?php echo base_url('advertise-with-us'); ?>">Advertise With Us</a></li>
						<li><a target="_self" title="Sitemap" tabindex="0" href="<?php echo base_url('sitemap'); ?>">Sitemap</a></li>
						<li><a target="_self" title="Report" tabindex="0" href="<?php echo base_url('report-abuse'); ?>">Report</a></li>
						<li><a target="_self" title="Contact Us" href="<?php echo base_url('contact-us'); ?>">Contact</a></li>
						<li><a target="_self" title="Send Us Feedback" href="<?php echo base_url('feedback'); ?>">Feedback</a></li>
					</ul>
					<ul class="footer-ul pt5 pb10">
						<li> Aileensoul Ⓒ 2018 </li>
                        <li>|<a target="_self" href="<?php echo base_url('terms-and-condition'); ?>" title="Terms and Condition" >Terms and Condition</a></li>
                        <li>|<a target="_self" href="<?php echo base_url('privacy-policy'); ?>" title="Privacy policy">Privacy Policy</a></li>
                        <li>|<a target="_self" title="Disclaimer Policy" href="<?php echo base_url('disclaimer-policy'); ?>">Disclaimer Policy</a></li>
                  
                    </ul>
                </div>
            
            </div>
        </div>
    </footer>
    <!-- IMAGE PRELOADER SCRIPT -->
    <script type="text/javascript">
        /*$.fn.preload = function (fn) {
            var len = this.length, i = 0;
            return this.each(function () {
                var tmp = new Image, self = this;
                if (fn)
                    tmp.onload = function () {
                        fn.call(self, 100 * ++i / len, i === len);
                    };
                tmp.src = this.src;
            });
        };

        $('img').preload(function (perc, done) {
            console.log(this, perc, done);
        }); */
    </script>
    <!-- IMAGE PRELOADER SCRIPT -->