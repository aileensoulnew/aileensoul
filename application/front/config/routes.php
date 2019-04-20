<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/


/* product Login end */
//$route['login'] = 'Login/index';

$route['default_controller'] = 'main';
//$route['default_controller'] = 'user_post';

$route['login'] = 'Login/index';
$route['registration'] = 'Registration/index';
$route['basic-information'] = 'user_info';
$route['educational-information'] = 'user_info';

$route['logout'] = 'dashboard/logout';
$route['dashboard/image'] = 'dashboard/image';
$route['dashboard/photos/(:any)'] = 'Userprofile';
$route['dashboard/header_all_dropdown_list'] = 'dashboard/header_all_dropdown_list';

$route['dashboard/(:any)'] = 'Userprofile';
$route['profiles/(:any)'] = 'Userprofile';
$route['details/(:any)'] = 'Userprofile';
$route['followers/(:any)'] = 'Userprofile';
$route['following/(:any)'] = 'Userprofile';
$route['contacts/(:any)'] = 'Userprofile';
$route['questions/(:any)'] = 'Userprofile';
$route['search'] = 'user_post/search';
// $route['post-detail/(:any)'] = 'user_post/post_detail/$1';

$route['userprofile_page'] = 'userprofile_page';
$route['userprofile_page/(:any)'] = 'userprofile_page/$1';

$route['opportunities'] = 'user_post';
$route['contact-request'] = 'userprofile_page/contact_request';

$route['questions/(:any)/(:any)'] = 'userprofile_page/question_detail/$1/$2';

//$route['default_controller'] = 'under_construction';


$route['404_override'] = 'My404Page';
//$route['translate_uri_dashes'] = FALSE;


$route['about-us'] = "about_us";
$route['disclaimer-policy'] = "Disclaimer";
$route['contact-us'] = "contact_us";
$route['terms-and-condition'] = "main/terms_condition";
$route['privacy-policy'] = "main/privacy_policy";
$route['advertise-with-us'] = "advertise_with_us";

$route['sitemap'] = "sitemap/sitemap";

/*$route['sitemap/people'] = "sitemap/sitemap_inner";
$route['sitemap/people/(:any)'] = "sitemap/sitemap_inner/$1";*/

$route['sitemap/people'] = "sitemap/sitemap_member";
$route['sitemap/people/(:any)'] = "sitemap/sitemap_member/$1";
$route['sitemap/people/(:any)/(:num)'] = "sitemap/sitemap_member/$1";

/*$route['sitemap/artist'] = "sitemap/sitemap_inner";
$route['sitemap/artist/(:any)'] = "sitemap/sitemap_inner/$1";*/

$route['sitemap/artist'] = "sitemap/sitemap_artist";
$route['sitemap/artist/(:any)'] = "sitemap/sitemap_artist/$1";
$route['sitemap/artist/(:any)/(:num)'] = "sitemap/sitemap_artist/$1";

/*$route['sitemap/companies'] = "sitemap/sitemap_inner";
$route['sitemap/companies/(:any)'] = "sitemap/sitemap_inner/$1";*/

$route['sitemap/companies'] = "sitemap/sitemap_companies";
$route['sitemap/companies/(:any)'] = "sitemap/sitemap_companies/$1";
$route['sitemap/companies/(:any)/(:num)'] = "sitemap/sitemap_companies/$1";

/*$route['sitemap/jobs'] = "sitemap/sitemap_inner";
$route['sitemap/jobs/(:any)'] = "sitemap/sitemap_inner/$1";*/

$route['sitemap/jobs'] = "sitemap/sitemap_jobs";
$route['sitemap/jobs/(:any)'] = "sitemap/sitemap_jobs/$1";
$route['sitemap/jobs/(:any)/(:num)'] = "sitemap/sitemap_jobs/$1";

/*$route['sitemap/freelance-jobs'] = "sitemap/sitemap_inner";
$route['sitemap/freelance-jobs/(:any)'] = "sitemap/sitemap_inner/$1";*/

$route['sitemap/freelance-jobs'] = "sitemap/sitemap_freelance_jobs";
$route['sitemap/freelance-jobs/(:any)'] = "sitemap/sitemap_freelance_jobs/$1";
$route['sitemap/freelance-jobs/(:any)/(:num)'] = "sitemap/sitemap_freelance_jobs/$1";

$route['sitemap/opportunities'] = "sitemap/sitemap_opportunities";
$route['sitemap/opportunities/(:any)'] = "sitemap/sitemap_opportunities/$1";
$route['sitemap/opportunities/(:any)/(:num)'] = "sitemap/sitemap_opportunities/$1";

$route['sitemap/article'] = "sitemap/sitemap_article";
$route['sitemap/article/(:any)'] = "sitemap/sitemap_article/$1";
$route['sitemap/article/(:any)/(:num)'] = "sitemap/sitemap_article/$1";

$route['sitemap/questions'] = "sitemap/sitemap_questions";
$route['sitemap/questions/(:any)'] = "sitemap/sitemap_questions/$1";
$route['sitemap/questions/(:any)/(:num)'] = "sitemap/sitemap_questions/$1";

$route['sitemap/blogs'] = "sitemap/blogs";
$route['sitemap/blogs/(:any)'] = "sitemap/blogs_category/$1";
$route['sitemap/blogs/(:any)/(:num)'] = "sitemap/blogs_category/$1";

// $route['sitemap/job-profile'] = "sitemap/job_profile";
// $route['sitemap/recruiter-profile'] = "sitemap/recruiter_profile";
// $route['sitemap/freelance-profile'] = "sitemap/freelance_profile";
// $route['sitemap/business-profile'] = "sitemap/business_profile";
// $route['sitemap/artistic-profile'] = "sitemap/artistic_profile";

$route['load_more/dataaaaa'] = "load_more/dataaaaa";


$route['edit-profile'] = "profile";
$route['change-password'] = "registration/changepassword";
$route['subscribe'] = "registration/subscribe";
$route['profiles'] = "dashboard";
$route['profiles/basic-information/(:any)'] = "user_basic_info";
$route['profiles/opportunities/(:any)'] = "user_opportunities";
//$route['profiles/(:any)'] = "dashboard";


//$route['business-profile'] = "business_profile/index";
$route['business-search'] = "business_live/index";

// $route['business-profile/category'] = "business_live/category";
$route['business/search'] = "business_live/business_search";


// $route['business-profile/reactivate'] = "business_profile/reactivate";
$route['business/reactivateacc'] = "business_profile/reactivateacc";

//$route['business-profile/business-information'] = "business_profile/business_information";
//$route['business-profile/business-information-insert'] = "business_profile/business_information_insert";
//$route['business-profile/business-information-update'] = "business_profile/business_information_update";
//$route['business-profile/business-information-edit'] = "business_profile/business_information_update";
//$route['business-profile/contact-information'] = "business_profile/contact_information";
//$route['business-profile/contact-information-insert'] = "business_profile/contact_information_insert";
//$route['business-profile/description'] = "business_profile/description";
//$route['business-profile/description-insert'] = "business_profile/description_insert";
//$route['business-profile/image'] = "business_profile/image";
$route['business-profile'] = "business_profile_live/business_profile_post";
$route['business-profile/image-insert'] = "business_profile/image_insert";
// $route['business-profile/details'] = "business_profile_live/business_resume";

