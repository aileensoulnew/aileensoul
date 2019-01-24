//AJAX DATA LOAD BY LAZZY LOADER START
$(document).ready(function() {
    rec_post();
    $(window).scroll(function() {
        if ($(window).scrollTop() >= ($(document).height() - $(window).height()) * 0.7) {
            var page = $(".page_number:last").val();
            var total_record = $(".total_record").val();
            var perpage_record = $(".perpage_record").val();
            if (parseInt(perpage_record) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                //if ($(".page_number:last").val() <= $(".total_record").val()) {
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum = parseInt($(".page_number:last").val()) + 1;
                    rec_post(pagenum);
                }
            }
        }
    });
});
var isProcessing = false;

function rec_post(pagenum) {
    if (isProcessing) {
        /*
         *This won't go past this condition while
         *isProcessing is true.
         *You could even display a message.
         **/
        return;
    }
    isProcessing = true;
    $.ajax({
        type: 'POST',
        url: base_url + "recruiter/ajax_rec_post?page=" + pagenum + "&id=" + id + "&returnpage=" + return_page,
        data: {
            total_record: $("#total_record").val()
        },
        dataType: "html",
        beforeSend: function() {
            if (pagenum == 'undefined') {
                $(".job-contact-frnd").prepend('<p style="text-align:center;"><img class="loader" src="' + base_url + 'images/loading.gif"/></p>');
            } else {
                $('#loader').show();
            }
        },
        complete: function() {
            $('#loader').hide();
        },
        success: function(data) {
            $('.loader').remove();
            var res = JSON.parse(data);
            $('.job-contact-frnd').append(res.postdata);
            // second header class add for scroll
            var nb = $('.post-design-box').length;
            if (nb == 0) {
                $("#dropdownclass").addClass("no-post-h2");
            } else {
                $("#dropdownclass").removeClass("no-post-h2");
            }
            isProcessing = false;
        }
    });
}
//AJAX DATA LOAD BY LAZZY LOADER END
function removepopup(id) {
    $('.biderror .mes').html("<div class='pop_content'>Do you want to remove this post?<div class='model_ok_cancel'><a class='okbtn' id=" + id + " onclick='remove_post(" + id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
    $('#bidmodal').modal('show').fadeIn();
}

function checkvalue() {
    var searchkeyword = $.trim(document.getElementById('tags').value);
    var searchplace = $.trim(document.getElementById('searchplace').value);
    if (searchkeyword == "" && searchplace == "") {
        return false;
    }
}

function check() {
    var keyword = $.trim(document.getElementById('tags1').value);
    var place = $.trim(document.getElementById('searchplace1').value);
    if (keyword == "" && place == "") {
        return false;
    }
}
// cover image start
function myFunction() {
    document.getElementById("upload-demo").style.visibility = "hidden";
    document.getElementById("upload-demo-i").style.visibility = "hidden";
    document.getElementById('message1').style.display = "block";
}

function showDiv() {
    document.getElementById('row1').style.display = "block";
    document.getElementById('row2').style.display = "none";
    $(".cr-image").attr("src", "");
    $("#upload").val('');
}
$uploadCrop = $('#upload-demo').croppie({
    enableExif: true,
    viewport: {
        width: 1250,
        height: 350,
        type: 'square'
    },
    boundary: {
        width: 1250,
        height: 350
    }
});
$('.upload-result').on('click', function(ev) {
    $uploadCrop.croppie('result', {
        type: 'canvas',
        size: 'viewport'
    }).then(function(resp) {
        $.ajax({
            url: base_url + "recruiter/ajaxpro",
            type: "POST",
            data: {
                "image": resp
            },
            success: function(data) {
                if (data) {
                    $("#row2").html(data);
                    document.getElementById('row2').style.display = "block";
                    document.getElementById('row1').style.display = "none";
                    document.getElementById('message1').style.display = "none";
                    document.getElementById("upload-demo").style.visibility = "visible";
                    document.getElementById("upload-demo-i").style.visibility = "visible";
                }
            }
        });
    });
});
$('.cancel-result').on('click', function(ev) {
    document.getElementById('row2').style.display = "block";
    document.getElementById('row1').style.display = "none";
    document.getElementById('message1').style.display = "none";
    $(".cr-image").attr("src", "");
});
//aarati code start
$('#upload').on('change', function() {
    var reader = new FileReader();
    reader.onload = function(e) {
        $uploadCrop.croppie('bind', {
            url: e.target.result
        }).then(function() {
            console.log('jQuery bind complete');
        });
    }
    reader.readAsDataURL(this.files[0]);
});
$('#upload').on('change', function() {
    var fd = new FormData();
    fd.append("image", $("#upload")[0].files[0]);
    files = this.files;
    size = files[0].size;
    // pallavi code start for file type support
    if (!files[0].name.match(/.(jpg|jpeg|png|gif)$/i)) {
        picpopup();
        document.getElementById('row1').style.display = "none";
        document.getElementById('row2').style.display = "block";
        return false;
    }
    // file type code end
    if (size > 26214400) {
        //show an alert to the user
        alert("Allowed file size exceeded. (Max. 25 MB)")
        document.getElementById('row1').style.display = "none";
        document.getElementById('row2').style.display = "block";
        return false;
    }
    $.ajax({
        url: base_url + "recruiter/image",
        type: "POST",
        data: fd,
        processData: false,
        contentType: false,
        success: function(response) {}
    });
});
//aarati code end
//cover image end 
//remove post start
function remove_post(abc) {
    $.ajax({
        type: 'POST',
        url: base_url + 'recruiter/remove_post',
        data: 'post_id=' + abc,
        success: function(data) {
            // $('#' + 'removepost' + abc).html(data);
            $('#' + 'removepost' + abc).remove();
            $('#' + 'removepost' + abc).removeClass();
            var numItems = $('.contact-frnd-post .job-contact-frnd .profile-job-post-detail').length;
            if (numItems == '0') {
                var nodataHtml = "<div class='art-img-nn'><div class='art_no_post_img'><img src='" + base_url + "img/job-no.png'/></div><div class='art_no_post_text'> No Post Available.</div></div>";
                $('.contact-frnd-post').html(nodataHtml);
            }
        }
    });
}

function divClicked() {
    var divHtml = $(this).html();
    var editableText = $("<textarea/>");
    editableText.val(divHtml);
    $(this).replaceWith(editableText);
    editableText.focus();
    // setup the blur event for this new textarea
    editableText.blur(editableTextBlurred);
}

function editableTextBlurred() {
    var html = $(this).val();
    var viewableText = $("<a>");
    if (html.match(/^\s*$/) || html == '') {
        html = "Designation";
    }
    viewableText.html(html);
    $(this).replaceWith(viewableText);
    // setup the click event for this new div
    viewableText.click(divClicked);
    $.ajax({
        url: base_url + "recruiter/ajax_designation",
        type: "POST",
        data: {
            "designation": html
        },
        success: function(response) {}
    });
}
$(document).ready(function() {
    $("a.designation").click(divClicked);
});

function save_post(abc) {
    $.ajax({
        type: 'POST',
        url: base_url + 'job/job_save',
        data: 'post_id=' + abc,
        success: function(data) {
            $('.' + 'savedpost' + abc).html(data).addClass('saved');
        }
    });
}
//save post end 
//apply post start
function apply_post(abc, xyz) {
    var alldata = 'all';
    var user = xyz;
    $('.applypost' + abc).attr("style","pointer-events:none;");
    $.ajax({
        type: 'POST',
        url: base_url + 'job/job_apply_post',
        data: 'post_id=' + abc + '&allpost=' + alldata + '&userid=' + user,
        dataType: 'json',
        success: function(data) {
            clearTimeout(int_not_count);            
            get_notification_unread_count();
            int_not_count = setTimeout(function(){
              get_notification_unread_count();
            }, 10000);
            $('.applypost' + abc).removeAttr("style");
            $('.savedpost' + abc).hide();
            $('.applypost' + abc).html("Applied");//(data.status);
            $('.applypost' + abc).attr('disabled', 'disabled');
            $('.applypost' + abc).attr('onclick', 'myFunction()');
            $('.applypost' + abc).addClass('applied');
        }
    });
}

function savepopup(id) {
    save_post(id);
    $('.biderror .mes').html("<div class='pop_content'>Your post is successfully saved.");
    $('#bidmodal').modal('show');
}

function applypopup(postid, userid) {    
    $('.biderror .mes').html("<div class='pop_content'>Are you sure want to apply this post?<div class='model_ok_cancel'><a class='okbtn' id=" + postid + " onclick='apply_post(" + postid + "," + userid + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
    $('#bidmodal').modal('show');
}
//script for profile pic strat    
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').style.display = 'block';
            $('#preview').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#profilepic").change(function() {
    // pallavi code for not supported file type 10/06/2017
    profile = this.files;
    //alert(profile);
    if (!profile[0].name.match(/.(jpg|jpeg|png|gif)$/i)) {
        //alert('not an image');
        $('#profilepic').val('');
        picpopup();
        return false;
    } else {
        readURL(this);
    }
    // end supported code 
});
//script for profile pic end 
//validation for edit email formate form
//
//            $(document).ready(function () { 
//
//                $("#userimage").validate({
//
//                    rules: {
//
//                        profilepic: {
//
//                            required: true,
//                         
//                        },
//  
//
//                    },
//
//                    messages: {
//
//                        profilepic: {
//
//                            required: "Photo Required",
//                            
//                        },
//
//                },
//                submitHandler: profile_pic
//                });
//                   });
function picpopup() {
    $('.biderror .mes').html("<div class='pop_content'>Only Image Type Supported");
    $('#bidmodal').modal('show');
}
//all popup close close using esc start
$(document).on('keydown', function(e) {
    if (e.keyCode === 27) {
        //$( "#bidmodal" ).hide();
        $('#bidmodal').modal('hide');
    }
});
$(document).on('keydown', function(e) {
    if (e.keyCode === 27) {
        //$( "#bidmodal" ).hide();
        $('#bidmodal-2').modal('hide');
    }
});
//all popup close close using esc end 
//For Scroll page at perticular position js Start
$(document).ready(function() {
    $('html,body').animate({
        scrollTop: 265
    }, 100);
});
//For Scroll page at perticular position js End
//UPLOAD PROFILE PIC START
//function profile_pic() {
//    if (typeof FormData !== 'undefined') {
//        
//        var formData = new FormData($("#userimage")[0]);
//        $.ajax({
//          
//            url: base_url + "recruiter/user_image_insert",
//            type: "POST",
//            data: formData,
//            contentType: false,
//            cache: false,
//            processData: false,
//            success: function (data)
//            {
//                $('#bidmodal-2').modal('hide');
//                $(".user-pic").html(data);
//                document.getElementById('profilepic').value = null;
//                $('#preview').prop('src', '#');
//                 $('#preview').hide();
//                $('.popup_previred').hide();
//            },
//        });
//        return false;
//    }
//}
//UPLOAD PROFILE PIC END
//CODE FOR PROFILE PIC UPLOAD WITH CROP START
$uploadCrop1 = $('#upload-demo-one').croppie({
    enableExif: true,
    viewport: {
        width: 200,
        height: 200,
        type: 'square'
    },
    boundary: {
        width: 300,
        height: 300
    }
});
$('#upload-one').on('change', function() {
    document.getElementById('upload-demo-one').style.display = 'block';
    var reader = new FileReader();
    reader.onload = function(e) {
        $uploadCrop1.croppie('bind', {
            url: e.target.result
        }).then(function() {
            console.log('jQuery bind complete');
        });
    }
    reader.readAsDataURL(this.files[0]);
});
$(document).ready(function() {
    $("#userimage").validate({
        rules: {
            profilepic: {
                required: true,
            },
        },
        messages: {
            profilepic: {
                required: "Photo Required",
            },
        },
        submitHandler: profile_pic
    });

    function profile_pic() {
        //    $('.upload-result-one').on('click', function (ev) {
        $uploadCrop1.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function(resp) {
            $.ajax({
                //url: "/ajaxpro.php", user_image_insert
                // url: "<?php echo base_url(); ?>freelancer/ajaxpro_test",
                url: base_url + "recruiter/user_image_insert1",
                type: "POST",
                data: {
                    "image": resp
                },
                beforeSend: function() {
                    $('#profi_loader').show();
                    // document.getElementById('profi_loader').style.display = 'block';
                },
                complete: function() {
                    //    $document.getElementById('profi_loader').style.display = 'none';
                },
                success: function(data) {
                    $('#profi_loader').hide();
                    $('#bidmodal-2').modal('hide');
                    $(".user-pic").html(data);
                    document.getElementById('upload-one').value = null;
                    document.getElementById('upload-demo-one').value = '';
                    //                    html = '<img src="' + resp + '" />';
                    //                    $("#upload-demo-i").html(html);
                }
            });
        });
        //    });
    }
});

