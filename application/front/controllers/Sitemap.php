<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sitemap extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //AWS access info start
        $this->load->library('S3');
        //AWS access info end
        include ('include.php');
        include ('main_profile_link.php');
        $this->load->model('sitemap_model');
        // $this->load->model('job_model');
        $this->load->model('business_model');
        // $this->load->model('artistic_model');

        $this->data['sitemap_header'] = $this->load->view('sitemap/sitemap_header', $this->data, true);
        if($this->session->userdata('aileenuser')){
            $this->data['sitemap_with_login_job'] = $this->data['job_right_profile_link'];
            $this->data['sitemap_with_login_rec'] = $this->data['recruiter_right_profile_link'];
            $this->data['sitemap_with_login_free_emp'] = $this->data['freelance_hire_right_profile_link'];
            $this->data['sitemap_with_login_free_pro'] = $this->data['freelance_apply_right_profile_link'];
            $this->data['sitemap_with_login_bus'] = $this->data['business_right_profile_link'];
            $this->data['sitemap_with_login_art'] = $this->data['artist_right_profile_link'];

            $this->data['sitemap_with_signup_bus'] = $business_right_profile_link;
            $this->data['sitemap_with_signup_art'] = base_url().'artist-profile/signup';
        }else{
            // Without login page
            $this->data['sitemap_with_login_job'] = base_url(). 'login';
            $this->data['sitemap_with_login_rec'] = base_url(). 'login';
            $this->data['sitemap_with_login_free_emp'] = base_url(). 'login';
            $this->data['sitemap_with_login_free_pro'] = base_url(). 'login';
            $this->data['sitemap_with_login_bus'] = base_url(). 'login';
            $this->data['sitemap_with_login_art'] = base_url(). 'login';

            $this->data['sitemap_with_signup_bus'] = base_url('business-profile/create-account');
            $this->data['sitemap_with_signup_art'] = base_url().'artist-profile/create-account';
            $this->data['sitemap_with_signup_rec'] = base_url().'artist-profile/create-account';
        }
    }

    public function index() {
        $this->data['title'] = 'Sitemap - Aileensoul';
        $this->data['login_header'] = $this->load->view('login_header', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);

        $contition_array = array('');
        $this->data['business_profile'] = $userdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        $this->load->view('sitemap/index', $this->data);
    }
    

    public function business_profile() {
        $this->data['title'] = 'Business Profile | Sitemap - Aileensoul';
        $this->data['login_header'] = $this->load->view('login_header', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['getBusinessDataByCategory'] = $this->sitemap_model->getBusinessDataByCategory();
        $this->load->view('sitemap/business', $this->data);
    }

    public function clean($string) {

        $string = str_replace(' ', '-', $string);  // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // replace double --- in single -

        return preg_replace('/-+/', '-', $string); // Removes special chars.
    }

    //NEW SITEMAP VIEW
    public function sitemap() {
        $this->data['title'] = "Sitemap | Aileensoul";
        $this->data['metadesc'] = "Aileensoul HTML sitemap for finding any jobs, freelance projects, business, artist and other important pages. ";
        $this->data['login_header'] = $this->load->view('login_header', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['sitemap_header'] = $this->load->view('sitemap/sitemap_header', $this->data, TRUE);
        $this->load->view('sitemap/sitemap', $this->data);
    }

    //NEW BLOG VIEW
    public function blogs() {
        $this->data['title'] = "Blog Sitemap | Aileensoul";
        $this->data['metadesc'] = "View all blog by categories";
        $this->data['login_header'] = $this->load->view('login_header', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data["categoryList"] = $this->sitemap_model->get_blog_cat_list();
        $this->load->view('sitemap/sitemap-blog', $this->data);
    }

    //NEW BLOG CATEGORY VIEW
    public function blogs_category($category = '') {        
        $this->data['login_header'] = $this->load->view('login_header', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data["categoryList"] = $this->sitemap_model->get_blog_cat_list();

        if($category != ""){
            $category = str_replace('-', ' ', $category);
            $this->data['cate_name'] = $category;
            $this->data['title'] = ucwords($category)." Related Blog Post | Aileensoul";
            $this->data['metadesc'] = "Read all ".ucwords($category)." related blogs";        
            $this->data['cate_id'] = $cate_id = $this->get_blog_cat_id($category);

            $limit = 100;
            $config = array(); 
            $config["base_url"] = base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
            $config["total_rows"] = $this->sitemap_model->get_blog_list_total_rec($cate_id);
            $config["per_page"] = $limit;
            $config["uri_segment"] = 4;
            $choice = $config["total_rows"] / $config["per_page"];
            $config["num_links"] = 1;//round($choice);

            //styling
            $config['full_tag_open']    = '<ul class="pagination pagination-button" id="pagination">';
            $config['full_tag_close']   = '</ul>';            
            $config['first_link'] = 'First';
            $config['first_tag_open'] = '<li>';
            $config['first_tag_close'] = '</li>';
            $config['last_link'] = 'Last';
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';
            $config['use_page_numbers']  = TRUE;

            $config['prev_link']        = 'Previous';
            $config['prev_tag_open'] = '<li>';
            $config['prev_tag_close'] = '</li>';

            $config['next_link']        = 'Next';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';

            $config['cur_tag_open'] = '<li class="active"><a>';
            $config['cur_tag_close'] = '</a></li>';

            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            // $config['display_pages']    = TRUE; 
            
            // $config['suffix']           = '-1';
            $this->pagination->initialize($config);

            $this->data['page'] = $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
            $this->data['blog_list'] = $this->sitemap_model->get_blog_list($cate_id,$page,$limit);            
            $this->data['links'] = $this->pagination->create_links();
        }

        $this->load->view('sitemap/sitemap_blog', $this->data);
    }

    //NEW SITEMAP INNER VIEW
    public function sitemap_inner($searchword = '') {
        $this->data['title'] = 'Sitemap - Aileensoul';
        $this->data['login_header'] = $this->load->view('login_header', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['searchword'] = $searchword;
        $this->load->view('sitemap/sitemap-inner', $this->data);
    }    

    //NEW SITEMAP INNER VIEW
    function get_blog_cat_id($category = ''){
        $sql = "SELECT id as cate_id  FROM ailee_blog_category where name ='". $category ."'";
        $query = $this->db->query($sql);
        $result = $query->row_array();
        if(count($result) > 0){
            return $result['cate_id'];
        }
        return false;
    }

    public function sitemap_company_list() {
        $this->data['title'] = "Business Sitemap | Aileensoul";
        $this->data['metadesc'] = "Search, connect and contact any field business from all over the world.";
        $this->load->view('sitemap/sitemap_business_list', $this->data);
    }

    //NEW SITEMAP INNER VIEW
    public function get_company_list() {
        $perpage = 100;
        $page = 1;
        if (!empty($_GET["searchword"]) && $_GET["searchword"] != 'undefined') {
            $searchword = $_GET["searchword"];
        }
        if (!empty($_GET["page_id"]) && $_GET["page_id"] != 'undefined') {
            $page = $_GET["page_id"];
        }
        if (!empty($_GET["limit"]) && $_GET["limit"] != 'undefined') {
            $perpage = $_GET["limit"];
        }
        $start = ($page - 1) * $perpage;
        if ($start < 0)
            $start = 0;
        $result['company_list'] = $this->sitemap_model->get_company_list($searchword,$start,$perpage);
        $result['total_record'] = $this->sitemap_model->get_company_list_total($searchword);
        echo json_encode($result);
    }    

    public function sitemap_member($searchword = "") {
        $this->data['title'] = "Member Sitemap | Aileensoul";
        $this->data['metadesc'] = "Find and connect with Aileensoul members.";
        $this->data['searchword'] = $searchword;
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['sitemap_header'] = $this->load->view('sitemap/sitemap_header', $this->data, TRUE);
        if($searchword != "")
        {
            $this->data['title'] = "Members Profile Starting from ".strtoupper($searchword)." | Aileensoul";
            $this->data['metadesc'] = "Browse and connect with Aileensoul members profile starting with letter ".strtoupper($searchword);

            $limit = 100;
            $config = array(); 
            $config["base_url"] = base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
            $config["total_rows"] = $this->sitemap_model->get_member_list_total($searchword);
            $config["per_page"] = $limit;
            $config["uri_segment"] = 4;
            $choice = $config["total_rows"] / $config["per_page"];
            $config["num_links"] = 1;//round($choice);

            //styling
            $config['full_tag_open']    = '<ul class="pagination pagination-button" id="pagination">';
            $config['full_tag_close']   = '</ul>';            
            $config['first_link'] = 'First';
            $config['first_tag_open'] = '<li>';
            $config['first_tag_close'] = '</li>';
            $config['last_link'] = 'Last';
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';
            $config['use_page_numbers']  = TRUE;

            $config['prev_link']        = 'Previous';
            $config['prev_tag_open'] = '<li>';
            $config['prev_tag_close'] = '</li>';

            $config['next_link']        = 'Next';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';

            $config['cur_tag_open'] = '<li class="active"><a>';
            $config['cur_tag_close'] = '</a></li>';

            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            // $config['display_pages']    = TRUE; 
            
            // $config['suffix']           = '-1';
            $this->pagination->initialize($config);

            $this->data['page'] = $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
            $this->data['member_list'] = $this->sitemap_model->get_member_list($searchword,$page,$limit);
            $this->data['links'] = $this->pagination->create_links();
        }
        // $this->data['sitemap_header'] = $this->load->view('sitemap/sitemap_header', $this->data, TRUE);
        $this->load->view('sitemap/sitemap_member', $this->data);
    }   

    public function sitemap_companies($searchword = "") {        
        $this->data['title'] = "Business Sitemap | Aileensoul";
        $this->data['metadesc'] = "Search, connect and contact any field business from all over the world.";
        $this->data['searchword'] = $searchword;
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        if($searchword != "")
        {
            $this->data['title'] = "Business Listings Starting from ".strtoupper($searchword)." | Aileensoul";
            $this->data['metadesc'] = "Browse all business whose name start with ".strtoupper($searchword);

            $limit = 100;
            $config = array(); 
            $config["base_url"] = base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
            $config["total_rows"] = $this->sitemap_model->get_company_list_total($searchword);
            $config["per_page"] = $limit;
            $config["uri_segment"] = 4;
            $choice = $config["total_rows"] / $config["per_page"];
            $config["num_links"] = 1;//round($choice);

            //styling
            $config['full_tag_open']    = '<ul class="pagination pagination-button" id="pagination">';
            $config['full_tag_close']   = '</ul>';            
            $config['first_link'] = 'First';
            $config['first_tag_open'] = '<li>';
            $config['first_tag_close'] = '</li>';
            $config['last_link'] = 'Last';
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';
            $config['use_page_numbers']  = TRUE;

            $config['prev_link']        = 'Previous';
            $config['prev_tag_open'] = '<li>';
            $config['prev_tag_close'] = '</li>';

            $config['next_link']        = 'Next';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';

            $config['cur_tag_open'] = '<li class="active"><a>';
            $config['cur_tag_close'] = '</a></li>';

            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            // $config['display_pages']    = TRUE; 
            
            // $config['suffix']           = '-1';
            $this->pagination->initialize($config);

            $this->data['page'] = $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
            $this->data['company_list'] = $this->sitemap_model->get_company_list($searchword,$page,$limit);
            $this->data['links'] = $this->pagination->create_links();
        }
        // $this->data['sitemap_header'] = $this->load->view('sitemap/sitemap_header', $this->data, TRUE);
        $this->load->view('sitemap/sitemap_companies', $this->data);
    }    

    public function sitemap_opportunities($searchword = "") {
        $this->data['title'] = "Opportunity Sitemap | Aileensoul";
        $this->data['metadesc'] = "";
        $this->data['searchword'] = $searchword;
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        if($searchword != "")
        {
            $this->data['title'] = "Opportunity Listing Starting from ".strtoupper($searchword)." | Aileensoul";
            $this->data['metadesc'] = "";

            $limit = 100;
            $config = array(); 
            $config["base_url"] = base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
            $config["total_rows"] = $this->sitemap_model->get_opportunities_list_total($searchword);
            $config["per_page"] = $limit;
            $config["uri_segment"] = 4;
            $choice = $config["total_rows"] / $config["per_page"];
            $config["num_links"] = 1;//round($choice);

            //styling
            $config['full_tag_open']    = '<ul class="pagination pagination-button" id="pagination">';
            $config['full_tag_close']   = '</ul>';            
            $config['first_link'] = 'First';
            $config['first_tag_open'] = '<li>';
            $config['first_tag_close'] = '</li>';
            $config['last_link'] = 'Last';
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';
            $config['use_page_numbers']  = TRUE;

            $config['prev_link']        = 'Previous';
            $config['prev_tag_open'] = '<li>';
            $config['prev_tag_close'] = '</li>';

            $config['next_link']        = 'Next';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';

            $config['cur_tag_open'] = '<li class="active"><a>';
            $config['cur_tag_close'] = '</a></li>';

            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            // $config['display_pages']    = TRUE; 
            
            // $config['suffix']           = '-1';
            $this->pagination->initialize($config);

            $this->data['page'] = $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
            $this->data['opportunities_list'] = $this->sitemap_model->get_opportunities_list($searchword,$page,$limit);
            $this->data['links'] = $this->pagination->create_links();
        }
        // $this->data['sitemap_header'] = $this->load->view('sitemap/sitemap_header', $this->data, TRUE);
        $this->load->view('sitemap/sitemap_opportunities', $this->data);
    }

    public function sitemap_article($searchword = "") {
        $this->data['title'] = "Article Sitemap | Aileensoul";
        $this->data['metadesc'] = "";
        $this->data['searchword'] = $searchword;
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        if($searchword != "")
        {
            $this->data['title'] = "Article Listing Starting from ".strtoupper($searchword)." | Aileensoul";
            $this->data['metadesc'] = "";

            $limit = 100;
            $config = array(); 
            $config["base_url"] = base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
            $config["total_rows"] = $this->sitemap_model->get_article_list_total($searchword);
            $config["per_page"] = $limit;
            $config["uri_segment"] = 4;
            $choice = $config["total_rows"] / $config["per_page"];
            $config["num_links"] = 1;//round($choice);

            //styling
            $config['full_tag_open']    = '<ul class="pagination pagination-button" id="pagination">';
            $config['full_tag_close']   = '</ul>';            
            $config['first_link'] = 'First';
            $config['first_tag_open'] = '<li>';
            $config['first_tag_close'] = '</li>';
            $config['last_link'] = 'Last';
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';
            $config['use_page_numbers']  = TRUE;

            $config['prev_link']        = 'Previous';
            $config['prev_tag_open'] = '<li>';
            $config['prev_tag_close'] = '</li>';

            $config['next_link']        = 'Next';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';

            $config['cur_tag_open'] = '<li class="active"><a>';
            $config['cur_tag_close'] = '</a></li>';

            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            // $config['display_pages']    = TRUE; 
            
            // $config['suffix']           = '-1';
            $this->pagination->initialize($config);

            $this->data['page'] = $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
            $this->data['article_list'] = $this->sitemap_model->get_article_list($searchword,$page,$limit);
            $this->data['links'] = $this->pagination->create_links();            
        }

        // $this->data['sitemap_header'] = $this->load->view('sitemap/sitemap_header', $this->data, TRUE);
        $this->load->view('sitemap/sitemap_article', $this->data);
    }

    public function sitemap_questions($searchword = "") {
        $this->data['title'] = "Questions Sitemap | Aileensoul";
        $this->data['metadesc'] = "";
        $this->data['searchword'] = $searchword;
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        if($searchword != "")
        {
            $this->data['title'] = "Questions Listing Starting from ".strtoupper($searchword)." | Aileensoul";
            $this->data['metadesc'] = "";

            $limit = 100;
            $config = array(); 
            $config["base_url"] = base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
            $config["total_rows"] = $this->sitemap_model->get_questions_list_total($searchword);
            $config["per_page"] = $limit;
            $config["uri_segment"] = 4;
            $choice = $config["total_rows"] / $config["per_page"];
            $config["num_links"] = 1;//round($choice);

            //styling
            $config['full_tag_open']    = '<ul class="pagination pagination-button" id="pagination">';
            $config['full_tag_close']   = '</ul>';            
            $config['first_link'] = 'First';
            $config['first_tag_open'] = '<li>';
            $config['first_tag_close'] = '</li>';
            $config['last_link'] = 'Last';
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';
            $config['use_page_numbers']  = TRUE;

            $config['prev_link']        = 'Previous';
            $config['prev_tag_open'] = '<li>';
            $config['prev_tag_close'] = '</li>';

            $config['next_link']        = 'Next';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';

            $config['cur_tag_open'] = '<li class="active"><a>';
            $config['cur_tag_close'] = '</a></li>';

            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            // $config['display_pages']    = TRUE; 
            
            // $config['suffix']           = '-1';
            $this->pagination->initialize($config);

            $this->data['page'] = $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
            $this->data['questions_list'] = $this->sitemap_model->get_questions_list($searchword,$page,$limit);
            $this->data['links'] = $this->pagination->create_links();            
        }

        // $this->data['sitemap_header'] = $this->load->view('sitemap/sitemap_header', $this->data, TRUE);
        $this->load->view('sitemap/sitemap_questions', $this->data);
    }

    public function sitemap_member_list() {
        $this->data['title'] = "Member Sitemap | Aileensoul";
        $this->data['metadesc'] = "Find and connect with Aileensoul members.";
        $this->load->view('sitemap/sitemap_member_list', $this->data);
    }

    //NEW SITEMAP INNER VIEW
    public function get_member_list() {
        $perpage = 100;
        $page = 1;
        if (!empty($_GET["searchword"]) && $_GET["searchword"] != 'undefined') {
            $searchword = $_GET["searchword"];
        }
        if (!empty($_GET["page_id"]) && $_GET["page_id"] != 'undefined') {
            $page = $_GET["page_id"];
        }
        if (!empty($_GET["limit"]) && $_GET["limit"] != 'undefined') {
            $perpage = $_GET["limit"];
        }
        $start = ($page - 1) * $perpage;
        if ($start < 0)
            $start = 0;
        
        $result['member_list'] = $this->sitemap_model->get_member_list($searchword,$start,$perpage);
        $result['total_record'] = $this->sitemap_model->get_member_list_total($searchword);
        echo json_encode($result);
    }

    public function create_slug($string) {
        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower(stripslashes($string)));
        $slug = preg_replace('/[-]+/', '-', $slug);
        $slug = trim($slug, '-');
        return $slug;
    }

    public function generate_sitemap_member()
    {
        $memberData = $this->sitemap_model->generate_sitemap_member();
        $mem_file_arr = array('members-1.xml');
        $myfile = fopen("members-1.xml", "w");
        $sitemap_index = 1;
        $sitemap_counter = 1;
        $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($memberData as $key => $value) {
            $txt .= '<url><loc>'.base_url().$value['user_slug'].'</loc><lastmod>'.date('Y-m-d\TH:i:sP', time()).'</lastmod><changefreq>daily</changefreq><priority>0.9</priority></url>';
            if($sitemap_counter == SITEMAP_LIMIT)
            {
                $sitemap_counter = 1;
                $sitemap_index++;
                $txt .= '</urlset>';
                fwrite($myfile, $txt);
                fclose($myfile);
                $mem_file_arr[] = "members-".$sitemap_index.".xml";
                $myfile = fopen("members-".$sitemap_index.".xml", "w");                
                $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
            }
            $sitemap_counter++;
        }
        $txt .= '</urlset>';
        fwrite($myfile, $txt);
        fclose($myfile);

        $member = fopen("members.xml", "w");        
        $txt = '<?xml version="1.0" encoding="UTF-8"?><sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($mem_file_arr as $key => $value) {
            $txt .='<sitemap><loc>'.base_url().$value.'</loc><lastmod>'.date('Y-m-d\TH:i:sP', time()).'</lastmod></sitemap>';
        }
        $txt .= '</sitemapindex>';
        fwrite($member, $txt);
        fclose($member);
    }    

    public function generate_sitemap_bussiness_listing()
    {
        $busData = $this->sitemap_model->generate_sitemap_bussiness_listing();
        // print_r($busData);exit;
        $bus_file_arr = array('business-listing-1.xml');
        $myfile = fopen("business-listing-1.xml", "w");
        $sitemap_index = 1;
        $sitemap_counter = 1;
        $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($busData as $key => $value) {
            $url = 'company/'.$value['business_slug'];
            $txt .= '<url><loc>'.base_url().$url.'</loc><lastmod>'.date('Y-m-d\TH:i:sP', time()).'</lastmod><changefreq>daily</changefreq><priority>0.9</priority></url>';
            if($sitemap_counter == SITEMAP_LIMIT)
            {
                $sitemap_counter = 1;
                $sitemap_index++;
                $txt .= '</urlset>';
                fwrite($myfile, $txt);
                fclose($myfile);
                $bus_file_arr[] = "business-listing-".$sitemap_index.".xml";
                $myfile = fopen("business-listing-".$sitemap_index.".xml", "w");                
                $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
            }
            $sitemap_counter++;
        }
        $txt .= '</urlset>';
        fwrite($myfile, $txt);
        fclose($myfile);
        return $bus_file_arr;
    }

    public function generate_sitemap_business_by_category_listing()
    {
        $busCatData = $this->sitemap_model->generate_sitemap_business_by_category_listing();
        // print_r($busCatData);exit;
        $bus_file_arr = array('business-by-category-1.xml');
        $myfile = fopen("business-by-category-1.xml", "w");
        $sitemap_index = 1;
        $sitemap_counter = 1;
        $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($busCatData as $key => $value) {
            $url = $value['industry_slug']."-business";
            $txt .= '<url><loc>'.base_url().$url.'</loc><lastmod>'.date('Y-m-d\TH:i:sP', time()).'</lastmod><changefreq>daily</changefreq><priority>0.9</priority></url>';
            if($sitemap_counter == SITEMAP_LIMIT && count($busCatData) - 1 >= $key)
            {
                $sitemap_counter = 1;
                $sitemap_index++;
                $txt .= '</urlset>';
                fwrite($myfile, $txt);
                fclose($myfile);
                $bus_file_arr[] = "business-by-category-".$sitemap_index.".xml";
                $myfile = fopen("business-by-category-".$sitemap_index.".xml", "w");                
                $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
            }
            $sitemap_counter++;
        }
        $txt .= '</urlset>';
        fwrite($myfile, $txt);
        fclose($myfile);
        return $bus_file_arr;
    }

    public function generate_sitemap_business_by_location_listing()
    {
        $busLocData = $this->sitemap_model->generate_sitemap_business_by_location_listing();
        $bus_file_arr = array('business-by-location-1.xml');
        $myfile = fopen("business-by-location-1.xml", "w");
        $sitemap_index = 1;
        $sitemap_counter = 1;
        $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($busLocData as $key => $value) {
            $url = 'business-in-'.$value['slug'];
            $txt .= '<url><loc>'.base_url().$url.'</loc><lastmod>'.date('Y-m-d\TH:i:sP', time()).'</lastmod><changefreq>daily</changefreq><priority>0.9</priority></url>';
            if($sitemap_counter == SITEMAP_LIMIT && count($busLocData) - 1 >= $key)
            {
                $sitemap_counter = 1;
                $sitemap_index++;
                $txt .= '</urlset>';
                fwrite($myfile, $txt);
                fclose($myfile);
                $bus_file_arr[] = "business-by-location-".$sitemap_index.".xml";
                $myfile = fopen("business-by-location-".$sitemap_index.".xml", "w");                
                $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
            }
            $sitemap_counter++;
        }
        $txt .= '</urlset>';
        fwrite($myfile, $txt);
        fclose($myfile);
        return $bus_file_arr;
    }

    public function generate_sitemap_business_by_cl_listing()
    {
        $page = 1;
        $limit = 20;
        $sitemap_index = 1;
        $sitemap_counter = 1;
        $bus_file_arr = array('business-by-category-location-1.xml');
        $myfile = fopen("business-by-category-location-1.xml", "w");
        $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $jobCat = $this->business_model->get_business_by_categories($page,$limit);        
        $jobCity = $this->sitemap_model->get_job_city($page,$limit);        
        $all_link = array();
        foreach ($jobCity as $key => $value) {
            $i=0;
            foreach ($jobCat['job_cat'] as $jck => $jcv) {
                $total_buss = $this->business_model->businessListByFilterTotalRec($jcv['industry_id'],$value['city_id'],$industry_name = array(),$city_name = array());
                if($total_buss > 0)
                {
                    $txt .= '<url><loc>'.base_url().$jcv['industry_slug']."-business-in-".$value['slug'].'</loc><lastmod>'.date('Y-m-d\TH:i:sP', time()).'</lastmod><changefreq>daily</changefreq><priority>0.9</priority></url>';
                    if($sitemap_counter == SITEMAP_LIMIT)
                    {
                        $sitemap_counter = 1;
                        $sitemap_index++;
                        $txt .= '</urlset>';
                        fwrite($myfile, $txt);
                        fclose($myfile);
                        $bus_file_arr[] = "business-by-category-location-".$sitemap_index.".xml";
                        $myfile = fopen("business-by-category-location-".$sitemap_index.".xml", "w");
                        $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
                    }
                    $sitemap_counter++;
                    $i++;
                }
            }            
        }
        $txt .= '</urlset>';
        fwrite($myfile, $txt);
        fclose($myfile);
        return $bus_file_arr;
    }

    public function business_sitemap()
    {
        $bussList = $this->generate_sitemap_bussiness_listing();
        $bussCatList = $this->generate_sitemap_business_by_category_listing();        
        $bussLocList = $this->generate_sitemap_business_by_location_listing();        
        $bussCLList = $this->generate_sitemap_business_by_cl_listing();        

        $myfile = fopen("business.xml", "w");
        $sitemap_index = 1;
        $sitemap_counter = 1;
        $txt = '<?xml version="1.0" encoding="UTF-8"?><sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($bussList as $key => $value) {
            $txt .='<sitemap><loc>'.base_url().$value.'</loc><lastmod>'.date('Y-m-d\TH:i:sP', time()).'</lastmod></sitemap>';
        }
        foreach ($bussCatList as $key => $value) {
            $txt .='<sitemap><loc>'.base_url().$value.'</loc><lastmod>'.date('Y-m-d\TH:i:sP', time()).'</lastmod></sitemap>';
        }
        foreach ($bussLocList as $key => $value) {
            $txt .='<sitemap><loc>'.base_url().$value.'</loc><lastmod>'.date('Y-m-d\TH:i:sP', time()).'</lastmod></sitemap>';
        }
        foreach ($bussCLList as $key => $value) {
            $txt .='<sitemap><loc>'.base_url().$value.'</loc><lastmod>'.date('Y-m-d\TH:i:sP', time()).'</lastmod></sitemap>';
        }        
        $txt .= '</sitemapindex>';
        fwrite($myfile, $txt);
        fclose($myfile);
    }

    public function generate_sitemap_blog_listing()
    {
        $blogData = $this->sitemap_model->generate_sitemap_blog_listing();
        // print_r($jobData);exit;
        $blog_file_arr = array('blog-1.xml');
        $myfile = fopen("blog-1.xml", "w");
        $sitemap_index = 1;
        $sitemap_counter = 1;
        $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($blogData as $key => $value) {
            $url = 'blog/'.$value['blog_slug'];
            $txt .= '<url><loc>'.base_url().$url.'</loc><lastmod>'.date('Y-m-d\TH:i:sP', time()).'</lastmod><changefreq>daily</changefreq><priority>0.9</priority></url>';
            if($sitemap_counter == SITEMAP_LIMIT)
            {
                $sitemap_counter = 1;
                $sitemap_index++;
                $txt .= '</urlset>';
                fwrite($myfile, $txt);
                fclose($myfile);
                $blog_file_arr[] = "blog-".$sitemap_index.".xml";
                $myfile = fopen("blog-".$sitemap_index.".xml", "w");                
                $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
            }
            $sitemap_counter++;
        }
        $txt .= '</urlset>';
        fwrite($myfile, $txt);
        fclose($myfile);
        // return $blog_file_arr;

        $myfile = fopen("blog.xml", "w");
        $sitemap_index = 1;
        $sitemap_counter = 1;
        $txt = '<?xml version="1.0" encoding="UTF-8"?><sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($blog_file_arr as $key => $value) {
            $txt .='<sitemap><loc>'.base_url().$value.'</loc><lastmod>'.date('Y-m-d\TH:i:sP', time()).'</lastmod></sitemap>';
        }        
        $txt .= '</sitemapindex>';
        fwrite($myfile, $txt);
        fclose($myfile);
    }

    public function generate_sitemap_opportunity_listing()
    {
        $opportunity_data = $this->sitemap_model->generate_sitemap_opportunity_listing();
        // print_r($opportunity_data);exit;
        $art_file_arr = array('opportunity-1.xml');
        $myfile = fopen("opportunity-1.xml", "w");
        $sitemap_index = 1;
        $sitemap_counter = 1;
        $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($opportunity_data as $key => $value) {
            $url = 'o/'.$value['oppslug'];
            $txt .= '<url><loc>'.base_url().$url.'</loc><lastmod>'.date('Y-m-d\TH:i:sP', time()).'</lastmod><changefreq>daily</changefreq><priority>0.9</priority></url>';
            if($sitemap_counter == SITEMAP_LIMIT)
            {
                $sitemap_counter = 1;
                $sitemap_index++;
                $txt .= '</urlset>';
                fwrite($myfile, $txt);
                fclose($myfile);
                $art_file_arr[] = "opportunity-".$sitemap_index.".xml";
                $myfile = fopen("opportunity-".$sitemap_index.".xml", "w");                
                $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
            }
            $sitemap_counter++;
        }
        $txt .= '</urlset>';
        fwrite($myfile, $txt);
        fclose($myfile);
        return $art_file_arr;
    }

    public function opportunity_sitemap()
    {
        $artList = $this->generate_sitemap_opportunity_listing();

        $myfile = fopen("opportunity.xml", "w");
        $sitemap_index = 1;
        $sitemap_counter = 1;
        $txt = '<?xml version="1.0" encoding="UTF-8"?><sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($artList as $key => $value) {
            $txt .='<sitemap><loc>'.base_url().$value.'</loc><lastmod>'.date('Y-m-d\TH:i:sP', time()).'</lastmod></sitemap>';
        }           
        $txt .= '</sitemapindex>';
        fwrite($myfile, $txt);
        fclose($myfile);
    }

    public function generate_sitemap_article_listing()
    {
        $article_data = $this->sitemap_model->generate_sitemap_article_listing();
        // print_r($opportunity_data);exit;
        $art_file_arr = array('article-1.xml');
        $myfile = fopen("article-1.xml", "w");
        $sitemap_index = 1;
        $sitemap_counter = 1;
        $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($article_data as $key => $value) {
            $url = 'article/'.$value['article_slug'];
            $txt .= '<url><loc>'.base_url().$url.'</loc><lastmod>'.date('Y-m-d\TH:i:sP', time()).'</lastmod><changefreq>daily</changefreq><priority>0.9</priority></url>';
            if($sitemap_counter == SITEMAP_LIMIT)
            {
                $sitemap_counter = 1;
                $sitemap_index++;
                $txt .= '</urlset>';
                fwrite($myfile, $txt);
                fclose($myfile);
                $art_file_arr[] = "article-".$sitemap_index.".xml";
                $myfile = fopen("article-".$sitemap_index.".xml", "w");                
                $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
            }
            $sitemap_counter++;
        }
        $txt .= '</urlset>';
        fwrite($myfile, $txt);
        fclose($myfile);
        return $art_file_arr;
    }

    public function article_sitemap()
    {
        $article_ist = $this->generate_sitemap_article_listing();

        $myfile = fopen("article.xml", "w");
        $sitemap_index = 1;
        $sitemap_counter = 1;
        $txt = '<?xml version="1.0" encoding="UTF-8"?><sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($article_ist as $key => $value) {
            $txt .='<sitemap><loc>'.base_url().$value.'</loc><lastmod>'.date('Y-m-d\TH:i:sP', time()).'</lastmod></sitemap>';
        }           
        $txt .= '</sitemapindex>';
        fwrite($myfile, $txt);
        fclose($myfile);
    }

    public function generate_sitemap_questions_listing()
    {
        $question_data = $this->sitemap_model->generate_sitemap_questions_listing();
        // print_r($question_data);exit;
        $art_file_arr = array('questions-1.xml');
        $myfile = fopen("questions-1.xml", "w");
        $sitemap_index = 1;
        $sitemap_counter = 1;
        $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($question_data as $key => $value) {            
            $url = 'questions/'.$value['question_id'].'/'.$this->common->create_slug($value['question']);
            $txt .= '<url><loc>'.base_url().$url.'</loc><lastmod>'.date('Y-m-d\TH:i:sP', time()).'</lastmod><changefreq>daily</changefreq><priority>0.9</priority></url>';
            if($sitemap_counter == SITEMAP_LIMIT)
            {
                $sitemap_counter = 1;
                $sitemap_index++;
                $txt .= '</urlset>';
                fwrite($myfile, $txt);
                fclose($myfile);
                $art_file_arr[] = "questions-".$sitemap_index.".xml";
                $myfile = fopen("questions-".$sitemap_index.".xml", "w");                
                $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
            }
            $sitemap_counter++;
        }
        $txt .= '</urlset>';
        fwrite($myfile, $txt);
        fclose($myfile);
        return $art_file_arr;
    }

    public function questions_sitemap()
    {
        $questions_ist = $this->generate_sitemap_questions_listing();

        $myfile = fopen("questions.xml", "w");
        $sitemap_index = 1;
        $sitemap_counter = 1;
        $txt = '<?xml version="1.0" encoding="UTF-8"?><sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($questions_ist as $key => $value) {
            $txt .='<sitemap><loc>'.base_url().$value.'</loc><lastmod>'.date('Y-m-d\TH:i:sP', time()).'</lastmod></sitemap>';
        }           
        $txt .= '</sitemapindex>';
        fwrite($myfile, $txt);
        fclose($myfile);
    }

    public function main_sitemap()
    {
        $myfile = fopen("sitemap.xml", "w");
        $lastmod = date('Y-m-d');
        $txt = '<?xml version="1.0" encoding="UTF-8"?>
                <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
                <url>
                <loc>'.base_url().'otherpages.xml</loc>
                <lastmod>'.$lastmod.'</lastmod>
                </url>
                <url>
                <loc>'.base_url().'members.xml</loc>
                <lastmod>'.$lastmod.'</lastmod>
                </url>                
                <url>
                <loc>'.base_url().'business.xml</loc>
                <lastmod>'.$lastmod.'</lastmod>
                </url>                
                <url>
                <loc>'.base_url().'opportunity.xml</loc>
                <lastmod>'.$lastmod.'</lastmod>
                </url>
                <url>
                <loc>'.base_url().'questions.xml</loc>
                <lastmod>'.$lastmod.'</lastmod>
                </url>                
                <url>
                <loc>'.base_url().'blog.xml</loc>
                <lastmod>'.$lastmod.'</lastmod>
                </url>
                </urlset>';
        fwrite($myfile, $txt);
        fclose($myfile);

    }
    public function main_other_page_sitemap()
    {

        $myfile1 = fopen("otherpages.xml", "w");
        $freq1 = "daily";
        $lastmod1 = date('Y-m-d');
        $txt1 = '<?xml version="1.0" encoding="UTF-8"?>
                <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
                <url>
                <loc>'.base_url().'</loc>
                <priority>1.0</priority>
                <changefreq>'.$freq1.'</changefreq>
                <lastmod>'.$lastmod1.'</lastmod>
                </url>
                <url>
                <loc>'.base_url().'login</loc>
                <priority>0.9</priority>
                <changefreq>'.$freq1.'</changefreq>
                <lastmod>'.$lastmod1.'</lastmod>
                </url>
                <url>
                <loc>'.base_url().'registration</loc>
                <priority>0.9</priority>
                <changefreq>'.$freq1.'</changefreq>
                <lastmod>'.$lastmod1.'</lastmod>
                </url>
                <url>
                <loc>'.base_url().'about-us</loc>
                <priority>0.8</priority>
                <changefreq>'.$freq1.'</changefreq>
                <lastmod>'.$lastmod1.'</lastmod>
                </url>
                <url>
                <loc>'.base_url().'privacy-policy</loc>
                <priority>0.8</priority>
                <changefreq>'.$freq1.'</changefreq>
                <lastmod>'.$lastmod1.'</lastmod>
                </url>
                <url>
                <loc>'.base_url().'disclaimer-policy</loc>
                <priority>0.8</priority>
                <changefreq>'.$freq1.'</changefreq>
                <lastmod>'.$lastmod1.'</lastmod>
                </url>
                <url>
                <loc>'.base_url().'terms-and-condition</loc>
                <priority>0.8</priority>
                <changefreq>'.$freq1.'</changefreq>
                <lastmod>'.$lastmod1.'</lastmod>
                </url>
                <url>
                <loc>'.base_url().'feedback</loc>
                <priority>0.8</priority>
                <changefreq>'.$freq1.'</changefreq>
                <lastmod>'.$lastmod1.'</lastmod>
                </url>
                <url>
                <loc>'.base_url().'contact-us</loc>
                <priority>0.8</priority>
                <changefreq>'.$freq1.'</changefreq>
                <lastmod>'.$lastmod1.'</lastmod>
                </url>
                <url>
                <loc>'.base_url().'advertise-with-us</loc>
                <priority>0.8</priority>
                <changefreq>'.$freq1.'</changefreq>
                <lastmod>'.$lastmod1.'</lastmod>
                </url>
                <url>
                <loc>'.base_url().'report-abuse</loc>
                <priority>0.8</priority>
                <changefreq>'.$freq1.'</changefreq>
                <lastmod>'.$lastmod1.'</lastmod>
                </url>
                <url>
                <loc>'.base_url().'business-profile/create-account</loc>
                <priority>0.8</priority>
                <changefreq>'.$freq1.'</changefreq>
                <lastmod>'.$lastmod1.'</lastmod>
                </url>
                <url>
                <loc>'.base_url().'business-search</loc>
                <priority>0.8</priority>
                <changefreq>'.$freq1.'</changefreq>
                <lastmod>'.$lastmod1.'</lastmod>
                </url>
                <url>
                <loc>'.base_url().'business-by-categories</loc>
                <priority>0.8</priority>
                <changefreq>'.$freq1.'</changefreq>
                <lastmod>'.$lastmod1.'</lastmod>
                </url>
                <url>
                <loc>'.base_url().'business-by-location</loc>
                <priority>0.8</priority>
                <changefreq>'.$freq1.'</changefreq>
                <lastmod>'.$lastmod1.'</lastmod>
                </url>
                <url>
                <loc>'.base_url().'business</loc>
                <priority>0.8</priority>
                <changefreq>'.$freq1.'</changefreq>
                <lastmod>'.$lastmod1.'</lastmod>
                </url>                
                <url>
                <loc>'.base_url().'sitemap</loc>
                <priority>0.8</priority>
                <changefreq>'.$freq1.'</changefreq>
                <lastmod>'.$lastmod1.'</lastmod>
                </url>
                <url>
                <loc>'.base_url().'blog</loc>
                <priority>0.8</priority>
                <changefreq>'.$freq1.'</changefreq>
                <lastmod>'.$lastmod1.'</lastmod>
                </url>
                <url>
                <loc>'.base_url().'guest-contributor</loc>
                <priority>0.8</priority>
                <changefreq>'.$freq1.'</changefreq>
                <lastmod>'.$lastmod1.'</lastmod>
                </url>
                </urlset>';
        fwrite($myfile1, $txt1);
        fclose($myfile1);
    }

    public function generate_sitemap()
    {        
        set_time_limit(0);
        ini_set("memory_limit","512M");
        $this->main_sitemap();
        $this->main_other_page_sitemap();
        $this->generate_sitemap_member();        
        $this->business_sitemap();        
        $this->opportunity_sitemap();
        // $this->article_sitemap();
        $this->questions_sitemap();
        $this->generate_sitemap_blog_listing();
        echo "Done";
    }
}