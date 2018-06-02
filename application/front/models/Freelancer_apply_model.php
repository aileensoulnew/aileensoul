<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Freelancer_apply_model extends CI_Model {

    public function getfreelancerapplydata($user_id, $select_data) {
        $this->db->select($select_data)->from('freelancer_post_reg');
        $this->db->where(array('user_id' => $user_id, 'is_delete' => '0', 'status' => '1'));
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    public function getfreelancerapplypost($user_id, $select_data) {
        $select_data = "post_id,post_name,(SELECT  Count(uv.invite_id) As invitecount FROM ailee_user_invite as uv WHERE   (uv.post_id = fp.post_id) ) As ShortListedCount,(SELECT  Count(afa.app_id) As invitecount FROM ailee_freelancer_apply as afa WHERE (afa.post_id = fp.post_id) ) As AppliedCount,fp.created_date,post_rate,GROUP_CONCAT(DISTINCT(s.skill)) as post_skill,post_rating_type,currency_name as post_currency,ct.city_name as city,cr.country_name as country,post_description,post_field_req";
        $this->db->select($select_data)->from('freelancer_post fp,ailee_skill s');
        $this->db->join('job_title jt', 'jt.title_id = fp.post_name', 'left');
        $this->db->join('currency c', 'c.currency_id = fp.post_currency', 'left');
        $this->db->join('cities ct', 'ct.city_id = fp.city', 'left');
        $this->db->join('countries cr', 'cr.country_id = fp.country', 'left');
        $this->db->where('FIND_IN_SET(s.skill_id, fp.`post_skill`) !=', 0);
        $this->db->where(array('fp.is_delete' => '0', 'fp.status' => '1'));
        $this->db->group_by('fp.post_skill');
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    function searchFreelancerApplyData($keyword = '', $location = '', $time = '') {

        $keyword = str_replace('%20', ' ', $keyword);
        $location = str_replace('%20', ' ', $location);

        // $busCat = $this->findBusinesCategory($keyword);
        $this->db->select('post_id,post_name,(SELECT  Count(uv.invite_id) As invitecount FROM ailee_user_invite as uv WHERE   (uv.post_id = fp.post_id) ) As ShortListedCount,(SELECT  Count(afa.app_id) As invitecount FROM ailee_freelancer_apply as afa WHERE (afa.post_id = fp.post_id) ) As AppliedCount,fp.created_date,post_rate,GROUP_CONCAT(DISTINCT(s.skill)) as post_skill,post_rating_type,currency_name as post_currency,ct.city_name as city,cr.country_name as country,post_description,post_field_req')->from('freelancer_post fp,ailee_skill s');
        $this->db->join('cities ct', 'ct.city_id = fp.city', 'left');
        $this->db->join('countries cr', 'cr.country_id = fp.country', 'left');
        $this->db->join('states st', 'st.state_name = fp.state', 'left');
        $this->db->join('freelancer_hire_reg fhg', 'fhg.user_id = fp.user_id', 'left');
        $this->db->join('currency c', 'c.currency_id = fp.post_currency', 'left');
        $this->db->where('FIND_IN_SET(s.skill_id, fp.`post_skill`) !=', 0);
        if ($keyword != '' && $busCat == '') {
            $this->db->where("(fp.post_name LIKE '%$keyword%' OR fp.post_description LIKE '%$keyword%')");
        } elseif ($keyword != '' && $busCat != '') {
            $this->db->where("(fp.company_name LIKE '%$keyword%' OR fp.address LIKE '%$keyword%' OR fp.contact_person LIKE '%$keyword%' OR bp.contact_mobile LIKE '%$keyword%' OR bp.contact_email LIKE '%$keyword%' OR bp.contact_website LIKE '%$keyword%' OR bp.details LIKE '%$keyword%' OR bp.business_slug LIKE '%$keyword%' OR bp.other_business_type LIKE '%$keyword%' OR bp.other_industrial LIKE '%$keyword%' OR bp.industriyal = '$busCat')");
        }
        if ($location != '') {
            $this->db->where("(ct.city_name = '$location' OR cr.country_name = '$location' OR st.state_name = '$location')");
        }
        $this->db->where('fp.status', '1');
        $this->db->where('fp.is_delete', '0');
        $this->db->group_by('fp.post_skill');
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }
    
    function freelancerCategory($limit = '') {
        $this->db->select('count(fp.post_id) as count,ji.industry_id,ji.industry_name,ji.industry_slug')->from('job_industry ji');
        $this->db->join('freelancer_post fp', 'fp.post_field_req = ji.industry_id', 'left');
        $this->db->where('ji.status', '1');
        $this->db->where('ji.is_delete', '0');
        $this->db->where('fp.status', '1');
        $this->db->where('fp.is_delete', '0');
        $this->db->group_by('fp.post_field_req');
        $this->db->order_by('count', 'desc');
        $this->db->limit($limit);
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    function freelancerFields($limit = '5',$page = "") {
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;$sql = "";

        $this->db->select('count(fp.post_id) as count,c.category_id,c.category_name,c.category_slug,c.category_image')->from('category c');
        $this->db->join('freelancer_post fp', 'fp.post_field_req = c.category_id', 'left');
        $this->db->where('c.status', '1');
        $this->db->where('c.is_delete', '0');
        $this->db->where('c.is_other', '0');
        $this->db->where('c.category_id != ', '15');
        $this->db->where('fp.status', '1');
        $this->db->where('fp.is_delete', '0');
        $this->db->group_by('fp.post_field_req');
        $this->db->order_by('count', 'desc');
        if($limit != '') {
            $this->db->limit($limit,$start);
        }
        $query = $this->db->get();
        // echo $this->db->last_query();exit;
        $result_array = $query->result_array();
        foreach ($result_array as $k => $v) {
            if(!file_exists(FA_CATEGORY_IMG_PATH."/".$result_array[$k]['category_image']))
            {
                $result_array[$k]['category_image'] = "category_default.png";
            }
        }
        return $result_array;
    }

    function get_fa_field($limit = '',$page = "") {
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;


        $sql = "SELECT count(fp.post_id) as count,c.category_id,c.category_name,c.category_slug,c.category_image FROM ailee_category c,ailee_freelancer_post fp WHERE fp.post_field_req = c.category_id AND c.category_id != 15 AND c.status = '1' AND c.is_delete = '0' AND c.is_other = '0' AND fp.status = '1' AND fp.is_delete = '0' GROUP BY fp.post_field_req ORDER BY count DESC";
        if($limit != '') {
            $sql .= " LIMIT $start,$limit";
        }

        $query = $this->db->query($sql);

        $fa_category = $query->result_array();
        foreach ($fa_category as $k => $v) {
            if(!file_exists(FA_CATEGORY_IMG_PATH."/".$fa_category[$k]['category_image']))
            {
                $fa_category[$k]['category_image'] = "category_default.png";
            }
        }
        
        $ret_array['fa_fields'] = $fa_category;
        $ret_array['total_record'] = $this->get_fa_field_total_rec();
        return $ret_array;
    }

    function get_fa_field_total_rec() {        

        $sql = "SELECT count(fp.post_id) as count,c.category_id,c.category_name,c.category_slug,c.category_image FROM ailee_category c,ailee_freelancer_post fp WHERE fp.post_field_req = c.category_id AND c.category_id != 15 AND c.status = '1' AND c.is_delete = '0' AND c.is_other = '0' AND fp.status = '1' AND fp.is_delete = '0' GROUP BY fp.post_field_req ORDER BY count DESC";

        $query = $this->db->query($sql);
        $return_array = $query->result_array();
        return count($return_array);
    }

    function get_fa_category($limit = '',$page = "") {
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;


        $sql = "SELECT count(fp.post_id) as count, s.skill_id, s.skill, s.skill_slug, s.skill_image FROM ailee_skill s,ailee_freelancer_post fp WHERE FIND_IN_SET(s.skill_id,fp.post_skill) > 0 AND s.status = '1' AND s.type = '1' AND fp.status = '1' AND fp.is_delete = '0' GROUP BY s.skill_id ORDER BY count DESC";
        if($limit != '') {
            $sql .= " LIMIT $start,$limit";
        }

        $query = $this->db->query($sql);

        $faSkills = $query->result_array();
        foreach ($faSkills as $k => $v) {
            if(!file_exists(SKILLS_IMG_PATH."/".$faSkills[$k]['skill_image']))
            {
                $faSkills[$k]['skill_image'] = "skills_default.png";
            }
        }
        
        $ret_array['fa_category'] = $faSkills;
        $ret_array['total_record'] = $this->get_fa_category_total_rec();
        return $ret_array;
    }

    function get_fa_category_total_rec() {        

        $sql = "SELECT count(fp.post_id) as count, s.skill_id, s.skill, s.skill_slug, s.skill_image FROM ailee_skill s,ailee_freelancer_post fp WHERE FIND_IN_SET(s.skill_id,fp.post_skill) > 0 AND s.status = '1' AND s.type = '1' AND fp.status = '1' AND fp.is_delete = '0' GROUP BY s.skill_id ORDER BY count DESC";

        $query = $this->db->query($sql);
        $return_array = $query->result_array();
        return count($return_array);
    }

    function is_fa_skills($keyword = "")
    {
        $this->db->select('s.skill_id,s.skill,s.skill_slug')->from('skill s');
        $this->db->where('s.status', '1');
        $this->db->where('s.type', '1');        
        $this->db->where('s.skill_slug LIKE BINARY "'.$keyword.'"');
        $query = $this->db->get();        
        $return_array = $query->row_array();
        return $return_array;
    }

    function is_fa_field($keyword = "")
    {
        $this->db->select('c.category_id,c.category_name,c.category_slug')->from('category c');        
        $this->db->where('c.status', '1');
        $this->db->where('c.is_delete', '0');
        $this->db->where('c.is_other', '0');        
        $this->db->where('c.category_id !=', '15');       
        $this->db->where('c.category_slug LIKE BINARY "'.$keyword.'"');
        $query = $this->db->get();
        // echo $this->db->last_query();exit;
        $result_array = $query->row_array();
        return $result_array;
    }

    function ajax_project_list_no_login($userid = "",$fa_skills = array(),$fa_fields = array(),$category_id = "",$skill_id = "",$worktype = "",$period_filter = "",$exp_fil = "",$page = "",$limit = '5',$keyword = "",$search_location_arr = array())
    {
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;

        $sql = "";        
        if($category_id != "")
        {
            $sql .= "post_field_req IN (".$category_id.") OR ";
        }        
        if($skill_id != "")
        {
            $skill_id = str_replace(",", "|", $skill_id);
            $sql .= "fp.post_skill REGEXP '[[:<:]](".$skill_id.")[[:>:]]' OR ";
        }
        if($worktype != "")
        {
            $sql_wt = "";
            foreach (explode(",", $worktype) as $key => $value) {
                if($value == 1)
                    $sql_wt .= "(fp.post_rating_type = 1) OR ";
                if($value == 2)
                    $sql_wt .= "(fp.post_rating_type = 2) OR ";
            }
            $sql .= "(".trim($sql_wt, ' OR ').") OR ";
        }
        if($period_filter != "")
        {
            $sql_period = "";
            foreach (explode(",", $period_filter) as $key => $value) {
                if($value == 1)
                    $sql_period .= "(DATEDIFF(NOW(),fp.created_date) = 0) OR ";
                if($value == 2)
                    $sql_period .= "(DATEDIFF(NOW(),fp.created_date) >= 0 AND DATEDIFF(NOW(),fp.created_date) <=7) OR ";
                if($value == 3)
                    $sql_period .= "(DATEDIFF(NOW(),fp.created_date) >= 0 AND DATEDIFF(NOW(),fp.created_date) <=15) OR ";
                if($value == 4)
                    $sql_period .= "(DATEDIFF(NOW(),fp.created_date) >= 0 AND DATEDIFF(NOW(),fp.created_date) <=45) OR ";                
                if($value == 5)
                    $sql_period .= "(DATEDIFF(NOW(),fp.created_date) >= 45) OR ";
            }
            $sql .= "(".trim($sql_period, ' OR ').") OR ";
        }
        if($exp_fil != "")
        {
            $sql_exp = "";
            foreach (explode(",", $exp_fil) as $key => $value) {
                if($value == 1)
                    $sql_exp .= "(fp.post_exp_year >= 0 AND fp.post_exp_year <=1) OR ";
                if($value == 2)
                    $sql_exp .= "(fp.post_exp_year >= 1 AND fp.post_exp_year <=2) OR ";
                if($value == 3)
                    $sql_exp .= "(fp.post_exp_year >= 2 AND fp.post_exp_year <=3) OR ";
                if($value == 4)
                    $sql_exp .= "(fp.post_exp_year >= 3 AND fp.post_exp_year <=4) OR ";
                if($value == 5)
                    $sql_exp .= "(fp.post_exp_year >= 4 AND fp.post_exp_year <=5) OR ";
                if($value == 6)
                    $sql_exp .= "(fp.post_exp_year >= 5) OR ";
            }
            $sql .= "(".trim($sql_exp, ' OR ').") OR ";
        }

        $select_data = "post_id,post_name,(SELECT  Count(uv.invite_id) As invitecount FROM ailee_user_invite as uv WHERE   (uv.post_id = fp.post_id) ) As ShortListedCount,(SELECT  Count(afa.app_id) As invitecount FROM ailee_freelancer_apply as afa WHERE (afa.post_id = fp.post_id) ) As AppliedCount,fp.created_date,post_rate,post_rating_type,currency_name as post_currency,ct.city_name as city,cr.country_name as country,post_description,post_field_req,fp.user_id,DATEDIFF(fp.post_last_date,NOW()) as day_remain,fp.post_slug";
        $this->db->select($select_data)->from('freelancer_post fp');
        $this->db->join('freelancer_hire_reg fhr', 'fhr.user_id = fp.user_id', 'left');
        $this->db->join('job_title jt', 'jt.title_id = fp.post_name', 'left');
        $this->db->join('currency c', 'c.currency_id = fp.post_currency', 'left');
        $this->db->join('cities ct', 'ct.city_id = fhr.city', 'left');
        $this->db->join('countries cr', 'cr.country_id = fhr.country', 'left');

        if(isset($fa_skills) && !empty($fa_skills)){            
            $this->db->where('FIND_IN_SET('.$fa_skills['skill_id'].', fp.`post_skill`) !=', 0);
        }
        else if(isset($fa_fields) && !empty($fa_fields)){            
            $this->db->where('post_field_req',$fa_fields['category_id']);
        }
        //$this->db->where('FIND_IN_SET(`s`.`skill_id`, `fp`.`post_skill`)');
        if($sql != "")
        {            
            $sql = "(".trim($sql, ' OR ').")";
            $this->db->where($sql,false,false);
        }
        $this->db->where(array('fp.is_delete' => '0', 'fp.status' => '1'));
        //$this->db->group_by('fp.post_skill,fp.post_id');
        $this->db->order_by('fp.post_id','desc');
        if($limit != "")
        {
            $this->db->limit($limit,$start);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        $result_array = $query->result_array();
        foreach ($result_array as $key => $value) {
            $firstname = $this->db->select('fullname')->get_where('freelancer_hire_reg', array('user_id' => $value['user_id']))->row()->fullname;
            $result_array[$key]['fullname'] = $firstname;

            $category_name = $this->db->select('category_name')->get_where('category', array('category_id' => $value['post_field_req']))->row()->category_name;
            $result_array[$key]['industry_name'] = $category_name;

            $contition_array = array('post_id' => $value['post_id'], 'job_delete' => '0', 'user_id' => $userid);
            $freelancerapply1 = $this->data['freelancerapply'] = $this->common->select_data_by_condition('freelancer_apply', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            if(isset($freelancerapply1) && !empty($freelancerapply1))
                $result_array[$key]['apply_post'] = 1;
            else
                $result_array[$key]['apply_post'] = 0;

            $contition_array = array('user_id' => $userid, 'job_save' => '2', 'post_id ' => $value['post_id'], 'job_delete' => '1');
            $jobsave = $this->common->select_data_by_condition('freelancer_apply', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if(isset($jobsave) && !empty($jobsave))
                $result_array[$key]['saved_post'] = 1;
            else
                $result_array[$key]['saved_post'] = 0;
            
            $result_array[$key]['post_skill'] = $this->get_skill_name_from_post_id($value['post_id']);
        }
        
        //return $result_array;
        $retur_arr = array();
        $retur_arr['fa_projects'] = $result_array;
        $retur_arr['total_record'] = $this->ajax_project_list_no_login_tot_rec($userid,$fa_skills,$fa_fields,$category_id,$skill_id,$worktype,$period_filter,$exp_fil,$keyword,$search_location_arr);
        return $retur_arr;
    }

    function ajax_project_list_no_login_tot_rec($userid = "",$fa_skills = array(),$fa_fields = array(),$category_id = "",$skill_id = "",$worktype = "",$period_filter = "",$exp_fil = "",$keyword = "",$search_location_arr = array())
    {
        $sql = "";        
        if($category_id != "")
        {
            $sql .= "post_field_req IN (".$category_id.") OR ";
        }        
        if($skill_id != "")
        {
            $skill_id = str_replace(",", "|", $skill_id);
            $sql .= "fp.post_skill REGEXP '[[:<:]](".$skill_id.")[[:>:]]' OR ";
        }
        if($worktype != "")
        {
            $sql_wt = "";
            foreach (explode(",", $worktype) as $key => $value) {
                if($value == 1)
                    $sql_wt .= "(fp.post_rating_type = 1) OR ";
                if($value == 2)
                    $sql_wt .= "(fp.post_rating_type = 2) OR ";
            }
            $sql .= "(".trim($sql_wt, ' OR ').") OR ";
        }
        if($period_filter != "")
        {
            $sql_period = "";
            foreach (explode(",", $period_filter) as $key => $value) {
                if($value == 1)
                    $sql_period .= "(DATEDIFF(NOW(),fp.created_date) = 0) OR ";
                if($value == 2)
                    $sql_period .= "(DATEDIFF(NOW(),fp.created_date) >= 0 AND DATEDIFF(NOW(),fp.created_date) <=7) OR ";
                if($value == 3)
                    $sql_period .= "(DATEDIFF(NOW(),fp.created_date) >= 0 AND DATEDIFF(NOW(),fp.created_date) <=15) OR ";
                if($value == 4)
                    $sql_period .= "(DATEDIFF(NOW(),fp.created_date) >= 0 AND DATEDIFF(NOW(),fp.created_date) <=45) OR ";                
                if($value == 5)
                    $sql_period .= "(DATEDIFF(NOW(),fp.created_date) >= 45) OR ";
            }
            $sql .= "(".trim($sql_period, ' OR ').") OR ";
        }
        if($exp_fil != "")
        {
            $sql_exp = "";
            foreach (explode(",", $exp_fil) as $key => $value) {
                if($value == 1)
                    $sql_exp .= "(fp.post_exp_year >= 0 AND fp.post_exp_year <=1) OR ";
                if($value == 2)
                    $sql_exp .= "(fp.post_exp_year >= 1 AND fp.post_exp_year <=2) OR ";
                if($value == 3)
                    $sql_exp .= "(fp.post_exp_year >= 2 AND fp.post_exp_year <=3) OR ";
                if($value == 4)
                    $sql_exp .= "(fp.post_exp_year >= 3 AND fp.post_exp_year <=4) OR ";
                if($value == 5)
                    $sql_exp .= "(fp.post_exp_year >= 4 AND fp.post_exp_year <=5) OR ";
                if($value == 6)
                    $sql_exp .= "(fp.post_exp_year >= 5) OR ";
            }
            $sql .= "(".trim($sql_exp, ' OR ').") OR ";
        }

        $select_data = "post_id,post_name,(SELECT  Count(uv.invite_id) As invitecount FROM ailee_user_invite as uv WHERE   (uv.post_id = fp.post_id) ) As ShortListedCount,(SELECT  Count(afa.app_id) As invitecount FROM ailee_freelancer_apply as afa WHERE (afa.post_id = fp.post_id) ) As AppliedCount,fp.created_date,post_rate,post_rating_type,currency_name as post_currency,ct.city_name as city,cr.country_name as country,post_description,post_field_req";
        $this->db->select($select_data)->from('freelancer_post fp');
        $this->db->join('freelancer_hire_reg fhr', 'fhr.user_id = fp.user_id', 'left');
        $this->db->join('job_title jt', 'jt.title_id = fp.post_name', 'left');
        $this->db->join('currency c', 'c.currency_id = fp.post_currency', 'left');
        $this->db->join('cities ct', 'ct.city_id = fhr.city', 'left');
        $this->db->join('countries cr', 'cr.country_id = fhr.country', 'left');
        if(isset($fa_skills) && !empty($fa_skills)){            
            $this->db->where('FIND_IN_SET('.$fa_skills['skill_id'].', fp.`post_skill`) !=', 0);
        }
        else if(isset($fa_fields) && !empty($fa_fields)){            
            $this->db->where('post_field_req',$fa_fields['category_id']);
        }        
        if($sql != "")
        {            
            $sql = "(".trim($sql, ' OR ').")";
            $this->db->where($sql,false,false);
        }
        $this->db->where(array('fp.is_delete' => '0', 'fp.status' => '1'));
        // $this->db->group_by('fp.post_skill,fp.post_id');
        $this->db->order_by('fp.post_id','desc');
        
        $query = $this->db->get();
        // echo $this->db->last_query();exit;
        $result_array = $query->result_array();
        return count($result_array);
    }

    
	//GET FILTER LIST
	public function get_filter_category($limitstart = 0, $limit = 5){
		$sql = "SELECT count(*) as count, c.category_name, c.category_id, false as isselected
				FROM ailee_freelancer_post_reg fpr
				LEFT JOIN ailee_category as c on c.category_id = fpr.freelancer_post_field
				WHERE  c.category_name IS NOT NULL and fpr.status = 1 and c.category_name != 'Other' 
				GROUP BY 
				c.category_name
				ORDER BY count DESC LIMIT $limitstart,$limit";
		$query = $this->db->query($sql);
        $result_array = $query->result_array();
        return $result_array;
	}

	public function get_filter_cities($limitstart = 0, $limit = 5){
		$sql = "SELECT count(*) as count, c.city_name, c.city_id, false as isselected
				FROM ailee_freelancer_post_reg fpr
				LEFT JOIN ailee_cities as c on c.city_id = fpr.freelancer_post_city
				WHERE  c.city_name IS NOT NULL and fpr.status = 1  
				GROUP BY c.city_name
				ORDER BY count DESC LIMIT $limitstart,$limit";
		$query = $this->db->query($sql);
        $result_array = $query->result_array();
        return $result_array;
	}

	public function get_filter_skills($limitstart = 0, $limit = 5){
		$sql = "SELECT count(fpr.freelancer_post_reg_id) as count, s.skill_id, 
				s.skill, s.skill_slug, s.skill_image 
				FROM ailee_skill s,ailee_freelancer_post_reg fpr 
				WHERE FIND_IN_SET(s.skill_id,fpr.freelancer_post_area) > 0 
				AND s.status = '1' AND s.type = '1' AND fpr.status = '1' AND fpr.is_delete = '0' 
				GROUP BY s.skill_id 
				ORDER BY count DESC 
				LIMIT $limitstart,$limit";

		$query = $this->db->query($sql);
        $result_array = $query->result_array();
        return $result_array;
	}

	public function get_filter_experience($limitstart = 0, $limit = 5){
        $result[] = array('id' => '1','name' => '0 to 1 year', 'isselected' => false);
        $result[] = array('id' => '2','name' => '1 to 2 year', 'isselected' => false);
        $result[] = array('id' => '3','name' => '2 to 3 year', 'isselected' => false);
        $result[] = array('id' => '4','name' => '3 to 4 year', 'isselected' => false);
        $result[] = array('id' => '5','name' => '4 to 5 year', 'isselected' => false);
        $result[] = array('id' => '6','name' => 'More than 5 year', 'isselected' => false);
        return $result;
    }

    function freelancer_apply_search_city($keyword = ''){
        $keyword = urldecode($keyword) . '%';
        $sql = "SELECT city_name as value FROM ailee_cities 
                WHERE status = '1' AND state_id != '0' AND (city_name LIKE '". $keyword ."') 
                GROUP BY city_name LIMIT 5";
        $query = $this->db->query($sql);
        $result_array = $query->result_array();
        return $result_array;
    }

    function freelancer_apply_search_keyword($keyword = ''){
        $keyword = '%' . urldecode($keyword) . '%';
        $sql = "SELECT skill as value FROM ailee_skill 
                WHERE status = '1' AND type = 1 AND (skill LIKE '". $keyword ."') 
                GROUP BY skill 
                Union

                SELECT category_name as value FROM ailee_category 
                WHERE status = '1' AND is_other = '0' AND category_id != 15 AND is_delete = '0' AND (category_name LIKE '". $keyword ."') 
                GROUP BY category_name 
                Union

                SELECT post_name as value FROM ailee_freelancer_post 
                WHERE status = '1' AND is_delete = '0' AND (post_name LIKE '". $keyword ."') 
                GROUP BY post_name 
                ORDER BY value ASC
                LIMIT 15";
            $query = $this->db->query($sql);
            $result_array = $query->result_array();
            return $result_array;
    }

    function get_freelancer_apply_search_new_result($userid = "",$category_id = "",$skill_id = "",$worktype = "",$period_filter = "",$exp_fil = "",$page = "",$limit = '5',$fa_keyword = "",$fa_location = "")
    {
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;

        $sql = "";

        if($category_id != "")
        {
            $sql .= "post_field_req IN (".$category_id.") OR ";
        }

        if($skill_id != "")
        {
            $skill_id = str_replace(",", "|", $skill_id);
            $sql .= "fp.post_skill REGEXP '[[:<:]](".$skill_id.")[[:>:]]' OR ";
        }
        if($worktype != "")
        {
            $sql_wt = "";
            foreach (explode(",", $worktype) as $key => $value) {
                if($value == 1)
                    $sql_wt .= "(fp.post_rating_type = 1) OR ";
                if($value == 2)
                    $sql_wt .= "(fp.post_rating_type = 2) OR ";
            }
            $sql .= "(".trim($sql_wt, ' OR ').") OR ";
        }
        if($period_filter != "")
        {
            $sql_period = "";
            foreach (explode(",", $period_filter) as $key => $value) {
                if($value == 1)
                    $sql_period .= "(DATEDIFF(NOW(),fp.created_date) = 0) OR ";
                if($value == 2)
                    $sql_period .= "(DATEDIFF(NOW(),fp.created_date) >= 0 AND DATEDIFF(NOW(),fp.created_date) <=7) OR ";
                if($value == 3)
                    $sql_period .= "(DATEDIFF(NOW(),fp.created_date) >= 0 AND DATEDIFF(NOW(),fp.created_date) <=15) OR ";
                if($value == 4)
                    $sql_period .= "(DATEDIFF(NOW(),fp.created_date) >= 0 AND DATEDIFF(NOW(),fp.created_date) <=45) OR ";                
                if($value == 5)
                    $sql_period .= "(DATEDIFF(NOW(),fp.created_date) >= 45) OR ";
            }
            $sql .= "(".trim($sql_period, ' OR ').") OR ";
        }
        if($exp_fil != "")
        {
            $sql_exp = "";
            foreach (explode(",", $exp_fil) as $key => $value) {
                if($value == 1)
                    $sql_exp .= "(fp.post_exp_year >= 0 AND fp.post_exp_year <=1) OR ";
                if($value == 2)
                    $sql_exp .= "(fp.post_exp_year >= 1 AND fp.post_exp_year <=2) OR ";
                if($value == 3)
                    $sql_exp .= "(fp.post_exp_year >= 2 AND fp.post_exp_year <=3) OR ";
                if($value == 4)
                    $sql_exp .= "(fp.post_exp_year >= 3 AND fp.post_exp_year <=4) OR ";
                if($value == 5)
                    $sql_exp .= "(fp.post_exp_year >= 4 AND fp.post_exp_year <=5) OR ";
                if($value == 6)
                    $sql_exp .= "(fp.post_exp_year >= 5) OR ";
            }
            $sql .= "(".trim($sql_exp, ' OR ').") OR ";
        }

        $sql_skill = "";$sql_pn = "";$sql_it = "";        
        foreach (explode(",", $fa_keyword) as $key => $value) {
            if($value != "")
            {
                $sql_skill .= "skill LIKE '%".$value."%' OR ";
                $sql_pn .= "post_name LIKE '%".$value."%' OR ";
                $sql_it .= "category_name LIKE '%".$value."%' OR ";
            }
        }
        $sql_city = "";$sql_state = "";$sql_country = "";
        foreach (explode(",", $fa_location) as $key => $value) {
            if($value != "")
            {                
                $sql_city .= "ct.city_name LIKE '".$value."%' OR ";
                $sql_state .= "st.state_name LIKE '".$value."%' OR ";
                $sql_country .= "cr.country_name LIKE '".$value."%' OR ";            
            }
        }

        $select_data = "post_id,post_name,(SELECT  Count(uv.invite_id) As invitecount FROM ailee_user_invite as uv WHERE   (uv.post_id = fp.post_id) ) As ShortListedCount,(SELECT  Count(afa.app_id) As invitecount FROM ailee_freelancer_apply as afa WHERE (afa.post_id = fp.post_id) ) As AppliedCount,fp.created_date,post_rate,post_rating_type,currency_name as post_currency,ct.city_name as city,cr.country_name as country,post_description,post_field_req,fp.user_id,DATEDIFF(fp.post_last_date,NOW()) as day_remain,fp.post_slug";
        $this->db->select($select_data)->from('freelancer_post fp');
        $this->db->join('freelancer_hire_reg fhr', 'fhr.user_id = fp.user_id', 'left');
        $this->db->join('job_title jt', 'jt.title_id = fp.post_name', 'left');
        $this->db->join('currency c', 'c.currency_id = fp.post_currency', 'left');
        $this->db->join('cities ct', 'ct.city_id = fhr.city', 'left');
        $this->db->join('states st', 'st.state_id = fhr.state', 'left');
        $this->db->join('countries cr', 'cr.country_id = fhr.country', 'left');

        // $this->db->where('FIND_IN_SET(`s`.`skill_id`, `fp`.`post_skill`)');

        $sql_ser = "";
        if($fa_keyword != "")
        {
            $sql_ser .= "(fp.post_skill REGEXP concat('[[:<:]](',(SELECT REPLACE(group_concat(skill_id), ',', '|') FROM ailee_skill WHERE status = 1 AND type = 1 AND (".trim($sql_skill, ' OR ').")), ')[[:>:]]')
                OR
                (".trim($sql_pn, ' OR ').")
                OR
                fp.post_field_req REGEXP concat('[[:<:]](',(SELECT REPLACE(group_concat(category_id), ',', '|') FROM ailee_category WHERE status = '1' AND is_delete = '0' AND is_other = '0' AND (".trim($sql_it, ' OR ').") ), ')[[:>:]]') )";        
        }
        if($fa_location != "")
        {
            if($sql_ser != "")
            {
                $sql_ser .= " AND ";
            }
            $sql_ser .= "(
                (".trim($sql_city, ' OR ').") OR
                (".trim($sql_state, ' OR ').") OR
                (".trim($sql_country, ' OR ').")
            )";
        }
        if($sql_ser != "")
        {
            $this->db->where($sql_ser,false,false);
        }
        if($sql != "")
        {            
            $sql = "(".trim($sql, ' OR ').")";
            $this->db->where($sql,false,false);
        }
        $this->db->where(array('fp.is_delete' => '0', 'fp.status' => '1'));
        // $this->db->group_by('fp.post_skill,fp.post_id');
        $this->db->order_by('fp.post_id','desc');
        if($limit != "")
        {
            $this->db->limit($limit,$start);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();exit;

        
        $result_array = $query->result_array();
        foreach ($result_array as $key => $value) {
            $firstname = $this->db->select('fullname')->get_where('freelancer_hire_reg', array('user_id' => $value['user_id']))->row()->fullname;
            $result_array[$key]['fullname'] = $firstname;

            $category_name = $this->db->select('category_name')->get_where('category', array('category_id' => $value['post_field_req']))->row()->category_name;
            $result_array[$key]['industry_name'] = $category_name;

            $contition_array = array('post_id' => $value['post_id'], 'job_delete' => '0', 'user_id' => $userid);
            $freelancerapply1 = $this->data['freelancerapply'] = $this->common->select_data_by_condition('freelancer_apply', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            if(isset($freelancerapply1) && !empty($freelancerapply1))
                $result_array[$key]['apply_post'] = 1;
            else
                $result_array[$key]['apply_post'] = 0;

            $contition_array = array('user_id' => $userid, 'job_save' => '2', 'post_id ' => $value['post_id'], 'job_delete' => '1');
            $jobsave = $this->common->select_data_by_condition('freelancer_apply', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if(isset($jobsave) && !empty($jobsave))
                $result_array[$key]['saved_post'] = 1;
            else
                $result_array[$key]['saved_post'] = 0;

            $result_array[$key]['post_skill'] = $this->get_skill_name_from_post_id($value['post_id']);
        }
        
        //return $result_array;
        $retur_arr = array();
        $retur_arr['fa_projects'] = $result_array;
        $retur_arr['total_record'] = $this->get_freelancer_apply_search_new_result_tot_rec($userid,$category_id,$skill_id,$worktype,$period_filter,$exp_fil,$fa_keyword,$fa_location);
        return $retur_arr;
    }

    function get_freelancer_apply_search_new_result_tot_rec($userid = "",$category_id = "",$skill_id = "",$worktype = "",$period_filter = "",$exp_fil = "",$fa_keyword = "",$fa_location = "")
    {
        $sql = "";

        if($category_id != "")
        {
            $sql .= "post_field_req IN (".$category_id.") OR ";
        }

        if($skill_id != "")
        {
            $skill_id = str_replace(",", "|", $skill_id);
            $sql .= "fp.post_skill REGEXP '[[:<:]](".$skill_id.")[[:>:]]' OR ";
        }
        if($worktype != "")
        {
            $sql_wt = "";
            foreach (explode(",", $worktype) as $key => $value) {
                if($value == 1)
                    $sql_wt .= "(fp.post_rating_type = 1) OR ";
                if($value == 2)
                    $sql_wt .= "(fp.post_rating_type = 2) OR ";
            }
            $sql .= "(".trim($sql_wt, ' OR ').") OR ";
        }
        if($period_filter != "")
        {
            $sql_period = "";
            foreach (explode(",", $period_filter) as $key => $value) {
                if($value == 1)
                    $sql_period .= "(DATEDIFF(NOW(),fp.created_date) = 0) OR ";
                if($value == 2)
                    $sql_period .= "(DATEDIFF(NOW(),fp.created_date) >= 0 AND DATEDIFF(NOW(),fp.created_date) <=7) OR ";
                if($value == 3)
                    $sql_period .= "(DATEDIFF(NOW(),fp.created_date) >= 0 AND DATEDIFF(NOW(),fp.created_date) <=15) OR ";
                if($value == 4)
                    $sql_period .= "(DATEDIFF(NOW(),fp.created_date) >= 0 AND DATEDIFF(NOW(),fp.created_date) <=45) OR ";                
                if($value == 5)
                    $sql_period .= "(DATEDIFF(NOW(),fp.created_date) >= 45) OR ";
            }
            $sql .= "(".trim($sql_period, ' OR ').") OR ";
        }
        if($exp_fil != "")
        {
            $sql_exp = "";
            foreach (explode(",", $exp_fil) as $key => $value) {
                if($value == 1)
                    $sql_exp .= "(fp.post_exp_year >= 0 AND fp.post_exp_year <=1) OR ";
                if($value == 2)
                    $sql_exp .= "(fp.post_exp_year >= 1 AND fp.post_exp_year <=2) OR ";
                if($value == 3)
                    $sql_exp .= "(fp.post_exp_year >= 2 AND fp.post_exp_year <=3) OR ";
                if($value == 4)
                    $sql_exp .= "(fp.post_exp_year >= 3 AND fp.post_exp_year <=4) OR ";
                if($value == 5)
                    $sql_exp .= "(fp.post_exp_year >= 4 AND fp.post_exp_year <=5) OR ";
                if($value == 6)
                    $sql_exp .= "(fp.post_exp_year >= 5) OR ";
            }
            $sql .= "(".trim($sql_exp, ' OR ').") OR ";
        }

        $sql_skill = "";$sql_pn = "";$sql_it = "";        
        foreach (explode(",", $fa_keyword) as $key => $value) {
            if($value != "")
            {
                $sql_skill .= "skill LIKE '%".$value."%' OR ";
                $sql_pn .= "post_name LIKE '%".$value."%' OR ";
                $sql_it .= "category_name LIKE '%".$value."%' OR ";
            }
        }
        $sql_city = "";$sql_state = "";$sql_country = "";
        foreach (explode(",", $fa_location) as $key => $value) {
            if($value != "")
            {                
                $sql_city .= "ct.city_name LIKE '".$value."%' OR ";
                $sql_state .= "st.state_name LIKE '".$value."%' OR ";
                $sql_country .= "cr.country_name LIKE '".$value."%' OR ";            
            }
        }

        $select_data = "post_id,post_name,(SELECT  Count(uv.invite_id) As invitecount FROM ailee_user_invite as uv WHERE   (uv.post_id = fp.post_id) ) As ShortListedCount,(SELECT  Count(afa.app_id) As invitecount FROM ailee_freelancer_apply as afa WHERE (afa.post_id = fp.post_id) ) As AppliedCount,fp.created_date,post_rate,post_rating_type,currency_name as post_currency,ct.city_name as city,cr.country_name as country,post_description,post_field_req,fp.user_id,DATEDIFF(fp.post_last_date,NOW()) as day_remain,fp.post_slug";
        $this->db->select($select_data)->from('freelancer_post fp');
        $this->db->join('freelancer_hire_reg fhr', 'fhr.user_id = fp.user_id', 'left');
        $this->db->join('job_title jt', 'jt.title_id = fp.post_name', 'left');
        $this->db->join('currency c', 'c.currency_id = fp.post_currency', 'left');
        $this->db->join('cities ct', 'ct.city_id = fhr.city', 'left');
        $this->db->join('states st', 'st.state_id = fhr.state', 'left');
        $this->db->join('countries cr', 'cr.country_id = fhr.country', 'left');

        // $this->db->where('FIND_IN_SET(`s`.`skill_id`, `fp`.`post_skill`)');

        $sql_ser = "";
        if($fa_keyword != "")
        {
            $sql_ser .= "(fp.post_skill REGEXP concat('[[:<:]](',(SELECT REPLACE(group_concat(skill_id), ',', '|') FROM ailee_skill WHERE status = 1 AND type = 1 AND (".trim($sql_skill, ' OR ').")), ')[[:>:]]')
                OR
                (".trim($sql_pn, ' OR ').")
                OR
                fp.post_field_req REGEXP concat('[[:<:]](',(SELECT REPLACE(group_concat(category_id), ',', '|') FROM ailee_category WHERE status = '1' AND is_other = '0' AND is_delete = '0' AND (".trim($sql_it, ' OR ').") ), ')[[:>:]]') )";        
        }
        if($fa_location != "")
        {
            if($sql_ser != "")
            {
                $sql_ser .= " AND ";
            }
            $sql_ser .= "(
                (".trim($sql_city, ' OR ').") OR
                (".trim($sql_state, ' OR ').") OR
                (".trim($sql_country, ' OR ').")
            )";
        }
        if($sql_ser != "")
        {
            $this->db->where($sql_ser,false,false);
        }
        if($sql != "")
        {            
            $sql = "(".trim($sql, ' OR ').")";
            $this->db->where($sql,false,false);
        }
        $this->db->where(array('fp.is_delete' => '0', 'fp.status' => '1'));
        // $this->db->group_by('fp.post_skill,fp.post_id');
        $this->db->order_by('fp.post_id','desc');
        
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        $result_array = $query->result_array();
        return count($result_array);        
    }

    function recommended_freelance_work($userid = "",$category_id = "",$skill_id = "",$worktype = "",$period_filter = "",$exp_fil = "",$page = "",$limit = '5')
    {
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;

        $sql = "";        
        if($category_id != "")
        {
            $sql .= "post_field_req IN (".$category_id.") OR ";
        }        
        if($skill_id != "")
        {
            $skill_id = str_replace(",", "|", $skill_id);
            $sql .= "fp.post_skill REGEXP '[[:<:]](".$skill_id.")[[:>:]]' OR ";
        }
        if($worktype != "")
        {
            $sql_wt = "";
            foreach (explode(",", $worktype) as $key => $value) {
                if($value == 1)
                    $sql_wt .= "(fp.post_rating_type = 1) OR ";
                if($value == 2)
                    $sql_wt .= "(fp.post_rating_type = 2) OR ";
            }
            $sql .= "(".trim($sql_wt, ' OR ').") OR ";
        }
        if($period_filter != "")
        {
            $sql_period = "";
            foreach (explode(",", $period_filter) as $key => $value) {
                if($value == 1)
                    $sql_period .= "(DATEDIFF(NOW(),fp.created_date) = 0) OR ";
                if($value == 2)
                    $sql_period .= "(DATEDIFF(NOW(),fp.created_date) >= 0 AND DATEDIFF(NOW(),fp.created_date) <=7) OR ";
                if($value == 3)
                    $sql_period .= "(DATEDIFF(NOW(),fp.created_date) >= 0 AND DATEDIFF(NOW(),fp.created_date) <=15) OR ";
                if($value == 4)
                    $sql_period .= "(DATEDIFF(NOW(),fp.created_date) >= 0 AND DATEDIFF(NOW(),fp.created_date) <=45) OR ";                
                if($value == 5)
                    $sql_period .= "(DATEDIFF(NOW(),fp.created_date) >= 45) OR ";
            }
            $sql .= "(".trim($sql_period, ' OR ').") OR ";
        }
        if($exp_fil != "")
        {
            $sql_exp = "";
            foreach (explode(",", $exp_fil) as $key => $value) {
                if($value == 1)
                    $sql_exp .= "(fp.post_exp_year >= 0 AND fp.post_exp_year <=1) OR ";
                if($value == 2)
                    $sql_exp .= "(fp.post_exp_year >= 1 AND fp.post_exp_year <=2) OR ";
                if($value == 3)
                    $sql_exp .= "(fp.post_exp_year >= 2 AND fp.post_exp_year <=3) OR ";
                if($value == 4)
                    $sql_exp .= "(fp.post_exp_year >= 3 AND fp.post_exp_year <=4) OR ";
                if($value == 5)
                    $sql_exp .= "(fp.post_exp_year >= 4 AND fp.post_exp_year <=5) OR ";
                if($value == 6)
                    $sql_exp .= "(fp.post_exp_year >= 5) OR ";
            }
            $sql .= "(".trim($sql_exp, ' OR ').") OR ";
        }

        $select_data = "post_id,post_name,(SELECT  Count(uv.invite_id) As invitecount FROM ailee_user_invite as uv WHERE   (uv.post_id = fp.post_id) ) As ShortListedCount,(SELECT  Count(afa.app_id) As invitecount FROM ailee_freelancer_apply as afa WHERE (afa.post_id = fp.post_id) ) As AppliedCount,fp.created_date,post_rate,post_rating_type,currency_name as post_currency,ct.city_name as city,cr.country_name as country,post_description,post_field_req,fp.user_id,DATEDIFF(fp.post_last_date,NOW()) as day_remain,fp.post_slug";
        $this->db->select($select_data)->from('freelancer_post fp,ailee_freelancer_post_reg fpr');
        $this->db->join('freelancer_hire_reg fhr', 'fhr.user_id = fp.user_id', 'left');
        $this->db->join('job_title jt', 'jt.title_id = fp.post_name', 'left');
        $this->db->join('currency c', 'c.currency_id = fp.post_currency', 'left');
        $this->db->join('cities ct', 'ct.city_id = fhr.city', 'left');
        $this->db->join('countries cr', 'cr.country_id = fhr.country', 'left');
        // $this->db->where('FIND_IN_SET(`s`.`skill_id`, `fp`.`post_skill`)');
        $this->db->where('fp.post_field_req = fpr.freelancer_post_field');
        if($sql != "")
        {            
            $sql = "(".trim($sql, ' OR ').")";
            $this->db->where($sql,false,false);
        }
        $this->db->where(array('fp.is_delete' => '0', 'fp.status' => '1','fpr.user_id' =>$userid,'fp.user_id != '=>$userid));
        // $this->db->group_by('fp.post_skill,fp.post_id');
        $this->db->order_by('fp.post_id','desc');
        if($limit != "")
        {
            $this->db->limit($limit,$start);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        $result_array = $query->result_array();
        foreach ($result_array as $key => $value) {
            $firstname = $this->db->select('fullname')->get_where('freelancer_hire_reg', array('user_id' => $value['user_id']))->row()->fullname;
            $result_array[$key]['fullname'] = $firstname;

            $category_name = $this->db->select('category_name')->get_where('category', array('category_id' => $value['post_field_req']))->row()->category_name;
            $result_array[$key]['industry_name'] = $category_name;

            $contition_array = array('post_id' => $value['post_id'], 'job_delete' => '0', 'user_id' => $userid);
            $freelancerapply1 = $this->data['freelancerapply'] = $this->common->select_data_by_condition('freelancer_apply', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            if(isset($freelancerapply1) && !empty($freelancerapply1))
                $result_array[$key]['apply_post'] = 1;
            else
                $result_array[$key]['apply_post'] = 0;

            $contition_array = array('user_id' => $userid, 'job_save' => '2', 'post_id ' => $value['post_id'], 'job_delete' => '1');
            $jobsave = $this->common->select_data_by_condition('freelancer_apply', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if(isset($jobsave) && !empty($jobsave))
                $result_array[$key]['saved_post'] = 1;
            else
                $result_array[$key]['saved_post'] = 0;

            $result_array[$key]['post_skill'] = $this->get_skill_name_from_post_id($value['post_id']);
        }
        
        //return $result_array;
        $retur_arr = array();
        $retur_arr['fa_projects'] = $result_array;
        $retur_arr['total_record'] = $this->recommended_freelance_work_total_rec($userid,$category_id,$skill_id,$worktype,$period_filter,$exp_fil);        
        return $retur_arr;
    }

    function recommended_freelance_work_total_rec($userid = "",$category_id = "",$skill_id = "",$worktype = "",$period_filter = "",$exp_fil = "")
    {
        $sql = "";        
        if($category_id != "")
        {
            $sql .= "post_field_req IN (".$category_id.") OR ";
        }        
        if($skill_id != "")
        {
            $skill_id = str_replace(",", "|", $skill_id);
            $sql .= "fp.post_skill REGEXP '[[:<:]](".$skill_id.")[[:>:]]' OR ";
        }
        if($worktype != "")
        {
            $sql_wt = "";
            foreach (explode(",", $worktype) as $key => $value) {
                if($value == 1)
                    $sql_wt .= "(fp.post_rating_type = 1) OR ";
                if($value == 2)
                    $sql_wt .= "(fp.post_rating_type = 2) OR ";
            }
            $sql .= "(".trim($sql_wt, ' OR ').") OR ";
        }
        if($period_filter != "")
        {
            $sql_period = "";
            foreach (explode(",", $period_filter) as $key => $value) {
                if($value == 1)
                    $sql_period .= "(DATEDIFF(NOW(),fp.created_date) = 0) OR ";
                if($value == 2)
                    $sql_period .= "(DATEDIFF(NOW(),fp.created_date) >= 0 AND DATEDIFF(NOW(),fp.created_date) <=7) OR ";
                if($value == 3)
                    $sql_period .= "(DATEDIFF(NOW(),fp.created_date) >= 0 AND DATEDIFF(NOW(),fp.created_date) <=15) OR ";
                if($value == 4)
                    $sql_period .= "(DATEDIFF(NOW(),fp.created_date) >= 0 AND DATEDIFF(NOW(),fp.created_date) <=45) OR ";                
                if($value == 5)
                    $sql_period .= "(DATEDIFF(NOW(),fp.created_date) >= 45) OR ";
            }
            $sql .= "(".trim($sql_period, ' OR ').") OR ";
        }
        if($exp_fil != "")
        {
            $sql_exp = "";
            foreach (explode(",", $exp_fil) as $key => $value) {
                if($value == 1)
                    $sql_exp .= "(fp.post_exp_year >= 0 AND fp.post_exp_year <=1) OR ";
                if($value == 2)
                    $sql_exp .= "(fp.post_exp_year >= 1 AND fp.post_exp_year <=2) OR ";
                if($value == 3)
                    $sql_exp .= "(fp.post_exp_year >= 2 AND fp.post_exp_year <=3) OR ";
                if($value == 4)
                    $sql_exp .= "(fp.post_exp_year >= 3 AND fp.post_exp_year <=4) OR ";
                if($value == 5)
                    $sql_exp .= "(fp.post_exp_year >= 4 AND fp.post_exp_year <=5) OR ";
                if($value == 6)
                    $sql_exp .= "(fp.post_exp_year >= 5) OR ";
            }
            $sql .= "(".trim($sql_exp, ' OR ').") OR ";
        }

        $select_data = "post_id,post_name,(SELECT  Count(uv.invite_id) As invitecount FROM ailee_user_invite as uv WHERE   (uv.post_id = fp.post_id) ) As ShortListedCount,(SELECT  Count(afa.app_id) As invitecount FROM ailee_freelancer_apply as afa WHERE (afa.post_id = fp.post_id) ) As AppliedCount,fp.created_date,post_rate,post_rating_type,currency_name as post_currency,ct.city_name as city,cr.country_name as country,post_description,post_field_req,fp.user_id,DATEDIFF(fp.post_last_date,NOW()) as day_remain,fp.post_slug";
        $this->db->select($select_data)->from('freelancer_post fp,ailee_freelancer_post_reg fpr');
        $this->db->join('freelancer_hire_reg fhr', 'fhr.user_id = fp.user_id', 'left');
        $this->db->join('job_title jt', 'jt.title_id = fp.post_name', 'left');
        $this->db->join('currency c', 'c.currency_id = fp.post_currency', 'left');
        $this->db->join('cities ct', 'ct.city_id = fhr.city', 'left');
        $this->db->join('countries cr', 'cr.country_id = fhr.country', 'left');
        // $this->db->where('FIND_IN_SET(`s`.`skill_id`, `fp`.`post_skill`)');
        $this->db->where('fp.post_field_req = fpr.freelancer_post_field');
        if($sql != "")
        {            
            $sql = "(".trim($sql, ' OR ').")";
            $this->db->where($sql,false,false);
        }
        $this->db->where(array('fp.is_delete' => '0', 'fp.status' => '1','fpr.user_id' =>$userid,'fp.user_id != '=>$userid));
        // $this->db->group_by('fp.post_skill,fp.post_id');
        $this->db->order_by('fp.post_id','desc');
        if($limit != "")
        {
            $this->db->limit($limit,$start);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        $result_array = $query->result_array();
        return count($result_array);
    }

    public function get_skill_name_from_post_id($post_id)
    {
        $sql = "SELECT GROUP_CONCAT(DISTINCT(s.skill)) as post_skill FROM (ailee_freelancer_post fp, ailee_skill s) WHERE FIND_IN_SET(s.skill_id, fp.post_skill) AND fp.is_delete = '0' AND fp.status = '1' AND fp.post_id = $post_id GROUP BY fp.post_skill ORDER BY fp.post_id";
        $query = $this->db->query($sql);
        $result_array = $query->result_array();
        return $result_array['post_skill'];
    }

}
