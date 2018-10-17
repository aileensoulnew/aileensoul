//setup before functions
var typingTimer;                //timer identifier
var doneTypingInterval = 1000;  //time in ms, 5 second for example
var maineditor;

maineditor = tinymce.init({
    selector: '#article_editor',    
    body_class: 'editor-body',
    content_css : base_url+'assets/n-css/editor-style.css',
    height: 300,
    relative_urls : false,
    remove_script_host : false,
    document_base_url : base_url,
    menubar: false,
    theme: 'modern',
    resize: false,
    autoresize_min_height: 350,
    advlist_bullet_styles:'default,circle,disc,square',
    block_formats: 'Paragraph=p;Text=h2;Text=h3;Text=h4;Text=h5;Text=h6',
    // image_dimensions: true,
    plugins:  [//autoresize
        "advlist autolink lists link image charmap print preview anchor ",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste imagetools wordcount textcolor hr charmap autoresize"
    ],
    toolbar: 'link image | undo redo |  formatselect | bold italic underline forecolor | alignleft aligncenter alignright alignjustify | hr charmap blockquote bullist numlist',
    imagetools_toolbar: "alignleft aligncenter alignright | rotateleft rotateright | flipv fliph | editimage imageoptions| removeimage",    
    setup: function(editor) {

        function insertDate() {            
            editor.insertContent('');
        }

        editor.addButton('removeimage', {
            icon: 'removeimage',
            image: base_url+'assets/n-images/trash.png',
            tooltip: "Insert Current Date",
            onclick: insertDate
        });

        editor.on('change', function (e) {        
            //console.log('Content changed to:  ' + editor.getContent());
            var title = $("#title_txt").val();
            var descr = editor.getContent();
            // console.log('title',title,'content',editor.getContent());
            if(title.trim() == "" && descr.trim() == "")
            {
                return false;
            }
            else
            {
                if(edit_art_published == 0)
                {                    
                    $("#save_post").show();
                    $("#save_post").text("Saving...");
                    var article_meta_title = $("#article_meta_title").val();
                    var article_meta_description = $("#article_meta_description").val();
                    var article_main_category = $('#article_main_category').find(":selected").val();
                    var article_other_category = $("#article_other_category").val();
                    var post_data = {
                        'article_title': title,
                        'article_content': descr,
                        'unique_key': unique_key,
                        'article_meta_title': article_meta_title,
                        'article_meta_description': article_meta_description,
                        'article_main_category': article_main_category,
                        'article_other_category': article_other_category,
                    };
                    $.ajax({
                        type: 'POST',
                        url: base_url + "article/add_article",
                        data: post_data,
                        dataType: "JSON",           
                        success: function (data) {
                            if(data.add_new_article == 1)
                            {
                                var title = "Edit Article"
                                var url = base_url +"edit-article/"+unique_key;
                                var obj = {
                                    Title: title,
                                    Url: url
                                };
                                history.pushState(obj, obj.Title, obj.Url);
                            }
                            $("#save_post").text("Saved");
                        }
                    });
                }
            }
        });
    },
    // enable title field in the Image dialog
    image_title: false,
    image_caption: false, 
    // enable automatic uploads of images represented by blob or data URIs
    automatic_uploads: true,    
    image_description: false,
    // image_dimensions: false, 
    image_title: false,

    init_instance_callback: function (editor) {
        editor.on('KeyUp', function (e) {            
            /*if(e.keyCode == 13)
            {
                var h = $("#article_editor_ifr").innerHeight();
                $("#article_editor_ifr").attr("style","width: 100%; display: block;height:"+ parseInt(h + 100)+"px");
            }*/
            clearTimeout(typingTimer);
            if (editor.getContent()) {
                typingTimer = setTimeout(function(){
                    var title = $("#title_txt").val();
                    var descr = editor.getContent();
                    // console.log('title',title,'content',editor.getContent());
                    if(title.trim() == "" && descr.trim() == "")
                    {
                        return false;
                    }
                    else
                    {
                        /*var words = descr.split(/[\w\u2019\'-]+/).length;
                        if(words > 200)
                        {
                            var ht = $("#article_editor_ifr").innerHeight();
                            $("#article_editor_ifr").attr("style","width: 100%; display: block;height:"+ parseInt(ht + 10)+"px");
                        }*/
                        if(edit_art_published == 0)
                        {                            
                            $("#save_post").show();
                            $("#save_post").text("Saving...");
                            var article_meta_title = $("#article_meta_title").val();
                            var article_meta_description = $("#article_meta_description").val();
                            var article_main_category = $('#article_main_category').find(":selected").val();
                            var article_other_category = $("#article_other_category").val();
                            var post_data = {
                                'article_title': title,
                                'article_content': descr,
                                'unique_key': unique_key,
                                'article_meta_title': article_meta_title,
                                'article_meta_description': article_meta_description,
                                'article_main_category': article_main_category,
                                'article_other_category': article_other_category,
                            };
                            $.ajax({
                                type: 'POST',
                                url: base_url + "article/add_article",
                                data: post_data,
                                dataType: "JSON",           
                                success: function (data) {
                                    if(data.add_new_article == 1)
                                    {
                                        var title = "Edit Article"
                                        var url = base_url +"edit-article/"+unique_key;
                                        var obj = {
                                            Title: title,
                                            Url: url
                                        };
                                        history.pushState(obj, obj.Title, obj.Url);
                                    }
                                    $("#save_post").text("Saved");
                                }
                            });
                        }
                    }
                }, doneTypingInterval);
            }
          // console.log('Editor contents was KeyUp.');
        });
        editor.on('focus blur',function(){
            $(".mce-statusbar").removeClass("error");
            // $("#article_editor").prev().removeClass("error");
            // $("#err_desc").hide();
        });
    },

    // URL of our upload handler (for more details check: https://www.tinymce.com/docs/configure/file-image-upload/#images_upload_url)
    // images_upload_url: 'postAcceptor.php',
    // here we add custom filepicker only to Image dialog
    file_picker_types: 'image', 
    // and here's our custom image picker
    file_picker_callback: function(cb, value, meta) {
        if (meta.filetype == 'image') {         
            // console.log(meta);
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');

            // Note: In modern browsers input[type="file"] is functional without 
            // even adding it to the DOM, but that might not be the case in some older
            // or quirky browsers like IE, so you might want to add it to the DOM
            // just in case, and visually hide it. And do not forget do remove it
            // once you do not need it anymore.
            input.onchange = function() {
                var file = this.files[0];
                var reader = new FileReader();
                reader.onload = function () {
                    // Note: Now we need to register the blob in TinyMCEs image blob
                    // registry. In the next release this part hopefully won't be
                    // necessary, as we are looking to handle it internally.
                    var id = 'blobid' + (new Date()).getTime();
                    var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                    var base64 = reader.result.split(',')[1];
                    var blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);
                    // call the callback and populate the Title field with the file name
                    // cb(blobInfo.blobUri(), { title: file.name });
                    var xhr, formData;

                    xhr = new XMLHttpRequest();
                    xhr.withCredentials = false;
                    xhr.open('POST', base_url+'article/upload_image');

                    xhr.onload = function() {
                        var json;

                        if (xhr.status != 200) {
                            failure('HTTP Error: ' + xhr.status);
                            return;
                        }

                        json = JSON.parse(xhr.responseText);                  

                        /*if (!json || typeof json.location != 'string') {
                        failure('Invalid JSON: ' + xhr.responseText);
                        return;
                        }*/

                        $("#upload_loader").hide();
                        $("#save_post").text("Saved");
                        var location = json.location;
                        cb(location,json.filename);
                        if(json.add_new_article == 1)
                        {
                            var title = "Edit Article"
                            var url = base_url +"edit-article/"+unique_key;
                            var obj = {
                                Title: title,
                                Url: url
                            };
                            history.pushState(obj, obj.Title, obj.Url);
                        }
                        // upload_success();
                    };
                    var title = $("#title_txt").val();
                    tinyMCE.activeEditor.getContent();
                    // Get the raw contents of the currently active editor
                    tinyMCE.activeEditor.getContent({format : 'raw'});
                    // Get content of a specific editor:
                    var descr =  tinyMCE.get('article_editor').getContent();

                    var article_meta_title = $("#article_meta_title").val();
                    var article_meta_description = $("#article_meta_description").val();
                    var article_main_category = $('#article_main_category').find(":selected").val();
                    var article_other_category = $("#article_other_category").val();                    

                    formData = new FormData();
                    formData.append('file', blobInfo.blob(), blobInfo.filename());              
                    formData.append('unique_key',unique_key);               
                    formData.append('article_title',title);             
                    formData.append('article_content',descr);               
                    formData.append('article_meta_title',article_meta_title);               
                    formData.append('article_meta_description',article_meta_description);               
                    formData.append('article_main_category',article_main_category);               
                    formData.append('article_other_category',article_other_category);               
                    formData.append('edit_art_published',edit_art_published);               
                    $("#upload_loader").show();
                    $("#save_post").show();
                    $("#save_post").text("Saving...");
                    xhr.send(formData);
                };
                reader.readAsDataURL(file);
            };
            input.click();
        }
    }
});
function upload_success()
{
    var title = $("#title_txt").val();
    tinyMCE.activeEditor.getContent();
    // Get the raw contents of the currently active editor
    tinyMCE.activeEditor.getContent({format : 'raw'});
    // Get content of a specific editor:
    var descr =  tinyMCE.get('article_editor').getContent();
    if(title.trim() == "" && descr.trim() == "")
    {
        return false;
    }
    else
    {
        if(edit_art_published == 0)
        {            
            var article_meta_title = $("#article_meta_title").val();
            var article_meta_description = $("#article_meta_description").val();
            var article_main_category = $('#article_main_category').find(":selected").val();
            var article_other_category = $("#article_other_category").val();
            var post_data = {
                'article_title': title,
                'article_content': descr,
                'unique_key': unique_key,
                'article_meta_title': article_meta_title,
                'article_meta_description': article_meta_description,
                'article_main_category': article_main_category,
                'article_other_category': article_other_category,
            };

            $("#save_post").show();
            $("#save_post").text("Saving...");
            $.ajax({
                type: 'POST',
                url: base_url + "article/add_article",
                data: post_data,
                dataType: "JSON",           
                success: function (data) {
                    if(data.add_new_article == 1)
                    {
                        var title = "Edit Article"
                        var url = base_url +"edit-article/"+unique_key;
                        var obj = {
                            Title: title,
                            Url: url
                        };
                        history.pushState(obj, obj.Title, obj.Url);
                    }
                    $("#save_post").text("Saved");
                }
            });
        }
    }

}

