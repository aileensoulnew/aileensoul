<?php
 
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
  |--------------------------------------------------------------------------
  | File and Directory Modes
  |--------------------------------------------------------------------------
  |
  | These prefs are used when checking and setting modes when working
  | with the file system.  The defaults are fine on servers with proper
  | security, but you may wish (or even need) to change the values in
  | certain environments (Apache running a separate process for each
  | user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
  | always be used to set the mode correctly.
  |
 */
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
  |--------------------------------------------------------------------------
  | File Stream Modes
  |--------------------------------------------------------------------------
  |
  | These modes are used when working with fopen()/popen()
  |
 */

define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['SERVER_ADDR'] == '127.0.0.1') {
    define('BASEURL', 'http://localhost/aileensoulnew/aileensoul/');
    define('IMAGEPATHFROM', 'upload'); //upload,s3bucket 
    error_reporting(0);
}else if ($_SERVER['HTTP_HOST'] == '35.165.1.109:81' || $_SERVER['SERVER_ADDR'] == '35.165.1.109') {
    define('BASEURL', 'http://35.165.1.109:81/');
    define('IMAGEPATHFROM', 'upload'); //upload,s3bucket 
    error_reporting(0);
} else {
    define('BASEURL', 'https://www.aileensoul.com/');
    define('IMAGEPATHFROM', 's3bucket'); //upload,s3bucket 
    error_reporting(0);
}


define('SITEPATH', $_SERVER['DOCUMENT_ROOT'] . '/aileensoulnew/aileensoul/');
define('TITLEPOSTFIX', ' - Aileensoul');

define('NOIMAGE', 'uploads/avatar.png');
define('NOBUSIMAGE', 'uploads/nobusimage.jpg');
define('NOBUSIMAGE2', 'uploads/nobusimage2.jpg');
define('WHITEIMAGE', 'uploads/white.png');
define('PROFILENA', '--');
define('JOBDATANA', 'No Data Available.');
define('FNOIMAGE', 'uploads/Email_Verification_female.png');
define('MNOIMAGE', 'uploads/Email_Verification_male.png');
define('NOARTIMAGE', 'uploads/noartimage.jpg');



define('JSPATHFROM', 'server'); //server,s3bucket 
// MINIFY CODE START
define('IS_CSS_MINIFY', '0'); //1 : yes,0 no (FOR COMMON PAGE ONLY AND BUSINESS)

define('IS_REC_CSS_MINIFY', '0'); //1 : yes,0 no
define('IS_JOB_CSS_MINIFY', '1'); //1 : yes,0 no
define('IS_ART_CSS_MINIFY', '1'); //1 : yes,0 no
define('IS_HIRE_CSS_MINIFY', '1'); //1 : yes,0 no
define('IS_APPLY_CSS_MINIFY', '1'); //1 : yes,0 no
define('IS_BUSINESS_CSS_MINIFY', '0'); //1 : yes,0 no 
define('IS_OUTSIDE_CSS_MINIFY', '0'); //1 : yes,0 no
define('IS_MSG_CSS_MINIFY', '0'); //1 : yes,0 no 
define('IS_NOT_CSS_MINIFY', '0'); //1 : yes,0 no 



define('IS_JS_MINIFY', '1'); //1 : yes,0 no (FOR COMMON PAGE ONLY AND BUSINESS)

define('IS_REC_JS_MINIFY', '0'); //1 : yes,0 no
define('IS_JOB_JS_MINIFY', '1'); //1 : yes,0 no
define('IS_ART_JS_MINIFY', '1'); //1 : yes,0 no
define('IS_HIRE_JS_MINIFY', '1'); //1 : yes,0 no
define('IS_APPLY_JS_MINIFY', '1'); //1 : yes,0 no
define('IS_BUSINESS_JS_MINIFY', '0'); //1 : yes,0 no
define('IS_OUTSIDE_JS_MINIFY', '0'); //1 : yes,0 no
define('IS_MSG_JS_MINIFY', '0'); //1 : yes,0 no
define('IS_NOT_JS_MINIFY', '0'); //1 : yes,0 no



// S3BUCKET START
// Bucket Name
define('bucket', 'aileensoulimages');

