<!-- menubar --> 
<?php
$userid = $this->session->userdata('aileenuser');
if($this->uri->segment(2) == "applied-job" || $this->uri->segment(2) == "saved-job")
{
$id = $userid;//$this->db->get_where('job_reg', array('slug' => $this->uri->segment(2)))->row()->user_id;
}
else
{

$id = $this->db->get_where('job_reg', array('slug' => $this->uri->segment(2)))->row()->user_id;
}
?>
<div class="profile-main-rec-box-menu profile-box-art col-md-12 padding_les">
    <div class=" right-side-menu art-side-menu padding_less_right job_edit_pr right-menu-jr <?php
if ($userid != $id) {

    echo "job_data_left_menubar";
}
?>">
             <?php
             $userid = $this->session->userdata('aileenuser');
             if ($jobdata[0]['user_id'] == $userid) {
                 ?>     
            <ul class="current-user pro-fw">
                <?php } else { ?>
                <ul class="pro-fw4">
                <?php } ?>  
                <?php
                $userid = $this->session->userdata('aileenuser');
                $contition_array = array('status' => '1', 'user_id' => $id);
                $slugdata = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'slug', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                ?>

                <li <?php if ($this->uri->segment(1) == 'job-profile' && $this->uri->segment(2) == $slugdata[0]['slug']) { ?> class="active" <?php } ?>>
                    <?php if ($userid) { ?>
                        <?php if ($userid != $id && $id != '') { ?>
                            <a title="Details" href="javascript:void(0);">Details</a>
                        <?php } else { ?>
                            <a title="Details" href="<?php echo base_url('job-profile/' . $slugdata[0]['slug']); ?>">Details</a>
                        <?php } ?>
                    <?php } else { ?>

                        <a title="Details" onclick="register_profile();">Details</a>
                    <?php } ?>
                </li>

                <?php
                if ($id == '' || $userid == $id) {
                    if (($this->uri->segment(1) == 'job-profile') && ($this->uri->segment(2) != '' || $this->uri->segment(2) == 'home' || $this->uri->segment(2) == 'resume' || $this->uri->segment(2) == 'job_resume' || $this->uri->segment(2) == 'saved-job' || $this->uri->segment(2) == 'applied-job')) {
                        ?>
                        <li <?php if ($this->uri->segment(1) == 'job-profile' && $this->uri->segment(2) == 'saved-job') { ?> class="active" <?php } ?>><a title="Saved Job" href="<?php echo base_url('job-profile/saved-job'); ?>">Saved </a>
                        </li>
                        <li <?php if ($this->uri->segment(1) == 'job-profile' && $this->uri->segment(2) == 'applied-job') { ?> class="active" <?php } ?>><a title="Applied Job" href="<?php echo base_url('job-profile/applied-job'); ?>">Applied </a>
                        </li>
                    <?php
                    }
                }
                ?>
            </ul>

            <?php
            if ($this->uri->segment(2) != "") {                
                if ($userid != $id) {
                    ?>
                    <div class="flw_msg_btn fr">
                        <ul id="btn-move">
                            <?php
                            if ($userid) {
                                $id = $this->db->get_where('job_reg', array('slug' => $this->uri->segment(2), 'is_delete' => '0', 'status' => '1'))->row()->user_id;

                                $contition_array = array('from_id' => $userid, 'to_id' => $id, 'save_type' => '1', 'status' => '0');
                                $data = $this->common->select_data_by_condition('save', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                                if ($data) {
                                    ?> 

                                    <li> 
                                        <a class="butt_rec  save_saved_btn">Saved</a>
                                    </li>
            <?php } else { ?>
                                    <li> 
                                        <a id="<?php echo 'saveduser' . $id; ?>" onClick="savepopup(<?php echo $id; ?>)" href="javascript:void(0);" class= "save_saved_btn btn-n2 <?php echo 'saveduser' . $id; ?>">
                                            Save
                                        </a>
                                    </li>
            <?php }
        } else { ?>
                                <li> 
                                    <a class="btn-n2" onclick="register_profile();">Save</a> 
                                </li>
        <?php } ?>
                            <?php if ($userid) {
                                // $msg_url = base_url('chat/abc/2/1/' . $id);//Old
                                $msg_url = MESSAGE_URL.'recruiter/job-'.$slugdata[0]['slug']; ?>
                                <li> 
                                    <a class="btn-n2" href="<?php echo $msg_url; ?>">Message</a> 
                                </li>
        <?php } else { ?>

                                <li> 
                                    <a class="btn-n2" onclick="register_profile();">Message</a> 
                                </li>
                    <?php } ?>
                        </ul>
                    </div>              <?php }
    }
            ?>


    </div>
</div>
<script>
		$(document).ready(function ()
		{
			if (screen.width <= 767)
			{
				$("#btn-move").appendTo($(".btn-move"));
			
			}
		
		});
	</script> 