$route['business-profile/bussiness-profile-post-add'] = "business_profile/business_profile_addpost_insert";
$route['business-profile/bussiness-profile-post-add/manage/(:any)'] = "business_profile/business_profile_addpost_insert/manage/$1";

$route['business-profile/dashboard'] = "business_profile_live/business_profile_manage_post";

$route['business-profile/followers'] = "business_profile_live/followers";
$route['business-profile/following'] = "business_profile_live/following";
$route['business-profile/userlist'] = "business_profile_live/userlist";
// $route['business-profile/userlist/(:any)'] = "business_profile_live/userlist/$1";
// $route['business-profile/contact-list'] = "business_profile_live/contact_list";
$route['company/contact-requests'] = "business_profile_live/contact_list";
$route['business-profile/contacts'] = "business_profile_live/bus_contact";
$route['business-profile/user-image-change'] = "business_profile/user_image_insert";
$route['business-profile/business-profile-save-post'] = "business_profile/business_profile_save_post";
$route['business-profile/business-profile-addpost'] = "business_profile/business_profile_addpost";
$route['business-profile/photos'] = "business_profile_live/business_photos";
$route['business-profile/videos'] = "business_profile_live/business_videos";
$route['business-profile/audios'] = "business_profile_live/business_audios";
$route['business-profile/pdf'] = "business_profile_live/business_pdf";
$route['business-profile/business-profile-contactperson'] = "business_profile/business_profile_contactperson";
$route['business-profile/contact-person/(:any)'] = "business_profile/business_profile_contactperson/$1";
$route['business-profile/post-detail'] = "business_profile_live/postnewpage";

$route['business-profile/creat-pdf'] = "business_profile/creat_pdf";
$route['business-profile/business-profile-editpost'] = "business_profile/business_profile_editpost";
$route['notification/business-profile-post/(:any)'] = "notification/business_post/$1";
$route['notification/business-profile-post-detail/(:any)/(:any)'] = "notification/bus_post_img/$1/$2";


//$route['business-profile/signup/business-information'] = "business_profile_registration/business_information";
//$route['business-profile/signup/contact-information'] = "business_profile_registration/contact_information";
//$route['business-profile/signup/description'] = "business_profile_registration/description";
//$route['business-profile/signup/image'] = "business_profile_registration/image";

$route['business-profile/registration/business-information'] = "business_profile_registration_live/business_registration/$1";
$route['business-profile/registration/contact-information'] = "business_profile_registration_live/business_registration/$1";
$route['business-profile/registration/description'] = "business_profile_registration_live/business_registration/$1";
$route['business-profile/registration/image'] = "business_profile_registration_live/business_registration/$1";

$route['business-profile/signup/edit/business-information'] = "business_profile_registration/business_information_edit";
$route['business-profile/signup/edit/contact-information'] = "business_profile_registration/contact_informatio_edit";
$route['business-profile/signup/edit/description'] = "business_profile_registration/description_edit";
$route['business-profile/signup/edit/image'] = "business_profile_registration/image_edit";
//$route['business-profile/signup/business-registration'] = "business_profile_registration/business_registration";

// $route['business_profile/reactivate'] = "business_profile_live/reactivate";


// $route['business-profile/location'] = "business_live/location";

$route['message/b/(:any)'] = "message/business_profile/$1";
$route['message/rj/(:any)'] = "recmessage/recjob/$1";

$route['freelance-profile'] = "freelancer";
// $route['freelance'] = "freelancer";



//FREELANCER HIRE ROUTES SETTINGS
// $route['freelance-hire'] = "freelancer_hire_live/freelancer_hire";
$route['freelance-employer'] = "freelancer_hire_live/freelancer_hire";
// $route['freelance-hire/home'] = "freelancer_hire_live/recommen_candidate";
$route['hire-freelancer'] = "freelancer_hire_live/recommen_candidate";
$route['freelance-hire/employer-details'] = "freelancer_hire_live/freelancer_hire_profile";
// $route['freelance-hire/employer-details/(:any)'] = "freelancer_hire_live/freelancer_hire_profile/$1";
$route['freelance-employer/projects'] = "freelancer_hire_live/freelancer_hire_post";
$route['freelance-employer/projects/(:any)'] = "freelancer_hire_live/freelancer_hire_post/$1";
$route['freelance-employer/saved-freelancer'] = "freelancer_hire_live/freelancer_save";
// $route['freelance-hire/add-projects'] = "freelancer_hire_live/freelancer_add_post";
$route['post-freelance-project'] = "freelancer_hire_live/freelancer_add_post";
$route['freelance-employer/basic-information'] = "freelancer_hire_live/freelancer_hire_basic_info";
$route['freelance-employer/address-information'] = "freelancer_hire_live/freelancer_hire_address_info";
$route['freelance-employer/professional-information'] = "freelancer_hire_live/freelancer_hire_professional_info";

$route['freelance-employer/search'] = "search_live/freelancer_hire_search";
$route['freelance-employer/search/0/(:any)'] = "search_live/freelancer_hire_search/0/$1";
$route['freelance-employer/search/(:any)/0'] = "search_live/freelancer_hire_search/$1/0";
$route['freelance-employer/search/(:any)/(:any)'] = "search_live/freelancer_hire_search/$1/$2";

// $route['freelance-hire/search'] = "search_live/freelancer_hire_search";
// $route['freelance-hire/search/0/(:any)'] = "search_live/freelancer_hire_search/0/$1";
// $route['freelance-hire/search/(:any)/0'] = "search_live/freelancer_hire_search/$1/0";
// $route['freelance-hire/search/(:any)/(:any)'] = "search_live/freelancer_hire_search/$1/$2";



$route['freelance-employer/edit-projects/(:any)'] = "freelancer_hire_live/freelancer_edit_post/$1";
$route['freelance-hire/reactivate'] = "freelancer_hire_live/reactivate";
$route['freelance-hire/deactivate'] = "freelancer_hire_live/deactivate_hire";
$route['freelance-employer/applied-freelancers/(:any)'] = "freelancer_hire_live/freelancer_apply_list/$1";
$route['notification/freelance-hire/(:any)'] = "notification/freelancer_hire_post/$1";
// $route['freelance-hire/project'] = "freelancer_hire_live/live_post";
// $route['freelance-hire/project/(:any)'] = "freelancer_hire_live/live_post/$1";
$route['freelance-employer/shortlisted-freelancers/(:any)'] = "freelancer_hire_live/freelancer_shortlist_list/$1";
// $route['freelance-hire/registration'] = "freelancer_hire_live/hire_registation";
$route['freelance-employer/signup'] = "freelancer_hire_live/hire_registation";
$route['freelance-hire/registration/live-post'] = "freelancer_hire/hire_registation";
$route['freelance-hire/reactivateacc'] = "freelancer_hire_live/reactivateacc";

$route['freelancer/ajax_recommen_candidate'] = "freelancer/ajax_recommen_candidate";
//$route['freelance-hire'] = "freelancer_hire/freelancer_hire/freelancer_hire_basic_info";



 // $route['projects'] = "search/freelancer_post_search";
 // $route['projects/(:any)'] = "search/freelancer_post_search/$1";

