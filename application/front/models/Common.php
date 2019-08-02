<?php

class Common extends CI_Model {

    public function __construct() {
        $this->db->reconnect();
    }

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

        /*$text= preg_replace("/(^|[\n ])([\w]*?)([\w]*?:\/\/[\w]+[^ \,\"\n\r\t<]*)/is", "$1$2<a href=\"$3\"  target=\"$target\">$3</a>", $text);  
        $text= preg_replace("/(^|[\n ])([\w]*?)((www)\.[^ \,\"\t\n\r<]*)/is", "$1$2<a href=\"http://$3\"  target=\"$target\">$3</a>", $text);
                $text= preg_replace("/(^|[\n ])([\w]*?)((ftp)\.[^ \,\"\t\n\r<]*)/is", "$1$2<a href=\"ftp://$3\"  target=\"$target\">$3</a>", $text);  
        $text= preg_replace("/(^|[\n ])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+)+)/i", "$1<a href=\"mailto:$2@$3\" >$2@$3</a>", $text);*/

        /*$url = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';   
        $string= preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $text);*/

        # $reg = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,}(\/\S*)?/'; 
        $reg = '/\b(?<!=")(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[A-Z0-9+&@#\/%=~_|](?!.*".*>)(?!.*<\/a>)/i'; 
        $text = preg_replace($reg, '<a href="$0" target="_blank" title="$0">$0</a>', $text);

        //Catch all links without protocol
        /*$reg2 = '/(?<=\s|\A)([0-9a-zA-Z\-\.]+\.[a-zA-Z0-9\/]{2,})(?=\s|$|\,|\.)/';
        $text = preg_replace($reg2, '<a href="//$0" target="_blank" title="$0">$0</a>', $text);*/

        //Catch all emails
        $emailRegex = '/(\S+\@\S+\.\S+)/';
        $text = preg_replace($emailRegex, '<a href="mailto:$1" target="_blank" title="$1">$1</a>', $text);
        $text = nl2br($text);

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

