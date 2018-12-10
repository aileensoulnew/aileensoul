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
        /*foreach ($result_array as $k => $v) {
            if(!file_exists(FA_CATEGORY_IMG_PATH."/".$result_array[$k]['category_image']))
            {
                $result_array[$k]['category_image'] = "category_default.png";
            }
        }*/
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
        /*foreach ($fa_category as $k => $v) {
            if(!file_exists(FA_CATEGORY_IMG_PATH."/".$fa_category[$k]['category_image']))
            {
                $fa_category[$k]['category_image'] = "category_default.png";
            }
        }*/
        
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
        /*foreach ($faSkills as $k => $v) {
            if(!file_exists(SKILLS_IMG_PATH."/".$faSkills[$k]['skill_image']))
            {
                $faSkills[$k]['skill_image'] = "skills_default.png";
            }
        }*/
        
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
        if(isset($category_id) && !empty($category_id))
        {
            $sql .= "post_field_req IN (".implode(",",$category_id).") OR ";
        }        
        if(isset($skill_id) && !empty($skill_id))
        {
            $skill_id = implode("|",$skill_id);
            $sql .= "fp.post_skill REGEXP '[[:<:]](".$skill_id.")[[:>:]]' OR ";
        }
        if(isset($worktype) && !empty($worktype))
        {
            $sql_wt = "";
            foreach ($worktype as $key => $value) {
                if($value == 1)
                    $sql_wt .= "(fp.post_rating_type = 1) OR ";
                if($value == 2)
                    $sql_wt .= "(fp.post_rating_type = 2) OR ";
            }
            $sql .= "(".trim($sql_wt, ' OR ').") OR ";
        }
        if(isset($period_filter) && !empty($period_filter))
        {
            $sql_period = "";
            foreach ($period_filter as $key => $value) {
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
        if(isset($exp_fil) && !empty($exp_fil))
        {
            $sql_exp = "";
            foreach ($exp_fil as $key => $value) {
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
        if(isset($category_id) && !empty($category_id))
        {
            $sql .= "post_field_req IN (".implode(",", $category_id).") OR ";
        }        
        if(isset($skill_id) && !empty($skill_id))
        {
            $skill_id = implode("|", $skill_id);
            $sql .= "fp.post_skill REGEXP '[[:<:]](".$skill_id.")[[:>:]]' OR ";
        }
        if(isset($worktype) && !empty($worktype))
        {
            $sql_wt = "";
            foreach ($worktype as $key => $value) {
                if($value == 1)
                    $sql_wt .= "(fp.post_rating_type = 1) OR ";
                if($value == 2)
                    $sql_wt .= "(fp.post_rating_type = 2) OR ";
            }
            $sql .= "(".trim($sql_wt, ' OR ').") OR ";
        }
        if(isset($period_filter) && !empty($period_filter))
        {
            $sql_period = "";
            foreach ($period_filter as $key => $value) {
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
        if(isset($exp_fil) && !empty($exp_fil))
        {
            $sql_exp = "";
            foreach ($exp_fil as $key => $value) {
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
            $sql .= "fp.post_field_req IN (".$category_id.") OR ";
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
                $sql_skill .= "LOWER(fp.post_skill_txt) LIKE '%".strtolower($value)."%' OR ";
                $sql_pn .= "LOWER(fp.post_name) LIKE '%".strtolower($value)."%' OR ";
                $sql_it .= "LOWER(fp.category_name) LIKE '%".strtolower($value)."%' OR ";
            }
        }
        $sql_city = "";$sql_state = "";$sql_country = "";
        foreach (explode(",", $fa_location) as $key => $value) {
            if($value != "")
            {                
                $sql_city .= "LOWER(fp.city_name) LIKE '".strtolower($value)."%' OR ";
                $sql_state .= "LOWER(fp.state_name) LIKE '".strtolower($value)."%' OR ";
                $sql_country .= "LOWER(fp.country_name) LIKE '".strtolower($value)."%' OR ";            
            }
        }

        $select_data = "fp.post_id,fp.post_name,(SELECT  Count(s.to_id) FROM ailee_save as s WHERE (s.post_id = fp.post_id) AND s.status = '2' AND s.save_type = '2' ) As ShortListedCount,(SELECT  Count(afa.app_id) FROM ailee_freelancer_apply as afa WHERE (afa.post_id = fp.post_id) AND afa.job_delete = '0' AND afa.job_save = '3' ) As AppliedCount,fp.created_date,fp.post_rate,fp.post_rating_type,fp.currency_name as post_currency,fp.city_name as city,fp.country_name as country,fp.post_description,fp.post_field_req,fp.user_id,DATEDIFF(fp.post_last_date,NOW()) as day_remain,fp.post_slug";
        $this->db->select($select_data)->from('freelancer_post_search_tmp fp');

        $sql_ser = "";
        if($fa_keyword != "")
        {
            $sql_ser .= "((".trim($sql_skill, ' OR ').")
                        OR
                        (".trim($sql_pn, ' OR ').")
                        OR
                        (".trim($sql_it, ' OR ')."))";
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
            $sql_ser = "(".trim($sql_ser).")";
            $this->db->where($sql_ser,false,false);
        }
        if($sql != "")
        {            
            $sql = "(".trim($sql, ' OR ').")";
            $this->db->where($sql,false,false);
        }
        $this->db->where(array('fp.is_delete' => '0', 'fp.status' => '1','fp.user_id != '=>$userid));
        // $this->db->group_by('fp.post_skill,fp.post_id');
        $this->db->order_by('fp.post_id','desc');
        if($limit != "")
        {
            $this->db->limit($limit,$start);
        }
        $query = $this->db->get();
        // echo $this->db->last_query();exit;
        $result_array = $query->result_array();
        foreach ($result_array as $key => $value) {
            $firstname = $this->db->select('concat(fullname," ",username) as fullname')->get_where('freelancer_hire_reg', array('user_id' => $value['user_id']))->row()->fullname;
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
                $sql_skill .= "LOWER(fp.post_skill_txt) LIKE '%".strtolower($value)."%' OR ";
                $sql_pn .= "LOWER(fp.post_name) LIKE '%".strtolower($value)."%' OR ";
                $sql_it .= "LOWER(fp.category_name) LIKE '%".strtolower($value)."%' OR ";
            }
        }
        $sql_city = "";$sql_state = "";$sql_country = "";
        foreach (explode(",", $fa_location) as $key => $value) {
            if($value != "")
            {                
                $sql_city .= "LOWER(fp.city_name) LIKE '".strtolower($value)."%' OR ";
                $sql_state .= "LOWER(fp.state_name) LIKE '".strtolower($value)."%' OR ";
                $sql_country .= "LOWER(fp.country_name) LIKE '".strtolower($value)."%' OR ";            
            }
        }

        $select_data = "count(*) as total_record";
        $this->db->select($select_data)->from('freelancer_post_search_tmp fp');

        $sql_ser = "";
        if($fa_keyword != "")
        {
            $sql_ser .= "((".trim($sql_skill, ' OR ').")
                        OR
                        (".trim($sql_pn, ' OR ').")
                        OR
                        (".trim($sql_it, ' OR ')."))";
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
            $sql_ser = "(".trim($sql_ser).")";
            $this->db->where($sql_ser,false,false);
        }
        if($sql != "")
        {            
            $sql = "(".trim($sql, ' OR ').")";
            $this->db->where($sql,false,false);
        }
        $this->db->where(array('fp.is_delete' => '0', 'fp.status' => '1','fp.user_id != '=>$userid));
        // $this->db->group_by('fp.post_skill,fp.post_id');
        $this->db->order_by('fp.post_id','desc');
        
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        $result_array = $query->row_array();
        return $result_array['total_record'];        
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

        $select_data = "post_id,post_name,,(SELECT  Count(s.to_id) FROM ailee_save as s WHERE (s.post_id = fp.post_id) AND s.status = '2' AND s.save_type = '2' ) As ShortListedCount,(SELECT  Count(afa.app_id) FROM ailee_freelancer_apply as afa WHERE (afa.post_id = fp.post_id) AND afa.job_delete = '0' AND afa.job_save = '3' ) As AppliedCount,fp.created_date,post_rate,post_rating_type,currency_name as post_currency,ct.city_name as city,cr.country_name as country,post_description,post_field_req,fp.user_id,DATEDIFF(fp.post_last_date,NOW()) as day_remain,fp.post_slug";
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
            $firstname = $this->db->select('concat(fullname," ",username) as fullname')->get_where('freelancer_hire_reg', array('user_id' => $value['user_id']))->row()->fullname;            
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
        $result_array = $query->row_array();
        return $result_array['post_skill'];
    }

    function free_job_related_blog_list() {
        $sql = "SELECT * FROM ailee_blog
                WHERE status='publish' AND
                blog_slug = 'how-to-kick-start-your-freelance-career-a-complete-beginners-guide' 
                OR blog_slug = 'take-your-freelance-career-to-greater-heights-with-these-popular-platforms' 
                OR blog_slug = 'it-s-raining-dollars-online-know-how-to-earn-online'";
        $query = $this->db->query($sql);
        $result_array = $query->result_array();   
        return $result_array;
    }

    function getSkillsNames($skills)
    {
        $sql = "SELECT GROUP_CONCAT(DISTINCT(skill)) as skill_name FROM ailee_skill WHERE skill_id IN (".$skills.")";
        $query = $this->db->query($sql);
        $result_array = $query->row_array();
        return $result_array['skill_name'];
    }

    public function getFreelancerApplyPostDetail($post_id) {
        $select_data = "fp.post_id,fp.post_name,fp.post_slug,fp.user_id,c.category_name";
        $this->db->select($select_data)->from('freelancer_post fp');
        $this->db->join('category c', 'c.category_id = fp.post_field_req', 'left');
        $this->db->where('fp.post_id', $post_id);
        $this->db->where(array('fp.is_delete' => '0', 'fp.status' => '1'));
        
        $query = $this->db->get();
        $result_array = $query->first_row();
        return $result_array;
    }

    public function freelancer_apply_create_search_table()
    {
        set_time_limit(0);
        ini_set("memory_limit","512M");
        echo "<pre>";
        $sql = "SELECT * from ailee_freelancer_post WHERE is_delete = '0' AND status = '1'";
        $query = $this->db->query($sql);
        $result_array = $query->result_array();
        // print_r($result_array);exit;
        foreach ($result_array as $key => $value) {

            if(trim($value['post_field_req']) != "")
            {
                $field_name = $this->db->get_where('category', array('category_id' => $value['post_field_req']))->row()->category_name;
                $value['category_name'] = trim($field_name);
            }            

            if($value['post_skill'] != "")
            {
                $skill_name = "";
                foreach (explode(',',$value['post_skill']) as $skk => $skv) {
                    if($skv != "" && $skv != "26")
                    {
                        $s_name = $this->db->get_where('skill', array('skill_id' => $skv))->row()->skill;
                        if(trim($s_name) != "")
                        {
                            $skill_name .= $s_name.",";
                        }
                    }
                }
                $value['post_skill_txt'] = trim($skill_name,",");
            }
            
            if(trim($value['post_currency']) != "")
            {
                $currency_name = $this->db->get_where('currency', array('currency_id' => $value['post_currency'], 'status' => '1'))->row()->currency_name;

                $value['currency_name'] = trim($currency_name);
            }

            $fa_regi = $this->db->get_where('freelancer_hire_reg', array('user_id' => $value['user_id']))->row();

            if(trim($fa_regi->country) != "")
            {
                $country_name = $this->db->get_where('countries', array('country_id' => $fa_regi->country, 'status' => '1'))->row()->country_name;

                $value['country_name'] = trim($country_name);
            }

            if(trim($fa_regi->state) != "")
            {
                $state_name = $this->db->get_where('states', array('state_id' => $fa_regi->state, 'status' => '1'))->row()->state_name;

                $value['state_name'] = trim($state_name);
            }

            if(trim($fa_regi->city) != "")
            {
                $city_name = $this->db->get_where('cities', array('city_id' => $fa_regi->city, 'status' => '1'))->row()->city_name;

                $value['city_name'] = trim($city_name);
            }
            // print_r($value);
            $this->db->insert('ailee_freelancer_post_search_tmp', $value);
        }
        echo "Done";
    }

    public function get_user_education($userid)
    {
        $this->db->select("fue.id_education, fue.user_id, fue.edu_school_college, fue.edu_university, fue.edu_other_university, fue.edu_degree, fue.edu_other_degree, fue.edu_stream, fue.edu_other_stream, fue.edu_start_date, fue.edu_end_date, fue.edu_nograduate, fue.edu_file, fue.status, fue.created_date, fue.modify_date, d.degree_name, s.stream_name, u.university_name, DATE_FORMAT(CONCAT(fue.edu_start_date,'-1'),'%b %Y') as start_date_str, DATE_FORMAT(CONCAT(fue.edu_end_date,'-1'),'%b %Y') as end_date_str")->from("freelancer_user_education fue");
        $this->db->join('degree d', 'd.degree_id = fue.edu_degree', 'left');
        $this->db->join('stream s', 's.stream_id = fue.edu_stream', 'left');
        $this->db->join('university u', 'u.university_id = fue.edu_university', 'left');
        $this->db->where('fue.user_id', $userid);
        $this->db->where('fue.status', '1');
        $this->db->order_by('fue.created_date',"desc");
        $query = $this->db->get();
        $user_data_exp = $query->result_array();        
        return $user_data_exp;
    }

    public function set_user_education($userid,$edu_school_college = "",$edu_university = "",$edu_other_university = "",$edu_degree = "",$edu_stream = "",$edu_other_degree = "",$edu_other_stream = "",$edu_start_date = "",$edu_end_date = "",$edu_nograduate = "",$edu_file = "",$edit_edu = 0)
    {
        if($edit_edu == 0)
        {            
            $data = array(
                'user_id' => $userid,
                'edu_school_college' => $edu_school_college,
                'edu_university' => $edu_university,
                'edu_other_university' => $edu_other_university,
                'edu_degree' => $edu_degree,
                'edu_other_degree' => $edu_other_degree,
                'edu_stream' => $edu_stream,
                'edu_other_stream' => $edu_other_stream,
                'edu_start_date' => $edu_start_date,
                'edu_end_date' => $edu_end_date,
                'edu_nograduate' => $edu_nograduate,
                'edu_file' => $edu_file,
                'status' => '1',
                'created_date' => date('Y-m-d H:i:s', time()),
                'modify_date' => date('Y-m-d H:i:s', time()),
            );
            $insert_id = $this->common->insert_data($data, 'freelancer_user_education');
            return $insert_id;
        }
        else
        {
            $data = array(
                'edu_school_college' => $edu_school_college,
                'edu_university' => $edu_university,
                'edu_other_university' => $edu_other_university,
                'edu_degree' => $edu_degree,
                'edu_other_degree' => $edu_other_degree,
                'edu_stream' => $edu_stream,
                'edu_other_stream' => $edu_other_stream,
                'edu_start_date' => $edu_start_date,
                'edu_end_date' => $edu_end_date,
                'edu_nograduate' => $edu_nograduate,
                'edu_file' => $edu_file,
                'modify_date' => date('Y-m-d H:i:s', time()),
            );
            $this->db->where('user_id', $userid);
            $this->db->where('id_education', $edit_edu);
            $this->db->update('freelancer_user_education', $data);
            return true;
        }
    }

    public function delete_user_education($userid,$edu_id)    
    {
        $data = array(                
                'status' => "0",
                'modify_date' => date('Y-m-d H:i:s', time()),
            );
            $this->db->where('user_id', $userid);
            $this->db->where('id_education', $edu_id);
            $this->db->update('freelancer_user_education', $data);
            return true;
    }

    public function set_user_experience($userid,$exp_company_name = "",$exp_designation = "",$exp_company_website = "",$exp_field = "",$exp_other_field = "",$exp_country = "",$exp_state = "",$exp_city = "",$exp_start_date = "",$exp_end_date = "",$exp_isworking = "",$exp_desc = "",$exp_file = "",$edit_exp = 0)
    {
        if($edit_exp == 0)
        {            
            $data = array(
                'user_id' => $userid,
                'exp_company_name' => $exp_company_name,
                'exp_designation' => $exp_designation,
                'exp_company_website' => $exp_company_website,
                'exp_field' => $exp_field,
                'exp_other_field' => $exp_other_field,
                'exp_country' => $exp_country,                
                'exp_state' => $exp_state,                
                'exp_city' => $exp_city,                
                'exp_start_date' => $exp_start_date,                
                'exp_end_date' => $exp_end_date,                
                'exp_isworking' => $exp_isworking,                
                'exp_desc' => $exp_desc,                
                'exp_file' => $exp_file,                
                'status' => '1',
                'created_date' => date('Y-m-d H:i:s', time()),
                'modify_date' => date('Y-m-d H:i:s', time()),
            );
            $insert_id = $this->common->insert_data($data, 'freelancer_user_experience');
            $data1 = array(
                'exp_y' => $expy,
                'exp_m' => $expm,
                'experience' => "Experience"
            );
            $this->db->where('user_id', $userid);            
            $this->db->update('job_reg', $data1);

            return $insert_id;
        }
        else
        {
            $data = array(
                'exp_company_name' => $exp_company_name,
                'exp_designation' => $exp_designation,
                'exp_company_website' => $exp_company_website,
                'exp_field' => $exp_field,
                'exp_other_field' => $exp_other_field,
                'exp_country' => $exp_country,                
                'exp_state' => $exp_state,                
                'exp_city' => $exp_city,                
                'exp_start_date' => $exp_start_date,                
                'exp_end_date' => $exp_end_date,                
                'exp_isworking' => $exp_isworking,                
                'exp_desc' => $exp_desc,                
                'exp_file' => $exp_file,                
                'modify_date' => date('Y-m-d H:i:s', time()),
            );
            $this->db->where('user_id', $userid);
            $this->db->where('id_experience', $edit_exp);
            $this->db->update('freelancer_user_experience', $data);
            $data1 = array(
                'exp_y' => $expy,
                'exp_m' => $expm,
                'experience' => "Experience"
            );
            $this->db->where('user_id', $userid);            
            $this->db->update('job_reg', $data1);
            return true;
        }
    }

    public function delete_user_experience($userid,$exp_id)    
    {
        $data = array(                
                'status' => "0",
                'modify_date' => date('Y-m-d H:i:s', time()),
            );
            $this->db->where('user_id', $userid);
            $this->db->where('id_experience', $exp_id);
            $this->db->update('freelancer_user_experience', $data);
            return true;
    }

    public function get_user_experience($userid)
    {

        $this->db->select("fue.id_experience, fue.user_id, fue.exp_company_name, fue.exp_designation,jt.name as designation, fue.exp_company_website, fue.exp_field, fue.exp_other_field, fue.exp_country, fue.exp_state, fue.exp_city, fue.exp_start_date, fue.exp_end_date, DATE_FORMAT(CONCAT(fue.exp_start_date,'-1'),'%b %Y') as start_date_str,DATE_FORMAT(CONCAT(fue.exp_end_date,'-1'),'%b %Y') as end_date_str,fue.exp_isworking, fue.exp_desc, fue.exp_file, fue.status, fue.created_date, fue.modify_date,cr.country_name,st.state_name,ct.city_name")->from("freelancer_user_experience fue");
        $this->db->join('countries cr', 'cr.country_id = fue.exp_country', 'left');
        $this->db->join('states st', 'st.state_id = fue.exp_state', 'left');
        $this->db->join('cities ct', 'ct.city_id = fue.exp_city', 'left');
        $this->db->join('job_title jt', 'jt.title_id = fue.exp_designation', 'left');
        $this->db->where('fue.user_id', $userid);
        $this->db->where('fue.status', '1');
        // $this->db->where('FIND_IN_SET(jt.title_id, fue.exp_designation) !=', 0);
        // $this->db->group_by('fue.exp_designation,fue.id_experience');
        $this->db->order_by('fue.created_date',"desc");
        $query = $this->db->get();
        $user_data_exp = $query->result_array();        
        return $user_data_exp;
    }

    public function set_user_addicourse($userid,$addicourse_name = "",$addicourse_org = "",$addicourse_start_date = "",$addicourse_end_date = "",$addicourse_url = "",$addicourse_document = "",$edit_addicourse = 0)
    {
        if($edit_addicourse == 0)
        {            
            $data = array(
                'user_id' => $userid,
                'addicourse_name' => $addicourse_name,
                'addicourse_org' => $addicourse_org,
                'addicourse_start_date' => $addicourse_start_date,
                'addicourse_end_date' => $addicourse_end_date,
                'addicourse_url' => $addicourse_url,
                'addicourse_file' => $addicourse_document,
                'status' => '1',
                'created_date' => date('Y-m-d H:i:s', time()),
                'modify_date' => date('Y-m-d H:i:s', time()),
            );
            $insert_id = $this->common->insert_data($data, 'freelancer_user_addicourse');
            return $insert_id;
        }
        else
        {
            $data = array(
                'addicourse_name' => $addicourse_name,
                'addicourse_org' => $addicourse_org,
                'addicourse_start_date' => $addicourse_start_date,
                'addicourse_end_date' => $addicourse_end_date,
                'addicourse_url' => $addicourse_url,
                'addicourse_file' => $addicourse_document,
                'modify_date' => date('Y-m-d H:i:s', time()),
            );
            $this->db->where('user_id', $userid);
            $this->db->where('id_addicourse', $edit_addicourse);
            $this->db->update('freelancer_user_addicourse', $data);
            return true;
        }
    }

    public function delete_user_addicourse($userid,$addicourse_id)    
    {
        $data = array(                
                'status' => "0",
                'modify_date' => date('Y-m-d H:i:s', time()),
            );
            $this->db->where('user_id', $userid);
            $this->db->where('id_addicourse', $addicourse_id);
            $this->db->update('freelancer_user_addicourse', $data);
            return true;
    }

    public function get_user_addicourse($userid)
    {
        $this->db->select("fua.*,DATE_FORMAT(CONCAT(fua.addicourse_start_date,'-1'),'%b %Y') as start_date_str, DATE_FORMAT(CONCAT(fua.addicourse_end_date,'-1'),'%b %Y') as end_date_str")->from("freelancer_user_addicourse fua");
        $this->db->where('fua.user_id', $userid);
        $this->db->where('fua.status', '1');
        $this->db->order_by('fua.created_date',"desc");
        $query = $this->db->get();
        $user_data_lang = $query->result_array();        
        return $user_data_lang;
    }

    public function set_user_publication($userid,$pub_title = "",$pub_author = "",$pub_url = "",$pub_publisher = "",$pub_desc = "",$publication_date = "",$pub_document = "",$edit_publication = 0)
    {
        if($edit_publication == 0)
        {
            $data = array(
                'user_id' => $userid,
                'pub_title' => $pub_title,
                'pub_author' => $pub_author,
                'pub_url' => $pub_url,
                'pub_publisher' => $pub_publisher,
                'pub_desc' => $pub_desc,
                'pub_date' => $publication_date,
                'pub_file' => $pub_document,                
                'status' => '1',
                'created_date' => date('Y-m-d H:i:s', time()),
                'modify_date' => date('Y-m-d H:i:s', time()),
            );
            $insert_id = $this->common->insert_data($data, 'freelancer_user_publication');
            return $insert_id;
        }
        else
        {
            $data = array(
                'pub_title' => $pub_title,
                'pub_author' => $pub_author,
                'pub_url' => $pub_url,
                'pub_publisher' => $pub_publisher,
                'pub_desc' => $pub_desc,
                'pub_date' => $publication_date,
                'pub_file' => $pub_document,                   
                'modify_date' => date('Y-m-d H:i:s', time()),
            );
            $this->db->where('user_id', $userid);
            $this->db->where('id_publication', $edit_publication);
            $this->db->update('freelancer_user_publication', $data);
            return true;
        }
    }

    public function delete_user_publication($userid,$publication_id)    
    {
        $data = array(                
                'status' => "0",
                'modify_date' => date('Y-m-d H:i:s', time()),
            );
            $this->db->where('user_id', $userid);
            $this->db->where('id_publication', $publication_id);
            $this->db->update('freelancer_user_publication', $data);
            return true;
    }

    public function get_user_publication($userid)
    {
        $this->db->select("jup.*,DATE_FORMAT(jup.pub_date,'%d %b %Y') as pub_date_str")->from("freelancer_user_publication jup");
        $this->db->where('jup.user_id', $userid);
        $this->db->where('jup.status', '1');
        $this->db->order_by('jup.created_date',"desc");
        $query = $this->db->get();
        $user_data_lang = $query->result_array();        
        return $user_data_lang;
    }

    public function get_user_languages($userid)
    {
        $this->db->select("user_id,language_txt as language_name,proficiency,status")->from("freelancer_user_languages");
        $this->db->where('user_id', $userid);
        $query = $this->db->get();
        $user_data_lang = $query->result_array();        
        return $user_data_lang;
    }

    public function get_user_links($userid)
    {
        $this->db->select("*")->from("freelancer_user_links");
        $this->db->where('user_id', $userid);
        $this->db->order_by('created_date',"desc");
        $query = $this->db->get();
        $user_data_links = $query->result_array();        
        return $user_data_links;
    }

    public function get_user_social_links($userid)
    {
        $this->db->select("*")->from("freelancer_user_links");
        $this->db->where('user_id', $userid);
        $this->db->where('user_links_type != ','Personal');
        $this->db->order_by('created_date',"desc");
        $query = $this->db->get();
        $user_data_links = $query->result_array();        
        return $user_data_links;
    }

    public function get_user_personal_links($userid)
    {
        $this->db->select("*")->from("freelancer_user_links");
        $this->db->where('user_id', $userid);
        $this->db->where('user_links_type','Personal');
        $this->db->order_by('created_date',"desc");
        $query = $this->db->get();
        $user_data_links = $query->result_array();        
        return $user_data_links;
    }

    public function get_skills() {
        $this->db->select("s.skill as name")->from("skill s");
        $this->db->where("(s.type = '1' OR s.type = '5')");
        $this->db->where('s.status', '1');
        $this->db->group_by('s.skill');
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    public function get_user_skills($userid)
    {
        $this->db->select("s.skill as name")->from("freelancer_post_reg fpr, skill s");
        $this->db->where('fpr.user_id', $userid);
        $this->db->where("(s.type = '1' OR s.type = '5')");
        $this->db->where('FIND_IN_SET(s.skill_id, fpr.freelancer_post_area) !=', 0);
        // $this->db->where('FIND_IN_SET(s.skill_id, fpr.user_skills) !=', 0);
        // $this->db->group_by('ui.user_skills', 'uo.location');
        $query = $this->db->get();
        $skills_data = $query->result_array();        
        return $skills_data;
    }

    public function set_user_project($userid,$project_title = "",$project_team = "",$project_role = "",$project_skill_ids = "",$project_field = "",$project_other_field = "",$project_url = "",$project_partner_name = "",$project_start_date = "",$project_end_date = "",$project_desc = "",$project_file = "",$edit_project = 0)
    {
        if($edit_project == 0)
        {            
            $data = array(
                'user_id' => $userid,
                'project_title' => $project_title,
                'project_team' => $project_team,
                'project_role' => $project_role,
                'project_skills' => $project_skill_ids,
                'project_field' => $project_field,
                'project_other_field' => $project_other_field,                
                'project_url' => $project_url,                
                'project_partner_name' => $project_partner_name,                
                'project_start_date' => $project_start_date,                
                'project_end_date' => $project_end_date,                
                'project_desc' => $project_desc,        
                'project_file' => $project_file,                
                'status' => '1',
                'created_date' => date('Y-m-d H:i:s', time()),
                'modify_date' => date('Y-m-d H:i:s', time()),
            );
            $insert_id = $this->common->insert_data($data, 'freelancer_user_projects');
            return $insert_id;
        }
        else
        {
            $data = array(
                'project_title' => $project_title,
                'project_team' => $project_team,
                'project_role' => $project_role,
                'project_skills' => $project_skill_ids,
                'project_field' => $project_field,
                'project_other_field' => $project_other_field,                
                'project_url' => $project_url,                
                'project_partner_name' => $project_partner_name,                
                'project_start_date' => $project_start_date,                
                'project_end_date' => $project_end_date,                
                'project_desc' => $project_desc,        
                'project_file' => $project_file,
                'modify_date' => date('Y-m-d H:i:s', time()),
            );
            $this->db->where('user_id', $userid);
            $this->db->where('id_projects', $edit_project);
            $this->db->update('freelancer_user_projects', $data);
            return true;
        }
    }

    public function delete_user_project($userid,$project_id)    
    {
        $data = array(                
                'status' => "0",
                'modify_date' => date('Y-m-d H:i:s', time()),
            );
            $this->db->where('user_id', $userid);
            $this->db->where('id_projects', $project_id);
            $this->db->update('freelancer_user_projects', $data);
            return true;
    }

    public function get_user_project($userid)
    {
        $this->db->select("fup.id_projects, fup.user_id, fup.project_title, fup.project_team, fup.project_role, fup.project_skills, fup.project_field, fup.project_other_field, fup.project_url, fup.project_partner_name, fup.project_start_date, fup.project_end_date, fup.project_desc, fup.project_file, fup.status, fup.created_date, fup.modify_date, DATE_FORMAT(CONCAT(fup.project_start_date,'-1'),'%b %Y') as start_date_str, DATE_FORMAT(CONCAT(fup.project_end_date,'-1'),'%b %Y') as end_date_str,IF(fup.project_skills != '',it.industry_name,'') as project_field_txt, IF(fup.project_skills != '',GROUP_CONCAT(DISTINCT(s.skill)),'') as project_skills_txt")->from("freelancer_user_projects fup,skill s");
        $this->db->join('industry_type it', 'it.industry_id = fup.project_field', 'left');
        $sql = "IF(fup.project_skills != '', FIND_IN_SET(s.skill_id, fup.project_skills) != '0', '1=1')";
        $this->db->where($sql);
        // $this->db->where('FIND_IN_SET(s.skill_id, fup.project_skills) !=', 0);
        $this->db->where('fup.user_id', $userid);
        $this->db->where('fup.status', '1');
        $this->db->group_by('fup.project_skills,fup.id_projects');
        $this->db->order_by('fup.created_date',"desc");
        $query = $this->db->get();        
        $user_data_exp = $query->result_array();        
        return $user_data_exp;
    }

    public function get_user_prof_summary($userid)
    {
        $this->db->select("freelancer_post_skill_description")->from("freelancer_post_reg");
        $this->db->where('user_id', $userid);
        $query = $this->db->get();
        $about_user_data = $query->row_array();        
        return $about_user_data['freelancer_post_skill_description'];
    }

    public function get_user_company_overview($userid)
    {
        $this->db->select("comp_overview")->from("freelancer_post_reg");
        $this->db->where('user_id', $userid);
        $query = $this->db->get();
        $about_user_data = $query->row_array();        
        return $about_user_data['comp_overview'];
    }
}