//AWS access info 
//define('awsAccessKey', 'AKIAI2ZIGZWVAZWQJOPA'); 
//define('awsSecretKey', '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');
define('awsAccessKey', 'AKIAI2ZIGZWVAZWQJOPA');
define('awsSecretKey', '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');

define('BUCKETLINK', 'https://' . bucket . '.s3.amazonaws.com/');

// S3BUCKET END

if(JSPATHFROM == 's3bucket'){
    define('JSPATH', BUCKETLINK . 'js/');
}else{
    define('JSPATH', BASEURL . 'js/');
}



if (IMAGEPATHFROM == 's3bucket') {
    //USER PHOTO 
    define('USER_WEB_IMAGE', BUCKETLINK . 'admin/../uploads/users/main/');
    define('USER_IMAGE', BUCKETLINK . '../uploads/users/main/');
    define('USERS_IMAGE', BUCKETLINK . 'uploads/users/main/');

    //CATEGORY PHOTO 
    define('CATEGORY_IMAGE', BUCKETLINK . 'uploads/category/main/');
    define('CATEGORY_IMAGE_THUMB', BUCKETLINK . 'uploads/category/thumb/');
    define('CATEGORY_WEB_IMAGE', BUCKETLINK . 'admin/../uploads/category/main/');
    define('CATEGORY_WEB_IMAGE_THUMB', BUCKETLINK . 'admin/../uploads/category/thumb/');

// USER BACKGROUND IMAGE
    define('USER_BG_MAIN_UPLOAD_URL', BUCKETLINK . 'uploads/user_bg/main/');

// USER BACKGROUND THUMB IMAGE 
    define('USER_BG_THUMB_UPLOAD_URL', BUCKETLINK . 'uploads/user_bg/thumbs/');

// USER BACKGROUND ORIGINAL IMAGE 
    define('USER_BG_ORIGINAL_UPLOAD_URL', BUCKETLINK . 'uploads/user_bg/original/');

// USER PROFILE IMAGE
    define('USER_MAIN_UPLOAD_URL', BUCKETLINK . 'uploads/user_profile/main/');

// USER PROFILE THUMB IMAGE
    define('USER_THUMB_UPLOAD_URL', BUCKETLINK . 'uploads/user_profile/thumbs/');

// JOB PROFILE IMAGE 
    define('JOB_PROFILE_MAIN_UPLOAD_URL', BUCKETLINK . 'uploads/job_profile/main/');

// JOB PROFILE THUMB IMAGE
    define('JOB_PROFILE_THUMB_UPLOAD_URL', BUCKETLINK . 'uploads/job_profile/thumbs/');

// JOB BACKGROUND IMAGE 
    define('JOB_BG_MAIN_UPLOAD_URL', BUCKETLINK . 'uploads/job_bg/main/');

// JOB BACKGROUND THUMB IMAGE
    define('JOB_BG_THUMB_UPLOAD_URL', BUCKETLINK . 'uploads/job_bg/thumbs/');

// JOB BACKGROUND ORIGINAL IMAGE
    define('JOB_BG_ORIGINAL_UPLOAD_URL', BUCKETLINK . 'uploads/job_bg/original/');

// JOB EDUCATION CERTIFICATE
    define('JOB_EDU_MAIN_UPLOAD_URL', BUCKETLINK . 'uploads/job_education/main/');

// JOB EDUCATION THUMB CERTIFICATE
    define('JOB_EDU_THUMB_UPLOAD_URL', BUCKETLINK . 'uploads/job_education/thumbs/');

// JOB WORK EXPERIENCE CERTIFICATE
    define('JOB_WORK_MAIN_UPLOAD_URL', BUCKETLINK . 'uploads/job_work/main/');

//  JOB WORK EXPERIENCE THUMB CERTIFICATE
    define('JOB_WORK_THUMB_UPLOAD_URL', BUCKETLINK . 'uploads/job_work/thumbs/');

// RECRUITER PROFILE IMAGE 
    define('REC_PROFILE_MAIN_UPLOAD_URL', BUCKETLINK . 'uploads/recruiter_profile/main/');

// RECRUITER PROFILE THUMB IMAGE
    define('REC_PROFILE_THUMB_UPLOAD_URL', BUCKETLINK . 'uploads/recruiter_profile/thumbs/');

// RECRUITER BACKGROUND IMAGE 
    define('REC_BG_MAIN_UPLOAD_URL', BUCKETLINK . 'uploads/recruiter_bg/main/');

// RECRUITER BACKGROUND THUMB IMAGE
    define('REC_BG_THUMB_UPLOAD_URL', BUCKETLINK . 'uploads/recruiter_bg/thumbs/');

// RECRUITER BACKGROUND ORIGINAL IMAGE
    define('REC_BG_ORIGINAL_UPLOAD_URL', BUCKETLINK . 'uploads/recruiter_bg/original/');

// FREELANCER PORTFOLIO ATTACHMENT 
    define('FREE_PORTFOLIO_MAIN_UPLOAD_URL', BUCKETLINK . 'uploads/freelancer_post_portfolio/main/');

// FREELANCER PORTFOLIO ATTACHMENT THUMBS
    define('FREE_PORTFOLIO_THUMB_UPLOAD_URL', BUCKETLINK . 'uploads/freelancer_post_portfolio/thumbs/');

// FREELANCER HIRE PROFILE 
    define('FREE_HIRE_PROFILE_MAIN_UPLOAD_URL', BUCKETLINK . 'uploads/freelancer_hire_profile/main/');

// FREELANCER HIRE PROFILE THUMBS
    define('FREE_HIRE_PROFILE_THUMB_UPLOAD_URL', BUCKETLINK . 'uploads/freelancer_hire_profile/thumbs/');

// FREELANCER HIRE BACKGROUND
    define('FREE_HIRE_BG_MAIN_UPLOAD_URL', BUCKETLINK . 'uploads/freelancer_hire_bg/main/');

// FREELANCER HIRE BACKGROUND THUMB
    define('FREE_HIRE_BG_THUMB_UPLOAD_URL', BUCKETLINK . 'uploads/freelancer_hire_bg/thumbs/');

// FREELANCER HIRE BACKGROUND ORIGINAL
    define('FREE_HIRE_BG_ORIGINAL_UPLOAD_URL', BUCKETLINK . 'uploads/freelancer_hire_bg/original/');

// FREELANCER POST PROFILE
    define('FREE_POST_PROFILE_MAIN_UPLOAD_URL', BUCKETLINK . 'uploads/freelancer_post_profile/main/');

// FREELANCER POST PROFILE THUMBS
    define('FREE_POST_PROFILE_THUMB_UPLOAD_URL', BUCKETLINK . 'uploads/freelancer_post_profile/thumbs/');

// FREELANCER POST PROFILE BACKGROUND
    define('FREE_POST_BG_MAIN_UPLOAD_URL', BUCKETLINK . 'uploads/freelancer_post_bg/main/');

// FREELANCER POST PROFILE BACKGROUND THUMBS
    define('FREE_POST_BG_THUMB_UPLOAD_URL', BUCKETLINK . 'uploads/freelancer_post_bg/thumbs/');

// FREELANCER POST PROFILE BACKGROUND ORIGINAL
    define('FREE_POST_BG_ORIGINAL_UPLOAD_URL', BUCKETLINK . 'uploads/freelancer_post_bg/original/');

// BUSINESS PROFILE IMAGE
    define('BUS_PROFILE_MAIN_UPLOAD_URL', BUCKETLINK . 'uploads/business_profile/main/');

// BUSINESS PROFILE IMAGE THUMBS
    define('BUS_PROFILE_THUMB_UPLOAD_URL', BUCKETLINK . 'uploads/business_profile/thumbs/');

// BUSINESS DETAILS IMAGE
    define('BUS_DETAIL_MAIN_UPLOAD_URL', BUCKETLINK . 'uploads/business_profile/main/');

// BUSINESS DETAILS IMAGE THUMBS
    define('BUS_DETAIL_THUMB_UPLOAD_URL', BUCKETLINK . 'uploads/business_profile/thumbs/');

// BUSINESS PROFILE BACKGROUND
    define('BUS_BG_MAIN_UPLOAD_URL', BUCKETLINK . 'uploads/business_bg/main/');

// BUSINESS PROFILE BACKGROUND THUMBS
    define('BUS_BG_THUMB_UPLOAD_URL', BUCKETLINK . 'uploads/business_bg/thumbs/');

// BUSINESS PROFILE BACKGROUND ORIGINAL
    define('BUS_BG_ORIGINAL_UPLOAD_URL', BUCKETLINK . 'uploads/business_bg/original/');

// BUSINESS POST 
    define('BUS_POST_MAIN_UPLOAD_URL', BUCKETLINK . 'uploads/business_post/main/');

// BUSINESS POST RESIZED
    define('BUS_POST_RESIZE_UPLOAD_URL', BUCKETLINK . 'uploads/business_post/resize/');

// BUSINESS POST THUMBS
    define('BUS_POST_THUMB_UPLOAD_URL', BUCKETLINK . 'uploads/business_post/thumbs/');

// BUSINESS POST 335 X 320
    define('BUS_POST_RESIZE1_UPLOAD_URL', BUCKETLINK . 'uploads/business_post/resize1/');

// BUSINESS POST 335 X 245
    define('BUS_POST_RESIZE2_UPLOAD_URL', BUCKETLINK . 'uploads/business_post/resize2/');

// BUSINESS POST 210 X 210
    define('BUS_POST_RESIZE3_UPLOAD_URL', BUCKETLINK . 'uploads/business_post/resize3/');

// BUSINESS POST 550 X 220
    define('BUS_POST_RESIZE4_UPLOAD_URL', BUCKETLINK . 'uploads/business_post/resize4/');
    
// BUSINESS MESSAGE MAIN
    define('BUS_MESSAGE_MAIN_UPLOAD_URL', BUCKETLINK . 'uploads/business_message/main/');

// BUSINESS MESSAGE THUMBS
    define('BUS_MESSAGE_THUMBS_UPLOAD_URL', BUCKETLINK . 'uploads/business_message/thumbs/');
    

// ARTISTIC PROFILE IMAGE
    define('ART_PROFILE_MAIN_UPLOAD_URL', BUCKETLINK . 'uploads/artistic_profile/main/');

// ARTISTIC PROFILE IMAGE THUMBS
    define('ART_PROFILE_THUMB_UPLOAD_URL', BUCKETLINK . 'uploads/artistic_profile/thumbs/');

// ARTISTIC PROFILE BACKGROUND
    define('ART_BG_MAIN_UPLOAD_URL', BUCKETLINK . 'uploads/artistic_bg/main/');

// ARTISTIC PROFILE BACKGROUND THUMBS
    define('ART_BG_THUMB_UPLOAD_URL', BUCKETLINK . 'uploads/artistic_bg/thumbs/');

// ARTISTIC PROFILE BACKGROUND ORIGINAL
    define('ART_BG_original_UPLOAD_URL', BUCKETLINK . 'uploads/artistic_bg/original/');

// ARTISTIC PORTFOLIO
    define('ART_PORTFOLIO_MAIN_UPLOAD_URL', BUCKETLINK . 'uploads/artistic_portfolio/main/');

// ARTISTIC PORTFOLIO THUMBS
    define('ART_PORTFOLIO_THUMB_UPLOAD_URL', BUCKETLINK . 'uploads/artistic_portfolio/thumbs/');

// ARTISTIC POST 
    define('ART_POST_MAIN_UPLOAD_URL', BUCKETLINK . 'uploads/artistic_post/main/');

// ARTISTIC POST THUMBS
    define('ART_POST_THUMB_UPLOAD_URL', BUCKETLINK . 'uploads/artistic_post/thumbs/');

// ARTISTIC POST 335 X 320
    define('ART_POST_RESIZE1_UPLOAD_URL', BUCKETLINK . 'uploads/artistic_post/resize1/');

// ARTISTIC POST 335 X 245
    define('ART_POST_RESIZE2_UPLOAD_URL', BUCKETLINK . 'uploads/artistic_post/resize2/');

// ARTISTIC POST 210 X 210
    define('ART_POST_RESIZE3_UPLOAD_URL', BUCKETLINK . 'uploads/artistic_post/resize3/');
// ARTISTIC POST 550 X 220
    define('ART_POST_RESIZE4_UPLOAD_URL', BUCKETLINK . 'uploads/artistic_post/resize4/');

// BLOG MAIN IMAGE
    define('BLOG_MAIN_UPLOAD_URL', BUCKETLINK . 'uploads/blog/main/');

// BLOG THUMB THUMB
    define('BLOG_THUMB_UPLOAD_URL', BUCKETLINK . 'uploads/blog/thumbs/');
    
    
    
// USER POST 
    define('USER_POST_MAIN_UPLOAD_URL', BUCKETLINK . 'uploads/user_post/main/');

// USER POST RESIZED
    define('USER_POST_RESIZE_UPLOAD_URL', BUCKETLINK . 'uploads/user_post/resize/');

// USER POST THUMBS
    define('USER_POST_THUMB_UPLOAD_URL', BUCKETLINK . 'uploads/user_post/thumbs/');

// USER POST 335 X 320
    define('USER_POST_RESIZE1_UPLOAD_URL', BUCKETLINK . 'uploads/user_post/resize1/');

// USER POST 335 X 245
    define('USER_POST_RESIZE2_UPLOAD_URL', BUCKETLINK . 'uploads/user_post/resize2/');

// USER POST 210 X 210
    define('USER_POST_RESIZE3_UPLOAD_URL', BUCKETLINK . 'uploads/user_post/resize3/');

// USER POST 550 X 220
    define('USER_POST_RESIZE4_UPLOAD_URL', BUCKETLINK . 'uploads/user_post/resize4/');    
    
    
} else {
    //USER PHOTO 
    define('USER_WEB_IMAGE_URL', BASEURL . 'admin/../uploads/users/main/');
    define('USER_IMAGE_URL', BASEURL . '../uploads/users/main/');
    define('USERS_IMAGE_URL', BASEURL . 'uploads/users/main/');

    //CATEGORY PHOTO 
    define('CATEGORY_IMAGE_URL', BASEURL . 'uploads/category/main/');
    define('CATEGORY_IMAGE_THUMB_URL', BASEURL . 'uploads/category/thumb/');
    define('CATEGORY_WEB_IMAGE_URL', BASEURL . 'admin/../uploads/category/main/');
    define('CATEGORY_WEB_IMAGE_THUMB_URL', BASEURL . 'admin/../uploads/category/thumb/');

// USER BACKGROUND IMAGE
    define('USER_BG_MAIN_UPLOAD_URL', BASEURL . 'uploads/user_bg/main/');

// USER BACKGROUND THUMB IMAGE 
    define('USER_BG_THUMB_UPLOAD_URL', BASEURL . 'uploads/user_bg/thumbs/');

// USER BACKGROUND ORIGINAL IMAGE 
    define('USER_BG_ORIGINAL_UPLOAD_URL', BASEURL . 'uploads/user_bg/original/');

// USER PROFILE IMAGE
    define('USER_MAIN_UPLOAD_URL', BASEURL . 'uploads/user_profile/main/');

// USER PROFILE THUMB IMAGE
    define('USER_THUMB_UPLOAD_URL', BASEURL . 'uploads/user_profile/thumbs/');

// JOB PROFILE IMAGE 
    define('JOB_PROFILE_MAIN_UPLOAD_URL', BASEURL . 'uploads/job_profile/main/');

// JOB PROFILE THUMB IMAGE
    define('JOB_PROFILE_THUMB_UPLOAD_URL', BASEURL . 'uploads/job_profile/thumbs/');

// JOB BACKGROUND IMAGE 
    define('JOB_BG_MAIN_UPLOAD_URL', BASEURL . 'uploads/job_bg/main/');

// JOB BACKGROUND THUMB IMAGE
    define('JOB_BG_THUMB_UPLOAD_URL', BASEURL . 'uploads/job_bg/thumbs/');

// JOB BACKGROUND ORIGINAL IMAGE
    define('JOB_BG_ORIGINAL_UPLOAD_URL', BASEURL . 'uploads/job_bg/original/');

// JOB EDUCATION CERTIFICATE
    define('JOB_EDU_MAIN_UPLOAD_URL', BASEURL . 'uploads/job_education/main/');

// JOB EDUCATION THUMB CERTIFICATE
    define('JOB_EDU_THUMB_UPLOAD_URL', BASEURL . 'uploads/job_education/thumbs/');

// JOB WORK EXPERIENCE CERTIFICATE
    define('JOB_WORK_MAIN_UPLOAD_URL', BASEURL . 'uploads/job_work/main/');

//  JOB WORK EXPERIENCE THUMB CERTIFICATE
    define('JOB_WORK_THUMB_UPLOAD_URL', BASEURL . 'uploads/job_work/thumbs/');

// RECRUITER PROFILE IMAGE 
    define('REC_PROFILE_MAIN_UPLOAD_URL', BASEURL . 'uploads/recruiter_profile/main/');

// RECRUITER PROFILE THUMB IMAGE
    define('REC_PROFILE_THUMB_UPLOAD_URL', BASEURL . 'uploads/recruiter_profile/thumbs/');

// RECRUITER BACKGROUND IMAGE 
    define('REC_BG_MAIN_UPLOAD_URL', BASEURL . 'uploads/recruiter_bg/main/');

// RECRUITER BACKGROUND THUMB IMAGE
    define('REC_BG_THUMB_UPLOAD_URL', BASEURL . 'uploads/recruiter_bg/thumbs/');

// RECRUITER BACKGROUND ORIGINAL IMAGE
    define('REC_BG_ORIGINAL_UPLOAD_URL', BASEURL . 'uploads/recruiter_bg/original/');

// FREELANCER PORTFOLIO ATTACHMENT 
    define('FREE_PORTFOLIO_MAIN_UPLOAD_URL', BASEURL . 'uploads/freelancer_post_portfolio/main/');

// FREELANCER PORTFOLIO ATTACHMENT THUMBS
    define('FREE_PORTFOLIO_THUMB_UPLOAD_URL', BASEURL . 'uploads/freelancer_post_portfolio/thumbs/');

// FREELANCER HIRE PROFILE 
    define('FREE_HIRE_PROFILE_MAIN_UPLOAD_URL', BASEURL . 'uploads/freelancer_hire_profile/main/');

// FREELANCER HIRE PROFILE THUMBS
    define('FREE_HIRE_PROFILE_THUMB_UPLOAD_URL', BASEURL . 'uploads/freelancer_hire_profile/thumbs/');

// FREELANCER HIRE BACKGROUND
    define('FREE_HIRE_BG_MAIN_UPLOAD_URL', BASEURL . 'uploads/freelancer_hire_bg/main/');

// FREELANCER HIRE BACKGROUND THUMB
    define('FREE_HIRE_BG_THUMB_UPLOAD_URL', BASEURL . 'uploads/freelancer_hire_bg/thumbs/');

// FREELANCER HIRE BACKGROUND ORIGINAL
    define('FREE_HIRE_BG_ORIGINAL_UPLOAD_URL', BASEURL . 'uploads/freelancer_hire_bg/original/');

// FREELANCER POST PROFILE
    define('FREE_POST_PROFILE_MAIN_UPLOAD_URL', BASEURL . 'uploads/freelancer_post_profile/main/');

// FREELANCER POST PROFILE THUMBS
    define('FREE_POST_PROFILE_THUMB_UPLOAD_URL', BASEURL . 'uploads/freelancer_post_profile/thumbs/');

// FREELANCER POST PROFILE BACKGROUND
    define('FREE_POST_BG_MAIN_UPLOAD_URL', BASEURL . 'uploads/freelancer_post_bg/main/');

// FREELANCER POST PROFILE BACKGROUND THUMBS
    define('FREE_POST_BG_THUMB_UPLOAD_URL', BASEURL . 'uploads/freelancer_post_bg/thumbs/');

// FREELANCER POST PROFILE BACKGROUND ORIGINAL
    define('FREE_POST_BG_ORIGINAL_UPLOAD_URL', BASEURL . 'uploads/freelancer_post_bg/original/');

// BUSINESS PROFILE IMAGE
    define('BUS_PROFILE_MAIN_UPLOAD_URL', BASEURL . 'uploads/business_profile/main/');

// BUSINESS PROFILE IMAGE THUMBS
    define('BUS_PROFILE_THUMB_UPLOAD_URL', BASEURL . 'uploads/business_profile/thumbs/');

// BUSINESS DETAILS IMAGE
    define('BUS_DETAIL_MAIN_UPLOAD_URL', BASEURL . 'uploads/business_profile/main/');

// BUSINESS DETAILS IMAGE THUMBS
    define('BUS_DETAIL_THUMB_UPLOAD_URL', BASEURL . 'uploads/business_profile/thumbs/');

// BUSINESS PROFILE BACKGROUND
    define('BUS_BG_MAIN_UPLOAD_URL', BASEURL . 'uploads/business_bg/main/');

// BUSINESS PROFILE BACKGROUND THUMBS
    define('BUS_BG_THUMB_UPLOAD_URL', BASEURL . 'uploads/business_bg/thumbs/');

// BUSINESS PROFILE BACKGROUND ORIGINAL
    define('BUS_BG_ORIGINAL_UPLOAD_URL', BASEURL . 'uploads/business_bg/original/');

// BUSINESS POST 
    define('BUS_POST_MAIN_UPLOAD_URL', BASEURL . 'uploads/business_post/main/');

// BUSINESS POST RESIZED
    define('BUS_POST_RESIZE_UPLOAD_URL', BASEURL . 'uploads/business_post/resize/');

// BUSINESS POST THUMBS
    define('BUS_POST_THUMB_UPLOAD_URL', BASEURL . 'uploads/business_post/thumbs/');

// BUSINESS POST 335 X 320
    define('BUS_POST_RESIZE1_UPLOAD_URL', BASEURL . 'uploads/business_post/resize1/');

// BUSINESS POST 335 X 245
    define('BUS_POST_RESIZE2_UPLOAD_URL', BASEURL . 'uploads/business_post/resize2/');

// BUSINESS POST 210 X 210
    define('BUS_POST_RESIZE3_UPLOAD_URL', BASEURL . 'uploads/business_post/resize3/');

// BUSINESS POST 550 X 220
    define('BUS_POST_RESIZE4_UPLOAD_URL', BASEURL . 'uploads/business_post/resize4/');

// ARTISTIC PROFILE IMAGE
    define('ART_PROFILE_MAIN_UPLOAD_URL', BASEURL . 'uploads/artistic_profile/main/');

// ARTISTIC PROFILE IMAGE THUMBS
    define('ART_PROFILE_THUMB_UPLOAD_URL', BASEURL . 'uploads/artistic_profile/thumbs/');

    // ARTISTIC POST 335 X 320
    define('ART_POST_RESIZE1_UPLOAD_URL', BASEURL . 'uploads/artistic_post/resize1/');

// ARTISTIC POST 335 X 245
    define('ART_POST_RESIZE2_UPLOAD_URL', BASEURL . 'uploads/artistic_post/resize2/');

// ARTISTIC POST 210 X 210
    define('ART_POST_RESIZE3_UPLOAD_URL', BASEURL . 'uploads/artistic_post/resize3/');

// ARTISTIC POST 550 X 220
    define('ART_POST_RESIZE4_UPLOAD_URL', BASEURL . 'uploads/artistic_post/resize4/');
// ARTISTIC PROFILE BACKGROUND
    define('ART_BG_MAIN_UPLOAD_URL', BASEURL . 'uploads/artistic_bg/main/');

// ARTISTIC PROFILE BACKGROUND THUMBS
    define('ART_BG_THUMB_UPLOAD_URL', BASEURL . 'uploads/artistic_bg/thumbs/');

// ARTISTIC PROFILE BACKGROUND ORIGINAL
    define('ART_BG_original_UPLOAD_URL', BASEURL . 'uploads/artistic_bg/original/');

// ARTISTIC PORTFOLIO
    define('ART_PORTFOLIO_MAIN_UPLOAD_URL', BASEURL . 'uploads/artistic_portfolio/main/');

// ARTISTIC PORTFOLIO THUMBS
    define('ART_PORTFOLIO_THUMB_UPLOAD_URL', BASEURL . 'uploads/artistic_portfolio/thumbs/');

// ARTISTIC POST 
    define('ART_POST_MAIN_UPLOAD_URL', BASEURL . 'uploads/artistic_post/main/');

// ARTISTIC POST THUMBS
    define('ART_POST_THUMB_UPLOAD_URL', BASEURL . 'uploads/artistic_post/thumbs/');

// BLOG MAIN IMAGE
    define('BLOG_MAIN_UPLOAD_URL', BASEURL . 'uploads/blog/main/');

// BLOG THUMB THUMB
    define('BLOG_THUMB_UPLOAD_URL', BASEURL . 'uploads/blog/thumbs/');
    
    
// USER POST 
    define('USER_POST_MAIN_UPLOAD_URL', BASEURL . 'uploads/user_post/main/');

// USER POST RESIZED
    define('USER_POST_RESIZE_UPLOAD_URL', BASEURL . 'uploads/user_post/resize/');

// USER POST THUMBS
    define('USER_POST_THUMB_UPLOAD_URL', BASEURL . 'uploads/user_post/thumbs/');

// USER POST 335 X 320
    define('USER_POST_RESIZE1_UPLOAD_URL', BASEURL . 'uploads/user_post/resize1/');

// USER POST 335 X 245
    define('USER_POST_RESIZE2_UPLOAD_URL', BASEURL . 'uploads/user_post/resize2/');

// USER POST 210 X 210
    define('USER_POST_RESIZE3_UPLOAD_URL', BASEURL . 'uploads/user_post/resize3/');

// USER POST 550 X 220
    define('USER_POST_RESIZE4_UPLOAD_URL', BASEURL . 'uploads/user_post/resize4/');    
    
}


