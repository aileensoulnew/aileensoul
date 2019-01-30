<?php
$userid = $this->session->userdata('aileenuser');
if ($total_record > 0) { ?>
    <input type="hidden" class="page_number" value="<?php echo $page; ?>" />
    <input type="hidden" class="total_record" value="<?php echo $total_record; ?>" />
    <input type = "hidden" class = "perpage_record" value = "<?php echo $perpage; ?>" />
    <?php
    foreach ($postdetail as $post) {
        $text = $post['post_name'] != '' ? strtolower($this->common->clean($post['post_name'])) : '';
        $category_name = $this->db->select('category_name')->get_where('category', array('category_id' => $post['post_field_req']))->row()->category_name;
        $f_url = base_url()."freelance-jobs/".$category_name."/".substr($text, 0,200)."-".$post['user_id']."-".$post['post_id'];
        
        $loc_data = $this->db->select('city,country')->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row();
        $city = $loc_data->city;
        $country = $loc_data->country;

        $cityname = $this->db->select('city_name')->get_where('cities', array('city_id' => $city))->row()->city_name;
        $countryname = $this->db->select('country_name')->get_where('countries', array('country_id' => $country))->row()->country_name;

        if ($cityname != '') {
            $cityname1 = '-vacancy-in-' . strtolower($this->common->clean($cityname));
        } else {
            $cityname1 = '';
        }

        $firstname = $this->db->select('fullname')->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->fullname;
        $lastname = $this->db->select('username')->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->username;
        $hireslug = $this->db->select('freelancer_hire_slug')->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->freelancer_hire_slug;
        ?>
        <div class="all-job-box" id="postdata<?php echo $post['app_id']; ?>">
            <div class="all-job-top">
                <div class="job-top-detail">
                    <h5>
                        <a title="<?php echo $post['post_name']; ?>" href="<?php echo $f_url; ?>">
                            <?php echo $post['post_name']; ?>
                        </a>
                    </h5>
                    <p>
                        <a title="<?php echo ucwords($firstname)." ".ucwords($lastname); ?>" href="<?php echo base_url('freelance-employer/' . $hireslug); ?>">
                            <?php echo ucwords($firstname." ".$lastname); ?>
                        </a>
                    </p>
                </div>
            </div>
            <div class="all-job-middle">
                <p class="pb5">
                    <span class="location">
                        <span>
                            <img alt="location" src="<?php echo base_url('assets/images/location.svg'); ?>">
                            <?php
                            if ($cityname || $countryname) {
                                if ($cityname) {
                                    echo $cityname . ",";
                                }
                                echo $countryname;
                            }
                            ?>
                        </span>
                    </span>
                    <span class="exp">
                        <span>
                            <img alt="skill" src="<?php echo base_url('assets/images/exp.svg'); ?>">
                            <?php
                            $comma = ", ";
                            $k = 0;
                            $aud = $post['post_skill'];
                            $aud_res = explode(',', $aud);
                            $skill_txt = "";
                            if (!$post['post_skill']) {
                                $skill_txt .= $post['post_other_skill'];
                            } else if (!$post['post_other_skill']) {
                                foreach ($aud_res as $skill) {
                                    if ($k != 0) {
                                        $skill_txt .= $comma;
                                    }
                                    $cache_time = $this->db->select('skill')->get_where('skill', array('skill_id' => $skill))->row()->skill;
                                    $skill_txt .= $cache_time;
                                    if ($k == 5) {
                                        $etc = ",etc...";
                                        $skill_txt .= $etc;
                                        break;
                                    }
                                    $k++;
                                }
                            } else if ($post['post_skill'] && $post['post_other_skill']) {
                                foreach ($aud_res as $skill) {
                                    if ($k != 0) {
                                        $skill_txt .= $comma;
                                    }
                                    $cache_time = $this->db->select('skill')->get_where('skill', array('skill_id' => $skill))->row()->skill;
                                    $skill_txt .= $cache_time;
                                    if ($k == 5) {
                                        $etc = ",etc...";
                                        $skill_txt .= $etc;
                                        break;
                                    }
                                    $k++;
                                }
                                if ($k < 5) {
                                    $skill_txt .= "," . $post['post_other_skill'];
                                }
                            }
                            echo $skill_txt;
                            ?>
                        </span>
                    </span>
                </p>
                <p>
                    <?php
                    echo substr($post['post_description'], 0, 150);
                    if (strlen($post['post_description']) > 150) {
                        echo '.....<a href="'.$f_url.'" title="Read more">Read more</a>';
                    }
                    ?>
                </p>
            </div>
            <div class="all-job-bottom">
                <span class="job-post-date">
                    <b>Posted on: </b><?php echo trim(date('d-M-Y', strtotime($post['created_date']))); ?>
                </span>
                <p class="pull-right">
                    <a title="Remove" href="javascript:void(0);" class="btn4" onclick="removepopup(<?php echo $post['app_id']; ?>)">Remove</a>
                    <?php
                    $contition_array = array('post_id' => $post['post_id'], 'job_delete' => '0', 'user_id' => $userid);
                    $freelancerapply1 = $this->common->select_data_by_condition('freelancer_apply', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    if(!$freelancerapply1){
                    ?>
                    <a title="Apply" href="javascript:void(0);" class="btn4" onclick="applypopup(<?php echo $post['post_id'] . ',' . $post['app_id']; ?>)">Apply</a>
                    <?php } ?>
                </p>
            </div>
        </div>
<?php 
    }
}
else
{ ?>
    <div class="art-img-nn">
        <div class="art_no_post_img">
            <img alt= "No Saved Projects" src="../assets/img/free-no1.png">
        </div>
        <div class="art_no_post_text">';
            <?php echo $this->lang->line("no_saved_project"); ?>
        </div>
    </div>
<?php 
} ?>