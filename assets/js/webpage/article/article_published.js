function post_like(post_id) {
    $('#post-like-' + post_id).attr("style","pointer-events:none");
    $.ajax({
        url: base_url + "article/likePost",
        type: "POST",
        data: {"post_id": post_id},
        dataType: 'json',
        success: function (success) {
            $('#post-like-' + post_id).removeAttr("style");
            if (success.message == 1) {
                if (success.is_newLike == 1) {
                    // $('#post-like-count-' + post_id).show();
                    $('#post-like-' + post_id).addClass('like');
                    // $('#post-like-count-' + post_id).html(success.likePost_count);
                    if (success.likePost_count == '0') {
                        $('#post-other-like-' + post_id).html('');
                    } else {
                        $('#post-other-like-' + post_id).html(success.post_like_data);
                    }                    
                } else if (success.is_oldLike == 1) {
                    /*if(success.likePost_count < 1)
                    {                        
                        // $('#post-like-count-' + post_id).hide();
                    }
                    else
                    {
                        // $('#post-like-count-' + post_id).show();
                    }*/
                    $('#post-like-' + post_id).removeClass('like');
                    // $('#post-like-count-' + post_id).html(success.likePost_count);
                    if (success.likePost_count == '0') {
                        $('#post-other-like-' + post_id).html('');
                    } else {
                        $('#post-other-like-' + post_id).html(success.post_like_data);
                    }
                }
                if(success.post_like_data.length > 0)
                {
                    var like_content = "";
                    $.each( success.post_like_data, function( key, value ) {
                        like_content += '<li class="like-img">';
                        like_content += '<a class="ripple" href="'+base_url+value.user_slug+'" title="'+value.fullname+'">';
                        if(value.user_image != "")
                        {
                            img_url = user_thumb_upload_url+value.user_image;
                        }
                        else
                        {
                            if(value.user_gender == "M")
                            {
                                img_url = base_url+'assets/img/man-user.jpg';
                            }
                            else if(value.user_gender == "F")
                            {
                                img_url = base_url+'assets/img/female-user.jpg';
                            }
                            else
                            {
                                img_url = base_url+'assets/img/man-user.jpg';
                            }

                        }
                        like_content += '<img src="'+img_url+'">';
                        like_content += '</a></li>';
                        if(key == parseInt(like_usr_cnt) - 1)
                        {
                            return false; 
                        }                        
                    });
                    if(success.likePost_count > parseInt(like_usr_cnt))
                    {
                        like_content += '<li class="like-img">';
                        like_content += '<a class="ripple" href="javascript:void(0);">+';
                        like_content += parseInt(success.likePost_count) - parseInt(like_usr_cnt)+ " Others";
                        like_content += '</a></li>';  
                    }
                    $("#like_user_list").html(like_content);
                }
                else
                {
                    $("#like_user_list").html("");   
                }
            }
        }
    });
}

function likePostComment(comment_id, post_id) {
    $.ajax({
        url: base_url + 'user_post/likePostComment',
        type: "POST",
        data: {"comment_id": comment_id,"post_id":post_id},
        dataType: 'json',
        success: function (success) {
            if (success.message == '1') {
                if (success.is_newLike == 1) {
                    $('#post-comment-like-' + comment_id).parent('a').addClass('like');
                    $('#post-comment-like-' + comment_id).html(success.commentLikeCount);
                } else if (success.is_oldLike == 1) {
                    $('#post-comment-like-' + comment_id).parent('a').removeClass('like');
                    $('#post-comment-like-' + comment_id).html(success.commentLikeCount);
                }
            }
        }
    });    
}

function deletePostComment(comment_id, post_id)
{
    $("#del_com").attr("onclick","deleteComment("+comment_id+", "+post_id+")");
    $('#delete_model').modal('show');
}

