<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Scripts extends CI_Controller {
	
	public function index()
	{
		redirect(base_url());
	}

	public function get_lastest_skill_post()
    {
        if($_SERVER['REMOTE_ADDR'] == '203.88.134.32' || $_SERVER['REMOTE_ADDR'] == '::1'):
            $this->db->select('GROUP_CONCAT(CONCAT(post_skill)) AS post_skill')->from('rec_post');        
            $result = $this->db->get();
            $row = $result->first_row();        
            $res_arr = array();
            $skill = array();
            $row1 = explode(",", $row->post_skill);
            $row1 = array_map("unserialize", array_unique(array_map("serialize", $row1)));
            sort($row1);
            foreach($row1 as $k=>$v)
            {
                //echo $v."<br>";
                if($v != "Array")
                {
                    $sql = "SELECT COUNT(rp.post_id) AS count,s.skill FROM ailee_rec_post rp LEFT JOIN ailee_skill as s ON s.skill_id = rp.post_skill WHERE rp.post_skill IN (".$v.")";
                    $result = $this->db->query($sql); 
                    //print_r($result->first_row());
                    // echo $result->first_row()->count."<br>";
                    if($result->first_row()->count > 0)
                    {
                        $res_arr[$k]['post_count'] = $result->first_row()->count;
                        $res_arr[$k]['skill'] = $v;
                        $res_arr[$k]['skill_name'] = $result->first_row()->skill;
                        $skill[$k] = $result->first_row()->count;
                    }
                }

            }
            array_multisort($skill, SORT_DESC, $res_arr);
            echo "<table><tr><th>Post Count</th>";
            echo "<th>Skill Id</th>";
            echo "<th>Skill Name</th>";
            echo "</tr>";
            foreach($res_arr as $_res_arr)
            {
                echo "<tr>";
                echo "<td>".$_res_arr['post_count']."</td>";
                echo "<td>".$_res_arr['skill']."</td>";
                echo "<td>".$_res_arr['skill_name']."</td>";
                echo "</tr>";
            }
        else:
            redirect(base_url());
        endif;
    }

    public function get_lastest_city_post()
    {
        if($_SERVER['REMOTE_ADDR'] == '203.88.134.32' || $_SERVER['REMOTE_ADDR'] == '::1'):
            echo "<table><tr><th>Post Count</th>";
            echo "<th>City Id</th>";
            echo "<th>City Name</th>";
            echo "</tr>";

            $sql = "SELECT COUNT(rp.`post_id`) AS post_count,c.`city_id`,c.`city_name` FROM ailee_rec_post rp LEFT JOIN ailee_cities c ON c.`city_id` = rp.`city` GROUP BY rp.`city` ORDER BY post_count DESC";
            $res = $this->db->query($sql);
            foreach($res->result() as $_row)
            {
                if($_row->city_id != 0)
                {                
                echo "<tr>";
                echo "<td>".$_row->post_count."</td>";
                echo "<td>".$_row->city_id."</td>";
                echo "<td>".$_row->city_name."</td>";
                echo "</tr>";
                }
            }
        else:
            redirect(base_url());
        endif;
    }

    public function get_lastest_jobtitle_post()
    {
        if($_SERVER['REMOTE_ADDR'] == '203.88.134.32' || $_SERVER['REMOTE_ADDR'] == ':00:1'):
            echo "<table><tr><th>Post Count</th>";
            echo "<th>Job Id</th>";
            echo "<th>Job Name</th>";
            echo "</tr>";

            $sql = "SELECT COUNT(rp.`post_id`) AS post_count,jt.`title_id`,jt.`name` FROM ailee_rec_post rp LEFT JOIN ailee_job_title jt ON jt.`title_id` = rp.`post_name` GROUP BY rp.`post_name` ORDER BY post_count DESC";
            $res = $this->db->query($sql);            
            foreach($res->result() as $_row)
            {
                if($_row->title_id != NULL)
                {                
                echo "<tr>";
                echo "<td>".$_row->post_count."</td>";
                echo "<td>".$_row->title_id."</td>";
                echo "<td>".$_row->name."</td>";
                echo "</tr>";
                }
            }
        else:
            redirect(base_url(),"refresh");
        endif;
    }
}
