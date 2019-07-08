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
            <div class="job-contact-frnd ">
                <div class="profile-job-post-detail clearfix">
                    <div class="profile-job-post-title-inside clearfix">
                        <div class="profile-job-post-location-name">
                            <div class="user_lst">
                                <ul>
                                    <li class="fl">
                                        <div class="follow-img">
                                            <a href="<?php echo base_url().$user['user_slug'];?>"  data-toggle="popover" data-uid="<?php echo $user['user_id'];?>" data-utype="1">
                                            <?php 
                                            if($user['user_image'] != '') { ?>
                                                <img src="<?php echo USER_THUMB_UPLOAD_URL.$user['user_image'];?>" height="50px" width="50px" alt="<?php echo $user['user_image'];?>">
                                            <?php
                                            } else {
                                                if($user['user_gender'] == "M")
                                                { ?>
                                                    <img  src="<?php echo base_url('assets/img/man-user.jpg');?>"  alt="NOBUSIMAGE">
                                                <?php
                                                }
                                                else
                                                { ?>
                                                    <img  src="<?php echo base_url('assets/img/female-user.jpg');?>"  alt="NOBUSIMAGE">
                                                <?php
                                                }
                                            } ?>
                                            </a>
                                        </div>
                                    </li>
                                    <li class="folle_text">
                                        <div class="">
                                            <div class="follow-li-text " style="padding: 0;">
                                                <a href="<?php echo base_url($followerslug);?>" data-toggle="popover" data-uid="<?php echo $user['user_id'];?>" data-utype="1">
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