    function get_search_results($searchword = '',$searchplace = '',$filter_data =array(), $limitstart = 0, $limit = ''){

        // Apply filter if any
        // Apply condition for filter
        $userid = $this->session->userdata('aileenuser');
        $sql_filter = "";
        if(isset($filter_data['city_id']) && $filter_data['city_id'] != ""){
            $sql_filter .= " OR fpr.freelancer_post_city IN (". $filter_data['city_id'] .") AND fpr.freelancer_post_city > 0";
        }

        if(isset($filter_data['category_id']) && $filter_data['category_id'] != ""){
            $sql_filter .= " OR fpr.freelancer_post_field IN (". $filter_data['category_id'] .") AND fpr.freelancer_post_field > 0";
        }

        if(isset($filter_data['skill_id']) && $filter_data['skill_id'] != ""){
            $sql_filter .= " OR fpr.freelancer_post_area IN (". $filter_data['skill_id'] .") AND fpr.freelancer_post_area > 0";
        }
        $experience_id = $filter_data['experience_id'];
        if($experience_id != ""){
            if($experience_id == 6)
            {
                $sql_filter .= " AND (fpr.freelancer_post_exp_year IS NOT NULL OR fpr.freelancer_post_exp_year > ". ($experience_id - 1) .")";
            }
            else if($experience_id == 1){
                $sql_filter .= " AND (fpr.freelancer_post_exp_year IS NULL OR fpr.freelancer_post_exp_year >= ". ($experience_id - 1) ." AND fpr.freelancer_post_exp_year <= ". $experience_id .")";
            } 
            else{
                $sql_filter .= " AND fpr.freelancer_post_exp_year >= ". ($experience_id - 1) ." AND fpr.freelancer_post_exp_year <= ". $experience_id;
            }
        }

        // Search query
        $sql_skill = "";
        $sql_category = "";
        $sql_search_query = "";
        $sql_final_search = '';
        if($searchword != ''){
            foreach (explode(",", $searchword) as $key => $value) {
                if($value != "")
                {
                    $search_val = "%". $value . "%";
                    $sql_search_query .= ($sql_search_query == "") ? " AND (" : " OR ";
                    $sql_search_query .= "fpr.freelancer_post_area_txt LIKE '". $search_val ."' OR ";
                    $sql_search_query .= "fpr.freelancer_post_field_txt LIKE '". $search_val ."'";
                } 
            }
            // $sql_search_query = trim($sql_search_query," OR ");
            $sql_search_query .= ($sql_search_query == "") ? "" : ")";
        }
        if($searchplace != ""){
            foreach (explode(",", $searchplace) as $key => $value) {
                if($value != "")
                {
                    $search_val = "%". $value . "%";
                    $sql_searchplace .= ($sql_searchplace == "") ? " AND (" : " OR";
                    $sql_searchplace .= " fpr.city_name LIKE '". $search_val ."' OR fpr.state_name LIKE '". $search_val ."'";
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
        $sql = "SELECT fpr.freelancer_post_reg_id,fpr.freelancer_post_fullname,fpr.freelancer_post_username,fpr.freelancer_post_city,fpr.city_name,fpr.state_name,fpr.country_name, fpr.freelancer_post_country,fpr.freelancer_post_area,fpr.freelancer_post_area_txt as skills,fpr.freelancer_post_field,fpr.freelancer_post_field_txt as category_name, fpr.freelancer_post_skill_description,fpr.freelancer_post_hourly,fpr.freelancer_post_ratestate, fpr.freelancer_post_fixed_rate,fpr.freelancer_post_work_hour,fpr.user_id, fpr.freelancer_post_user_image,fpr.designation,fpr.freelancer_post_otherskill,fpr.freelancer_post_exp_month, fpr.freelancer_post_exp_year,fpr.freelancer_apply_slug,fpr.created_date, fpr.free_post_step
            FROM ailee_freelancer_post_reg_search_tmp fpr
            WHERE fpr.user_id != '".$userid."' AND fpr.is_delete = '0' AND fpr.status = '1' AND fpr.free_post_step = '7'" 
            . $sql_final_search . $sql_filter;
        $sql .= " ORDER BY fpr.freelancer_post_reg_id DESC ";
        if($limit != ""){
            $sql .= " LIMIT $limitstart , $limit";
        }
        // echo $sql;exit;
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    function get_search_results_total($searchword = '',$searchplace = '',$filter_data =array()){

        // Apply filter if any
        $sql_filter = "";
        if(isset($filter_data['city_id']) && $filter_data['city_id'] != ""){
            $sql_filter .= " AND fpr.freelancer_post_city IN (". $filter_data['city_id'] .") AND fpr.freelancer_post_city > 0";
        }

        if(isset($filter_data['category_id']) && $filter_data['category_id'] != ""){
            $sql_filter .= " AND fpr.freelancer_post_field IN (". $filter_data['category_id'] .") AND fpr.freelancer_post_field > 0";
        }

        if(isset($filter_data['skill_id']) && $filter_data['skill_id'] != ""){
            $sql_filter .= " AND fpr.freelancer_post_area IN (". $filter_data['skill_id'] .") AND fpr.freelancer_post_area > 0";
        }
        $experience_id = $filter_data['experience_id'];
        if($experience_id != ""){
            if($experience_id == 6)
            {
                $sql_filter .= " AND (fpr.freelancer_post_exp_year IS NOT NULL OR fpr.freelancer_post_exp_year > ". $experience_id .")";
            }
            else if($experience_id == 1){
                $sql_filter .= " AND (fpr.freelancer_post_exp_year IS NULL OR fpr.freelancer_post_exp_year >= ". ($experience_id - 1) ." AND fpr.freelancer_post_exp_year <= ". $experience_id .")";
            } 
            else{
                $sql_filter .= " AND fpr.freelancer_post_exp_year >= ". ($experience_id - 1) ." AND fpr.freelancer_post_exp_year <= ". $experience_id;
            }
        }

        // Search query
        $sql_skill = "";
        $sql_category = "";
        $sql_search_query = "";
        $sql_final_search = '';
        if($searchword != ''){
            foreach (explode(",", $searchword) as $key => $value) {
                if($value != "")
                {
                    $search_val = "%". $value . "%";
                    $sql_search_query .= ($sql_search_query == "") ? " AND (" : " OR ";
                    $sql_search_query .= "fpr.freelancer_post_area_txt LIKE '". $search_val ."' OR ";
                    $sql_search_query .= "fpr.freelancer_post_field_txt LIKE '". $search_val ."'";
                } 
            }
            // $sql_search_query = trim($sql_search_query," OR ");
            $sql_search_query .= ($sql_search_query == "") ? "" : ")";
        }
        if($searchplace != ""){
            foreach (explode(",", $searchplace) as $key => $value) {
                if($value != "")
                {
                    $search_val = "%". $value . "%";
                    $sql_searchplace .= ($sql_searchplace == "") ? " AND (" : " OR";
                    $sql_searchplace .= " fpr.city_name LIKE '". $search_val ."' OR fpr.state_name LIKE '". $search_val ."'";
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
        $sql = "SELECT count(*) as total_record
            FROM ailee_freelancer_post_reg_search_tmp fpr
            WHERE fpr.user_id != '".$userid."' AND fpr.is_delete = '0' AND fpr.status = '1' AND fpr.free_post_step = '7'" 
            . $sql_final_search . $sql_filter;        
        $query = $this->db->query($sql);
        $result = $query->row_array();
        return $result;
    }

    // CREATE SLUG START
    public function set_slug($slugname, $filedname, $tablename, $notin_id = array()) {
        $slugname = $oldslugname = $this->create_slug($slugname);
        $i = 1;
        while ($this->compare_slug($slugname, $filedname, $tablename, $notin_id) > 0) {
            $slugname = $oldslugname . '-' . $i;
            $i++;
        }return $slugname;
    }

     public function set_city_slug($slugname, $filedname, $tablename, $notin_id = array()) {
        $slugname = $oldslugname = $this->clean($slugname);
        $i = 1;
        while ($this->compare_slug($slugname, $filedname, $tablename, $notin_id) > 0) {
            $slugname = $oldslugname . '-' . $i;
            $i++;
        }return $slugname;
    }

    public function compare_slug($slugname, $filedname, $tablename, $notin_id = array()) {
        $this->db->where($filedname, $slugname);
        if (isset($notin_id) && $notin_id != "" && count($notin_id) > 0 && !empty($notin_id)) {
            $this->db->where($notin_id);
        }
        $num_rows = $this->db->count_all_results($tablename);
        return $num_rows;
    }

    public function create_slug($string) {
        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower(stripslashes($string)));
        $slug = preg_replace('/[-]+/', '-', $slug);
        $slug = trim($slug, '-');
        return $slug;
    }
    // CREATE SLUG END

    //GENERATE ENCRYPT KEY START
    public function generate_encrypt_key($length = '16')
    {
        $cipher = $length.' byte key';
        $key = bin2hex( $this->encryption->create_key($length));
        $query = $this->db->get_where('user', array('encrypt_key' => $key));
        if ($query->num_rows() > 0) {
            $this->generate_encrypt_key(16);
        }
        return $key;
    }
    //GENERATE ENCRYPT KEY END

    //GENERATE ENCRYPT KEY START
    public function generate_token($length = '16')
    {
        $cipher = $length.' byte key';
        $key = bin2hex( $this->encryption->create_key($length));
        $query = $this->db->get_where('user', array('token' => $key));
        if ($query->num_rows() > 0) {
            $this->generate_encrypt_key(16);
        }
        return $key;
    }
    //GENERATE ENCRYPT KEY END

    //GENERATE ENCRYPT KEY START
    public function generate_article_unique_key($length = '16')
    {
        $cipher = $length.' byte key';
        $key = bin2hex( $this->encryption->create_key($length));
        $query = $this->db->get_where('post_article', array('unique_key' => $key));
        if ($query->num_rows() > 0) {
            $this->generate_article_unique_key(16);
        }
        return $key;
    }
    //GENERATE ENCRYPT KEY END

    public function get_post_count($user_id = "")
    {
        $this->db->select("COUNT(up.id) as post_count")->from("user_post up");
        $this->db->where('up.user_id',$user_id);
        $getDeleteUserPost = "SELECT post_id FROM ailee_user_post_delete WHERE user_id = $user_id";
        $this->db->where('up.id NOT IN (' . $getDeleteUserPost . ')');        
        $this->db->where('up.status', 'publish');
        $sql = "(up.post_for = 'opportunity' OR up.post_for = 'article' OR up.post_for = 'simple' OR up.post_for = 'share')";
        $this->db->where($sql);        
        $this->db->where('up.user_type', '1');
        $this->db->where('up.is_delete', '0');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array['post_count'];
    }

    public function getContactCount($user_id = '', $select_data = '') {

        $where = "((from_id = '" . $user_id . "' OR to_id = '" . $user_id . "'))";

        $this->db->select("count(*) as total")->from("user_contact  uc");
        $this->db->where('uc.status', 'confirm');
        $this->db->where($where);
        $this->db->order_by("uc.id", "DESC");
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    public function getFollowingCount($user_id = '', $select_data = '') {
        $where = "(uf.follow_from = '" . $user_id . "')";
        $this->db->select("count(*) as total")->from("user_follow  uf");
        $this->db->join('user_login ul', 'ul.user_id = uf.follow_to', 'left');
        $this->db->where('uf.status', '1');
        $this->db->where($where);
        $this->db->where('ul.status', '1');
        $this->db->where('ul.is_delete', '0');
        $this->db->order_by("uf.id", "DESC");
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    public function getFollowerCount($user_id = '', $select_data = '') {
        $where = "((uf.follow_to = '" . $user_id . "'))";
        $this->db->select("count(*) as total")->from("user_follow  uf");
        $this->db->where('uf.status', '1');
        $this->db->where('uf.follow_type', '1');
        $this->db->where($where);
        $this->db->order_by("uf.id", "DESC");
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    public function userQuestionsCount($user_id = '')
    {

        $this->db->select("COUNT(up.id) as post_count")->from("user_post up");
        $getDeleteUserPost = "SELECT post_id FROM ailee_user_post_delete WHERE user_id = $user_id";// $this->deletePostUser($user_id);
        $this->db->where('up.id NOT IN ('.$getDeleteUserPost.')');        
        $this->db->where('up.user_id', $user_id);
        $this->db->where('up.status', 'publish');
        $this->db->where('up.post_for', 'question');
        $this->db->where('up.is_delete', '0');
        $query = $this->db->get();        
        $result_array = $query->row_array();        
        return $result_array['post_count'];
    }

    public function userSavedPostCount($user_id = '')
    {

        $this->db->select("COUNT(ups.save_post_id) as saved_post_count")->from("user_post_save ups");
        $getDeleteUserPost = "SELECT post_id FROM ailee_user_post_delete WHERE user_id = $user_id";// $this->deletePostUser($user_id);
        $this->db->where('ups.save_post_id NOT IN ('.$getDeleteUserPost.')');        
        $this->db->where('ups.user_id', $user_id);
        $this->db->where('ups.status', '1');        
        $query = $this->db->get();        
        $result_array = $query->row_array();        
        return $result_array['saved_post_count'];
    }

    public function change_number_long_format_to_short($n)
    {
        // first strip any formatting;        
        $n = (0+str_replace(",","",$n));        
        // is this a number?
        if(!is_numeric($n)) return 0;        
        // now filter it;
        if($n>1000000000000) return round(($n/1000000000000),1).'T';
        else if($n>1000000000) return round(($n/1000000000),1).'B';
        else if($n>1000000) return round(($n/1000000),1).'M';
        else if($n>1000) return round(($n/1000),1).'k';        
        return number_format($n);
    }

    public function get_all_counter($user_id = "")
    {
        $return_arr = array();
        $post_counter = $this->get_post_count($user_id);
        $return_arr['dashboard_counter'] = $this->change_number_long_format_to_short((int)$post_counter);

        $contact_counter = $this->getContactCount($user_id);
        $return_arr['contact_counter'] = $this->change_number_long_format_to_short($contact_counter[0]['total']);
        
        $following_counter = $this->getFollowingCount($user_id);
        $return_arr['following_counter'] = $this->change_number_long_format_to_short($following_counter[0]['total']);

        $follower_counter = $this->getFollowerCount($user_id);
        $return_arr['follower_counter'] = $this->change_number_long_format_to_short($follower_counter[0]['total']);

        $question_counter = $this->userQuestionsCount($user_id);
        $return_arr['question_counter'] = $this->change_number_long_format_to_short($question_counter);

        $savedpost_counter = $this->userSavedPostCount($user_id);
        $return_arr['savedpost_counter'] = $this->change_number_long_format_to_short($savedpost_counter);

        $monetize_data = $this->get_monetize();
        $return_arr['monetize_earn'] = '$ '.$monetize_data['total_earn'];
        
        return $return_arr;
    }

    public function get_monetize()
    {
        $user_id = $this->session->userdata('aileenuser');
        // $monetize_data = $this->db->select('*')->get_where('user_point_mapper', array('user_id' => $user_id,'status' => '1'))->row();
        $this->db->select("upm.*")->from("user_point_mapper upm");
        $this->db->join('user_post up', 'up.id = upm.post_id', 'left');
        $this->db->where('upm.user_id', $user_id);
        $this->db->where('upm.status', '1');
        $this->db->where('up.status', 'publish');
        $this->db->where('up.is_delete', '0');        
        $query = $this->db->get();
        $result_array = $query->result_array();
        $total_points = 0;
        $total_earn = 0;
        if(isset($result_array) && !empty($result_array))
        {
            foreach ($result_array as $_result_array) {
                $total_points = $total_points + $_result_array['points'];
            }
            $total_earn = $total_points / 100;
        }
        $return_arr = array(
            'total_points'  =>  $total_points,
            'total_earn'  =>  $total_earn,
        );
        return $return_arr;
    }

    public function is_user_monetize() {
        $user_id = $this->session->userdata('aileenuser');

        $this->db->select("COUNT(*) as total")->from("user_monetize um");
        $this->db->where("um.user_id", $user_id);
        $query = $this->db->get();
        $result_array = $query->row('total');
        return $result_array;
    }

    public function is_post_monetize($post_id, $user_id) {
        $this->db->select("id_user_point_mapper")->from("user_point_mapper");
        $this->db->where("post_id", $post_id);
        $this->db->where("user_id", $user_id);
        $this->db->where("status", '1');
        $query = $this->db->get();
        $result_array = $query->row();
        if(isset($result_array) && !empty($result_array))
        {
            return "1";
        }
        else
        {
            return "0";
        }
    }

    public function createThumbnail($imageDirectory, $imageName, $thumbDirectory, $thumbWidth) {
        /* read the source image */
        $source_image = imagecreatefromjpeg("$imageDirectory/$imageName");
        $width = imagesx($source_image);
        $height = imagesy($source_image);
        
        /* find the "desired height" of this thumbnail, relative to the desired width  */
        $desired_height = floor($height * ($thumbWidth / $width));
        
        /* create a new, "virtual" image */
        $virtual_image = imagecreatetruecolor($thumbWidth, $desired_height);
        imageinterlace($virtual_image, true);
        
        /* copy source image at a resized size */
        imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $thumbWidth, $desired_height, $width, $height);
        
        /* create the physical thumbnail image to its destination */
        imagejpeg($virtual_image, "$thumbDirectory/$imageName");

        /*$srcImg = imagecreatefromjpeg($imageDirectory.$imageName);           

        $origWidth = imagesx($srcImg);
        $origHeight = imagesy($srcImg);

        if($origWidth < $thumbWidth)
        {
            $thumbHeight = $origHeight;
            $thumbWidth = $origWidth;
        }
        else
        {        
            $ratio = $origWidth / $thumbWidth;
            $thumbHeight = $origHeight / $ratio;
        }

        $thumbImg = imagecreatetruecolor($thumbWidth, $thumbHeight);
        imagecopyresized($thumbImg, $srcImg, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $origWidth, $origHeight);
        imagejpeg($thumbImg, $thumbDirectory.$imageName);*/
        return true;
    }

    public function createThumbnailHeight($imageDirectory, $imageName, $thumbDirectory, $thumbHeight) {
        /* read the source image */
        $source_image = imagecreatefromjpeg("$imageDirectory/$imageName");
        $width = imagesx($source_image);
        $height = imagesy($source_image);
        
        /* find the "desired height" of this thumbnail, relative to the desired width  */
        $desired_width = floor($width * ($thumbHeight / $height));
        
        /* create a new, "virtual" image */
        $virtual_image = imagecreatetruecolor($desired_width, $thumbHeight);
        imageinterlace($virtual_image, true);
        
        /* copy source image at a resized size */
        imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $thumbHeight, $width, $height);
        
        /* create the physical thumbnail image to its destination */
        imagejpeg($virtual_image, "$thumbDirectory/$imageName");
        return true;
    }

    public function resizeImage($sourceImage, $path, $targetImage, $quality = 80, $thumbs_path, $resize1_path,$create_thumb = 1,$user_width = '',$user_height = '',$resize2_path = ''){
        $mime = getimagesize($sourceImage);
        if ($mime['mime'] == 'image/png') {
            $main_image1 = @imagecreatefrompng($sourceImage);
            $image       = imagecreatetruecolor(imagesx($main_image1), imagesy($main_image1));
            imagefill($image, 0, 0, imagecolorallocate($image, 255, 255, 255));
            imagealphablending($image, true);
            imagecopy($image, $main_image1, 0, 0, 0, 0, imagesx($main_image1), imagesy($main_image1));
            imagedestroy($main_image1);
        }
        elseif ($mime['mime'] == 'image/jpg'){
            $image = @imagecreatefromjpeg($sourceImage);
        }
        elseif ($mime['mime'] == 'image/jpeg'){
            $image = @imagecreatefromjpeg($sourceImage);
        }
        elseif ($mime['mime'] == 'image/pjpeg'){
            $image = @imagecreatefromjpeg($sourceImage);
        }
        elseif ($mime['mime'] == 'image/gif') {
            $image = imagecreatefromgif($sourceImage);
        }

        // Get dimensions of source image.
        list($origWidth, $origHeight) = getimagesize($sourceImage);
        $maxWidth = 0;
        $maxHeight = 0;
        if ($origWidth < 1500) {
            $maxWidth = $origWidth;
        }
        elseif ($origWidth > 1500 && $origWidth < 2000) {
            $maxWidth = $origWidth / 2;
        }
        elseif ($origWidth > 2000){
            $maxWidth = $origWidth / (int) ($origWidth / 1000);
        }

        if ($origHeight < 1500) {
            $maxHeight = $origHeight;
        }
        elseif ($origHeight > 1500 && $origHeight < 2000) {
            $maxHeight = $origHeight / 2;
        }
        elseif ($origHeight > 2000) {
            $maxHeight = $origHeight / (int) ($origHeight / 1000);
        }

        if ($maxWidth == 0) {
            $maxWidth = $origWidth;
        }

        if ($maxHeight == 0) {
            $maxHeight = $origHeight;
        }

        // Calculate ratio of desired maximum sizes and original sizes.
        $widthRatio  = $maxWidth / $origWidth;
        $heightRatio = $maxHeight / $origHeight;

        // Ratio used for calculating new image dimensions.
        $ratio = min($widthRatio, $heightRatio);

        // Calculate new image dimensions.
        $newWidth  = (int) $origWidth * $ratio;
        $newHeight = (int) $origHeight * $ratio;
        if($user_width != '')
        {
            $newWidth = $user_width;
        }
        if($user_height != '')
        {
            $newHeight = $user_height;
        }

        // Create final image with new dimensions.
        $newImage = imagecreatetruecolor($newWidth, $newHeight);
        imageinterlace($newImage, true);
        imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);
        imagejpeg($newImage, $path.$targetImage, $quality);
        if($create_thumb == 1)
        {            
            $this->createThumbnail($path,$targetImage,$thumbs_path,560);//thumb,resize4        
            $this->createThumbnail($path,$targetImage,$resize1_path,280);//resize1,resize2
            $this->createThumbnailHeight($path,$targetImage,$resize2_path,92);//resize1,resize2
        }
        
        // Free up the memory.
        imagedestroy($image);
        imagedestroy($newImage);

        return true;
    }

    public function mutual_friend($login_user_id,$user_id){
        $sql = "SELECT u.user_id,u.first_name,u.last_name,CONCAT(u.first_name,' ',u.last_name) as fullname,ui.user_image,ui.profile_background,u.user_gender FROM ailee_user_contact uc LEFT JOIN ailee_user AS u ON u.user_id = (CASE WHEN uc.from_id='$user_id' THEN uc.to_id ELSE uc.from_id END) LEFT JOIN ailee_user_info ui ON ui.user_id = u.user_id WHERE (uc.from_id = '$user_id' OR uc.to_id = '$user_id') AND uc.status = 'confirm' AND u.user_id IN(SELECT u.user_id FROM ailee_user_contact uc LEFT JOIN ailee_user AS u ON u.user_id = (CASE WHEN uc.from_id='$login_user_id' THEN uc.to_id ELSE uc.from_id END) WHERE (uc.from_id = '$login_user_id' OR uc.to_id = '$login_user_id') AND uc.status = 'confirm') ORDER BY uc.modify_date DESC LIMIT 2";
        $query = $this->db->query($sql);
        $result_array = $query->result_array();
        return $result_array;
    }

    public function get_points_from_id($point_id){
        $sql = "SELECT points FROM ailee_points WHERE id_points = '".$point_id."'";
        $query = $this->db->query($sql);
        $result_array = $query->row_array();
        return $result_array['points'];
    }
}