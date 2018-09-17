<?php
  echo $header;
  echo $leftmenu;
?>
<style type="text/css">
  .feedback-img {
      width: 25% !important;
      float: left;
      padding-left: 10px;
      height: 180px;
  }
  .feedback-img img {
      height: 170px;
      width: 170px;
  }
  
  .feedback .modal-dialog{
    margin: 15px auto !important;
  }
  .pop_content img {
      width: 100%;
  }
</style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
     <section class="content-header">
        <h1>
            <img src="<?php echo SITEURL .'/img/i1.jpg' ?>" alt=""  style="height: 50px; width: 50px;">
            <?php echo $module_name; ?>
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('dashboard'); ?>">
                    <i class="fa fa-dashboard"></i>
                    Home
                </a>
            </li>
            <li class="active">Feedback</li>
        </ol>
    </section>

 

    <!-- Main content -->
    <section class="content feedback">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image --> 
          <div class="box box-primary mt0 hide">
            <div class="box-body box-profile">

              <h3 class="profile-username text-center"><?php //echo ucfirst($user[0]['first_name']); echo ' ';echo ucfirst($user[0]['last_name']);  ?></h3>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-primary hide">
            <div class="box-header with-border">
              <h3 class="box-title">About Me</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
           
              <strong><i class="fa fa-map-marker margin-r-5"></i> Email Address</strong>

            <p> <?php //echo $user[0]['user_email']; ?> </p> 
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#basic_information" data-toggle="tab"><i class="fa fa-fw fa-info-circle margin-r-5"></i>General Feedback</a>
              </li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="basic_information">
                <!-- Post -->
                <div class="post">

                  <form class="form-horizontal">
                    <div class="form-group">
                       <label for="inputName" class="col-sm-2 control-label">Email</label>
                      <div class="col-sm-2 control-label">
                       <?php echo $feedbackData[0]['feedback_email']; ?> 
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputName" class="col-sm-2 control-label">Description</label>
                      <div class="col-sm-2 control-label">
                        <?php 
                        echo $feedbackData[0]['feedback_desc'];
                        ?>
                      </div>
                    </div>
                    <?php if($feedbackData[0]['feedback_screenshot'] != ""):
                      $images = explode(",", $feedbackData[0]['feedback_screenshot']); ?>
                    <div class="form-group">
                      <label for="inputName" class="col-sm-2 control-label">Screenshot</label>
                      <div class="col-sm-2">
                        <?php 
                          foreach ($images as $key => $value) {
                          ?>
                          <span class="feedback-img">
                            <img data-target="#screen-model-<?php echo $key; ?>" data-toggle="modal" src="<?php echo FEEDBACK_SCREENSHOT.$value; ?>">
                          </span>                          
                          <?php
                          }
                        ?>
                      </div>
                    </div>
                    <?php 
                        foreach ($images as $key => $value) {
                        ?>
                        <div class="modal fade message-box" id="screen-model-<?php echo $key; ?>" role="dialog" tabindex="-1">
                            <div class="modal-dialog modal-lm">
                                <div class="modal-content">
                                    <button type="button" class="modal-close" id="postedit"data-dismiss="modal">&times;</button>       
                                    <div class="modal-body">
                                        <div class="mes">
                                            <div class="pop_content">
                                              <img src="<?php echo FEEDBACK_SCREENSHOT.$value; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                      ?>
                    <?php endif; ?>
                  </form>
                </div>
                <!-- /.post -->

              </div>


            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 <!-- Footer start -->
<?php echo $footer; ?>
<!-- Footer End -->

</body>
</html>

<!-- This script and css are used for tabbing at graduation and work experience Start -->
<script type="text/javascript">
   function openCity(evt, cityName,e) {
   // Declare all variables
   var i, tabcontent, tablinks;
   
   // Get all elements with class="tabcontent" and hide them
   tabcontent = document.getElementsByClassName("tabcontent");
   for (i = 0; i < tabcontent.length; i++) {
     tabcontent[i].style.display = "none";
   }
   
   // Get all elements with class="tablinks" and remove the class "active"
   tablinks = document.getElementsByClassName("tablinks");
   for (i = 0; i < tablinks.length ; i++) {
     tablinks[i].className = tablinks[i].className.replace(" active", "");
   }
   
   // Show the current tab, and add an "active" class to the button that opened the tab
   document.getElementById(cityName).style.display = "block";
   evt.currentTarget.className += " active";
  evt.preventDefault();
   }
   // $("#delete_post_model").modal("show");
</script>
<style>
   #work6 {
   display: block;
   }
   #gra1 {
   display: block;
   }
</style>
<!-- This script and css are used for tabbing at graduation and work experience ENd -->
