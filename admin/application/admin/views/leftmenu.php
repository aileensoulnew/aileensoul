<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo base_url('admin/images/logo.png') ?>" class="" alt="Dollarbid">
            </div>
        </div>

        <ul class="sidebar-menu">
            <!--<li class="header">MAIN NAVIGATION</li>-->

            <!-- Start Dashboard -->
            <li <?php if ($this->uri->segment(1) == 'dashboard' || $this->uri->segment(1) == '') { ?> class="active treeview" <?php } else { ?> class="treeview"   <?php } ?> >
                <a href="<?php echo base_url('dashboard'); ?>">
                    <i class="fa fa-dashboard margin-r-5"></i> <span>Dashboard</span> 
                </a>
            </li>
            <!-- End Dashboard -->
            <!--Start Monetizationt-->
            <li <?php if ($this->uri->segment(1) == 'monetize' || $this->uri->segment(1) == '') { ?> class="active treeview" <?php } else { ?> class="treeview"   <?php } ?>>
                <a href="#">
                    <i class="fa fa-money margin-r-5"></i> <span>Monetization</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('monetize/postlist'); ?>"><i class="fa fa-money"></i>List ALL Monetization</a></li>
                    <li><a href="<?php echo base_url('monetize/userlist'); ?>"><i class="fa fa-money"></i>User Monetization</a></li>
                    <li><a href="<?php echo base_url('monetize/paymentprocess'); ?>"><i class="fa fa-money"></i>Payment Process</a></li>
                </ul>
            </li>
            <!--End Monetizationt-->
            <!--Start Article Management-->
            <li <?php if ($this->uri->segment(1) == 'article' || $this->uri->segment(1) == '') { ?> class="active treeview" <?php } else { ?> class="treeview"   <?php } ?>>
                <a href="#">
                    <i class="fa fa-newspaper-o margin-r-5"></i> <span>Article Management</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('article/articlelist'); ?>"><i class="fa fa-newspaper-o"></i>List ALL Article</a></li>
                </ul>
            </li>
            <!--End Article Management-->
            <!--Start user Management-->
            <li <?php if ($this->uri->segment(1) == 'user_manage' || $this->uri->segment(1) == '') { ?> class="active treeview" <?php } else { ?> class="treeview"   <?php } ?>>
                <a href="#">
                    <i class="fa fa-users margin-r-5"></i> <span>User Management</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('user_manage/user'); ?>"><i class="fa fa-users"></i>List ALL User</a></li>
                </ul>
            </li>
            <!--End user Management-->            

            <!--Start Business Management-->
            <li <?php if ($this->uri->segment(1) == 'business' || $this->uri->segment(1) == '') { ?> class="active treeview" <?php } else { ?> class="treeview"   <?php } ?>>
                <a href="#">
                    <i class="fa fa-briefcase margin-r-5"></i> <span>Business Management</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('business/user'); ?>"><i class="fa fa-briefcase"></i>List Business User</a></li>
                </ul>
            </li>
            <!--End Business Management-->            

            <!--Start CSV Management-->
            <li <?php if ($this->uri->segment(1) == 'csv_file' || $this->uri->segment(1) == '') { ?> class="active treeview" <?php } else { ?> class="treeview"   <?php } ?>>
                <a href="#">
                    <i class="fa fa-file margin-r-5"></i> <span>CSV Upload</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('csv_file/index'); ?>"><i class="fa fa-file"></i>Upload CSV</a></li>
                </ul>
            </li>
            <!--End CSV Management-->
            
            <!--Start search keyword  Management-->
            <?php /* ?>
            <li <?php if ($this->uri->segment(1) == 'search_keyword' || $this->uri->segment(1) == '') { ?> class="active treeview" <?php } else { ?> class="treeview"   <?php } ?>>
                <a href="#">
                    <i class="fa fa-briefcase margin-r-5"></i> <span>Search Keyword Display</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('search_keyword/job'); ?>"><i class="fa fa-users"></i>Job Module keyword</a></li>
                    <li><a href="<?php echo base_url('search_keyword/rec'); ?>"><i class="fa fa-users"></i>Recruiter  keyword</a></li>
                    <li><a href="<?php echo base_url('search_keyword/freelancer_hire'); ?>"><i class="fa fa-users"></i>Freelancer Hire keyword</a></li>
                    <li><a href="<?php echo base_url('search_keyword/freelancer_apply'); ?>"><i class="fa fa-users"></i>Freelancer Apply keyword</a></li>
                    <li><a href="<?php echo base_url('search_keyword/business'); ?>"><i class="fa fa-users"></i>Business keyword</a></li>
                    <li><a href="<?php echo base_url('search_keyword/artistic'); ?>"><i class="fa fa-users"></i>Artistic keyword</a></li>
                </ul>
            </li>
            <!--End search keyword Management-->
            <?php */ ?>


            <!--Start Blog-->
            <li <?php if ($this->uri->segment(1) == 'blog' || $this->uri->segment(1) == '') { ?> class="active treeview" <?php } else { ?> class="treeview"   <?php } ?>>
                <a href="#">
                    <i class="fa fa-rss" aria-hidden="true"></i><span>Blog</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">     

                 <!--    <li><a href="<?php //echo base_url('blog_tag/blog_list'); ?>"><i class="fa fa-tag" aria-hidden="true"></i></i>Tag List</a></li> -->
                    <li><a href="<?php echo base_url('blog/blog_list'); ?>"><i class="fa fa-rss" aria-hidden="true"></i>Blog List</a></li>
                </ul>
            </li>
           <!--End Blog-->


           <!--Start Goverment job-->
            <li <?php if ($this->uri->segment(1) == 'goverment' || $this->uri->segment(1) == '') { ?> class="active treeview" <?php } else { ?> class="treeview"   <?php } ?>>
                <a href="#">
                    <i class="fa fa-building" aria-hidden="true"></i><span>Goverment</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">     
                    <li><a href="<?php echo base_url('goverment/add_gov_category'); ?>"><i class="fa fa-building" aria-hidden="true"></i>Add Goverment category</a></li>

                     <li><a href="<?php echo base_url('goverment/view_gov_category'); ?>"><i class="fa fa-building" aria-hidden="true"></i>View Goverment category</a></li>


                     <li><a href="<?php echo base_url('goverment/add_gov_post'); ?>"><i class="fa fa-building" aria-hidden="true"></i>Add Goverment post</a></li>

                     <li><a href="<?php echo base_url('goverment/view_gov_post'); ?>"><i class="fa fa-building" aria-hidden="true"></i>View Goverment post</a></li>

                </ul>
            </li>
           <!--End Goverment job -->


            <!--Start Feedback-->
            <li <?php if ($this->uri->segment(1) == 'feedback' || $this->uri->segment(1) == '') { ?> class="active treeview" <?php } else { ?> class="treeview"   <?php } ?>>
                <a href="#">
                    <i class="fa fa-comments-o" aria-hidden="true"></i><span>Feedback</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">     

                 <!--    <li><a href="<?php //echo base_url('blog_tag/blog_list'); ?>"><i class="fa fa-tag" aria-hidden="true"></i></i>Tag List</a></li> -->
                    <li><a href="<?php echo base_url('feedback/user'); ?>"><i class="fa fa-comments-o" aria-hidden="true"></i>Feedback List</a></li>
                    <li><a href="<?php echo base_url('feedback/general'); ?>"><i class="fa fa-comments-o" aria-hidden="true"></i>General Feedback</a></li>
                </ul>
            </li>
           <!--End Feedback-->
           
           <!--Start Advertise With us-->
            <li <?php if ($this->uri->segment(1) == 'advertise_with_us' || $this->uri->segment(1) == '') { ?> class="active treeview" <?php } else { ?> class="treeview"   <?php } ?>>
                <a href="#">
                    <i class="fa fa-line-chart" aria-hidden="true"></i><span>Advertise With Us</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">     
                   <li><a href="<?php echo base_url('advertise_with_us/'); ?>"><i class="fa fa-line-chart" aria-hidden="true"></i>Advertise With Us List</a></li>
                </ul>
            </li>
           <!--End Advertise With us-->


           <!--Start Contact us-->
            <li <?php if ($this->uri->segment(1) == 'contact_us' || $this->uri->segment(1) == '') { ?> class="active treeview" <?php } else { ?> class="treeview"   <?php } ?>>
                <a href="#">
                    <i class="fa fa-address-book" aria-hidden="true"></i><span>Contact Us</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">     

                 <!--    <li><a href="<?php //echo base_url('blog_tag/blog_list'); ?>"><i class="fa fa-tag" aria-hidden="true"></i></i>Tag List</a></li> -->
                    <li><a href="<?php echo base_url('contact_us/user'); ?>"><i class="fa fa-address-book" aria-hidden="true"></i>Contact Us List</a></li>
                </ul>
            </li>
           <!--End contact us-->


           <!--Start Blog-->
            <li <?php if ($this->uri->segment(1) == 'email' || $this->uri->segment(1) == '') { ?> class="active treeview" <?php } else { ?> class="treeview"   <?php } ?>>
                <a href="#">
                    <i class="fa fa-envelope" aria-hidden="true"></i><span>Mailbox</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">     

                 <!--<li><a href="<?php //echo base_url('blog_tag/blog_list'); ?>"><i class="fa fa-tag" aria-hidden="true"></i></i>Tag List</a></li> -->
                    <li><a href="<?php echo base_url('email/compose/job'); ?>"><i class="fa fa-envelope" aria-hidden="true"></i>Compose Mail</a></li>
                </ul>
            </li>
           <!--End Blog-->
           
           <!--Start Change Password-->
            <li <?php if ($this->uri->segment(1) == 'change_password' || $this->uri->segment(1) == '') { ?> class="active treeview" <?php } else { ?> class="treeview"   <?php } ?> >
               <a href="<?php echo base_url('dashboard/change_password'); ?>">
                   <i class="fa fa-lock"></i> <span>Change Password</span>
               </a>
           </li>
           <!--End Change Password-->
            

            <!--End of my code-->

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>