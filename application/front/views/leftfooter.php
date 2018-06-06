<div class="custom_footer_left fw">
    <div class="">
        <ul>
            <li><a href="<?php echo base_url('about-us'); ?>" target="_blank">About</a></li>
			<li><a href="<?php echo base_url('blog'); ?>" target="_blank">Blog</a></li>
			<li><a href="<?php echo base_url('faq'); ?>" target="_blank">Faq</a></li>
			<li><a href="<?php echo base_url('advertise-with-us'); ?>" target="_blank">Advertise With Us</a></li>
			<!-- <li><a title="Sitemap" href="<?php //echo base_url('sitemap'); ?>" target="_blank">Sitemap</a></li> -->
			<li><a title="Report" href="<?php echo base_url('report-abuse'); ?>" target="_blank">Report </a></li>
			<li><a href="<?php echo base_url('contact-us'); ?>" target="_blank">Contact</a></li>
			<li><a href="<?php echo base_url('feedback'); ?>" target="_blank">Feedback</a></li>
			<li><a href="<?php echo base_url('terms-and-condition'); ?>" target="_blank">Terms &amp; Condition </a></li>
            <li><a href="<?php echo base_url('privacy-policy'); ?>" target="_blank">Privacy Policy</a></li>
			<li><a title="Disclaimer Policy" href="<?php echo base_url('disclaimer-policy'); ?>" target="_blank">Disclaimer Policy</a></li>
			<li><a id="trigger" class="click-profiles" style="" href="javascript:void(0)">Profiles <i class="fa fa-sort-asc" aria-hidden="true"></i></a>
                <div class="click-nav">
                    <ul id="drop" class="left-ftr-profiles">
                        <li>
                            <a href="<?php echo $job_right_profile_link; ?>" target="_blank">  Job Profiles</a>
                        </li>
                        <li>
                            <a href="<?php echo $recruiter_right_profile_link; ?>" target="_blank">Recruiter Profile</a>
                        </li>
                        <li>
                            <a href="<?php echo $freelance_hire_right_profile_link; ?>" target="_blank">Freelance Employer</a>
                        </li>
                        <li>
                            <a href="<?php echo $freelance_apply_right_profile_link; ?>" target="_blank">Freelance Job</a>
                        </li>
                        <li>
                            <a href="<?php echo $business_right_profile_link; ?>" target="_blank">Business Profile</a>
                        </li>
                        <li>
                            <a href="<?php echo $artist_right_profile_link; ?>" target="_blank">Artistic Profile</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>

    </div>
</div>



<script>
    $(document).on('click', '#trigger', function (event) {
        event.stopPropagation();
        $('#drop').toggle();
    });

    $(document).click(function () {
        $('#drop').hide();
    });
</script>