define('VALID_IMAGE', serialize (array('jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF', 'psd', 'PSD', 'bmp', 'BMP', 'tiff', 'TIFF', 'iff', 'IFF', 'xbm', 'XBM', 'webp', 'WebP', 'HEIF', 'heif', 'BAT', 'bat', 'BPG', 'bpg', 'SVG', 'svg')));
                            
// SMTP CREDENTIAL

//define('SMTP_HOST', 'Smtp.gmail.com'); //email-smtp.us-west-2.amazonaws.com
define('SMTP_HOST', 'ssl://smtpout.asia.secureserver.net'); //email-smtp.us-west-2.amazonaws.com
//define('SMTP_PORT', '25'); //465
define('SMTP_PORT', '465'); //465
define('SMTP_USER', 'noreply@aileensoul.com');
define('SMTP_PASS', 'aileensoul@123');
define('CHARSET', 'utf-8');
define('MAILTYPE', 'html');


// Define Artist Path

define('base_url', BASEURL); 
define('artist_registration', BASEURL. 'artist/registration'); 
define('artist_dashboard', BASEURL. 'artist/p/'); 
define('artist_reactivateacc', BASEURL. 'artist/reactivateacc'); 
define('artist_category', BASEURL. 'artist/'); 
define('artist_other_category', BASEURL. 'artist/other'); 
define('artist_category_list', BASEURL. 'artist/category'); 
define('artist_location', BASEURL. 'artist-in-'); 
define('artist_location_list', BASEURL. 'artist/location'); 
define('artist_information_update', BASEURL. 'artist/artistic-information-update'); 
define('artist_information', BASEURL. 'artist/artistic-information'); 
define('artist_art_address_insert', BASEURL. 'artist/art_address_insert'); 
define('artist_userlist', BASEURL. 'artist/userlist'); 
define('artist_art_post_insert', BASEURL. 'artist/art_post_insert/'); 
define('artist_videos', BASEURL. 'artist/videos/'); 
define('artist_audios', BASEURL. 'artist/audios/'); 
define('artist_pdf', BASEURL. 'artist/pdf/'); 
define('artist_details', BASEURL. 'artist/details/'); 
define('artist_followers', BASEURL. 'artist/followers/'); 
define('artist_following', BASEURL. 'artist/following/'); 
define('artist_edit_profile', BASEURL. 'artist/edit-information/'); 
define('artistic_address', BASEURL. 'artist/artistic-address/'); 

define('find_artist', BASEURL. 'find-artist/'); 
define('profiles', BASEURL. 'profiles/'); 
define('job', BASEURL. 'job/'); 
define('recruiter', BASEURL. 'recruiter/'); 
define('freelance', BASEURL. 'freelance/'); 
