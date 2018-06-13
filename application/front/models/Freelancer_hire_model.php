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
}