<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php echo $head; ?>
        <?php
        $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        ?>
        <link rel="canonical" href="<?php echo $actual_link ?>" />
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/aos.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>" />
    </head>
    <?php if($this->session->userdata('aileenuser')){ ?>
        <body class="page-container-bg-solid page-boxed">
    <?php }else{ ?>
        <body class="page-container-bg-solid page-boxed old-no-login">
    <?php } ?>
        <?php //echo $header; ?>
        <header class="custom-header">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-3 col-xs-4 fw-539 left-header">
                        <?php $this->load->view('main_logo'); ?>
                    </div>
                    <div class="col-md-8 col-sm-9 col-xs-8 fw-539 right-header">
                        <div class="btn-right">
                            <?php if (!$this->session->userdata('aileenuser')) { ?>
                                <a href="<?php echo base_url('login'); ?>" class="btn4">Login</a>
                                <a href="<?php echo base_url('registration'); ?>" class="btn2">Create an account</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="middle-section middle-section-banner">
            <div class="container">
                <div class="error-top-box">
                    <h1>
                        <span>Oh no!</span>
                        <span>Seems something is broken.</span>
                    </h1>
                    <p class="text-center pb20">
                        <img src="<?php echo base_url('assets/n-images/404.jpg?ver=' . time()) ?>">
                    </p>
                    <h2 class="text-center pt20 pb10">May be the following options can help you reach your destination.</h2>
                </div>
                <div class="error-bottom">
                    <ul class="row">
                        <li class="error-main-box">
                            <a href="<?php echo $job_right_profile_link; ?>">
                                <div class="error-pr-box">
                                    <img src="<?php echo base_url('assets/n-images/e-job.png?ver=' . time()) ?>">
                                    <p>Looking for Great Job Opportunities? Create Free Job Profile Account</p>
                                </div>
                            </a>
                        </li>
                        <li class="error-main-box">
                            <a href="<?php echo $recruiter_right_profile_link; ?>">
                                <div class="error-pr-box">
                                    <img src="<?php echo base_url('assets/n-images/e-rec.png?ver=' . time()) ?>">
                                    <p>Looking for Hiring Quality Employees? Create Free Recruiter Profile Account</p>
                                </div>
                            </a>
                        </li>
                        <li class="error-main-box">
                            <a href="<?php echo $freelance_hire_right_profile_link; ?>">
                                <div class="error-pr-box">
                                    <img src="<?php echo base_url('assets/n-images/e-free-apply.png?ver=' . time()) ?>g">
                                    <p>Looking for Remote Team? Create Free Freelance Employer Profile Account</p>
                                </div>
                            </a>
                        </li>
                        <li class="error-main-box">
                            <a href="<?php echo $freelance_apply_right_profile_link; ?>">
                                <div class="error-pr-box">
                                    <img src="<?php echo base_url('assets/n-images/e-free.png?ver=' . time()) ?>g">
                                    <p>Looking for Freelance Work? Create Free Freelancer Profile Account</p>
                                </div>
                            </a>
                        </li>
                        <li class="error-main-box">
                            <a href="<?php echo $business_right_profile_link; ?>">
                                <div class="error-pr-box">
                                    <img src="<?php echo base_url('assets/n-images/e-bus.png?ver=' . time()) ?>">
                                    <p>Looking for Growing Business Network? Create Free Business Profile Account</p>
                                </div>
                            </a>
                        </li>
                        <li class="error-main-box">
                            <a href="<?php echo $artist_right_profile_link; ?>">
                                <div class="error-pr-box">
                                    <img src="<?php echo base_url('assets/n-images/e-art.png?ver=' . time()) ?>">
                                    <p>Looking for Platform to Show Artistic Side? Create Free Artistic Profile Account</p>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="error-btn">
                    <div class="col-md-6 col-sm-6 text-right">
                        <a class="btn3" href="<?php echo $_SERVER['HTTP_REFERER']; ?>"><img class="pr20" src="<?php echo base_url('assets/n-images/e-arrow.png?ver=' . time()) ?>"><span>Back to Previous page</span></a>
                    </div>
                    <div class="col-md-6 col-sm-6 text-left">
                        <a class="btn3" href="<?php echo base_url(); ?>"><img class="pr20" src="<?php echo base_url('assets/n-images/e-home.png?ver=' . time()) ?>"><span>Back to Home page</span></a>
                    </div>
                </div>
                
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js?ver=<?php echo time(); ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>        
        <script src="<?php echo base_url('assets/js/owl.carousel.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/aos.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js?ver=' . time()); ?>"></script>
        <script>
            var base_url = '<?php echo base_url(); ?>';
        </script>
        <footer>
            <?php echo $footer; ?>
        </footer>
    </body>
</html>