// $route['(:any)-project'] = "search/freelancer_post_search";
// $route['project-in-(:any)'] = "search/freelancer_post_search";
// $route['(:any)-project-in-(:any)'] = "search/freelancer_post_search";

// $route['freelance-work'] = "freelancer/freelancer_post";
//$route['freelance-work/home/'] = "freelancer/freelancer_apply_post";
//$route['freelance-work/home/live-post'] = "freelancer/freelancer_apply_post";
//$route['freelance-work/home/live-post/(:any)'] = "freelancer/freelancer_apply_post/$1";

//$route['freelance-work/profile'] = "freelancer/freelancer_apply_reg";
$route['freelance-work/profile/live-post'] = "freelancer/registation";
$route['freelance-work/profile/live-post/(:any)'] = "freelancer/registation/$1";

// $route['freelance-work'] = "freelancer_apply_live/index";
$route['freelance-jobs'] = "freelancer_apply_live/index";
$route['freelance-jobs/(:any)'] = "freelancer_apply_live/freelance_apply_field_cat_no_login/$1";
$route['freelance-jobs/(:any)/(:num)'] = "freelancer_apply_live/freelance_apply_field_cat_no_login/$1";
$route['freelance-jobs/(:any)/(:any)'] = "freelancer_hire_live/live_post/$1";
//$route['freelance-jobs-by-categories'] = "freelancer_apply_live/view_more_freelancer_apply";
// $route['freelance-jobs-by-skills'] = "freelancer_apply_live/view_more_freelancer_apply";
//$route['freelance-jobs-by-fields'] = "freelancer_apply_live/view_more_freelancer_apply";
$route['freelance-jobs-by-fields'] = "freelancer_apply_live/freelance_jobs_by_fields";
$route['freelance-jobs-by-fields/(:any)'] = "freelancer_apply_live/freelance_jobs_by_fields";
$route['freelance-jobs-by-categories'] = "freelancer_apply_live/freelance_jobs_by_categories";
$route['freelance-jobs-by-categories/(:any)'] = "freelancer_apply_live/freelance_jobs_by_categories";

$route['freelance-work/category'] = "freelancer_apply_live/category";
$route['freelance-work/category/(:any)'] = "freelancer_apply_live/categoryFreelancerList/$1";

/* Report Route end */



//ARTISTIC ROUTES SETTINGS


//$route['artist'] = "artist/index";
$route['find-artist'] = "artist_live/index";
$route['artist-profile/signup'] = "artist_live/registration";
// $route['artist/registration'] = "artist_live/registration";
$route['artist/ajax_data'] = "artist_live/ajax_data";


$route['artist/followers'] = "artist_live/followers";
$route['artist/following'] = "artist_live/userlist";

// $route['artist/category'] = "artist_live/category";
// $route['artist/category/(:any)'] = "artist_live/categoryArtistList/$1";
$route['artist/search'] = "artist_live/artist_search";

$route['artist/artistic-basic-information-insert'] = "artist_live/art_basic_information_insert";
$route['artist/edit-information'] = "artist_live/art_basic_information_update";

$route['artist/artistic-address'] = "artist_live/art_address";
$route['artist/artistic-address-insert'] = "artist_live/art_address_insert";

$route['artist/artistic-information'] = "artist_live/art_information";
$route['artist/artistic-information-insert'] = "artist_live/art_information_insert";

$route['artist/artistic-portfolio'] = "artist/art_portfolio";
$route['artist/artistic-portfolio-insert'] = "artist/art_portfolio_insert";

$route['artist/dashboard'] = "artist_live/art_manage_post";
// $route['artist/dashboard/(:any)'] = "artist_live/art_manage_post/$1";


// $route['artist/details/(:any)'] = "artist_live/artistic_profile/$1";
$route['artist/p/(:any)/details'] = "artist_live/artistic_profile/$1";
$route['artist-new/p/(:any)/details'] = "artist_live/artistic_profile_new/$1";
$route['artist/details'] = "artist_live/artistic_profile";

$route['artist/photos'] = "artist_live/art_photos";
$route['artist/p/(:any)/photos'] = "artist_live/art_photos/$1";
// $route['artist/photos/(:any)'] = "artist_live/art_photos/$1";

$route['artist/videos'] = "artist_live/art_videos";
$route['artist/p/(:any)/videos'] = "artist_live/art_videos/$1";
// $route['artist/videos/(:any)'] = "artist_live/art_videos/$1";

$route['artist/audios'] = "artist_live/art_audios";
$route['artist/p/(:any)/audios'] = "artist_live/art_audios/$1";


$route['artist/pdf'] = "artist_live/art_pdf";
$route['artist/p/(:any)/pdf'] = "artist_live/art_pdf/$1";

$route['artist/post-detail'] = "artist_live/postnewpage";
$route['artist/post-detail/(:any)'] = "artist_live/postnewpage/$1";

$route['artist/creat-pdf'] = "artist/creat_pdf";


$route['artist/reactivate'] = "artist_live/reactivate";
$route['artist/reactivateacc'] = "artist_live/reactivateacc";


// $route['artist/location'] = "artist_live/location";
$route['artist_live/artistCategory'] = "artist_live/artistCategory";
$route['artist/insert_commentthree_postnewpage'] = "artist/insert_commentthree_postnewpage";
$route['artist/postnewpage_fourcomment'] = "artist/postnewpage_fourcomment";
$route['artist/p/(:any)/following'] = "artist_live/following/$1";
$route['artist/p/(:any)/followers'] = "artist_live/followers/$1";
// $route['artist/location/(:any)'] = "artist_live/locationArtistList/$1";