// $(document).ready(function () {
    /*$("#article_frm").validate({
        rules: {
            title_txt: {
                required: true,
            },
            article_editor: {
                required: true,
            },
            
        },                   
        messages:
        {
            title_txt: {
                required: "Please enter article title",
            },
            article_editor: {
                required: "Please enter article description",
            },
        },                   
        submitHandler: submitArticle
    });*/

    $("#title_txt").focusin(function(){
        $("#title_txt").removeClass("error");
        $("#err_title").hide();
    });    
    /*$("#title_txt").focusout(function(){
        $('#dobtooltip').hide();
    });*/

    function submitArticle()
    {
        var title = $("#title_txt").val();      
        var descr_vali =  tinyMCE.get('article_editor').getContent({format: 'text'});
        var descr =  tinyMCE.get('article_editor').getContent({format: 'raw'});     
        var error = 0;
        if(title.trim() == '')
        {
            $("#title_txt").addClass("error");
            // $("#err_title").show();
            error = 1;
        }
        if(descr_vali.trim() == '')
        {
            $(".mce-statusbar").addClass("error");
            // $("#article_editor").prev().addClass("error");
            // $("#err_desc").show();
            error = 1;  
        }
        if(error == 1)
        {           
            return false;
        }
        var article_meta_title = $("#article_meta_title").val();
        var article_meta_description = $("#article_meta_description").val();
        var article_main_category = $('#article_main_category').find(":selected").val();
        var article_other_category = $("#article_other_category").val();
        var post_data = {
            'article_title': title,
            'article_content': descr,
            'unique_key': unique_key,
            'article_meta_title': article_meta_title,
            'article_meta_description': article_meta_description,
            'article_main_category': article_main_category,
            'article_other_category': article_other_category,
            'edit_art_published': edit_art_published,
        };
        $("#publish").text('Publishing ...');
        $("#publish").attr('style','pointer-events: none;');
        $("#publish").removeAttr('onclick');
        $.ajax({
            type: 'POST',
            url: base_url+'article/publish_article',
            dataType: 'json',
            data: post_data,            
            success: function (response)
            {
                if(response.status == 1)
                {
                    $("#publishmodal .mes .msg").html("Congratulations, your post has been successfully submitted and sent for approval. We'll send you notifications once it's live.");
                    $("#publishmodal").modal("show");
                    $("#publish").text('Publish');  
                    $("#publish").removeAttr('style');
                    $("#publish").attr('onclick','return submitArticle();');
                    article_slug = response.article_slug;

                }
                else
                {
                    $("#publishmodal .mes .msg").html("Please try again later.");
                    $("#publishmodal").modal("show");
                    $("#publish").text('Publish');  
                    $("#publish").removeAttr('style');
                    $("#publish").attr('onclick','return submitArticle();');
                }               
            }
        });
        return false;
    }    

