<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Freelancer_hire_model extends CI_Model {

    public function getfreelancerhiredata($user_id = '', $select_data = '') {
        $this->db->select($select_data)->from('freelancer_hire_reg');
        $this->db->where(array('user_id' => $user_id, 'is_delete' => '0', 'status' => '1'));
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    public function getprojectdatabypostid($postid = '', $userid = '', $selectdata = '') {
        $this->db->select($selectdata)->from("freelancer_post fp");
        $this->db->join('freelancer_hire_reg fr', 'fp.user_id = fr.user_id', 'left');
        $this->db->where(array('fp.post_id' => $postid, 'fp.is_delete' => '0', 'fr.user_id' => $userid, 'fr.status' => '1', 'fr.free_hire_step' => '3'));
        $query = $this->db->get();
        //       $result_array = $query->row_array();
        return $query->result_array();
    }

    public function checkfreelanceruser($user_id = '') {
        $this->db->select("freelancer_hire_slug")->from("freelancer_hire_reg");
        $this->db->where(array('user_id' => $user_id, 'status' => '0', 'is_delete' => '0'));
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    public function getCountry() {
        $this->db->select('country_id,country_name')->from('countries');
        $this->db->order_by("country_name", "ASC");
        $this->db->where(array('status' => '1'));
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getprojectlivedatabyuserid($userid = '') {
        $this->db->select('*')->from("freelancer_post_live pl");
        $this->db->where(array('status' => '1', 'is_delete' => '0', 'user_id' => $userid));
        $query = $this->db->get();
//       $result_array = $query->row_array();
        return $query->result_array();
    }

    function insert_data($data, $tablename) {
        if ($this->db->insert($tablename, $data)) {
            return true;
        } else {
            return false;
        }
    }

    function insert_data_getid($data, $tablename) {
        if ($this->db->insert($tablename, $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    function select_data_by_search($tablename, $search_condition, $condition_array = array(), $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $group_by = '') {
        $this->db->select($data);

        if (!empty($join_str)) {
            foreach ($join_str as $join) {
                $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id']);
            }
        }
        $this->db->where($condition_array);
        $this->db->where($search_condition);

        if ($limit != '' && $offset == 0) {
            $this->db->limit($limit);
        } elseif ($limit != '' && $offset != 0) {
            $this->db->limit($limit, $offset);
        }

        if ($sortby != '' && $orderby != '') {
            $this->db->order_by($sortby, $orderby);
        }
        $this->db->group_by($group_by);
        $query = $this->db->get($tablename);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    public function update_data($data, $tablename, $columnname, $columnid) {
        $this->db->where($columnname, $columnid);
        if ($this->db->update($tablename, $data)) {
            return true;
        } else {
            return false;
        }
    }

    public function clean($string) {
        $string = str_replace(' ', '-', $string);
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);
        return preg_replace('/-+/', '-', $string);
    }

    function select_data_by_condition($tablename, $condition_array = array(), $data = '*', $sort_by = '', $order_by = '', $limit = '', $offset = '', $join_str = array(), $group_by = '') {
        $this->db->simple_query('SET SESSION group_concat_max_len=15000');
        $this->db->select($data);
        if (!empty($join_str)) {
            foreach ($join_str as $join) {
                if ($join['type'] == '') {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id']);
                } else {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id'], $join['join_type']);
                }
            }
        }

        if(!empty($having)){
            $this->db->having($having);
        }
        
        if ($sort_by != '' && $order_by != '') {
            $this->db->$order_by($sort_by, $order_by);
        }
        if ($limit != '' && $offset == 0) {
            $this->db->limit($limit);
        } else if ($limit != '' && $offset != 0) {
            $this->db->limit($limit, $offset);
        }
        if ($group_by) {
            $this->db->group_by($group_by);
        }

        $query = $this->db->get($tablename);

        if ($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }

    public function get_freelancer_rec_candidate($user_id = '', $category_id='',$city_id='',$skill_id='',$experience_id='', $limitstart=0, $limit=5){
        // echo $user_id;
        // echo "string";
        // exit;
        $filter_condition = "";
        if ($category_id) {
            $category_id = $_GET["category_id"];
            $filter_condition .= " AND freelancer_post_field IN (". $category_id .")";
        }
        if ($city_id) {
            $filter_condition .= " AND freelancer_post_city IN (". $city_id .")";
        }
        if ($skill_id) {
            $filter_condition .= " AND freelancer_post_area IN (". $skill_id .")";
        }
        if ($experience_id) {
            if($experience_id == 6)
            {
                $filter_condition .= " AND (freelancer_post_exp_year IS NOT NULL AND freelancer_post_exp_year > ". ($experience_id - 1) .")";
            }
            else if($experience_id == 1){
                $filter_condition .= " AND (freelancer_post_exp_year IS NULL OR freelancer_post_exp_year <= ". ($experience_id - 1) ." AND freelancer_post_exp_year >= ". $experience_id .")";
            }
            else{
                $filter_condition .= " AND freelancer_post_exp_year <= ". ($experience_id - 1) ." AND freelancer_post_exp_year >= ". $experience_id;
            }
        }
        $sql = "SELECT fpr.freelancer_post_reg_id, fpr.freelancer_post_fullname, 
                fpr.freelancer_post_username, fpr.freelancer_post_field, fpr.freelancer_post_city,
                fpr.freelancer_post_area, fpr.freelancer_post_skill_description, 
                fpr.freelancer_post_hourly, fpr.freelancer_post_ratestate, 
                fpr.freelancer_post_fixed_rate, fpr.freelancer_post_work_hour, 
                fpr.user_id, fpr.freelancer_post_user_image, fpr.designation, 
                fpr.freelancer_post_otherskill, fpr.freelancer_post_exp_month, 
                fpr.freelancer_post_exp_year, fpr.freelancer_apply_slug, 
                fpr.freelancer_post_country,fp.created_date
                FROM ailee_freelancer_post_reg fpr, ailee_freelancer_post fp
                WHERE fpr.status = '1' AND fpr.is_delete = '0' AND fpr.free_post_step = '7' 
                AND fpr.user_id != '". $user_id ."' 
                AND fp.post_skill REGEXP concat('[[:<:]](', REPLACE(fpr.freelancer_post_area, ',', '|'), ')[[:>:]]')
                AND fp.user_id = '". $user_id ."' AND fp.is_delete = '0' AND fp.status = '1' ". $filter_condition ." 
                ORDER BY fp.created_date";

        if($limit != ""){
            $sql .= " LIMIT $limitstart,$limit";
        }
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function get_freelancer_rec_candidate_total($user_id = '', $category_id='',$city_id='',$skill_id='',$experience_id=''){
        $filter_condition = "";
        if ($category_id) {
            $category_id = $_GET["category_id"];
            $filter_condition .= " AND freelancer_post_field IN (". $category_id .")";
        }
        if ($city_id) {
            $filter_condition .= " AND freelancer_post_city IN (". $city_id .")";
        }
        if ($skill_id) {
            $filter_condition .= " AND freelancer_post_area IN (". $skill_id .")";
        }
        if ($experience_id) {
            if($experience_id == 6)
            {
                $filter_condition .= " AND (freelancer_post_exp_year IS NOT NULL AND freelancer_post_exp_year > ". ($experience_id - 1) .")";
            }
            else if($experience_id == 1){
                $filter_condition .= " AND (freelancer_post_exp_year IS NULL OR freelancer_post_exp_year <= ". ($experience_id - 1) ." AND freelancer_post_exp_year >= ". $experience_id .")";
            }
            else{
                $filter_condition .= " AND freelancer_post_exp_year <= ". ($experience_id - 1) ." AND freelancer_post_exp_year >= ". $experience_id;
            }
        }
        $sql = "SELECT count(fpr.freelancer_post_reg_id) as total_record
                FROM ailee_freelancer_post_reg fpr, ailee_freelancer_post fp
                WHERE fpr.status = '1' AND fpr.is_delete = '0' AND fpr.free_post_step = '7' 
                AND fpr.user_id != '". $user_id ."' 
                AND fp.post_skill REGEXP concat('[[:<:]](', REPLACE(fpr.freelancer_post_area, ',', '|'), ')[[:>:]]')
                AND fp.user_id = '". $user_id ."' AND fp.is_delete = '0' AND fp.status = '1' ". $filter_condition ." 
                ORDER BY fp.created_date";
        $query = $this->db->query($sql);
        $result = $query->row_array();
        return $result;
    }

    
    function free_hire_related_blog_list() {
        $sql = "SELECT * FROM ailee_blog
                WHERE status='publish' AND
                blog_slug = 'benefits-of-hiring-freelancers-from-aileensoul' 
                OR blog_slug = '7-solutions-for-start-up-challenges' 
                OR blog_slug = 'find-quick-freelance-work-hire-quality-freelancers-for-free'";
        $query = $this->db->query($sql);
        $result_array = $query->result_array();   
        return $result_array;
    }

    function getSkillsNames($skills)
    {
        $sql = "SELECT GROUP_CONCAT(DISTINCT(skill)) as skill_name FROM ailee_skill WHERE skill_id IN (".$skills.") AND type = '1' AND status = '1'";
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

    public function freelancer_create_search_table()
    {
        set_time_limit(0);
        ini_set("memory_limit","512M");
        echo "<pre>";
        $sql = "SELECT * from ailee_freelancer_post_reg WHERE is_delete = '0' AND status = '1' AND free_post_step = '7'";
        $query = $this->db->query($sql);
        $result_array = $query->result_array();
        // print_r($result_array);exit;
        foreach ($result_array as $key => $value) {

            if(trim($value['freelancer_post_field']) != "")
            {
                $field_name = $this->db->get_where('category', array('category_id' => $value['freelancer_post_field']))->row()->category_name;
                $value['freelancer_post_field_txt'] = trim($field_name);
            }            

            if($value['freelancer_post_area'] != "")
            {
                $skill_name = "";
                foreach (explode(',',$value['freelancer_post_area']) as $skk => $skv) {
                    if($skv != "" && $skv != "26")
                    {
                        $s_name = $this->db->get_where('skill', array('skill_id' => $skv))->row()->skill;
                        if(trim($s_name) != "")
                        {
                            $skill_name .= $s_name.",";
                        }
                    }
                }
                $value['freelancer_post_area_txt'] = trim($skill_name,",");
            }
            if(trim($value['freelancer_post_country']) != "")
            {
                $country_name = $this->db->get_where('countries', array('country_id' => $value['freelancer_post_country'], 'status' => '1'))->row()->country_name;

                $value['country_name'] = trim($country_name);
            }

            if(trim($value['freelancer_post_state']) != "")
            {
                $state_name = $this->db->get_where('states', array('state_id' => $value['freelancer_post_state'], 'status' => '1'))->row()->state_name;

                $value['state_name'] = trim($state_name);
            }

            if(trim($value['freelancer_post_city']) != "")
            {
                $city_name = $this->db->get_where('cities', array('city_id' => $value['freelancer_post_city'], 'status' => '1'))->row()->city_name;

                $value['city_name'] = trim($city_name);
            }            
            $this->db->insert('ailee_freelancer_post_reg_search_tmp', $value);
        }
        echo "Done";
    }

    public function set_save_review($from_user_id,$to_user_id,$review_star,$review_desc ='',$fileName = '')
    {
        $data = array(
            'to_user_id' => $to_user_id,
            'from_user_id' => $from_user_id,
            'review_star' => $review_star,
            'review_desc' => $review_desc,
            'review_file' => $fileName,    
            'status' => '1',
            'created_date' => date('Y-m-d H:i:s', time()),
            'modify_date' => date('Y-m-d H:i:s', time()),
        );
        $insert_id = $this->common->insert_data($data, 'freelancer_review');
        return $insert_id;
    }

    public function get_save_review($to_user_id)
    {
        $this->db->select("fp.freelancer_post_fullname as first_name,fp.freelancer_post_username as last_name,freelancer_post_user_image as user_image,fr.*")->from('freelancer_review fr');
        $this->db->join('freelancer_post_reg fp', 'fp.user_id = fr.from_user_id', 'left');
        $this->db->where('fr.to_user_id', $to_user_id);
        $this->db->where('fr.status', '1');
        $this->db->order_by('fr.created_date', 'desc');
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    public function get_review_avarage($to_user_id)
    {
        $this->db->select("review_star,count(from_user_id) as rating_count")->from('freelancer_review');        
        $this->db->where('to_user_id', $to_user_id);
        $this->db->where('status', '1');
        $this->db->group_by('review_star');
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    public function get_review_count($to_user_id)
    {
        $this->db->select("COUNT(*) total_review")->from('freelancer_review fr');
        $this->db->join('freelancer_post_reg fp', 'fp.user_id = fr.from_user_id', 'left');
        $this->db->where('fr.to_user_id', $to_user_id);
        $this->db->where('fr.status', '1');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    public function get_cmp_company_cont_info($to_user_id)
    {
        $this->db->select("fh.comp_email, fh.comp_skype, fh.comp_number, fh.comp_website, fh.company_country, fh.company_state, fh.company_city, cr.country_name, st.state_name, ct.city_name")->from('freelancer_hire_reg fh');
        $this->db->join('countries cr', 'cr.country_id = fh.company_country', 'left');
        $this->db->join('states st', 'st.state_id = fh.company_state', 'left');
        $this->db->join('cities ct', 'ct.city_id = fh.company_city', 'left');
        $this->db->where('fh.user_id', $to_user_id);
        $this->db->where('fh.status', '1');
        $this->db->where('fh.is_delete', '0');
        $query = $this->db->get();
        $row_array = $query->row_array();
        return $row_array;
    }

    public function get_cmp_company_info($to_user_id)
    {
        $this->db->select("fh.comp_name, fh.company_field, fh.company_other_field, fh.company_country, fh.company_state, fh.company_city, fh.comp_team, fh.comp_founded_year, fh.comp_founded_month, fh.comp_overview, fh.comp_service_offer, fh.comp_exp_year, fh.comp_exp_month, fh.comp_skills_offer, fh.comp_logo, cr.country_name, st.state_name, ct.city_name, it.industry_name as company_field_txt,IF(fh.comp_skills_offer != '',GROUP_CONCAT(DISTINCT(s.skill)),'') as comp_skills_offer_txt")->from('freelancer_hire_reg fh,skill s');
        $this->db->join('countries cr', 'cr.country_id = fh.company_country', 'left');
        $this->db->join('states st', 'st.state_id = fh.company_state', 'left');
        $this->db->join('cities ct', 'ct.city_id = fh.company_city', 'left');
        $this->db->join('industry_type it', 'it.industry_id = fh.company_field', 'left');
        $sql = "IF(fh.comp_skills_offer != '', FIND_IN_SET(s.skill_id, fh.comp_skills_offer) != '0', '1=1')";
        $this->db->where($sql);
        $this->db->where('fh.user_id', $to_user_id);
        $this->db->where('fh.status', '1');
        $this->db->where('fh.is_delete', '0');
        $this->db->group_by('fh.comp_skills_offer,fh.reg_id');        
        $query = $this->db->get();
        $row_array = $query->row_array();
        return $row_array;
    }

    public function set_save_cmp_comp_info($userid,$comp_name = "", $company_field = "", $company_other_field = "", $comp_skill_ids = "", $comp_team = "", $comp_founded_year = "", $comp_founded_month = "", $comp_overview  = "",$comp_service_offer  = "",$comp_exp_year  = "",$comp_exp_month = "", $fileName = "")
    {
         $data = array(
                'comp_name' => $comp_name,
                'company_field' => $company_field,
                'company_other_field' => $company_other_field,
                'comp_team  ' => $comp_team ,
                'comp_skills_offer' => $comp_skill_ids,
                'comp_founded_year' => $comp_founded_year,
                'comp_founded_month' => $comp_founded_month,                
                'comp_overview' => $comp_overview,                
                'comp_service_offer' => $comp_service_offer,                
                'comp_exp_year' => $comp_exp_year,                
                'comp_exp_month' => $comp_exp_month,                
                'comp_logo' => $fileName,
                'modified_date' => date('Y-m-d H:i:s', time()),
            );
            $this->db->where('user_id', $userid);
            $this->db->update('freelancer_hire_reg', $data);
            return true;
    }

    public function get_individual_company_info($to_user_id)
    {
        $this->db->select("fh.comp_name, fh.company_field, it.industry_name as company_field_txt, fh.company_other_field, fh.comp_overview, fh.country, fh.state, fh.city, cr.country_name, st.state_name, ct.city_name")->from('freelancer_hire_reg fh');
        $this->db->join('countries cr', 'cr.country_id = fh.country', 'left');
        $this->db->join('states st', 'st.state_id = fh.state', 'left');
        $this->db->join('cities ct', 'ct.city_id = fh.city', 'left');
        $this->db->join('industry_type it', 'it.industry_id = fh.company_field', 'left');
        $this->db->where('fh.user_id', $to_user_id);
        $this->db->where('fh.status', '1');
        $this->db->where('fh.is_delete', '0');
        $query = $this->db->get();
        $row_array = $query->row_array();
        return $row_array;
    }

    public function get_individual_basic_info($to_user_id)
    {
        $this->db->select("fh.fullname as first_name,fh.username as last_name,fh.email, fh.phone, fh.skyupid, fh.current_position, jt.name as current_position_txt, fh.individual_skills, fh.individual_industry, it.industry_name as individual_industry_txt, fh.individual_other_industry, fh.professional_info,IF(fh.individual_skills != '',GROUP_CONCAT(DISTINCT(s.skill)),'') as individual_skills_txt")->from('freelancer_hire_reg fh,skill s');
        $this->db->join('job_title jt', 'jt.title_id = fh.current_position', 'left');
        $this->db->join('industry_type it', 'it.industry_id = fh.individual_industry', 'left');
        $sql = "IF(fh.individual_skills != '', FIND_IN_SET(s.skill_id, fh.individual_skills) != '0', '1=1')";
        $this->db->where($sql);
        $this->db->where('fh.user_id', $to_user_id);
        $this->db->where('fh.status', '1');
        $this->db->where('fh.is_delete', '0');
        $this->db->group_by('fh.individual_skills,fh.reg_id');        
        $query = $this->db->get();
        $row_array = $query->row_array();
        return $row_array;
    }
}