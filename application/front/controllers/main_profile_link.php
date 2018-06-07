 <?php 
 $userid = $this->session->userdata('aileenuser'); 
 // print_r($userid);
 // exit;
        /*code for business profile link start */

        $contition_array = array('user_id' => $userid, 'is_deleted' => '0', 'status' => '1');
        $business_profile_count = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_step', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $this->business_profile_link = base_url("business-search/");
        if(isset($business_profile_count) && !empty($business_profile_count) && isset($business_profile_count[0]['business_count']) && $business_profile_count[0]['business_count']==1){
            $this->business_profile_link = base_url("business-profile/home");
        }
        /*Code for business profile link end*/

        /*code for Artis profile link start */
            $contition_array = array('user_id' => $userid);
            $artist_profile_count = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        /*Code for artist profile link ends*/ 

        /*code for Job profile link start */
            $contition_array = array('user_id' => $userid);
            $job_profile_count = $this->common->select_data_by_condition('job_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array_job = array('user_id' => $userid, 'status' => '0', 'is_delete' => '0');
        $job_deactive = $this->common->select_data_by_condition('job_reg', $contition_array_job, $data = 'count(*) as total', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        $job_deactive = $job_deactive[0]['total'];
        /*Code for Job profile link ends*/
        /*code for recruiter profile link start */
        $contition_array = array('user_id' => $userid);
        $recruiter_profile_count = $this->common->select_data_by_condition('recruiter', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        /*Code for recuiter profile link ends*/

        /*code for freelance hire link start */
        $contition_array = array('user_id' => $userid,'is_delete' => '0', 'status' => '1');
        $freelancer_hire_profile_count = $this->common->select_data_by_condition('freelancer_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        /*Code for freelance hire profile link ends*/

        /*code for freelace apply link start */
        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $freelancer_apply_profile_count = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        /*Code for freelance aply link ends*/

        $this->business_profile_link = base_url("business-search");
        $this->artist_profile_link = base_url("find-artist");
        $this->job_profile_link = base_url("job-search");
        $this->recruiter_profile_link = base_url("recruiter");
        $this->freelance_hire_profile_link = base_url("freelance-profile");
        $this->freelance_apply_profile_link = base_url("freelance-profile");
        $this->business_profile_set = 0;
        $this->artist_profile_set = 0;
        $this->job_profile_set = 0;
        $this->recruiter_profile_set = 0;
        $this->freelance_hire_profile_set = 0;
        $this->freelance_apply_profile_set = 0;

        $this->data['freelance_hire_right_profile_link'] = base_url('freelance-employer');
        $this->data['freelance_apply_right_profile_link'] = base_url('freelance-jobs');

        if(!empty($business_profile_count) &&  $business_profile_count[0]['business_step']==4){
            $this->business_profile_link = base_url("business-profile");
             $this->business_profile_set = 1;
        }
        if(!empty($artist_profile_count) &&  count($artist_profile_count)>0){
            $this->artist_profile_link = base_url("artist-profile");
            $this->artist_profile_set = 1;
        }
        if(!empty($job_profile_count) &&  count($job_profile_count)>0 && $job_deactive == 0){
            $this->job_profile_link = base_url("recommended-jobs");
            $this->job_profile_set = 1;
        }
        if(!empty($recruiter_profile_count) &&  count($recruiter_profile_count)>0){
            $this->recruiter_profile_link = base_url("recommended-candidates");
            $this->recruiter_profile_set = 1;
        }
        if(!empty($freelancer_hire_profile_count) &&  count($freelancer_hire_profile_count)>0){
            $this->freelance_hire_profile_link = base_url("hire-freelancer");
            $this->data['freelance_hire_right_profile_link'] = $this->freelance_hire_profile_link;
            $this->freelance_hire_profile_set = 1;
        }
        if(!empty($freelancer_apply_profile_count) &&  count($freelancer_apply_profile_count)>0){
            $this->freelance_apply_profile_link = base_url("recommended-freelance-work");
            $this->data['freelance_apply_right_profile_link'] = $this->freelance_apply_profile_link;
            $this->freelance_apply_profile_set = 1;
        }

        $this->data['job_right_profile_link'] = $this->job_profile_link;
        $this->data['recruiter_right_profile_link'] = $this->recruiter_profile_link;
        $this->data['freelance_right_profile_link'] = base_url('freelance-profile');
        $this->data['business_right_profile_link'] = $this->business_profile_link;
        $this->data['artist_right_profile_link'] = $this->artist_profile_link;
         $login_user_totalpost = 0;
        if($this->session->userdata('aileenuser')){
            $login_data_sql = "SELECT user_slug FROM ailee_user where user_id = " . $this->session->userdata('aileenuser');
            $login_data_query = $this->db->query($login_data_sql);        
            $login_user_totalpost = $login_data_query->row_array()['user_slug'];
        }
        if($this->session->userdata('aileenuser')){
            $all_path_link = base_url(). $login_user_totalpost . '/profiles';
        }else{
            $all_path_link = base_url('profiles');
        }
        $this->data['all_right_profile_link'] = $all_path_link;

        /*Code for business profile link end*/
        $this->data['header_all_profile'] = '<div class="dropdown-title"> Profiles <a href="'. $all_path_link .'" title="All" class="pull-right">All</a> </div><div id="abody" class="as"> <ul> <li> <div class="all-down"> <a href="'. $this->artist_profile_link .'"> <div class="all-img"> <img src="' . base_url('assets/n-images/i5.jpg') . '"> </div><div class="text-all"> Artistic Profile </div></a> </div></li><li> <div class="all-down"> <a href="'.  $this->business_profile_link .'"> <div class="all-img"> <img src="' . base_url('assets/n-images/i4.jpg') . '"> </div><div class="text-all"> Business Profile </div></a> </div></li><li> <div class="all-down"> <a href="'.  $this->job_profile_link .'"> <div class="all-img"> <img src="' . base_url('assets/n-images/i1.jpg') . '"> </div><div class="text-all"> Job Profile </div></a> </div></li><li> <div class="all-down"> <a href="'.$this->recruiter_profile_link.'"> <div class="all-img"> <img src="' . base_url('assets/n-images/i2.jpg') . '"> </div><div class="text-all"> Recruiter Profile </div></a> </div></li><li> <div class="all-down"> <a href="'.base_url('freelance-profile').'"> <div class="all-img"> <img src="' . base_url('assets/n-images/i3.jpg') . '"> </div><div class="text-all"> Freelance Profile </div></a> </div></li></ul> </div>';
     
        
        // Check freelancer is active or not and generate uel for create freelancer Search_banner
        $this->data['isdeactivatefreelancer'] = false;
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_delete' => '0');
        $freelancerpost_deactive = $this->data['freelancerpost_deactive'] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
        if ($freelancerpost_deactive) {
            $this->data['isdeactivatefreelancer'] = true;
        }
        $this->data['right_profile_view'] = $this->load->view('right_profile', $this->data, TRUE);
        $this->data['left_footer_list_view'] = $this->load->view('leftfooter', $this->data, TRUE);
?>