function deleteComment (comment_id, post_id) {
    
    $.ajax({
        url: base_url + 'user_post/deletePostComment',
        type: "POST",
        data: {"comment_id": comment_id,"post_id":post_id},
        dataType: 'json',
        success: function (success) {
            if (success.message == '1') {
                $("#comment-"+comment_id).remove();
            }
        }
    });
}

function editPostComment(comment_id, post_id) {
    $(".comment-for-post-"+post_id+" .edit-comment").hide();
    $(".comment-for-post-"+post_id+" .comment-dis-inner").show();
    $(".comment-for-post-"+post_id+" li[id^=edit-comment-li-]").show();
    $(".comment-for-post-"+post_id+" li[id^=cancel-comment-li-]").hide();
    var editContent = $('#comment-dis-inner-' + comment_id).html();
    $('#edit-comment-' + comment_id).show();
    $('#editCommentTaxBox-' + comment_id).html(editContent);
    $('#comment-dis-inner-' + comment_id).hide();
    $('#edit-comment-li-' + comment_id).hide();
    $('#cancel-comment-li-' + comment_id).show();
    
    $(".new-comment-"+post_id).hide();
}

function cancelPostComment(comment_id, post_id) {        
    $('#edit-comment-' + comment_id).hide();        
    $('#comment-dis-inner-' + comment_id).show();
    $('#edit-comment-li-' + comment_id).show();
    $('#cancel-comment-li-' + comment_id).hide();
    $(".new-comment-"+post_id).show();
}

function sendEditComment(comment_id,post_id) {
    var comment = $('#editCommentTaxBox-' + comment_id).html();
    comment = comment.replace(/&nbsp;/gi, " ");
    comment = comment.replace(/<br>$/, '');
    comment = comment.replace(/&gt;/gi, ">");
    comment = comment.replace(/&/g, "%26");
    if (comment) {

        $.ajax({
            url: base_url + 'user_post/postCommentUpdate',
            type: "POST",
            data: {"comment_id": comment_id,"comment":comment},
            dataType: 'json',
            success: function (success) {
                if (success.message == '1') {
                    $('#comment-dis-inner-' + comment_id).show();
                    $('#comment-dis-inner-' + comment_id).html(comment);
                    $('#edit-comment-' + comment_id).html();
                    $('#edit-comment-' + comment_id).hide();
                    $('#edit-comment-li-' + comment_id).show();
                    $('#cancel-comment-li-' + comment_id).hide();
                    $('.new-comment-'+post_id).show();
                }
            }
        });
    }
}
var is_loading = false;
var offset = 2;
function load_more_comment(post_id)
{
    if(is_loading)
    {
        return;
    }
    $("#cmt_loader").show();
    is_loading = true;
    $.ajax({
        url: base_url + 'article/load_more_comment',
        type: "POST",
        data: {"post_id": post_id,"offset":offset},
        dataType: 'html',
        success: function (result) {            
            $("#cmt_loader").hide();
            if(result.trim() != "")
            {
                $(".art-comment").append(result);
                offset = offset + 1;
                is_loading = false;
            }
            else
            {
                is_loading = true;
            }
        }
    });
}

