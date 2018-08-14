<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Recruiter_model extends CI_Model {
 
    public function getRecruiterByUserid($user_id = '') {
        $this->db->select("r.rec_id,r.rec_firstname,r.rec_lastname,r.rec_email,r.re_status,r.rec_phone,r.re_comp_name,r.re_comp_email,r.re_comp_site,r.re_comp_country,r.re_comp_state,r.re_comp_city,r.user_id,r.re_comp_profile,r.re_comp_sector,r.re_comp_activities,r.re_step,r.re_comp_phone,r.recruiter_user_image,r.profile_background,r.profile_background_main,r.designation,r.comp_logo")->from("recruiter r");
        $this->db->where(array('r.user_id' => $user_id,'is_delete' => '0', 're_status' => '1'));
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }
    
    
    public function getRecruiterCompanyname($user_id = '') {
        $this->db->select("r.re_comp_name")->from("recruiter r");
        $this->db->where(array('r.user_id' => $user_id,'is_delete' => '0', 're_status' => '1'));
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }
    
    public function getRecruiterPostById($post_id = '',$user_id = '') {
        $this->db->select("rp.post_name,rp.max_year,rp.min_year,rp.fresher,rp.city,rp.state")->from("rec_post rp");
        $this->db->where(array('rp.post_id' => $post_id, 'rp.status' => '1', 'rp.is_delete' => '0', 'rp.user_id' => $user_id));
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }
    
    public function getRecruiterWhere($table_name = '',$where = '',$fieldvalue = '') {
       return $this->db->get_where($table_name, $where)->row_array()->$fieldvalue; 
    }
    
    public function CheckRecruiterAvailable($user_id = '') {
       $this->db->select("count(*) as total")->from("recruiter r");
        $this->db->where(array('r.user_id' => $user_id, 'r.re_status' => '1', 'r.is_delete' => '0', 'r.re_step' => '3'));
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array; 
    }

   /* public function get_recommen_candidate_post($userid,$page = "",$limit = '5')
    {
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;

        $sql = "SELECT ailee_job_reg.user_id as iduser, ailee_job_reg.fname, ailee_job_reg.lname, ailee_job_reg.email, ailee_job_reg.phnno, ailee_job_reg.language, ailee_job_reg.keyskill, ailee_job_reg.experience, ailee_job_reg.job_user_image, ailee_job_reg.designation, ailee_job_reg.work_job_title, ailee_job_reg.work_job_industry, ailee_job_reg.work_job_city, ailee_job_reg.slug, ailee_job_add_edu.degree, ailee_job_add_edu.stream, ailee_job_add_edu.board_primary, ailee_job_add_edu.board_secondary, ailee_job_add_edu.board_higher_secondary, ailee_job_add_edu.percentage_primary, ailee_job_add_edu.percentage_secondary, ailee_job_add_edu.percentage_higher_secondary, ailee_job_graduation.* FROM ailee_job_reg LEFT JOIN ailee_job_add_edu ON ailee_job_reg.user_id=ailee_job_add_edu.user_id LEFT JOIN ailee_job_graduation ON ailee_job_reg.user_id=ailee_job_graduation.user_id WHERE ailee_job_reg.job_id IN (
                SELECT DISTINCT j.job_id FROM( SELECT jr.job_id FROM ailee_job_reg jr,ailee_rec_post rp WHERE jr.status = '1' AND jr.is_delete = '0' AND jr.job_step = '10' AND jr.user_id != '".$userid."' AND jr.keyskill REGEXP concat('[[:<:]](', REPLACE(rp.post_skill, ',', '|'), ')[[:>:]]') AND rp.user_id = '".$userid."' AND rp.is_delete = '0' AND rp.status = '1'

                UNION

                SELECT jr.job_id FROM ailee_job_reg jr,ailee_rec_post rp WHERE jr.status = '1' AND jr.is_delete = '0' AND jr.job_step = '10' AND jr.user_id != '".$userid."' AND jr.work_job_title = rp.post_name AND rp.user_id = '".$userid."' AND rp.is_delete = '0' AND rp.status = '1'

                UNION

                SELECT DISTINCT jr.job_id FROM ailee_job_reg jr,ailee_rec_post rp WHERE jr.status = '1' AND jr.is_delete = '0' AND jr.job_step = '10' AND jr.user_id != '".$userid."' AND jr.work_job_industry = rp.industry_type AND rp.user_id = '".$userid."' AND rp.is_delete = '0' AND rp.status = '1'
                ) as j ORDER BY j.job_id DESC

            ) AND ailee_job_reg.is_delete = '0' AND ailee_job_reg.status = '1' AND ailee_job_reg.job_step = '10' ORDER BY job_id DESC";
        if($limit != '') {
            $sql .= " LIMIT $start,$limit";
        }

        // echo $sql;exit;
        $query = $this->db->query($sql);        
        $recommen_candid = $query->result_array();
        return $recommen_candid;
    }*/

    public function get_recommen_candidate_post_total($city_id='',$title_id = '',$industry_id = '',$skill_id = '',$experience = '', $userid,$page = "",$limit = '5')
    {
        $sql_filter = "";
        // Apply condition for filter
        if($city_id != ""){
            $sql_filter .= " AND ailee_job_reg.city_id IN (". $city_id .") AND ailee_job_reg.city_id > 0";
        }

        if($title_id != ""){
            $sql_filter .= " AND ailee_job_reg.work_job_title IN (". $title_id .") AND ailee_job_reg.work_job_title > 0";
        }

        if($industry_id != ""){
            $sql_filter .= " AND ailee_job_reg.work_job_industry IN (". $industry_id .") AND ailee_job_reg.work_job_industry > 0";
        }

        if($skill_id != ""){
            $sql_filter .= " AND ailee_job_reg.keyskill IN (". $skill_id .") AND ailee_job_reg.keyskill > 0";
        }

        if($experience_id != ""){
            if($experience_id == 6)
            {
                $sql_filter .= " AND (ailee_job_reg.exp_y IS NOT NULL OR ailee_job_reg.exp_y > ". $experience_id .")";
            }
            else if($experience_id == 1){
                $sql_filter .= " AND (ailee_job_reg.exp_y IS NULL OR ailee_job_reg.exp_y <= ". ($experience_id - 1) ." AND ailee_job_reg.exp_y >= ". $experience_id .")";
            } 
            else{
                $sql_filter .= " AND ailee_job_reg.exp_y <= ". ($experience_id - 1) ." AND ailee_job_reg.exp_y >= ". $experience_id;
            }
        }

        $sql = "SELECT COUNT(*) as total_record FROM ailee_job_reg LEFT JOIN ailee_job_add_edu ON ailee_job_reg.user_id=ailee_job_add_edu.user_id WHERE ailee_job_reg.is_delete = '0' AND ailee_job_reg.status = '1' AND ailee_job_reg.job_step = '10'". $sql_filter ." ORDER BY job_id DESC";
       
        $query = $this->db->query($sql);        
        // echo $this->db->last_query();exit;
        $recommen_candid_totrec = $query->row_array();
        return $recommen_candid_totrec['total_record'];
    }

    // GET TOP CITIES LIST
    public function get_top_cities($limitstart = 0, $limit = 5){
        $this->db->select('count(jr.job_id) as count,c.city_id,c.city_name,c.slug,c.city_image')->from('cities c');
        $this->db->join('ailee_job_reg jr', 'jr.work_job_city = c.city_id', 'left');
        $this->db->where('c.status', '1');
        $this->db->where('jr.status', '1');
        $this->db->where('jr.is_delete', '0');
        $this->db->group_by('jr.work_job_city');        
        if($limit != '') {
            $this->db->limit($limit,$start);
        }
        $this->db->order_by('count', 'desc');
        $query = $this->db->get();
        $jobCity = $query->result_array();
        return $jobCity;

        // $result_array['job_city'] = $jobCity;

        // // GET TOP LOCATION OF ARTIST
        // $sql = "SELECT count(*) as count, ac.city_name, ac.city_id, false as isselected  
        //         FROM ailee_job_reg jr
        //         left join ailee_cities as ac on ac.city_id = jr.city_id
        //         where city_name IS NOT NULL and jr.status = 1 
        //         group by city_name
        //         order by count desc LIMIT ". $limitstart .",". $limit;
        // $query = $this->db->query($sql);
        // $result_array = $query->result_array();
        // return $result_array;
    }

    // GET TOP TITLE LIST
    public function get_job_title($limitstart = 0, $limit = 5){
        // GET TOP LOCATION OF ARTIST
        $sql = "SELECT count(*) as count, jt.name, jt.title_id, false as isselected
                FROM ailee_job_reg jr
                left join ailee_job_title as jt on jt.title_id = jr.work_job_title
                where jt.name IS NOT NULL and jr.status = 1 and jt.name != 'Others' 
                group by jt.name
                order by count desc LIMIT ". $limitstart .",". $limit;
        $query = $this->db->query($sql);
        $result_array = $query->result_array();
        return $result_array;
    }

    // GET TOP INDUSTRIES LIST
    public function get_top_industries($limitstart = 0, $limit = 5){
        $sql = "SELECT count(*) as count, ji.industry_name, ji.industry_id, false as isselected
                FROM ailee_job_reg jr
                left join ailee_job_industry as ji on ji.industry_id = jr.work_job_industry
                where ji.industry_name IS NOT NULL and jr.status = 1 and ji.industry_name != 'Others'
                group by ji.industry_name
                order by count desc LIMIT ". $limitstart .",". $limit;
        $query = $this->db->query($sql);
        $result_array = $query->result_array();
        return $result_array;
    }
    
    // GET TOP SKILL LIST
    public function get_job_skill($limitstart = 0, $limit = 5){
        $sql = "SELECT count(jr.job_id) as count, s.skill_id, s.skill, s.skill_slug, s.skill_image 
                FROM ailee_skill s,ailee_job_reg jr WHERE FIND_IN_SET(s.skill_id,jr.keyskill) > 0 
                AND s.status = '1' AND s.type = '1' AND jr.status = '1' AND jr.is_delete = '0' 
                GROUP BY s.skill_id ORDER BY count DESC LIMIT ". $limitstart .",". $limit;
        $query = $this->db->query($sql);
        $skills = $query->result_array();
        return $skills;
    }

    public function get_job_experience($limitstart = 0, $limit = 5){
        $result[] = array('id' => '1','name' => '0 to 1 year', 'isselected' => false);
        $result[] = array('id' => '2','name' => '1 to 2 year', 'isselected' => false);
        $result[] = array('id' => '3','name' => '2 to 3 year', 'isselected' => false);
        $result[] = array('id' => '4','name' => '3 to 4 year', 'isselected' => false);
        $result[] = array('id' => '5','name' => '4 to 5 year', 'isselected' => false);
        $result[] = array('id' => '6','name' => 'More than 5 year', 'isselected' => false);
        return $result;
    }
    public function get_recommen_candidate_post($city_id='',$title_id = '',$industry_id = '',$skill_id = '',$experience_id = '', $userid = '', $page = '',$limit = '5')
    {
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;

        $sql_filter = "";
        // Apply condition for filter
        if($city_id != ""){
            $sql_filter .= " AND ailee_job_reg.city_id IN (". $city_id .") AND ailee_job_reg.city_id > 0";
        }

        if($title_id != ""){
            $sql_filter .= " AND ailee_job_reg.work_job_title IN (". $title_id .") AND ailee_job_reg.work_job_title > 0";
        }

        if($industry_id != ""){
            $sql_filter .= " AND ailee_job_reg.work_job_industry IN (". $industry_id .") AND ailee_job_reg.work_job_industry > 0";
        }

        if($skill_id != ""){
            $sql_filter .= " AND ailee_job_reg.keyskill IN (". $skill_id .") AND ailee_job_reg.keyskill > 0";
        }

        if($experience_id != ""){
            if($experience_id == 6)
            {
                $sql_filter .= " AND (ailee_job_reg.exp_y IS NOT NULL AND ailee_job_reg.exp_y > ". $experience_id .")";
            }
            else if($experience_id == 1){
                $sql_filter .= " AND (ailee_job_reg.exp_y IS NULL OR ailee_job_reg.exp_y <= ". ($experience_id - 1) ." AND ailee_job_reg.exp_y >= ". $experience_id .")";
            }
            else{
                $sql_filter .= " AND ailee_job_reg.exp_y <= ". ($experience_id - 1) ." AND ailee_job_reg.exp_y >= ". $experience_id;
            }
        }

        $sql = "SELECT ailee_job_reg.user_id as iduser, ailee_job_reg.fname, ailee_job_reg.lname, ailee_job_reg.email, ailee_job_reg.phnno, ailee_job_reg.language, ailee_job_reg.keyskill, ailee_job_reg.experience, ailee_job_reg.job_user_image, ailee_job_reg.designation, ailee_job_reg.work_job_title, ailee_job_reg.work_job_industry, ailee_job_reg.work_job_city, ailee_job_reg.slug, ailee_job_add_edu.degree, ailee_job_add_edu.stream, ailee_job_add_edu.board_primary, ailee_job_add_edu.board_secondary, ailee_job_add_edu.board_higher_secondary, ailee_job_add_edu.percentage_primary, ailee_job_add_edu.percentage_secondary, ailee_job_add_edu.percentage_higher_secondary, ailee_job_reg.exp_y,ailee_job_reg.exp_m FROM ailee_job_reg LEFT JOIN ailee_job_add_edu ON ailee_job_reg.user_id=ailee_job_add_edu.user_id WHERE ailee_job_reg.is_delete = '0' AND ailee_job_reg.status = '1' AND ailee_job_reg.job_step = '10'" . $sql_filter;

        $sql .= " ORDER BY job_id DESC";
        if($limit != '') {
            $sql .= " LIMIT $start,$limit";
        }

        // echo $sql;exit;
        $query = $this->db->query($sql);        
        $recommen_candid = $query->result_array();
        return $recommen_candid;
    }

    // Get Filter List
    public function get_recommen_candidate_search($searchkeyword = '',$searchplace = '',$city_id='',$title_id = '',$industry_id = '',$skill_id = '',$experience_id = '', $userid = '', $page = '',$limit = '5')
    {
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;

        $sql_skill = "";$sql_jt = "";$sql_cn = "";$sql_it = "";     
        foreach (explode(",", $searchkeyword) as $key => $value) {
            if($value != "" && $value != "in" && $value != "candidates")
            {
                $sql_skill .= ($sql_skill == "") ? " (" : " OR";
                $sql_jt .= ($sql_jt == "") ? " (" : " OR";
                $sql_it .= ($sql_it == "") ? " (" : " OR";

                $value = '%'. $value .'%'; 
                $sql_skill .= " jr.keyskill_txt LIKE '". $value ."'";
                $sql_jt .= " jr.work_job_title_txt LIKE '". $value ."'";
                $sql_it .= " jr.work_job_industry_txt LIKE '". $value ."'";
            }
        }
        $sql_skill .= ($sql_skill == "") ? "" : ")";
        $sql_jt .= ($sql_jt == "") ? "" : ")";
        $sql_it .= ($sql_it == "") ? "" : ")";

        $sql_city = "";$sql_state = "";$sql_country = "";
        foreach (explode(",", $searchplace) as $key => $value) {
            if($value != "")
            {                
                $sql_city .= ($sql_city == "") ? " (" : " OR";
                // $sql_state .= ($sql_state == "") ? " (" : " OR";
                // $sql_country .= ($sql_country == "") ? " (" : " OR";

                $value = $value .'%';
                $sql_city .= " jr.work_job_city_txt LIKE '".$value."'";
                // $sql_state .= "  jr.state_name LIKE '".$value."'";
                // $sql_country .= "jr.country_name LIKE '".$value."'";            
            }
        }
        $sql_city .= ($sql_city == "") ? "" : ")";
        // $sql_state .= ($sql_state == "") ? "" : ")";
        // $sql_country .= ($sql_country == "") ? "" : ")";
        // echo $sql_city;
        // exit;

        $sql_filter = "";
        // Apply condition for filter
        if($city_id != ""){
            $sql_filter .= " AND jr.work_job_city IN (". $city_id .") AND jr.work_job_city > 0";
        }

        if($title_id != ""){
            $sql_filter .= " AND jr.work_job_title IN (". $title_id .") AND jr.work_job_title > 0";
        }

        if($industry_id != ""){
            $sql_filter .= " AND jr.work_job_industry IN (". $industry_id .") AND jr.work_job_industry > 0";
        }

        if($skill_id != ""){
            $sql_filter .= " AND jr.keyskill IN (". $skill_id .") AND jr.keyskill > 0";
        }

        if($experience_id != ""){
            if($experience_id == 6)
            {
                $sql_filter .= " AND (jr.exp_y IS NOT NULL OR jr.exp_y > ". $experience_id.")";
            }
            else if($experience_id == 1)
            {
                $sql_filter .= " AND (jr.exp_y IS NULL OR jr.exp_y <= ". ($experience_id - 1) ." AND jr.exp_y >= ". $experience_id .")";
            }
            else{
                $sql_filter .= " AND jr.exp_y <= ". ($experience_id - 1) ." AND jr.exp_y >= ". $experience_id;
            }
        }        

        $sql = "SELECT jr.user_id as iduser, jr.fname, jr.lname, jr.email, jr.phnno, jr.language, jr.keyskill,jr.keyskill_txt, jr.work_job_title_txt,jr.work_job_industry_txt,jr.city_name,jr.state_name,jr.experience, jr.job_user_image, jr.designation, jr.work_job_title, jr.work_job_industry, jr.work_job_city, jr.slug, jr.exp_y,jr.exp_m,jae.degree, jae.stream, jae.board_primary, jae.board_secondary, jae.board_higher_secondary, jae.percentage_primary, jae.percentage_secondary, jae.percentage_higher_secondary FROM ailee_job_reg_search_tmp jr
            LEFT JOIN ailee_job_add_edu as jae ON jr.user_id = jae.user_id 
            WHERE jr.is_delete = '0' AND jr.status = '1' AND jr.is_delete = '0' AND jr.job_step = '10' AND jr.user_id != '".$userid."' ";
        if($searchkeyword != "")
        {
            $sql .= "AND (".$sql_skill." OR ".$sql_jt." OR ".$sql_it.")";   
        }
        if($searchplace != "")
        {
            // if($searchkeyword != "")
            // {
            //     $sql .= "OR";
            // }
            // else
            // {
            //     $sql .= "AND";
            // }
            $sql .= "AND (".$sql_city.")";      
        }

        if($sql_filter != "")
        {
            $sql .= "AND ".trim($sql_filter," AND ");
        }

        $sql .= " ORDER BY jr.user_id DESC";
        if($limit != '') {
            $sql .= " LIMIT $start, $limit";
        }

        // echo $sql;exit;
        $query = $this->db->query($sql);        
        $recommen_candid = $query->result_array();
        return $recommen_candid;
    }

    // Get Filter List
    public function get_recommen_candidate_search_total($searchkeyword = '',$searchplace = '',$city_id='', $title_id = '', $industry_id, $skill_id, $experience_id, $userid, $page = '',$limit = '')
    {

        $sql_skill = "";$sql_jt = "";$sql_cn = "";$sql_it = "";     
        foreach (explode(",", $searchkeyword) as $key => $value) {
            if($value != "" && $value != "in" && $value != "candidates")
            {
                $sql_skill .= ($sql_skill == "") ? " (" : " OR";
                $sql_jt .= ($sql_jt == "") ? " (" : " OR";
                $sql_it .= ($sql_it == "") ? " (" : " OR";

                $value = '%'. $value .'%'; 
                $sql_skill .= " jr.keyskill_txt LIKE '". $value ."'";
                $sql_jt .= " jr.work_job_title_txt LIKE '". $value ."'";
                $sql_it .= " jr.work_job_industry_txt LIKE '". $value ."'";
            }
        }
        $sql_skill .= ($sql_skill == "") ? "" : ")";
        $sql_jt .= ($sql_jt == "") ? "" : ")";
        $sql_it .= ($sql_it == "") ? "" : ")";

        $sql_city = "";$sql_state = "";$sql_country = "";
        foreach (explode(",", $searchplace) as $key => $value) {
            if($value != "")
            {                
                $sql_city .= ($sql_city == "") ? " (" : " OR";
                // $sql_state .= ($sql_state == "") ? " (" : " OR";
                // $sql_country .= ($sql_country == "") ? " (" : " OR";

                $value = $value .'%';
                $sql_city .= " jr.work_job_city_txt LIKE '".$value."'";
                // $sql_state .= "  jr.state_name LIKE '".$value."'";
                // $sql_country .= "jr.country_name LIKE '".$value."'";            
            }
        }
        $sql_city .= ($sql_city == "") ? "" : ")";
        // $sql_state .= ($sql_state == "") ? "" : ")";
        // $sql_country .= ($sql_country == "") ? "" : ")";
        // echo $sql_city;
        // exit;

        $sql_filter = "";
        // Apply condition for filter
        if($city_id != ""){
            $sql_filter .= " AND jr.work_job_city IN (". $city_id .") AND jr.work_job_city > 0";
        }

        if($title_id != ""){
            $sql_filter .= " AND jr.work_job_title IN (". $title_id .") AND jr.work_job_title > 0";
        }

        if($industry_id != ""){
            $sql_filter .= " AND jr.work_job_industry IN (". $industry_id .") AND jr.work_job_industry > 0";
        }

        if($skill_id != ""){
            $sql_filter .= " AND jr.keyskill IN (". $skill_id .") AND jr.keyskill > 0";
        }

        if($experience_id != ""){
            if($experience_id == 6)
            {
                $sql_filter .= " AND (jr.exp_y IS NOT NULL OR jr.exp_y > ". $experience_id.")";
            }
            else if($experience_id == 1)
            {
                $sql_filter .= " AND (jr.exp_y IS NULL OR jr.exp_y <= ". ($experience_id - 1) ." AND jr.exp_y >= ". $experience_id .")";
            }
            else{
                $sql_filter .= " AND jr.exp_y <= ". ($experience_id - 1) ." AND jr.exp_y >= ". $experience_id;
            }
        }        

        $sql = "SELECT COUNT(*) as total_record FROM ailee_job_reg_search_tmp jr
            LEFT JOIN ailee_job_add_edu as jae ON jr.user_id = jae.user_id 
            WHERE jr.is_delete = '0' AND jr.status = '1' AND jr.is_delete = '0' AND jr.job_step = '10' AND jr.user_id != '".$userid."' ";
        if($searchkeyword != "")
        {
            $sql .= "AND (".$sql_skill." OR ".$sql_jt." OR ".$sql_it.")";   
        }
        if($searchplace != "")
        {
            if($searchkeyword != "")
            {
                $sql .= "OR";
            }
            else
            {
                $sql .= "AND";
            }
            $sql .= "(".$sql_city.")";
        }

        if($sql_filter != "")
        {
            $sql .= "AND ".trim($sql_filter," AND ");
        }

        $sql .= " ORDER BY jr.user_id DESC";       
        // echo $sql;exit;
        $query = $this->db->query($sql);        
        $recommen_candid = $query->row_array();
        return $recommen_candid;
    }

    function recruiter_related_blog_list() {
        $sql = "SELECT * FROM ailee_blog
                WHERE status='publish' AND
                blog_slug = 'pros-and-cons-of-hiring-a-full-time-employee-vs-a-freelancer' 
                OR blog_slug = 'aileensoul-a-timeless-platform-for-every-stage-of-your-life' 
                OR blog_slug = '7-solutions-for-start-up-challenges'";

        $query = $this->db->query($sql);
        $result_array = $query->result_array();   
        return $result_array;
    }

    public function create_search_table()
    {
        set_time_limit(0);
        ini_set("memory_limit","512M");
        echo "<pre>";
        $sql = "SELECT * FROM ailee_job_reg WHERE is_delete = '0' AND status = '1'";
        $query = $this->db->query($sql);
        $result_array = $query->result_array();   
        // print_r($result_array);exit;
        foreach ($result_array as $key => $value) {            
            if($value['keyskill'] != "")
            {
                $skill_name = "";
                foreach (explode(',',$value['keyskill']) as $skk => $skv) {
                    if($skv != "")
                    {
                        $s_name = $this->db->get_where('skill', array('skill_id' => $skv, 'status' => 1))->row()->skill;
                        if(trim($s_name) != "")
                        {
                            $skill_name .= $s_name.",";
                        }
                    }
                }
                $value['keyskill_txt'] = trim($skill_name,",");
            }

            if(trim($value['work_job_title']) != "")
            {
                $work_job_title = $this->db->get_where('job_title', array('title_id' => $value['work_job_title'], 'status' => 1))->row()->name;

                $value['work_job_title_txt'] = trim($work_job_title);
            }

            if(trim($value['work_job_industry']) != "")
            {
                $work_job_industry = $this->db->get_where('job_industry', array('industry_id' => $value['work_job_industry'], 'status' => '1','is_delete'=> '0'))->row()->industry_name;

                $value['work_job_industry_txt'] = trim($work_job_industry);
            }

            if(trim($value['country_id']) != "")
            {
                $country_name = $this->db->get_where('countries', array('country_id' => $value['country_id'], 'status' => '1'))->row()->country_name;

                $value['country_name'] = trim($country_name);
            }

            if(trim($value['state_id']) != "")
            {
                $state_name = $this->db->get_where('states', array('state_id' => $value['state_id'], 'status' => '1'))->row()->state_name;

                $value['state_name'] = trim($state_name);
            }

            if(trim($value['city_id']) != "")
            {
                $city_name = $this->db->get_where('cities', array('city_id' => $value['city_id'], 'status' => '1'))->row()->city_name;

                $value['city_name'] = trim($city_name);
            }

            if($value['work_job_city'] != "")
            {
                $w_city_name = "";
                foreach (explode(',',$value['work_job_city']) as $ck => $cv) {
                    if($cv != "")
                    {
                        $c_name = $this->db->get_where('cities', array('city_id' => $cv, 'status' => '1'))->row()->city_name;
                        if(trim($c_name) != "")
                        {
                            $w_city_name .= $c_name.",";
                        }
                    }
                }
                $value['work_job_city_txt'] = trim($w_city_name,",");
            }
            // $this->db->insert('ailee_job_reg_search_tmp', $value);
        }
        echo "Done";
        
    }
}
