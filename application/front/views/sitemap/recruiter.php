<!DOCTYPE html>
<?php
if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
    // $date = $_SERVER['HTTP_IF_MODIFIED_SINCE'];
    header("HTTP/1.1 304 Not Modified");
    exit();
}
$format = 'D, d M Y H:i:s \G\M\T';
$now = time();

$date = gmdate($format, $now);
header('Date: ' . $date);
header('Last-Modified: ' . $date);

$date = gmdate($format, $now + 30);
header('Expires: ' . $date);

header('Cache-Control: public, max-age=30');
?>

<html lang="en">
    <head>
        <title><?php echo $title; ?></title>
        <!-- <meta name="robots" content="noindex, nofollow"> -->
        <meta name="description" content="Aileensoul.com have something to give this world, Know about us." />
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
        
        <meta name="google-site-verification" content="BKzvAcFYwru8LXadU4sFBBoqd0Z_zEVPOtF0dSxVyQ4" />
        <?php
        $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        ?>
        <link rel="canonical" href="<?php echo $actual_link ?>" />
        <?php
        if (IS_OUTSIDE_CSS_MINIFY == '0') {
            ?>
            <link rel="stylesheet" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()) ?>">
            <link rel="stylesheet" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()) ?>">
        <?php } else { ?>
            <link rel="stylesheet" href="<?php echo base_url('assets/css_min/common-style.css?ver=' . time()) ?>">
            <link rel="stylesheet" href="<?php echo base_url('assets/css_min/style-main.css?ver=' . time()) ?>">

        <?php } ?>

  <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
        <style type="text/css">
            /*            .linkbox ul li{
                            width: 100% !important;
                        }*/
        </style>

    <?php $this->load->view('adsense'); ?>
</head>
    <body class="site-map outer-page" >
        <div class="main-inner">
            <?php echo $sitemap_header ?>
            <section class="middle-main">
                <div class="container">
                    <!-- html code for inner page  -->
                    <div class="all-site-link">
                        <h2 style="margin-left: -2px;">Recruiter Profile</h2>
                        <div class="linkbox">
                            <div class="smap-catbox">
                                <ul class="catbox-right artist-sitemap">
                                    <li style="list-style-type: circle;font-size: 20px; width: 100%;">Login/Register</li>
                                    <li style="padding-bottom: 30px; width: 100%;"><a href="<?php echo base_url('recruiter/registration') ?>">Register/Takeme in</a></li>
                                    <li style="margin-left: -20px;padding-left: 38px;font-size: 20px; width: 100%;"><a style="text-transform: none;color: #333;" href="<?php echo base_url() ?>recruiter/add-post" target="_blank">Post a Job</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="all-site-link ">
                        <h3 style="padding-bottom: 15px;">Job Seekers</h3>
                        <div class="linkbox">
                            <?php
                            foreach ($getJobseekers as $key => $value) {
                                ?>
                                <div class="smap-catbox">
                                    <div class="catbox-left">
                                        <h5><?php echo $key ?></h5>
                                    </div>
                                    <ul class="catbox-right">
                                        <?php foreach ($value as $jobseekers) { ?>
                                            <li><a href="<?php echo base_url('job/resume/' . $jobseekers['slug']) ?>" target="_blank"><?php echo $jobseekers['fname'] . ' ' . $jobseekers['lname'] ?></a></li>    
                                        <?php } ?>
                                    </ul>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>

                </div>
            </section>
            <?php
            echo $login_footer
            ?>
        </div>
        <?php
        if (IS_OUTSIDE_JS_MINIFY == '0') {
            ?><script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()); ?>" ></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/aboutus.js?ver=' . time()); ?>"></script>
        <?php } else { ?>
            <script src="<?php echo base_url('assets/js_min/jquery-3.2.1.min.js?ver=' . time()); ?>" ></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/aboutus.js?ver=' . time()); ?>"></script>
        <?php } ?>

    </body>
</html>