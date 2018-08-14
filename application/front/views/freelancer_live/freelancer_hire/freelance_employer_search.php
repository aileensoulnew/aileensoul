<input type = "hidden" class = "page_number" value = "<?php echo $page; ?>" />
<input type = "hidden" class = "total_record" value = "<?php echo $total_record; ?>" />
<input type = "hidden" class = "perpage_record" value = "<?php echo $perpage; ?>" />

<?php
$contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1', 'free_hire_step' => '3');
$free_hire_result = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = 'reg_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
if (count($freelancerpostdata1) > 0)
{
    $counter = 1;
    foreach ($freelancerpostdata1 as $row)
    {
        ?>
        <div class="profile-job-post-detail clearfix search">
            <div class="profile-job-post-title-inside clearfix">
                <div class="profile-job-profile-button clearfix">
                    <div class="profile-job-post-location-name-rec">
                        <div style="display: inline-block; float: left;">
                            <div class="buisness-profile-pic-candidate">
                                <?php
                                $post_fname = $row['freelancer_post_fullname'];
                                $post_lname = $row['freelancer_post_username'];
                                $sub_post_fname = substr($post_fname, 0, 1);
                                $sub_post_lname = substr($post_lname, 0, 1);

                                if ($row['freelancer_post_user_image']) {
                                    if (IMAGEPATHFROM == 'upload') {
                                        if (!file_exists($this->config->item('free_post_profile_main_upload_path') . $row['freelancer_post_user_image'])) {
                                            if ($userid) {
                                                if ($free_hire_result) {
                                                    ?>
                                                    <a href="<?php echo base_url('freelancer/' . $row['freelancer_apply_slug']); ?>" title="<?php echo  ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']); ?>"> 
                                                    <?php
                                                } else {
                                                    ?>
                                                    <a href="<?php echo base_url('freelance-employer/signup'); ?>" title="<?php echo  ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']); ?>"> 
                                                    <?php
                                                }
                                            } else {
                                                 ?>
                                                    <a href="javascript:void(0);" title="<?php echo  ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']); ?>"> 
                                            <?php
                                            }
                                            ?>
                                                <div class = "post-img-div">
                                                <?php echo ucfirst(strtolower($sub_post_fname)) . ucfirst(strtolower($sub_post_lname));?>
                                                </div>
                                            </a>
                                            <?php
                                        }
                                        else
                                        {
                                            if($userid)
                                            {
                                                if ($free_hire_result)
                                                {
                                                    ?>
                                                    <a style="margin-right: 4px;" href="<?php echo base_url('freelancer/' . $row['freelancer_apply_slug']); ?>" title="<?php echo ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']); ?>">
                                                <?php
                                                }
                                                else
                                                { ?>
                                                    <a style="margin-right: 4px;" href="<?php echo base_url('freelance-employer/signup'); ?>" title="<?php echo ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']); ?>">
                                                <?php
                                                }
                                            }
                                            else
                                            {
                                            ?>
                                                <a style="margin-right: 4px;" href="javascript:void(0);" onclick="login_profile();" title="<?php echo ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']); ?>">
                                            <?php
                                            }
                                            ?>
                                                <img src="<?php echo FREE_POST_PROFILE_THUMB_UPLOAD_URL . $row['freelancer_post_user_image']; ?>" alt="<?php echo ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']); ?>">
                                            </a>
                                            <?php
                                        }
                                    }
                                    else
                                    {
                                        $filename = $this->config->item('free_post_profile_main_upload_path') . $row['freelancer_post_user_image'];
                                        $s3 = new S3(awsAccessKey, awsSecretKey);
                                        $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                        if ($info)
                                        {
                                            if ($userid) {
                                                if ($free_hire_result) {
                                                    ?>
                                                    <a style="margin-right: 4px;" href="<?php echo base_url('freelancer/' . $row['freelancer_apply_slug']); ?>" title="<?php echo ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']); ?>">
                                                    <?php                                                    
                                                } else {
                                                    ?>
                                                    <a style="margin-right: 4px;" href="<?php echo base_url('freelance-employer/signup'); ?>" title="<?php echo ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']); ?>">
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <a style="margin-right: 4px;" href="javascript:void(0);" onclick="login_profile();" title="<?php echo ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']); ?>">
                                            <?php
                                            }?>
                                                <img src="<?php echo FREE_POST_PROFILE_THUMB_UPLOAD_URL . $row['freelancer_post_user_image']; ?>" alt="<?php echo ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']); ?>" >
                                            </a>
                                            <?php

                                        }
                                        else
                                        {
                                            if ($userid) {
                                                if ($free_hire_result) {
                                                    ?>
                                                    <a href="<?php echo base_url('freelancer/' . $row['freelancer_apply_slug']); ?>" title="<?php echo ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']); ?>">
                                                    <?php
                                                } 
                                                else
                                                { ?>
                                                    <a href="<?php echo base_url('freelance-employer/signup'); ?>" title="<?php echo ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']); ?>">
                                                <?php
                                                }
                                            } else {
                                                ?>
                                                <a href="javascript:void(0);" onclick="login_profile();" title="<?php echo ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']); ?>">
                                                <?php
                                            }
                                            ?>
                                                <div class = "post-img-div">
                                                <?php echo ucfirst(strtolower($sub_post_fname)) . ucfirst(strtolower($sub_post_lname));?>
                                                </div>
                                            </a>
                                            <?php
                                        }
                                    }
                                }
                                else
                                {
                                    if ($userid) {
                                        if ($free_hire_result) {
                                            ?>
                                            <a href="<?php echo base_url('freelancer/' . $row['freelancer_apply_slug']); ?>" title="<?php echo ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']); ?>">
                                            <?php
                                        } else {
                                            ?>
                                            <a href="<?php echo base_url('freelance-employer/signup'); ?>" title="<?php echo ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']); ?>">
                                            <?php
                                        }
                                    }
                                    else
                                    { ?>
                                            <a href="javascript:void(0);" onclick="login_profile();" title="<?php echo ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']); ?>">
                                            <?php
                                    }?>

                                    <div class = "post-img-div">
                                    <?php echo ucfirst(strtolower($sub_post_fname)) . ucfirst(strtolower($sub_post_lname)); ?>
                                    </div>
                                    </a>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="designation_rec" style="float: left;">
                            <ul>
                                <li>
                                    <?php
                                    if ($userid) {
                                        if ($free_hire_result) {
                                            ?>
                                            <a style="margin-right: 4px;" href="<?php echo base_url('freelancer/' . $row['freelancer_apply_slug']); ?>" title="<?php echo ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']); ?>">
                                            <?php
                                        } else {
                                            ?>
                                            <a style="margin-right: 4px;" href="<?php echo base_url('freelance-employer/signup'); ?>" title="<?php echo ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']); ?>">
                                            <?php
                                        }
                                    }
                                    else
                                    {
                                        ?>
                                        <a style="margin-right: 4px;" href="javascript:void(0);" onclick="login_profile();" title="<?php echo ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']); ?>">
                                        <?php
                                    }
                                    ?>
                                        <h6><?php echo ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']); ?></h6>
                                    </a>
                                </li>
                                <li style="display: block;" >
                                    <a><?php
                                    if ($row['designation']) {
                                        echo $row['designation'];
                                    } else {
                                        echo "Designation";
                                    }
                                    ?></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="profile-job-post-title clearfix">
                <div class="profile-job-profile-menu">
                    <ul class="clearfix">
                        <li>
                            <b>Field</b>
                            <span>
                                <?php
                                if ($row['freelancer_post_field']) {
                                    $field_name = $this->db->get_where('category', array('category_id' => $row['freelancer_post_field']))->row()->category_name;
                                    echo $field_name;
                                } else {
                                    echo PROFILENA;
                                } ?>
                            </span>
                        </li>
                        <li>
                            <b>Skills</b>
                            <span>
                                <?php
                                $aud = $row['freelancer_post_area'];
                                $aud_res = explode(',', $aud);
                                if (!$row['freelancer_post_area']) {
                                    $return_html .= $row['freelancer_post_otherskill'];
                                } elseif (!$row['freelancer_post_otherskill']) {
                                    foreach ($aud_res as $skill) {
                                        $cache_time = $this->db->get_where('skill', array('skill_id' => $skill))->row()->skill;
                                        $skillsss[] = $cache_time;
                                    }
                                    $listskill = implode(', ', $skillsss);
                                    echo $listskill;
                                    unset($skillsss);
                                } elseif ($row['freelancer_post_area'] && $row['freelancer_post_otherskill']) {
                                    foreach ($aud_res as $skillboth) {
                                        $cache_time = $this->db->get_where('skill', array('skill_id' => $skillboth))->row()->skill;
                                        $skilldddd[] = $cache_time;
                                    }
                                    $listFinal = implode(', ', $skilldddd);
                                    echo $listFinal . "," . $row['freelancer_post_otherskill'];
                                    unset($skilldddd);
                                }
                                ?>
                            </span>
                        </li>
                        <li>
                            <b>Location</b>
                            <span>
                                <?php
                                $cityname = $this->db->get_where('cities', array('city_id' => $row['freelancer_post_city']))->row()->city_name;
                                $countryname = $this->db->select('country_name')->get_where('countries', array('country_id' => $row['freelancer_post_country']))->row()->country_name;
                                if ($cityname || $countryname) {
                                    if ($cityname) {
                                        echo $cityname . ",";
                                    }
                                    if ($countryname) {
                                        echo $countryname;
                                    }
                                }
                                ?>
                            </span>
                        </li>
                        <li>
                            <b>Skill Description</b>
                            <span><p>
                            <?php
                            if ($row['freelancer_post_skill_description']) {
                                echo $row['freelancer_post_skill_description'];
                            } else {
                                echo PROFILENA;
                            }
                            ?>
                            </p></span>
                        </li>
                        <li>
                            <b>Avaiability</b>
                            <span>
                            <?php
                            if ($row['freelancer_post_work_hour']) {
                                echo $row['freelancer_post_work_hour'] . "  " . "Hours per week ";
                            } else {
                                echo PROFILENA;
                            } ?>
                            </span>
                        </li>
                        <li>
                            <b>Rate Hourly</b>
                            <span>
                            <?php
                            if ($row['freelancer_post_hourly']) {
                                $currency = $this->db->get_where('currency', array('currency_id' => $row['freelancer_post_ratestate']))->row()->currency_name;
                                if ($row['freelancer_post_fixed_rate'] == '1') {
                                    echo $row['freelancer_post_hourly'] . "   " . $currency . " (Also work on fixed Rate)";
                                } else {
                                    echo $row['freelancer_post_hourly'] . "   " . $currency;
                                }
                            } else {
                                echo PROFILENA;
                            } ?>
                            </span>
                        </li>
                        <li>
                            <b>Total Experience</b>
                            <span>
                            <?php
                            if ($row['freelancer_post_exp_year'] || $row['freelancer_post_exp_month']) {
                                if ($row['freelancer_post_exp_month'] == '12 month' && $row['freelancer_post_exp_year'] == '') {
                                    $return_html .= "1 year";
                                } elseif ($row['freelancer_post_exp_month'] == '12 month' && $row['freelancer_post_exp_year'] == '0 year') {
                                    $return_html .= "1 year";
                                } elseif ($row['freelancer_post_exp_month'] == '12 month' && $row['freelancer_post_exp_year'] != '') {
                                    $year = explode(' ', $row['freelancer_post_exp_year']);
                                    // echo $year;
                                    $totalyear = $year[0] + 1;
                                    $return_html .= $totalyear . " year";
                                } elseif ($row['freelancer_post_exp_year'] != '' && $row['freelancer_post_exp_month'] == '') {
                                    $return_html .= $row['freelancer_post_exp_year'];
                                } elseif ($row['freelancer_post_exp_year'] != '' && $row['freelancer_post_exp_month'] == '0 month') {

                                    $return_html .= $row['freelancer_post_exp_year'];
                                } else {

                                    $return_html .= $row['freelancer_post_exp_year'] . ' ' . $row['freelancer_post_exp_month'];
                                }
                            } else {
                                $return_html .= PROFILENA;
                            } ?>
                            </span>
                        </li>
                        <!-- <input type="hidden" name="search" id="search" value=""> -->
                    </ul>
                </div>
                <div class="profile-job-profile-button clearfix">
                    <div class="apply-btn fr">
                        <?php
                        if ($userid) {
                            $userid = $this->session->userdata('aileenuser');

                            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1', 'free_hire_step' => '3');
                            $free_hire_result = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = 'reg_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                            if ($free_hire_result) {
                                $contition_array = array('from_id' => $userid, 'to_id' => $row['user_id'], 'save_type' => '2');
                                $data = $this->common->select_data_by_condition('save', $contition_array, $data = 'status', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                if ($userid != $row['user_id']) {?>
                                    <a href="<?php echo base_url('chat/abc/3/4/' . $row['user_id']); ?>">Message</a>
                                    <?php
                                    if ($data[0]['status'] == 1 || $data[0]['status'] == '')
                                    { ?>
                                        <input type="hidden" id="hideenuser<?php echo $row['user_id']?>" value= "<?php echo $data[0]['save_id']?>">
                                        <a id="<?php echo $row['user_id']?>" onClick="savepopup('<?php echo $row['user_id']?>')" href="javascript:void(0);" class="saveduser<?php echo $row['user_id']?>">Save</a>
                                    <?php
                                    } elseif ($data[0]['status'] == 2) {
                                        ?><a class="saved">Shortlisted</a><?php
                                    } else {
                                        ?><a class="saved">Saved </a><?php
                                    }
                                }
                            } else {
                                ?>
                                <a href="echo base_url('freelance-employer/signup')?>"> Message </a>';
                                <a href="echo base_url('freelance-employer/signup')?>"> Save </a>';
                                <?php
                            }
                        } else { ?>
                            <a href="javascript:void(0);" onclick="login_profile();"> Message </a>';
                            <a href="javascript:void(0);" onclick="login_profile();"> Save </a>';
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
<?php
    }
}
else
{?>
    <div class="text-center rio">
        <h1 style="margin-bottom:11px;" class="page-heading  product-listing" >';
            <?php echo $this->lang->line("oops_no_data"); ?>
        </h1>
        <p style="margin-left:4%;">
            <?php echo $this->lang->line("couldn_find"); ?>
        </p>
        <ul>
            <li style="text-transform:none !important; list-style: none;">';
            <?php echo $this->lang->line("right_keyword"); ?>
            </li>
        </ul>
    </div>
<?php
} ?>
<div class="col-md-1"></div>
