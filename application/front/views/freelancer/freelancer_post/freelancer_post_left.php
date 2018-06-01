<?php
$userid = $this->session->userdata('aileenuser');
$fa_slug = $this->db->select('freelancer_apply_slug')->get_where('freelancer_post_reg', array('user_id' => $freepostdata['user_id'], 'status' => '1'))->row()->freelancer_apply_slug;
?><div class="col-md-3 col-sm-3">
    <div class="job-profile-left-side-bar">
        <div class="left-side-bar">
            <ul>
                <?php if (($this->uri->segment(1) == 'freelancer') && ($this->uri->segment(2) == 'freelancer-details' || $this->uri->segment(2) == 'home' || $this->uri->segment(2) == 'saved-projects' || $this->uri->segment(2) == 'applied-projects') && ($this->uri->segment(3) == $this->session->userdata('aileenuser') || $this->uri->segment(3) == '')) { ?>
                    <li <?php if (($this->uri->segment(1) == 'freelancer') && ($this->uri->segment(2) == 'home')) { ?> class="active" <?php } ?>><a href="<?php echo base_url('recommended-freelance-work'); ?>">Home</a>
                    </li>
                <?php } ?>
                <li <?php if (($this->uri->segment(1) == 'freelancer') && ($this->uri->segment(2) == 'freelancer-details')) { ?> class="active" <?php } ?>><a href="<?php echo base_url('freelancer/'.$fa_slug); ?>"><?php echo $this->lang->line("freelancer_work_profile"); ?></a>
                </li>
                <?php if (($this->uri->segment(1) == 'freelancer') && ($this->uri->segment(2) == 'freelancer-details' || $this->uri->segment(2) == 'home' || $this->uri->segment(2) == 'saved-projects' || $this->uri->segment(2) == 'applied-projects') && ($this->uri->segment(3) == $this->session->userdata('aileenuser') || $this->uri->segment(3) == '')) { ?>
                    <li <?php if (($this->uri->segment(1) == 'freelancer') && ($this->uri->segment(2) == 'saved-projects')) { ?> class="active" <?php } ?>><a href="<?php echo base_url('freelancer/saved-projects'); ?>"><?php echo $this->lang->line("saved_freelancer"); ?></a>
                    </li>
                    <li <?php if (($this->uri->segment(1) == 'freelancer') && ($this->uri->segment(2) == 'applied-projects')) { ?> class="active" <?php } ?>><a href="<?php echo base_url('freelancer/applied-projects'); ?>"><?php echo $this->lang->line("applied_freelancer"); ?>freelancer_work_profile</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>