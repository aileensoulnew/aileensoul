<div class="all-profile-box">
    <div class="all-pro-head">
        <h4>Profiles
            <?php if($this->session->userdata('aileenuser')){ ?>
                <a target="_self" href="<?php echo $all_right_profile_link; ?>" class="pull-right" title="All">All
                </a>
            <?php } ?>
        </h4>
    </div>
    <ul class="all-pr-list">
        <li>
            <a target="_self" href="<?php echo $job_right_profile_link; ?>" title="Job Profile">
                <div class="all-pr-img">
                    <img src="<?php echo base_url('assets/img/i1.jpg'); ?>" alt="<?php echo "i1.jpg"; ?>">
                </div>
                <span>Job Profile <span>(Find Jobs)</span></span>
            </a>
        </li>
        <li>
            <a target="_self" href="<?php echo $recruiter_right_profile_link; ?>" title="Recruiter Profile">
                <div class="all-pr-img">
                    <img src="<?php echo base_url('assets/img/i2.jpg'); ?>" alt="<?php echo "i2.jpg"; ?>">
                </div>
                <span>Recruiter Profile <span>(Post Jobs)</span></span>
            </a> 
        </li>
        <li>
            <a href="<?php echo $freelance_hire_right_profile_link; ?>" title="Freelance Employer">
                <div class="all-pr-img">
                    <img src="<?php echo base_url('assets/n-images/i31.png?ver='.time()) ?>" alt="Freelance Profile">
                </div>
                <span>Freelance Employer <span>(Hire Freelancers)</span></span>
            </a>
        </li>
        <li>
            <a href="<?php echo $freelance_apply_right_profile_link; ?>" title="Freelancer Profile">
                <div class="all-pr-img">
                    <img src="<?php echo base_url('assets/n-images/i3.jpg?ver='.time()) ?>" alt="Freelancer Profile">
                </div>
                <span>Freelancer Profile <span>(Freelance Jobs)</span></span>
            </a>
        </li>
        <!-- <li>
            <a target="_self" href="<?php echo $freelance_right_profile_link; ?>" title="Freelance Profile">
                <div class="all-pr-img">
                    <img src="<?php echo base_url('assets/img/i3.jpg'); ?>" alt="<?php echo "i3.jpg"; ?>">
                </div>
                <span>Freelance Profile</span>
            </a>
        </li> -->
        <li>
            <a target="_self" href="<?php echo $business_right_profile_link; ?>" title="Business Profile">
                <div class="all-pr-img">
                    <img src="<?php echo base_url('assets/img/i4.jpg'); ?>" alt="<?php echo "i4.jpg"; ?>">
                </div>
                <span>Business Profile <span>(Add Company)</span></span>
            </a>
        </li>
        <li>
            <a target="_self" href="<?php echo $artist_right_profile_link; ?>" title="Artistic Profile">
                <div class="all-pr-img">
                    <img src="<?php echo base_url('assets/img/i5.jpg'); ?>" alt="<?php echo "i5.jpg"; ?>">
                </div>
                <span>Artistic Profile <span>(Show your Art)</span></span>
            </a>
        </li>
    </ul>
</div>
