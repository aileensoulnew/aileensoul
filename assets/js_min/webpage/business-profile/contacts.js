function checkvalue(){var o=$.trim(document.getElementById("tags").value),t=$.trim(document.getElementById("searchplace").value);return""==o&&""==t?!1:void 0}function check(){var o=$.trim(document.getElementById("tags1").value),t=$.trim(document.getElementById("searchplace1").value);return""==o&&""==t?!1:void 0}function business_contacts(o,t){isProcessing||(isProcessing=!0,$.ajax({type:"POST",url:base_url+"business_profile/ajax_bus_contact/"+o+"?page="+t,data:{total_record:$("#total_record").val()},dataType:"html",beforeSend:function(){"undefined"==t||$("#loader").show()},complete:function(){$("#loader").hide()},success:function(o){$(".loader").remove(),$(".contact-frnd-post").append(o);var t=$(".post-design-box").length;0==t?$("#dropdownclass").addClass("no-post-h2"):$("#dropdownclass").removeClass("no-post-h2"),isProcessing=!1,check_no_contact_list()}}))}function business_contacts_header(o,t){isProcessing||(isProcessing=!0,$.ajax({type:"POST",url:base_url+"business_profile/ajax_bus_contact/"+o+"?page="+t,data:{total_record:$("#total_record").val()},dataType:"html",beforeSend:function(){"undefined"==t||$("#loader").show()},complete:function(){$("#loader").hide()},success:function(o){$(".loader").remove(),$(".contact-frnd-post").append(o);var t=$(".post-design-box").length;0==t?$("#dropdownclass").addClass("no-post-h2"):$("#dropdownclass").removeClass("no-post-h2"),isProcessing=!1}}))}function followuser_two(o){$.ajax({type:"POST",url:base_url+"business_profile/follow_two",data:"follow_to="+o,dataType:"json",success:function(t){if($(".fr"+o).html(t.follow_html),$("#countfollow").html("("+t.following_count+")"),$("#countfollower").html("("+t.follower_count+")"),0!=t.notification.notification_count){var n=t.notification.notification_count,a=t.notification.to_id;show_header_notification(n,a)}}})}function unfollowuser_two(o){$.ajax({type:"POST",url:base_url+"business_profile/unfollow_two",data:"follow_to="+o,dataType:"json",success:function(t){$(".fr"+o).html(t.unfollow_html),$("#countfollow").html("("+t.unfollowing_count+")"),$("#countfollower").html("("+t.unfollower_count+")"),check_no_contact_list()}})}function contact_person_menu(o){$.ajax({type:"POST",url:base_url+"business_profile/contact_person_menu",data:"toid="+o,dataType:"json",success:function(t){if($("#statuschange"+o).html(t.return_html),0!=t.co_notification.co_notification_count){var n=t.co_notification.co_notification_count,a=t.co_notification.co_to_id;show_contact_notification(n,a)}}})}function removecontactuser(o){var t=window.location.href.split("/").pop();$.ajax({type:"POST",url:base_url+"business_profile/removecontactuser",dataType:"json",data:"contact_id="+o+"&showdata="+t,success:function(t){$("#statuschange"+o).html(t.contactdata),1==t.notfound&&(0==t.notcount?$(".contact-frnd-post").html(t.nomsg):$("#removecontact"+o).fadeOut(2e3)),$(".contactcount").html(t.notcount)}})}function contact_person_cancle(o,t){"confirm"==t?($(".biderror .mes").html("<div class='pop_content'> Do you want to remove this user from your contact list?<div class='model_ok_cancel'><a class='okbtn' id="+o+" onClick='removecontactuser("+o+")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>"),$("#bidmodal").modal("show")):"pending"==t&&($(".biderror .mes").html("<div class='pop_content'> Do you want to cancel  contact request?<div class='model_ok_cancel'><a class='okbtn' id="+o+" onClick='contact_person_menu("+o+")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>"),$("#bidmodal").modal("show"))}function contact_person_query(o,t){$.ajax({type:"POST",url:base_url+"business_profile/contact_person_query",data:"toid="+o+"&status="+t,success:function(n){contact_person_model(o,t,n)}})}function contact_person_model(o,t,n){1==n?"pending"==t?($(".biderror .mes").html("<div class='pop_content'> Do you want to cancel  contact request?<div class='model_ok_cancel'><a class='okbtn' id="+o+" onClick='contact_person("+o+")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>"),$("#bidmodal").modal("show")):"confirm"==t?($(".biderror .mes").html("<div class='pop_content'> Do you want to remove this user from your contact list?<div class='model_ok_cancel'><a class='okbtn' id="+o+" onClick='contact_person("+o+")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>"),$("#bidmodal").modal("show")):contact_person(o):($("#query .mes").html("<div class='pop_content'>Sorry, we can't process this request at this time."),$("#query").modal("show"))}function contact_person(o){$.ajax({type:"POST",url:base_url+"business_profile/contact_person",data:"toid="+o,dataType:"json",success:function(o){if($("#contact_per").html(o),0!=o.co_notification.co_notification_count){var t=o.co_notification.co_notification_count,n=o.co_notification.co_to_id;show_contact_notification(t,n)}}})}function check_no_contact_list(){var o=$(".job-contact-frnd").length;0==o&&$(".contact-frnd-post").html(no_business_contact_html)}$(document).ready(function(){business_contacts(slug),$(window).scroll(function(){if($(window).scrollTop()>=.7*($(document).height()-$(window).height())){var o=$(".page_number:last").val(),t=$(".total_record").val(),n=$(".perpage_record").val();if(parseInt(n)<=parseInt(t)){var a=t/n;a=parseInt(a,10);var c=t%n;if(c>0&&(a+=1),parseInt(o)<=parseInt(a)){var s=parseInt($(".page_number:last").val())+1;business_contacts(slug,s)}}}})});var isProcessing=!1;$(document).ready(function(){$("html,body").animate({scrollTop:330},100)}),$(document).on("keydown",function(o){27===o.keyCode&&$("#query").modal("hide")});