$route['artist-profile'] = "artist_live/art_post"; 
$route['artist/profile_insert'] = "artist/profile_insert";
$route['artist/edit_post_insert'] = "artist/edit_post_insert";
$route['artist/art_delete_post'] = "artist/art_delete_post";
$route['artist/showuser'] = "artist/showuser";
$route['artist/follow_home'] = "artist/follow_home";
$route['artist/artistic_home_follow_ignore'] = "artist/artistic_home_follow_ignore";
$route['artist/art_home_post'] = "artist/art_home_post";
$route['artist/art_home_three_user_list'] = "artist/art_home_three_user_list"; 
$route['artist/art_post_insert'] = "artist/art_post_insert/"; 
$route['artist/like_post'] = "artist/like_post"; 
$route['artist/like_comment'] = "artist/like_comment"; 
$route['artist/like_comment1'] = "artist/like_comment1"; 
$route['artist/delete_comment'] = "artist/delete_comment"; 
$route['artist/delete_commenttwo'] = "artist/delete_commenttwo"; 
$route['artist/insert_commentthree'] = "artist/insert_commentthree"; 
$route['artist/insert_comment'] = "artist/insert_comment";  
$route['artist/edit_comment_insert'] = "artist/edit_comment_insert"; 
$route['artist/fourcomment'] = "artist/fourcomment"; 
$route['artist/artistic_save'] = "artist/artistic_save"; 
$route['artist/del_particular_userpost'] = "artist/del_particular_userpost"; 
$route['artist/likeuserlist'] = "artist/likeuserlist"; 
$route['artist/edit_more_insert'] = "artist/edit_more_insert"; 
$route['artist/art_designation'] = "artist/art_designation"; 
$route['artist/profilepic'] = "artist/profilepic"; 
$route['artist/ajaxpro'] = "artist/ajaxpro"; 
$route['artist/artistic_dashboard_post'] = "artist/artistic_dashboard_post/"; 
$route['artist/artistic_dashboard_post/(:any)'] = "artist/artistic_dashboard_post/$1"; 
$route['artist/ajax_followers/'] = "artist/ajax_followers"; 
$route['artist/ajax_followers/(:any)'] = "artist/ajax_followers/$1";
$route['artist/ajax_following/'] = "artist/ajax_following"; 
$route['artist/ajax_following/(:any)'] = "artist/ajax_following/$1"; 
$route['artist/artistic_photos'] = "artist/artistic_photos"; 
$route['artist/artistic_videos'] = "artist/artistic_videos"; 
$route['artist/artistic_audio'] = "artist/artistic_audio"; 
$route['artist/artistic_pdf'] = "artist/artistic_pdf"; 
$route['artist/userlist'] = "artist_live/userlist"; 
$route['artist/ajax_userlist'] = "artist/ajax_userlist"; 
$route['artist/image'] = "artist/image"; 
$route['artist/follow'] = "artist/follow"; 
$route['artist/unfollow'] = "artist/unfollow"; 
$route['artist/artistic_search_keyword'] = "artist/artistic_search_keyword"; 
$route['artist/artistic_search_city'] = "artist/artistic_search_city"; 
$route['artist/followtwo'] = "artist/followtwo"; 
$route['artist/follow_two'] = "artist/follow_two"; 
$route['artist/unfollow_two'] = "artist/unfollow_two"; 
$route['artist/unfollowtwo'] = "artist/unfollowtwo"; 
$route['artist/unfollow_following'] = "artist/unfollow_following"; 
$route['login/artistic_check_login'] = "login/artistic_check_login"; 
$route['artist/like_postimg'] = "artist/like_postimg"; 
$route['artist/fourcommentimg'] = "artist/fourcommentimg"; 
$route['artist/insert_commentimg'] = "artist/insert_commentimg"; 
$route['artist/insert_commentthreeimg'] = "artist/insert_commentthreeimg"; 
$route['artist/edit_comment_insertimg'] = "artist/edit_comment_insertimg"; 
$route['artist/delete_commentimg'] = "artist/delete_commentimg";

$route['artist/generate_artist_profile'] = "artist/generate_artist_profile";
$route['artist/send_promotional_main_in_back'] = "artist/send_promotional_main_in_back";

/*$route['artist/category'] = "artist_live/view_more_artist";
$route['artist/location'] = "artist_live/view_more_artist";
$route['artist'] = "artist_live/view_more_artist";*/

$route['artist/category'] = "artist_live/category";
$route['artist/category/(:num)'] = "artist_live/category";
$route['artist/location'] = "artist_live/location";
$route['artist/location/(:num)'] = "artist_live/location";
$route['artist'] = "artist_live/artist_by_artist";

//BLOG ROUTES SETTINGS
//$route['blog/popular'] = "blog/popular";
//$route['blog/read_more'] = "blog/read_more";
$route['blog'] = "blog/index";
$route['blog/(:num)'] = "blog/index";
$route['blog/blog_ajax'] = "blog/blog_ajax";
$route['blog/cat_ajax'] = "blog/cat_ajax";
$route['blog/get_blog_cat_list'] = "blog/get_blog_cat_list";
$route['blog/comment_insert'] = "blog/comment_insert";
$route['blog/load_more_comment'] = "blog/load_more_comment";
$route['blog/add_subscription'] = "blog/add_subscription";
$route['blog/get_blog_details'] = "blog/get_blog_details";
$route['blog/recent_blog_list'] = "blog/recent_blog_list";

$route['blog/category/(:any)'] = "blog/index/$1/true";
$route['blog/category/(:any)/(:num)'] = "blog/index/$1/true";
$route['blog/add_guest'] = "blog/add_guest";

//$route['blog/tag/(:any)'] = "blog/tagsearch/$1";
//$route['blog/page/(:any)'] = "blog/index/$1";
$route['blog/(:any)'] = "blog/index/$1";

$route['guest-contributor'] = "blog/guest_contributor";

//JOB ROUTES SETTINGS

//$route['job'] = "job_live/index";
$route['job-search'] = "job_live/index";
$route['job/category/(:any)'] = "job_live/category/$1";
$route['job/city/(:any)'] = "job_live/city/$1";
$route['job/skill/(:any)'] = "job_live/skill/$1";
$route['job/company/(:any)'] = "job_live/company/$1";
//$route['job/search'] = "job_live/job_search";
$route['job/reactivateacc'] = "job_live/reactivateacc";

$route['jobs/search/(.+)'] = "job_live/job_search_new";
// $route['jobs/search/(:any)-jobs'] = "job_live/job_search_new/$1-jobs";
// $route['jobs/search/jobs-in-(:any)'] = "job_live/job_search_new/jobs-in-$1";
// $route['jobs/search/(:any)-jobs-in-(:any)'] = "job_live/job_search_new/$1-jobs-in-$2";
// $route['artist/(:any)-in-(:any)'] = "artist_live/artist_search/$1-in-$2";

$route['recommended-jobs'] = "job/job_all_post";
$route['job/home/live-post'] = "job/job_all_post/$1";

// $route['job/resume'] = "job/job_printpreview";//old
// $route['job/resume/(:any)'] = "job/job_printpreview/$1";//old

$route['job-profile'] = "job/job_printpreview";

// $route['job/saved-job'] = "job/job_save_post";//Old
$route['job-profile/saved-job'] = "job/job_save_post";

// $route['job/applied-job'] = "job/job_applied_post";//Old
$route['job-profile/applied-job'] = "job/job_applied_post";

//$route['job/basic-information'] = "job/job_basicinfo_update";//Old
$route['job-profile/basic-information'] = "job/job_basicinfo_update";

// $route['job/qualification'] = "job/job_education_update";//Old
// $route['job/qualification/(:any)'] = "job/job_education_update/$1";//Old

$route['job-profile/qualification'] = "job/job_education_update";
$route['job-profile/qualification/(:any)'] = "job/job_education_update/$1";

// $route['job/project'] = "job/job_project_update"; //Old
$route['job-profile/project'] = "job/job_project_update";
// $route['job/work-area'] = "job/job_skill_update";//Old
$route['job-profile/work-area'] = "job/job_skill_update";
// $route['job/work-experience'] = "job/job_work_exp_update";//Old
$route['job-profile/work-experience'] = "job/job_work_exp_update";

$route['job-profile/create-account'] = "job_live/job_register_new";
$route['job-profile/basic-info'] = "job_live/job_register_new";
$route['job-profile/educational-info'] = "job_live/job_register_new";
$route['job-profile/registration'] = "job_live/job_register_new";

$route['job-profile/signup'] = "job/job_reg";
$route['job/registration/live-post'] = "job/job_reg";
$route['job/registration/live-post/(:any)'] = "job/job_reg/$1";
$route['job-profile/(:any)'] = "job/job_printpreview/$1";
$route['job-profile-new/(:any)'] = "job/job_printpreviewnew/$1";

