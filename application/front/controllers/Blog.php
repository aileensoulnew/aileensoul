<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Blog extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //AWS access info start
        $this->load->library('S3');
        $this->load->model('blog_model');
        //AWS access info end
        include ('include.php');
        include ('main_profile_link.php');
    }

    //MAIN INDEX PAGE START   
    public function index($slug = '', $iscategory = '') {
         // echo $slug;exit;
        // blog category start
        $condition_array = array('status' => 'publish');
        $data = 'id,name';
        // $this->data['blog_category'] = $this->common->select_data_by_condition('blog_category', $condition_array, $data, $short_by = '', $order_by = '', $limit = '', $offset = '', $join_str = array());
        $category_id = "";
        $uri_segment = 2;
        $pg_url = base_url().$this->uri->segment(1);
        $this->data['category_name'] = "";
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        if($iscategory != ""){
            $this->data['category_name'] = $sel_category_name = str_replace('-', ' ', $slug);
            $sql = "SELECT GROUP_CONCAT(id) as cate_id  FROM ailee_blog_category where name IN ('". $slug ."')";
            $query = $this->db->query($sql);
            $result = $query->row_array();
            if(count($result) > 0){
                $this->data['category_id'] = $category_id = $result['cate_id'];
                $slug = "";
                $uri_segment = 4;
                $pg_url = base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
            }
        }

        $condition_array = array('status' => 'publish');
        $recent_blog_list = $this->common->select_data_by_condition('blog', $condition_array, $data = '*,DATE_FORMAT(created_date,"%D %M %Y") as created_date_formatted', $short_by = 'id', $order_by = 'desc', $limit = 5, $offset, $join_str = array());        
        $this->data['recent_blog_list'] = $recent_blog_list;
        $this->data['categoryList'] = $this->blog_model->get_blog_cat_list();        
        // blog category end
        if ($slug != '') {
            
            $count =  $this->blog_check($slug); 
            if($count == 1){
            //FOR GETTING ALL DATA
            $condition_array = array('status' => 'publish');
            $this->data['blog_all'] = $this->common->select_data_by_condition('blog', $condition_array, $data = '*', $short_by = 'id', $order_by = 'desc', $limit = '', $offset = '', $join_str = array());

            // echo count($this->data['blog_all']);exit;
            //FOR GETTING BLOG
            $condition_array = array('status' => 'publish', 'blog_slug' => $slug);
            $this->data['blog_detail'] = $this->common->select_data_by_condition('blog', $condition_array, $data = '*', $short_by = 'id', $order_by = 'desc', $limit, $offset, $join_str = array());
            // echo $this->db->last_query();
            // exit;

            $this->data['blog_data'] = $this->blog_model->get_blog_details($slug);
            // random blog end
            $this->data['title'] = "Career Advice, Business Hacks, Recruitment Solutions, and More - Aileensoul Blog ";
            $this->data['metadesc'] = "Get the advice and solutions about business and career from Aileensoul Blog. Setup to provide insights to its user.";

            $this->load->view('blog/blogdetail', $this->data);
            }
            else
            {
                redirect('blog', refresh);
            }
        }
        else
        {
            //THIS IF IS USED FOR WHILE SEARCH FOR RETRIEVE SAME PAGE START
            if ($this->input->get('q') || $this->input->get('p')) { 
                if($this->input->get('q'))
                {
                    $this->data['search_keyword'] = $search_keyword = trim($this->input->get('q'));
                }
                else if($this->input->get('p'))
                {
                    $this->data['search_keyword'] = $search_keyword = trim($this->input->get('p'));
                }

                $total_blog = $this->blog_model->get_blog_post($search_keyword,"",'','','');                
                $limit = 5;
                $config = array(); 
                $config["base_url"] = $pg_url;
                $config["total_rows"] = count($total_blog);
                $config["per_page"] = $limit;
                $config["uri_segment"] = $uri_segment;
                $choice = $config["total_rows"] / $config["per_page"];
                $config["num_links"] = 1;//round($choice);

                //styling
                $config['full_tag_open']    = '<ul class="pagination" id="pagination">';
                $config['full_tag_close']   = '</ul>';
                $config['first_url'] = $pg_url.'?q='.$search_keyword;
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
                // $config['page_query_string'] = TRUE;
                // $config['query_string_segment'] = "q";
                $config['suffix'] = '?q='.$search_keyword;
                $this->pagination->initialize($config);

                $this->data['page'] = $page = ($this->uri->segment($uri_segment)) ? $this->uri->segment($uri_segment) : 0;
                $blogPost = $this->blog_model->get_blog_post($search_keyword,"",$page,$limit,'created_date');

                foreach ($blogPost as $key=>$blog) {
                    $sql = "SELECT count(id) as total_comment FROM ailee_blog_comment where status = 'approve' AND blog_id = '". $blog['id'] ."'";
                    $query = $this->db->query($sql);
                    $blogPost[$key]['total_comment'] = $query->row()->total_comment;

                    $blogPost[$key]['category_name'] = $category_name = $this->blog_model->get_blog_post_category_name($blog['id']);                

                    $blogPost[$key]['social_title'] = urlencode('"' . $blog['title'] . '"');
                    $blogPost[$key]['social_encodeurl'] = urlencode(base_url('blog/' . $blog['blog_slug']));
                    $blogPost[$key]['social_summary'] = urlencode('"' . $blog['description'] . '"');
                    $blogPost[$key]['social_image'] = urlencode(base_url($this->config->item('blog_main_upload_path') . $blog['image']));
                    $blogPost[$key]['social_url'] = base_url('blog/' . $blog['blog_slug']);
                    $blogPost[$key]['blog_category_name'] = explode(',', $category_name);
                }
                $this->data['blogPost'] = $blogPost;
                // print_r($this->data['blogPost']);
                $this->data['links'] = $this->pagination->create_links();

                $this->data['title'] = "Search | Official Blog for Regular Updates, News and Sharing knowledge - Aileensoul";
                $this->data['metadesc'] = "Our Aileensoul official blog will describe our free service and related news, tips and tricks - stay tuned.";
				
				$this->data['category_page'] = 1;

                // $this->load->view('blog/search', $this->data);
                $this->load->view('blog/index', $this->data);
               
            }//THIS IF IS USED FOR WHILE SEARCH FOR RETRIEVE SAME PAGE END
            else
            {
                $total_blog = $this->blog_model->get_blog_post("",$category_id,'','','');                
                $limit = 5;
                $config = array(); 
                $config["base_url"] = $pg_url;
                $config["total_rows"] = count($total_blog);
                $config["per_page"] = $limit;
                $config["uri_segment"] = $uri_segment;
                $choice = $config["total_rows"] / $config["per_page"];
                $config["num_links"] = 1;//round($choice);

                //styling
                $config['full_tag_open']    = '<ul class="pagination" id="pagination">';
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

                $this->data['page'] = $page = ($this->uri->segment($uri_segment)) ? $this->uri->segment($uri_segment) : 0;
                $blogPost = $this->blog_model->get_blog_post('',$category_id,$page,$limit,'created_date');

                foreach ($blogPost as $key=>$blog) {
                    $sql = "SELECT count(id) as total_comment FROM ailee_blog_comment where status = 'approve' AND blog_id = '". $blog['id'] ."'";
                    $query = $this->db->query($sql);
                    $blogPost[$key]['total_comment'] = $query->row()->total_comment;

                    $blogPost[$key]['category_name'] = $category_name = $this->blog_model->get_blog_post_category_name($blog['id']);                

                    $blogPost[$key]['social_title'] = urlencode('"' . $blog['title'] . '"');
                    $blogPost[$key]['social_encodeurl'] = urlencode(base_url('blog/' . $blog['blog_slug']));
                    $blogPost[$key]['social_summary'] = urlencode('"' . $blog['description'] . '"');
                    $blogPost[$key]['social_image'] = urlencode(base_url($this->config->item('blog_main_upload_path') . $blog['image']));
                    $blogPost[$key]['social_url'] = base_url('blog/' . $blog['blog_slug']);
                    $blogPost[$key]['blog_category_name'] = explode(',', $category_name);
                }
                $this->data['blogPost'] = $blogPost;
                // print_r($this->data['blogPost']);exit;
                $this->data['links'] = $this->pagination->create_links();
				
				$this->data['category_page'] = 0;
                if($iscategory != ""){
					$this->data['category_page'] = 1;
                    $this->data['title'] = ucwords($sel_category_name)." Blogs | Aileensoul Knowledge";
                    $this->data['metadesc'] = "Read all best ".ucwords($sel_category_name)." related articles to get more insights about this field.";
                }
                else
                {                    
                    $this->data['title'] = "Career Advice, Business Hacks, Recruitment Solutions, and More - Aileensoul Blog ";
                    $this->data['metadesc'] = "Get the advice and solutions about business and career from Aileensoul Blog. Setup to provide insights to its user.";
                }

                // echo $this->db->last_query();
                // print_r($this->data['blog_last']);
                // exit;
                $this->load->view('blog/index', $this->data);

                // echo "<pre>";print_r( $this->data['blog_detail']);die();
            }
            //FOR GETTING ALL DATA START
            //FOR GETTING 5 LAST DATA
        
        }
    }

    //MAIN INDEX PAGE END   
    //READ MORE CLICK START
    public function popular() {

        $join_str[0]['table'] = 'blog';
        $join_str[0]['join_table_id'] = 'blog.id';
        $join_str[0]['from_table_id'] = 'blog_visit.blog_id';
        $join_str[0]['join_type'] = '';

        $condition_array = array('blog.status' => 'publish');
        $data = "blog.* ,count(blog_id) as count";
        $this->data['blog_detail'] = $this->common->select_data_by_condition('blog_visit', $condition_array, $data, $short_by = 'count', $order_by = 'desc', $limit, $offset, $join_str, $groupby = 'blog_visit.blog_id');

        //FOR GETTING 5 LAST DATA
        $condition_array = array('status' => 'publish');
        $this->data['blog_last'] = $this->common->select_data_by_condition('blog', $condition_array, $data = '*', $short_by = 'id', $order_by = 'desc', $limit = 5, $offset, $join_str = array());

        $this->load->view('blog/index', $this->data);
    }

    //READ MORE CLICK START