function upload_company_logo(id) {
    $('#bidmodal-com-logo').show();
}
$("#comlogo").on('submit', (function(e) {
    var fd = new FormData();
    fd.append("image", $("#upload-complogo")[0].files[0]);
    files = this.files;
    //  fd.append('portfolio', portfolio);
    //  fd.append('image_hidden_portfolio', image_hidden_portfolio);
    e.preventDefault();
    $.ajax({
        url: base_url + "recruiter/company_logo",
        type: "POST",
        data: new FormData(this),
        beforeSend: function() {
            $(".modal-content").prepend('<p style="text-align:center;"><img class="loader" src="' + base_url + 'assets/images/loading.gif"/></p>');
        },
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
            $('.loader').remove();
            $(".post-img").html(data);
            $('#bidmodal-com-logo').hide();
            document.getElementById("upload-complogo").value = '';
            // $('upload-complogo').value('');
            //  $(".user-pic").html(data);
        },
        error: function() {}
    });
}));
$('.modal-close').on('click', function() {
    $('#bidmodal-com-logo').hide();
    document.getElementById("upload-complogo").value = '';
});

get_recruiter_progress();

function get_recruiter_progress() {
    $.ajax({
        type: 'POST',
        url: base_url + 'recruiter/get_recruiter_progress',
        data: '',
        dataType: "JSON",
        success: function(data) {
            // data = JSON.parse(data);
            var profile_progress = data.profile_progress;
            count_profile_value = profile_progress.user_process_value;
            count_profile = profile_progress.user_process;
            set_progress(count_profile_value, count_profile);
        }
    });
}

function set_progress(count_profile_value, count_profile) {
    if (count_profile == 100) {
        $("#profile-progress").show();
        $("#progress-txt").html("Hurray! Your profile is complete.");
        setTimeout(function() {
            $("#profile-progress").hide();
            $(".progress-bar-custom").hide();
        }, 5000);
    } else {
        $("#edit-profile-move").show();
        $("#profile-progress").show();
        $("#progress-txt").html("<a href='" + base_url + 'recruiter/profile/' + login_user_id + "'>Complete your profile to get connected with more people</a>.");
    }
    // if($scope.old_count_profile < 100)
    {
        $('.second.circle-1').circleProgress({
            value: count_profile_value //with decimal point
        }).on('circle-animation-progress', function(event, progress) {
            $('.progress-bar-custom').width(Math.round(count_profile * progress)+'%');
            $('.progress-bar-custom span .val').html(Math.round(count_profile * progress)+'%');
            $(this).find('strong').html(Math.round(count_profile * progress) + '<i>%</i>');
        });
    }
}