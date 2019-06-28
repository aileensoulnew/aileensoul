<?php $login_user_id = $this->session->userdata('aileenuser'); ?>
<div id="tooltip_content" class="tooltip_templates1">
    <?php if($type == '2'): ?>
    <div class="bus-tooltip">
        <div class="user-tooltip">
            <div class="tooltip-cover-img">
                <?php if($user_info_data['user_data']['profile_background']){ ?>
                    <img src="<?php echo BUS_BG_MAIN_UPLOAD_URL.$user_info_data['user_data']['profile_background']; ?>"> <?php
                }
                else{ ?>
                    <div class="gradient-bg" style="height: 100%"></div> <?php
                } ?>
            </div>
            <div class="tooltip-user-detail">
                <div class="tooltip-user-img">
                    <?php
                    if($user_info_data['user_data']['business_user_image']){
                        $pro_img = BUS_PROFILE_THUMB_UPLOAD_URL.$user_info_data['user_data']['business_user_image'];
                    }
                    else{
                        $pro_img = base_url(NOBUSIMAGE);
                    } ?>
                    <img src="<?php echo $pro_img; ?>">
                </div>
                <div class="fw">
                    <div class="tooltip-detail">
                        <h4><?php echo $user_info_data['user_data']['company_name']; ?></h4>

                        <p><?php
                        if($user_info_data['user_data']['industry_name']){
                            echo $user_info_data['user_data']['industry_name'];
                        }
                        else{
                            echo "Current Work";
                        } ?>
                        </p>

                        <p><?php
                            echo $user_info_data['user_data']['city_name'].($user_info_data['user_data']['state_name'] ? ', ' : '').$user_info_data['user_data']['state_name'].($user_info_data['user_data']['country_name'] ? ', ' : '').$user_info_data['user_data']['country_name'];
                        ?></p>
                    </div>
                    
                    <div class="tooltip-btns follow-btn-bus-<?php echo $user_info_data['user_data']['user_id']; ?>">
                        <?php if($user_info_data['user_data']['follow_status'] == '1'){ ?>
                            <a class="btn-new-1 following" data-uid="<?php echo $user_info_data['user_data']['user_id'].date('his'); ?>" onclick="unfollow_user_bus(this.id)" id="follow_btn_bus">Following</a><?php
                        }
                        else{ ?>
                            <a ng-if="userInfo.user_data.follow_status == 0 || !userInfo.user_data.follow_status" class="btn-new-1 follow" data-uid="<?php echo $user_info_data['user_data']['user_id'].date('his'); ?>" onclick="follow_user_bus(this.id)" id="follow_btn_bus">Follow</a><?php
                        } ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    endif;
    if($type == '1'): ?>
    <div class="user-tooltip">
        <div class="tooltip-cover-img">
            <?php 
            if($user_info_data['user_data']['profile_background'] != ''){
            ?>
                <img src="<?php echo USER_BG_MAIN_UPLOAD_URL.$user_info_data['user_data']['profile_background']; ?>">
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
                if($user_info_data['user_data']['user_image'] != ''){
                    ?>
                    <img src="<?php echo USER_THUMB_UPLOAD_URL.$user_info_data['user_data']['user_image'];?>">
                <?php
                }
                else{
                    if($user_info_data['user_data']['user_gender'] == 'M'){ ?>
                        <img src="<?php echo base_url('assets/img/man-user.jpg'); ?>">
                    <?php
                    }
                    if($user_info_data['user_data']['user_gender'] == 'F'){
                    ?>
                        <img src="<?php echo base_url('assets/img/female-user.jpg'); ?>">
                    <?php
                    }
                }
                ?>                            
            </div>

            <h4><?php echo ucwords($user_info_data['user_data']['fullname']); ?></h4>
            <p>
                <?php
                if($user_info_data['user_data']['title_name'] != '' && $user_info_data['user_data']['degree_name'] == ''){
                    echo strlen($user_info_data['user_data']['title_name']) > 30 ? substr($user_info_data['user_data']['title_name'], 0,30).'...' : $user_info_data['user_data']['title_name'];
                }
                elseif($user_info_data['user_data']['title_name'] == '' && $user_info_data['user_data']['degree_name'] != ''){
                    echo strlen($user_info_data['user_data']['degree_name']) > 30 ? substr($user_info_data['user_data']['degree_name'], 0,30).'...' : $user_info_data['user_data']['degree_name'];
                }
                else{
                    echo 'Current Work';
                }
                ?>
            </p>
            <?php if($user_info_data['user_data']['post_count'] != '' || $user_info_data['user_data']['contact_count'] != '' || $user_info_data['user_data']['follower_count'] != ''){ ?>
                <p>
                    <?php if($user_info_data['user_data']['post_count'] != ''){
                        echo '<span><b>'.$user_info_data['user_data']['post_count'].'</b> Posts</span>';
                    }
                    if($user_info_data['user_data']['contact_count'] != ''){
                        echo '<span><b>'.$user_info_data['user_data']['contact_count'].'</b> Contacts</span>';
                    }
                    if($user_info_data['user_data']['follower_count'] != ''){
                        echo '<span><b>'.$user_info_data['user_data']['follower_count'].'</b> Followers</span>';
                    } ?>
                </p>
            <?php
            }
            if(count($user_info_data['mutual_friend']) > 0)
            { ?>
                <ul>
                    <?php
                    foreach ($user_info_data['mutual_friend'] as $key => $value)
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
                                    elseif($value['user_gender'] == 'F'){
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
                        <?php if(count($user_info_data['mutual_friend']) == 1){ ?>
                        <span>
                            <b><?php echo $user_info_data['mutual_friend'][0]['fullname'];?></b> is in mutual contact.
                        </span>
                        <?php
                        }
                        elseif(count($user_info_data['mutual_friend']) > 1){ ?>
                        <span>
                            <b><?php echo $user_info_data['mutual_friend'][0]['fullname'];?></b> and <b><?php echo count($user_info_data['mutual_friend']) - 1; ?> more mutual contacts.</b>
                        </span>
                        <?php
                        }?>                                    
                    </li>                                
                </ul>
            <?php
            }
            if($user_info_data['user_data']['user_id'] != $login_user_id)
            { ?>
                <div class="tooltip-btns">
                    <ul>
                        <li class="contact-btn-<?php echo $user_info_data['user_data']['user_id']; ?>">
                            <?php
                            if($user_info_data['user_data']['contact_value'] == 'new'){ ?>
                                <a class="btn-new-1" data-param="<?php echo $user_info_data['user_data']['contact_id'].date('his'); ?>,pending,<?php echo $user_info_data['user_data']['user_id'].date('his'); ?>,<?php echo ($index + 1).date('his');?>,0" onclick="contact(this.id);" id="contact_btn_<?php echo $user_info_data['user_data']['user_id']; ?>">Add to contact</a>
                            <?php
                            }
                            elseif($user_info_data['user_data']['contact_value'] == 'confirm'){ ?>
                                <a class="btn-new-1" data-param="<?php echo $user_info_data['user_data']['contact_id'].date('his'); ?>,cancel,<?php echo $user_info_data['user_data']['user_id'].date('his'); ?>,<?php echo ($index + 1).date('his');?>,1" onclick="contact(this.id);" id="contact_btn_<?php echo $user_info_data['user_data']['user_id']; ?>">In Contacts</a>
                            <?php
                            }
                            elseif($user_info_data['user_data']['contact_value'] == 'pending'){ ?>
                                <a class="btn-new-1" data-param="<?php echo $user_info_data['user_data']['contact_id'].date('his'); ?>,cancel,<?php echo $user_info_data['user_data']['user_id'].date('his'); ?>,<?php echo ($index + 1).date('his');?>,0" onclick="contact(this.id);" id="contact_btn_<?php echo $user_info_data['user_data']['user_id']; ?>">Request sent</a>
                            <?php
                            }
                            elseif($user_info_data['user_data']['contact_value'] == 'cancel'){ ?>
                                <a class="btn-new-1" data-param="<?php echo $user_info_data['user_data']['contact_id'].date('his'); ?>,pending,<?php echo $user_info_data['user_data']['user_id'].date('his'); ?>,<?php echo ($index + 1).date('his');?>,0" onclick="contact(this.id);" id="contact_btn_<?php echo $user_info_data['user_data']['user_id']; ?>">Add to contact</a>
                            <?php
                            }
                            elseif($user_info_data['user_data']['contact_value'] == 'reject'){ ?>
                                <a class="btn-new-1" data-param="<?php echo $user_info_data['user_data']['contact_id'].date('his'); ?>,pending,<?php echo $user_info_data['user_data']['user_id'].date('his'); ?>,<?php echo ($index + 1).date('his');?>,0" onclick="contact(this.id);" id="contact_btn_<?php echo $user_info_data['user_data']['user_id']; ?>">Add to contact</a>
                            <?php
                            } ?>
                        </li>
                        <li class="follow-btn-user-<?php echo $user_info_data['user_data']['user_id']; ?>">
                            <?php
                            if($user_info_data['user_data']['follow_status'] == 1){ ?>
                                <a class="btn-new-1 following" data-uid="<?php echo $user_info_data['user_data']['user_id'].date('his'); ?>" onclick="unfollow_user(this.id)" id="follow_btn_<?php echo $user_info_data['user_data']['user_id']; ?>">Following</a>
                            <?php
                            }
                            else{ ?>
                                <a class="btn-new-1 follow" data-uid="<?php echo $user_info_data['user_data']['user_id'].date('his'); ?>" onclick="follow_user(this.id)" id="follow_btn_<?php echo $user_info_data['user_data']['user_id']; ?>">Follow</a>
                            <?php    
                            } ?>

                        </li>
                        <li>
                            <a href="<?php echo MESSAGE_URL.'user/'.$user_info_data['user_data']['user_slug']; ?>" class="btn-new-1" target="_blank">Message</a>
                        </li>
                    </ul>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php endif; ?>
</div>