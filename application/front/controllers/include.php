<?php$this->load->model('user_model');// user detail$userid = $this->session->userdata('aileenuser');$this->data['userdata'] = $this->user_model->getUserData($userid);/*$contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');$this->data['userdata'] = $this->common->select_data_by_condition('user', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');*/// recruiter detail$contition_array = array('user_id' => $userid, 'is_delete' => '0', 're_status' => '1');$this->data['recdata'] = $this->common->select_data_by_condition('recruiter', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');// job detail$contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');$this->data['jobdata'] = $this->common->select_data_by_condition('job_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');// freelancer hire detail$contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');$this->data['freehiredata'] = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');// freelancer post detail$contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');$this->data['freepostdata'] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');// business profile detail$contition_array = array('user_id' => $userid, 'is_deleted' => '0', 'status' => '1');$this->data['businessdata'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');// artistics detail$contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');$this->data['artdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');//for message notification start$contition_array = array('notification.not_type' => '2', 'notification.not_to_id' => $userid);$join_str = array(array(        'join_type' => '',        'table' => 'messages',        'join_table_id' => 'notification.not_product_id',        'from_table_id' => 'messages.id'),    array(        'join_type' => '',        'table' => 'user',        'join_table_id' => 'notification.not_from_id',        'from_table_id' => 'user.user_id'),    array(        'join_type' => '',        'table' => 'user_info',        'join_table_id' => 'user_info.user_id',        'from_table_id' => 'user.user_id'));$data = array('notification.*', ' messages.*', ' user.user_id', 'user.first_name', 'user_info.user_image', 'user.last_name');$this->data['user_message'] = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'messages.id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = 'not_from_id');$this->data['message_count'] = count($this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'messages.id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = 'not_from_id'));$contition_array = array('notification.not_type' => '2', 'notification.not_to_id' => $userid);$join_str = array(array(        'join_type' => '',        'table' => 'messages',        'join_table_id' => 'notification.not_product_id',        'from_table_id' => 'messages.id'),    array(        'join_type' => '',        'table' => 'user',        'join_table_id' => 'notification.not_from_id',        'from_table_id' => 'user.user_id'),    array(        'join_type' => '',        'table' => 'user_info',        'join_table_id' => 'user_info.user_id',        'from_table_id' => 'user.user_id'));$data = array('notification.*', ' messages.*', ' user.user_id', 'user.first_name', 'user_info.user_image', 'user.last_name');$this->data['message_seeall'] = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'messages.id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = 'not_from_id');$this->data['message_seeall'] = count($this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'messages.id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = 'not_from_id'));$contition_array = array('notification.not_type' => '3', 'notification.not_to_id' => $userid, 'notification.not_from' => '2', 'created_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()');$join_str = array(array(        'join_type' => '',        'table' => 'job_apply',        'join_table_id' => 'notification.not_product_id',        'from_table_id' => 'job_apply.app_id'),    array(        'join_type' => '',        'table' => 'user',        'join_table_id' => 'notification.not_from_id',        'from_table_id' => 'user.user_id'),    array(        'join_type' => '',        'table' => 'user_info',        'join_table_id' => 'user_info.user_id',        'from_table_id' => 'user.user_id'));$data = array('notification.*', 'job_apply.*', 'user.user_id', 'user.first_name', 'user_info.user_image', 'user.last_name');$this->data['rec_not'] = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'app_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = 'not_from_id');// recruiter notification end// job notfication start $contition_array = array('notification.not_type' => '4', 'notification.not_to_id' => $userid, 'created_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()');$join_str = array(array(        'join_type' => '',        'table' => 'job_apply',        'join_table_id' => 'notification.not_product_id',        'from_table_id' => 'job_apply.app_id'),    array(        'join_type' => '',        'table' => 'user',        'join_table_id' => 'notification.not_from_id',        'from_table_id' => 'user.user_id'),    array(        'join_type' => '',        'table' => 'user_info',        'join_table_id' => 'user_info.user_id',        'from_table_id' => 'user.user_id'));$data = array('notification.*', ' job_apply.*', ' user.user_id', 'user.first_name', 'user_info.user_image', 'user.last_name');$this->data['job_not'] = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'app_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = 'not_from_id');// job notification end// freelancer hire  notification start$contition_array = array('notification.not_type' => '3', 'notification.not_from' => '6', 'notification.not_to_id' => $userid, 'created_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()');$join_str = array(    array(        'join_type' => '',        'table' => 'freelancer_apply',        'join_table_id' => 'notification.not_product_id',        'from_table_id' => 'freelancer_apply.app_id'),    array(        'join_type' => '',        'table' => 'user',        'join_table_id' => 'notification.not_from_id',        'from_table_id' => 'user.user_id'),    array(        'join_type' => '',        'table' => 'user_info',        'join_table_id' => 'user_info.user_id',        'from_table_id' => 'user.user_id'));$data = array('notification.*', 'freelancer_apply.*', 'user.user_id', 'user.first_name', 'user_info.user_image', 'user.last_name');$this->data['hire_not'] = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'app_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = 'not_from_id');// freelancer hire notification end// freelancer post notification start$contition_array = array('notification.not_type' => '4', 'notification.not_from' => '4', 'notification.not_to_id' => $userid, 'created_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()');$join_str = array(array(        'join_type' => '',        'table' => 'job_apply',        'join_table_id' => 'notification.not_product_id',        'from_table_id' => 'job_apply.app_id'),    array(        'join_type' => '',        'table' => 'user',        'join_table_id' => 'notification.not_from_id',        'from_table_id' => 'user.user_id'),    array(        'join_type' => '',        'table' => 'user_info',        'join_table_id' => 'user_info.user_id',        'from_table_id' => 'user.user_id'));$data = array('notification.*', ' job_apply.*', ' user.user_id', 'user.first_name', 'user_info.user_image', 'user.last_name');$this->data['work_post'] = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'app_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = 'not_from_id');$contition_array = array('notification.not_type' => '8', 'notification.not_from' => '3', 'notification.not_to_id' => $userid, 'created_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()');$join_str = array(array(        'join_type' => '',        'table' => 'follow',        'join_table_id' => 'notification.not_product_id',        'from_table_id' => 'follow.follow_id'),    array(        'join_type' => '',        'table' => 'user',        'join_table_id' => 'notification.not_from_id',        'from_table_id' => 'user.user_id'),    array(        'join_type' => '',        'table' => 'user_info',        'join_table_id' => 'user_info.user_id',        'from_table_id' => 'user.user_id'));$data = array('notification.*', ' follow.*', ' user.user_id', 'user.first_name', 'user_info.user_image', 'user.last_name');$this->data['artfollow'] = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'follow_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = 'not_from_id');$contition_array = array('notification.not_type' => '6', 'notification.not_from' => '3', 'notification.not_to_id' => $userid, 'created_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()');$join_str = array(array(        'join_type' => '',        'table' => 'artistic_post_comment',        'join_table_id' => 'notification.not_product_id',        'from_table_id' => 'artistic_post_comment.artistic_post_comment_id'),    array(        'join_type' => '',        'table' => 'user',        'join_table_id' => 'notification.not_from_id',        'from_table_id' => 'user.user_id'),    array(        'join_type' => '',        'table' => 'user_info',        'join_table_id' => 'user_info.user_id',        'from_table_id' => 'user.user_id'));$data = array('notification.*', ' artistic_post_comment.*', ' user.user_id', 'user.first_name', 'user_info.user_image', 'user.last_name');$this->data['artcommnet'] = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'artistic_post_comment_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = 'not_from_id');$contition_array = array('notification.not_type' => '5', 'notification.not_from' => '3', 'notification.not_to_id' => $userid, 'created_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()');$join_str = array(array(        'join_type' => '',        'table' => 'art_post',        'join_table_id' => 'notification.not_product_id',        'from_table_id' => 'art_post.art_post_id'),    array(        'join_type' => '',        'table' => 'user',        'join_table_id' => 'notification.not_from_id',        'from_table_id' => 'user.user_id'),    array(        'join_type' => '',        'table' => 'user_info',        'join_table_id' => 'user_info.user_id',        'from_table_id' => 'user.user_id'));$data = array('notification.*', 'art_post.*', ' user.user_id', 'user.first_name', 'user_info.user_image', 'user.last_name');$this->data['artlike'] = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'art_post_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = 'not_from_id');$contition_array = array('notification.not_type' => '8', 'notification.not_from' => '6', 'notification.not_to_id' => $userid, 'created_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()');$join_str = array(array(        'join_type' => '',        'table' => 'follow',        'join_table_id' => 'notification.not_product_id',        'from_table_id' => 'follow.follow_id'),    array(        'join_type' => '',        'table' => 'user',        'join_table_id' => 'notification.not_from_id',        'from_table_id' => 'user.user_id'),    array(        'join_type' => '',        'table' => 'user_info',        'join_table_id' => 'user_info.user_id',        'from_table_id' => 'user.user_id'));$data = array('notification.*', 'follow.*', 'user.user_id', 'user.first_name', 'user_info.user_image', 'user.last_name');$this->data['busifollow'] = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'follow_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = 'not_from_id');$contition_array = array('notification.not_type' => '6', 'notification.not_from' => '6', 'notification.not_to_id' => $userid, 'created_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()');$join_str = array(array(        'join_type' => '',        'table' => 'business_profile_post_comment',        'join_table_id' => 'notification.not_product_id',        'from_table_id' => 'business_profile_post_comment.business_profile_post_comment_id'),    array(        'join_type' => '',        'table' => 'user',        'join_table_id' => 'notification.not_from_id',        'from_table_id' => 'user.user_id'),    array(        'join_type' => '',        'table' => 'user_info',        'join_table_id' => 'user_info.user_id',        'from_table_id' => 'user.user_id'));$data = array('notification.*', 'business_profile_post_comment.*', 'user.user_id', 'user.first_name', 'user_info.user_image', 'user.last_name');$this->data['buscommnet'] = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'business_profile_post_comment_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = 'not_from_id');$contition_array = array('notification.not_type' => '5', 'notification.not_from' => '6', 'notification.not_to_id' => $userid, 'created_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()');$join_str = array(array(        'join_type' => '',        'table' => 'business_profile_post',        'join_table_id' => 'notification.not_product_id',        'from_table_id' => 'business_profile_post.business_profile_post_id'),    array(        'join_type' => '',        'table' => 'user',        'join_table_id' => 'notification.not_from_id',        'from_table_id' => 'user.user_id'),    array(        'join_type' => '',        'table' => 'user_info',        'join_table_id' => 'user_info.user_id',        'from_table_id' => 'user.user_id'));$data = array('notification.*', ' business_profile_post.*', ' user.user_id', 'user.first_name', 'user_info.user_image', 'user.last_name');$this->data['buslike'] = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'business_profile_post_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = 'not_from_id');// khyati changes 27-10 start$this->data['head'] = $this->load->view('head', $this->data, true);//$this->load->driver('cache',array('adapter' => 'file'));//$cacheid = 'header';//if(!$this->data['header'] = $this->cache->get($cacheid)){$this->data['header'] = $this->load->view('header', $this->data, true);//$this->cache->save($cacheid,$this->data['header'],900);///}$this->data['footer'] = $this->load->view('footer', $this->data, true);$this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);// khyati chnages 27-10 end// Start Job$this->data['job_left'] = $this->load->view('job/job_left', $this->data, true);$this->data['job_search'] = $this->load->view('job/job_search', $this->data, true);$this->data['job_menubar'] = $this->load->view('job/menubar', $this->data, true);$this->data['job_header2_border'] = $this->load->view('job/job_header2_border', $this->data, true);$this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);$this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);$this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);$this->data['header_inner_profile'] = $this->load->view('header_inner_profile', $this->data, true);$this->data['job_header2'] = $this->load->view('job/job_header2', $this->data, true);// End Job// Start Recruiter$this->data['rec_search'] = $this->load->view('recruiter/rec_search', $this->data, true);// Start Recruiter////$this->data['rec_left'] = $this->load->view('recruiter/rec_left', $this->data, true);//$this->data['rec_cover'] = $this->load->view('recruiter/rec_cover', $this->data, true);//$this->data['rec_search'] = $this->load->view('recruiter/rec_search', $this->data, true);//$this->data['job_cover'] = $this->load->view('job/job_cover', $this->data, true);//$this->data['job_left'] = $this->load->view('job/job_left', $this->data, true);//$this->data['job_search'] = $this->load->view('job/job_search', $this->data, true);//$this->data['job_menubar'] = $this->load->view('job/menubar', $this->data, true);//$this->data['business_cover'] = $this->load->view('business_profile/business_cover', $this->data, true); // comment on 21-9-2017$this->data['business_search'] = $this->load->view('business_profile/business_search', $this->data, true);//$this->data['artistic_cover'] = $this->load->view('artist/artistic_cover', $this->data, true);//$this->data['artistic_left'] = $this->load->view('artist/artistic_left', $this->data, true);$this->data['artistic_search'] = $this->load->view('artist/artistic_search', $this->data, true);$this->data['freelancer_post_cover'] = $this->load->view('freelancer/freelancer_post/freelancer_post_cover', $this->data, true);$this->data['freelancer_post_left'] = $this->load->view('freelancer/freelancer_post/freelancer_post_left', $this->data, true);$this->data['freelancer_post_search'] = $this->load->view('freelancer/freelancer_post/freelancer_post_search', $this->data, true);//$this->data['freelancer_hire_left'] = $this->load->view('freelancer/freelancer_hire/freelancer_hire_left', $this->data, true);//$this->data['freelancer_hire_cover'] = $this->load->view('freelancer/freelancer_hire/freelancer_hire_cover', $this->data, true);$this->data['freelancer_hire_search'] = $this->load->view('freelancer/freelancer_hire/freelancer_hire_search', $this->data, true);$artregid = (isset($this->data['artdata']) && !empty($this->data['artdata']) ? $this->data['artdata'][0]['art_id'] : "");$contition_array = array('follow_to' => $artregid, 'follow_status' => '1', 'follow_type' => '1');$followerdata = $this->data['followerdata'] = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');$countlu = array();foreach ($followerdata as $followkey) {    $contition_array = array('art_id' => $followkey['follow_from'], 'status' => '1');    $artaval = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');    if ($artaval) {        $countlu[] = $artaval;    }}$this->data['flucount'] = $flucount = count($countlu);$contition_array = array('follow_from' => $artregid, 'follow_status' => '1', 'follow_type' => '1');$followingdata = $this->data['followingdata'] = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');$countlfu = array();foreach ($followingdata as $followkey) {    $contition_array = array('art_id' => $followkey['follow_to'], 'status' => '1');    $artaval = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');    if ($artaval) {        $countlfu[] = $artaval;    }}$this->data['countfr'] = $countfr = count($countlfu);$businessregid = (isset($this->data['businessdata']) && !empty($this->data['businessdata']) ? $this->data['businessdata'][0]['business_profile_id'] : "");$contition_array = array('follow_to' => $businessregid, 'follow_status' => '1', 'follow_type' => '2', 'business_profile.status' => '1');$join_str_follower[0]['table'] = 'follow';$join_str_follower[0]['join_table_id'] = 'follow.follow_from';$join_str_follower[0]['from_table_id'] = 'business_profile.business_profile_id';$join_str_follower[0]['join_type'] = '';$businessfollowerdata = $this->data['businessfollowerdata'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str_follower, $groupby = '');$contition_array = array('follow_from' => $businessregid, 'follow_status' => '1', 'follow_type' => '2', 'business_profile.status' => '1');$join_str_following[0]['table'] = 'follow';$join_str_following[0]['join_table_id'] = 'follow.follow_to';$join_str_following[0]['from_table_id'] = 'business_profile.business_profile_id';$join_str_following[0]['join_type'] = '';$businessfollowingdata = $this->data['businessfollowingdata'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str_following, $groupby = '');$this->data['arturl'] = $this->user_model->get_art_url($userid);$this->data['artistic_header2'] = $this->load->view('artist_live/artistic_header2', $this->data, true);//$this->data['art_header2'] = $this->load->view('artist/art_header2', $this->data, true);$this->data['freelancer_hire_header2'] = $this->load->view('freelancer_live/freelancer_hire/freelancer_hire_header2_new', $this->data, true);$this->data['freelancer_post_header2'] = $this->load->view('freelancer_live/freelancer_post/freelancer_post_header2_new', $this->data, true);$this->data['business_header2'] = $this->load->view('business_profile_live/business_header2', $this->data, true);$this->data['recruiter_header2'] = $this->load->view('recruiter_live/recruiter_header2', $this->data, true);//$this->data['job_header2'] = $this->load->view('job/job_header2', $this->data, true);//$this->data['job_header2_border'] = $this->load->view('job/job_header2_border', $this->data, true);$this->data['recruiter_header2_border'] = $this->load->view('recruiter/recruiter_header2_border', $this->data, true);$this->data['art_header2_border'] = $this->load->view('artist/art_header2_border', $this->data, true);$this->data['freelancer_hire_header2_border'] = $this->load->view('freelancer/freelancer_hire/freelancer_hire_header2_border', $this->data, true);$this->data['freelancer_post_header2_border'] = $this->load->view('freelancer/freelancer_post/freelancer_post_header2_border', $this->data, true);$this->data['business_header2_border'] = $this->load->view('business_profile/business_header2_border', $this->data, true);$id = $this->uri->segment(3);$contition_array = array('user_id' => $userid, 'status' => '1');$this->data['slug_data'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_slug', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');$slug_id = (isset($this->data['slug_data']) && !empty($this->data['slug_data']) ? $this->data['slug_data'][0]['business_slug'] : "");if ($id == $slug_id || $id == '') {    $contition_array = array('business_slug' => $slug_id, 'status' => '1', 'business_step' => '4');    $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');    $contition_array = array('user_id' => $userid, 'is_delete' => '0');    $this->data['busimagedata'] = $this->common->select_data_by_condition('bus_image', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');} else {    $contition_array = array('business_slug' => $id, 'status' => '1', 'business_step' => '4');    $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');    $contition_array = array('user_id' => $businessdata1[0]['user_id'], 'is_delete' => '0');    $this->data['busimagedata'] = $this->common->select_data_by_condition('bus_image', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');}$this->data['business_common'] = $this->load->view('business_profile/business_common', $this->data, true);$contition_array = array('contact_type' => '2', 'contact_person.status' => 'confirm', 'business_profile.status'=>'1');$search_condition = "((contact_from_id = ' $userid') OR (contact_to_id = '$userid'))";$join_str_contact[0]['table'] = 'business_profile';$join_str_contact[0]['join_table_id'] = 'business_profile.user_id';$join_str_contact[0]['from_table_id'] = 'contact_person.contact_from_id';$join_str_contact[0]['join_type'] = '';$this->data['businesscontacts'] = $businesscontacts = $this->common->select_data_by_search('contact_person', $search_condition, $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str_contact, $groupby = '');$contition_array = array('is_delete' => '0', 'status' => '1', 'user_id !=' => $userid, 'art_step' => '4');$this->data['userlistcount'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');?>