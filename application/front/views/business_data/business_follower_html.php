<input type="hidden" class="page_number" value="<?php echo $offset; ?>" />
<input type="hidden" class="total_record" value="<?php echo $total_record; ?>" />
<input type = "hidden" class = "perpage_record" value = "<?php echo $perpage; ?>" />
<?php
$login_user_id = $this->session->userdata('aileenuser');
if ($total_record > 0) {
    $followerrecord = $userlist['followerrecord'];
    if($followerrecord){
        foreach ($followerrecord as $index=>$user)
        { ?>
            <div id="people_tooltip_content_<?php echo $index;?>" class="tooltip_templates">
                <div class="user-tooltip">
                    <div class="tooltip-cover-img">
                        <?php 
                        if($user['profile_background'] != ''){
                        ?>
                            <img src="<?php echo USER_BG_MAIN_UPLOAD_URL.$user['profile_background']; ?>">
                        <?php
                        }
                        else{ ?>
                            <div class="gradient-bg" style="height: 100%"></div>
                        <?php
                        } ?>
                    </div>
                    <div class="tooltip-user-detail">
                        <div class="tooltip-user-img">
                            <?php 
                            if($user['user_image'] != ''){
                                ?>
                                <img src="<?php echo USER_THUMB_UPLOAD_URL.$user['user_image'];?>">
                            <?php
                            }
                            else{
                                if($user['user_gender'] == 'M'){ ?>
                                    <img src="<?php echo base_url('assets/img/man-user.jpg'); ?>">
                                <?php
                                }
                                if($user['user_gender'] == 'M'){
                                ?>
                                    <img src="<?php echo base_url('assets/img/female-user.jpg'); ?>">
                                <?php
                                }
                            }
                            ?>                            
                        </div>

                        <h4><?php echo ucwords($user['fullname']); ?></h4>
                        <p>
                            <?php
                            if($user['title_name'] != '' && $user['degree_name'] == ''){
                                echo strlen($user['title_name']) > 30 ? substr($user['title_name'], 0,30).'...' : $user['title_name'];
                            }
                            elseif($user['title_name'] == '' && $user['degree_name'] != ''){
                                echo strlen($user['degree_name']) > 30 ? substr($user['degree_name'], 0,30).'...' : $user['degree_name'];
                            }
                            else{
                                echo 'Current Work';
                            }
                            ?>
                        </p>
                        <?php if($user['post_count'] != '' || $user['contact_count'] != '' || $user['follower_count'] != ''){ ?>
                            <p>
                                <?php if($user['post_count'] != ''){
                                    echo '<span><b>'.$user['post_count'].'</b> Posts</span>';
                                }
                                if($user['contact_count'] != ''){
                                    echo '<span><b>'.$user['contact_count'].'</b> Connections</span>';
                                }
                                if($user['follower_count'] != ''){
                                    echo '<span><b>'.$user['follower_count'].'</b> Followers</span>';
                                } ?>
                            </p>
                        <?php
                        }
                        if(count($user['mutual_friend']) > 0)
                        { ?>
                            <ul>
                                <?php
                                foreach ($user['mutual_friend'] as $key => $value)
                                { ?>
                                    <li>
                                        <div class="user-img">
                                            <?php 
                                            if($value['user_image'] != ''){ ?>
                                                <img src="<?php echo USER_THUMB_UPLOAD_URL.$value['user_image'];?>">
                                            <?php
                                            }
                                            else{
                                                if($value['user_gender'] == 'M'){ ?>
                                                    <img src="<?php echo base_url('assets/img/man-user.jpg'); ?>">
                                                <?php
                                                }
                                                elseif($value['user_gender'] == 'M'){
                                                ?>
                                                    <img src="<?php echo base_url('assets/img/female-user.jpg'); ?>">
                                                <?php
                                                }
                                            } ?>                                            
                                        </div>
                                    </li>
                                <?php 
                                } ?>
                                <li class="m-contacts">
                                    <?php if(count($user['mutual_friend']) == 1){ ?>
                                    <span>
                                        <b><?php echo $user['mutual_friend'][0]['fullname'];?></b> is in mutual contact.
                                    </span>
                                    <?php
                                    }
                                    elseif(count($user['mutual_friend']) > 1){ ?>
                                    <span>
                                        <b><?php echo $user['mutual_friend'][0]['fullname'];?></b> and <b><?php echo count($user['mutual_friend']) - 1; ?> more mutual contacts.</b>
                                    </span>
                                    <?php
                                    }?>                                    
                                </li>                                
                            </ul>
                        <?php
                        }
                        if($user['user_id'] != $login_user_id)
                        { ?>
                            <div class="tooltip-btns">
                                <ul>
                                    <li class="contact-btn-<?php echo $user['user_id']; ?>">
                                        <?php
                                        if($user['contact_value'] == 'new'){ ?>
                                            <a class="btn-new-1" data-param="<?php echo $user['contact_id'].date('his'); ?>,pending,<?php echo $user['user_id'].date('his'); ?>,<?php echo ($index + 1).date('his');?>,0" onclick="contact(this.id);" id="contact_btn_<?php echo $user['user_id']; ?>">Add to contact</a>
                                        <?php
                                        }
                                        elseif($user['contact_value'] == 'confirm'){ ?>
                                            <a class="btn-new-1" data-param="<?php echo $user['contact_id'].date('his'); ?>,cancel,<?php echo $user['user_id'].date('his'); ?>,<?php echo ($index + 1).date('his');?>,1" onclick="contact(this.id);" id="contact_btn_<?php echo $user['user_id']; ?>">In Contacts</a>
                                        <?php
                                        }
                                        elseif($user['contact_value'] == 'pending'){ ?>
                                            <a class="btn-new-1" data-param="<?php echo $user['contact_id'].date('his'); ?>,cancel,<?php echo $user['user_id'].date('his'); ?>,<?php echo ($index + 1).date('his');?>,0" onclick="contact(this.id);" id="contact_btn_<?php echo $user['user_id']; ?>">Request sent</a>
                                        <?php
                                        }
                                        elseif($user['contact_value'] == 'cancel'){ ?>
                                            <a class="btn-new-1" data-param="<?php echo $user['contact_id'].date('his'); ?>,pending,<?php echo $user['user_id'].date('his'); ?>,<?php echo ($index + 1).date('his');?>,0" onclick="contact(this.id);" id="contact_btn_<?php echo $user['user_id']; ?>">Add to contact</a>
                                        <?php
                                        }
                                        elseif($user['contact_value'] == 'reject'){ ?>
                                            <a class="btn-new-1" data-param="<?php echo $user['contact_id'].date('his'); ?>,pending,<?php echo $user['user_id'].date('his'); ?>,<?php echo ($index + 1).date('his');?>,0" onclick="contact(this.id);" id="contact_btn_<?php echo $user['user_id']; ?>">Add to contact</a>
                                        <?php
                                        } ?>
                                    </li>
                                    <li class="follow-btn-user-<?php echo $user['user_id']; ?>">
                                        <?php
                                        if($user['follow_status'] == 1){ ?>
                                            <a class="btn-new-1 following" data-uid="<?php echo $user['user_id'].date('his'); ?>" onclick="unfollow_user(this.id)" id="follow_btn_<?php echo $user['user_id']; ?>">Following</a>
                                        <?php
                                        }
                                        else{ ?>
                                            <a class="btn-new-1 follow" data-uid="<?php echo $user['user_id'].date('his'); ?>" onclick="follow_user(this.id)" id="follow_btn_<?php echo $user['user_id']; ?>">Follow</a>
                                        <?php    
                                        } ?>

                                    </li>
                                    <li>
                                        <a href="<?php echo MESSAGE_URL.'user/'.$user['user_slug']; ?>" class="btn-new-1" target="_blank">Message</a>
                                    </li>
                                </ul>
                            </div>
                        <?php } ?>
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
                                            <a href="<?php echo base_url().$user['user_slug'];?>"  data-toggle="popover" data-tooltip-content="#people_tooltip_content_<?php echo $index;?>">
                                            <?php 
                                            if($user['user_image'] != '') { ?>
                                                <img src="<?php echo USER_THUMB_UPLOAD_URL.$user['user_image'];?>" height="50px" width="50px" alt="<?php echo $user['user_image'];?>">
                                            <?php
                                            } else {
                                                if($user['user_gender'] == "M")
                                                { ?>
                                                    <img  src="'.base_url('assets/img/man-user.jpg').'"  alt="NOBUSIMAGE">
                                                <?php
                                                }
                                                else
                                                { ?>
                                                    <img  src="'.base_url('assets/img/female-user.jpg').'"  alt="NOBUSIMAGE">
                                                <?php
                                                }
                                            } ?>
                                            </a>
                                        </div>
                                    </li>
                                    <li class="folle_text">
                                        <div class="">
                                            <div class="follow-li-text " style="padding: 0;">
                                                <a href="<?php echo base_url($followerslug);?>" data-toggle="popover" data-tooltip-content="#people_tooltip_content_<?php echo $index;?>">
                                                    <?php echo ucwords(strtolower($user['first_name'].' '.$user['last_name']));?>
                                                </a>
                                            </div>
                                        </div>
                                        <div>
                                            <?php
                                            if($user['title_name']) {
                                                echo $user['title_name'];
                                            }
                                            elseif($user['degree_name']) {
                                                echo $user['degree_name'];
                                            }
                                            else{
                                                echo "Current Work";
                                            } ?>
                                        </div>
                                    </li>
                                    <li class="fr" id ="frfollow<?php echo $user['user_id'];?>">
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
    }
} 
else{ ?>
    <div class="art-img-nn" id= "art-blank">
        <div class="art_no_post_img">
            <img src="<?php echo base_url('assets/img/icon_no_follower.png');?>" alt="icon_no_follower.png">
        </div>
        <div class="art_no_post_text">
            No Followers Available.
        </div>
    </div><?php
} ?>