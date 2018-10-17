<?php
echo $header;
echo $leftmenu;
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
 <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>
         <i class="fa fa-newspaper-o" aria-hidden="true"></i>
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
         <li class="active">Article</li>
     </ol>        
   </section>

   <!-- Main content -->
   <section class="content">
      <div class="row" >
         <div class="col-xs-12" >
            <?php if ($this->session->flashdata('success')) { ?>
            <div class="callout callout-success">
               <p><?php echo $this->session->flashdata('success'); ?></p>
            </div>
            <?php } ?>
            <?php if ($this->session->flashdata('error')) { ?>  
            <div class="callout callout-danger">
               <p><?php echo $this->session->flashdata('error'); ?></p>
            </div>
            <?php } ?>
         </div>
      </div>

      <div class="row">
         <div class="col-xs-12">
            <div class="box">
               <div class="box-header">
                  <h3 class="box-title">Article</h3>

                  <div class="box-tools">
                     <?php echo form_open('article/search', array('method' => 'post', 'id' => 'search_frm', 'class' => 'form-inline','autocomplete' => 'off')); ?>
                     <div class="input-group input-group-sm" >
                        <input type="text" class="form-control input-sm" value="<?php echo $search_keyword; ?>" placeholder="Search" name="search_keyword" id="search_keyword">
                        <div class="input-group-btn">
                           <button type="submit" class="btn btn-default" id="search_btn"><i class="fa fa-search"></i></button>
                        </div><!--input-group-btn-->
                        <?php echo form_close(); 
                        if ($this->session->userdata('user_search_keyword'))
                        {?>
                           <a href="<?php echo base_url('article/clear_search') ?>">Clear Search</a>
                           <?php
                        } ?>
                     </div><!--input-group input-group-sm-->
                  </div><!--box-tools-->
               </div><!-- box-header -->
               <div class="box-body table-responsive no-padding">
                  <table class="table table-hover table-bordered">
                     <tbody>
                        <tr>
                           <?php
                           if ($this->uri->segment(2) == '' || $this->uri->segment(2) == 'user') {
                              $segment2 = 'user';
                           } 
                           else {
                              $segment2 = 'search';
                           }
                           ?>
                           <th><i class="fa fa-bullhorn"></i>
                              <a href="javascript:void(0);">ID.</a>
                           </th>
                           <th style="width: 10%;"><i class="fa fa-user"></i>
                              <a href="javascript:void(0);">Fullname</a>
                           </th>
                           <th><i class="fa fa-envelope"></i>
                              <a href="javascript:void(0);">Email</a>
                           </th>
                           <th style="width: 15%;"><i class="fa fa-fw fa-pencil-square"></i> 
                              <a href="javascript:void(0);">Title</a>
                           </th>
                           <th  style="width: 25%;"><i class="fa fa-fw fa-pencil-square"></i> 
                              <a href="javascript:void(0);">Description</a>
                           </th>
                           <th><i class="fa fa-fw fa-pencil-square"></i> 
                              <a href="javascript:void(0);">Status</a>
                           </th>
                           <th><i class="fa fa-fw fa-pencil"></i> 
                              <a href="javascript:void(0);">Created Date</a>
                           </th>
                           <th><i class=" fa fa-edit"></i> 
                              <a href="javascript:void(0);">Action</a>
                           </th>
                        </tr>
                        <?php
                        if (count($article_list) != 0){
                           $i = $offset + 1; 
                           foreach ($article_list as $article) {?>
                              <tr id="delete<?php echo $article['id_post_article'];?>">
                                 <td><?php echo $i++; ?></td>
                                 <td><?php echo ucwords($article['first_name'].' '.$article['last_name']); ?></td>
                                 <td><?php echo $article['email']; ?></td>
                                 <td><?php echo $article['article_title']; ?></td>
                                 <td><?php echo substr(htmlentities($article['article_desc']), 0,100); ?></td>
                                 <td class="art-status-<?php echo $article['id_post_article']; ?>">
                                    <?php 
                                    if($article['user_post_status'] == "publish" && $article['user_post_isdeleted'] == '0')
                                    {
                                       $status = "Accepted";
                                    }
                                    elseif($article['user_post_status'] == "draft" && $article['user_post_isdeleted'] == '0')
                                    {
                                       $status = "Pending";
                                    }
                                    elseif($article['user_post_status'] == "reject" && $article['user_post_isdeleted'] == '0')
                                    {
                                       $status = "Rejected";
                                    }
                                    elseif($article['user_post_isdeleted'] == '1')
                                    {
                                       $status = "Deleted";
                                    }
                                    echo $status; ?>
                                 </td>
                                 <td><?php echo $article['created_date']; ?></td>
                                 <td>
                                    <?php
                                    if($article['user_post_status'] == "draft" && $article['user_post_isdeleted'] == '0'):
                                    ?>
                                    <button class="btn btn-primary btn-xs art-pub-<?php echo $article['id_post_article']; ?>" onclick="publish_article(<?php echo $article['id_post_article']; ?>);" >
                                       <i class="fa fa-upload"></i>
                                    </button>
                                    <button class="btn btn-danger btn-xs art-pub-<?php echo $article['id_post_article']; ?>" onclick="delete_article(<?php echo $article['id_post_article']; ?>);">
                                       <i class="fa fa-trash-o"></i>
                                    </button>
                                    <button class="btn btn-danger btn-xs art-pub-<?php echo $article['id_post_article']; ?>" onclick="reject_article(<?php echo $article['id_post_article']; ?>);">
                                       <i class="fa fa-ban"></i>
                                    </button>
                                    <?php endif; ?>
                                    <a class="btn btn-success btn-xs" href="<?php echo base_url('article/articledetail/'.$article['id_post_article'] ); ?>">
                                       <i class="fa fa-fw fa-eye"></i>
                                    </a>
                                 </td>
                              </tr>
                              <?php
                           }//for loop close
                        }//if close
                        else 
                        { ?>
                           <tr>
                              <td align="center" colspan="11"> Oops! No Data Found</td>
                           </tr>
                           <?php
                        } ?>
                     </tbody>
                  </table>
               </div><!--box-body table-responsive no-padding -->
            </div><!-- /.box -->
         </div><!-- /.col -->
         <div class="dta_left col-md-6" id="pagination">
            <?php
            if ($total_rows > 0)
            {
               if ($this->pagination->create_links())
               {
                 $rec1 = $offset + 1;
                 $rec2 = $offset + $limit;
                 if ($rec2 > $total_rows) 
                 {
                     $rec2 = $total_rows;
                 } ?>
                 <div style="margin-left: 20px;">
                  <?php  echo "Records $rec1 - $rec2 of $total_rows"; ?>
                  </div>
                  <?php
               }
               else 
               { ?>
                  <div style="margin-left: 20px;">
                     <?php echo "Records 1 - $total_rows of $total_rows"; ?>
                  </div>
                  <?php
               }
            } ?>
         </div><!-- dta_left col-md-6--> 
         <!-- /pagination Start-->
         <?php
         if ($this->pagination->create_links()) 
         {
            $tot_client = ceil($total_rows / $limit);
            $cur_client = ceil($offset / $limit) + 1; ?>
            <div class="text-right data_right col-md-6">
               <div id="example2_paginate" class="dataTables_paginate paging_simple_numbers">
                  <?php echo $this->pagination->create_links(); ?> 
               </div>
            </div>
         <?php } ?>
         <!-- /pagination End-->
      </div><!-- /.row -->
   </section><!-- /.content -->