$route['artist-profile/create-account'] = "artist_live/artist_register_new";
$route['artist-profile/basic-info'] = "artist_live/artist_register_new";
$route['artist-profile/educational-info'] = "artist_live/artist_register_new";
$route['artist-profile/registration'] = "artist_live/artist_register_new";

$route['artist/profile_insert_new'] = "artist/profile_insert_new";
$route['artist/art_basic_information_insert'] = "artist/art_basic_information_insert";
$route['artist/art_address_insert'] = "artist/art_address_insert";
$route['artist/art_information_insert'] = "artist/art_information_insert";


$route['recruiter/create-account'] = "recruiter/recruiter_register_new";
$route['recruiter/general-info'] = "recruiter/recruiter_register_new";
$route['recruiter/educational-info'] = "recruiter/recruiter_register_new";
$route['recruiter/registration'] = "recruiter/recruiter_register_new";

$route['business-profile/create-account'] = "business_profile_live/business_register_new";
$route['business-profile/basic-info'] = "business_profile_live/business_register_new";
$route['business-profile/educational-info'] = "business_profile_live/business_register_new";
$route['business-profile/registration'] = "business_profile_live/business_register_new";

//Freelance hire Signup start
$route['freelance-employer/create-account'] = "freelancer_hire_live/freelancer_hire_register_new";
$route['freelance-employer/general-info'] = "freelancer_hire_live/freelancer_hire_register_new";
$route['freelance-employer/educational-info'] = "freelancer_hire_live/freelancer_hire_register_new";
$route['freelance-employer/registration'] = "freelancer_hire_live/freelancer_hire_register_new";
//Freelance hire Signup End

//Freelance Apply Signup start
$route['freelancer/create-account'] = "freelancer_apply_live/freelancer_apply_register_new";
$route['freelancer/general-info'] = "freelancer_apply_live/freelancer_apply_register_new";
$route['freelancer/educational-info'] = "freelancer_apply_live/freelancer_apply_register_new";
$route['freelancer/registration'] = "freelancer_apply_live/freelancer_apply_register_new";

// $route['freelancer/search/(:any)'] = "freelancer_apply_live/$1";
// $route['freelancer/search/projects-in-(:any)'] = "freelancer_apply_live/$1";
// $route['freelancer/search/(:any)projects-in-(:any)'] = "freelancer_apply_live/$1";
$route['freelancer/search/(.+)'] = "freelancer_apply_live/freelancer_apply_search_new";

//FREELANCER APPLY ROUTES SETTINGS
//$route['freelance-work/home'] = "freelancer/freelancer_apply_post";
$route['recommended-freelance-work'] = "freelancer/freelancer_apply_post";
$route['freelance-work/home/live-post'] = "freelancer/freelancer_apply_post/$1";
// $route['freelance-work/freelancer-details/(:any)'] = "freelancer/freelancer_post_profile/$1";//old
// $route['freelance-work/freelancer-details'] = "freelancer/freelancer_post_profile";//old


// $route['freelance-work/saved-projects'] = "freelancer/freelancer_save_post";//old
$route['freelancer/saved-projects'] = "freelancer/freelancer_save_post";

//$route['freelance-work/applied-projects'] = "freelancer/freelancer_applied_post";//old
$route['freelancer/applied-projects'] = "freelancer/freelancer_applied_post";

//$route['freelance-work/basic-information'] = "freelancer/freelancer_post_basic_information";//old
$route['freelancer/basic-information'] = "freelancer/freelancer_post_basic_information";

//$route['freelance-work/address-information'] = "freelancer/freelancer_post_address_information";//old
//$route['freelance-work/address-information/(:any)'] = "freelancer/freelancer_post_address_information/$1";//old
$route['freelancer/address-information'] = "freelancer/freelancer_post_address_information";
$route['freelancer/address-information/(:any)'] = "freelancer/freelancer_post_address_information/$1";

//$route['freelance-work/professional-information'] = "freelancer/freelancer_post_professional_information";
//$route['freelance-work/professional-information/(:any)'] = "freelancer/freelancer_post_professional_information/$1";

$route['freelancer/professional-information'] = "freelancer/freelancer_post_professional_information";
$route['freelancer/professional-information/(:any)'] = "freelancer/freelancer_post_professional_information/$1";

// $route['freelance-work/rate'] = "freelancer/freelancer_post_rate";
// $route['freelance-work/rate/(:any)'] = "freelancer/freelancer_post_rate/$1";
$route['freelancer/rate'] = "freelancer/freelancer_post_rate";
$route['freelancer/rate/(:any)'] = "freelancer/freelancer_post_rate/$1";

// $route['freelance-work/avability'] = "freelancer/freelancer_post_avability";
// $route['freelance-work/avability/(:any)'] = "freelancer/freelancer_post_avability/$1";
$route['freelancer/availability'] = "freelancer/freelancer_post_avability";
$route['freelancer/availability/(:any)'] = "freelancer/freelancer_post_avability/$1";

// $route['freelance-work/education'] = "freelancer/freelancer_post_education";
// $route['freelance-work/education/(:any)'] = "freelancer/freelancer_post_education/$1";
$route['freelancer/education'] = "freelancer/freelancer_post_education";
$route['freelancer/education/(:any)'] = "freelancer/freelancer_post_education/$1";

// $route['freelance-work/portfolio'] = "freelancer/freelancer_post_portfolio";
// $route['freelance-work/portfolio/(:any)'] = "freelancer/freelancer_post_portfolio/$1";
$route['freelancer/portfolio'] = "freelancer/freelancer_post_portfolio";
$route['freelancer/portfolio/(:any)'] = "freelancer/freelancer_post_portfolio/$1";

$route['freelance-work/search'] = "search/freelancer_post_search";
$route['freelance-work/deactivate'] = "freelancer/deactivate";
$route['freelance-work/reactivate'] = "freelancer/reactivate";
//$route['freelance-work/registration'] = "freelancer/registation";//old
$route['freelancer/signup'] = "freelancer/registation";
// $route['freelance-work'] = "freelancer_live/freelancer_post/freelancer_post_basic_information";



