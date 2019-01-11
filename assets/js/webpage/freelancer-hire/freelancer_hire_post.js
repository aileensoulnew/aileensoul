//CODE FOR ALL POPUP CLOSE USING ESC START
$(document).on('keydown', function (e) {
    if (e.keyCode === 27) {
        $('#bidmodal').modal('hide');
    }
});
$(document).on('keydown', function (e) {
    if (e.keyCode === 27) {
        $('#bidmodal-2').modal('hide');
    }
});

//CODE FOR ALL POPUP CLOSE USING ESC END

//CODE FOR RESPONES OF AJAX COME FROM CONTROLLER AND LAZY LOADER START
$(document).ready(function () {
    freelancerhire_project(user_id, returnpage);
    $(window).scroll(function () {
        //if ($(window).scrollTop() == $(document).height() - $(window).height()) {
       // if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
        if ($(window).scrollTop() >= ($(document).height() - $(window).height())*0.7){
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
                    freelancerhire_project(user_id, returnpage, pagenum);
                }
            }
        }
    });

});
var isProcessing = false;
function freelancerhire_project(user_id, returnpage, pagenum)
{
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
        url: base_url + "freelancer_hire_live/ajax_freelancer_hire_post/" + user_id + '/' + returnpage + '?page=' + pagenum,
        data: {total_record: $("#total_record").val()},
        dataType: "html",
        beforeSend: function () {
            if (pagenum == 'undefined') {
                $(".job-contact-frnd1").prepend('<p style="text-align:center;"><img class="loader" src="' + base_url + 'images/loading.gif"/></p>');
            } else {
                $('#loader').show();
            }
        },
        complete: function () {
            $('#loader').hide();
        },
        success: function (data) {
            $('.loader').remove();
            $('.job-contact-frnd1').append(data);
            // second header class add for scroll
            var nb = $('.post-design-box').length;
            if (nb == 0) {
                $("#dropdownclass").addClass("no-post-h2");
            } else {
                $("#dropdownclass").removeClass("no-post-h2");
            }
            isProcessing = false;
            $('#main_loader').hide();
            // $('#main_page_load').show();
            $('body').removeClass("body-loader");
        }
    });
}

//CODE FOR RESPONES OF AJAX COME FROM CONTROLLER AND LAZY LOADER END

//  //CODE FOR DESIGNATION START
function divClicked() {
    // alert(456);
    var divHtml = $(this).html();
    var editableText = $("<textarea />");
    editableText.val(divHtml);
    $(this).replaceWith(editableText);
    editableText.focus();
    editableText.blur(editableTextBlurred);
}

function editableTextBlurred() {
    //alert(789);
    var html = $(this).val();
    var viewableText = $("<a>");
    if (html.match(/^\s*$/) || html == '') {
        html = "Current Work";
    }
    viewableText.html(html);
    $(this).replaceWith(viewableText);
    viewableText.click(divClicked);
    $.ajax({
        url: base_url + "freelancer/hire_designation",
        type: "POST",
        data: {"designation": html},
        success: function (response) {

        }
    });
}
$(document).ready(function () {
    // alert(123);
    $("a.designation").click(divClicked);
});
//CODE FOR DESIGNATION END

//FUNCTION FOR CHECK VALUE OF SEARCH KEYWORD AND LOCATION BLANK STRAT
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
//FUNCTION FOR CHECK VALUE OF SEARCH KEYWORD AND LOCATION BLANK END

//CODE FOR SAVE POST START
function savepopup(id) {
    save_post(id);
    $('.biderror .mes').html("<div class='pop_content'>Your project is successfully saved.");
    $('#bidmodal').modal('show');
}
function save_post(abc)
{
    $.ajax({
        type: 'POST',
        url: base_url + "freelancer/save_user",
        data: 'post_id=' + abc,
        success: function (data) {
            $('.' + 'savedpost' + abc).html(data).addClass('saved');
        }
    });
}
//CODE FOR SAVE POST END
//CODE FOR REMOVE POST START
function removepopup(id) {
    $('.biderror .mes').html("<div class='pop_content'>Do you want to remove this project?<div class='model_ok_cancel'><a class='okbtn' id=" + id + " onClick='remove_post(" + id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
    $('#bidmodal').modal('show');
}
function remove_post(abc)
{
    $.ajax({
        type: 'POST',
        url: base_url + "freelancer_hire_live/remove_post",
        data: 'post_id=' + abc,
        success: function (data) {
            $('#' + 'removeapply' + abc).html(data);
            $('#' + 'removeapply' + abc).parent().removeClass();
            var numItems = $('.contact-frnd-post .job-contact-frnd').length;
            if (numItems == '0') {
                var nodataHtml = '<div class="art-img-nn"><div class="art_no_post_img"><img src="../img/free-no1.png"></div><div class="art_no_post_text">No Project Found</div></div>';
                $('.contact-frnd-post').html(nodataHtml);
            }
        }
    });

}
//CODE FOR REMOVE POST END
//CODE FOR APPLY POST START
function applypopup(postid, userid) {
    $('.biderror .mes').html("<div class='pop_content'>Are you sure you want to apply this project?<div class='model_ok_cancel'><a class='okbtn' id=" + postid + " onClick='apply_post(" + postid + "," + userid + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
    $('#bidmodal').modal('show');
}
function apply_post(abc, xyz) {
    var alldata = 'all';
    var user = xyz;
    $.ajax({
        type: 'POST',
        url: base_url + "freelancer/apply_insert",
        data: 'post_id=' + abc + '&allpost=' + alldata + '&userid=' + user,
        dataType: "JSON",
        success: function (data) {
            $('.savedpost' + abc).hide();
            $('.applypost' + abc).html(data.status);
            $('.applypost' + abc).attr('disabled', 'disabled');
            $('.applypost' + abc).attr('onclick', 'myFunction()');
            $('.applypost' + abc).addClass('applied');
        }
    });
}
//CODE FOR APPLY POST END
//CODE FOR PROFILE PIC AND COVER PIC VALIDATION START
function picpopup() {
    $('.biderror .mes').html("<div class='pop_content'>Please select only Image type File.(jpeg,jpg,png,gif)");
    $('#bidmodal').modal('show');
}
//CODE FOR PROFILE PIC AND COVER PIC VALIDATION END

//CODE FOR SCROLL PAGE AT PERTICULAR START
$(document).ready(function () {
    $('html,body').animate({scrollTop: 265}, 100);
});
//CODE FOR SCROLL PAGE AT PERTICULAR END
get_fh_progress();
function get_fh_progress() {
    $.ajax({
        type: 'POST',
        url: base_url +'freelancer_hire_live/get_fh_progress',
        data: '',
        dataType: "JSON",
        success: function (data) {            
            // data = JSON.parse(data);
            var profile_progress = data.profile_progress;
            count_profile_value = profile_progress.user_process_value;
            count_profile = profile_progress.user_process;            
            set_progress(count_profile_value,count_profile);
            
        }
    });
}

function set_progress(count_profile_value,count_profile)
{
    if(count_profile == 100)
    {
        $("#profile-progress").show();
        $("#progress-txt").html("Hurray! Your profile is complete.");
        setTimeout(function(){
            $("#profile-progress").hide();
            $(".mob-progressbar").hide();
        },5000);
    }
    else
    {
        $("#edit-profile-move").show();
        $("#profile-progress").show();
        $("#progress-txt").html("<a href='"+base_url+'freelance-employer/'+fh_slug+"'>Complete your profile to get connected with more people</a>.");   
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