function sendComment(post_id) {
    // var commentClassName = $('#comment-icon-' + post_id).attr('class').split(' ')[0];
    var comment = $('#commentTaxBox-' + post_id).html();
    //comment = comment.replace(/^(<br\s*\/?>)+/, '');
    comment = comment.replace(/&nbsp;/gi, " ");
    comment = comment.replace(/<br>$/, '');
    comment = comment.replace(/&gt;/gi, ">");
    comment = comment.replace(/&/g, "%26");
    if (comment) {
    $("#send_comment").attr("style","pointer-events:none;");

        $.ajax({
            url: base_url + 'article/postCommentInsert',
            type: "POST",
            data: {"post_id": post_id,"comment":comment},
            dataType: 'json',
            success: function (result) {
                $("#send_comment").removeAttr("style");
                if (result.message == '1') {
                    $('#commentTaxBox-' + post_id).html('');
                    comment_data = result.comment_data[0];

                    if(comment_data.user_image != "")
                    {
                        img_url = user_thumb_upload_url+comment_data.user_image;
                    }
                    else
                    {
                        if(comment_data.user_gender == "M")
                        {
                            img_url = base_url+'assets/img/man-user.jpg';
                        }
                        else if(comment_data.user_gender == "F")
                        {
                            img_url = base_url+'assets/img/female-user.jpg';
                        }
                        else
                        {
                            img_url = base_url+'assets/img/man-user.jpg';
                        }

                    }

                    content = '<div id="comment-'+comment_data.comment_id+'" class="post-comment">';
                        content += '<div class="post-img"><img src="'+img_url+'"></div>';
                        content += '<div class="comment-dis">';
                            content += '<div class="comment-name">';
                                content += '<a href="'+base_url+comment_data.user_slug+'">'+comment_data.username+'</a>';
                            content += '</div>';
                            content += '<div id="comment-dis-inner-'+comment_data.comment_id+'" class="comment-dis-inner">';
                                content += comment_data.comment;
                            content += '</div>';
                            //Edit Comment Start
                            content += '<div class="edit-comment" id="edit-comment-'+comment_data.comment_id+'" style="display:none;">';
                                content += '<div class="comment-input">';
                                    content += '<div contenteditable="true" data-directive ng-model="editComment" class="editable_text" placeholder="Add a Comment ..." id="editCommentTaxBox-'+comment_data.comment_id+'" focus="setFocus" focus-me="setFocus" role="textbox" spellcheck="true">'+comment_data.comment+'</div>';
                                content += '</div>';
                                content += '<div class="mob-comment">';
                                    content += '<button onclick="sendEditComment('+comment_data.comment_id+', '+post_id+')"><img src="'+base_url+'assets/n-images/send.png'+'"></button>';
                                content += '</div>';
                                
                                content += '<div class="comment-submit hidden-mob">';
                                    content += '<button class="btn2" onclick="sendEditComment('+comment_data.comment_id+', '+post_id+')">Save</button>';
                                content += '</div>';
                            content += '</div>';
                            // Edit Comment End
                            content += '<ul class="comment-action">';
                                content += '<li>';
                                    
                                    cmt_like_cls = "";
                                    if(comment_data.is_userlikePostComment == 1)
                                    {
                                        cmt_like_cls = "like";
                                    }
                                    content += '<a href="javascript:void(0);" class="<?php echo $cmt_like_cls; ?>" onclick="likePostComment('+comment_data.comment_id+', '+post_id+')">';
                                        content += '<i class="fa fa-thumbs-up"></i>';
                                        content += '<span id="post-comment-like-'+comment_data.comment_id+'">'+comment_data.postCommentLikeCount > 0 ? comment_data.postCommentLikeCount : "" +'</span>';
                                    content += '</a>';
                                content += '</li>';
                                
                                if(comment_data.commented_user_id == user_id){
                                content += '<li id="edit-comment-li-'+comment_data.comment_id+'">';
                                    content += '<a href="javascript:void(0);" onclick="editPostComment('+comment_data.comment_id+', '+post_id+')">Edit</a>';
                                content += '</li>';
                                content += '<li id="cancel-comment-li-'+comment_data.comment_id+'" style="display: none;"><a href="javascript:void(0);" onclick="cancelPostComment('+comment_data.comment_id+', '+post_id+')">Cancel</a>';
                                content += '</li>';                                    
                                }
                                
                                content += '<li><a href="javascript:void(0);" onclick="deletePostComment('+comment_data.comment_id+', '+post_id+')">Delete</a></li>';
                                
                                content += '<li><a href="javascript:void(0);">'+comment_data.comment_time_string+'</a></li>';
                            content += '</ul>';
                        content += '</div>';
                    content += '</div>';
                    $(".art-comment").prepend(content);
                }                    
            }
        });
    }
}

