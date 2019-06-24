<input type="hidden" class="page_number" value="<?php echo $page;?>" />
<input type="hidden" class="total_record" value="<?php echo $total_record;?>" />
<input type = "hidden" class = "perpage_record" value = "<?php echo $perpage;?>" />
<?php
$user_id = $this->session->userdata('aileenuser');
foreach ($userlist as $index=>$user) { ?>
    <div id="tooltip_content_<?php echo $index;?>" class="tooltip_templates">
        <div class="bus-tooltip">
            <div class="user-tooltip">
                <div class="tooltip-cover-img">
                    <?php if($user['profile_background'] != ''){ ?>
                        <img src="<?php echo BUS_BG_MAIN_UPLOAD_URL.$user['profile_background']; ?>">
                        <?php
                    }
                    else
                    { ?>
                        <div class="gradient-bg" style="height: 100%"></div>
                        <?php
                    } ?>
                </div>
                <div class="tooltip-user-detail">
                    <div class="tooltip-user-img">
                        <?php if($user['business_user_image'] != ''){ ?>
                            <img src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL.$user['business_user_image']; ?>">
                        <?php }
                        else{ ?>
                            <img src="<?php echo base_url(NOBUSIMAGE); ?>">
                        <?php } ?>
                    </div>
                    <div class="fw">
                        <div class="tooltip-detail">
                            <h4><?php echo $user['company_name'];?></h4>
                            <p>
                            <?php 
                            $category = $this->db->get_where('industry_type', array('industry_id' => $user['industriyal'], 'status' => '1'))->row()->industry_name;
                            if ($category) {
                                echo $category;
                            } else {
                                echo ucfirst($user['other_industrial']);
                            } ?>
                            </p>
                            <p>
                                <?php echo $user['city_name'].($user['city_name'] != '' ? ', ' : ' ').$user['state_name'].($user['state_name'] != '' ? ', ' : ' ').$user['country_name']; ?>
                            </p>
                        </div>
                        
                        <div class="tooltip-btns follow-btn-bus-<?php echo $user['user_id'];?>">
                            <?php
                            if($user['follow_status'] == 1): ?>
                            <a class="btn-new-1 following" data-uid="<?php echo $user['user_id'].date('his');?>" onclick="unfollow_user_bus(this.id)" id="follow_btn_bus_<?php echo $user['user_id'];?>">Following</a>
                            <?php
                            else: ?>
                            <a class="btn-new-1 follow" data-uid="<?php echo $user['user_id'].date('his');?>" onclick="follow_user_bus(this.id)" id="follow_btn_bus_<?php echo $user['user_id'];?>">Follow</a>
                            <?php
                            endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="job-contact-frnd ">
        <div class="profile-job-post-detail clearfix">
            <div class="profile-job-post-title-inside clearfix">
                <div class="profile-job-post-location-name">
                    <div class="user_lst">
                        <ul>
                            <li class="fl">
                                <div class="follow-img">
                                    <?php
                                    if ($user['business_user_image'] != '') { ?>
                                        <a href="<?php echo base_url('company/' . $user['business_slug']) ;?>" data-toggle="popover" data-tooltip-content="#tooltip_content_<?php echo $index;?>">
                                        <?php
                                        if (IMAGEPATHFROM == 'upload') {
                                            if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $user['business_user_image'])) {
                                                echo '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
                                            } else {
                                                echo '<img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $user['business_user_image'] . '?ver=' . time() . '" height="50px" width="50px" alt="' . $user['business_user_image'] . '" >';
                                            }
                                        } else {
                                            echo '<img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $user['business_user_image'] . '?ver=' . time() . '" height="50px" width="50px" alt="' . $user['business_user_image'] . '" >';
                                        }
                                        echo '</a>';
                                    } else { ?>
                                        <a href="<?php echo base_url('company/' . $user['business_slug']);?>" data-toggle="popover" data-tooltip-content="#tooltip_content_<?php echo $index;?>"><img  src="<?php echo base_url(NOBUSIMAGE);?>" alt="NOBUSIMAGE"></a>
                                    <?php
                                    } ?>
                                </div>
                            </li>
                            <li class="folle_text">
                                <div class="">
                                    <div class="follow-li-text " style="padding: 0;">
                                        <a href="<?php echo base_url('company/' . $user['business_slug']);?>" data-toggle="popover" data-tooltip-content="#tooltip_content_<?php echo $index;?>"> <?php echo $user['company_name'];?>
                                        </a>
                                    </div>
                                    <div><?php
                                        $category = $this->db->get_where('industry_type', array('industry_id' => $user['industriyal'], 'status' => '1'))->row()->industry_name; ?>
                                        <a><?php 
                                            if ($category) {
                                                echo $category;
                                            } else {
                                                echo ucfirst($user['other_industrial']);
                                            }
                                            if($user['city_name']){
                                                echo "(" . $user['city_name'] . ")";
                                            } ?>
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <li class="fruser<?php echo $user['business_profile_id'];?> fr">
                                <div id= "followdiv " class="user_btn follow-btn-bus-<?php echo $user['user_id'];?>">
                                    <!-- <button id="follow<?php //echo $user['user_id'];?>" onClick="followuser('<?php //echo $user_id; ?>',1,'<?php //echo $user['user_id'];?>')">
                                        <span> Follow </span>
                                    </button> -->
                                    <a class="btn-new-1 follow" data-uid="<?php echo $user['user_id'].date('his');?>" onclick="follow_user_bus(this.id)" id="follow_btn_bus_<?php echo $user['user_id'];?>">Follow</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div><?php
} ?>