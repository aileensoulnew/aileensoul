<li class="dropdown hd-profile">
	<a href="#" class="btn4">Profiles </a>
	<ul class="dropdown-menu">
		<div class="all-profile-box">
			<ul class="all-pr-list">
				<li>
					<a href="<?php echo $this->job_profile_link; ?>" title="Job Profile">
						<div class="all-pr-img">
							<img src="<?php echo base_url('assets/n-images/i1.jpg?ver='.time()) ?>" alt="Job Profile">
						</div>
						<span>Job Profile</span>
					</a>
				</li>
				<li>
					<a href="<?php echo base_url('recruiter/') ?>" title="Recruiter Profile">
						<div class="all-pr-img">
							<img src="<?php echo base_url('assets/n-images/i2.jpg?ver='.time()) ?>" alt="Recruiter Profile">
						</div>
						<span>Recruiter Profile</span>
					</a>
				</li>
				<li>
					<a href="<?php echo $freelance_hire_right_profile_link; ?>" title="Freelance Employer">
						<div class="all-pr-img">
							<img src="<?php echo base_url('assets/n-images/i31.png?ver='.time()) ?>" alt="Freelance Profile">
						</div>
						<span>Freelance Employer</span>
					</a>
				</li>
				<li>
					<a href="<?php echo $freelance_apply_right_profile_link; ?>" title="Freelancer Profile">
						<div class="all-pr-img">
							<img src="<?php echo base_url('assets/n-images/i3.jpg?ver='.time()) ?>" alt="Freelancer Profile">
						</div>
						<span>Freelancer Profile</span>
					</a>
				</li>
				<li>
					<a href="<?php echo base_url('business-search/') ?>" title="Business Profile">
						<div class="all-pr-img">
							<img src="<?php echo base_url('assets/n-images/i4.jpg?ver='.time()) ?>" alt="Business Profile">
						</div>
						<span>Business Profile</span>
					</a>
				</li>
				<li>
					<a href="<?php echo base_url('find-artist/') ?>" title="Artistic Profile">
						<div class="all-pr-img">
							<img src="<?php echo base_url('assets/n-images/i5.jpg?ver='.time()) ?>" alt="Artistic Profile">
						</div>
						<span>Artistic Profile</span>
					</a>
				</li>
			</ul>
		</div>
	</ul>
</li>
<script>
	$(function(){
		$(".dropdown").hover(            
            function() {
                $('.dropdown-menu', this).stop( true, true ).fadeIn("fast");
                $(this).toggleClass('open');
                $('b', this).toggleClass("caret caret-up");                
            },
            function() {
                $('.dropdown-menu', this).stop( true, true ).fadeOut("fast");
                $(this).toggleClass('open');
                $('b', this).toggleClass("caret caret-up");                
            });
    });
</script>