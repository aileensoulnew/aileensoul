<div class="col-md-3 col-sm-3">
    <div class="job-profile-left-side-bar">
        <div class="left-side-bar">
            <ul>
                <li <?php if (($this->uri->segment(1) == 'freelance-hire') && ($this->uri->segment(2) == 'projects')) { ?> class="active" <?php } ?>><a href="<?php echo base_url('freelance-employer/projects'); ?>">Home</a>
                </li>

                <li <?php if (($this->uri->segment(1) == 'freelance-hire') && ($this->uri->segment(2) == 'employer-details')) { ?> class="active" <?php } ?>><a href="<?php echo base_url('freelance-employer/'. $free_hire_login_slug); ?>">Employer Profile</a>
                </li>
                <?php if (($this->uri->segment(1) == 'freelance-hire') && ($this->uri->segment(2) == 'projects' || $this->uri->segment(2) == 'employer-details' || $this->uri->segment(2) == 'add-projects' || $this->uri->segment(2) == 'freelancer-save') && ($this->uri->segment(3) == $this->session->userdata('aileenuser') || $this->uri->segment(3) == '')) { ?>
                    <li <?php if (($this->uri->segment(1) == 'freelance-hire') && ($this->uri->segment(2) == 'add-projects')) { ?> class="active" <?php } ?>><a href="<?php echo base_url('post-freelance-project'); ?>">Add New Post</a>
                    </li>
                    <li <?php if (($this->uri->segment(1) == 'freelance-hire') && ($this->uri->segment(2) == 'freelancer-save')) { ?> class="active" <?php } ?>><a href="<?php echo base_url('freelance-employer/saved-freelancer'); ?>">Saved Freelancer</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>