<?php$this->load->model('user_post_model');$this->load->model('business_model');$userid = $this->session->userdata('aileenuser');// USERDATA USE FOR HEADER NAME AND IMAGE START$userdata = $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = 'u.first_name,ui.user_image');$contition_array = array('contact_to_id' => $userid,'contact_type' => '2','status' => 'pending','not_read'=>'2');$conReq = $this->common->select_data_by_condition('contact_person', $contition_array, $data = 'count(*) as total_bus_con_req', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');if(isset($conReq) && $conReq[0]['total_bus_con_req'] > 0)    $this->data['bus_con_request'] = $conReq[0]['total_bus_con_req'];else    $this->data['bus_con_request'] = "";$contition_array = array('not_read' => '2', 'not_to_id' => $userid, 'not_type !=' => '1', 'not_type !=' => '2');$result = $this->common->select_data_by_condition('notification', $contition_array, $data = 'count(*) as total', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');$this->data['user_notification_count'] = $count = $result[0]['total'];$contition_array = array('not_read' => '2');$search_condition = "((contact_to_id = '$userid' AND status = 'pending') OR (contact_from_id = '$userid' AND status = 'confirm'))";$contactperson = $this->common->select_data_by_search('contact_person', $search_condition, $contition_array, $data = 'count(*) as total', $sortby = 'contact_id', $orderby = '', $limit = '', $offset = '', $join_str = '', $groupby = '');$this->data['contact_request_count'] = $contactcount = $contactperson[0]['total'];// THIS CODE FOR BUSINESS PROFILE IMAGE IN COVERPAGE START$contition_array = array('user_id' => $userid, 'status' => '1');$slug_data = $this->data['slug_data'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_profile_id,company_name,business_slug,business_user_image', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');$this->data['business_login_profile_id'] = $business_profile_id = $slug_data[0]['business_profile_id'];$this->data['business_login_company_name'] = $company_name = $slug_data[0]['company_name'];$this->data['business_login_slug'] = $slug_id = $slug_data[0]['business_slug'];$this->data['business_login_user_image'] = $business_user_image = $slug_data[0]['business_user_image'];if ($this->data['business_login_user_image'] == '') {    $no_image = NOBUSIMAGE;    $no_image = str_replace('uploads/', '', $no_image);    $this->data['business_login_user_image'] = $no_image;}$this->data['business_search'] = $this->load->view('business_profile/business_search', $this->data, true);$slug = $this->uri->segment(3);if (is_numeric($slug)) {    $slug = '';}// print_r($slug_data);// echo $slug;exit;if ($slug_id != '') {    if (($slug == $slug_data[0]['business_slug'] || $slug == '') && $slug != 'manage') {        $contition_array = array('user_id' => $userid, 'status' => '1', 'is_deleted' => '0');        $data = "business_profile_id,user_id,business_user_image,business_slug,industriyal,other_industrial,company_name,profile_background,city,state,business_type,business_step";        $business_common_data = $this->data['business_common_data'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');    } elseif ($slug == 'manage') {        $userid = $this->uri->segment(4);        $contition_array = array('user_id' => $userid, 'status' => '1', 'is_deleted' => '0');        $data = "business_profile_id,user_id,business_user_image,business_slug,industriyal,other_industrial,company_name,profile_background,city,state,country,business_type,business_step";        $business_common_data = $this->data['business_common_data'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');    } else {        $slug1 = $slug_data[0]['business_slug'];        $contition_array = array('business_slug' => $slug1, 'status' => '1', 'business_step' => '4', 'is_deleted' => '0');        $data = "business_profile_id,user_id,business_user_image,business_slug,industriyal,other_industrial,company_name,profile_background,city,state,country,business_type,business_step";        $business_common_data = $this->data['business_common_data'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');        //$company_description = $this->get_description($id);         $this->data['country_name'] = $this->db->get_where('countries', array('country_id' => $business_common_data[0]['country']))->row()->country_name;        $this->data['city_name'] = $this->db->get_where('cities', array('city_id' => $business_common_data[0]['city']))->row()->city_name;    }} else {    $business_common_data = $this->data['business_common_data'][0]['business_step'] = 0;    $contition_array = array('business_slug' => $this->uri->segment(3), 'status' => '1', 'business_step' => '4', 'is_deleted' => '0');    $data = "business_profile_id,user_id,business_user_image,business_slug,industriyal,other_industrial,company_name,profile_background,city,state,country,business_type,business_step";    $business_common_data = $this->data['business_common_data'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');    //$company_description = $this->get_description($id);     $this->data['country_name'] = $this->db->get_where('countries', array('country_id' => $business_common_data[0]['country']))->row()->country_name;    $this->data['city_name'] = $this->db->get_where('cities', array('city_id' => $business_common_data[0]['city']))->row()->city_name;}//echo '<pre>';//print_r($business_common_data);//exit;// THIS CODE FOR BUSINESS PROFILE IMAGE IN COVERPAGE END$this->data['head'] = $this->load->view('head', $this->data, true);$this->data['head_profile_reg'] = $this->load->view('head_profile_reg', $this->data, true);$this->data['head_message'] = $this->load->view('head_message', $this->data, true);//$this->data['header'] = $this->load->view('header', $this->data, true);$this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");$this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);$this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);$this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);$this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);$this->data['header_inner_profile'] = $this->load->view('header_inner_profile', $this->data, true);$this->data['footer'] = $this->load->view('footer', $this->data, true);$this->data['left_footer'] = $this->load->view('leftfooter', $this->data, TRUE);$this->data['business_user_following_count'] = $this->business_model->business_user_following_count($business_common_data[0]['business_profile_id']);$this->data['business_user_follower_count'] = $this->business_model->business_user_follower_count($business_common_data[0]['business_profile_id']);$this->data['business_user_contacts_count'] = $this->business_model->business_user_contacts_count($business_common_data[0]['business_profile_id']);$this->data['business_common'] = $this->load->view('business_profile_live/business_common', $this->data, true);//$this->data['business_header2_border'] = $this->load->view('business_profile/business_header2_border', $this->data, true);$this->data['isbusiness_deactive'] = false;$contition_array = array('user_id' => $userid, 'status' => '0', 'is_deleted' => '0');$business_deactive = $this->common->select_data_by_condition('business_profile', $contition_array, $data = ' business_profile_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby);if (count($business_deactive) > 0) {    $this->data['isbusiness_deactive'] = true;}$this->data['isbusiness_register'] = false;$contition_array = array('user_id' => $userid);$business_register = $this->common->select_data_by_condition('business_profile', $contition_array, $data = ' business_profile_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby);if (count($business_register) > 0) {    $this->data['isbusiness_register'] = true;}$this->data['business_header2'] = $this->load->view('business_profile_live/business_header2', $this->data, true);$this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);?>