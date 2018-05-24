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

    public function get_recommen_candidate_post($userid,$page = "",$limit = '5')
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

        $query = $this->db->query($sql);        
        //echo $this->db->last_query();exit;
        $recommen_candid = $query->result_array();
        return $recommen_candid;
    }

    public function get_recommen_candidate_post_total($userid,$page = "",$limit = '5')
    {

        $sql = "SELECT COUNT(*) as total_record FROM ailee_job_reg LEFT JOIN ailee_job_add_edu ON ailee_job_reg.user_id=ailee_job_add_edu.user_id LEFT JOIN ailee_job_graduation ON ailee_job_reg.user_id=ailee_job_graduation.user_id WHERE ailee_job_reg.job_id IN (
                SELECT DISTINCT j.job_id FROM( SELECT jr.job_id FROM ailee_job_reg jr,ailee_rec_post rp WHERE jr.status = '1' AND jr.is_delete = '0' AND jr.job_step = '10' AND jr.user_id != '".$userid."' AND jr.keyskill REGEXP concat('[[:<:]](', REPLACE(rp.post_skill, ',', '|'), ')[[:>:]]') AND rp.user_id = '".$userid."' AND rp.is_delete = '0' AND rp.status = '1'

                UNION

                SELECT jr.job_id FROM ailee_job_reg jr,ailee_rec_post rp WHERE jr.status = '1' AND jr.is_delete = '0' AND jr.job_step = '10' AND jr.user_id != '".$userid."' AND jr.work_job_title = rp.post_name AND rp.user_id = '".$userid."' AND rp.is_delete = '0' AND rp.status = '1'

                UNION

                SELECT DISTINCT jr.job_id FROM ailee_job_reg jr,ailee_rec_post rp WHERE jr.status = '1' AND jr.is_delete = '0' AND jr.job_step = '10' AND jr.user_id != '".$userid."' AND jr.work_job_industry = rp.industry_type AND rp.user_id = '".$userid."' AND rp.is_delete = '0' AND rp.status = '1'
                ) as j ORDER BY j.job_id DESC

            ) AND ailee_job_reg.is_delete = '0' AND ailee_job_reg.status = '1' AND ailee_job_reg.job_step = '10' ORDER BY job_id DESC";
       
        $query = $this->db->query($sql);        
        //echo $this->db->last_query();exit;
        $recommen_candid_totrec = $query->row_array();
        return $recommen_candid_totrec['total_record'];
    }
   
}
