<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php echo $head; ?>
        <?php
        if (IS_BUSINESS_CSS_MINIFY == '0') {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/business.css?ver=' . time()); ?>">
            <?php
        } else {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/business.css?ver=' . time()); ?>">
        <?php } ?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>" />
        <script type="text/javascript">
            //For Scroll page at perticular position js Start
            $(document).ready(function () {
                $('html,body').animate({scrollTop: 330}, 500);
            });
            //For Scroll page at perticular position js End
        </script>
    <?php $this->load->view('adsense'); ?>
</head>
    <body class="page-container-bg-solid page-boxed pushmenu-push botton_footer">
        <?php echo $header; ?>
        <?php echo $business_header2; ?> 
        <section>
            <?php echo $business_common; ?>
            <div class="container mobp0">
                <div class="user-midd-section">
                    <div  class="col-sm-12 border_tag padding_low_data padding_les" >
                        <div class="padding_les main_art" >
                            <?php echo $file_header; ?>
                            <div class="tab-content">
                                <div class="tab-pane active" id="home">
                                    <div class="common-form">
                                        <div class="">
                                            <div class="all-box">
                                                <ul class="all-tab article-tab">
                                                    <?php
                                                    if ($buss_article_data && !empty($buss_article_data)) {
                                                        foreach ($buss_article_data as $_buss_article_data) { ?>
                                                        <li>
                                                            <a href="<?php echo $_buss_article_data['article_slug']; ?>" target="_blank">
                                                            </a>
                                                            <div class="rel-art-box">
                                                                <a href="<?php echo $_buss_article_data['article_slug']; ?>" target="_blank">
                                                                    <div class="art-list-img">
                                                                        <?php if($_buss_article_data['article_featured_image']): ?>
                                                                            <img src="<?php echo base_url().$this->config->item('article_featured_upload_path').$_buss_article_data['article_featured_image']; ?>">
                                                                        <?php else: ?>
                                                                            <img src="<?php echo base_url('assets/img/art-default.jpg'); ?>">
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </a>
                                                                <div class="rel-art-name">
                                                                    <a href="<?php echo $_buss_article_data['article_slug']; ?>" target="_blank">
                                                                        <span><?php echo substr($_buss_article_data['article_title'], 0,50); ?></span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    <?php }
                                                    } else {
                                                        ?>
                                                        <div class="art_no_pva_avl">
                                                            <div class="art_no_post_img">
                                                                <img src="<?php echo base_url('assets/images/020.png'); ?>" alt="No PDF Available">
                                                            </div>
                                                            <div class="art_no_post_text1">
                                                                No Pdf Available.
                                                            </div>
                                                        </div>

                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </section>
        
        <?php echo $login_footer ?>
        <?php echo $footer; ?>
        <script>
            var base_url = '<?php echo base_url(); ?>';
            var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
        </script>

        <script src="http://chat.aileensoul.localhost/socket.io/socket.io.js"></script>
        <script type="text/javascript">
            var socket = io.connect("<?php echo SOCKETSERVER; ?>");
        </script>
        
        <script src="<?php echo base_url('assets/js/croppie.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/business-profile/pdf.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" defer="defer" src="<?php echo base_url('assets/js/webpage/business-profile/common.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/notification.js?ver=' . time()) ?>"></script>
    </body>
</html>