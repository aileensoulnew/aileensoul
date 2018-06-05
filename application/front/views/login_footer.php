<?php
if ($this->uri->segment(1) == '' || $this->uri->segment(1) == 'main' || $this->uri->segment(1) == 'profiles') {
    ?>
    <footer class="footer">
        <?php
    } else {
        ?>
        <footer>    
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
                            <li><a title="Login" href="<?php echo base_url('login'); ?>" target="_blank">Login</a></li>
                            <li><a title="Create an Account" href="<?php echo base_url('registration'); ?>" target="_blank">Sign Up</a></li>
                            <?php
                        }
                        ?>

                        <li><a title="Job Profile" href="<?php echo $job_right_profile_link; ?>" target="_blank">Job Profile</a></li>
                        <li><a title="Recruiter Profile" href="<?php echo $recruiter_right_profile_link; ?>" target="_blank">Recruiter Profile</a></li>
                        <li><a title="Freelance Hire" href="<?php echo $freelance_hire_right_profile_link; ?>" target="_blank">Freelancer Profile</a></li>
						<li><a title="Freelance Employer" href="<?php echo $freelance_apply_right_profile_link; ?>" target="_blank">Freelance Employer Profile</a></li>
						
                        <!--<li><a title="Freelance Jobs" href="<?php //echo base_url('freelance-jobs'); ?>" target="_blank">Freelance Jobs</a></li> 
                        <li><a title="Freelance Profile" href="<?php //echo base_url('how-to-use-freelance-profile-in-aileensoul'); ?>" target="_blank">Freelance Profile</a></li> -->
                        <li><a title="Business Profile" href="<?php echo $business_right_profile_link; ?>" target="_blank">Business Profile</a></li>
                        <li><a title="Artistic Profile" href="<?php echo $artist_right_profile_link; ?>" target="_blank">Artistic Profile</a></li>
                        <li><a title="About Us" href="<?php echo base_url('about-us'); ?>"  target="_blank">About</a></li>
						<li><a title="Blog" href="<?php echo base_url('blog'); ?>" target="_blank">Blog</a></li>
						<li><a title="Faq" tabindex="0" href="<?php echo base_url('faq'); ?>" target="_blank">FAQ</a></li>
						<li><a title="Advertise With Us" href="<?php echo base_url('advertise-with-us'); ?>" target="_blank">Advertise With Us</a></li>
						<li><a title="Sitemap" tabindex="0" href="<?php echo base_url('sitemap'); ?>" target="_blank">Sitemap</a></li>
						<li><a title="Report" tabindex="0" href="<?php echo base_url('report-abuse'); ?>" target="_blank">Report</a></li>
						<li><a title="Contact Us" href="<?php echo base_url('contact-us'); ?>"  target="_blank">Contact</a></li>
						<li><a title="Send Us Feedback" href="<?php echo base_url('feedback'); ?>" target="_blank">Feedback</a></li>
					</ul>
					<ul class="footer-ul pt5 pb10">
						<li> Aileensoul Ⓒ 2018 </li>
                        <li>|<a href="<?php echo base_url('terms-and-condition'); ?>" title="Terms and Condition" target="_blank">Terms and Condition</a></li>
                        <li>|<a href="<?php echo base_url('privacy-policy'); ?>" title="Privacy policy" target="_blank">Privacy Policy</a></li>
                        <li>|<a title="Disclaimer Policy" href="<?php echo base_url('disclaimer-policy'); ?>"  target="_blank">Disclaimer Policy</a></li>
                  
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