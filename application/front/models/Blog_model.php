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


    public function get_blog_post($searchword = '',$cateid = '', $page = '', $limit = '', $sory_by='') {

        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;

        $sql_condition = "";
        if($searchword != ""){ 
            $search_split = explode(" ",$searchword);
            foreach ($search_split as $key => $value) {
                $val_con = "%".$value."%";                
                $sql_condition .= " (b.title LIKE '". $val_con ."' OR b.description LIKE '". $val_con ."') AND ";
            }
        }   

        $sql_find_cond = "";
        if($cateid != ""){
            $sql_find_cond = " AND FIND_IN_SET(". $cateid .",blog_category_id) != '0'";
        }

        /*$sql = "SELECT b.*,DATE_FORMAT(b.created_date,'%D %M %Y') as created_date_formatted, GROUP_CONCAT(DISTINCT(bc.name)) as category_name
                    FROM ailee_blog b, ailee_blog_category bc 
                    WHERE b.status = 'publish' AND FIND_IN_SET(bc.id, b.blog_category_id)". $sql_find_cond ." 
                    GROUP BY b.blog_category_id" 
                    . $sql_condition;*/
        $sql = "SELECT b.*,DATE_FORMAT(b.created_date,'%D %M %Y') as created_date_formatted
                    FROM ailee_blog b
                    WHERE b.status = 'publish'";
        if($sql_condition != "")
        {
            $sql .= " AND ".trim($sql_condition," AND ");
        }

        if($sql_find_cond != "")
        {
            $sql .= $sql_find_cond;
        }

        if($sory_by != ""){
            $sql .= " ORDER BY b.created_date DESC";
        }

        if($limit != ""){
            $sql .= " LIMIT $start, $limit";
        }
        // echo $sql;exit;
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function get_blog_post_category_name($blog_id)
    {
        $sql = "SELECT GROUP_CONCAT(DISTINCT(bc.name)) as category_name FROM (ailee_blog b, ailee_blog_category bc) WHERE FIND_IN_SET(bc.id, b.blog_category_id) AND b.status = 'publish' AND b.id = $blog_id GROUP BY b.blog_category_id";
        $query = $this->db->query($sql);
        $result_array = $query->row_array();
        return $result_array['category_name'];
    }

    public function get_blog_cat_list(){
        $sql = "SELECT id,name FROM ailee_blog_category where status = 'publish' ORDER BY name";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function get_blog_details($blog_slug = ""){        
        $sql = "SELECT b.*,DATE_FORMAT(b.created_date,'%D %M %Y') as created_date_formatted, GROUP_CONCAT(DISTINCT(bc.name)) as category_name
            FROM ailee_blog b, ailee_blog_category bc 
            WHERE b.status = 'publish' AND FIND_IN_SET(bc.id, b.blog_category_id) and
            blog_slug = '". $blog_slug ."' 
            GROUP BY b.blog_category_id ORDER BY `id` DESC";
        $query = $this->db->query($sql);
        $result = $query->row_array();
        if(count($result) > 0){
            $sql = "SELECT count(id) as total_comment FROM ailee_blog_comment where status = 'approve' AND blog_id = '". $result['id'] ."'";
            $query = $this->db->query($sql);
            $result['total_comment'] = $query->row()->total_comment;

            $result['social_title'] = urlencode('"' . $result['title'] . '"');
            $result['social_encodeurl'] = urlencode(base_url('blog/' . $result['blog_slug']));
            $result['social_summary'] = urlencode('"' . $result['description'] . '"');
            $result['social_image'] = urlencode(base_url($this->config->item('blog_main_upload_path') . $result['image']));
            $result['social_url'] = base_url('blog/' . $result['blog_slug']);

            $sql = "SELECT b.*,DATE_FORMAT(b.created_date,'%D %M %Y') as created_date_formatted, GROUP_CONCAT(DISTINCT(bc.name)) as category_name
                FROM ailee_blog b, ailee_blog_category bc 
                WHERE b.status = 'publish' AND FIND_IN_SET(bc.id, b.blog_category_id) and
                b.id IN (". $result['blog_related_id'] .") 
                GROUP BY b.blog_category_id ORDER BY b.id DESC";
            $query = $this->db->query($sql);
            $result['related_post'] = $query->result_array();
            foreach ($result['related_post'] as $key => $value) {
                $result['related_post'][$key]['blog_category_name'] = explode(',', $value['category_name']);
            }
            $sql = "SELECT *, DATE_FORMAT(comment_date,'%D %M %Y') as created_date_formatted FROM ailee_blog_comment WHERE status = 'approve' AND blog_id = ". $result['id'] ." ORDER BY id DESC LIMIT 3";
            $query = $this->db->query($sql);
            $result['all_comment'] = $query->result_array();

            $result['blog_category_name'] = explode(',', $result['category_name']);
        }
        return $result;
    }

    public function get_loadmore_comment($blog_id,$page,$limit)
    {
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;
        
        $sql = "SELECT *, DATE_FORMAT(comment_date,'%D %M %Y') as created_date_formatted FROM ailee_blog_comment WHERE status = 'approve' AND blog_id = ". $blog_id ." ORDER BY id DESC LIMIT $start,$limit";        
        $query = $this->db->query($sql);
        $all_comment = $query->result_array();
        return $all_comment;
    }

}
