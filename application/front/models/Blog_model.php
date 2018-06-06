<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Blog_Model extends CI_Model {

    public static $category = "blog_category";
    public static $blog = "blog";

    public function CategoryOnly() {
        $this->db->where('parent_id', '0');
        $results = $this->db->get('category')->result();
        return $results;
    }

    public function Blogdetail($is_not = null) {
        if (isset($is_not) && $is_not != "" && $is_not != null) {
            $this->db->where('blog_id', $is_not);
        }
        $get = $this->db->get('blog');
        return $get->result();
    }

    public function Blogcount($is_not = null) {
        if (isset($is_not) && $is_not != "" && $is_not != null) {
            $this->db->where('blog_id', $is_not);
            $this->db->where('approve_status', '1');
        }
        $get = $this->db->get('blog_review');
        return $get->result();
    }

    public function AllBlog() {

        $get = $this->db->get('blog');
        return $get->result();
    }

    public function Oldblog() {
        $this->db->limit($limit = '5', $offset = "0");
        $this->db->order_by('blog_id', "desc");
        $get = $this->db->get('blog');
        return $get->result();
    }

    public function Oldblogdetail($is_not = null) {
        $this->db->limit($limit = '5', $offset = "0");
        $this->db->order_by('blog_id', "desc");
        if (isset($is_not) && $is_not != "" && $is_not != null) {
            $this->db->where('blog_id !=', $is_not);
        }
        $get = $this->db->get('blog');
        return $get->result();
    }


    public function get_blog_post($searchword = '',$cateid = '', $start = '', $perpage = '', $sory_by='') {
        $sql_condition = "";
        if($searchword != ""){ 
            $search_split = explode(" ",$searchword);
            foreach ($search_split as $key => $value) {
                $val_con = "%".$val."%";
                $sql_condition = ($sql_condition == "") ? " AND" : " OR";
                $sql_condition .= " (b.title LIKE '". $val_con ."') OR (b.description LIKE '". $val_con ."')";
            }
        }   

        $sql_find_cond = "";
        if($cateid != ""){
            $sql_find_cond = " AND FIND_IN_SET(". $cateid .",blog_category_id) != '0'";
        }

        $sql = "SELECT b.*,DATE_FORMAT(b.created_date,'%D %M %Y') as created_date_formatted, GROUP_CONCAT(DISTINCT(bc.name)) as category_name
                    FROM ailee_blog b, ailee_blog_category bc 
                    WHERE b.status = 'publish' AND FIND_IN_SET(bc.id, b.blog_category_id)". $sql_find_cond ." 
                    GROUP BY b.blog_category_id" 
                    . $sql_condition;

        if($sory_by != ""){
            $sql .= " ORDER BY b.created_date DESC";
        }

        if($perpage != ""){
            $sql .= " LIMIT ". $start . "," . $perpage;
        }
        // echo $sql;
        // exit;
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

}