//    public function read_more() {
//
//        $id = $_POST['blog_id'];
//
//        //FOR INSERT READ MORE BLOG START
//        $data = array(
//            'blog_id' => $id,
//            'visiter_date' => date('Y-m-d H:i:s')
//        );
//        $insert_id = $this->common->insert_data_getid($data, 'blog_visit');
//
//        //FOR INSERT READ MORE BLOG END
//
//        if ($insert_id) {
//            echo 1;
//        } else {
//            echo 0;
//        }
//    }

    //READ MORE CLICK END
    //BLOGDETAIL FOR PERICULAR ONE POST START
    public function blogdetail($slug = '') {
        //FOR GETTING ALL DATA
        $condition_array = array('status' => 'publish');
        $this->data['blog_all'] = $this->common->select_data_by_condition('blog', $condition_array, $data = '*', $short_by = 'id', $order_by = 'desc', $limit, $offset, $join_str = array());

        //FOR GETTING BLOG
        $condition_array = array('status' => 'publish', 'blog_slug' => $slug);
        $this->data['blog_detail'] = $this->common->select_data_by_condition('blog', $condition_array, $data = '*', $short_by = 'id', $order_by = 'desc', $limit, $offset, $join_str = array());

        //FOR GETTING 5 LAST DATA
        $condition_array = array('status' => 'publish');
        $this->data['blog_last'] = $this->common->select_data_by_condition('blog', $condition_array, $data = '*', $short_by = 'id', $order_by = 'desc', $limit = 5, $offset, $join_str = array());

        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->load->view('blog/blogdetail', $this->data);
    }

    //BLOGDETAIL FOR PERICULAR ONE POST END
    //COMMENT INSERT BY USER START
    public function comment_insert() {        
        $id = $_POST['blog_id'];
        $name = $_POST['cname'];
        $email = $_POST['comment_email'];
        $message = $_POST['comment_message'];

        //FOR INSERT READ MORE BLOG START
        $data = array(
            'blog_id' => $id,
            'name' => $name,
            'email' => $email,
            'message' => $message,
            'comment_date' => date('Y-m-d H:i:s'),
            'status' => 'pending'
        );

        $insert_id = $this->common->insert_data_getid($data, 'blog_comment');

        //FOR INSERT READ MORE BLOG END

        if ($insert_id) {
            echo 1;
        } else {
            echo 0;
        }
    }
    // blog available check start
    public function blog_check($slug = " ") {
        $condition_array = array('blog_slug' => $slug);
        $availblog = $this->common->select_data_by_condition('blog', $condition_array, $data = '*', $short_by = '', $order_by = '', $limit, $offset, $join_str = array(), $groupby = '');
       return count($availblog);
    }

    // blog available check start end
    // blog available check start
    public function blog_ajax() {
        // data start
        $perpage = 4;
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }
        if (!empty($_GET["limit"]) && $_GET["limit"] != 'undefined') {
            $perpage = $_GET["limit"];
        }

        // echo $page;
        $start = ($page - 1) * $perpage;
        if ($start < 0)
            $start = 0;
        $searchword = trim($this->input->get('searchword'));
        $sql_condition = "";
        if($searchword){ 
            $blog_detail1 = $this->blog_model->get_blog_post($searchword,'','','','');
            $blog_detail = $this->blog_model->get_blog_post($searchword,'',$start,$perpage,'');
        }else{ 
            $blog_detail1 = $this->blog_model->get_blog_post($searchword,'','','','id');
            $blog_detail = $this->blog_model->get_blog_post($searchword,'',$start,$perpage,'id');            
        }
       
        if(count($blog_detail) > 0){
            foreach ($blog_detail as $key=>$blog) {
                $sql = "SELECT count(id) as total_comment FROM ailee_blog_comment where blog_id = '". $blog['id'] ."'";
                $query = $this->db->query($sql);
                $blog_detail[$key]['total_comment'] = $query->row()->total_comment;

                $blog_detail[$key]['category_name'] = $category_name = $this->blog_model->get_blog_post_category_name($blog['id']);                

                $blog_detail[$key]['social_title'] = urlencode('"' . $blog['title'] . '"');
                $blog_detail[$key]['social_encodeurl'] = urlencode(base_url('blog/' . $blog['blog_slug']));
                $blog_detail[$key]['social_summary'] = urlencode('"' . $blog['description'] . '"');
                $blog_detail[$key]['social_image'] = urlencode(base_url($this->config->item('blog_main_upload_path') . $blog['image']));
                $blog_detail[$key]['social_url'] = base_url('blog/' . $blog['blog_slug']);
                $blog_detail[$key]['blog_category_name'] = explode(',', $category_name);
            }
        }

        if (empty($_GET["total_record"])) {
            $_GET["total_record"] = count($blog_detail1);
        }

        // echo $blog_detail;
        $result['blog_data'] = $blog_detail;
        $result['total_record'] = count($blog_detail1);
        echo json_encode($result);
        exit;

        $blog_data = '';
        $blog_data .= '<input type = "hidden" class = "page_number" value = "' . $page . '" />';
        $blog_data .= '<input type = "hidden" class = "total_record" value = "' . $_GET["total_record"] . '" />';
        $blog_data .= '<input type = "hidden" class = "perpage_record" value = "' . $perpage . '" />';

        // data end

        foreach ($blog_detail as $blog) {
            $blog_data .= '<div class="blog-box">';
                $blog_data .= '<div class="blog-left-img">';
                    $blog_data .= '<a target="_blank" href="' .
                    base_url('blog/' . $blog['blog_slug']) . '"> <img src="' . base_url($this->config->item('blog_main_upload_path') . $blog['image'] .'?ver='.time()) . '" alt="' . $blog['image'] . '"></a>';   
                $blog_data .= '</div>';
                $blog_data .= '<div class="blog-left-content"> <p class="blog-details-cus">
                                    <span class="cat">Categorys</span>
                                    <span>8th March 2018</span>
                                    <span>Dhaval Shah</span>
                                    <span>8 comments</span>
                                    <a target="_blank" href="' . base_url('blog/' . $blog['blog_slug']) . '">
                                        <h3>' . $blog['title'] . '</h3>
                                    </a>
                                    <div class="blog-text">';

            $num_words = 20;
            $words = array();
            $words = explode(" ", $blog['description'], $num_words);
            $shown_string = "";

            if (count($words) == 20) {
                $words[19] = " ...... ";
            }

            $shown_string = implode(" ", $words);
            $blog_data .= $shown_string;

            $blog_data .= '</div>

            <p>
		<ul class="social-icon">
                    <li><a href="#"><i class="fa fa-facebook-f"></i></a></li>
                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                    <li><a href="#"><i class="fa fa-skype"></i></a></li>
		</ul>
            </p>
';
                   
                        
                        
                    
                $blog_data .= '</div>';
            
            $blog_data .= '</div>';
            
            
            $blog_data .= '<div class="blog-box">';
            //$blog_data .= $blog['id'];
            
            $blog_data .= '<div class="date_blog_left">
                                            <div class="blog-date-change">
                                                    <div class="blog-month blog-picker">
                                                        <span class="blog_monthd">';

            $date_time = new DateTime($blog['created_date']);
            $month = $date_time->format('M') . PHP_EOL;
            $blog_data .= $month;

            $blog_data .= '  </span>
                                                    </div>
                                                    <div>
                                                        <span class="blog_mdate">';

            $date = new DateTime($blog['created_date']);
            $blog_data .= $date->format('d') . PHP_EOL;

            $blog_data .= '</span>
                                                    </div>
                                                    <div class="blog-year blog-picker">
                                                        <span class="blog_moyear" >';

            $year = new DateTime($blog['created_date']);
            $blog_data .= $year->format('Y') . PHP_EOL;
            $blog_data .= '</span>
                                                    </div>
                                                </div>
                                                <div class="blog-left-comment">
                                                    <div class="blog-comment-count">
                                                        <a>';
            $condition_array = array('status' => 'approve', 'blog_id' => $blog['id']);
            $blog_comment = $this->common->select_data_by_condition('blog_comment', $condition_array, $data = '*', $short_by = 'id', $order_by = 'desc', $limit, $offset, $join_str = array());

            //echo "<pre>"; print_r($blog_comment); die();
            $blog_data .= count($blog_comment);

            $blog_data .= '</a>
                                                    </div>
                                                    <div class="blog-comment">
                                                        <a>Comments</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="date_blog_right">
                                                <div class="blog_post_main">
                                                    <div class="blog_inside_post_main">
                                                        <div class="blog_main_post_first_part">
                                                            <div class="blog_main_post_img">';
            $blog_data .= '<a target="_blank" href="' .
                    base_url('blog/' . $blog['blog_slug']) . '"> <img src="' . base_url($this->config->item('blog_main_upload_path') . $blog['image'] .'?ver='.time()) . '" alt="' . $blog['image'] . '"></a>';
            $blog_data .= '</div>
                                                        </div>
                                                        <div class="blog_main_post_second_part">
                                                            <div class="blog_class_main_name">
                                                                <span>
                                                                    <a target="_blank" href="' . base_url('blog/' . $blog['blog_slug']) . '">
                                                                        <h1>' . $blog['title'] . '</h1>
                                                                    </a>
                                                                </span>
                                                            </div>
                                                            <div class="blog_class_main_by">
                                                                <span>
                                                                </span>
                                                            </div>
                                                            <div class="blog_class_main_desc ">
                                                                <span class="dot_span_desc">';

            $num_words = 75;
            $words = array();
            $words = explode(" ", $blog['description'], $num_words);
            $shown_string = "";

            if (count($words) == 75) {
                $words[74] = " ...... ";
            }

            $shown_string = implode(" ", $words);
            $blog_data .= $shown_string;

            $blog_data .= '</span>
                                                            </div>
                                                            <div class="blog_class_main_social">
                                                                <div class="left_blog_icon fl">
                                                                    <ul class="social_icon_bloag fl">
                                                                        <li>';

            $title = urlencode('"' . $blog['title'] . '"');
            $url = urlencode(base_url('blog/' . $blog['blog_slug']));
            $summary = urlencode('"' . $blog['description'] . '"');
            $image = urlencode(base_url($this->config->item('blog_main_upload_path') . $blog['image']));

            $blog_data .= '<a class="fbk" id="facebook_link" url_encode="' . $url . '" url="' . base_url('blog/' . $blog['blog_slug']) . '" title="Facebook" summary="' . $summary . '" image="' . $image . '"> 
                                                                                <span  class="social_fb"></span>
                                                                            </a>
                                                                        </li>
                                                                        <li>';


            $blog_data .= '<a href="javascript:void(0)" title="Google +" id="google_link" url_encode="' . $url . '" url="' . base_url('blog/' . $blog['blog_slug']) . '">
                                                                                <span  class="social_gp"></span>
                                                                            </a>';

            $blog_data .= '<a href="javascript:void(0)" title="linkedin" id="linked_link" url_encode="' . $url . '" url="' . base_url('blog/' . $blog['blog_slug']) . '">
                    <span  class="social_lk"></span></a>
                                                                        </li>
                                                                        <li>';
            $blog_data .= '<a href="javascript:void(0)"  title="twitter" id="twitter_link" url_encode="' . $url . '" url="' . base_url('blog/' . $blog['blog_slug']) . '">
                    <span  class="social_tw"></span></a>
                                                                        </li>';
            $blog_data .= '</ul>
                                                                </div>';
            $blog_data .= '<div class="fr blog_view_link">';
                $blog_data .= '<a title="Read more"  href="' .base_url('blog/' . $blog['blog_slug']) . '" target="_blank"> Read more <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
        }

        $record = $_GET["total_record"] / $perpage;

        if ($page > $record) {
            // $lod_message = '<button class="loadmore">No more blog available</button>';  
        } else {
          //  $lod_message = '<img src=" '.base_url('assets/images/loader.gif?ver='.time()).'" alt="'.'LOADERIMAGE'.'"/>';
             $lod_message = '<button class="loadmore">See More ...</button>';
        }

        echo json_encode(array(
            'blog_data' => $blog_data,
            'load_msg' => $lod_message
        ));
    }

    // blog available check start
    public function cat_ajax() {

        // data start
        $perpage = 4;
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }
        if (!empty($_GET["limit"]) && $_GET["limit"] != 'undefined') {
            $perpage = $_GET["limit"];
        }
        $cateid = $_GET["cateid"];
        // echo $page;
        $start = ($page - 1) * $perpage;
        if ($start < 0)
            $start = 0;

        $blog_detail = $this->blog_model->get_blog_post('', $cateid, $start, $perpage, 'id');
        $blog_detail1 = $this->blog_model->get_blog_post('', $cateid, '', '', 'id');

        if(count($blog_detail) > 0){
            foreach ($blog_detail as $key=>$blog) {
                $sql = "SELECT count(id) as total_comment FROM ailee_blog_comment where blog_id = '". $blog['id'] ."'";
                $query = $this->db->query($sql);
                $blog_detail[$key]['total_comment'] = $query->row()->total_comment;

                $blog_detail[$key]['social_title'] = urlencode('"' . $blog['title'] . '"');
                $blog_detail[$key]['social_encodeurl'] = urlencode(base_url('blog/' . $blog['blog_slug']));
                $blog_detail[$key]['social_summary'] = urlencode('"' . $blog['description'] . '"');
                $blog_detail[$key]['social_image'] = urlencode(base_url($this->config->item('blog_main_upload_path') . $blog['image']));
                $blog_detail[$key]['social_url'] = base_url('blog/' . $blog['blog_slug']);
                $blog_detail[$key]['blog_category_name'] = explode(',', $blog['category_name']);
            }
        }

        if (empty($_GET["total_record"])) {
            $_GET["total_record"] = count($blog_detail1);
        }
        // echo $blog_detail;
        $result['blog_data'] = $blog_detail;
        $result['total_record'] = count($blog_detail1);
        echo json_encode($result);
        exit;


        $blog_data = '';
        $blog_data .= '<input type = "hidden" class = "page_number" value = "' . $page . '" />';
        $blog_data .= '<input type = "hidden" class = "catid" value = "' . $cateid . '" />';
        $blog_data .= '<input type = "hidden" class = "total_record" value = "' . $_GET["total_record"] . '" />';
        $blog_data .= '<input type = "hidden" class = "perpage_record" value = "' . $perpage . '" />';

        // data end

        foreach ($blog_detail as $blog) {

            $blog_data .= '<div class="blog_main_o">';
            $blog_data .= '<div class="date_blog_left">
                                            <div class="blog-date-change">
                                                    <div class="blog-month blog-picker">
                                                        <span class="blog_monthd">';

            $date_time = new DateTime($blog['created_date']);
            $month = $date_time->format('M') . PHP_EOL;
            $blog_data .= $month;

            $blog_data .= '  </span>
                                                    </div>
                                                    <div>
                                                        <span class="blog_mdate">';

            $date = new DateTime($blog['created_date']);
            $blog_data .= $date->format('d') . PHP_EOL;

            $blog_data .= '</span>
                                                    </div>
                                                    <div class="blog-year blog-picker">
                                                        <span class="blog_moyear" >';

            $year = new DateTime($blog['created_date']);
            $blog_data .= $year->format('Y') . PHP_EOL;

            $blog_data .= '</span>
                                                    </div>
                                                </div>
                                                <div class="blog-left-comment">
                                                    <div class="blog-comment-count">
                                                        <a>';
            $condition_array = array('status' => 'approve', 'blog_id' => $blog['id']);
            $blog_comment = $this->common->select_data_by_condition('blog_comment', $condition_array, $data = '*', $short_by = 'id', $order_by = 'desc', $limit = 5, $offset, $join_str = array());
            $blog_data .= count($blog_comment);

            $blog_data .= '</a>
                                                    </div>
                                                    <div class="blog-comment">
                                                        <a>Comments</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="date_blog_right">
                                                <div class="blog_post_main">
                                                    <div class="blog_inside_post_main">
                                                        <div class="blog_main_post_first_part">
                                                            <div class="blog_main_post_img">';
            $blog_data .= '<a target="_blank" href="' .
                    base_url('blog/' . $blog['blog_slug']) . '"> <img src="' . base_url($this->config->item('blog_main_upload_path') . $blog['image']) . '" alt="' . $blog['image'] . '" ></a>';
            $blog_data .= '</div>
                                                        </div>
                                                        <div class="blog_main_post_second_part">
                                                            <div class="blog_class_main_name">
                                                                <span>
                                                                    <a target="_blank" href="' . base_url('blog/' . $blog['blog_slug']) . '">
                                                                        <h1>' . $blog['title'] . '</h1>
                                                                    </a>
                                                                </span>
                                                            </div>
                                                            <div class="blog_class_main_by">
                                                                <span>
                                                                </span>
                                                            </div>
                                                            <div class="blog_class_main_desc ">
                                                                <span class="dot_span_desc">';

            $num_words = 75;
            $words = array();
            $words = explode(" ", $blog['description'], $num_words);
            $shown_string = "";

            if (count($words) == 75) {
                $words[74] = " ...... ";
            }

            $shown_string = implode(" ", $words);
            $blog_data .= $shown_string;

            $blog_data .= '</span>
                                                            </div>
                                                            <div class="blog_class_main_social">
                                                                <div class="left_blog_icon fl">
                                                                    <ul class="social_icon_bloag fl">
                                                                        <li>';

            $title = urlencode('"' . $blog['title'] . '"');
            $url = urlencode(base_url('blog/' . $blog['blog_slug']));
            $summary = urlencode('"' . $blog['description'] . '"');
            $image = urlencode(base_url($this->config->item('blog_main_upload_path') . $blog['image']));


            $blog_data .= '<a class="fbk" id="facebook_link" url_encode="' . $url . '" url="' . base_url('blog/' . $blog['blog_slug']) . '" title="Facebook" summary="' . $summary . '" image="' . $image . '"> 
                                                                                <span  class="social_fb"></span>
                                                                            </a>
                                                                        </li>
                                                                        <li>';


            $blog_data .= '<a href="javascript:void(0)" title="Google +" id="google_link" url_encode="' . $url . '" url="' . base_url('blog/' . $blog['blog_slug']) . '">
                                                                                <span  class="social_gp"></span>
                                                                            </a>';

            $blog_data .= '<a href="javascript:void(0)" title="linkedin" id="linked_link" url_encode="' . $url . '" url="' . base_url('blog/' . $blog['blog_slug']) . '">
                    <span  class="social_lk"></span></a>
                                                                        </li>
                                                                        <li>';
            $blog_data .= '<a href="javascript:void(0)"  title="twitter" id="twitter_link" url_encode="' . $url . '" url="' . base_url('blog/' . $blog['blog_slug']) . '">
                    <span  class="social_tw"></span></a>
                                                                        </li>';
            $blog_data .= '</ul>
                                                                </div>';

            $blog_data .= '<div class="fr blog_view_link">';
            $blog_data .= "<a title='Read more' href='" .base_url('blog/' . $blog['blog_slug']) . "' target='_blank'> Read more <i class='fa fa-long-arrow-right' aria-hidden='true'></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>";
        }

        $record = $_GET["total_record"] / $perpage;

        if ($page > $record) {
            //   $lod_message = '<button class="loadcatbutton">No more blog available</button>';  
        } else {
            $lod_message = '<button class="catbutton">Load More ... </button>';
        }

        echo json_encode(array(
            'blog_data' => $blog_data,
            'load_msg' => $lod_message
        ));
    }

    // Get all category of blog list
    function get_blog_cat_list(){
        $sql = "SELECT id,name FROM ailee_blog_category where status = 'publish'";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        echo json_encode($result);
    }

    // Get all category of blog list
    function get_blog_details(){
        $blog_slug = $_GET['blog_slug'];
        $sql = "SELECT b.*,DATE_FORMAT(b.created_date,'%D %M %Y') as created_date_formatted, GROUP_CONCAT(DISTINCT(bc.name)) as category_name
            FROM ailee_blog b, ailee_blog_category bc 
            WHERE b.status = 'publish' AND FIND_IN_SET(bc.id, b.blog_category_id) and
            blog_slug = '". $blog_slug ."' 
            GROUP BY b.blog_category_id ORDER BY `id` DESC";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if(count($result) > 0){
            $sql = "SELECT count(id) as total_comment FROM ailee_blog_comment where status = 'approve' AND blog_id = '". $result[0]['id'] ."'";
            $query = $this->db->query($sql);
            $result[0]['total_comment'] = $query->row()->total_comment;

            $result[0]['social_title'] = urlencode('"' . $result[0]['title'] . '"');
            $result[0]['social_encodeurl'] = urlencode(base_url('blog/' . $result[0]['blog_slug']));
            $result[0]['social_summary'] = urlencode('"' . $result[0]['description'] . '"');
            $result[0]['social_image'] = urlencode(base_url($this->config->item('blog_main_upload_path') . $result[0]['image']));
            $result[0]['social_url'] = base_url('blog/' . $result[0]['blog_slug']);

            $sql = "SELECT b.*,DATE_FORMAT(b.created_date,'%D %M %Y') as created_date_formatted, GROUP_CONCAT(DISTINCT(bc.name)) as category_name
                FROM ailee_blog b, ailee_blog_category bc 
                WHERE b.status = 'publish' AND FIND_IN_SET(bc.id, b.blog_category_id) and
                b.id IN (". $result[0]['blog_related_id'] .") 
                GROUP BY b.blog_category_id ORDER BY b.id DESC";
            $query = $this->db->query($sql);
            $result[0]['related_post'] = $query->result_array();
            foreach ($result[0]['related_post'] as $key => $value) {
                $result[0]['related_post'][$key]['blog_category_name'] = explode(',', $value['category_name']);
            }
            $sql = "SELECT *, DATE_FORMAT(comment_date,'%D %M %Y') as created_date_formatted FROM ailee_blog_comment WHERE status = 'approve' AND blog_id = ". $result[0]['id'] ." ORDER BY id DESC";
            
            $query = $this->db->query($sql);
            $result[0]['all_comment'] = $query->result_array();

            $result[0]['blog_category_name'] = explode(',', $result[0]['category_name']);
        }
        echo json_encode($result);
    }

    function add_subscription(){
        $email = isset($_POST['email']) ? $_POST['email'] : "";
        if($email == ""){
            $result_data = array("success"=>false,"message"=>"Please enter email id");            
        }else{
            $sql_sub_exisit = "SELECT * FROM ailee_subscription where email = '". $email ."'";
            $query_sub_exisit = $this->db->query($sql_sub_exisit);
            $result_sub_exisit = $query_sub_exisit->result_array();
            if(count($result_sub_exisit) > 0){
                $result_data = array("error"=>true,"message"=>"already subscribe");
            }else{
                $subscribe_data = array("email" => $email, "status" => '1');
                $this->db->insert('subscription', $subscribe_data);
                $insert_id = $this->db->insert_id();
                $result_data = array("success"=>true,"message"=>$insert_id);
            }
        }
        echo json_encode($result_data);
    }

    function recent_blog_list(){
        $condition_array = array('status' => 'publish');
        $recent_blog_list = $this->common->select_data_by_condition('blog', $condition_array, $data = '*,DATE_FORMAT(created_date,"%D %M %Y") as created_date_formatted', $short_by = 'id', $order_by = 'desc', $limit = 5, $offset, $join_str = array());
        echo json_encode($recent_blog_list);
    }

    public function load_more_comment()
    {
        $blog_id = $_POST['blog_id'];
        $page = $_POST['page'];
        $limit = 3;
        $commen_data = $this->blog_model->get_loadmore_comment($blog_id,$page,$limit);
        $html = "";
        foreach($commen_data as $_commen_data)
        {
            $html .= '<div class="comment-box">
                <div class="comment-img post-head">
                    <span class="post-img">'.ucwords($_commen_data['name'][0]).'
                    </span>
                </div>
                <div class="comment-text">
                    <h4>'.ucwords($_commen_data['name']).'</h4>
                    <span>'.$_commen_data['created_date_formatted'].'</span>
                    <p>'.$_commen_data['message'].'</p>
                </div>
            </div>';
        }
        echo $html;exit;
    }
}
