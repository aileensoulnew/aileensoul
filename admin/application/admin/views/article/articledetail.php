<?php
echo $header;
echo $leftmenu;
use Caxy\HtmlDiff\HtmlDiff;
require '../contentcompare/vendor/autoload.php';
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
     del.diffmod {
          color: red;
          display: none;
      }

      ins.diffmod {
          color: #000;
          background: #1b8ab921;
          text-decoration: none
      }

      ins.diffins {
        color: #000;
          background: #1b8ab921;
          text-decoration: none;
      }
      ins.mod {
          text-decoration: none;
      }
      del.diffdel {
          display: none;
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
                         <i class="fa fa-dashboard"></i>Home
                    </a>
               </li>
               <li class="active">Article</li>
          </ol>
     </section>

     <!-- Main content -->
     <section class="content feedback">
          <div class="row">
               <div class="col-md-3">
                    <!-- Profile Image --> 
                    <div class="box box-primary mt0">
                         <div class="box-body box-profile">
                              <h3 class="profile-username text-center">
                                   <?php echo ucwords($article_detail['first_name'].' '.$article_detail['last_name']);  ?>
                              </h3>
                         </div>
                         <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                    <!-- Profile Image --> 
                    <div class="box box-primary mt0">
                         <div class="box-body box-profile">
                              <div class="profile-username text-center art-pub-<?php echo $article_detail['id_post_article']; ?>">                                   
                              <?php
                               if($article_detail['user_post_status'] == "draft" && $article_detail['user_post_isdeleted'] == '0'){
                               ?>
                                   <a class="btn1 btn-lg" id="acceptbtn" onclick="publish_article(<?php echo $article_detail['id_post_article']; ?>)" href="javascript:void(0);" data-dismiss="modal" title="Accept">Accept</a>
                                   <a class="btn1 btn-lg" id="rejectbtn" onclick="reject_article(<?php echo $article_detail['id_post_article']; ?>)" href="javascript:void(0);" data-dismiss="modal" title="Reject">Reject</a>
                              <?php }
                              elseif($article_detail['user_post_status'] == 'reject'){
                                   echo "Rejected";
                              }
                              elseif($article_detail['user_post_status'] == 'publish'){
                                   echo "Accepted";
                              }
                              elseif($article_detail['user_post_isdeleted'] == '1'){
                                   echo "Deleted";
                              } ?>
                              </div>
                         </div>
                         <!-- /.box-body -->
                    </div>
                    <!-- /.box -->    
               </div>
               <div class="col-md-3">
                    <!-- About Me Box -->
                    <div class="box box-primary mt0">
                         <div class="box-header with-border">
                              <h3 class="box-title">About Me</h3>
                         </div>
                         <!-- /.box-header -->
                         <div class="box-body">
                              <strong><i class="fa fa-map-marker margin-r-5"></i> Email Address</strong>
                              <p> <?php echo $article_detail['email']; ?> </p> 
                         </div>
                          <div class="box-body"></div>
                         <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
               </div>

               <?php
               if($article_detail['article_featured_image'] != ""){ ?>
               <div class="col-md-3">
                    <!-- About Me Box -->
                    <div class="box box-primary mt0">
                         <div class="box-header with-border">
                              <h3 class="box-title">Featured Image</h3>
                         </div>
                         <!-- /.box-header -->
                         <div class="box-body">
                          <img id="featured_img_src" src="<?php echo ARTICLE_FEATURED_IMAGE.$article_detail['article_featured_image']; ?>" style="width: 100%">
                         </div>
                          <div class="box-body"></div>
                         <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
               </div>
               <?php 
                } ?>
               <!-- /.col -->
               <div class="col-md-12">
                    <div class="nav-tabs-custom">
                         <ul class="nav nav-tabs">
                              <li class="active">
                                   <a href="#basic_information" data-toggle="tab"><i class="fa fa-fw fa-info-circle margin-r-5"></i> <?php echo ucwords($article_detail['article_title']); ?></a>
                              </li>
                         </ul>
                         <div class="tab-content hide">
                              <div class="active tab-pane" id="basic_information">
                                   <!-- Post -->
                                   <div class="post">
                                        <form class="form-horizontal">
                                             <div class="form-group">
                                                  <label for="inputName" class="col-sm-2 control-label">Description</label>
                                                  <div class="col-sm-2 control-label">
                                                       <?php 
                                                       echo $article_detail['article_desc'];
                                                       ?>
                                                  </div>
                                             </div>
                                        </form>
                                   </div>
                                   <!-- /.post -->
                              </div>
                         </div>
                         <!-- /.tab-content -->
                         <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#new">New</a></li>
                            <li><a data-toggle="tab" href="#old">Old</a></li>
                            <li><a data-toggle="tab" href="#compare">Compare</a></li>
                          </ul>

                          <div class="tab-content">
                            <div id="new" class="tab-pane fade in active">
                              <?php echo $article_detail['article_desc'];?>
                            </div>
                            <div id="old" class="tab-pane fade">
                              <?php echo $article_detail['article_desc_old'];?>
                            </div>
                            <div id="compare" class="tab-pane fade">
                              <?php
                              $oldHtml = $article_detail['article_desc_old'];
                              $newHtml = $article_detail['article_desc'];
                              $htmlDiff = new HtmlDiff($oldHtml, $newHtml);
                              $htmlDiff->getConfig()
                                  ->setMatchThreshold(80)
                                  ->setInsertSpaceInReplace(true);
                              $content = $htmlDiff->build();
                              echo $content;
                              ?>
                            </div>                            
                          </div>
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
<!-- Model Popup Start -->
   <div class="modal fade message-box biderror" id="publishmodal" role="dialog" data-backdrop="static" data-keyboard="false">
       <div class="modal-dialog modal-lm">
           <div class="modal-content message">
            <button type="button" class="modal-close" data-dismiss="modal">&times;</button>
               <div class="modal-body">
                   <span class="mes">
                     <div class="msg"></div>
                      <div class="pop_content">
                        <div class="model_ok_cancel">
                           <a class="btn1 btn-lg" id="okbtn" onclick="" href="javascript:void(0);" data-dismiss="modal" title="OK">OK</a>
                           <a class="btn1 btn-lg" id="cancelbtn" href="javascript:void(0);" data-dismiss="modal" title="Cancel">Cancel</a>
                        </div>
                      </div>
                  </span>
               </div>               
           </div>
       </div>
   </div>
   <!-- Model Popup End -->
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

function publish_article(id) 
{
   $("#publishmodal .mes .msg").html("Are you sure want to publish article ?");
   $("#okbtn").attr("onclick","article_publish("+id+")");
   $("#publishmodal").modal("show");
}
function reject_article(id) 
{
   $("#publishmodal .mes .msg").html("Are you sure want to reject article ?");
   $("#okbtn").attr("onclick","article_reject("+id+")");
   $("#publishmodal").modal("show");
}

function article_publish(id) 
{
   $.ajax({
      type: 'POST',
      url: '<?php echo base_url() . "article/publish" ?>',
      data: 'id=' + id,
      success: function (response){
         $('.'+'art-pub-'+id).html(response);         
      }
   });
}
function article_reject(id) 
{
   $.ajax({
      type: 'POST',
      url: '<?php echo base_url() . "article/reject" ?>',
      data: 'id=' + id,
      success: function (response){
         $('.'+'art-pub-'+id).html(response);
      }
   });
}
</script>