$route['freelancer/index'] = "freelancer/index";
$route['freelancer/freelancer_post'] = "freelancer/freelancer_post";
$route['freelancer/freelancer_post_basic_information'] = "freelancer/freelancer_post_basic_information";
$route['freelancer/freelancer_post_basic_information_insert'] = "freelancer/freelancer_post_basic_information_insert";
$route['freelancer/setcategory_slug'] = "freelancer/setcategory_slug";
$route['freelancer/comparecategory_slug'] = "freelancer/comparecategory_slug";
$route['freelancer/create_slug'] = "freelancer/create_slug";
$route['freelancer/slug_script'] = "freelancer/slug_script";
$route['freelancer/check_email'] = "freelancer/check_email";
$route['freelancer/freelancer_apply_deactivate_check'] = "freelancer/freelancer_apply_deactivate_check";
$route['freelancer/freelancer_post_address_information'] = "freelancer/freelancer_post_address_information";
$route['freelancer/ajax_data'] = "freelancer/ajax_data";
$route['freelancer/freelancer_post_address_information_insert'] = "freelancer/freelancer_post_address_information_insert";
$route['freelancer/freelancer_post_professional_information'] = "freelancer/freelancer_post_professional_information";
$route['freelancer/freelancer_post_professional_information_insert'] = "freelancer/freelancer_post_professional_information_insert";
$route['freelancer/freelancer_post_rate'] = "freelancer/freelancer_post_rate";
$route['freelancer/freelancer_post_rate_insert'] = "freelancer/freelancer_post_rate_insert";
$route['freelancer/freelancer_post_avability'] = "freelancer/freelancer_post_avability";
$route['freelancer/freelancer_post_avability_insert'] = "freelancer/freelancer_post_avability_insert";
$route['freelancer/freelancer_post_education'] = "freelancer/freelancer_post_education";
$route['freelancer/freelancer_other_university'] = "freelancer/freelancer_other_university";
$route['freelancer/freelancer_post_education_insert'] = "freelancer/freelancer_post_education_insert";
$route['freelancer/freelancer_post_portfolio'] = "freelancer/freelancer_post_portfolio";
$route['freelancer/freelancer_post_portfolio_insert'] = "freelancer/freelancer_post_portfolio_insert";
$route['freelancer/text2link'] = "freelancer/text2link";
$route['freelancer/aasort'] = "freelancer/aasort";
$route['freelancer/ajax_dataforcity'] = "freelancer/ajax_dataforcity";
$route['freelancer/freelancer_apply_post'] = "freelancer/freelancer_apply_post";
$route['freelancer/ajax_freelancer_apply_post'] = "freelancer/ajax_freelancer_apply_post";
$route['freelancer/freelancer_apply_check'] = "freelancer/freelancer_apply_check";
$route['freelancer/apply_insert'] = "freelancer/apply_insert";
$route['freelancer/freelancer_applied_post'] = "freelancer/freelancer_applied_post";
$route['freelancer/ajax_freelancer_applied_post'] = "freelancer/ajax_freelancer_applied_post";
$route['freelancer/freelancer_delete_apply'] = "freelancer/freelancer_delete_apply";
$route['freelancer/save_insert'] = "freelancer/save_insert";
$route['freelancer/save_user'] = "freelancer/save_user";
$route['freelancer/freelancer_save_post'] = "freelancer/freelancer_save_post";
$route['freelancer/ajax_freelancer_save_post'] = "freelancer/ajax_freelancer_save_post";
$route['freelancer/user_image_add1'] = "freelancer/user_image_add1";
$route['freelancer/pdf'] = "freelancer/pdf";
$route['freelancer/freelancer_post_profile'] = "freelancer/freelancer_post_profile";
$route['freelancer/deactivate'] = "freelancer/deactivate";
$route['freelancer/ajaxpro_work'] = "freelancer/ajaxpro_work";
$route['freelancer/image_work'] = "freelancer/image_work";
$route['freelancer/designation'] = "freelancer/designation";
$route['freelancer/reactivate'] = "freelancer/reactivate";
$route['freelancer/free_invite_user'] = "freelancer/free_invite_user";
$route['freelancer/deletepdf'] = "freelancer/deletepdf";
$route['freelancer/freelancer_search_city'] = "freelancer/freelancer_search_city";
$route['freelancer/freelancer_apply_search_keyword'] = "freelancer/freelancer_apply_search_keyword";
$route['freelancer/get_skill'] = "freelancer/get_skill";
$route['freelancer/freelancer_other_degree'] = "freelancer/freelancer_other_degree";
$route['freelancer/freelancer_other_stream'] = "freelancer/freelancer_other_stream";
$route['freelancer/freelancer_other_field'] = "freelancer/freelancer_other_field";
$route['freelancer/apply_email'] = "freelancer/apply_email";
$route['freelancer/selectemail_user'] = "freelancer/selectemail_user";
$route['freelancer/registation'] = "freelancer/registation";
$route['freelancer/registation_insert'] = "freelancer/registation_insert";
$route['freelancer/email_view'] = "freelancer/email_view";
$route['freelancer/session'] = "freelancer/session";
$route['freelancer/progressbar'] = "freelancer/progressbar";
$route['freelancer/post_slug'] = "freelancer/post_slug";
$route['freelancer/category_slug'] = "freelancer/category_slug";
$route['freelancer/skill_slug'] = "freelancer/skill_slug";
$route['freelancer/freelancer_notification_count'] = "freelancer/freelancer_notification_count";
$route['freelancer/registation_insert_new'] = "freelancer/registation_insert_new";
$route['freelancer/get_filter_data'] = "freelancer/get_filter_data";

$route['freelancer/remove_post'] = "freelancer/remove_post";
$route['freelancer/save_individual'] = "freelancer/save_individual";
$route['freelancer/save_company'] = "freelancer/save_company";

$route['freelancer/get_user_education'] = "freelancer/get_user_education";
$route['freelancer/save_user_education'] = "freelancer/save_user_education";
$route['freelancer/delete_user_education'] = "freelancer/delete_user_education";

$route['freelancer/get_user_experience'] = "freelancer/get_user_experience";
$route['freelancer/save_user_experience'] = "freelancer/save_user_experience";
$route['freelancer/delete_user_experience'] = "freelancer/delete_user_experience";

$route['freelancer/get_user_addicourse'] = "freelancer/get_user_addicourse";
$route['freelancer/save_user_addicourse'] = "freelancer/save_user_addicourse";
$route['freelancer/delete_user_addicourse'] = "freelancer/delete_user_addicourse";

$route['freelancer/get_user_publication'] = "freelancer/get_user_publication";
$route['freelancer/save_user_publication'] = "freelancer/save_user_publication";
$route['freelancer/delete_user_publication'] = "freelancer/delete_user_publication";

$route['freelancer/get_user_languages'] = "freelancer/get_user_languages";
$route['freelancer/save_user_language'] = "freelancer/save_user_language";

$route['freelancer/get_user_links'] = "freelancer/get_user_links";
$route['freelancer/save_user_links'] = "freelancer/save_user_links";

$route['freelancer/get_freelancer_skills'] = "freelancer/get_freelancer_skills";
$route['freelancer/get_user_skills'] = "freelancer/get_user_skills";
$route['freelancer/save_user_skills'] = "freelancer/save_user_skills";

$route['freelancer/save_user_project'] = "freelancer/save_user_project";
$route['freelancer/get_user_project'] = "freelancer/get_user_project";
$route['freelancer/delete_user_project'] = "freelancer/delete_user_project";

$route['freelancer/save_prof_summary'] = "freelancer/save_prof_summary";
$route['freelancer/get_user_prof_summary'] = "freelancer/get_user_prof_summary";

$route['freelancer/save_company_overview'] = "freelancer/save_company_overview";
$route['freelancer/get_user_company_overview'] = "freelancer/get_user_company_overview";

$route['freelancer/save_user_tagline'] = "freelancer/save_user_tagline";
$route['freelancer/get_user_tagline'] = "freelancer/get_user_tagline";

$route['freelancer/save_user_availability'] = "freelancer/save_user_availability";
$route['freelancer/get_user_availability'] = "freelancer/get_user_availability";

$route['freelancer/save_user_rate'] = "freelancer/save_user_rate";
$route['freelancer/get_user_rate'] = "freelancer/get_user_rate";

$route['freelancer/save_review'] = "freelancer/save_review";
$route['freelancer/get_review'] = "freelancer/get_review";

$route['freelancer/get_company_info'] = "freelancer/get_company_info";
$route['freelancer/save_company_info'] = "freelancer/save_company_info";

