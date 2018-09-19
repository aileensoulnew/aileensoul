<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_model extends CI_Model {

    public function getUserData($user_id = '') {
        $this->db->select("u.user_id,u.first_name,u.last_name,u.user_dob,u.user_gender,u.user_agree,u.created_date,u.verify_date,u.user_verify,u.user_slider,u.user_slug,ui.user_image,ui.modify_date,ui.edit_ip,ui.profile_background,ui.profile_background_main,ul.email,ul.password,ul.is_delete,ul.status,ul.password_code")->from("user u");
        $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
        $this->db->join('user_login ul', 'ul.user_id = u.user_id', 'left');
        $this->db->where("u.user_id =" . $user_id);
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    public function is_userBasicInfo($user_id = '') {
        $this->db->select("COUNT(*) as total")->from("user_profession up");
        $this->db->where("up.user_id", $user_id);
        $query = $this->db->get();
        $result_array = $query->row('total');
        return $result_array;
    }

    public function is_userStudentInfo($user_id = '') {
        
        $this->db->select("COUNT(*) as total")->from("user_student us");
        $this->db->where("us.user_id", $user_id);
        $query = $this->db->get();
        $result_array = $query->row('total');
        return $result_array;
    }

    public function getUserSelectedData($user_id = '', $select_data = '') {
        $this->db->select($select_data)->from("user u");
        $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
        $this->db->join('user_login ul', 'ul.user_id = u.user_id', 'left');
        $this->db->where("u.user_id =" . $user_id);
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    public function getLeftboxData($user_id = '') {
        $this->db->select('u.first_name,u.last_name,u.user_slug,u.user_gender,ui.user_image,ui.profile_background,jt.name as title_name,d.degree_name')->from("user u");
        $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
        $this->db->join('user_profession up', 'up.user_id = u.user_id', 'left');
        $this->db->join('job_title jt', 'jt.title_id = up.designation', 'left');
        $this->db->join('user_student us', 'us.user_id = u.user_id', 'left');
        $this->db->join('degree d', 'd.degree_id = us.current_study', 'left');
        $this->db->join('user_login ul', 'ul.user_id = u.user_id', 'left');
        $this->db->where("u.user_id", $user_id);
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    public function getUserSlugById($user_id = '') {
        $this->db->select("u.user_slug")->from("user u");
        $this->db->where("u.user_id =" . $user_id);
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    public function getUserPasswordById($user_id = '') {
        $this->db->select("ul.password")->from("user_login ul");
        $this->db->where("ul.user_id =" . $user_id);
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    public function getCountry() {
        $this->db->select('country_id,country_name')->from('countries');
        $this->db->where(array('status' => '1'));
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getStateByCountryId($id) {
        $this->db->select('state_id,state_name')->from('states');
        $this->db->where(array('country_id' => $id, 'status' => '1'));
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getCityByStateId($id) {
        $this->db->select('city_id,city_name')->from('cities');
        $this->db->where(array('state_id' => $id, 'status' => '1'));
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getBusinessType() {
        $this->db->select('type_id,business_name')->from('business_type');
        $this->db->where(array('status' => '1', 'is_delete' => '0'));
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getCategory() {
        $this->db->select('industry_id,industry_name')->from('industry_type');
        $this->db->where(array('status' => '1', 'is_delete' => '0'));
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getUserByEmail($user_email = '') {
        $this->db->select("ul.user_id,ul.email")->from("user_login ul");
        $this->db->where(array('ul.email' => $user_email, 'is_delete' => '0', 'status' => '1'));
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    public function getUserPassword($userid = '', $oldpassword = '') {
        $this->db->select("ul.user_id")->from("user_login ul");
        $this->db->where(array('ul.user_id' => $userid, 'password' => $oldpassword));
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    public function getUserDataByEmail($user_email = '') {
        $this->db->select("u.user_id,u.first_name,u.last_name,u.user_dob,u.user_gender,u.user_agree,u.created_date,u.verify_date,u.user_verify,u.user_slider,u.user_slug,ui.user_image,ui.modify_date,ui.edit_ip,ui.profile_background,ui.profile_background_main,ul.email,ul.password,ul.is_delete,ul.status,ul.password_code")->from("user u");
        $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
        $this->db->join('user_login ul', 'ul.user_id = u.user_id', 'left');
        $this->db->where('ul.email', $user_email);
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    public function getUserProfessionData($user_id = '', $select_data = '') {
        $this->db->select($select_data)->from("user_profession up");
        $this->db->join('cities c', 'c.city_id = up.city', 'left');
        $this->db->join('user usr', 'usr.user_id = up.user_id', 'left');
        $this->db->join('job_title jt', 'jt.title_id = up.designation', 'left');
        $this->db->join('industry_type it', 'it.industry_id = up.field', 'left');
        $this->db->where("up.user_id =" . $user_id);
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    public function getSameFieldProUser($field = '',$other_field = '') {
        $this->db->select("GROUP_CONCAT(CONCAT('''', `user_id`, '''' )) AS group_user")->from("user_profession up");        
        if($field == 0)
        {
            if($other_field != ""){
                $of_sql = "";
                foreach (explode(" ", $other_field) as $key => $value) {
                    if($value != ""){                    
                        $of_sql .= " other_field LIKE '%".$value."%' OR";
                    }
                }
                $of_sql = trim($of_sql," OR");
                $this->db->where($of_sql);
            }
            else
            {
                $this->db->where("up.field =" . $field);
            }
        }
        else
        {
            $this->db->where("up.field =" . $field);
        }
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array['group_user'];
    }

    public function getUserStudentData($user_id = '', $select_data = '') {
        $this->db->select($select_data)->from("user_student us");
        $this->db->join('cities c', 'c.city_id = us.city', 'left');
        $this->db->join('user usr', 'usr.user_id = us.user_id', 'left');
        $this->db->join('university u', 'u.university_id = us.university_name', 'left');
        $this->db->join('degree d', 'd.degree_id = us.current_study', 'left');
        // $this->db->join('job_title jt', 'jt.title_id = us.interested_fields', 'left');
        $this->db->join('industry_type it', 'it.industry_id = us.interested_fields', 'left');
        $this->db->where("us.user_id =" . $user_id);
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        $result_array = $query->row_array();
        return $result_array;
    }

    public function getSameFieldStdUser($current_study = '') {
        $this->db->select("GROUP_CONCAT(CONCAT('''', `user_id`, '''' )) AS group_user")->from("user_student us");
        $this->db->where("us.current_study =" . $current_study);
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array['group_user'];
    }

    public function getUserDataByslug($user_slug = '', $select_data = '') {
        $this->db->select($select_data)->from("user u");
        $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
        $this->db->join('user_login ul', 'ul.user_id = u.user_id', 'left');
        $this->db->where("u.user_slug ='" . $user_slug . "'");
        $this->db->where("ul.status","1");
        $this->db->where("ul.is_delete","0");
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    public function getUserProfessionDataBySlug($user_slug = '', $select_data = '') {
        $this->db->select($select_data)->from("user_profession up");
        $this->db->join('cities c', 'c.city_id = up.city', 'left');
        $this->db->join('user usr', 'usr.user_id = up.user_id', 'left');
        $this->db->join('job_title jt', 'jt.title_id = up.designation', 'left');
        $this->db->join('industry_type it', 'it.industry_id = up.field', 'left');
        $this->db->where("usr.user_slug ='" . $user_slug . "'");
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    public function getUserStudentDataBySlug($user_slug = '', $select_data = '') {
        $this->db->select($select_data)->from("user_student us");
        $this->db->join('cities c', 'c.city_id = us.city', 'left');
        $this->db->join('user usr', 'usr.user_id = us.user_id', 'left');
        $this->db->join('university u', 'u.university_id = us.university_name', 'left');
        $this->db->join('degree d', 'd.degree_id = us.current_study', 'left');
        $this->db->where("usr.user_slug ='" . $user_slug . "'");
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    public function contact_request_pending($user_id = '') {
//        $this->db->select("uc.from_id,uc.to_id,uc.modify_date,uc.status,uc.not_read,CONCAT(u.first_name,' ', u.last_name) as fullname")->from("user_contact uc");
//        $this->db->join('user u', 'u.user_id = (CASE WHEN uc.from_id=' . $user_id . ' THEN uc.to_id ELSE uc.from_id END)');
        $this->db->select("uc.from_id,uc.modify_date,uc.status,uc.not_read,CONCAT(u.first_name,' ', u.last_name) as fullname,u.user_gender, u.user_slug,ui.user_image,jt.name as designation,d.degree_name as degree")->from("user_contact uc");
        $this->db->join('user u', 'u.user_id = uc.from_id');
        $this->db->join('user_info ui', 'ui.user_id = uc.from_id');
        $this->db->join('user_profession up', 'up.user_id = uc.from_id', 'left');
        $this->db->join('job_title jt', 'jt.title_id = up.designation', 'left');
        $this->db->join('user_student us', 'us.user_id = uc.from_id', 'left');
        $this->db->join('degree d', 'd.degree_id = us.current_study', 'left');
        $this->db->where("uc.to_id", $user_id);
        $this->db->where('uc.status', 'pending');
        $query = $this->db->get();
        $result_array = $query->result_array();
        foreach ($result_array as $key => $value) {
            $result_array[$key]['time_string'] = $this->common->time_elapsed_string($value['modify_date']);    
        }
        return $result_array;
    }

    public function contact_request_accept($user_id = '') {
//        $this->db->select("uc.from_id,uc.to_id,uc.modify_date,uc.status,uc.not_read,CONCAT(u.first_name,' ', u.last_name) as fullname")->from("user_contact uc");
//        $this->db->join('user u', 'u.user_id = (CASE WHEN uc.from_id=' . $user_id . ' THEN uc.to_id ELSE uc.from_id END)');
        $this->db->select("uc.to_id,uc.modify_date,uc.status,uc.not_read,CONCAT(u.first_name,' ', u.last_name) as fullname, u.first_name, u.last_name, u.user_gender , u.user_slug,ui.user_image,jt.name as designation,d.degree_name as degree")->from("user_contact uc");
        $this->db->join('user u', 'u.user_id = uc.to_id');
        $this->db->join('user_info ui', 'ui.user_id = uc.to_id');
        $this->db->join('user_profession up', 'up.user_id = uc.to_id', 'left');
        $this->db->join('job_title jt', 'jt.title_id = up.designation', 'left');
        $this->db->join('user_student us', 'us.user_id = uc.to_id', 'left');
        $this->db->join('degree d', 'd.degree_id = us.current_study', 'left');
        $this->db->where("uc.from_id", $user_id);
        $this->db->where('uc.status', 'confirm');
        $this->db->order_by('uc.modify_date', 'desc');
        $query = $this->db->get();
        $result_array = $query->result_array();
        foreach ($result_array as $key => $value) {
            $result_array[$key]['time_string'] = $this->common->time_elapsed_string($value['modify_date']);    
        }
        
        return $result_array;
    }

    public function contactRequestCount($user_id = '') {
        $this->db->select('COUNT(id) as total')->from('user_contact uc');
        $this->db->where("(uc.to_id ='$user_id' AND uc.status = 'pending') OR (uc.from_id ='$user_id' AND uc.status = 'confirm')");
        $this->db->where("uc.not_read", '2');
        $this->db->where("(uc.status = 'confirm' OR  uc.status = 'pending')");
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    public function contact_request($user_id = '') {
        $contact_request_pending = $this->contact_request_pending($user_id);
        $contact_request_accept = $this->contact_request_accept($user_id);
        $result_array = array_merge($contact_request_pending, $contact_request_accept);

        return $result_array;
    }

    public function contactRequestAction($user_id = '', $from_id = '', $action = '') {
        $data = array();
        $data['status'] = $action;
        $data['modify_date'] = date('Y-m-d H:i:s', time());
        if ($action == 'confirm') {
            $data['not_read'] = '2';
        }
        
        $this->db->where('from_id', $from_id);
        $this->db->where('to_id', $user_id);
        $result_array = $this->db->update('user_contact', $data);
        return $result_array;
    }

    public function contact_request_read($user_id = '') {
        $data = array('not_read' => '1');
        $this->db->where('to_id', $user_id);
        $this->db->where('status', 'pending');
        $result_array = $this->db->update('user_contact', $data);

        $data1 = array('not_read' => '1');
        $this->db->where('from_id', $user_id);
        $this->db->where('status', 'confirm');
        $result_array1 = $this->db->update('user_contact', $data1);
    }

    public function getJobTitleCityProUser($designation = '',$city = '') {
        $this->db->select("GROUP_CONCAT(CONCAT('''', `user_id`, '''' )) AS group_user")->from("user_profession up");
        if($designation != '')
        {
            $this->db->where("up.designation =" . $designation);
        }
        if($city != '')
        {            
            $this->db->where("up.city =" . $city);
        }
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array['group_user'];
    }

    public function getUnivetsityCityStdUser($university_name = '',$city = '') {
        $this->db->select("GROUP_CONCAT(CONCAT('''', `user_id`, '''' )) AS group_user")->from("user_student us");
        if($university_name != "")
        {            
            $this->db->where("us.university_name =" . $university_name);
        }

        if($city != "")
        {
            $this->db->where("us.city =" . $city);
        }
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array['group_user'];
    }

    public function getIncontactData($user_id = "")
    {
        $where = "((from_id = '" . $user_id . "' OR to_id = '" . $user_id . "'))";

        $this->db->select("GROUP_CONCAT(CONCAT('''', u.user_id, '''' )) AS group_user")->from("user_contact  uc");
        $this->db->join('user u', 'u.user_id = (CASE WHEN uc.from_id=' . $user_id . ' THEN uc.to_id ELSE uc.from_id END)', 'left');
        $this->db->where('u.user_id !=', $user_id);
        $this->db->where('uc.status', 'confirm');
        $this->db->where($where);        
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    public function getFollowersData($user_id = "")
    {
        $this->db->select("GROUP_CONCAT(CONCAT('''', uf.follow_from, '''' )) AS follower_user")->from("user_follow  uf");
        $this->db->where('uf.status', '1');
        $this->db->where("uf.follow_to",$user_id);

        $query = $this->db->get();

        $result_array = $query->row_array();
        return $result_array;
    }

    function getAnyJobTitle($title_id = '') {
        $this->db->select('jt.name as job_name')->from('job_title jt');
        $this->db->where('jt.title_id', $title_id);        
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    function getAnyIndustryName($title_id = '') {
        // $this->db->select('jt.name as job_name')->from('job_title jt');
        $this->db->select('it.industry_name as job_name')->from('industry_type it');
        $this->db->where('it.type_id', '');
        $this->db->where('it.industry_id', $title_id);
        $this->db->where('it.status', '1');
        $this->db->where('it.is_delete', '0');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    function getAnyDegreename($degree_id = '') {
        $this->db->select('degree_name')->from('degree');
        $this->db->where('degree_id', $degree_id);        
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    function getAnyJobIds($title_name = '') {
        $this->db->select("GROUP_CONCAT(jt.title_id) AS jobs_id")->from('job_title jt');
        $this->db->where($title_name);        
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    function getPostIdsForOppQue($table_name = '',$search_srt = '') {
        $this->db->select("GROUP_CONCAT(CONCAT('''', post_id, '''' )) AS post_id")->from($table_name);
        $search_srt = str_replace(",", "|", $search_srt);
        if($table_name == 'user_opportunity'){
            $this->db->where('opportunity_for REGEXP "[[:<:]]('.$search_srt.')[[:>:]]"',false,false);
        }
        if($table_name == 'user_ask_question'){
            $this->db->where(' category REGEXP "[[:<:]]('.$search_srt.')[[:>:]]"',false,false);
        }
        $this->db->order_by("post_id","desc");
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    public function get_art_url($userid, $from = "") {

        $contition_array = array('user_id' => $userid, 'status' => '1');
        $arturl = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id,art_city,art_skill,other_skill,slug', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        if($from == "artist"){
            return $arturl[0]['slug'];
        }

        $city_url = $this->db->select('city_name')->get_where('cities', array('city_id' => $arturl[0]['art_city'], 'status' => '1'))->row()->city_name;

        $art_othercategory = $this->db->select('other_category')->get_where('art_other_category', array('other_category_id' => $arturl[0]['other_skill']))->row()->other_category;

        $category = $arturl[0]['art_skill'];
        $category = explode(',', $category);

        foreach ($category as $catkey => $catval) {
            $art_category = $this->db->select('art_category')->get_where('art_category', array('category_id' => $catval))->row()->art_category;
            $categorylist[] = $art_category;
        }

        $listfinal1 = array_diff($categorylist, array('other'));
        $listFinal = implode('-', $listfinal1);

        if (!in_array(26, $category)) {
            $category_url = $this->common->clean($listFinal);
        } else if ($arturl[0]['art_skill'] && $arturl[0]['other_skill']) {

            $trimdata = $this->common->clean($listFinal) . '-' . $this->common->clean($art_othercategory);
            $category_url = trim($trimdata, '-');
        } else {
            $category_url = $this->common->clean($art_othercategory);
        }

        $city_get = $this->common->clean($city_url);

        if (!$city_get) {
            $url = $arturl[0]['slug'] . '-' . $category_url . '-' . $arturl[0]['art_id'];
        } else if (!$category_url) {
            $url = $arturl[0]['slug'] . '-' . $city_get . '-' . $arturl[0]['art_id'];
        } else if ($city_get && $category_url) {
            $url = $arturl[0]['slug'] . '-' . $category_url . '-' . $city_get . '-' . $arturl[0]['art_id'];
        }
        return $url;
    }

    public function unsubscribeUser($encrypt_key = "", $user_slug = "",$user_id = "",$reason = "")
    {
        $userData = $this->db->select('*')->get_where('user', array('md5(encrypt_key)' => $encrypt_key, 'md5(user_slug)' => $user_slug, 'md5(user_id)' => $user_id, 'is_subscribe' => '1'))->row();
        if(isset($userData) && !empty($userData))
        {
            $data = array("is_subscribe" => 0);
            $this->db->where('encrypt_key', $userData->encrypt_key);
            $this->db->where('user_slug', $userData->user_slug);
            $this->db->where('user_id', $userData->user_id);
            $result_array = $this->db->update('user', $data);

            $data_ins = array(
                "user_id" => $userData->user_id,
                "reason" => $reason,
                "status" => '1',
                "created_date" => date('Y-m-d H:i:s', time())

            );
            $result_array = $this->db->insert('unsubscribe_reason', $data_ins);
            return 1;
        }
        else
        {
            return 0;
        }
        // print_r($userData);exit();
    }


}
