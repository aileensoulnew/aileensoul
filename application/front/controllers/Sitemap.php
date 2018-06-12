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
        $this->load->model('job_model');
        $this->load->model('business_model');
        $this->load->model('artistic_model');

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

    public function job_profile() {
        $this->data['title'] = 'Job Profile | Sitemap - Aileensoul';
        $this->data['login_header'] = $this->load->view('login_header', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['getJobDataByLocation'] = $this->sitemap_model->getJobDataByLocation();
        $this->data['getRecruiter'] = $this->sitemap_model->getRecruiter();
        $this->load->view('sitemap/job', $this->data);
    }

    public function recruiter_profile() {
        $this->data['title'] = 'Recruiter Profile | Sitemap - Aileensoul';
        $this->data['login_header'] = $this->load->view('login_header', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['getJobseekers'] = $this->sitemap_model->getJobseekers();
        $contition_array = array('');
        $this->data['business_profile'] = $userdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        $this->load->view('sitemap/recruiter', $this->data);
    }

    public function freelance_profile() {
        $this->data['title'] = 'Freelance Profile | Sitemap - Aileensoul';
        $this->data['login_header'] = $this->load->view('login_header', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['getFreepostDataByCategory'] = $this->sitemap_model->getFreepostDataByCategory();
        $this->data['getFreelancers'] = $this->sitemap_model->getFreelancers();
        $this->data['getEmployees'] = $this->sitemap_model->getEmployees();
        $this->load->view('sitemap/freelance', $this->data);
    }

    public function business_profile() {
        $this->data['title'] = 'Business Profile | Sitemap - Aileensoul';
        $this->data['login_header'] = $this->load->view('login_header', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['getBusinessDataByCategory'] = $this->sitemap_model->getBusinessDataByCategory();
        $this->load->view('sitemap/business', $this->data);
    }

    public function artistic_profile() {
        $this->data['title'] = 'Artistic Profile | Sitemap - Aileensoul';
        $this->data['login_header'] = $this->load->view('login_header', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['getArtistDataByCategory'] = $this->sitemap_model->getArtistDataByCategory();
        $this->load->view('sitemap/artistic', $this->data);
    }

    public function get_artistic_url($userid) {

        $contition_array = array('user_id' => $userid, 'status' => '1');
        $arturl = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id,art_city,art_skill,other_skill,slug', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        $city_url = $this->db->select('city_name')->get_where('cities', array('city_id' => $arturl[0]['art_city'], 'status' => '1'))->row()->city_name;

        $art_othercategory = $this->db->select('other_category')->get_where('art_other_category', array('other_category_id' => $arturl[0]['other_skill']))->row()->other_category;

        $category = $arturl[0]['art_skill'];
        $category = explode(',', $category);

        foreach ($category as $catkey => $catval) {
            $art_category = $this->db->select('art_category')->get_where('art_category', array('category_id' => $catval))->row()->art_category;
            $categorylist[] = $art_category;
        }

        $listfinal1 = array_diff($categorylist, array('other'));
        $listFinal = implode('-', $listfinal1);

        if (!in_array(26, $category)) {
            $category_url = $this->common->clean($listFinal);
        } else if ($arturl[0]['art_skill'] && $arturl[0]['other_skill']) {

            $trimdata = $this->common->clean($listFinal) . '-' . $this->common->clean($art_othercategory);
            $category_url = trim($trimdata, '-');
        } else {
            $category_url = $this->common->clean($art_othercategory);
        }

        $city_get = $this->common->clean($city_url);

        $url = $arturl[0]['slug'] . '-' . $category_url . '-' . $city_get . '-' . $arturl[0]['art_id'];

        return $url;
    }

    public function clean($string) {

        $string = str_replace(' ', '-', $string);  // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // replace double --- in single -

        return preg_replace('/-+/', '-', $string); // Removes special chars.
    }

    //NEW SITEMAP VIEW
    public function sitemap() {
        $this->data['title'] = 'Sitemap - Aileensoul';
        $this->data['login_header'] = $this->load->view('login_header', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->load->view('sitemap/sitemap', $this->data);
    }

    //NEW BLOG VIEW
    public function blogs() {
        $this->data['title'] = 'Sitemap Blogs - Aileensoul';
        $this->data['login_header'] = $this->load->view('login_header', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->load->view('sitemap/sitemap-blog', $this->data);
    }

    //NEW BLOG CATEGORY VIEW
    public function blogs_category($category = '') {
        $this->data['title'] = 'Sitemap Blogs - Aileensoul';
        $this->data['login_header'] = $this->load->view('login_header', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $category = str_replace('-', ' ', $category);
        $this->data['cate_name'] = $category;
        $this->data['cate_id'] = $this->get_blog_cat_id($category);
        $this->load->view('sitemap/sitemap-blog-inner', $this->data);
    }

    //NEW SITEMAP INNER VIEW
    public function sitemap_inner($searchword = '') {
        $this->data['title'] = 'Sitemap - Aileensoul';
        $this->data['login_header'] = $this->load->view('login_header', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['searchword'] = $searchword;
        $this->load->view('sitemap/sitemap-inner', $this->data);
    }

    public function sitemap_art_list() {
        $this->load->view('sitemap/sitemap_art_list', $this->data);
    }

    //NEW SITEMAP INNER VIEW
    public function get_artist_list() {
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
        $result['artist_list'] = $this->sitemap_model->get_artist_list($searchword,$start,$perpage);
        $result['total_record'] = $this->sitemap_model->get_artist_list_total($searchword);
        echo json_encode($result);
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

    public function sitemap_job_list() {
        $this->load->view('sitemap/sitemap_job_list', $this->data);
    }

    //NEW SITEMAP INNER VIEW
    public function get_job_list() {
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
        $result['job_list'] = $this->sitemap_model->get_job_list($searchword,$start,$perpage);
        $result['total_record'] = $this->sitemap_model->get_job_list_total($searchword);
        echo json_encode($result);
    }

    public function sitemap_freelancer_list() {
        $this->load->view('sitemap/sitemap_freelance_list', $this->data);
    }

    //NEW SITEMAP INNER VIEW
    public function get_freelancer_list() {
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
        $result['freelancer_list'] = $this->sitemap_model->get_freelancer_list($searchword,$start,$perpage);
        $result['total_record'] = $this->sitemap_model->get_freelancer_list_total($searchword);
        echo json_encode($result);
    }

    public function sitemap_member_list() {
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
            $txt .= '<url><loc>'.base_url().$value['user_slug'].'</loc><lastmod>'.date('Y-m-dTH:i:sP', time()).'</lastmod><changefreq>weekly</changefreq><priority>0.9</priority></url>';
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
            $txt .='<sitemap><loc>'.base_url().$value.'</loc><lastmod>'.date('Y-m-dTH:i:sP', time()).'</lastmod></sitemap>';
        }
        $txt .= '</sitemapindex>';
        fwrite($member, $txt);
        fclose($member);
    }

    public function generate_sitemap_job_listing()
    {
        $jobData = $this->sitemap_model->generate_sitemap_job_listing();
        // print_r($jobData);exit;
        $job_file_arr = array('job-listing-1.xml');
        $myfile = fopen("job-listing-1.xml", "w");
        $sitemap_index = 1;
        $sitemap_counter = 1;
        $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($jobData as $key => $value) {
            $url = $this->create_slug($value['post_name'])."-job-vacancy-in-".$this->create_slug($value['city_name']).'-'.$value['post_user_id'].'-'.$value['post_id'];
            $txt .= '<url><loc>'.base_url().$url.'</loc><lastmod>'.date('Y-m-dTH:i:sP', time()).'</lastmod><changefreq>weekly</changefreq><priority>0.9</priority></url>';
            if($sitemap_counter == SITEMAP_LIMIT)
            {
                $sitemap_counter = 1;
                $sitemap_index++;
                $txt .= '</urlset>';
                fwrite($myfile, $txt);
                fclose($myfile);
                $job_file_arr[] = "job-listing-".$sitemap_index.".xml";
                $myfile = fopen("job-listing-".$sitemap_index.".xml", "w");                
                $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
            }
            $sitemap_counter++;
        }
        $txt .= '</urlset>';
        fwrite($myfile, $txt);
        fclose($myfile);
        return $job_file_arr;
    }

    public function generate_sitemap_job_by_category_listing()
    {
        $jobCatData = $this->sitemap_model->generate_sitemap_job_by_category_listing();
        // print_r($jobCatData);exit;
        $job_file_arr = array('job-by-category-1.xml');
        $myfile = fopen("job-by-category-1.xml", "w");
        $sitemap_index = 1;
        $sitemap_counter = 1;
        $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($jobCatData as $key => $value) {
            $url = $value['industry_slug']."-jobs";
            $txt .= '<url><loc>'.base_url().$url.'</loc><lastmod>'.date('Y-m-dTH:i:sP', time()).'</lastmod><changefreq>weekly</changefreq><priority>0.9</priority></url>';
            if($sitemap_counter == SITEMAP_LIMIT)
            {
                $sitemap_counter = 1;
                $sitemap_index++;
                $txt .= '</urlset>';
                fwrite($myfile, $txt);
                fclose($myfile);
                $job_file_arr[] = "job-by-category-".$sitemap_index.".xml";
                $myfile = fopen("job-by-category-".$sitemap_index.".xml", "w");                
                $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
            }
            $sitemap_counter++;
        }
        $txt .= '</urlset>';
        fwrite($myfile, $txt);
        fclose($myfile);
        return $job_file_arr;
    }

    public function generate_sitemap_job_by_skills_listing()
    {
        $jobSkillsData = $this->sitemap_model->generate_sitemap_job_by_skills_listing();        
        $job_file_arr = array('job-by-skills-1.xml');
        $myfile = fopen("job-by-skills-1.xml", "w");
        $sitemap_index = 1;
        $sitemap_counter = 1;
        $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($jobSkillsData as $key => $value) {
            $url = $value['skill_slug']."-jobs";
            $txt .= '<url><loc>'.base_url().$url.'</loc><lastmod>'.date('Y-m-dTH:i:sP', time()).'</lastmod><changefreq>weekly</changefreq><priority>0.9</priority></url>';
            if($sitemap_counter == SITEMAP_LIMIT)
            {
                $sitemap_counter = 1;
                $sitemap_index++;
                $txt .= '</urlset>';
                fwrite($myfile, $txt);
                fclose($myfile);
                $job_file_arr[] = "job-by-skills-".$sitemap_index.".xml";
                $myfile = fopen("job-by-skills-".$sitemap_index.".xml", "w");                
                $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
            }
            $sitemap_counter++;
        }
        $txt .= '</urlset>';
        fwrite($myfile, $txt);
        fclose($myfile);
        return $job_file_arr;
    }

    public function generate_sitemap_job_by_location_listing()
    {
        $jobLocData = $this->sitemap_model->generate_sitemap_job_by_location_listing();
        $job_file_arr = array('job-by-location-1.xml');
        $myfile = fopen("job-by-location-1.xml", "w");
        $sitemap_index = 1;
        $sitemap_counter = 1;
        $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($jobLocData as $key => $value) {
            $url = 'jobs-in-'.$value['slug'];
            $txt .= '<url><loc>'.base_url().$url.'</loc><lastmod>'.date('Y-m-dTH:i:sP', time()).'</lastmod><changefreq>weekly</changefreq><priority>0.9</priority></url>';
            if($sitemap_counter == SITEMAP_LIMIT)
            {
                $sitemap_counter = 1;
                $sitemap_index++;
                $txt .= '</urlset>';
                fwrite($myfile, $txt);
                fclose($myfile);
                $job_file_arr[] = "job-by-location-".$sitemap_index.".xml";
                $myfile = fopen("job-by-location-".$sitemap_index.".xml", "w");                
                $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
            }
            $sitemap_counter++;
        }
        $txt .= '</urlset>';
        fwrite($myfile, $txt);
        fclose($myfile);
        return $job_file_arr;
    }

    public function generate_sitemap_job_by_company_listing()
    {
        $jobCmpData = $this->sitemap_model->generate_sitemap_job_by_company_listing();
        $job_file_arr = array('job-by-company-1.xml');
        $myfile = fopen("job-by-company-1.xml", "w");
        $sitemap_index = 1;
        $sitemap_counter = 1;
        $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($jobCmpData as $key => $value) {
            $url = 'jobs-opening-at-'.$this->create_slug($value['company_name']).'-'.$value['rec_id'];
            $txt .= '<url><loc>'.base_url().$url.'</loc><lastmod>'.date('Y-m-dTH:i:sP', time()).'</lastmod><changefreq>weekly</changefreq><priority>0.9</priority></url>';
            if($sitemap_counter == SITEMAP_LIMIT)
            {
                $sitemap_counter = 1;
                $sitemap_index++;
                $txt .= '</urlset>';
                fwrite($myfile, $txt);
                fclose($myfile);
                $job_file_arr[] = "job-by-company-".$sitemap_index.".xml";
                $myfile = fopen("job-by-company-".$sitemap_index.".xml", "w");                
                $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
            }
            $sitemap_counter++;
        }
        $txt .= '</urlset>';
        fwrite($myfile, $txt);
        fclose($myfile);
        return $job_file_arr;
    }

    public function generate_sitemap_job_by_desi_listing()
    {
        $jobDesiData = $this->sitemap_model->generate_sitemap_job_by_desi_listing();
        $job_file_arr = array('job-by-designation-1.xml');
        $myfile = fopen("job-by-designation-1.xml", "w");
        $sitemap_index = 1;
        $sitemap_counter = 1;
        $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($jobDesiData as $key => $value) {
            $url = $value['job_slug'].'-jobs';
            $txt .= '<url><loc>'.base_url().$url.'</loc><lastmod>'.date('Y-m-dTH:i:sP', time()).'</lastmod><changefreq>weekly</changefreq><priority>0.9</priority></url>';
            if($sitemap_counter == SITEMAP_LIMIT)
            {
                $sitemap_counter = 1;
                $sitemap_index++;
                $txt .= '</urlset>';
                fwrite($myfile, $txt);
                fclose($myfile);
                $job_file_arr[] = "job-by-designation-".$sitemap_index.".xml";
                $myfile = fopen("job-by-designation-".$sitemap_index.".xml", "w");                
                $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
            }
            $sitemap_counter++;
        }
        $txt .= '</urlset>';
        fwrite($myfile, $txt);
        fclose($myfile);
        return $job_file_arr;
    }
    public function generate_sitemap_job_by_cdsl_listing()
    {
        $page = 1;
        $limit = 20;
        $sitemap_index = 1;
        $sitemap_counter = 1;
        $job_file_arr = array('job-with-category-location-1.xml');
        $myfile = fopen("job-with-category-location-1.xml", "w");
        $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $jobCat = $this->job_model->get_jobs_by_categories($page,$limit);
        $jobDesc = $this->job_model->get_job_designations($page,$limit);
        $jobSkill = $this->job_model->get_job_skills($page,$limit);
        $jobCity = $this->job_model->get_job_city($page,$limit);        
        $all_link = array();
        foreach ($jobCity['job_city'] as $key => $value) {
            $i=0;
            foreach ($jobCat['job_cat'] as $jck => $jcv) {                
                $txt .= '<url><loc>'.base_url().$jcv['industry_slug']."-jobs-in-".$value['slug'].'</loc><lastmod>'.date('Y-m-dTH:i:sP', time()).'</lastmod><changefreq>weekly</changefreq><priority>0.9</priority></url>';
                if($sitemap_counter == SITEMAP_LIMIT)
                {
                    $sitemap_counter = 1;
                    $sitemap_index++;
                    $txt .= '</urlset>';
                    fwrite($myfile, $txt);
                    fclose($myfile);
                    $job_file_arr[] = "job-with-category-location-".$sitemap_index.".xml";
                    $myfile = fopen("job-with-category-location-".$sitemap_index.".xml", "w");
                    $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
                }
                $sitemap_counter++;
                $i++;
            }
            foreach ($jobDesc['job_desc'] as $jdk => $jdv) {                
                $txt .= '<url><loc>'.base_url().$jdv['job_slug']."-jobs-in-".$value['slug'].'</loc><lastmod>'.date('Y-m-dTH:i:sP', time()).'</lastmod><changefreq>weekly</changefreq><priority>0.9</priority></url>';
                if($sitemap_counter == SITEMAP_LIMIT)
                {
                    $sitemap_counter = 1;
                    $sitemap_index++;
                    $txt .= '</urlset>';
                    fwrite($myfile, $txt);
                    fclose($myfile);
                    $job_file_arr[] = "job-with-category-location-".$sitemap_index.".xml";
                    $myfile = fopen("job-with-category-location-".$sitemap_index.".xml", "w");
                    $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
                }
                $sitemap_counter++;
                $i++;
            }
            foreach ($jobSkill['job_skills'] as $jsk => $jsv) {                
                $txt .= '<url><loc>'.base_url().$jsv['skill_slug']."-jobs-in-".$value['slug'].'</loc><lastmod>'.date('Y-m-dTH:i:sP', time()).'</lastmod><changefreq>weekly</changefreq><priority>0.9</priority></url>';
                if($sitemap_counter == SITEMAP_LIMIT)
                {
                    $sitemap_counter = 1;
                    $sitemap_index++;
                    $txt .= '</urlset>';
                    fwrite($myfile, $txt);
                    fclose($myfile);
                    $job_file_arr[] = "job-with-category-location-".$sitemap_index.".xml";
                    $myfile = fopen("job-with-category-location-".$sitemap_index.".xml", "w");
                    $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
                }
                $sitemap_counter++;
                $i++;
            }
        }
        $txt .= '</urlset>';
        fwrite($myfile, $txt);
        fclose($myfile);
        return $job_file_arr;
    }

    public function job_sitemap()
    {
        $jobList = $this->generate_sitemap_job_listing();
        $jobCatList = $this->generate_sitemap_job_by_category_listing();
        $jobSkillList = $this->generate_sitemap_job_by_skills_listing();
        $jobLocList = $this->generate_sitemap_job_by_location_listing();
        $jobCmpList = $this->generate_sitemap_job_by_company_listing();
        $jobDesiList = $this->generate_sitemap_job_by_desi_listing();
        $jobCDSLList = $this->generate_sitemap_job_by_cdsl_listing();
        /*echo "<pre>";
        print_r($jobList);
        print_r($jobCatList);
        print_r($jobSkillList);
        print_r($jobLocList);
        print_r($jobCmpList);
        print_r($jobDesiList);
        print_r($jobCDSLList);
        echo "</pre>";*/

        $myfile = fopen("job.xml", "w");
        $sitemap_index = 1;
        $sitemap_counter = 1;
        $txt = '<?xml version="1.0" encoding="UTF-8"?><sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($jobList as $key => $value) {
            $txt .='<sitemap><loc>'.base_url().$value.'</loc><lastmod>'.date('Y-m-dTH:i:sP', time()).'</lastmod></sitemap>';
        }
        foreach ($jobCatList as $key => $value) {
            $txt .='<sitemap><loc>'.base_url().$value.'</loc><lastmod>'.date('Y-m-dTH:i:sP', time()).'</lastmod></sitemap>';
        }
        foreach ($jobSkillList as $key => $value) {
            $txt .='<sitemap><loc>'.base_url().$value.'</loc><lastmod>'.date('Y-m-dTH:i:sP', time()).'</lastmod></sitemap>';
        }
        foreach ($jobLocList as $key => $value) {
            $txt .='<sitemap><loc>'.base_url().$value.'</loc><lastmod>'.date('Y-m-dTH:i:sP', time()).'</lastmod></sitemap>';
        }
        foreach ($jobCmpList as $key => $value) {
            $txt .='<sitemap><loc>'.base_url().$value.'</loc><lastmod>'.date('Y-m-dTH:i:sP', time()).'</lastmod></sitemap>';
        }
        foreach ($jobDesiList as $key => $value) {
            $txt .='<sitemap><loc>'.base_url().$value.'</loc><lastmod>'.date('Y-m-dTH:i:sP', time()).'</lastmod></sitemap>';
        }
        foreach ($jobCDSLList as $key => $value) {
            $txt .='<sitemap><loc>'.base_url().$value.'</loc><lastmod>'.date('Y-m-dTH:i:sP', time()).'</lastmod></sitemap>';
        }
        $txt .= '</sitemapindex>';
        fwrite($myfile, $txt);
        fclose($myfile);
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
            $txt .= '<url><loc>'.base_url().$url.'</loc><lastmod>'.date('Y-m-dTH:i:sP', time()).'</lastmod><changefreq>weekly</changefreq><priority>0.9</priority></url>';
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
        // return $bus_file_arr;
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
            $txt .= '<url><loc>'.base_url().$url.'</loc><lastmod>'.date('Y-m-dTH:i:sP', time()).'</lastmod><changefreq>weekly</changefreq><priority>0.9</priority></url>';
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
        // return $bus_file_arr;
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
            $url = 'jobs-in-'.$value['slug'];
            $txt .= '<url><loc>'.base_url().$url.'</loc><lastmod>'.date('Y-m-dTH:i:sP', time()).'</lastmod><changefreq>weekly</changefreq><priority>0.9</priority></url>';
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
        // return $bus_file_arr;
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
        $jobCity = $this->job_model->get_job_city($page,$limit);        
        $all_link = array();
        foreach ($jobCity['job_city'] as $key => $value) {
            $i=0;
            foreach ($jobCat['job_cat'] as $jck => $jcv) {                
                $txt .= '<url><loc>'.base_url().$jcv['industry_slug']."-business-in-".$value['slug'].'</loc><lastmod>'.date('Y-m-dTH:i:sP', time()).'</lastmod><changefreq>weekly</changefreq><priority>0.9</priority></url>';
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
        $txt .= '</urlset>';
        fwrite($myfile, $txt);
        fclose($myfile);
        // return $bus_file_arr;
    }

    public function generate_sitemap_freelance_listing()
    {
        $freeData = $this->sitemap_model->generate_sitemap_freelance_listing();
        // print_r($freeData);exit;
        $free_file_arr = array('freelancejobs-listing-1.xml');
        $myfile = fopen("freelancejobs-listing-1.xml", "w");
        $sitemap_index = 1;
        $sitemap_counter = 1;
        $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($freeData as $key => $value) {
            $url = 'freelance-jobs/'.$value['category_name'].'-'.$value['post_slug'].'-'.$value['post_user_id'].'-'.$value['post_id'];
            $txt .= '<url><loc>'.base_url().$url.'</loc><lastmod>'.date('Y-m-dTH:i:sP', time()).'</lastmod><changefreq>weekly</changefreq><priority>0.9</priority></url>';
            if($sitemap_counter == SITEMAP_LIMIT)
            {
                $sitemap_counter = 1;
                $sitemap_index++;
                $txt .= '</urlset>';
                fwrite($myfile, $txt);
                fclose($myfile);
                $free_file_arr[] = "freelancejobs-listing-".$sitemap_index.".xml";
                $myfile = fopen("freelancejobs-listing-".$sitemap_index.".xml", "w");                
                $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
            }
            $sitemap_counter++;
        }
        $txt .= '</urlset>';
        fwrite($myfile, $txt);
        fclose($myfile);
        // return $free_file_arr;
    }

    public function generate_sitemap_freelance_by_category_listing()
    {
        $freeCatData = $this->sitemap_model->generate_sitemap_freelance_by_category_listing();
        // print_r($busCatData);exit;
        $free_file_arr = array('freelancejobs-by-category-1.xml');
        $myfile = fopen("freelancejobs-by-category-1.xml", "w");
        $sitemap_index = 1;
        $sitemap_counter = 1;
        $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($freeCatData as $key => $value) {
            $url = 'freelance-jobs/'.$value['skill_slug'];
            $txt .= '<url><loc>'.base_url().$url.'</loc><lastmod>'.date('Y-m-dTH:i:sP', time()).'</lastmod><changefreq>weekly</changefreq><priority>0.9</priority></url>';
            if($sitemap_counter == SITEMAP_LIMIT && count($freeCatData) - 1 >= $key)
            {
                $sitemap_counter = 1;
                $sitemap_index++;
                $txt .= '</urlset>';
                fwrite($myfile, $txt);
                fclose($myfile);
                $free_file_arr[] = "freelancejobs-by-category-".$sitemap_index.".xml";
                $myfile = fopen("freelancejobs-by-category-".$sitemap_index.".xml", "w");                
                $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
            }
            $sitemap_counter++;
        }
        $txt .= '</urlset>';
        fwrite($myfile, $txt);
        fclose($myfile);
        // return $free_file_arr;
    }

    public function generate_sitemap_freelance_by_field_listing()
    {
        $freeFieldData = $this->sitemap_model->generate_sitemap_freelance_by_field_listing();
        // print_r($busCatData);exit;
        $free_file_arr = array('freelancejobs-by-category-1.xml');
        $myfile = fopen("freelancejobs-by-field-1.xml", "w");
        $sitemap_index = 1;
        $sitemap_counter = 1;
        $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($freeFieldData as $key => $value) {
            $url = 'freelance-jobs/'.$value['category_slug'];
            $txt .= '<url><loc>'.base_url().$url.'</loc><lastmod>'.date('Y-m-dTH:i:sP', time()).'</lastmod><changefreq>weekly</changefreq><priority>0.9</priority></url>';
            if($sitemap_counter == SITEMAP_LIMIT && count($freeFieldData) - 1 >= $key)
            {
                $sitemap_counter = 1;
                $sitemap_index++;
                $txt .= '</urlset>';
                fwrite($myfile, $txt);
                fclose($myfile);
                $free_file_arr[] = "freelancejobs-by-field-".$sitemap_index.".xml";
                $myfile = fopen("freelancejobs-by-category-".$sitemap_index.".xml", "w");                
                $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
            }
            $sitemap_counter++;
        }
        $txt .= '</urlset>';
        fwrite($myfile, $txt);
        fclose($myfile);
        // return $free_file_arr;
    }

    public function generate_sitemap_artist_listing()
    {
        $artData = $this->sitemap_model->generate_sitemap_artist_listing();
        // print_r($artData);exit;
        $art_file_arr = array('artist-listing-1.xml');
        $myfile = fopen("artist-listing-1.xml", "w");
        $sitemap_index = 1;
        $sitemap_counter = 1;
        $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($artData as $key => $value) {
            $url = 'artist/p/'.$value['slug'];
            $txt .= '<url><loc>'.base_url().$url.'</loc><lastmod>'.date('Y-m-dTH:i:sP', time()).'</lastmod><changefreq>weekly</changefreq><priority>0.9</priority></url>';
            if($sitemap_counter == SITEMAP_LIMIT)
            {
                $sitemap_counter = 1;
                $sitemap_index++;
                $txt .= '</urlset>';
                fwrite($myfile, $txt);
                fclose($myfile);
                $art_file_arr[] = "artist-listing-".$sitemap_index.".xml";
                $myfile = fopen("artist-listing-".$sitemap_index.".xml", "w");                
                $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
            }
            $sitemap_counter++;
        }
        $txt .= '</urlset>';
        fwrite($myfile, $txt);
        fclose($myfile);
        // return $art_file_arr;
    }

    public function generate_sitemap_artist_by_category_listing()
    {
        $artCatData = $this->sitemap_model->generate_sitemap_artist_by_category_listing();
        // print_r($artCatData);exit;
        $job_file_arr = array('artist-by-category-1.xml');
        $myfile = fopen("artist-by-category-1.xml", "w");
        $sitemap_index = 1;
        $sitemap_counter = 1;
        $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($artCatData as $key => $value) {
            $url = 'artist/'.$value['category_slug'];
            $txt .= '<url><loc>'.base_url().$url.'</loc><lastmod>'.date('Y-m-dTH:i:sP', time()).'</lastmod><changefreq>weekly</changefreq><priority>0.9</priority></url>';
            if($sitemap_counter == SITEMAP_LIMIT)
            {
                $sitemap_counter = 1;
                $sitemap_index++;
                $txt .= '</urlset>';
                fwrite($myfile, $txt);
                fclose($myfile);
                $job_file_arr[] = "artist-by-category-".$sitemap_index.".xml";
                $myfile = fopen("artist-by-category-".$sitemap_index.".xml", "w");                
                $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
            }
            $sitemap_counter++;
        }
        $txt .= '</urlset>';
        fwrite($myfile, $txt);
        fclose($myfile);
        return $job_file_arr;
    }

    public function generate_sitemap_artist_by_location_listing()
    {
        $artLocData = $this->sitemap_model->generate_sitemap_artist_by_location_listing();

        $art_file_arr = array('artist-by-location-1.xml');
        $myfile = fopen("artist-by-location-1.xml", "w");
        $sitemap_index = 1;
        $sitemap_counter = 1;
        $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($artLocData as $key => $value) {
            $url = 'artist-in-'.$value['location_slug'];
            $txt .= '<url><loc>'.base_url().$url.'</loc><lastmod>'.date('Y-m-dTH:i:sP', time()).'</lastmod><changefreq>weekly</changefreq><priority>0.9</priority></url>';
            if($sitemap_counter == SITEMAP_LIMIT)
            {
                $sitemap_counter = 1;
                $sitemap_index++;
                $txt .= '</urlset>';
                fwrite($myfile, $txt);
                fclose($myfile);
                $art_file_arr[] = "artist-by-location-".$sitemap_index.".xml";
                $myfile = fopen("artist-by-location-".$sitemap_index.".xml", "w");                
                $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
            }
            $sitemap_counter++;
        }
        $txt .= '</urlset>';
        fwrite($myfile, $txt);
        fclose($myfile);
        return $art_file_arr;
    }

    public function generate_sitemap_artist_by_cl_listing()
    {
        $page = 1;
        $limit = 20;
        $sitemap_index = 1;
        $sitemap_counter = 1;
        $art_file_arr = array('artist-by-category-location-1.xml');
        $myfile = fopen("artist-by-category-location-1.xml", "w");
        $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        // $artistCat = $this->artistic_model->get_artist_by_categories($page,$limit);
        $artCatData = $this->sitemap_model->generate_sitemap_artist_by_category_listing();
        // print_r($artistCat);
        // exit;
        $artistCity = $this->artistic_model->artistAllLocationList($page,$limit); 
        $all_link = array();
        foreach ($artistCity['art_loc'] as $key => $value) {
            foreach ($artCatData as $jck => $jcv) {
                $txt .= '<url><loc>'.base_url().$jcv['category_slug']."-in-".$value['location_slug'].'</loc><lastmod>'.date('Y-m-dTH:i:sP', time()).'</lastmod><changefreq>weekly</changefreq><priority>0.9</priority></url>';
                if($sitemap_counter == SITEMAP_LIMIT)
                {
                    $sitemap_counter = 1;
                    $sitemap_index++;
                    $txt .= '</urlset>';
                    fwrite($myfile, $txt);
                    fclose($myfile);
                    $art_file_arr[] = "artist-by-category-location-".$sitemap_index.".xml";
                    $myfile = fopen("artist-by-category-location-".$sitemap_index.".xml", "w");
                    $txt = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
                }
                $sitemap_counter++;
                $i++;
            }
        }

        $txt .= '</urlset>';
        fwrite($myfile, $txt);
        fclose($myfile);
        // return $art_file_arr;
    }
}