<?php

class Common extends CI_Model {

    // insert database
    function insert_data($data, $tablename) {
        if ($this->db->insert($tablename, $data)) {
            return true;
        } else {
            return false;
        }
    }

    // insert database
    function insert_data_getid($data, $tablename) {
        if ($this->db->insert($tablename, $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    // update database

    function update_data($data, $tablename, $columnname, $columnid) {

        $this->db->where($columnname, $columnid);

        if ($this->db->update($tablename, $data)) {

            return true;
        } else {

            return false;
        }
    }

    // select data using colum id

    function select_data_by_id($tablename, $columnname, $columnid, $data = '*') {

        if ($data != '*')
            $this->db->select($data);



        $this->db->where($columnname, $columnid);

        $query = $this->db->get($tablename);

        if ($query->num_rows() > 0) {

            return $query->result_array();
        } else {

            return array();
        }
    }

    function select_data_by_id_row($tablename, $columnname, $columnid, $data = '*', $join_str = array()) {

        if ($data != '*')
            $this->db->select($data);



        if (!empty($join_str)) {

            foreach ($join_str as $join) {

                if ($join['join_type'] == '') {

                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id']);
                } else {

                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id'], $join['join_type']);
                }
            }
        }

        $this->db->where($columnname, $columnid);

        $query = $this->db->get($tablename);

        if ($query->num_rows() > 0) {

            return $query->row_array();
        } else {

            return array();
        }
    }

    // select data using multiple conditions

    function select_data_by_condition($tablename, $contition_array = array(), $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '') {

        $this->db->simple_query('SET SESSION group_concat_max_len=15000');
        $this->db->select($data);

        if (!empty($join_str)) {

            // pre($join_str);

            foreach ($join_str as $join) {

                if ($join['join_type'] == '') {

                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id']);
                } else {

                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id'], $join['join_type']);
                }
            }
        }



        $this->db->where($contition_array);

        if (!empty($having)) {

            $this->db->having($having);
        }

        //Setting Limit for Paging

        if ($limit != '' && $offset == 0) {

            $this->db->limit($limit);
        } else if ($limit != '' && $offset != 0) {

            $this->db->limit($limit, $offset);
        }

        //order by query

        if ($sortby != '' && $orderby != '') {

            $this->db->order_by($sortby, $orderby);
        }



        $this->db->group_by($groupby);

        $query = $this->db->get($tablename);



        if ($query->num_rows() > 0) {

            return $query->result_array();
        } else {

            return array();
        }
    }

    // select data using multiple conditions and search keyword

    function select_data_by_search($tablename, $search_condition, $contition_array = array(), $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '') {

        $this->db->select($data);

        if (!empty($join_str)) {

            foreach ($join_str as $join) {

                $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id']);
            }
        }





        $this->db->where($contition_array);

        $this->db->where($search_condition);

        //Setting Limit for Paging

        if ($limit != '' && $offset == 0) {

            $this->db->limit($limit);
        } else if ($limit != '' && $offset != 0) {

            $this->db->limit($limit, $offset);
        }

        //order by query

        if ($sortby != '' && $orderby != '') {

            $this->db->order_by($sortby, $orderby);
        }

        $this->db->group_by($groupby);

        $query = $this->db->get($tablename);

        if ($query->num_rows() > 0) {

            return $query->result_array();
        } else {

            return array();
        }
    }

    // delete data

    function delete_data($tablename, $columnname, $columnid) {

        $this->db->where($columnname, $columnid);

        if ($this->db->delete($tablename)) {

            return true;
        } else {

            return false;
        }
    }

    // check unique avaliblity

    function check_unique_avalibility($tablename, $columname1, $columnid1_value, $columname2, $columnid2_value, $condition_array = array()) {

        // if edit than $columnid2_value use



        if ($columnid2_value != '') {

            $this->db->where($columname2 . " !=", $columnid2_value); //in this line make space between " and !=
        }



        if (!empty($condition_array)) {

            $this->db->where($condition_array);
        }



        $this->db->where($columname1, $columnid1_value);

        $query = $this->db->get($tablename);

        if ($query->num_rows() > 0) {

            return false;
        } else {

            return true;
        }
    }

    //get all record 

    function get_all_record($tablename, $data = '*', $sortby = '', $orderby = '') {

        $this->db->select($data);

        $this->db->from($tablename);

        $this->db->where('status', 'Enable');

        if ($sortby != '' && $orderby != "") {

            $this->db->order_by($sortby, $orderby);
        }

        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            return $query->result_array();
        } else {

            return array();
        }
    }

    //table records count

    function get_count_of_table($table) {

        $query = $this->db->count_all($table);

        return $query;
    }

    //Function for getting all Settings

    function get_all_setting($sortby = 'settingid', $orderby = 'ASC') {

        //Ordering Data

        $this->db->order_by($sortby, $orderby);



        //Executing Query

        $query = $this->db->get('setting');



        if ($query->num_rows() > 0) {

            return $query->result_array();
        } else {

            return array();
        }
    }

    //Getting setting value for editing By id

    function get_setting_byid($intid) {

        $query = $this->db->get_where('setting', array('settingid' => $intid));



        if ($query->num_rows() > 0) {

            return $query->result_array();
        } else {

            return array();
        }
    }

    //Getting setting value By id

    function get_setting_value($id) {

        $query = $this->db->get_where('setting', array('settingid' => $id,));

        if ($query->num_rows() > 0) {

            $result = $query->result_array();

            return nl2br(($result[0]['settingfieldvalue']));
        } else {

            return false;
        }
    }

    //Getting setting field name By id

    function get_setting_fieldname($intid) {

        $query = $this->db->get_where('setting', array('settingid' => $intid));



        if ($query->num_rows() > 0) {

            $result = $query->result_array();

            return ($result[0]['settingfieldname']);
        } else {

            return false;
        }
    }

    function get_data_csv($tablename = '') {

        $query = $this->db->get($tablename);

        if ($query->num_rows() > 0) {

            return $query->result_array();
        } else {

            return FALSE;
        }
    }

    function insert_csv($tablename, $data) {

        $this->db->insert($tablename, $data);
    }

    function select_data_in($tablename, $in_field, $array1, $data = '*') {

        $this->db->select($data);

        $this->db->where_in($in_field, $array1);

        $query = $this->db->get($tablename);



        if ($query->num_rows() > 0) {

            return $query->result_array();
        } else {

            return array();
        }
    }

    function twoDto1D($tarr) {

        $oned_arr = array();

        foreach ($tarr as $arr) {

            foreach ($arr as $value1) {

                array_push($oned_arr, $value1);
            }
        }



        if (!empty($oned_arr)) {

            return $oned_arr;
        } else {

            return array();
        }
    }

    function candidate_all_data() {

        $this->db->select('*');

        $this->db->from('candidate c');

        $this->db->join('candidate_detail cd', 'c.candidate_id = cd.candidate_id', 'left');

        $this->db->join('candidate_qualification cq', 'c.candidate_id = cq.candidate_id', 'left');

        $this->db->join('candidate_speciality csp', 'c.candidate_id = csp.candidate_id', 'left');

        $this->db->join('candidate_subscription csu', 'c.candidate_id = csu.candidate_id', 'left');

        $this->db->join('candidate_work cw', 'c.candidate_id = cw.candidate_id', 'left');

        $this->db->group_by('c.candidate_id');

        $query = $this->db->get();

        echo $this->db->last_query();

        if ($query->num_rows() > 0) {

            return $query->result_array();
        } else {

            return array();
        }
    }

    function update_data_by_condition($tablename, $contition_array = array(), $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '') {



        //print_r($join_str);
        //die();



        $this->db->select($data);



        if (!empty($join_str)) {

            // pre($join_str);

            foreach ($join_str as $join) {

                if ($join['join_type'] == '') {

                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id']);
                } else {

                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id'], $join['join_type']);
                }
            }
        }



        $this->db->where($contition_array);

        if (!empty($having)) {

            $this->db->having($having);
        }

        //Setting Limit for Paging

        if ($limit != '' && $offset == 0) {

            $this->db->limit($limit);
        } else if ($limit != '' && $offset != 0) {

            $this->db->limit($limit, $offset);
        }

        //order by query

        if ($sortby != '' && $orderby != '') {

            $this->db->order_by($sortby, $orderby);
        }



        $this->db->group_by($groupby);

        $query = $this->db->get($tablename);



        if ($query->num_rows() > 0) {

            return $query->result_array();
        } else {

            return array();
        }
    }

// select data using colum id
    function select_database_id($tablename, $columnname, $columnid, $data = '*', $condition_array = array()) {
        $this->db->select($data);
        $this->db->where($columnname, $columnid);
        if (!empty($condition_array)) {
            $this->db->where($condition_array);
        }
        $query = $this->db->get($tablename);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    function getExtension($str) {
        $i = strrpos($str, ".");
        if (!$i) {
            return "";
        }

        $l = strlen($str) - $i;
        $ext = substr($str, $i + 1, $l);
        return $ext;
    }

    public function time_elapsed_string($datetime, $full = false) {
        $this->load->helper('date');
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full)
            $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }


    // falguni cahnges function start
    function make_links($text, $class='content_link', $target='_blank'){

        $text= preg_replace("/(^|[\n ])([\w]*?)([\w]*?:\/\/[\w]+[^ \,\"\n\r\t<]*)/is", "$1$2<a href=\"$3\"  target=\"$target\">$3</a>", $text);  
        $text= preg_replace("/(^|[\n ])([\w]*?)((www)\.[^ \,\"\t\n\r<]*)/is", "$1$2<a href=\"http://$3\"  target=\"$target\">$3</a>", $text);
                $text= preg_replace("/(^|[\n ])([\w]*?)((ftp)\.[^ \,\"\t\n\r<]*)/is", "$1$2<a href=\"ftp://$3\"  target=\"$target\">$3</a>", $text);  
        $text= preg_replace("/(^|[\n ])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+)+)/i", "$1<a href=\"mailto:$2@$3\" >$2@$3</a>", $text);  
        return($text);  

    }

    //old but latest
    // falguni changes before function 
     // function make_links($text, $class='content_link', $target='_blank'){ 
     //     return preg_replace('!((http\:\/\/|ftp\:\/\/|https\:\/\/)|www\.)([-a-zA-Z?-??-?0-9\~\!\@\#\$\%\^\&\*\(\)_\-\=\+\\\/\?\.\:\;\'\,]*)?!ism','<a href="//$3" class="' . $class . '" target="'.$target.'">$1$3</a>', 
     //         $text);
     // }
// very old     
//    function make_links($text, $class = 'content_link', $target = '_blank') {
//        return preg_replace('!((http:\:\/\/|ftp\:\/\/|https:\:\/\/)|www\.)([-a-zA-Z?-??-?0-9\~\!\@\#\$\%\^\&\*\(\)_\-\=\+\\\/\?\.\:\;\'\,]*)?!ism', '<a href="//$1$3" class="' . $class . '" target="' . $target . '">$1$3</a>', $text);
//    }

//    function make_links($comment) {
//        return $string = auto_link($comment, 'both', TRUE);
//    }

    function rec_profile_links($text, $class = 'content_link', $target = '_blank') {
        return preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Z?-??-?()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1" class="' . $class . '" target="' . $target . '">$1</a>', $text);
    }
   // for remove unexpected special character from slug 
  public function clean($string) { 
      
   $string = str_replace(' ', '-', $string);  // Replaces all spaces with hyphens.
   $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // replace double --- in single -
  
   return preg_replace('/-+/', '-', $string); // Removes special chars.
}

    function get_search_results($searchword = '',$searchplace = ''){
        $sql_searchword = '';
        $sql_searchplace = '';
        $sql_search = '';
        $sql_place = '';
        $sql_final_search = '';

        $sql_skill = "";
        $sql_place = "";
        $sql_category = "";
        $sql_search_query = "";
        if($searchword != ''){
            foreach (explode(",", $searchword) as $key => $value) {
                if($value != "")
                {
                    $search_val = "%". $value . "%";
                    $sql_skill .= "skill like '". $search_val ."' OR ";
                    $sql_category .= "category_name LIKE '". $search_val ."' OR ";
                } 
            }
            if($sql_skill != ""){
                $sql_skill = "fpr.freelancer_post_area IN 
                                (select skill_id from ailee_skill where ". trim($sql_skill," OR ") . ")";
            }
            if($sql_category != ""){
                $sql_category = "fpr.freelancer_post_area IN 
                                (SELECT category_id FROM ailee_category WHERE ". trim($sql_category," OR ") . ")";
            }

            if($sql_skill != "" && $sql_category != ""){
                $sql_search_query = " AND (".$sql_skill . " OR " .$sql_category .")";
            }
        }
        if($searchplace != ""){
            foreach (explode(",", $searchplace) as $key => $value) {
                if($value != "")
                {
                    $sql_searchplace .= ($sql_searchplace == "") ? "AND (" : " OR";
                    $sql_searchplace .= " city_name like '". $sql_searchplace ."'";
                }
            }
            $sql_searchplace .= ($sql_searchplace == "") ? "" : ")";
        }
        if($searchword != "" && $searchplace !=""){
            $sql_final_search = $sql_search_query . $sql_searchplace;
        }else if($searchword != ""){
            $sql_final_search = $sql_search_query;
        }else{
            $sql_final_search = $sql_searchplace;
        }
        $sql = "SELECT fpr.freelancer_post_fullname,fpr.freelancer_post_username,fpr.freelancer_post_city,
            fpr.freelancer_post_country,fpr.freelancer_post_area,fpr.freelancer_post_field,
            fpr.freelancer_post_skill_description,fpr.freelancer_post_hourly,fpr.freelancer_post_ratestate,
            fpr.freelancer_post_fixed_rate,fpr.freelancer_post_work_hour,fpr.user_id,
            fpr.freelancer_post_user_image,fpr.designation,fpr.freelancer_post_otherskill,fpr.freelancer_post_exp_month,
            fpr.freelancer_post_exp_year,fpr.freelancer_apply_slug,fpr.freelancer_post_reg_id,fp.created_date
            FROM ailee_freelancer_post_reg fpr 
            LEFT JOIN ailee_freelancer_post as fp ON fp.user_id = fpr.user_id
            LEFT JOIN ailee_cities c on c.city_id = freelancer_post_city
            WHERE fpr.user_id != 103 AND fpr.is_delete = '0' AND fpr.status = '1'" .$sql_final_search;
        // echo $sql;
        // exit;
        $query = $this->db->query($sql);
        $result = $query->row_array();
        return $result;
    }

}
