<div class="custom_footer_left fw">
    <div class="">
        <ul>
            <li><a href="<?php echo base_url('about-us'); ?>" target="_self">About</a></li>
			<li><a href="<?php echo base_url('blog'); ?>" target="_self">Blog</a></li>
			<li><a href="<?php echo base_url('faq'); ?>" target="_self">Faq</a></li>
			<li><a href="<?php echo base_url('advertise-with-us'); ?>" target="_self">Advertise With Us</a></li>
			<li><a title="Sitemap" href="<?php echo base_url('sitemap'); ?>" target="_self">Sitemap</a></li>
			<li><a title="Report" href="<?php echo base_url('report-abuse'); ?>" target="_self">Report </a></li>
			<li><a href="<?php echo base_url('contact-us'); ?>" target="_self">Contact</a></li>
			<li><a href="<?php echo base_url('feedback'); ?>" target="_self">Feedback</a></li>
			<li><a href="<?php echo base_url('terms-and-condition'); ?>" target="_self">Terms &amp; Condition </a></li>
            <li><a href="<?php echo base_url('privacy-policy'); ?>" target="_self">Privacy Policy</a></li>
			<li><a title="Disclaimer Policy" href="<?php echo base_url('disclaimer-policy'); ?>" target="_self">Disclaimer Policy</a></li>
			<li><a id="trigger" class="click-profiles" style="" href="javascript:void(0)">Profiles <i class="fa fa-sort-asc" aria-hidden="true"></i></a>
                <div class="click-nav">
                    <ul id="drop" class="left-ftr-profiles">
                        <li>
                            <a target="_self" href="<?php echo $job_right_profile_link; ?>">  Job Profiles</a>
                        </li>
                        <li>
                            <a target="_self" href="<?php echo $recruiter_right_profile_link; ?>">Recruiter Profile</a>
                        </li>
                        <li>
                            <a target="_self" href="<?php echo $freelance_hire_right_profile_link; ?>">Freelance Employer</a>
                        </li>
                        <li>
                            <a target="_self" href="<?php echo $freelance_apply_right_profile_link; ?>">Freelance Job</a>
                        </li>
                        <li>
                            <a target="_self" href="<?php echo $business_right_profile_link; ?>">Business Profile</a>
                        </li>
                        <li>
                            <a target="_self" href="<?php echo $artist_right_profile_link; ?>">Artistic Profile</a>
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