//SCRIPT FOR AUTOFILL OF SEARCH KEYWORD START

    $(function() {
        function split( val ) {
            return val.split( /,\s*/ );
        }
        function extractLast( term ) { 
            return split( term ).pop();
        }
        $( ".skill_keyword" ).bind( "keydown", function( event ) {
            if ( event.keyCode === $.ui.keyCode.TAB &&
                $( this ).autocomplete( "instance" ).menu.active ) {
                event.preventDefault();
            }
        })
        .autocomplete({
            minLength: 2,
            source: function( request, response ) { 
                // delegate back to autocomplete, but extract the last term
                $.getJSON(base_url + "freelancer/freelancer_apply_search_keyword", { term : extractLast( request.term )},response);
            },
            focus: function() {
                // prevent value inserted on focus
                return false;
            },
            select: function( event, ui ) {
               
                var terms = split( this.value );
                if(terms.length <= 1) {
                    // remove the current input
                    terms.pop();
                    // add the selected item
                    terms.push( ui.item.value );
                    // add placeholder to get the comma-and-space at the end
                    terms.push( "" );
                    this.value = terms.join( "" );
                    return false;
                }else{
                    var last = terms.pop();
                    $(this).val(this.value.substr(0, this.value.length - last.length - 2)); // removes text from input
                    $(this).effect("highlight", {}, 1000);
                    $(this).attr("style","border: solid 1px red;");
                    return false;
                }
            }
        });
    });

//SCRIPT FOR AUTOFILL OF SEARCH KEYWORD END


//SCRIPT FOR CITY AUTOFILL OF SEARCH START

    $(function() {
        function split( val ) {
            return val.split( /,\s*/ );
        }
        function extractLast( term ) { 
            return split( term ).pop();
        }
        $( ".skill_place" ).bind( "keydown", function( event ) {
            if ( event.keyCode === $.ui.keyCode.TAB &&
                $( this ).autocomplete( "instance" ).menu.active ) {
                event.preventDefault();
            }
        })
        .autocomplete({
            minLength: 2,
            source: function( request, response ) { 
                // delegate back to autocomplete, but extract the last term
                $.getJSON(base_url + "freelancer/freelancer_search_city", { term : extractLast( request.term )},response);
            },
            focus: function() {
                // prevent value inserted on focus
                return false;
            },
            select: function( event, ui ) {
               
                var terms = split( this.value );
                if(terms.length <= 1) {
                    // remove the current input
                    terms.pop();
                    // add the selected item
                    terms.push( ui.item.value );
                    // add placeholder to get the comma-and-space at the end
                    terms.push( "" );
                    this.value = terms.join( "" );
                    return false;
                }else{
                    var last = terms.pop();
                    $(this).val(this.value.substr(0, this.value.length - last.length - 2)); // removes text from input
                    $(this).effect("highlight", {}, 1000);
                    $(this).attr("style","border: solid 1px red;");
                    return false;
                }
            }
        });
    });

//SCRIPT FOR CITY AUTOFILL OF SEARCH END

//UPLOAD PROFILE PIC START
function updateprofilepopup(id) {
    $('#profi_loader').hide();
    document.getElementById('upload-one').value = null;
    document.getElementById('upload-demo-one').style.display = 'none';
    $('#bidmodal-2').modal('show');
}
//UPLOAD PROFILE PIC END
//CODE FOR PROFILE PIC UPLOAD WITH CROP START
$uploadCrop1 = $('#upload-demo-one').croppie({
    enableExif: true,
    viewport: {
        width: 157,
        height: 157,
        type: 'square'
    },
    boundary: {
        width: 257,
        height: 257
    }
});

$('#upload-one').on('change', function () {
document.getElementById('upload-demo-one').style.display = 'block';
    var reader = new FileReader();
    reader.onload = function (e) {
        $uploadCrop1.croppie('bind', {
            url: e.target.result
        }).then(function () {
            console.log('jQuery bind complete');
        });

    }
    reader.readAsDataURL(this.files[0]);
});
// $(function () {
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
        // $('.upload-result-one').on('click', function (ev) {
        $uploadCrop1.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (resp) {
            $.ajax({
                //url: "/ajaxpro.php", user_image_insert
                // url: "<?php echo base_url(); ?>freelancer/ajaxpro_test",
                url: base_url + "freelancer/user_image_add1",
                type: "POST",
                data: {"image": resp},
                 beforeSend: function () {
                    // $('.loader').show();
                    $('#profi_loader').show();
                },
                complete: function () {
                    $document.getElementById('loader').style.display = 'none';
                },
                success: function (data) {
                    $('#profi_loader').hide();
                    $('#bidmodal-2').modal('hide');
                    $(".user-pic").html(data);
                    document.getElementById('upload-one').value = null;
                    document.getElementById('upload-one').value = null;
                    document.getElementById('upload-demo-one').style.display = 'none';
                    $('.cr-image').attr('src', '#');
                   // html = '<img src="' + resp + '" />';
                   // $("#upload-demo-i").html(html);
                }
            });
        });
        // });
    }
