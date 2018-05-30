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

        $this->db->select('count(fp.post_id) as count,ji.industry_id,ji.industry_name,ji.industry_slug,ji.industry_image')->from('job_industry ji');
        $this->db->join('freelancer_post fp', 'fp.post_field_req = ji.industry_id', 'left');
        $this->db->where('ji.status', '1');
        $this->db->where('ji.is_delete', '0');
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
            if(!file_exists(JOB_INDUSTRY_IMG_PATH."/".$result_array[$k]['industry_image']))
            {
                $result_array[$k]['industry_image'] = "job_industry_image_default.png";
            }
        }
        return $result_array;
    }

    function get_fa_field($limit = '',$page = "") {
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;


        $sql = "SELECT count(fp.post_id) as count,ji.industry_id,ji.industry_name,ji.industry_slug, ji.industry_image FROM ailee_job_industry ji,ailee_freelancer_post fp WHERE fp.post_field_req = ji.industry_id AND ji.status = '1' AND ji.is_delete = '0' AND fp.status = '1' AND fp.is_delete = '0' GROUP BY fp.post_field_req ORDER BY count DESC";
        if($limit != '') {
            $sql .= " LIMIT $start,$limit";
        }

        $query = $this->db->query($sql);

        $fa_category = $query->result_array();
        foreach ($fa_category as $k => $v) {
            if(!file_exists(JOB_INDUSTRY_IMG_PATH."/".$fa_category[$k]['industry_image']))
            {
                $fa_category[$k]['industry_image'] = "job_industry_image_default.png";
            }
        }
        
        $ret_array['fa_fields'] = $fa_category;
        $ret_array['total_record'] = $this->get_fa_field_total_rec();
        return $ret_array;
    }

    function get_fa_field_total_rec() {        

        $sql = "SELECT count(fp.post_id) as count,ji.industry_id,ji.industry_name,ji.industry_slug, ji.industry_image FROM ailee_job_industry ji,ailee_freelancer_post fp WHERE fp.post_field_req = ji.industry_id AND ji.status = '1' AND ji.is_delete = '0' AND fp.status = '1' AND fp.is_delete = '0' GROUP BY fp.post_field_req ORDER BY count DESC";

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
        $this->db->select('ji.industry_id,ji.industry_name,ji.industry_slug')->from('job_industry ji');        
        $this->db->where('ji.status', '1');
        $this->db->where('ji.is_delete', '0');
        $this->db->where('ji.is_other', '0');        
        $this->db->where('ji.industry_slug LIKE BINARY "'.$keyword.'"');
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
        $select_data = "post_id,post_name,(SELECT  Count(uv.invite_id) As invitecount FROM ailee_user_invite as uv WHERE   (uv.post_id = fp.post_id) ) As ShortListedCount,(SELECT  Count(afa.app_id) As invitecount FROM ailee_freelancer_apply as afa WHERE (afa.post_id = fp.post_id) ) As AppliedCount,fp.created_date,post_rate,GROUP_CONCAT(DISTINCT(s.skill)) as post_skill,post_rating_type,currency_name as post_currency,ct.city_name as city,cr.country_name as country,post_description,post_field_req,fp.user_id,DATEDIFF(fp.post_last_date,NOW()) as day_remain,fp.post_slug";
        $this->db->select($select_data)->from('freelancer_post fp,ailee_skill s');
        $this->db->join('job_title jt', 'jt.title_id = fp.post_name', 'left');
        $this->db->join('currency c', 'c.currency_id = fp.post_currency', 'left');
        $this->db->join('cities ct', 'ct.city_id = fp.city', 'left');
        $this->db->join('countries cr', 'cr.country_id = fp.country', 'left');
        if(isset($fa_skills) && !empty($fa_skills)){            
            $this->db->where('FIND_IN_SET('.$fa_skills['skill_id'].', fp.`post_skill`) !=', 0);
        }
        else if(isset($fa_fields) && !empty($fa_fields)){            
            $this->db->where('post_field_req',$fa_fields['industry_id']);
        }
        $this->db->where('FIND_IN_SET(`s`.`skill_id`, `fp`.`post_skill`)');
        if($sql != "")
        {            
            $sql = "(".trim($sql, ' OR ').")";
            $this->db->where($sql,false,false);
        }
        $this->db->where(array('fp.is_delete' => '0', 'fp.status' => '1'));
        $this->db->group_by('fp.post_skill,fp.post_id');
        $this->db->order_by('fp.post_id','desc');
        if($limit != "")
        {
            $this->db->limit($limit,$start);
        }
        $query = $this->db->get();
        // echo $this->db->last_query();exit;
        $result_array = $query->result_array();
        foreach ($result_array as $key => $value) {
            $firstname = $this->db->select('fullname')->get_where('freelancer_hire_reg', array('user_id' => $value['user_id']))->row()->fullname;
            $result_array[$key]['fullname'] = $firstname;

            $industry_name = $this->db->select('industry_name')->get_where('job_industry', array('industry_id' => $value['post_field_req']))->row()->industry_name;
            $result_array[$key]['industry_name'] = $industry_name;
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

        $select_data = "post_id,post_name,(SELECT  Count(uv.invite_id) As invitecount FROM ailee_user_invite as uv WHERE   (uv.post_id = fp.post_id) ) As ShortListedCount,(SELECT  Count(afa.app_id) As invitecount FROM ailee_freelancer_apply as afa WHERE (afa.post_id = fp.post_id) ) As AppliedCount,fp.created_date,post_rate,GROUP_CONCAT(DISTINCT(s.skill)) as post_skill,post_rating_type,currency_name as post_currency,ct.city_name as city,cr.country_name as country,post_description,post_field_req";
        $this->db->select($select_data)->from('freelancer_post fp,ailee_skill s');
        $this->db->join('job_title jt', 'jt.title_id = fp.post_name', 'left');
        $this->db->join('currency c', 'c.currency_id = fp.post_currency', 'left');
        $this->db->join('cities ct', 'ct.city_id = fp.city', 'left');
        $this->db->join('countries cr', 'cr.country_id = fp.country', 'left');
        if(isset($fa_skills) && !empty($fa_skills)){            
            $this->db->where('FIND_IN_SET('.$fa_skills['skill_id'].', fp.`post_skill`) !=', 0);
        }
        else if(isset($fa_fields) && !empty($fa_fields)){            
            $this->db->where('post_field_req',$fa_fields['industry_id']);
        }
        if($sql != "")
        {            
            $sql = "(".trim($sql, ' OR ').")";
            $this->db->where($sql,false,false);
        }
        $this->db->where(array('fp.is_delete' => '0', 'fp.status' => '1'));
        $this->db->group_by('fp.post_skill,fp.post_id');
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

}