// });

//Featured Image Crop and Upload Start
$uploadCrop = $('#img_preview').croppie({
    enableExif: true,
    viewport: {
        width: 915,
        height: 350,
        type: 'square'
    },
    boundary: {
        width: 915,
        height: 350
    }
});
   
function readURL(input) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('.cr-image').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}
$(document).on('change','#featured_img', function(){
    $("#featured_img_src").hide();
    $("#featured_img_remove").hide();
    $("#img_preview_div").show();
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
$("#featured_img_remove").click(function(){
    $("#featured_img_src").hide();
    $("#featured_img_src").attr("src","");
    $("#featured_img_remove").hide();
    $("#img_preview_div").hide();

    $("#save_post").show();
    $("#save_post").text("Saving...");
    var post_data = {            
            'unique_key': unique_key,            
        };
    $.ajax({
        url: base_url + "article/remove_featured_img",
        type: "POST",
        data: post_data,
        dataType: 'json',
        success: function (result) {            
            $("#save_post").text("Saved");
        }
    });
});
$('.upload-result').on('click', function (ev) {
    $(this).attr("disabled","disabled");
    $(".cancel-result").attr("disabled","disabled");
    $("#publish").attr("disabled","disabled");

    $uploadCrop.croppie('result', {
        type: 'canvas',
        size: 'viewport'
    }).then(function (resp) {
        //console.log(resp);return false;
        var title = $("#title_txt").val();
        tinyMCE.activeEditor.getContent();
        // Get the raw contents of the currently active editor
        tinyMCE.activeEditor.getContent({format : 'raw'});
        // Get content of a specific editor:
        var descr =  tinyMCE.get('article_editor').getContent();
        var article_meta_title = $("#article_meta_title").val();
        var article_meta_description = $("#article_meta_description").val();
        var article_main_category = $('#article_main_category').find(":selected").val();
        var article_other_category = $("#article_other_category").val();
        var post_data = {
            'image': resp,
            'article_title': title,
            'article_content': descr,
            'unique_key': unique_key,
            'article_meta_title': article_meta_title,
            'article_meta_description': article_meta_description,
            'article_main_category': article_main_category,
            'article_other_category': article_other_category,
        };
        $("#save_post").show();
        $("#save_post").text("Saving...");
        $.ajax({
            url: base_url + "article/upload_featured_img",
            type: "POST",
            data: post_data,
            dataType: 'json',
            success: function (result) {
                $(".upload-result").removeAttr("disabled");
                $(".cancel-result").removeAttr("disabled");
                $("#publish").removeAttr("disabled");
                $('#img_preview_div').hide();
                $("#featured_img").val('');
                if(result.add_new_article == 1)
                {
                    var title = "Edit Article"
                    var url = base_url +"edit-article/"+unique_key;
                    var obj = {
                        Title: title,
                        Url: url
                    };
                    history.pushState(obj, obj.Title, obj.Url);
                }
                $("#featured_img_src").show();
                $("#featured_img_remove").show();
                $("#featured_img_src").attr('src',result.featured_img);
                $("#save_post").text("Saved");
            }
        });
    });
});
$('.cancel-result').on('click', function (ev) {
    $("#img_preview_div").hide();
    $("#featured_img").val('');
    $("#featured_img_src").hide();
    $("#featured_img_remove").hide();
});
//Featured Image Crop and Upload End
$("#okbtn").click(function(){   
    window.location = base_url + "article-preview/" + article_slug;
});
function other_field_fnc(id)
{
    if(id.value == 0)
    {
        $("#other_field_div").show();
    }
    else
    {
        upload_success();
        $("#other_field_div").hide();
    }
}

//setup before functions
var typingTimer1;                //timer identifier
var doneTypingInterval1 = 1000;  //time in ms, 5 second for example

//on keyup, start the countdown
$('#title_txt').keyup(function(){
    clearTimeout(typingTimer1);
    if ($('#title_txt').val()) {        
        typingTimer1 = setTimeout(function(){
            //do stuff here e.g ajax call etc....
            upload_success();
            // console.log('title',title,'content',descr);
             // $("#out").html(v);
        }, doneTypingInterval1);
    }
});



// $('#meta-detail').on('shown.bs.modal', function (e) {
    //on keyup, start the countdown
    $('#article_meta_title').keyup(function(){
        clearTimeout(typingTimer1);
        if ($('#article_meta_title').val()) {        
            typingTimer1 = setTimeout(function(){
                //do stuff here e.g ajax call etc....
                upload_success();
                // console.log('title',title,'content',descr);
                 // $("#out").html(v);
            }, doneTypingInterval1);
        }
    });

    //on keyup, start the countdown
    $('#article_meta_description').keyup(function(){
        clearTimeout(typingTimer1);
        if ($('#article_meta_description').val()) {        
            typingTimer1 = setTimeout(function(){
                //do stuff here e.g ajax call etc....
                upload_success();
                // console.log('title',title,'content',descr);
                 // $("#out").html(v);
            }, doneTypingInterval1);
        }
    });

// });
//on keyup, start the countdown
$('#article_other_category').keyup(function(){
    clearTimeout(typingTimer1);
    if ($('#article_other_category').val()) {        
        typingTimer1 = setTimeout(function(){
            //do stuff here e.g ajax call etc....
            upload_success();
            // console.log('title',title,'content',descr);
             // $("#out").html(v);
        }, doneTypingInterval1);
    }
});
$("#okcategory").click(function(){
    var cat = $("#article_main_category").find(":selected").val();
    if(cat != 0)
    {
        var txt = $("#article_main_category").find(":selected").text();
        $("#cat-selected").text(txt);
        change_category();
    }
    else
    {
        var txt = $("#article_other_category").val();
        if(txt.trim() != "")
        {
            $("#article_other_category").removeClass("error");
            $("#cat-selected").text(txt);
            change_category();
        }
        else
        {
            $("#article_other_category").addClass("error");
        }
    }
});
function change_category()
{    
    var article_main_category = $('#article_main_category').find(":selected").val();
    var article_other_category = $("#article_other_category").val();
    var post_data = {
        'unique_key': unique_key,
        'article_main_category': article_main_category,
        'article_other_category': article_other_category,
    };
    $("#okcategory").hide();
    $("#save_post").show();
    $("#save_post").text("Saving...");
    $("#cat_load_img").show();
    $.ajax({
        url: base_url + "article/change_category",
        type: "POST",
        data: post_data,
        dataType: 'json',
        success: function (result) {
            if(result.add_new_article == 1)
            {
                var title = "Edit Article"
                var url = base_url +"edit-article/"+unique_key;
                var obj = {
                    Title: title,
                    Url: url
                };
                history.pushState(obj, obj.Title, obj.Url);
                $("#cat_load_img").hide();
                $('#article-cetegory').modal('hide');
            }
            $("#okcategory").show();
            $("#save_post").hide();
        }
    });
}
$(document).ready(function(){
    $(window).scroll(function() {
        var window_height = $(window).scrollTop();
        var mce_tool_scroll = $('.mce-top-part').offset().top;    
        if(window_height >= parseInt(mce_tool_scroll) - 85)
        {
            $('.mce-toolbar-grp').addClass('stop-scroll-toolbar');
        }
        else
        {
            $('.mce-toolbar-grp').removeClass('stop-scroll-toolbar');   
        }

    });

    var cat = $("#article_main_category").find(":selected").val();
    if(cat != 0)
    {
        var txt = $("#article_main_category").find(":selected").text();
        $("#cat-selected").text(txt);        
    }
    else
    {
        var txt = $("#article_other_category").val();
        if(txt.trim() != "")
        {
            $("#article_other_category").removeClass("error");
            $("#cat-selected").text(txt);            
        }
        else
        {
            // $("#article_other_category").addClass("error");
        }
    }
});