// });
//CODE FOR PROFILE PIC UPLOAD WITH CROP END

//COVER IMAGE CODE START
function showDiv() {
    document.getElementById('row1').style.display = "block";
    document.getElementById('row2').style.display = "none";
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
$('.upload-result').off('click').on('click', function (ev) {
  
    
//$('.upload-result').on('click', function (ev) {
    document.getElementById("upload-demo").style.visibility = "hidden";
    document.getElementById("upload-demo-i").style.visibility = "hidden";
    document.getElementById('message1').style.display = "block";
    $uploadCrop.croppie('result', {
        type: 'canvas',
        size: 'viewport'
    }).then(function (resp) {
        //WHEN USER NOT SELECT IMAGE AND UPLOAD THEN GO TO IF CONDITION OTHER WISE ELSE
        var aa = resp.length;
        if(aa == 11350) {
                document.getElementById('row2').style.display = "block";
                    document.getElementById('row1').style.display = "none";
                    document.getElementById('message1').style.display = "none";
                    document.getElementById("upload-demo").style.visibility = "visible";
                    document.getElementById("upload-demo-i").style.visibility = "visible";
            return false;
        }else{
        $.ajax({
            url: base_url + "freelancer/ajaxpro_work",
            type: "POST",
            data: {"image": resp},
            success: function (data) {
                $("#row2").html(data);
                document.getElementById('row2').style.display = "block";
                document.getElementById('row1').style.display = "none";
                document.getElementById('message1').style.display = "none";
                document.getElementById("upload-demo").style.visibility = "visible";
                document.getElementById("upload-demo-i").style.visibility = "visible";
            }
        });
    }
    });
});
$('.cancel-result').on('click', function (ev) {
   
    document.getElementById('row2').style.display = "block";
    document.getElementById('row1').style.display = "none";
    document.getElementById('message1').style.display = "none";
    $(".cr-image").attr("src", "");
});
$('#upload').on('change', function () {
   
    var reader = new FileReader();
    reader.onload = function (e) {
        $uploadCrop.croppie('bind', {
            url: e.target.result
        }).then(function () {
            console.log('jQuery bind complete');
        });
    }
    reader.readAsDataURL(this.files[0]);
});
$('#upload').on('change', function () {
    var fd = new FormData();
    fd.append("image", $("#upload")[0].files[0]);
    files = this.files;
    size = files[0].size;
    if (!files[0].name.match(/.(jpg|jpeg|png|gif)$/i)) {
        picpopup();
        document.getElementById('row1').style.display = "none";
        document.getElementById('row2').style.display = "block";
        $("#upload").val('');
        return false;
    }

    if (size > 26214400)
    {
        alert("Allowed file size exceeded. (Max. 25 MB)")
        document.getElementById('row1').style.display = "none";
        document.getElementById('row2').style.display = "block";
        //reset file upload control
        return false;
    }
    $.ajax({
        url: base_url + "freelancer/image_work",
        type: "POST",
        data: fd,
        processData: false,
        contentType: false,
        success: function (response) {
        }
    });
});

function get_freelancer_apply_progress() {
    $.ajax({
        type: 'POST',
        url: base_url +'freelancer/get_freelancer_apply_progress',
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
            // $("#edit-profile-move").hide();
        },5000);
    }
    else
    {
        $("#edit-profile-move").show();
        $("#profile-progress").show();                
        $("#progress-txt").html("<a href='"+base_url+'freelancer/'+freelancer_apply_slug+"'>Complete your profile to get connected with more people</a>.");   
    }
    // if($scope.old_count_profile < 100)
    {
        $('.second.circle-1').circleProgress({
            value: count_profile_value //with decimal point
        }).on('circle-animation-progress', function(event, progress) {
            $(this).find('strong').html(Math.round(count_profile * progress) + '<i>%</i>');
        });
    }
}
get_freelancer_apply_progress();