</div><!-- /.content-wrapper -->

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

<!-- Footer start -->
<?php echo $footer; ?>
<!-- Footer End -->

<script language="javascript" type="text/javascript">
    $(document).ready(function () {
        $('.callout-danger').delay(3000).hide('700');
        $('.callout-success').delay(3000).hide('700');
    });
</script>

<script>
//Publish Article Start
function publish_article(id) 
{
  $("#publishmodal .mes .msg").html("Are you sure want to publish article ?");
  $("#okbtn").attr("onclick","article_publish("+id+")");
  $("#publishmodal").modal("show");
}
function article_publish(id) 
{
  $('.'+'art-pub-'+id).attr("style","pointer-events: none;");
   $.ajax({
      type: 'POST',
      url: '<?php echo base_url() . "article/publish" ?>',
      data: {'id':id},      
      success: function (response){
         $('.'+'art-pub-'+id).remove();
         $('.'+'art-status-'+id).html(response);
      }
   });
}
//Publish Article End

//Reject Article Start
function reject_article(id) 
{
   $("#publishmodal .mes .msg").html("Are you sure want to reject article ?");
   $("#okbtn").attr("onclick","article_reject("+id+")");
   $("#publishmodal").modal("show");
}
function article_reject(id) 
{
  $('.'+'art-pub-'+id).attr("style","pointer-events: none;");
   $.ajax({
      type: 'POST',
      url: '<?php echo base_url() . "article/reject" ?>',
      data: {'id':id},      
      success: function (response){
        $('.art-pub-'+id).remove();
        $('.art-status-'+id).html(response);
      }
   });
}
//Reject Article End

//Reject Article Start
function delete_article(id) 
{
   $("#publishmodal .mes .msg").html("Are you sure want to delete article ?");
   $("#okbtn").attr("onclick","article_delete("+id+")");
   $("#publishmodal").modal("show");
}
function article_delete(id) 
{
  $('.'+'art-pub-'+id).attr("style","pointer-events: none;");
   $.ajax({
      type: 'POST',
      url: '<?php echo base_url() . "article/delete" ?>',
      data: {'id':id},      
      success: function (response){
         $('.art-pub-'+id).remove();
         $('.art-status-'+id).html(response);
      }
   });
}
//Reject Article End

//Enable search button when user write something on textbox Start
 $(document).ready(function(){
    $('#search_btn').attr('disabled',true);

    $('#search_keyword').keyup(function()
    {  
        if($(this).val().length !=0)
        {
            $('#search_btn').attr('disabled', false);
        }
        else
        {  
            $('#search_btn').attr('disabled', true);        
        }
    })

     $('body').on('keydown', '#search_keyword', function(e) {
    console.log(this.value);
    if (e.which === 32 &&  e.target.selectionStart === 0) {
      return false;
    }  
  });
});
//Enable search button when user write something on textbox End

// $(function() {
 
// });
</script>