$route['freelancer/get_basic_info'] = "freelancer/get_basic_info";
$route['freelancer/save_user_basic'] = "freelancer/save_user_basic";

$route['freelancer/get_freelancer_apply_progress'] = "freelancer/get_freelancer_apply_progress";

$route['freelancer/send_promotional_main_in_back'] = "freelancer/send_promotional_main_in_back";
$route['freelancer/generate_freelancer_profile'] = "freelancer/generate_freelancer_profile";

$route['freelancer/(:any)'] = "freelancer/freelancer_post_profile/$1";
$route['freelancer-new/(:any)'] = "freelancer/freelancer_post_profile_new/$1";
$route['freelancer-new-individual/(:any)'] = "freelancer/freelancer_post_profile_new_individual/$1";
//Freelance Apply Signup End

//$route['job/search'] = "job/job_search";
 // $route['jobs'] = "job/job_search";
 // $route['jobs/(:any)'] = "job/job_search/$1";
//$route['(:any)'] = "job/job_search";
//$route['(:any)-jobs'] = "job/job_search";//old
$route['freelance-employer/(:any)'] = "freelancer_hire_live/freelancer_hire_profile/$1";
$route['freelance-employer-new/(:any)'] = "freelancer_hire_live/freelancer_hire_profile_new/$1";

$route['(:any)-job-vacancy-in-(:any)'] = "recruiter/live_post";
$route['(:any)-job-vacancy-in-(:any)/(:any)'] = "recruiter/live_post/$1";

$route['(:any)-jobs'] = "job/job_search_new/$1//1";//Pratik Job By Job Title,Job by Category,Job by Skills
$route['(:any)-jobs/(:any)'] = "job/job_search_new/$1//1";//Pratik Job By Job Title,Job by Category,Job by Skills
$route['jobs-opening-at-(:any)'] = "job/job_search_new/$1//2";
$route['jobs-opening-at-(:any)/(:any)'] = "job/job_search_new/$1//2";

$route['jobs-in-(:any)'] = "job/job_search_new/$1//3";
$route['jobs-in-(:any)/(:any)'] = "job/job_search_new/$1//3";

$route['(:any)-jobs-in-(:any)'] = "job/job_search_new/$1/$2/4";
$route['(:any)-jobs-in-(:any)/(:any)'] = "job/job_search_new/$1/$2/4";

/*$route['jobs-by-location'] = "job_live/view_more_jobs";
$route['jobs-by-skills'] = "job_live/view_more_jobs";
$route['jobs-by-designations'] = "job_live/view_more_jobs";
$route['jobs-by-companies'] = "job_live/view_more_jobs";
$route['jobs-by-categories'] = "job_live/view_more_jobs";
$route['jobs'] = "job_live/view_more_jobs";*/

$route['jobs-by-categories'] = "job_live/jobs_by_categories";
$route['jobs-by-categories/(:any)'] = "job_live/jobs_by_categories";

$route['jobs-by-skills'] = "job_live/jobs_by_skills";
$route['jobs-by-skills/(:any)'] = "job_live/jobs_by_skills";

$route['jobs-by-location'] = "job_live/jobs_by_location";
$route['jobs-by-location/(:any)'] = "job_live/jobs_by_location";

$route['jobs-by-companies'] = "job_live/jobs_by_companies";
$route['jobs-by-companies/(:any)'] = "job_live/jobs_by_companies";

$route['jobs-by-designations'] = "job_live/jobs_by_designations";
$route['jobs-by-designations/(:any)'] = "job_live/jobs_by_designations";

$route['jobs'] = "job_live/jobs_by_jobs";

/*$route['jobs-in-(:any)'] = "job/job_search";
$route['(:any)-jobs-in-(:any)'] = "job/job_search";*/

$route['job/post-(:any)/(:any)'] = "job/post/$1/$2";
$route['job/recruiter-profile/(:any)'] = "job/rec_profile/$1";


//RECRUITER ROUTES SETTINGS

$route['recruiter'] = "recruiter_live/index";
$route['recruiter/category/(:any)'] = "recruiter_live/category/$1";
$route['recruiter/city/(:any)'] = "recruiter_live/city/$1";
$route['recruiter/skill/(:any)'] = "recruiter_live/skill/$1";
$route['recruiter/company/(:any)'] = "recruiter_live/company/$1";
$route['recruiter/search'] = "recruiter_live/job_search";
$route['recruiter/reactivateacc'] = "recruiter_live/reactivateacc";

/*$route['recruiter/registration'] = "recruiter/rec_reg";
$route['recruiter/registration/live-post'] = "recruiter/rec_reg";*/

$route['recruiter/signup'] = "recruiter/rec_reg";
$route['recruiter/signup/live-post'] = "recruiter/rec_reg";

$route['recruiter/basic-information'] = "recruiter/rec_basic_information";
$route['recruiter/company-information'] = "recruiter/company_info_form";

// $route['recruiter/home'] = "recruiter_live/recommen_candidate";
$route['recommended-candidates'] = "recruiter_live/recommen_candidate";
$route['recruiter/reactivateacc'] = "recruiter_live/reactivateacc";
//$route['recruiter/add-post-live'] = "recruiter/add_post_login";


$route['recruiter/profile'] = "recruiter_live/rec_profile";
$route['recruiter/profilenew'] = "recruiter_live/rec_profilenew";
$route['recruiter/profile/(:any)'] = "recruiter_live/rec_profile/$1";

$route['recruiter/saved-candidate'] = "recruiter_live/save_candidate";
$route['recruiter/saved-candidate/(:any)'] = "recruiter_live/save_candidate/$1";

$route['recruiter/post'] = "recruiter/rec_post";
$route['recruiter/post/(:any)'] = "recruiter_live/rec_post/$1";

// $route['recruiter/jobpost'] = "recruiter/live_post";
// $route['recruiter/jobpost/(:any)'] = "recruiter/live_post/$1";

// $route['recruiter/add-post'] = "recruiter/add_post";
$route['post-job'] = "recruiter/add_post";

$route['recruiter/post-insert'] = "recruiter/add_post";

$route['recruiter/edit-post'] = "recruiter/edit_post";
$route['recruiter/edit-post/(:any)'] = "recruiter/edit_post/$1";
$route['recruiter/applied-candidates/(:any)'] = "recruiter/view_apply_list/$1";

// $route['recruiter/search'] = "recruiter_live/recruiter_search";
$route['recruiter/search/(:any)'] = "recruiter_live/recruiter_search/$1";
$route['recruiter/search/candidates-in-(:any)'] = "recruiter_live/recruiter_search/''/$1";
$route['recruiter/search/(:any)-candidates-in-(:any)'] = "recruiter_live/recruiter_search/$1/$2";
$route['recruiter/deactivate'] = "recruiter_live/deactivate";


// NOTIFICATION ROUTES SETTINGS
$route['notification/details/(:any)'] = "business_profile/business_resume/$1";
$route['notification/business-post/(:any)'] = "business_profile/edit_post/$1";

$route['notification/art-post/(:any)'] = "notification/art_post/$1";
$route['feedback'] = "feedback/index";
$route['faq'] = "general/faq";
$route['report'] = "general/report";
$route['report-abuse'] = "general/report";

