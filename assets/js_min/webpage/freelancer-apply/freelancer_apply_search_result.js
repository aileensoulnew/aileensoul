function freelancerapply_search(a){isProcessing||(isProcessing=!0,$.ajax({type:"POST",url:base_url+"search/ajax_freelancer_post_search?page="+a+"&skill="+encodeURIComponent(skill)+"&place="+place,data:{total_record:$("#total_record").val()},dataType:"html",beforeSend:function(){document.getElementById("loader").style.display="block"},complete:function(){document.getElementById("loader").style.display="none"},success:function(a){$(".job-contact-frnd1").append(a);var o=$(".job-contact-frnd1 .all-job-box").length;0==o&&$(".job-contact-frnd1").addClass("cust-border");var e=$(".post-design-box").length;0==e?$("#dropdownclass").addClass("no-post-h2"):$("#dropdownclass").removeClass("no-post-h2"),isProcessing=!1}}))}function save_post(a){$.ajax({type:"POST",url:base_url+"freelancer/save_user",data:"post_id="+a,success:function(o){$(".savedpost"+a).html(o).addClass("saved")}})}function savepopup(a){save_post(a),$(".biderror .mes").html("<div class='pop_content'>Your post is successfully saved."),$("#bidmodal").modal("show")}function apply_post(a,o){var e="all",s=o;$.ajax({type:"POST",url:base_url+"freelancer/apply_insert",data:"post_id="+a+"&allpost="+e+"&userid="+s,dataType:"json",success:function(o){if($(".savedpost"+a).hide(),$(".applypost"+a).html(o.status),$(".applypost"+a).attr("disabled","disabled"),$(".applypost"+a).attr("onclick","myFunction()"),$(".applypost"+a).addClass("applied"),0!=o.notification.notification_count){var e=o.notification.notification_count,s=o.notification.to_id;show_header_notification(e,s)}}})}function applypopup(a,o){$(".biderror .mes").html("<div class='pop_content'>Are you sure you want to apply this post?<div class='model_ok_cancel'><a class='okbtn' id="+a+" onClick='apply_post("+a+","+o+")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>"),$("#bidmodal").modal("show")}$(document).ready(function(){freelancerapply_search(),$(window).scroll(function(){if($(window).scrollTop()>=.7*($(document).height()-$(window).height())){var a=$(".page_number:last").val(),o=$(".total_record").val(),e=$(".perpage_record").val();if(parseInt(e)<=parseInt(o)){var s=o/e;s=parseInt(s,10);var t=o%e;if(t>0&&(s+=1),parseInt(a)<=parseInt(s)){var n=parseInt($(".page_number:last").val())+1;freelancerapply_search(n)}}}})});var isProcessing=!1;$(document).on("keydown",function(a){27===a.keyCode&&$("#bidmodal").modal("hide")});