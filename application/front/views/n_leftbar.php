<?php
$url = $this->uri->segment_array();
$all_counter = $this->common->get_all_counter($leftbox_data['user_id']);
?>
<div id="left-fixed" class="fw">
    <div class="user-profile-box box-border">
        <div class="user-cover-img">
            <a href="<?php echo base_url($leftbox_data['user_slug']) ?>">
                <?php
                if($leftbox_data['profile_background'] != '')
                { ?>
                    <img ng-src="<?php echo USER_BG_MAIN_UPLOAD_URL.$leftbox_data['profile_background'] ?>" alt="<?php echo $leftbox_data['first_name'] ?>" class="bgImage">
                <?php
                }
                else
                {?>
                    <div class="gradient-bg" style="height: 100%"></div>
                <?php
                }?>
            </a>    
        </div>
        <div class="user-detail">
            <div class="user-img">
                <a href="<?php echo base_url($leftbox_data['user_slug']) ?>">
                <?php
                if ($leftbox_data['user_image'] != '')
                { ?> 
                    <img ng-src="<?php echo USER_THUMB_UPLOAD_URL . $leftbox_data['user_image'] ?>" alt="<?php echo $leftbox_data['first_name'] ?>">  
                <?php
                }
                else
                {
                    if($leftbox_data['user_gender'] == "M")
                    {?>
                        <img class="login-user-pro-pic" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                    <?php
                    }
                    if($leftbox_data['user_gender'] == "F")
                    {
                    ?>
                        <img class="login-user-pro-pic" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                    <?php
                    }
                } ?>
                </a>
            </div>
            <div class="user-detail-right">
                <div class="user-detail-top">
                    <h4>
                        <a href="<?php echo base_url($leftbox_data['user_slug']) ?>" title="<?php echo ucfirst($leftbox_data['first_name']) . ' ' . ucfirst($leftbox_data['last_name']) ?>">
                            <?php echo ucfirst($leftbox_data['first_name']) . ' ' . ucfirst($leftbox_data['last_name']) ?></a>
                    </h4>
                    <p>
                        <a href="<?php echo base_url($leftbox_data['user_slug']) ?>">
                            <?php
                            if($leftbox_data['title_name'] == "")
                            {
                                echo $leftbox_data['degree_name'];
                            }
                            else if($leftbox_data['title_name'] != "")
                            {
                                echo $leftbox_data['title_name'];
                            }
                            else
                            {
                                echo "Self Employee";
                            } ?>
                        </a>
                    </p>
                </div>
                <div class="user-detail-bottom">
                    <ul>
                        <li><a href="<?php echo base_url($leftbox_data['user_slug']) ?>">Dashboard <span class="dashboard_counter"><?php echo($all_counter['dashboard_counter'] > 0 ? $all_counter['dashboard_counter'] : 0); ?></span></a></li>
                        <li><a href="<?php echo base_url($leftbox_data['user_slug'].'/contacts') ?>">Contacts <span class="contact_counter"><?php echo($all_counter['contact_counter'] > 0 ? $all_counter['contact_counter'] : 0); ?></span></a></li>
                        <li><a href="<?php echo base_url($leftbox_data['user_slug'].'/followers') ?>">Followers <span class="follower_counter"><?php echo($all_counter['follower_counter'] > 0 ? $all_counter['follower_counter'] : 0); ?></span></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php
    if(isset($url) && empty($url)): ?>
	<div class="add-detail all-user-list">            
        <div id="profile-progress" class="edit_profile_progress" style="display: none;">
            <div class="count_main_progress">
                <div class="circles">
                    <div class="second circle-1">
                        <div>
                            <strong></strong>
                            <span id="progress-txt"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    $is_user_monetize = $this->common->is_user_monetize();    
    if($is_user_monetize > 0)
    {
        $monetize_data = $this->common->get_monetize();    
        if($monetize_data['total_points'] > 0 && $monetize_data['total_earn'] > 0)
        {
        ?>
            <div class="left-info-box monetize">
                <div class="dash-left-title">
                    <h3><i class="fa fa-money"></i> Points</h3>
                </div>
                <div class="dash-info-box">
                    <span><?php echo $monetize_data['total_points']; ?> Point<?php echo $monetize_data['total_points'] > 1 ? 's' : ''; ?></span>
                </div>
                <div class="dash-info-box">
                    <span><?php echo "$ ".$monetize_data['total_earn']; ?></span>
                </div>
            </div>
        <?php }
    }
    endif; ?>
	<div class="business-move">
	</div>
					
	<div class="artist-move">
	</div>
	
    
    <?php echo $left_footer; ?>
  
</div>