$route['how-to-use-job-profile-in-aileensoul'] = "introduction/job_profile";
$route['how-to-use-recruiter-profile-in-aileensoul'] = "introduction/recruiter_profile";
$route['how-to-use-freelance-profile-in-aileensoul'] = "introduction/freelance_profile";
$route['how-to-use-business-profile-in-aileensoul'] = "introduction/business_profile";
$route['how-to-use-artistic-profile-in-aileensoul'] = "introduction/artistic_profile";

$route['business-in-(:any)'] = "business_live/locationBusinessList/$1";
$route['business-in-(:any)/(:num)'] = "business_live/locationBusinessList/$1";
$route['(:any)-business-in-(:any)'] = "business_live/categoryBusinessList/$1/$2/1";
$route['(:any)-business-in-(:any)/(:num)'] = "business_live/categoryBusinessList/$1/$2/1";
$route['(:any)-business'] = "business_live/categoryBusinessList/$1//2";
$route['(:any)-business/(:num)'] = "business_live/categoryBusinessList/$1//2";

$route['company/userlist'] = "business_profile_live/userlist";

$route['company/(:any)'] = "business_profile_live/business_profile_manage_post/$1";

/*$route['business-by-categories'] = "business_live/view_more_business";
$route['business-by-location'] = "business_live/view_more_business";
$route['business'] = "business_live/view_more_business";*/

$route['business-by-categories'] = "business_live/category";
$route['business-by-categories/(:num)'] = "business_live/category";
$route['business-by-location'] = "business_live/location";
$route['business-by-location/(:num)'] = "business_live/location";
$route['business'] = "business_live/business_by_business";

$route['artist/pdf-view/(:any)'] = "artist/pdf_display/$1";
$route['business-profile/pdf-view/(:any)'] = "business_profile/pdf_display/$1";

$route['(:any)/post/(:any)'] = 'user_post/post_detail/$2';
$route['(:any)/photos/(:any)'] = 'user_post/post_detail/$2';
$route['(:any)/videos/(:any)'] = 'user_post/post_detail/$2';
$route['(:any)/pdf/(:any)'] = 'user_post/post_detail/$2';
$route['(:any)/audios/(:any)'] = 'user_post/post_detail/$2';

$route['(:any)/contacts'] = 'Userprofile';
$route['(:any)/following'] = 'Userprofile';
$route['(:any)/followers'] = 'Userprofile';
$route['(:any)/details'] = 'Userprofile';
$route['(:any)/questions'] = 'Userprofile';
$route['(:any)/profiles'] = 'Userprofile';
$route['(:any)/photos'] = 'Userprofile';
$route['(:any)/videos'] = 'Userprofile';
$route['(:any)/audios'] = 'Userprofile';
$route['(:any)/pdf'] = 'Userprofile';
$route['(:any)/article'] = 'Userprofile';
$route['(:any)/savedpost'] = 'Userprofile';
$route['(:any)/monetization-analytics'] = 'Userprofile';

//Article
$route['article/likePost'] = 'article/likePost';
$route['article/load_more_comment'] = 'article/load_more_comment';
$route['article/postCommentInsert'] = 'article/postCommentInsert';
$route['article/add_article'] = 'article/add_article';
$route['article/publish_article'] = 'article/publish_article';
$route['article/upload_featured_img'] = 'article/upload_featured_img';
$route['article/upload_image'] = 'article/upload_image';
$route['article/change_category'] = 'article/change_category';
$route['article/remove_featured_img'] = 'article/remove_featured_img';
$route['article/save_article_hashtag'] = 'article/save_article_hashtag';

// $route['artist-in-(:any)'] = "artist_live/artist_search/artist-in-$1";
$route['artist/p/(:any)'] = "artist_live/art_manage_post/$1";
$route['artist/search/artist-in-(:any)'] = "artist_live/artist_search/artist-in-$1";
$route['business/search/business-in-(:any)'] = "business_live/business_search/business-in-$1";
// $route['artist-in-(:any)'] = "artist_live/artist_search/artist-in-$1";
$route['artist-in-(:any)'] = "artist_live/categoryArtistList//$1/1";
$route['artist-in-(:any)/(:num)'] = "artist_live/categoryArtistList//$1/1";
$route['notification'] = 'notification';
$route['message'] = "message/main_message";
$route['generate_sitemap'] = "sitemap/generate_sitemap";
$route['new-article'] = 'article/new_article';
$route['edit-article/(:any)'] = 'article/edit_article/$1';
$route['article-preview/(:any)'] = 'article/article_preview/$1';

$route['new-business-article'] = 'article/new_business_article';

$route['article/(:any)'] = 'article/article_published/$1';
$route['o/(:any)'] = 'user_post/opprtunity_detail/$1';
$route['p/(:any)'] = 'user_post/simple_post_detail/$1';
$route['shp/(:any)'] = 'user_post/shared_post_detail/$1';
$route['noscript'] = 'Userprofile/noscript';

//Old Url
$route['business-profile/details'] = "My404Page";
$route['business-profile/details/(:any)'] = "My404Page";
$route['recruiter/jobpost'] = "My404Page";
$route['recruiter/jobpost/(:any)'] = "My404Page";

//Monetize
$route['monetize-aileensoul-account'] = "Userprofile/monetize";

$route['(:any)'] = 'Userprofile';


// ARTIST SEARCH 
$route['artist/search/(:any)'] = "artist_live/artist_search/$1";
$route['artist/search/(:any)-in-(:any)'] = "artist_live/artist_search/$1-in-$2";

$route['artist/like_commentimg1'] = "artist/like_commentimg1";
$route['artist/(:any)-in-(:any)'] = "artist_live/categoryArtistList/$1/$2/1";
$route['artist/(:any)-in-(:any)/(:num)'] = "artist_live/categoryArtistList/$1/$2/1";
$route['artist/(:any)'] = "artist_live/categoryArtistList/$1//2";
$route['artist/(:any)/(:num)'] = "artist_live/categoryArtistList/$1//2";

$route['business/search/(:any)'] = "business_live/business_search/$1";
$route['business/search/(:any)-in-(:any)'] = "business_live/business_search/$1-in-$2";

$route['company/(:any)/details'] = "business_profile_live/business_resume/$1";
$route['company-new/(:any)/details'] = "business_profile_live/business_resume_new/$1";
$route['company/(:any)/contacts'] = "business_profile_live/bus_contact/$1";
$route['company/(:any)/followers'] = "business_profile_live/followers/$1";
$route['company/(:any)/following'] = "business_profile_live/following/$1";

$route['company/(:any)/photos'] = "business_profile_live/business_photos/$1";
$route['company/(:any)/videos'] = "business_profile_live/business_videos/$1";
$route['company/(:any)/audios'] = "business_profile_live/business_audios/$1";
$route['company/(:any)/pdf'] = "business_profile_live/business_pdf/$1";
$route['company/(:any)/article'] = "business_profile_live/business_article/$1";
// $route['company/(:any)/userlist'] = "business_profile_live/userlist/$1";
$route['company/(:any)/post/(:any)'] = "business_profile_live/postnewpage/$1/$2";

$route['unsubscribe/(:any)/(:any)/(:any)'] = "Registration/unsubscribe/$1/$2/$3";