function contact(id, status, to_id, confirm = 0) {
    // alert(status);
    // return false;
    if(confirm == '1')
    {
        $("#remove-contact-conform").modal("show");
        return false;
    }
    $("#contact-btn").attr("style","pointer-events:none");
    $.ajax({
        url: base_url + 'userprofile_page/addcontact',
        type: "POST",
        data: {"contact_id": id,"status":status,"to_id":to_id},
        dataType: 'text',
        success: function (result) {            
            $("#contact-btn").removeAttr("style");
            if(result.trim() == 'pending')
            {
                $("#contact-btn").attr("onclick","contact("+id+", 'cancel', "+to_id+")");
                $("#contact-btn").html("Request sent");
            }
            if(result.trim() == 'cancel')
            {
                $("#contact-btn").attr("onclick","contact("+id+", 'pending', "+to_id+")");
                $("#contact-btn").html("Add to contact");
            }
        },
        error: function (jqXHR, status, err) {
            console.error(err);
            $("#contact-btn").removeAttr("style");
        },
    });
}

function remove_contact(id, status, to_id) {
    $("#contact-btn").attr("style","pointer-events:none");
    $.ajax({
        url: base_url + 'userprofile_page/addcontact',
        type: "POST",
        data: {"contact_id": id,"status":status,"to_id":to_id},
        dataType: 'text',
        success: function (result) {
            $("#contact-btn").removeAttr("style");
            $("#contact-btn").attr("onclick","contact("+id+",'pending',"+to_id+")");
            $("#contact-btn").html("Add to contact");
            
        },
        error: function (jqXHR, status, err) {
            console.error(err);
            $("#contact-btn").removeAttr("style");
        },
    });
}

function confirmContactRequestInnerHeader(from_id,to_id) {
    $("#contact-btn").attr("style","pointer-events:none");
    $.ajax({
        url: base_url + 'userprofile/contactRequestAction',
        type: "POST",
        data: {"from_id": from_id,"action":'confirm'},
        dataType: 'json',
        success: function (result) {
            $("#contact-btn").removeAttr("style");            
            $("#contact-btn").attr("onclick","contact("+from_id+",'cancel',"+to_id+",1)");
            $("#contact-btn").html("In Contacts");            
        },
        error: function (jqXHR, status, err) {
            console.error(err);
            $("#contact-btn").removeAttr("style");
        },
    });
    $http({
        method: 'POST',
        url: base_url + 'userprofile/contactRequestAction',
        data: 'from_id=' + from_id + '&action=confirm',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function (success) {
        $scope.contact_value = 'confirm';
    });
}
function follow(id, status, to_id) {    
    $("#follow-btn").attr("style","pointer-events:none");
    $.ajax({
        url: base_url + 'userprofile_page/addfollow',
        type: "POST",
        data: {"follow_id": id,"status":status,"to_id":to_id},
        dataType: 'json',
        success: function (result) {
            $("#follow-btn").removeAttr("style");
            if(result == '1')
            {
                $("#follow-btn").attr("onclick","follow("+id+", 0, "+to_id+")");
                $("#follow-btn").html("Following");
            }
            if(result == '0')
            {
                $("#follow-btn").attr("onclick","follow("+id+", 1, "+to_id+")");
                $("#follow-btn").html("Follow");
            }
        },
        error: function (jqXHR, status, err) {
            console.error(err);
            $("#follow-btn").removeAttr("style");
        },
    });    
}
$(document).ready(function(){
    
    $(window).scroll(function() {
        var scroll_height = $(window).scrollTop();
        var window_height = $(window).innerHeight();        
        var mce_tool_scroll = $('.like-other-box').offset().top;        
        if(Math.abs(window_height + scroll_height) >= parseInt(mce_tool_scroll))
        {
            $('.right-part').addClass('reach-to-allcomment');
        }
        else
        {
            $('.right-part').removeClass('reach-to-allcomment');   
        }

    });
});