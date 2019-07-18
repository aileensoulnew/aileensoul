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
$route['search/opportunity'] = 'user_post/search';
$route['search/people'] = 'user_post/search';
$route['search/post'] = 'user_post/search';
$route['search/business'] = 'user_post/search';
$route['search/article'] = 'user_post/search';
$route['search/question'] = 'user_post/search';

$route['userprofile_page'] = 'userprofile_page';
$route['userprofile_page/(:any)'] = 'userprofile_page/$1';

$route['opportunities'] = 'user_post';
$route['contact-request'] = 'userprofile_page/contact_request';
$route['hashtags'] = 'userprofile_page/contact_request';
$route['contact-business'] = 'userprofile_page/contact_request';

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

$route['sitemap/people'] = "sitemap/sitemap_member";
$route['sitemap/people/(:any)'] = "sitemap/sitemap_member/$1";
$route['sitemap/people/(:any)/(:num)'] = "sitemap/sitemap_member/$1";

$route['sitemap/companies'] = "sitemap/sitemap_companies";
$route['sitemap/companies/(:any)'] = "sitemap/sitemap_companies/$1";
$route['sitemap/companies/(:any)/(:num)'] = "sitemap/sitemap_companies/$1";


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


$route['edit-profile'] = "profile";
$route['change-password'] = "registration/changepassword";
$route['subscribe'] = "registration/subscribe";
$route['profiles'] = "dashboard";
$route['profiles/basic-information/(:any)'] = "user_basic_info";
$route['profiles/opportunities/(:any)'] = "user_opportunities";

$route['business-search'] = "business_live/index";

$route['business/search'] = "business_live/business_search";
$route['business/search/business-in-(:any)'] = "business_live/business_search/business-in-$1";
$route['business/search/(:any)'] = "business_live/business_search/$1";
$route['business/search/(:any)-in-(:any)'] = "business_live/business_search/$1-in-$2";


$route['business/reactivateacc'] = "business_profile/reactivateacc";
$route['business-profile'] = "business_profile_live/business_profile_post";
$route['business-profile/image-insert'] = "business_profile/image_insert";

$route['business-profile/bussiness-profile-post-add'] = "business_profile/business_profile_addpost_insert";
$route['business-profile/bussiness-profile-post-add/manage/(:any)'] = "business_profile/business_profile_addpost_insert/manage/$1";

$route['business-profile/dashboard'] = "business_profile_live/business_profile_manage_post";

$route['business-profile/followers'] = "business_profile_live/followers";
$route['business-profile/following'] = "business_profile_live/following";
$route['business-profile/userlist'] = "business_profile_live/userlist";

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

$route['business-profile/business-profile-editpost'] = "business_profile/business_profile_editpost";

$route['business-profile/registration/business-information'] = "business_profile_registration_live/business_registration/$1";
$route['business-profile/registration/contact-information'] = "business_profile_registration_live/business_registration/$1";
$route['business-profile/registration/description'] = "business_profile_registration_live/business_registration/$1";
$route['business-profile/registration/image'] = "business_profile_registration_live/business_registration/$1";

$route['business-profile/signup/edit/business-information'] = "business_profile_registration/business_information_edit";
$route['business-profile/signup/edit/contact-information'] = "business_profile_registration/contact_informatio_edit";
$route['business-profile/signup/edit/description'] = "business_profile_registration/description_edit";
$route['business-profile/signup/edit/image'] = "business_profile_registration/image_edit";

$route['message/b/(:any)'] = "message/business_profile/$1";
$route['message/rj/(:any)'] = "recmessage/recjob/$1";

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

$route['blog/(:any)'] = "blog/index/$1";

$route['guest-contributor'] = "blog/guest_contributor";

$route['business-profile/create-account'] = "business_profile_live/business_register_new";
$route['business-profile/basic-info'] = "business_profile_live/business_register_new";
$route['business-profile/educational-info'] = "business_profile_live/business_register_new";
$route['business-profile/registration'] = "business_profile_live/business_register_new";

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

$route['business-by-categories'] = "business_live/category";
$route['business-by-categories/(:num)'] = "business_live/category";
$route['business-by-location'] = "business_live/location";
$route['business-by-location/(:num)'] = "business_live/location";
$route['business'] = "business_live/business_by_business";

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

$route['peoples'] = 'main';
$route['posts'] = 'main';
$route['opportunities'] = 'main';
$route['articles'] = 'main';
$route['qa'] = 'main';
$route['businesses'] = 'main';

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
$route['searchelastic'] = "Searchelastic";
$route['searchelastic/search'] = "Searchelastic/search";
$route['searchelastic/search_opportunity_data'] = "Searchelastic/search_opportunity_data";


$route['user-info-box'] = "user_post/user_info_box/$1";

$route['(:any)'] = 'Userprofile';

$route['company/userlist'] = "business_profile_live/userlist";
$route['company/(:any)'] = "business_profile_live/business_profile_manage_post/$1";

$route['company/(:any)/details'] = "business_profile_live/business_resume/$1";
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