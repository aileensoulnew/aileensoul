app.directive('ddTextCollapse', ['$compile', function($compile) {

    return {
        restrict: 'A',
        scope: true,
        link: function(scope, element, attrs) {

            // start collapsed
            scope.collapsed = false;

            // create the function to toggle the collapse
            scope.toggle = function() {
                scope.collapsed = !scope.collapsed;
            };

            // wait for changes on the text
            attrs.$observe('ddTextCollapseText', function(text) {

                // get the length from the attributes
                var maxLength = scope.$eval(attrs.ddTextCollapseMaxLength);
                var condition = scope.$eval(attrs.ddTextCollapseCond);
                

                if (text.length > maxLength) {
                    // split the text in two parts, the first always showing

                    if(/^\<a.*\>.*\<\/a\>/i.test(text))
                    {
                        var start = text.indexOf("<a href");
                        var end = text.indexOf('target="_blank">');
                        element.append(text);
                    }
                    else
                    {
                        var firstPart = String(text).substring(0, maxLength);                    
                        var secondPart = String(text).substring(maxLength, text.length);                    

                        // create some new html elements to hold the separate info
                        var firstSpan = $compile('<span>' + firstPart + '</span>')(scope);
                        var secondSpan = $compile('<span ng-if="collapsed">' + secondPart + '</span>')(scope);
                        var moreIndicatorSpan = $compile('<span ng-if="!collapsed">... </span>')(scope);
                        var lineBreak = $compile('<br ng-if="collapsed">')(scope);
                        if(condition == true)
                        {                        
                            var toggleButton = $compile('<span class="collapse-text-toggle" ng-click="toggle()">{{collapsed ? "" : "View more"}}</span>')(scope);//{{collapsed ? "View less" : "View more"}}
                        }
                        if(condition == false)
                        {                        
                            var toggleButton = $compile('<span class="collapse-text-toggle" ng-click="toggle()">{{collapsed ? "" : ""}}</span>')(scope);//{{collapsed ? "View less" : "View more"}}
                        }

                        // remove the current contents of the element
                        // and add the new ones we created
                        element.empty();
                        element.append(firstSpan);
                        element.append(secondSpan);
                        element.append(moreIndicatorSpan);
                        element.append(lineBreak);
                        element.append(toggleButton);

                    }                    
                }
                else {
                    element.empty();
                    element.append(text);
                }
            });
        }
    };
}]);

app.directive('pTextCollapse', ['$compile', function($compile) {

    return {
        restrict: 'A',
        scope: true,
        link: function(scope, element, attrs) {

            // start collapsed
            scope.collapsed = false;

            // create the function to toggle the collapse
            scope.toggle = function() {
                scope.collapsed = !scope.collapsed;
            };

            // wait for changes on the text
            attrs.$observe('pTextCollapseText', function(text) {

                // get the length from the attributes
                var maxLength = scope.$eval(attrs.pTextCollapseMaxLength);

                if (text.length > maxLength) {
                    // split the text in two parts, the first always showing
                    var firstPart = String(text).substring(0, maxLength);
                    var secondPart = String(text).substring(maxLength, text.length);

                    // create some new html elements to hold the separate info
                    var firstSpan = $compile('<span>' + firstPart + '</span>')(scope);
                    var secondSpan = $compile('<span ng-if="collapsed">' + secondPart + '</span>')(scope);
                    var moreIndicatorSpan = $compile('<span ng-if="!collapsed">... </span>')(scope);
                    var lineBreak = $compile('<br ng-if="collapsed">')(scope);
                    var toggleButton = $compile('<span class="collapse-text-toggle">{{collapsed ? "" : ""}}</span>')(scope);//{{collapsed ? "View less" : "View more"}}

                    // remove the current contents of the element
                    // and add the new ones we created
                    element.empty();
                    element.append(firstSpan);
                    element.append(secondSpan);
                    element.append(moreIndicatorSpan);
                    element.append(lineBreak);
                    element.append(toggleButton);
                }
                else {
                    element.empty();
                    element.append(text);
                }
            });
        }
    };
}]);
app.filter('parseUrl', function($sce) {
  var urls = /(\b(https:\/\/?|http:\/\/?|ftp:\/\/)[A-Z0-9+&@#\/%?=~_|!:,.;-]*[-A-Z0-9+&@#\/%=~_|])/gim
  var urlswww = /(\b(www.?)[A-Z0-9+&@#\/%?=~_|!:,.;-]*[-A-Z0-9+&@#\/%=~_|])/gim
  var emails = /(\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,6})/gim

  return function(text, asTrusted) {
    if(text.match(urls)) {
      text = text.replace(urls, "<a href=\"$1\" target=\"_self\">$1</a>")
    }
    else if(text.match(urlswww)) {
      text = text.replace(urlswww, "<a href=\"//$1\" target=\"_self\">$1</a>")
    }
    if(text.match(emails)) {
      text = text.replace(emails, "<a href=\"mailto:$1\">$1</a>")
    }

    if(asTrusted) {
      return $sce.trustAsHtml(text);
    }
    return text;
  }
});
app.filter('wordFirstCase', function () {
    return function (text) {
        return  text ? String(text).replace(/<[^>]+>/gm, '') : '';
    };
});
app.filter('removeLastCharacter', function () {
    return function (text) {
        return text.substr(0, text.lastIndexOf(".") + 1);
        //return  text ? String(text).replace(/<[^>]+>/gm, '') : '';
    };
});
app.filter('slugify', function () {
    return function (input) {
        if (!input)
            return;

        // make lower case and trim
        var slug = input.toLowerCase().trim();

        // replace invalid chars with spaces
        slug = slug.replace(/[^a-z0-9\s-]/g, ' ');

        // replace multiple spaces or hyphens with a single hyphen
        slug = slug.replace(/[\s-]+/g, '-');

        return slug;
    };
});
app.directive("owlCarousel", function () {
    return {
        restrict: 'E',
        link: function (scope) {
            scope.initCarousel = function (element) {
                // provide any default options you want
                /*var defaultOptions = {
                    loop: false,
                    nav: true,
                    lazyLoad: true,
                    margin: 0,
                    video: true,
                    responsive: {
                        0: {
                            items: 2
                        },
                        480: {
                            items: 3
                        },
                        768: {
                            items: 3,
                        },
						1280: {
                            items: 2
                        }
                    }
                };*/
                var defaultOptions = {
                    loop: false,
                    nav: true,
                    lazyLoad: true,
                    margin: 0,
                    video: true,
                    responsive: {
                        0: {
                            items: 1
                        },
                        480: {
                            items: 1
                        },
                        768: {
                            items: 1,
                        },
                        1280: {
                            items: 1
                        }
                    }
                };
                var customOptions = scope.$eval($(element).attr('data-options'));
                // combine the two options objects
                for (var key in customOptions) {
                    defaultOptions[key] = customOptions[key];
                }
                // init carousel
                $(element).owlCarousel(defaultOptions);
            };
        }
    };
});
app.directive('owlCarouselItem', [function () {
    return {
        restrict: 'A',
        link: function (scope, element) {
            // wait for the last item in the ng-repeat then call init
            if (scope.$last) {
                scope.initCarousel(element.parent());
            }
        }
    };
}]);
/*app.directive('fileInput', function ($parse) {
    return {
        restrict: 'A',
        link: function ($scope, element, attrs) {
            $(element).fileinput({
                uploadUrl: '#',
                allowedFileExtensions: ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF', 'psd', 'PSD', 'bmp', 'BMP', 'tiff', 'TIFF', 'iff', 'IFF', 'xbm', 'XBM', 'webp', 'WebP', 'HEIF', 'heif', 'BAT', 'bat', 'BPG', 'bpg', 'SVG', 'svg', 'mp4', 'mp3', 'pdf'],
                overwriteInitial: false,
                maxFileSize: 1000000,
                maxFilesNum: 10,
                //allowedFileTypes: ['image','video', 'flash'],
                slugCallback: function (filename) {
                    return filename.replace('(', '_').replace(']', '_');
                }
            });
            element.on("change", function (event) {
                var files = event.target.files;
                $parse(attrs.fileInput).assign($scope, element[0].files);
                $scope.$apply();
            });
        }
    };
});*/

// AUTO SCROLL MESSAGE DIV FIRST TIME END
app.directive('ngEnter', function () {			// custom directive for sending message on enter click
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if (event.which === 13 && !event.shiftKey) {
                scope.$apply(function () {
                    scope.$eval(attrs.ngEnter);
                });
                event.preventDefault();
            }
        });
    };
});
app.directive("editableText", function () {
    return {
        controller: 'EditorController',
        restrict: 'C',
        replace: true,
        transclude: true,
    };
});
app.controller('EditorController', ['$scope', function ($scope) {
    $scope.handlePaste = function (e) {
        e.preventDefault();
        e.stopPropagation();
        var value = e.originalEvent.clipboardData.getData("Text");
        document.execCommand('inserttext', false, value);
    };
}]);

// app.directive('scrollableContainer', function ($window, $document, $http) {
//     return {
//         link: function ($scope, element, attrs) {
//             $(window).on('scroll', function () {
// //                if ($(window).scrollTop() >= ($(document).height() - $(window).height()) * 0.7) {
//                 if ($(window).scrollTop() == $(document).height() - $(window).height()) {
//                     //var post_index = $(".post_index:last").val();
//                     var page = $(".page_number:last").val();
//                     var total_record = $(".total_record").val();
//                     var perpage_record = $(".perpage_record").val();
//                     if (parseInt(perpage_record * page) <= parseInt(total_record)) {
//                         var available_page = total_record / perpage_record;
//                         available_page = parseInt(available_page, 10);
//                         var mod_page = total_record % perpage_record;
//                         if (mod_page > 0) {
//                             available_page = available_page + 1;
//                         }
//                         //if ($(".page_number:last").val() <= $(".total_record").val()) {
//                         if (parseInt(page) <= parseInt(available_page)) {
//                             var pagenum = parseInt($(".page_number:last").val()) + 1;
//                             getUserPost(pagenum);
//                         }
//                     }
//                 }
//             });
//             function getUserPost(pagenum = '') {
//                 $('#loader').show();
//                 $http.get(base_url + "user_post/getUserPost?page=" + pagenum).then(function (success) {
//                     $('#loader').hide();
//                     for (var i in success.data) {
//                         $scope.postData.push(success.data[i]);
//                     }
//                     $('video,audio').mediaelementplayer(/* Options */);
//                 }, function (error) {});
//             }
//         }
//     };
// });


app.controller('userOppoController', function ($scope, $http,$compile) {
    $scope.IsVisible = false;

    $(document).on('hidden.bs.modal', function (event) {
        if($('.modal.in').length > 0)
        {
            if ($('body').hasClass('modal-open') == false) {
                $('body').addClass('modal-open');
            };            
        }
    });

    $(document)
    .on('show.bs.modal', '.modal', function(event) {
        $(this).appendTo($('body'));
    })
    .on('shown.bs.modal', '.modal.in', function(event) {
        setModalsAndBackdropsOrder();
    })
    .on('hidden.bs.modal', '.modal', function(event) {
        setModalsAndBackdropsOrder();
    });

    function setModalsAndBackdropsOrder() {  
        var modalZIndex = 1040;
        $('.modal.in').each(function(index) {
            var $modal = $(this);
            modalZIndex++;
            $modal.css('zIndex', modalZIndex);
            $modal.next('.modal-backdrop.in').addClass('hidden').css('zIndex', modalZIndex - 1);
        });
        $('.modal.in:visible:last').focus().next('.modal-backdrop.in').removeClass('hidden');
    }

    setTimeout(function(){
        var $elm = $('<adsense ad-client="ca-pub-6060111582812113" ad-slot="8390312875" inline-style="display:block;" ad-class="adBlock"></adsense>').appendTo('.right-add-box');
            $compile($elm)($scope);
    },2000);

    $scope.openModal2 = function(myModal2Id) {        
        document.getElementById(myModal2Id).style.display = "block";
        $("body").addClass("modal-open");
    };
    $scope.closeModal2 = function(myModal2Id) {    
        document.getElementById(myModal2Id).style.display = "none";
        $("body").removeClass("modal-open");
    };
    $scope.plusSlides2 = function(n,myModal2Id) {    
        showSlides2(slideIndex += n,myModal2Id);
    };
    $scope.currentSlide2 = function(n,myModal2Id) {    
        showSlides2(slideIndex = n,myModal2Id);
    };
    function showSlides2(n,myModal2Id) {
        var i;
        var slides = document.getElementsByClassName("mySlides2"+myModal2Id);
        //var dots = document.getElementsByClassName("demo");
        var captionText = document.getElementById("caption");
        if (n > slides.length) {
            slideIndex = 1
        }
        if (n < 1) {
            slideIndex = slides.length
        }
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }

        var elem = $("#element_load_"+slideIndex);
        $("#myModal"+myModal2Id+" #all_image_loader").hide();

        if (!elem.prop('complete')) {
            $("#myModal"+myModal2Id+" #all_image_loader").show();
            elem.on('load', function() {
                $("#myModal"+myModal2Id+" #all_image_loader").hide();
                // console.log("Loaded!");
                // console.log(this.complete);
            });
        } 
        /*for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }*/
        slides[slideIndex - 1].style.display = "block";
        //dots[slideIndex - 1].className += " active";
        //captionText.innerHTML = dots[slideIndex - 1].alt;
    }

    /*$(document).on('keydown', function (e) {
        if (e.keyCode === 27) {
            $('.modal-close').click();            
        }
    });*/
    $(document).on('keydown','#job_title .input',function () {
        if($('#job_title ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '100%');
        }
    });

    $(document).on('focusin','#job_title .input',function () {
        if($('#job_title ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '10px');
        }
    });
    $(document).on('focusout','#job_title .input',function () {
        if($('#job_title ul li').length > 0)
        {             
            $(this).attr('placeholder', '');
            $(this).css('width', '10px');
        }
        if($('#job_title ul li').length == 0)
        {            
            $(this).attr('placeholder', 'Ex:Seeking Opportunity, CEO, Enterpreneur, Founder, Singer, Photographer....');
            $(this).css('width', '100%');
        }         
    });

    $(document).on('keydown','#location .input',function () {
        if($('#location ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '100%');
        }
    });
    $(document).on('focusin','#location .input',function () {
        if($('#location ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '10px');
        }
    });
    $(document).on('focusout','#location .input',function () {
        if($('#location ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '10px');
        }
        if($('#location ul li').length == 0)
        {            
            $(this).attr('placeholder', 'Ex:Mumbai, Delhi, New south wels, London, New York, Captown, Sydeny, Shanghai....');
            $(this).css('width', '100%');
        }         
    });


    $(document).on('keydown','#ask_related_category .input',function () {
        if($('#ask_related_category ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '100%');
        }
    });
    $(document).on('focusin','#ask_related_category .input',function () {
        if($('#ask_related_category ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', 'auto');
        }
    });
    $(document).on('focusout','#ask_related_category .input',function () {
        if($('#ask_related_category ul li').length > 0)
        {             
            $(this).attr('placeholder', '');
            $(this).css('width', 'auto');
        }
        if($('#ask_related_category ul li').length == 0)
        {            
            $(this).attr('placeholder', 'Related Category');
            $(this).css('width', '100%');
        }         
    });

    $scope.opp = {};
    $scope.sim = {};
    $scope.ask = {};
    $scope.postData = {};
    $scope.opp.post_for = 'opportunity';
    $scope.sim.post_for = 'simple';
    $scope.ask.post_for = 'question';
    $scope.live_slug = live_slug;
    $scope.user_id = user_id;


    var cntImgSim = 0;
    var formFileDataSim = new FormData();
    var formFileExtSim = [];
    var fileCountSim = 0;
    var fileNamesArrSim = [];

    var cntImgOpp = 0;
    var formFileDataOpp = new FormData();
    var formFileExtOpp = [];
    var fileCountOpp = 0;
    var fileNamesArrOpp = [];

    var cntImgQue = 0;
    var formFileDataQue = new FormData();
    var formFileExtQue = [];
    var fileCountQue = 0;
    var fileNamesArrQue = [];

    var isLoadingData = false;
    var postIndex = -1;

    $(document).on('change','#fileInput1', function(e){
        $.each($('#fileInput1')[0].files, function(i, f) {
            
            if(fileNamesArrSim.indexOf(f.name) < 0)
            {
                formFileExtSim.push(f.type.split('/')[1]);
                fileNamesArrSim.push(f.name);

                if(f.type.match("image.*")) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var $el = $("<div class='img_preview' id='imgPrev_"+cntImgSim+"'><div class='i-ip'><img src=\"" + e.target.result + "\" data-file='"+f.name+"' class='selFile' title='"+f.name+"'></div><label class='remove_img' name='remove_image' ng-click=\"removeFile('"+cntImgSim+"')\" ><i class='fa fa-trash-o' aria-hidden='true'></i></label></div>").appendTo('#selectedFiles');
                        //$("#selectedFiles").append(html);
                        $compile($el)($scope);

                        formFileDataSim.append('myfiles_'+cntImgSim, f);

                        cntImgSim++;
                        fileCountSim++;                    
                        $("#fileCountSim").text(fileCountSim);
                        if($('#fileInput1')[0].files.length - 1 == i)
                        {
                            $('#fileInput1').val("");
                        }
                    }
                    reader.readAsDataURL(f); 
                }
                else if(f.type.match("video.*")) {
                    src = URL.createObjectURL(f);
                    var $el = $('<div class="img_preview" id="imgPrev_'+cntImgSim+'"><div class="i-ip"><video width="400"><source src="'+src+'" id="video_here">Your browser does not support HTML5 video.</video></div><label class="remove_img" name="remove_image" ng-click=\'removeFile("'+cntImgSim+'")\'><i class="fa fa-trash-o" aria-hidden="true"></i></label></div>').appendTo('#selectedFiles');
                    //$("#selectedFiles").append(html);
                    $compile($el)($scope);
                    formFileDataSim.append('myfiles_'+cntImgSim, f);
                    //fileNamesArrSim.push(f.name);
                    cntImgSim++;
                    fileCountSim++;
                    $("#fileCountSim").text(fileCountSim);
                    if($('#fileInput1')[0].files.length - 1 == i)
                    {
                        $('#fileInput1').val("");
                    }
                }

                else if(f.type.match("audio.*")) {
                    src = URL.createObjectURL(f);
                    var $el =  $('<div class="img_preview" id="imgPrev_'+cntImgSim+'"><div class="i-ip i-ip-audio"><audio><source src="'+src+'" type="audio/ogg"><source src="'+src+'" type="audio/mpeg">Your browser does not support the audio element.</audio></div><label class="remove_img" name="remove_image" ng-click=\'removeFile("'+cntImgSim+'")\'><i class="fa fa-trash-o" aria-hidden="true"></i></label></div>').appendTo('#selectedFiles');
                    //$("#selectedFiles").append(html);
                    $compile($el)($scope);
                    formFileDataSim.append('myfiles_'+cntImgSim, f);
                    cntImgSim++;
                    fileCountSim++;
                    $("#fileCountSim").text(fileCountSim);
                    if($('#fileInput1')[0].files.length - 1 == i)
                    {
                        $('#fileInput1').val("");
                    }
                }

                else if(f.type == "application/pdf") {              
                    var $el =  $('<div class="img_preview" id="imgPrev_'+cntImgSim+'"><div class="i-ip"><img ng-src="'+base_url+'assets/images/PDF.jpg" class="selFile"></div><label class="remove_img" name="remove_image" ng-click=\'removeFile("'+cntImgSim+'")\'><i class="fa fa-trash-o" aria-hidden="true"></i></label></div>').appendTo('#selectedFiles');
                    //$("#selectedFiles").append(html);
                    $compile($el)($scope);
                    formFileDataSim.append('myfiles_'+cntImgSim, f);
                    cntImgSim++;
                    fileCountSim++;
                    $("#fileCountSim").text(fileCountSim);
                    if($('#fileInput1')[0].files.length - 1 == i)
                    {
                        $('#fileInput1').val("");
                    }

                    /*var reader = new FileReader();
                    reader.onload = function (e) {
                        var $el = $("<div class='img_preview' id='imgPrev_"+cntImgSim+"'><div class='i-ip'><embed width='100%' src=\"" + e.target.result + "\" data-file='"+f.name+"' class='selFile' title='"+f.name+"'></embed></div><label class='remove_img' name='remove_image' ng-click=\"removeFile('"+cntImgSim+"')\" ><i class='fa fa-trash-o' aria-hidden='true'></i></label></div>").appendTo('#selectedFiles');
                        //$("#selectedFiles").append(html);
                        $compile($el)($scope);

                        formFileDataSim.append('myfiles_'+cntImgSim, f);

                        cntImgSim++;
                        fileCountSim++;                    
                        $("#fileCountSim").text(fileCountSim);
                        if($('#fileInput1')[0].files.length - 1 == i)
                        {
                            $('#fileInput1').val("");
                        }
                    }
                    reader.readAsDataURL(f);*/
                }
            }            
        });
    });

    $scope.removeFile = function(rmId) {        
        fileCountSim--;
        $("#fileCountSim").text(fileCountSim);
        if(fileCountSim <= 0)
        {
            $("#fileInput1").val("");
        }        
        var ext = formFileDataSim.get("myfiles_"+rmId).type.split('/')[1];
        var fileExtIndex = formFileExtSim.indexOf(ext.toString());
        formFileExtSim.splice(fileExtIndex, 1);
        
        var fileNameIndex = fileNamesArrSim.indexOf(formFileDataSim.get("myfiles_"+rmId).name);
        fileNamesArrSim.splice(fileNameIndex, 1);
        //console.log(fileNamesArrSim);
        $("#imgPrev_"+rmId).remove();
        formFileDataSim.delete("myfiles_"+rmId);

    };

    $(document).on('change','#fileInput', function(e){
        $.each($('#fileInput')[0].files, function(i, f) {
            
            if(fileNamesArrOpp.indexOf(f.name) < 0)
            {
                formFileExtOpp.push(f.type.split('/')[1]);
                fileNamesArrOpp.push(f.name);

                if(f.type.match("image.*")) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var $el = $("<div class='img_preview' id='imgPrevOpp_"+cntImgOpp+"'><div class='i-ip'><img src=\"" + e.target.result + "\" data-file='"+f.name+"' class='selFile' title='"+f.name+"'></div><label class='remove_img' name='remove_image' ng-click=\"removeFileOpp('"+cntImgOpp+"')\" ><i class='fa fa-trash-o' aria-hidden='true'></i></label></div>").appendTo('#selectedFilesOpp');                        
                        $compile($el)($scope);

                        formFileDataOpp.append('myfiles_'+cntImgOpp, f);

                        cntImgOpp++;
                        fileCountOpp++;                    
                        $("#fileCountOpp").text(fileCountOpp);
                        if($('#fileInput')[0].files.length - 1 == i)
                        {
                            $('#fileInput').val("");
                        }
                    }
                    reader.readAsDataURL(f); 
                }
                else if(f.type.match("video.*")) {
                    src = URL.createObjectURL(f);
                    var $el = $('<div class="img_preview" id="imgPrevOpp_'+cntImgOpp+'"><div class="i-ip"><video width="400"><source src="'+src+'" id="video_here">Your browser does not support HTML5 video.</video></div><label class="remove_img" name="remove_image" ng-click=\'removeFileOpp("'+cntImgOpp+'")\'><i class="fa fa-trash-o" aria-hidden="true"></i></label></div>').appendTo('#selectedFilesOpp');                    
                    $compile($el)($scope);
                    formFileDataOpp.append('myfiles_'+cntImgOpp, f);                    
                    cntImgOpp++;
                    fileCountOpp++;
                    $("#fileCountOpp").text(fileCountOpp);
                    if($('#fileInput')[0].files.length - 1 == i)
                    {
                        $('#fileInput').val("");
                    }
                }

                else if(f.type.match("audio.*")) {
                    src = URL.createObjectURL(f);
                    var $el =  $('<div class="img_preview" id="imgPrevOpp_'+cntImgOpp+'"><div class="i-ip i-ip-audio"><audio><source src="'+src+'" type="audio/ogg"><source src="'+src+'" type="audio/mpeg">Your browser does not support the audio element.</audio></div><label class="remove_img" name="remove_image" ng-click=\'removeFileOpp("'+cntImgOpp+'")\'><i class="fa fa-trash-o" aria-hidden="true"></i></label></div>').appendTo('#selectedFilesOpp');                    
                    $compile($el)($scope);
                    formFileDataOpp.append('myfiles_'+cntImgOpp, f);
                    cntImgOpp++;
                    fileCountOpp++;
                    $("#fileCountOpp").text(fileCountOpp);
                    if($('#fileInput')[0].files.length - 1 == i)
                    {
                        $('#fileInput').val("");
                    }
                }

                else if(f.type == "application/pdf") {              
                    var $el =  $('<div class="img_preview" id="imgPrevOpp_'+cntImgOpp+'"><div class="i-ip"><img ng-src="'+base_url+'assets/images/PDF.jpg" class="selFile"></div><label class="remove_img" name="remove_image" ng-click=\'removeFileOpp("'+cntImgOpp+'")\'><i class="fa fa-trash-o" aria-hidden="true"></i></label></div>').appendTo('#selectedFilesOpp');                    
                    $compile($el)($scope);
                    formFileDataOpp.append('myfiles_'+cntImgOpp, f);
                    cntImgOpp++;
                    fileCountOpp++;
                    $("#fileCountOpp").text(fileCountOpp);
                    if($('#fileInput')[0].files.length - 1 == i)
                    {
                        $('#fileInput').val("");
                    }
                }
            }            
        });
    });

    $scope.removeFileOpp = function(rmId) {
        fileCountOpp--;
        $("#fileCountOpp").text(fileCountOpp);
        if(fileCountOpp <= 0)
        {
            $("#fileInput").val("");
        }        
        var ext = formFileDataOpp.get("myfiles_"+rmId).type.split('/')[1];
        var fileExtIndex = formFileExtOpp.indexOf(ext.toString());
        formFileExtOpp.splice(fileExtIndex, 1);
        
        var fileNameIndex = fileNamesArrOpp.indexOf(formFileDataOpp.get("myfiles_"+rmId).name);
        fileNamesArrOpp.splice(fileNameIndex, 1);
        $("#imgPrevOpp_"+rmId).remove();
        formFileDataOpp.delete("myfiles_"+rmId);
    };

    $(document).on('change','#fileInput2', function(e){        
        $.each($('#fileInput2')[0].files, function(i, f) {
            if(fileNamesArrQue.indexOf(f.name) < 0)
            {

                if(f.type.match("image.*")) {
                
                formFileExtQue.push(f.type.split('/')[1]);
                fileNamesArrQue.push(f.name);

                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var $el = $("<div class='img_preview' id='imgPrevQue_"+cntImgQue+"'><div class='i-ip'><img src=\"" + e.target.result + "\" data-file='"+f.name+"' class='selFile' title='"+f.name+"'></div><label class='remove_img' name='remove_image' ng-click=\"removeFileQue('"+cntImgQue+"')\" ><i class='fa fa-trash-o' aria-hidden='true'></i></label></div>").appendTo('#selectedFilesQue');
                        //$("#selectedFiles").append(html);
                        $compile($el)($scope);

                        formFileDataQue.append('myfiles_'+cntImgQue, f);

                        cntImgQue++;
                        fileCountQue++;                    
                        $("#fileCountQue").text(fileCountQue);
                        if($('#fileInput2')[0].files.length - 1 == i)
                        {
                            $('#fileInput2').val("");
                        }
                    }
                    reader.readAsDataURL(f); 
                }               
            }            
        });
    });

    $scope.removeFileQue = function(rmId) {
        fileCountQue--;
        $("#fileCountQue").text(fileCountQue);
        if(fileCountQue <= 0)
        {
            $("#fileInput2").val("");
        }        
        var ext = formFileDataQue.get("myfiles_"+rmId).type.split('/')[1];
        var fileExtIndex = formFileExtQue.indexOf(ext.toString());
        formFileExtQue.splice(fileExtIndex, 1);
        
        var fileNameIndex = fileNamesArrQue.indexOf(formFileDataQue.get("myfiles_"+rmId).name);
        fileNamesArrQue.splice(fileNameIndex, 1);
        $("#imgPrevQue_"+rmId).remove();
        formFileDataQue.delete("myfiles_"+rmId);
    };

    $("#opptitle").focusin(function(){
        $('#opptitletooltip').show();
    });
    $("#opptitle").focusout(function(){
        $('#opptitletooltip').hide();
    });

    $("#job_title").focusin(function(){
        $('#jobtitletooltip').show();
    });
    $("#job_title").focusout(function(){
        $('#jobtitletooltip').hide();
    });

    $("#location").focusin(function(){
        $('#locationtooltip').show();
    });
    $("#location").focusout(function(){
        $('#locationtooltip').hide();
    });

    $("#field").focusin(function(){
        $('#fieldtooltip').show();
    });
    $("#field").focusout(function(){
        $('#fieldtooltip').hide();
    });

    $("#ask_desc").focusin(function(){
        $('#ask_desctooltip').show();
    });
    $("#ask_desc").focusout(function(){
        $('#ask_desctooltip').hide();
    });

    $("#ask_related_category").focusin(function(){
        $('#rlcattooltip').show();
    });
    $("#ask_related_category").focusout(function(){
        $('#rlcattooltip').hide();
    });

    $("#ask_field").focusin(function(){
        $('#ask_fieldtooltip').show();
    });
    $("#ask_field").focusout(function(){
        $('#ask_fieldtooltip').hide();
    });

    $scope.showLoadmore = true;
    var pg="";
    var fl_addpost="";
    var processing = false;
    getUserPost(pg);
    var isProcessing = false;
    function getUserPost(pg,fl_addpost) {
     
        $('#loader').show();
        if(pg == "" && fl_addpost == ""){
            $('#main_loader').show();
        }
        $http.get(base_url + "user_post/getUserPost?page=" + pg).then(function (success) {
            $('#loader').hide();
            if(pg == ""){
                $('#main_loader').hide();
            }
            // $('#main_page_load').show();
            $('body').removeClass("body-loader");
            if (success.data) {
                isLoadingData = false;
                $('#progress_div').hide();
                $('.progress-bar').css("width",0);
                $('.sr-only').text(0+"%");
                $scope.postData = success.data; 
            } else {
                isLoadingData = true;
            }

            setTimeout(function(){$('video,audio').mediaelementplayer({'pauseOtherPlayers': true}/* Options */);},300);
        }, function (error) {});
    }

    $(window).on('scroll', function () {
        if (($(window).scrollTop() >= ($(document).height() - $(window).height()) * 0.7)) {
            // isLoadingData = true;
            var page = $(".page_number:last").val();
            var total_record = $(".total_record").val();
            var perpage_record = $(".perpage_record").val();            
            if (parseInt(perpage_record * page) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum = parseInt($(".page_number:last").val()) + 1;
                    getUserPostLoadMore(pagenum);
                }
            }
        }
    });

    function getUserPostLoadMore(pg) {
       
        if (isProcessing) {
          
            /*
             *This won't go past this condition while
             *isProcessing is true.
             *You could even display a message.
             **/
            return;
        }
        isProcessing = true;
        $('#loader').show();
        $http.get(base_url + "user_post/getUserPost?page=" + pg).then(function (success) {
            $('#loader').hide();
           
            if (success.data[0].post_data) {
                isProcessing = false;
                //$scope.postData = success.data; 
                for (var i in success.data) {
                    $scope.postData.push(success.data[i]);
                }
                $scope.showLoadmore = true;
            } else {
                // processing = false;
                // isLoadingData = false;                
                $scope.showLoadmore = false;
            }

            setTimeout(function(){$('video,audio').mediaelementplayer({'pauseOtherPlayers': true}/* Options */);},300);
        }, function (error) {            
            getUserPostLoadMore(pg);
        });
    }

    

    getFieldList();
    function getFieldList() {
        $http.get(base_url + "general_data/getFieldList").then(function (success) {
            $scope.fieldList = success.data;
        }, function (error) {});
    }


    getContactSuggetion();
    function getContactSuggetion() {
        $http.get(base_url + "user_post/getContactSuggetion").then(function (success) {
            $scope.contactSuggetion = success.data;
        }, function (error) {});
    }
    $scope.job_title = [];
    $scope.loadJobTitle = function ($query) {
        return $http.get(base_url + 'user_post/get_jobtitle', {cache: true}).then(function (response) {
            var job_title = response.data;
            return job_title.filter(function (title) {
                return title.name.toLowerCase().indexOf($query.toLowerCase()) != -1;
            });
        });
    };
    $scope.location = [];
    $scope.loadLocation = function ($query) {
        return $http.get(base_url + 'user_post/get_location', {cache: true}).then(function (response) {
            var location_data = response.data;
            return location_data.filter(function (location) {
                return location.city_name.toLowerCase().indexOf($query.toLowerCase()) != -1;
            });
        });
    };

    $scope.category = [];
    $scope.loadCategory = function ($query) {
        return $http.get(base_url + 'user_post/get_category', {cache: true}).then(function (response) {
            var category_data = response.data;
            return category_data.filter(function (category) {
                return category.name.toLowerCase().indexOf($query.toLowerCase()) != -1;
            });
        });
    };

    $scope.removeViewMore = function(mainId,removeViewMore) {    
        $("#"+mainId).removeClass("view-more-expand");
        $("#"+removeViewMore).remove();
    };

    $scope.postFiles = function () {
        var a = document.getElementById('description').value;
        var b = $('job_title').val();
        var c = $('#location').val();
        var d = $('#field').val();
        //$("#post_opportunity")[0].reset();
        $('#description').val(a);
        $('#job_title').val(b);
        $('#location').val(c);
        $('#field').val(d);
    }

    $scope.post_opportunity_check = function (event,postIndex) {

        if (document.getElementById("opp_edit_post_id"+postIndex)) {
            var post_id = document.getElementById("opp_edit_post_id"+postIndex).value;
        } else {
            var post_id = 0;
        }        
        if (post_id == 0) {
            var fileInput = document.getElementById("fileInput").files;
            var description = $scope.opp.description;//document.getElementById("description").value;            
            var opptitle = $scope.opp.opptitle;
            var job_title = $scope.opp.job_title;
            var location = $scope.opp.location;
            var fields = $scope.opp.field;
            var otherField = $scope.opp.otherField;
            
            if( (fileCountOpp == 0 && (description == '' || description == undefined)) || ((opptitle == undefined || opptitle == '')  || (job_title == undefined || job_title == '')  || (location == undefined || location == '') || (fields == undefined || fields == '') || (fields == 0 && otherField == "")))
            {
                $('#post .mes').html("<div class='pop_content'>This post appears to be blank. All fields are mandatory.");
                $('#post').modal('show');
                $(document).on('keydown', function (e) {
                    if (e.keyCode === 27) {
                        $('#posterrormodal').modal('hide');
                        $('.modal-post').show();
                    }
                });
                //event.preventDefault();
                return false;
            }
            else
            {
                var allowedExtensions = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'bmp', 'BMP'];
                var allowesvideo = ['mp4', 'webm', 'mov', 'MP4'];
                var allowesaudio = ['mp3','mpeg'];
                var allowespdf = ['pdf'];
                var imgExt = false,videoExt = false,audioExt = false,pdfExt = false;

                if(fileCountOpp > 0 && fileCountOpp < 11)
                {
                    $.each(formFileExtOpp, function( index, value ) {
                        //console.log( index + ": " + value );
                        if($.inArray(value, allowedExtensions) > -1)
                        {
                            imgExt = true;
                        }
                        if($.inArray(value, allowesvideo) > -1)
                        {
                            videoExt = true;
                        }
                        if($.inArray(value, allowesaudio) > -1)
                        {
                            audioExt = true;
                        }
                        if($.inArray(value, allowespdf) > -1)
                        {
                            pdfExt = true;
                        }
                    });

                    if(imgExt == true && (videoExt == true || audioExt == true || pdfExt == true))
                    {
                        $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either photo or video or audio or pdf. You cannot upload more than 10 files at a time.");
                            $('#posterrormodal').modal('show');
                            //$("#post_opportunity")[0].reset();
                            //setInterval('window.location.reload()', 10000);
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false;
                    }
                    if(videoExt == true && (imgExt == true || audioExt == true || pdfExt == true))
                    {
                        $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either video or photo or  audio or pdf. You cannot upload more than 10 files at a time.");
                            $('#posterrormodal').modal('show');
                            //$("#post_opportunity")[0].reset();
                            //setInterval('window.location.reload()', 10000);
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false;                        
                    }
                    if(audioExt == true && (imgExt == true || videoExt == true || pdfExt == true))
                    {
                        $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either audio or photo or video or pdf. You cannot upload more than 10 files at a time.");
                            $('#posterrormodal').modal('show');
                            //$("#post_opportunity")[0].reset();
                            //setInterval('window.location.reload()', 10000);
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false;                        
                    }
                    else
                    {
                        if(audioExt == true && (description == '' || description == undefined))
                        {
                            $('.biderror .mes').html("<div class='pop_content'>Please Enter Audio Title.");
                            $('#posterrormodal').modal('show');
                            //$("#post_opportunity")[0].reset();
                            //setInterval('window.location.reload()', 10000);
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false; 
                        }

                    }
                    if(pdfExt == true && (imgExt == true || videoExt == true || audioExt == true))
                    {
                        $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either pdf or photo or video or audio. You cannot upload more than 10 files at a time.");
                            $('#posterrormodal').modal('show');
                            //$("#post_opportunity")[0].reset();
                            //setInterval('window.location.reload()', 10000);
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false;                        
                    }
                    else
                    {
                        if(pdfExt == true && (description == '' || description == undefined))
                        {
                            $('.biderror .mes').html("<div class='pop_content'>Please Enter PDF Title.");
                            $('#posterrormodal').modal('show');
                            //$("#post_opportunity")[0].reset();
                            //setInterval('window.location.reload()', 10000);
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false; 
                        }
                    }
                }
                else
                {
                    if((opptitle == '' || opptitle == undefined) || (description == '' || description == undefined) || ((job_title == undefined || job_title == '')  || (location == undefined || location == '') || (fields.trim() == undefined || fields.trim() == '')))
                    {
                        $('.biderror .mes').html("<div class='pop_content'>This post appears to be blank. Please write or attach (photos, videos, audios, pdf) to Post Opportunity.");
                        $('#posterrormodal').modal('show');
                        //$("#post_opportunity")[0].reset();
                        //setInterval('window.location.reload()', 10000);
                        $(document).on('keydown', function (e) {
                            if (e.keyCode === 27) {
                                $('#posterrormodal').modal('hide');
                                $('.modal-post').show();
                            }
                        });
                        //event.preventDefault();
                        return false;
                    }
                }

                for (var i = 0; i < fileCountOpp; i++)
                {
                    var vname = fileNamesArrOpp[i];
                    var vfirstname = fileNamesArrOpp[i];
                    var ext = vfirstname.split('.').pop();
                    var ext1 = vname.split('.').pop();
                    var foundPresent = $.inArray(ext, allowedExtensions) > -1;
                    var foundPresentvideo = $.inArray(ext, allowesvideo) > -1;
                    var foundPresentaudio = $.inArray(ext, allowesaudio) > -1;
                    var foundPresentpdf = $.inArray(ext, allowespdf) > -1;

                    if (foundPresent == true)
                    {
                        var foundPresent1 = $.inArray(ext1, allowedExtensions) > -1;
                        if (foundPresent1 == true && fileCountOpp >= 11) {                        
                            $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either photo or video or audio or pdf. You cannot upload more than 10 photos at a time.");
                            $('#posterrormodal').modal('show');
                            //setInterval('window.location.reload()', 10000);
                            //$("#post_opportunity")[0].reset();
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false;
                        }
                    } else if (foundPresentvideo == true)
                    {
                        var foundPresent1 = $.inArray(ext1, allowesvideo) > -1;
                        if (foundPresent1 == true && fileCountOpp == 1) {
                        } else {
                            $('.biderror .mes').html("<div class='pop_content'>Allowed to upload only single video.");
                            $('#posterrormodal').modal('show');
                            // setInterval('window.location.reload()', 10000);
                            //$("#post_opportunity")[0].reset();
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false;
                        }
                    } else if (foundPresentaudio == true)
                    {
                        var foundPresent1 = $.inArray(ext1, allowesaudio) > -1;
                        if (foundPresent1 == true && fileCountOpp == 1) {
                        } else {
                            $('.biderror .mes').html("<div class='pop_content'>Allowed to upload only single audio.");
                            $('#posterrormodal').modal('show');
                            //setInterval('window.location.reload()', 10000);
                            //$("#post_opportunity")[0].reset();
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false;
                        }
                    } else if (foundPresentpdf == true)
                    {
                        var foundPresent1 = $.inArray(ext1, allowespdf) > -1;
                        if (foundPresent1 == true && fileCountOpp == 1) {
                        } else {                            
                            $('.biderror .mes').html("<div class='pop_content'>Allowed to upload only single PDF.");                            
                            $('#posterrormodal').modal('show');
                            //setInterval('window.location.reload()', 10000);
                            //$("#post_opportunity")[0].reset();
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();

                                }
                            });
                            //event.preventDefault();
                            return false;
                        }
                    } else if (foundPresentvideo == false) {

                        $('.biderror .mes').html("<div class='pop_content'>This File Format is not supported Please Try to Upload MP4 or WebM files..");
                        $('#posterrormodal').modal('show');
                        //setInterval('window.location.reload()', 10000);
                        //$("#post_opportunity")[0].reset();
                        $(document).on('keydown', function (e) {
                            if (e.keyCode === 27) {
                                $('#posterrormodal').modal('hide');
                                $('.modal-post').show();

                            }
                        });
                        event.preventDefault();
                        return false;
                    }
                }

                /*var form_data = new FormData();
                $.each($("#fileInput")[0].files, function(i, file) {
                    form_data.append('postfiles[]', file);
                });*/

                formFileDataOpp.append('description', $scope.opp.description);
                formFileDataOpp.append('opptitle', $scope.opp.opptitle);
                formFileDataOpp.append('field', $scope.opp.field);
                formFileDataOpp.append('other_field', $scope.opp.otherField);
                formFileDataOpp.append('job_title', JSON.stringify($scope.opp.job_title));
                formFileDataOpp.append('location', JSON.stringify($scope.opp.location));
                formFileDataOpp.append('post_for', $scope.opp.post_for);
                formFileDataOpp.append('company_name', $scope.opp.company_name);

                $('body').removeClass('modal-open');
                $("#opportunity-popup").modal('hide');

                //$('.post_loader').show();
                $('#progress_div').show();
                var bar = $('.progress-bar');
                var percent = $('.sr-only');
                $http.post(base_url + 'user_post/post_opportunity', formFileDataOpp,
                        {
                            transformRequest: angular.identity,
                            headers: {'Content-Type': undefined, 'Process-Data': false},
                            uploadEventHandlers: {
                                progress: function(e) {
                                     if (e.lengthComputable) {
                                        progress = Math.round(e.loaded * 100 / e.total);

                                        bar.width((progress - 1) +'%');
                                        percent.html((progress - 1) +'%');

                                        //console.log("progress: " + progress + "%");
                                        if (e.loaded == e.total) {
                                            /*setTimeout(function(){
                                                $('#progress_div').hide();
                                                progress = 0;
                                                bar.width(progress+'%');
                                                percent.html(progress+'%');
                                            }, 2000);*/
                                            //console.log("File upload finished!");
                                            //console.log("Server will perform extra work now...");
                                        }
                                    }
                                }
                            }
                        })
                        .then(function (success) {

                            if (success) {                                
                                $('.post_loader').hide();
                                $scope.opp.description = '';
                                $scope.opp.opptitle = '';
                                $scope.opp.job_title = '';
                                $scope.opp.location = '';
                                $scope.opp.field = '';
                                $scope.opp.postfiles = '';
                                document.getElementById('fileInput').value = '';
                                $('#job_title .input').attr('placeholder', 'Ex:Seeking Opportunity, CEO, Enterpreneur, Founder, Singer, Photographer....');
                                $('#job_title .input').css('width', '100%');

                                $('#location .input').attr('placeholder', 'Ex:Mumbai, Delhi, New south wels, London, New York, Captown, Sydeny, Shanghai....');
                                $('#location .input').css('width', '100%');


                                $("#post_opportunity")[0].reset();

                                $('.file-preview-thumbnails').html('');
                                //$scope.postData.splice(0, 0, success.data[0]);
                                getUserPost(pg,1);
                                $scope.IsVisible = true;                                
                                $scope.recentpost = success.data;

                                bar.width(100+'%');
                                percent.html(100+'%');
                                setTimeout(function(){                                    
                                    progress = 0;
                                    // bar.width(progress+'%');
                                    // percent.html(progress+'%');
                                }, 2000);

                                imgExt = false,videoExt = false,audioExt = false,pdfExt = false;

                                cntImgOpp = 0;
                                formFileDataOpp = new FormData();
                                fileCountOpp = 0;
                                fileNamesArrOpp = [];
                                formFileExtOpp = [];
                                $("#selectedFilesOpp").html("");
                                $("#fileCountOpp").text("");

                                $('video, audio').mediaelementplayer({'pauseOtherPlayers': true});
                            }
                        });
            }

        } else {
            //var description = $("#description_edit_"+post_id).val();//$scope.opp.description;//document.getElementById("description").value;
            var description = $('#description_edit_' + post_id).html();
            description = description.replace(/&nbsp;/gi, " ");
            description = description.replace(/<br>$/, '');
            description = description.replace(/&gt;/gi, ">");
            description = description.replace(/&/g, "%26");            
            description = description.trim();
            var opptitle = $scope.opp.opptitleedit;
            var job_title = $scope.opp.job_title_edit;
            var location = $scope.opp.location_edit;            
            var fields = $("#field_edit"+post_id).val();
            var otherField_edit = $("#otherField_edit"+post_id).val();//$scope.opp.otherField_edit;

            if((opptitle == undefined || opptitle == '')  || (job_title == undefined || job_title == '')  || (location == undefined || location == '') || (fields == undefined || fields == '') || (fields == 0 && otherField_edit == ""))
            {
                $('#post .mes').html("<div class='pop_content'>This post appears to be blank. Please write to post.");
                $('#post').modal('show');
                $(document).on('keydown', function (e) {
                    if (e.keyCode === 27) {
                        $('#posterrormodal').modal('hide');
                        $('.modal-post').show();
                    }
                });
                //event.preventDefault();
                return false;
            } else {


                var form_data = new FormData();

                form_data.append('description', description);
                form_data.append('opptitle', opptitle);
                form_data.append('field', fields);
                form_data.append('other_field', otherField_edit);
                form_data.append('job_title', JSON.stringify(job_title));
                form_data.append('location', JSON.stringify(location));
                form_data.append('post_for', $scope.opp.post_for);
                form_data.append('company_name', $scope.opp.company_name);
                form_data.append('post_id', post_id);

                $('body').removeClass('modal-open');
                $("#opportunity-popup").modal('hide');
                $("#login_ajax_load"+post_id).show();
                $("#save_"+post_id).attr("style","pointer-events: none;");
                $http.post(base_url + 'user_post/edit_post_opportunity', form_data,
                        {
                            transformRequest: angular.identity,

                            headers: {'Content-Type': undefined, 'Process-Data': false}
                        })
                        .then(function (success) {
                            $("#login_ajax_load"+post_id).hide();
                            $("#save_"+post_id).attr("style","pointer-events: all;");
                            if (success.data.response == 1) {
                                $scope.postData[postIndex].opportunity_data.opptitle = success.data.opptitle;
                                $scope.postData[postIndex].opportunity_data.field = success.data.opp_field;
                                $scope.postData[postIndex].opportunity_data.field_id = success.data.field_id;
                                $scope.postData[postIndex].opportunity_data.location = success.data.opp_location;
                                $scope.postData[postIndex].opportunity_data.opportunity_for = success.data.opp_opportunity_for;
                                $scope.postData[postIndex].opportunity_data.opportunity = success.data.opportunity;
                                $scope.postData[postIndex].opportunity_data.company_name = success.data.company_name;
                                $("#post_opportunity_edit")[0].reset();

                                $("#edit-opp-post-"+post_id).hide();
                                $('#post-opp-detail-' + post_id).show();
                                $("#main-post-"+post_id+ " .post-images").show();
                            }

                        });
            }

        }
    }

    $scope.IsVisible = false;
    $scope.ShowHide = function () {
        //If DIV is visible it will be hidden and vice versa.
        $scope.IsVisible = $scope.IsVisible ? false : true;
    }


    $scope.questionList = function () {
        $http({
            method: 'POST',
            url: base_url + 'general_data/searchQuestionList',
            data: 'q=' + $scope.ask.ask_que,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            data = success.data;
            $scope.queSearchResult = data;
            if ($scope.queSearchResult.length > 0) {
                $('.questionSuggetion').addClass('question-available');
            } else {
                $('.questionSuggetion').removeClass('question-available');
            }
        });
    }


    $scope.ask_question_check = function (event,postIndex) {

        if (document.getElementById("ask_edit_post_id_"+postIndex)) {
            var post_id = document.getElementById("ask_edit_post_id_"+postIndex).value;
        } else {
            var post_id = 0;
        }
        if (post_id == 0) {
            var field = document.getElementById("ask_field").value;
            var description = document.getElementById("ask_que").value;
            var description = description.trim();
            var fileInput = document.getElementById("fileInput2").files;
            if ((field == '') || (description == ''))
            {
                $('#post .mes').html("<div class='pop_content'>Ask question and Field is required.");
                $('#post').modal('show');
                $(document).on('keydown', function (e) {
                    if (e.keyCode === 27) {
                        $('#posterrormodal').modal('hide');
                        $('.modal-post').show();
                    }
                });
                //event.preventDefault();
                return false;
            } else {

                var allowedExtensions = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'bmp', 'BMP'];
                
                var imgExtNot = false;

                if(fileCountQue > 0)
                {
                    $.each(formFileExtQue, function( index, value ) {
                        //console.log( index + ": " + value );
                        if($.inArray(value, allowedExtensions) == -1)
                        {
                            imgExtNot = true;
                        }                        
                    });

                    if(imgExtNot == true || fileCountQue > 10)
                    {
                        $('.biderror .mes').html("<div class='pop_content'>You can only upload photo. You cannot upload more than 10 photos at a time.");
                            $('#posterrormodal').modal('show');
                            //$("#post_opportunity")[0].reset();
                            //setInterval('window.location.reload()', 10000);
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false;
                    }                    
                }

                /*var form_data = new FormData();
                angular.forEach($scope.files, function (file) {
                    form_data.append('postfiles[]', file);
                });*/
                //form_data.append('postfiles',$scope.ask.postfiles);
                formFileDataQue.append('question', $scope.ask.ask_que);
                formFileDataQue.append('description', $scope.ask.ask_description);
                formFileDataQue.append('field', $scope.ask.ask_field);
                formFileDataQue.append('other_field', $scope.ask.otherField);
                formFileDataQue.append('category', JSON.stringify($scope.ask.related_category));
                formFileDataQue.append('weblink', $scope.ask.web_link);
                formFileDataQue.append('post_for', $scope.ask.post_for);
                formFileDataQue.append('is_anonymously', $scope.ask.is_anonymously);

                $('body').removeClass('modal-open');
                $("#opportunity-popup").modal('hide');
                $("#ask-question").modal('hide');
                //$('.post_loader').show();
                // $.each($("#fileInput2")[0].files, function(i, file) {
                //     form_data.append('postfiles[]', file);
                // });
                $('#progress_div').show();
                var bar = $('.progress-bar');
                var percent = $('.sr-only');

                $http.post(base_url + 'user_post/post_opportunity', formFileDataQue,
                        {
                            transformRequest: angular.identity,
                            headers: {'Content-Type': undefined, 'Process-Data': false},
                            uploadEventHandlers: {
                                progress: function(e) {
                                     if (e.lengthComputable) {
                                        progress = Math.round(e.loaded * 100 / e.total);

                                        bar.width((progress - 1) +'%');
                                        percent.html((progress - 1) +'%');

                                        //console.log("progress: " + progress + "%");
                                        if (e.loaded == e.total) {
                                            /*setTimeout(function(){
                                                $('#progress_div').hide();
                                                progress = 0;
                                                bar.width(progress+'%');
                                                percent.html(progress+'%');
                                            }, 2000);*/
                                            //console.log("File upload finished!");
                                            //console.log("Server will perform extra work now...");
                                        }
                                    }
                                }
                            }
                        })
                        .then(function (success) {
                            if (success) {
                                //window.location = base_url+user_slug+"/questions";
                                $('.post_loader').hide();
                                $scope.opp.description = '';
                                $scope.opp.job_title = '';
                                $scope.opp.location = '';
                                $scope.opp.field = '';
                                $scope.opp.postfiles = '';
                                document.getElementById('fileInput2').value = '';
                                $('.file-preview-thumbnails').html('');
                                $scope.ask.postfiles = '';
                                $scope.ask.ask_que = '';
                                $scope.ask.ask_description = '';
                                $scope.ask.ask_field = '';
                                $scope.ask.otherField = '';
                                $scope.ask.related_category = '';
                                $scope.ask.web_link = '';
                                $scope.ask.post_for = 'question';
                                $scope.ask.is_anonymously = '';

                                $('#ask_related_category .input').attr('placeholder', 'Related Category');
                                $('#ask_related_category .input').css('width', '100%');

                                //$scope.postData.splice(0, 0, success.data[0]);
                                getUserPost(pg,1);
                                $scope.IsVisible = true;
                                $scope.recentpost = success.data;

                                bar.width(100+'%');
                                percent.html(100+'%');
                                setTimeout(function(){                                    
                                    progress = 0;
                                    // bar.width(progress+'%');
                                    // percent.html(progress+'%');
                                }, 2000);
                                imgExt = false;
                                cntImgQue = 0;
                                formFileDataQue = new FormData();
                                fileCountQue = 0;
                                fileNamesArrQue = [];
                                formFileExtQue = [];
                                $("#selectedFilesQue").html("");
                                $("#fileCountQue").text("");
                                $('video, audio').mediaelementplayer({'pauseOtherPlayers': true});
                            }
                        });
            }

        } else {
            var ask_que = document.getElementById("ask_que_"+post_id).value;
            var ask_que = ask_que.trim();

            if($scope.IsVisible == true)
            {                
                var ask_web_link = $("#ask_web_link_"+post_id).val();
            }
            else
            {
                var ask_web_link = "";
            }
            var ask_que_desc = $('#ask_que_desc_' + post_id).val();
            /*ask_que_desc = ask_que_desc.replace(/&nbsp;/gi, " ");
            ask_que_desc = ask_que_desc.replace(/<br>$/, '');
            ask_que_desc = ask_que_desc.replace(/&gt;/gi, ">");
            ask_que_desc = ask_que_desc.replace(/&/g, "%26");*/
            ask_que_desc = ask_que_desc.trim();
            var related_category_edit = $scope.ask.related_category_edit;
            var edit_fields = $("#ask_field_"+post_id).val();  
            if(edit_fields == 0)
                var ask_other = $("#ask_other_"+post_id).val();
            else
                var ask_other = "";

            var ask_is_anonymously = ($("#ask_is_anonymously"+post_id+":checked").length > 0 ? 1 : 0);            
            
            if ((edit_fields == '') || (ask_que == ''))
            {
                $('#post .mes').html("<div class='pop_content'>Ask question and Field is required.");
                $('#post').modal('show');
                $(document).on('keydown', function (e) {
                    if (e.keyCode === 27) {
                        $('#posterrormodal').modal('hide');
                        $('.modal-post').show();
                    }
                });
                //event.preventDefault();
                return false;
            } else {


                var form_data = new FormData();

                form_data.append('question', ask_que);
                form_data.append('description', ask_que_desc);
                form_data.append('field', edit_fields);
                form_data.append('other_field', ask_other);
                form_data.append('category', JSON.stringify(related_category_edit));
                form_data.append('weblink', ask_web_link);
                form_data.append('post_for', "question");
                form_data.append('is_anonymously', ask_is_anonymously);
                form_data.append('post_id', post_id);
                $('body').removeClass('modal-open');
                $("#opportunity-popup").modal('hide');
                $("#ask-question").modal('hide');
                $http.post(base_url + 'user_post/edit_post_opportunity', form_data,
                        {
                            transformRequest: angular.identity,

                            headers: {'Content-Type': undefined, 'Process-Data': false}
                        })
                        .then(function (success) {
                            if (success) {
                                $("#edit-ask-que-"+post_id).hide();
                                $("#ask-que-"+post_id).show();
                                $("#main-post-"+post_id+ " .post-images").show();                                
                                $scope.postData[postIndex].question_data = success.data.question_data;
                                //$scope.getQuestions();
                                /*if (success.data.response == 1) {
                                    $('#ask-post-question-' + post_id).html(success.data.ask_question);
                                    $('#ask-post-description-' + post_id).html(success.data.ask_description);
                                    //   $('#ask-post-link-' + post_id).html(success.data.opp_field);
                                    $('#ask-post-category-' + post_id).html(success.data.ask_category);
                                    $('#ask-post-field-' + post_id).html(success.data.ask_field);
                                }*/
                                
                            }
                        });
            }
        }
    }


    // POST SOMETHING UPLOAD START

    $scope.post_something_check = function (event,postIndex) {
        //alert(postIndex);return false;
        if (document.getElementById("edit_post_id"+postIndex)) {
            var post_id = document.getElementById("edit_post_id"+postIndex).value;
        } else {
            var post_id = 0;
        }        
        if (post_id == 0) {
            var fileInput = document.getElementById("fileInput1").files;

            var sim_title = $scope.sim.sim_title;//document.getElementById("description").value;
            var sim_hashtag = $scope.sim.sim_hashtag;//document.getElementById("description").value;
            var description = $scope.sim.description;//document.getElementById("description").value;
            //var description = description.trim();
            var fileInput1 = document.getElementById("fileInput1").value;
            //console.log(fileInput1);
            
            if((sim_title == '' || sim_title == undefined) || (sim_hashtag == '' || sim_hashtag == undefined) || (fileCountSim == 0 && (description == '' || description == undefined)))
            {
                $('#posterrormodal .mes').html("<div class='pop_content'>This post appears to be blank. Please write or attach (photos, videos, audios, pdf) to post.");
                $('#posterrormodal').modal('show');
                $(document).on('keydown', function (e) {
                    if (e.keyCode === 27) {
                        $('#posterrormodal').modal('hide');
                        $('.modal-post').show();
                    }
                });
                // $("#post_something")[0].reset();
                //event.preventDefault();
                return false;
            } else {

                var allowedExtensions = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'bmp', 'BMP'];
                var allowesvideo = ['mp4', 'webm', 'mov', 'MP4'];
                var allowesaudio = ['mp3','mpeg'];
                var allowespdf = ['pdf'];
                var imgExt = false,videoExt = false,audioExt = false,pdfExt = false;

                if(fileCountSim > 0 && fileCountSim < 11)
                {                    
                    $.each(formFileExtSim, function( index, value ) {
                        //console.log( index + ": " + value );
                        if($.inArray(value, allowedExtensions) > -1)
                        {
                            imgExt = true;
                        }
                        if($.inArray(value, allowesvideo) > -1)
                        {
                            videoExt = true;
                        }
                        if($.inArray(value, allowesaudio) > -1)
                        {
                            audioExt = true;
                        }
                        if($.inArray(value, allowespdf) > -1)
                        {
                            pdfExt = true;
                        }
                    });

                    if(imgExt == true && (videoExt == true || audioExt == true || pdfExt == true))
                    {
                        $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either photo or video or audio or pdf. You cannot upload more than 10 files at a time.");
                            $('#posterrormodal').modal('show');
                            //$("#post_something")[0].reset();
                            //setInterval('window.location.reload()', 10000);
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false;
                    }
                    if(videoExt == true && (imgExt == true || audioExt == true || pdfExt == true))
                    {
                        $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either video or photo or  audio or pdf. You cannot upload more than 10 files at a time.");
                            $('#posterrormodal').modal('show');
                            //$("#post_something")[0].reset();
                            //setInterval('window.location.reload()', 10000);
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false;                        
                    }
                    if(audioExt == true && (imgExt == true || videoExt == true || pdfExt == true))
                    {
                        $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either audio or photo or video or pdf. You cannot upload more than 10 files at a time.");
                            $('#posterrormodal').modal('show');
                            //$("#post_something")[0].reset();
                            //setInterval('window.location.reload()', 10000);
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false;                        
                    }
                    else
                    {
                        if(audioExt == true && (description == '' || description == undefined || description == ' '))
                        {
                            $('.biderror .mes').html("<div class='pop_content'>Please Enter Audio Title.");
                            $('#posterrormodal').modal('show');
                            //$("#post_something")[0].reset();
                            //setInterval('window.location.reload()', 10000);
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false; 
                        }

                    }
                    if(pdfExt == true && (imgExt == true || videoExt == true || audioExt == true))
                    {
                        $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either pdf or photo or video or audio. You cannot upload more than 10 files at a time.");
                            $('#posterrormodal').modal('show');
                            //$("#post_something")[0].reset();
                            //setInterval('window.location.reload()', 10000);
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false;                        
                    }
                    else
                    {
                        if(pdfExt == true && (description == '' || description == undefined || description == ' '))
                        {
                            $('.biderror .mes').html("<div class='pop_content'>Please Enter PDF Title.");
                            $('#posterrormodal').modal('show');
                            //$("#post_something")[0].reset();
                            //setInterval('window.location.reload()', 10000);
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false; 
                        }
                    }
                }
                else
                {
                    if(description == '' || description == undefined || description == ' ')
                    {
                        $('.biderror .mes').html("<div class='pop_content'>You cannot upload more than 10 files at a time.");
                        $('#posterrormodal').modal('show');
                        //$("#post_something")[0].reset();
                        //setInterval('window.location.reload()', 10000);
                        $(document).on('keydown', function (e) {
                            if (e.keyCode === 27) {
                                $('#posterrormodal').modal('hide');
                                $('.modal-post').show();
                            }
                        });
                        //event.preventDefault();
                        return false;
                    }
                }

                for (var i = 0; i < fileCountSim; i++)
                {
                    var vname = fileNamesArrSim[i];
                    var vfirstname = fileNamesArrSim[i];
                    var ext = vfirstname.split('.').pop();
                    var ext1 = vname.split('.').pop();                    
                    var foundPresent = $.inArray(ext, allowedExtensions) > -1;
                    var foundPresentvideo = $.inArray(ext, allowesvideo) > -1;
                    var foundPresentaudio = $.inArray(ext, allowesaudio) > -1;
                    var foundPresentpdf = $.inArray(ext, allowespdf) > -1;

                    if (foundPresent == true)
                    {
                        var foundPresent1 = $.inArray(ext1, allowedExtensions) > -1;
                        if (foundPresent1 == true && fileCountSim >= 11) {                        
                            $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either photo or video or audio or pdf. You cannot upload more than 10 files at a time.");
                            $('#posterrormodal').modal('show');
                            //$("#post_something")[0].reset();
                            //setInterval('window.location.reload()', 10000);
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false;
                        }
                    }
                    else if (foundPresentvideo == true)
                    {
                        var foundPresent1 = $.inArray(ext1, allowesvideo) > -1;
                        if (foundPresent1 == true && fileCountSim == 1) {
                        } else {
                            $('.biderror .mes').html("<div class='pop_content'>Allowed to upload only single video.");
                            $('#posterrormodal').modal('show');
                            //setInterval('window.location.reload()', 10000);
                            //$("#post_something")[0].reset();

                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false;
                        }
                    } else if (foundPresentaudio == true)
                    {
                        var foundPresent1 = $.inArray(ext1, allowesaudio) > -1;
                        if (foundPresent1 == true && fileCountSim == 1) {

                            /*if (product_name == '') {
                             $('.biderror .mes').html("<div class='pop_content'>You have to add audio title.");
                             $('#posterrormodal').modal('show');
                             //setInterval('window.location.reload()', 10000);
                             
                             $(document).on('keydown', function (e) {
                             if (e.keyCode === 27) {
                             //$( "#bidmodal" ).hide();
                             $('#posterrormodal').modal('hide');
                             $('.modal-post').show();
                             }
                             });
                             event.preventDefault();
                             return false;
                             } */

                        } else {
                            $('.biderror .mes').html("<div class='pop_content'>Allowed to upload only single audio.");
                            $('#posterrormodal').modal('show');
                            //$("#post_something")[0].reset();
                            //setInterval('window.location.reload()', 10000);

                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false;
                        }
                    } else if (foundPresentpdf == true)
                    {
                        var foundPresent1 = $.inArray(ext1, allowespdf) > -1;
                        if (foundPresent1 == true && fileCountSim == 1) {

                            /*if (product_name == '') {
                             $('.biderror .mes').html("<div class='pop_content'>You have to add pdf title.");
                             $('#posterrormodal').modal('show');
                             setInterval('window.location.reload()', 10000);
                             
                             $(document).on('keydown', function (e) {
                             if (e.keyCode === 27) {
                             $('#posterrormodal').modal('hide');
                             $('.modal-post').show();
                             }
                             });
                             event.preventDefault();
                             return false;
                             } */
                        } else {
                            /*if (fileInput.length > 10) {
                                $('.biderror .mes').html("<div class='pop_content'>You can not upload more than 10 files at a time.");
                            } else {
                            }*/
                            $('.biderror .mes').html("<div class='pop_content'>Allowed to upload only single PDF.");
                            $('#posterrormodal').modal('show');
                            //$("#post_something")[0].reset();
                            //setInterval('window.location.reload()', 10000);

                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();

                                }
                            });
                            //event.preventDefault();
                            return false;
                        }
                    } else if (foundPresentvideo == false) {

                        $('.biderror .mes').html("<div class='pop_content'>This File Format is not supported Please Try to Upload MP4 or WebM files..");
                        $('#posterrormodal').modal('show');
                        //$("#post_something")[0].reset();
                        //setInterval('window.location.reload()', 10000);

                        $(document).on('keydown', function (e) {
                            if (e.keyCode === 27) {
                                $('#posterrormodal').modal('hide');
                                $('.modal-post').show();

                            }
                        });
                        //event.preventDefault();
                        return false;
                    }
                }

                /*var form_data = new FormData();
                $.each($("#fileInput1")[0].files, function(i, file) {
                    form_data.append('postfiles[]', file);
                });*/

               

                formFileDataSim.append('description', description);//$scope.sim.description);
                formFileDataSim.append('sptitle', sim_title);//$scope.sim.sim_title);
                formFileDataSim.append('hashtag', sim_hashtag);//$scope.sim.sim_hashtag);
                formFileDataSim.append('post_for', $scope.sim.post_for);
                //data.append('data', data);

                $('body').removeClass('modal-open');
                $("#post-popup").modal('hide');
                $("#post_opportunity_box").attr("style","pointer-events:none;");

                //$('.post_loader').show();
                $('#progress_div').show();
                var bar = $('.progress-bar');
                var percent = $('.sr-only');
                $http.post(base_url + 'user_post/post_opportunity', formFileDataSim,
                        {
                            transformRequest: angular.identity,
                            headers: {'Content-Type': undefined, 'Process-Data': false},
                            uploadEventHandlers: {
                                progress: function(e) {
                                     if (e.lengthComputable) {

                                        //document.getElementById("progress_div").style.display = "block";                                        
                                        
                                        progress = Math.round(e.loaded * 100 / e.total);

                                        bar.width((progress - 1) +'%');
                                        percent.html((progress - 1) +'%');

                                        //console.log("progress: " + progress + "%");
                                        if (e.loaded == e.total) {
                                            /*setTimeout(function(){
                                                $('#progress_div').hide();
                                                progress = 0;
                                                bar.width(progress+'%');
                                                percent.html(progress+'%');
                                            }, 2000);*/
                                            //console.log("File upload finished!");
                                            //console.log("Server will perform extra work now...");
                                        }
                                    }
                                }
                            }
                        })
                        .then(function (success) {
                            if (success) {
                                $("#post_something")[0].reset();
                                //$('.post_loader').hide();
                                $scope.sim.description = '';
                                $scope.sim.sim_title = '';
                                $scope.sim.sim_hashtag = '';
                                $scope.sim.postfiles = '';
                                document.getElementById('fileInput1').value = '';
                                $('.file-preview-thumbnails').html('');
                                //$scope.postData.splice(0, 0, success.data[0]);                                
                                getUserPost(pg,1);
                                $scope.IsVisible = true;
                                $scope.recentpost = success.data;

                                setTimeout(function(){
                                    // $scope.IsVisible = false;
                                },5000);

                                bar.width(100+'%');
                                percent.html(100+'%');
                                setTimeout(function(){
                                    //$('#progress_div').hide();
                                    progress = 0;
                                    // bar.width(progress+'%');
                                    // percent.html(progress+'%');
                                }, 2000);

                                imgExt = false,videoExt = false,audioExt = false,pdfExt = false;

                                cntImgSim = 0;
                                formFileDataSim = new FormData();
                                fileCountSim = 0;
                                fileNamesArrSim = [];
                                formFileExtSim = [];
                                $("#selectedFiles").html("");
                                $("#fileCountSim").text("");

                                $('video, audio').mediaelementplayer({'pauseOtherPlayers': true});
                            }
                            $("#post_opportunity_box").removeAttr("style");
                        });
            }
        } else {
            var description_check = $('#editPostTexBox-' + post_id).text();

            var description = $('#editPostTexBox-' + post_id).html();
            description = description.replace(/&nbsp;/gi, " ");
            description = description.replace(/<br>$/, '');//old
            // description = description.replace(/<br>/gi, '');
            description = description.replace(/&gt;/gi, ">");
            description = description.replace(/&/g, "%26");            

            var sim_title = $scope.sim.sim_title_edit;
            var sim_hashtag = $scope.sim.sim_hashtag_edit;

            //var description = $("#editPostTexBox-"+post_id).val();//$scope.sim.description_edit;//document.getElementById("description").value;            
            description = description.trim();            
            if($scope.sim.post_for == "simple")
            {
                if ((sim_title == '' || sim_title == undefined) || (sim_hashtag == '' || sim_hashtag == undefined) || description_check.trim() == '')
                {
                    $('#post .mes').html("<div class='pop_content'>This post appears to be blank. Please write to post.");
                    $('#post').modal('show');
                    $(document).on('keydown', function (e) {
                        if (e.keyCode === 27) {
                            $('#posterrormodal').modal('hide');
                            $('.modal-post').show();
                        }
                    });
                    //event.preventDefault();
                    return false;
                }
            }
            /*if (description == '')
            {
                $('#post .mes').html("<div class='pop_content'>This post appears to be blank. Please write to post.");
                $('#post').modal('show');
                $(document).on('keydown', function (e) {
                    if (e.keyCode === 27) {
                        $('#posterrormodal').modal('hide');
                        $('.modal-post').show();
                    }
                });
                //event.preventDefault();
                return false;
            } else {*/
                var form_data = new FormData();
                form_data.append('description', description);
                form_data.append('post_for', $scope.sim.post_for);
                form_data.append('sptitle', sim_title);
                form_data.append('hashtag', sim_hashtag);
                form_data.append('post_id', post_id);

                $('body').removeClass('modal-open');
                $("#post-popup").modal('hide');
                $http.post(base_url + 'user_post/edit_post_opportunity', form_data,
                {
                    transformRequest: angular.identity,
                    headers: {'Content-Type': undefined, 'Process-Data': false}
                })
                .then(function (success) {
                    if (success) {
                        $("#post_something_edit")[0].reset();
                        if (success.data.response == 1) {
                            $scope.postData[postIndex].simple_data.description = success.data.sim_description;
                            //$('#simple-post-description-' + post_id).html(success.data.sim_description);
                            //$('#simple-post-description-' + post_id).attr("dd-text-collapse-text",success.data.sim_description);
                            $('#edit-simple-post-' + post_id).hide();
                            $('#simple-post-description-' + post_id).show();
                            $("#main-post-"+post_id+ " .post-images").show();
                        }
                    }
                });
            //}

        }
    }

    $scope.loadMediaElement = function ()
    {
        $('video,audio').mediaelementplayer({'pauseOtherPlayers': true}/* Options */);
        var mediaElements = document.querySelectorAll('video, audio'), i, total = mediaElements.length;

        for (i = 0; i < total; i++) {
            new MediaElementPlayer(mediaElements[i], {
                stretching: stretching,
                pluginPath: '../js/build/',
                success: function (media) {
                    var renderer = document.getElementById(media.id + '-rendername');

                    media.addEventListener('loadedmetadata', function () {
                        var src = media.originalNode.getAttribute('src').replace('&amp;', '&');
                        if (src !== null && src !== undefined) {
                            renderer.querySelector('.src').innerHTML = '<a href="' + src + '" target="_blank">' + src + '</a>';
                            renderer.querySelector('.renderer').innerHTML = media.rendererName;
                            renderer.querySelector('.error').innerHTML = '';
                        }
                    });

                    media.addEventListener('error', function (e) {
                        renderer.querySelector('.error').innerHTML = '<strong>Error</strong>: ' + e.message;
                    });
                }
            });
        }
    };

    $scope.addToContact = function (user_id, contact) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/addToContact',
            data: 'user_id=' + user_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            if (success.data.message == 1) {
                var index = $scope.contactSuggetion.indexOf(contact);
                $('.addtobtn-' + user_id).html('Request Sent');
                $('.addtobtn-' + user_id).attr('style','pointer-events:none;');
//                $('.owl-carousel').trigger('next.owl.carousel');
            }
        });
    }

    $scope.post_like = function (post_id,parent_index) {
        $('#post-like-' + post_id).attr('style','pointer-events: none;');
        $http({
            method: 'POST',
            url: base_url + 'user_post/likePost',
            data: 'post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            $('#post-like-' + post_id).removeAttr('style');
            
            if (success.data.message == 1) {
                if (success.data.is_newLike == 1) {
                    $('#post-like-count-' + post_id).show();
                    // $('#post-like-' + post_id).addClass('like');
                    
                    var myEl = angular.element( document.querySelector('#post-like-' + post_id) );
                    myEl.addClass('like');

                    $('#post-like-count-' + post_id).html(success.data.likePost_count);
                    if (success.data.likePost_count == '0') {
                        $('#post-other-like-' + post_id).html('');
                    } else {
                        $('#post-other-like-' + post_id).html(success.data.post_like_data);
                    }
                } else if (success.data.is_oldLike == 1) {
                    if(success.data.likePost_count < 1)
                    {                        
                        $('#post-like-count-' + post_id).hide();
                    }
                    else
                    {
                        $('#post-like-count-' + post_id).show();
                    }
                    $('#post-like-' + post_id).removeClass('like');
                    $('#post-like-count-' + post_id).html(success.data.likePost_count);
                    if (success.data.likePost_count == '0') {
                        $('#post-other-like-' + post_id).html('');
                    } else {
                        $('#post-other-like-' + post_id).html(success.data.post_like_data);
                    }
                }
                $scope.postData[parent_index].user_like_list = success.data.user_like_list;
            }            
        });
    }

    $scope.cmt_handle_paste = function (e) {        
        e.preventDefault();
        e.stopPropagation();
        var value = e.originalEvent.clipboardData.getData("Text");        
        value = value.substring(0,cmt_maxlength);        
        document.execCommand('inserttext', false, value);
    };

    $scope.check_comment_char_count = function(post_id,e){
        var comment = $('#commentTaxBox-' + post_id).html();
        //comment = comment.replace(/^(<br\s*\/?>)+/, '');
        comment = comment.replace(/&nbsp;/gi, " ");
        comment = comment.replace(/<br>$/, '');
        comment = comment.replace(/&gt;/gi, ">");
        comment = comment.replace(/&/g, "%26");
        var no_allow_keycode = [8,17,35,36,37,38,39,40,46];

        // if(e.keyCode != 8 && e.keyCode != 37 && e.keyCode != 39 && e.keyCode != 17 && e.keyCode != 46 && comment.length + 1 > 10)
        if(no_allow_keycode.indexOf(e.keyCode) == -1 && comment.length + 1 > cmt_maxlength)
        {
            e.preventDefault();
            return false;
        }
        else
        {
            return true;
        }
    };

    $scope.cmt_handle_paste_edit = function (e) {        
        e.preventDefault();
        e.stopPropagation();
        var value = e.originalEvent.clipboardData.getData("Text");        
        value = value.substring(0,cmt_maxlength);        
        document.execCommand('inserttext', false, value);
    };

    $scope.check_comment_char_count_edit = function(cmt_id,e){
        var comment = $('#editCommentTaxBox-' + cmt_id).text();
        //comment = comment.replace(/^(<br\s*\/?>)+/, '');
        comment = comment.replace(/&nbsp;/gi, " ");
        comment = comment.replace(/<br>$/, '');
        comment = comment.replace(/&gt;/gi, ">");
        comment = comment.replace(/&/g, "%26");
        var no_allow_keycode = [8,17,35,36,37,38,39,40,46];
        // if(e.keyCode != 8 && e.keyCode != 37 && e.keyCode != 39 && e.keyCode != 17 && e.keyCode != 46 && comment.length + 1 > 10)
        if(no_allow_keycode.indexOf(e.keyCode) == -1 && comment.length + 1 > cmt_maxlength)
        {
            e.preventDefault();
            return false;
        }
        else
        {
            return true;
        }
    };

    $scope.sendComment = function (post_id, index, post) {
        var commentClassName = $('#comment-icon-' + post_id).attr('class').split(' ')[0];
        var comment = $('#commentTaxBox-' + post_id).html();
        //comment = comment.replace(/^(<br\s*\/?>)+/, '');
        comment = comment.replace(/&nbsp;/gi, " ");
        comment = comment.replace(/<br>$/, '');
        comment = comment.replace(/&gt;/gi, ">");
        comment = comment.replace(/&/g, "%26");
        if (comment) {
            $("#cmt-btn-mob-"+post_id).attr("style","pointer-events: none;");
            $("#cmt-btn-mob-"+post_id).attr("disabled","disabled");
            $("#cmt-btn-"+post_id).attr("style","pointer-events: none;");
            $("#cmt-btn-"+post_id).attr("disabled","disabled");
            
            $scope.isMsg = true;
            $http({
                method: 'POST',
                url: base_url + 'user_post/postCommentInsert',
                data: 'comment=' + comment + '&post_id=' + post_id,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            })
            .then(function (success) {
                data = success.data;
                clearTimeout(int_not_count);            
                get_notification_unread_count();
                int_not_count = setTimeout(function(){
                  get_notification_unread_count();
                }, 10000);
                if (data.message == '1') {
                    if (commentClassName == 'last-comment') {
                        $scope.postData[index].post_comment_data.splice(0, 1);
                        $scope.postData[index].post_comment_data.push(data.comment_data[0]);
                        if(data.comment_count > 0)
                        {
                            $('.post-comment-count-' + post_id).show();
                        }
                        $('.post-comment-count-' + post_id).html(data.comment_count);
                        $('.editable_text').html('');
                    } else {
                        $scope.postData[index].post_comment_data.push(data.comment_data[0]);
                        if(data.comment_count > 0)
                        {
                            $('.post-comment-count-' + post_id).show();
                        }
                        $('.post-comment-count-' + post_id).html(data.comment_count);
                        $('.editable_text').html('');
                    }
                }
                setTimeout(function(){
                    $("#cmt-btn-mob-"+post_id).removeAttr("style");
                    $("#cmt-btn-mob-"+post_id).removeAttr("disabled");
                    $("#cmt-btn-"+post_id).removeAttr("style");
                    $("#cmt-btn-"+post_id).removeAttr("disabled");
                },1000);
            });
        } else {
            $scope.isMsgBoxEmpty = true;
        }
    }

    $scope.viewAllComment = function (post_id, index, post) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/viewAllComment',
            data: 'post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            data = success.data;
            $scope.postData[index].post_comment_data = data.all_comment_data;
            $scope.postData[index].post_comment_count = data.post_comment_count;
        });

    }

    $scope.viewLastComment = function (post_id, index, post) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/viewLastComment',
            data: 'post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            data = success.data;
            $scope.postData[index].post_comment_data = data.comment_data;
            $scope.postData[index].post_comment_count = data.post_comment_count;
        });

    }
    $scope.deletePostComment = function (comment_id, post_id, parent_index, index, post) {
        $scope.c_d_comment_id = comment_id;
        $scope.c_d_post_id = post_id;
        $scope.c_d_parent_index = parent_index;
        $scope.c_d_index = index;
        $scope.c_d_post = post;

        $('#delete_model').modal('show');
    }

    $scope.deleteComment = function (comment_id, post_id, parent_index, index, post) {
        var commentClassName = $('#comment-icon-' + post_id).attr('class').split(' ')[0];
        $http({
            method: 'POST',
            url: base_url + 'user_post/deletePostComment',
            data: 'comment_id=' + comment_id + '&post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            data = success.data;
            if (commentClassName == 'last-comment') {
                $scope.postData[parent_index].post_comment_data.splice(0, 1);
                $scope.postData[parent_index].post_comment_data.push(data.comment_data[0]);
                if(data.comment_count < 1)
                {
                    $('.post-comment-count-' + post_id).hide();
                }
                $('.post-comment-count-' + post_id).html(data.comment_count);
                $('.editable_text').html('');
            } else {
                $scope.postData[parent_index].post_comment_data.splice(index, 1);
                if(data.comment_count < 1)
                {
                    $('.post-comment-count-' + post_id).hide();
                }
                $('.post-comment-count-' + post_id).html(data.comment_count);
                $('.editable_text').html('');
            }
            if(data.comment_count <= 0)
            {
                setTimeout(function(){
                    $(".comment-for-post-"+post_id+" .post-comment").remove();
                },100);
                $(".new-comment-"+post_id).show();
            }
        });
    }

    $scope.likePostComment = function (comment_id, post_id) {
        $('#cmt-like-fnc-' + comment_id).attr("style","pointer-events:none;")
        $http({
            method: 'POST',
            url: base_url + 'user_post/likePostComment',
            data: 'comment_id=' + comment_id + '&post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            data = success.data;
            
            if (data.message == '1') {                
                if (data.is_newLike == 1) {
                    // $('#post-comment-like-' + comment_id).parent('a').addClass('like');
                    $('#cmt-like-fnc-' + comment_id).addClass('like');
                    $('#post-comment-like-' + comment_id).html(data.commentLikeCount);
                } else if (data.is_oldLike == 1) {
                    // $('#post-comment-like-' + comment_id).parent('a').removeClass('like');
                    $('#cmt-like-fnc-' + comment_id).removeClass('like');
                    $('#post-comment-like-' + comment_id).html(data.commentLikeCount);
                }

            }
            setTimeout(function(){
                $('#cmt-like-fnc-' + comment_id).removeAttr("style");
            },100);
        });
    }
    $scope.editPostComment = function (comment_id, post_id, parent_index, index) {
       /* var editContent = $('#comment-dis-inner-' + comment_id).html();
        $('#edit-comment-' + comment_id).show();
        $('#editCommentTaxBox-' + comment_id).html(editContent);
        $('#comment-dis-inner-' + comment_id).hide();*/
        $(".comment-for-post-"+post_id+" .edit-comment").hide();
        $(".comment-for-post-"+post_id+" .comment-dis-inner").show();
        $(".comment-for-post-"+post_id+" li[id^=edit-comment-li-]").show();
        $(".comment-for-post-"+post_id+" li[id^=cancel-comment-li-]").hide();
        // var editContent = $('#comment-dis-inner-' + comment_id).html();
        // var editContent = $('#comment-dis-inner-' + comment_id).text();
        var editContent = $scope.postData[parent_index].post_comment_data[index].comment;
        editContent = editContent.substring(0,cmt_maxlength);
        $('#edit-comment-' + comment_id).show();
        $('#editCommentTaxBox-' + comment_id).html(editContent);
        $('#comment-dis-inner-' + comment_id).hide();
        $('#edit-comment-li-' + comment_id).hide();
        $('#cancel-comment-li-' + comment_id).show();
        $(".new-comment-"+post_id).hide();
    }

    $scope.cancelPostComment = function (comment_id, post_id, parent_index, index) {
        
        $('#edit-comment-' + comment_id).hide();
        
        $('#comment-dis-inner-' + comment_id).show();
        $('#edit-comment-li-' + comment_id).show();
        $('#cancel-comment-li-' + comment_id).hide();
        $(".new-comment-"+post_id).show();
    }

    $scope.EditPostNew = function (post_id, post_for, index) {

        $("span[id^=simple-post-description-]").show();
        $("div[id^=edit-simple-post-]").hide();
        $("div[id^=post-opp-detail-]").show();
        $("div[id^=edit-opp-post-]").hide();
        $("div[id^=ask-que-]").show();
        $("div[id^=edit-ask-que-]").hide();
        //$("div[id^=main-post-]  .post-images").show();
        //$("#main-post-"+post_id+ " .post-images").hide();
        if(post_for == "simple")
        {
            $("#edit-simple-post-"+post_id).show();

            $scope.sim.sim_title_edit = $scope.postData[index].simple_data.sim_title
            var hashtags = "";
            if($scope.postData[index].simple_data.hashtag && $scope.postData[index].simple_data.hashtag != undefined)
            {
                hashtags = $scope.postData[index].simple_data.hashtag;
                hashtags = '#'+hashtags.replace(/,/ig,' #');
            }
            $scope.sim.sim_hashtag_edit = hashtags;//$scope.postData[index].simple_data.hashtag

            var editContent = $scope.postData[index].simple_data.description;//$('#simple-post-description-' + post_id).attr("ng-bind-html");
            $('#editPostTexBox-' + post_id).html(editContent.replace(/(<([^>]+)>)/ig,""));
            setTimeout(function(){
                //$('#editPostTexBox-' + post_id).focus();
                setCursotToEnd(document.getElementById('editPostTexBox-' + post_id));
            },100);            
            $('#simple-post-description-' + post_id).hide();            
        }
        else if(post_for == "opportunity")
        {
            var edit_location = [];
            var edit_jobtitle = [];
            var opportunity = $scope.postData[index].opportunity_data.opportunity;//$("#opp-post-opportunity-" + post_id).attr("dd-text-collapse-text");
            var job_title = $('#opp-post-opportunity-for-' + post_id).html().split(",");
            var city_names = $('#opp-post-location-' + post_id).html().split(",");
            //var field = ($scope.postData[index].opportunity_data.field_id == null || $scope.postData[index].opportunity_data.field_id == "" || $scope.postData[index].opportunity_data.field_id == 0 ? "Other" : $scope.postData[index].opportunity_data.field);//$('#opp-post-field-' + post_id).html();
            var field = $scope.postData[index].opportunity_data.field;
            var field_id = $scope.postData[index].opportunity_data.field_id;
            if(opportunity != "" && opportunity != undefined)
            {
                //$("#description_edit_" + post_id).val(opportunity.replace(/(<([^>]+)>)/ig,""));
                $("#description_edit_" + post_id).html(opportunity.replace(/(<([^>]+)>)/ig,""));
            }
            city_names.forEach(function(element,cityArrIndex) {
              edit_location[cityArrIndex] = {"city_name":element};
            });
            $scope.opp.location_edit = edit_location;

            job_title.forEach(function(element,jobArrIndex) {
              edit_jobtitle[jobArrIndex] = {"name":element};
            });
            $scope.opp.job_title_edit = edit_jobtitle;

            $scope.opp.opptitleedit = $scope.postData[index].opportunity_data.opptitle;            
            $("#opptitleedit"+post_id).val($scope.postData[index].opportunity_data.opptitle);

            if(city_names.length > 0)
            {
                $('#location .input').attr('placeholder', '');
                $('#location .input').css('width', '200px');
            }
            if(job_title.length > 0)
            {
                $('#job_title .input').attr('placeholder', '');
                $('#job_title .input').css('width', '200px');
            }
            $('[id=field_edit'+post_id+'] option').filter(function() { 
                return (field_id != 0 ? $(this).text() == field : 'Other'); //To select Blue
            }).prop('selected', true);

            $scope.opp.field_edit = field_id;
            $scope.opp.otherField_edit = "";
            $scope.opp.company_name_edit = $scope.postData[index].opportunity_data.company_name;
            setTimeout(function(){
                // $scope.opp.otherField_edit = field;
                $("#otherField_edit" + post_id).val(field);    
            },100);
            $("#description_edit_" + post_id).focus();
            setTimeout(function(){
                //$('#description_edit_' + post_id).focus();                
                setCursotToEnd(document.getElementById('description_edit_' + post_id));
            },100);

            $("#edit-opp-post-"+post_id).show();
            $('#post-opp-detail-' + post_id).hide();
        }
        else if(post_for == "question")
        {
            $('#ask-que-' + post_id).hide();
            $("#edit-ask-que-"+post_id).show();
            $("#ask_que_"+post_id).val($scope.postData[index].question_data.question);
            $("#ask_que_desc_"+post_id).val($scope.postData[index].question_data.description);
            if($scope.postData[index].question_data.link != "")
            {                
                $scope.IsVisible = true;
                $("#ask_web_link_"+post_id).val($scope.postData[index].question_data.link);                
            }
            else
            {
                $("#ask_web_link_"+post_id).val("");  
            }
            var related_category = [];
            var rel_category = $scope.postData[index].question_data.category.split(",");            
            rel_category.forEach(function(element,catArrIndex) {
              related_category[catArrIndex] = {"name":element};
            });
            $scope.ask.related_category_edit = related_category;
            if(rel_category.length > 0)
            {
                $('#ask_related_category_edit'+post_id+' .input').attr('placeholder', '');
                $('#ask_related_category_edit'+post_id+' .input').css('width', '200px');
            }
            $(document).on('focusin','#ask_related_category_edit'+post_id+' .input',function () {
                if($('#ask_related_category_edit'+post_id+' ul li').length > 0)
                {            
                    $(this).attr('placeholder', '');
                    $(this).css('width', '200px');
                }
            });
            $(document).on('focusout','#ask_related_category_edit'+post_id+' .input',function () {
                if($('#ask_related_category_edit'+post_id+' ul li').length > 0)
                {             
                    $(this).attr('placeholder', '');
                    $(this).css('width', '200px');
                }
                if($('#ask_related_category_edit'+post_id+' ul li').length == 0)
                {            
                    $(this).attr('placeholder', 'Related Category');
                    $(this).css('width', '200px');
                }         
            });

            //$("#ask_related_category_edit"+post_id).val(related_category);

            var ask_field = $scope.postData[index].question_data.field;

            if(ask_field != null)
            {                
                $('[id=ask_field_'+post_id+'] option').filter(function() { 
                    return ($(this).text() == ask_field);
                }).prop('selected', true);
            }
            else
            {                
                $scope.ask.ask_field_edit = 0
                var ask_other = $scope.postData[index].question_data.others_field;                
                setTimeout(function(){                    
                    $('[id=ask_field_'+post_id+'] option').filter(function() { 
                        return ($(this).text() == 'Other');
                    }).prop('selected', true);
                    $("#ask_other_"+post_id).val(ask_other);
                },100)
            }

            
            // var editContent = $('#simple-post-description-' + post_id).attr("dd-text-collapse-text");
            // $('#editPostTexBox-' + post_id).html(editContent);
            // setTimeout(function(){
            //     //$('#editPostTexBox-' + post_id).focus();
            //     setCursotToEnd(document.getElementById('editPostTexBox-' + post_id));
            // },100);
            
        }
    }

    $scope.cancelPostEditNew = function (post_id, post_for, index) {
        if(post_for == "simple")
        {
            $("#edit-simple-post-"+post_id).hide();
            $('#simple-post-description-' + post_id).show();
        }
        else if(post_for == "opportunity")
        {
            $("#edit-opp-post-"+post_id).hide();
            $('#post-opp-detail-' + post_id).show();
        }
    }

    $scope.EditPost = function (post_id, post_for, index) {
        $scope.is_edit = 1;


        $http({
            method: 'POST',
            url: base_url + 'user_post/getPostData',
            data: 'post_id=' + post_id + '&post_for=' + post_for,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            $scope.is_edit = 1;
            if (post_for == "opportunity") {
                $scope.opp.description = success.data.opportunity;
                $scope.opp.job_title = success.data.opportunity_for;
                $scope.opp.location = success.data.location;
                $scope.opp.field = success.data.field;
                $scope.opp.edit_post_id = post_id;
                $("#opportunity-popup").modal('show');

            } else if (post_for == "simple") {
                $scope.sim.description = success.data.description;
                $scope.sim.edit_post_id = post_id;

                $("#post-popup").modal('show');

            } else if (post_for == "question") {
                $scope.ask.ask_que = success.data.question;
                $scope.ask.ask_description = success.data.description;
                $scope.ask.related_category = success.data.tag_name;
                $scope.ask.ask_field = success.data.field;
                $scope.ask.edit_post_id = post_id;

                $("#ask-question").modal('show');
            }
        });
    }

    $scope.sendEditComment = function (comment_id,post_id) {
        var comment = $('#editCommentTaxBox-' + comment_id).html();
        comment = comment.replace(/&nbsp;/gi, " ");
        comment = comment.replace(/<br>$/, '');
        comment = comment.replace(/&gt;/gi, ">");
        comment = comment.replace(/&/g, "%26");
        if (comment) {
            $scope.isMsg = true;
            $http({
                method: 'POST',
                url: base_url + 'user_post/postCommentUpdate',
                data: 'comment=' + comment + '&comment_id=' + comment_id,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function (success) {
                data = success.data;
                if (data.message == '1') {
                    $('#comment-dis-inner-' + comment_id).show();
                    $('#comment-dis-inner-' + comment_id).html(comment);
                    $('#edit-comment-' + comment_id).html();
                    $('#edit-comment-' + comment_id).hide();
                    $('#edit-comment-li-' + comment_id).show();
                    $('#cancel-comment-li-' + comment_id).hide();
                    $('.new-comment-'+post_id).show();
                }
            });
        } else {
            $scope.isMsgBoxEmpty = true;
        }
    }
    $scope.deletePost = function (post_id, index) {
        $scope.p_d_post_id = post_id;
        $scope.p_d_index = index;

        $('#delete_post_model').modal('show');
    }
    $scope.deletedPost = function (post_id, index) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/deletePost',
            data: 'post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            data = success.data;
            if (data.message == '1') {
                //$scope.postData.splice(index, 1);
                getUserPost();
            }
        });
    }

   /*function check_no_post_data() {
       var numberPost = $scope.postData.length;
       if (numberPost == 0) {
           $('.all_user_post').html(no_user_post_html);
       }
   }*/

    $scope.like_user_list = function (post_id) {
        $http({
            method: 'POST',
            url: base_url + "user_post/likeuserlist",
            data: 'post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            $scope.count_likeUser = success.data.countlike;
            $scope.get_like_user_list = success.data.likeuserlist;
            if($scope.count_likeUser > 0)
            {                
                $('#likeusermodal').modal('show');
            }
        });

    }

    $scope.like_user_model_list = function (comment_id, post_id, parent_index, index, post) {
        var commentClassName = $('#comment-icon-' + post_id).attr('class').split(' ')[0];
        $http({
            method: 'POST',
            url: base_url + 'user_post/deletePostComment',
            data: 'comment_id=' + comment_id + '&post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            data = success.data;
            if (commentClassName == 'last-comment') {
                $scope.postData[parent_index].post_comment_data.splice(0, 1);
                $scope.postData[parent_index].post_comment_data.push(data.comment_data[0]);
                $('.post-comment-count-' + post_id).html(data.comment_count);
                $('.editable_text').html('');
            } else {
                $scope.postData[parent_index].post_comment_data.splice(index, 1);
                $('.post-comment-count-' + post_id).html(data.comment_count);
                $('.editable_text').html('');
            }
        });
    }
    
    
     $scope.lightbox = function (idx) {
                 //show the slider's wrapper: this is required when the transitionType has been set to "slide" in the ninja-slider.js
            var ninjaSldr = document.getElementById("ninja-slider");
            ninjaSldr.parentNode.style.display = "block";

            nslider.init(idx);

            var fsBtn = document.getElementById("fsBtn");
            fsBtn.click();
        alert("hiiii");
    };
    
    function fsIconClick(isFullscreen, ninjaSldr) {
        //fsIconClick is the default event handler of the fullscreen button
        if (isFullscreen) {
            ninjaSldr.parentNode.style.display = "none";
        }
    }
    
    // angular.element("input[name='gender']:checked").val();
    $('input:radio[name="report_spam"]').change(function(){
        if($(this).val() == '0'){
           $("#report_other").show();
        }
        else
        {
            $("#report_other").hide();   
        }
    });
    $scope.report_post_id = 0;
    $scope.open_report_spam = function(post_id){
        $scope.report_post_id = post_id;
        $("#report_spam_form")[0].reset();
        $("#report-spam").modal('show');
    };

    $scope.report_spam_validate = {        
        rules: {           
            report_spam: {
                required: true,
            },
            other_report_spam: {
                required: {
                    depends: function(element) {
                        return $("input[name='report_spam']:checked").val() == 0 ? true : false;
                    }
                },
            },
        },
        messages: {
            report_spam: {
                required: "Select Report",
            },
            other_report_spam: {
                required: "Enter Other Report",
            },
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "report_spam") {
                error.appendTo($("#err_report"));
            } else {
                error.insertAfter(element);
            }
        },
    };
    $scope.save_report_spam = function(){
        if ($scope.report_spam_form.validate()) {

            $("#save_report_spam").attr("style","pointer-events:none;display:none;");
            $("#save_report_spam_loader").show();

            var reported_post_id = $scope.report_post_id;            
            var reported_reason = $("input[name='report_spam']:checked").val();
            var reported_reason_other = $("#other_report_spam").val();
            var updatedata = $.param({'reported_post_id':reported_post_id,'reported_reason':reported_reason,'reported_reason_other':reported_reason_other});
            $http({
                method: 'POST',
                url: base_url + 'userprofile_page/save_report_spam',                
                data: updatedata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function (result) {                
                // $('#main_page_load').show();                
                success = result.data.success;
                $("#report_spam_form")[0].reset();                
                if(success == 1)
                {
                    
                }
                $("#save_report_spam").removeAttr("style");
                $("#save_report_spam_loader").hide();
                $("#report-spam").modal('hide');
            });
        }
    };

    $scope.get_user_progress = function(){
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/get_user_progress',            
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            var profile_progress = success.data.profile_progress;
            var count_profile_value = profile_progress.user_process_value;
            var count_profile = profile_progress.user_process;
            $scope.progress_status = profile_progress.progress_status;
            if(count_profile == 100)
            {
                $("#edit-profile-move").hide();
            }
            $scope.set_progress(count_profile_value,count_profile);
        });
    };

    $scope.get_user_progress();

    $scope.set_progress = function(count_profile_value,count_profile){
        if(count_profile == 100)
        {
            $("#progress-txt").html("Hurray! Your profile is complete.");
            setTimeout(function(){
                $("#edit-profile-move").hide();
                $("#profile-progress").hide();
            },5000);
        }
        else
        {
            $("#edit-profile-move").show();
            $("#profile-progress").show();                
            $("#progress-txt").html("<a href='"+base_url+live_slug+"/details' target='_self'>Complete your profile to get connected with more people.</a>");   
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
        $scope.old_count_profile = count_profile;
    };

    $scope.get_business_contact_suggetion = function() {
        $http.get(base_url + "user_post/get_business_contact_suggetion").then(function (success) {
            $scope.business_suggetion = success.data;
        }, function (error) {});
    };
    $scope.get_business_contact_suggetion();

    $scope.add_to_contact_business = function (id, status, to_id) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/add_business_follow',
            data: 'follow_id=' + id + '&status=' + status + '&to_id=' + to_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            // $scope.follow_value = success.data;
            $('.busflwbtn-' + to_id).html('Following');
            $('.busflwbtn-' + to_id).attr('style','pointer-events:none;');
        });
    };


    $scope.EditRecentPostNew = function (post_id, post_for, index) {

        $("span[id^=simple-post-description-]").show();
        $("div[id^=edit-simple-post-]").hide();
        $("div[id^=post-opp-detail-]").show();
        $("div[id^=edit-opp-post-]").hide();
        $("div[id^=ask-que-]").show();
        $("div[id^=edit-ask-que-]").hide();
        //$("div[id^=main-post-]  .post-images").show();
        //$("#main-post-"+post_id+ " .post-images").hide();
        if(post_for == "simple")
        {
            $("#edit-simple-post-"+post_id).show();
            var editContent = $scope.recentpost.simple_data.description//$('#simple-post-description-' + post_id).attr("ng-bind-html");
            $scope.sim.sim_title_edit = $scope.recentpost.simple_data.sim_title
            var hashtags = "";
            if($scope.recentpost.simple_data.hashtag && $scope.recentpost.simple_data.hashtag != undefined)
            {
                hashtags = $scope.recentpost.simple_data.hashtag;
                hashtags = '#'+hashtags.replace(/,/ig,' #');
            }
            $scope.sim.sim_hashtag_edit = hashtags;//$scope.postData[index].simple_data.hashtag

            $('#editPostTexBox-' + post_id).html(editContent.replace(/(<([^>]+)>)/ig,""));
            setTimeout(function(){
                //$('#editPostTexBox-' + post_id).focus();
                setCursotToEnd(document.getElementById('editPostTexBox-' + post_id));
            },100);            
            $('#simple-post-description-' + post_id).hide();            
        }
        else if(post_for == "opportunity")
        {
            var edit_location = [];
            var edit_jobtitle = [];
            var opportunity = $scope.recentpost.opportunity_data.opportunity;//$("#opp-post-opportunity-" + post_id).attr("dd-text-collapse-text");
            var job_title = $('#opp-post-opportunity-for-' + post_id).html().split(",");
            var city_names = $('#opp-post-location-' + post_id).html().split(",");
            //var field = ($scope.recentpost.opportunity_data.field_id == null || $scope.recentpost.opportunity_data.field_id == "" || $scope.recentpost.opportunity_data.field_id == 0 ? "Other" : $scope.recentpost.opportunity_data.field);//$('#opp-post-field-' + post_id).html();
            var field = $scope.recentpost.opportunity_data.field;
            var field_id = $scope.recentpost.opportunity_data.field_id;
            if(opportunity != "" && opportunity != undefined)
            {
                //$("#description_edit_" + post_id).val(opportunity.replace(/(<([^>]+)>)/ig,""));
                $("#description_edit_" + post_id).html(opportunity.replace(/(<([^>]+)>)/ig,""));
            }
            city_names.forEach(function(element,cityArrIndex) {
              edit_location[cityArrIndex] = {"city_name":element};
            });
            $scope.opp.location_edit = edit_location;

            job_title.forEach(function(element,jobArrIndex) {
              edit_jobtitle[jobArrIndex] = {"name":element};
            });
            $scope.opp.job_title_edit = edit_jobtitle;

            $scope.opp.opptitleedit = $scope.recentpost.opportunity_data.opptitle;
            $("#opptitleedit"+post_id).val($scope.recentpost.opportunity_data.opptitle);

            if(city_names.length > 0)
            {
                $('#location .input').attr('placeholder', '');
                $('#location .input').css('width', '200px');
            }
            if(job_title.length > 0)
            {
                $('#job_title .input').attr('placeholder', '');
                $('#job_title .input').css('width', '200px');
            }
            $('[id=field_edit'+post_id+'] option').filter(function() { 
                return (field_id != 0 ? $(this).text() == field : 'Other'); //To select Blue
            }).prop('selected', true);

            $scope.opp.field_edit = field_id;
            $scope.opp.otherField_edit = "";

            $scope.opp.company_name_edit = $scope.recentpost.opportunity_data.company_name;            
            setTimeout(function(){
                // $scope.opp.otherField_edit = field;
                $("#otherField_edit" + post_id).val(field);    
            },100);
            $("#description_edit_" + post_id).focus();
            setTimeout(function(){
                //$('#description_edit_' + post_id).focus();                
                setCursotToEnd(document.getElementById('description_edit_' + post_id));
            },100);

            $("#edit-opp-post-"+post_id).show();
            $('#post-opp-detail-' + post_id).hide();
        }
        else if(post_for == "question")
        {
            $('#ask-que-' + post_id).hide();
            $("#edit-ask-que-"+post_id).show();
            $("#ask_que_"+post_id).val($scope.recentpost.question_data.question);
            $("#ask_que_desc_"+post_id).val($scope.recentpost.question_data.description);
            if($scope.recentpost.question_data.link != "")
            {                
                $scope.IsVisible = true;
                $("#ask_web_link_"+post_id).val($scope.recentpost.question_data.link);                
            }
            else
            {
                $("#ask_web_link_"+post_id).val("");  
            }
            var related_category = [];
            var rel_category = $scope.recentpost.question_data.category.split(",");            
            rel_category.forEach(function(element,catArrIndex) {
              related_category[catArrIndex] = {"name":element};
            });
            $scope.ask.related_category_edit = related_category;
            if(rel_category.length > 0)
            {
                $('#ask_related_category_edit'+post_id+' .input').attr('placeholder', '');
                $('#ask_related_category_edit'+post_id+' .input').css('width', '200px');
            }
            $(document).on('focusin','#ask_related_category_edit'+post_id+' .input',function () {
                if($('#ask_related_category_edit'+post_id+' ul li').length > 0)
                {            
                    $(this).attr('placeholder', '');
                    $(this).css('width', '200px');
                }
            });
            $(document).on('focusout','#ask_related_category_edit'+post_id+' .input',function () {
                if($('#ask_related_category_edit'+post_id+' ul li').length > 0)
                {             
                    $(this).attr('placeholder', '');
                    $(this).css('width', '200px');
                }
                if($('#ask_related_category_edit'+post_id+' ul li').length == 0)
                {            
                    $(this).attr('placeholder', 'Related Category');
                    $(this).css('width', '200px');
                }         
            });

            //$("#ask_related_category_edit"+post_id).val(related_category);

            var ask_field = $scope.recentpost.question_data.field;

            if(ask_field != null)
            {                
                $('[id=ask_field_'+post_id+'] option').filter(function() { 
                    return ($(this).text() == ask_field);
                }).prop('selected', true);
            }
            else
            {                
                $scope.ask.ask_field_edit = 0
                var ask_other = $scope.recentpost.question_data.others_field;                
                setTimeout(function(){                    
                    $('[id=ask_field_'+post_id+'] option').filter(function() { 
                        return ($(this).text() == 'Other');
                    }).prop('selected', true);
                    $("#ask_other_"+post_id).val(ask_other);
                },100)
            }            
        }
    }

    $scope.deleteRecentPost = function (post_id, index) {
        $scope.p_rd_post_id = post_id;
        $scope.p_rd_index = index;

        $('#delete_recent_post_model').modal('show');
    }
    $scope.deletedRecentPost = function (post_id, index) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/deletePost',
            data: 'post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            data = success.data;
            if (data.message == '1') {
                $scope.IsVisible = false;
                $scope.recentpost = {};
            }
        });
    }

    $scope.post_recent_like = function (post_id,parent_index) {
        $('#post-like-' + post_id).attr('style','pointer-events: none;');
        $http({
            method: 'POST',
            url: base_url + 'user_post/likePost',
            data: 'post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            $('#post-like-' + post_id).removeAttr('style');
            
            if (success.data.message == 1) {
                if (success.data.is_newLike == 1) {
                    $('#post-like-count-' + post_id).show();
                    // $('#post-like-' + post_id).addClass('like');
                    
                    var myEl = angular.element( document.querySelector('#post-like-' + post_id) );
                    myEl.addClass('like');

                    $('#post-like-count-' + post_id).html(success.data.likePost_count);
                    if (success.data.likePost_count == '0') {
                        $('#post-other-like-' + post_id).html('');
                    } else {
                        $('#post-other-like-' + post_id).html(success.data.post_like_data);
                    }
                } else if (success.data.is_oldLike == 1) {
                    if(success.data.likePost_count < 1)
                    {                        
                        $('#post-like-count-' + post_id).hide();
                    }
                    else
                    {
                        $('#post-like-count-' + post_id).show();
                    }
                    $('#post-like-' + post_id).removeClass('like');
                    $('#post-like-count-' + post_id).html(success.data.likePost_count);
                    if (success.data.likePost_count == '0') {
                        $('#post-other-like-' + post_id).html('');
                    } else {
                        $('#post-other-like-' + post_id).html(success.data.post_like_data);
                    }
                }
                $scope.recentpost.user_like_list = success.data.user_like_list;
            }            
        });
    }

    $scope.viewAllCommentRecent = function (post_id, index, post) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/viewAllComment',
            data: 'post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            data = success.data;
            $scope.recentpost.post_comment_data = data.all_comment_data;
            $scope.recentpost.post_comment_count = data.post_comment_count;
        });

    }

    $scope.viewLastCommentRecent = function (post_id, index, post) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/viewLastComment',
            data: 'post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            data = success.data;
            $scope.recentpost.post_comment_data = data.comment_data;
            $scope.recentpost.post_comment_count = data.post_comment_count;
        });
    };

    $scope.editRecentPostComment = function (comment_id, post_id, parent_index, index) {
       /* var editContent = $('#comment-dis-inner-' + comment_id).html();
        $('#edit-comment-' + comment_id).show();
        $('#editCommentTaxBox-' + comment_id).html(editContent);
        $('#comment-dis-inner-' + comment_id).hide();*/
        $(".comment-for-post-"+post_id+" .edit-comment").hide();
        $(".comment-for-post-"+post_id+" .comment-dis-inner").show();
        $(".comment-for-post-"+post_id+" li[id^=edit-comment-li-]").show();
        $(".comment-for-post-"+post_id+" li[id^=cancel-comment-li-]").hide();
        // var editContent = $('#comment-dis-inner-' + comment_id).html();
        // var editContent = $('#comment-dis-inner-' + comment_id).text();
        var editContent = $scope.recentpost.post_comment_data[index].comment;
        editContent = editContent.substring(0,cmt_maxlength);
        $('#edit-comment-' + comment_id).show();
        $('#editCommentTaxBox-' + comment_id).html(editContent);
        $('#comment-dis-inner-' + comment_id).hide();
        $('#edit-comment-li-' + comment_id).hide();
        $('#cancel-comment-li-' + comment_id).show();
        $(".new-comment-"+post_id).hide();
    };

    $scope.deleteRecentPostComment = function (comment_id, post_id, parent_index, index, post) {
        $scope.c_d_comment_id = comment_id;
        $scope.c_d_post_id = post_id;
        $scope.c_d_parent_index = parent_index;
        $scope.c_d_index = index;
        $scope.c_d_post = post;

        $('#delete_recent_model').modal('show');
    }

    $scope.deleteRecentComment = function (comment_id, post_id, parent_index, index, post) {
        var commentClassName = $('#comment-icon-' + post_id).attr('class').split(' ')[0];
        $http({
            method: 'POST',
            url: base_url + 'user_post/deletePostComment',
            data: 'comment_id=' + comment_id + '&post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            data = success.data;
            if (commentClassName == 'last-comment') {
                $scope.recentpost.post_comment_data.splice(0, 1);
                $scope.recentpost.post_comment_data.push(data.comment_data[0]);
                if(data.comment_count < 1)
                {
                    $('.post-comment-count-' + post_id).hide();
                }
                $('.post-comment-count-' + post_id).html(data.comment_count);
                $('.editable_text').html('');
            } else {
                $scope.recentpost.post_comment_data.splice(index, 1);
                if(data.comment_count < 1)
                {
                    $('.post-comment-count-' + post_id).hide();
                }
                $('.post-comment-count-' + post_id).html(data.comment_count);
                $('.editable_text').html('');
            }
            if(data.comment_count <= 0)
            {
                setTimeout(function(){
                    $(".comment-for-post-"+post_id+" .post-comment").remove();
                },100);
                $(".new-comment-"+post_id).show();
            }
        });
    };

    $scope.sendRecentComment = function (post_id, index, post) {
        var commentClassName = $('#comment-icon-' + post_id).attr('class').split(' ')[0];
        var comment = $('#commentTaxBox-' + post_id).html();
        //comment = comment.replace(/^(<br\s*\/?>)+/, '');
        comment = comment.replace(/&nbsp;/gi, " ");
        comment = comment.replace(/<br>$/, '');
        comment = comment.replace(/&gt;/gi, ">");
        comment = comment.replace(/&/g, "%26");
        if (comment) {
            $("#cmt-btn-mob-"+post_id).attr("style","pointer-events: none;");
            $("#cmt-btn-mob-"+post_id).attr("disabled","disabled");
            $("#cmt-btn-"+post_id).attr("style","pointer-events: none;");
            $("#cmt-btn-"+post_id).attr("disabled","disabled");
            
            $scope.isMsg = true;
            $http({
                method: 'POST',
                url: base_url + 'user_post/postCommentInsert',
                data: 'comment=' + comment + '&post_id=' + post_id,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            })
            .then(function (success) {
                data = success.data;
                
                if (data.message == '1') {
                    if (commentClassName == 'last-comment') {
                        $scope.recentpost.post_comment_data.splice(0, 1);
                        $scope.recentpost.post_comment_data.push(data.comment_data[0]);
                        if(data.comment_count > 0)
                        {
                            $('.post-comment-count-' + post_id).show();
                        }
                        $('.post-comment-count-' + post_id).html(data.comment_count);
                        $('.editable_text').html('');
                    } else {
                        $scope.recentpost.post_comment_data.push(data.comment_data[0]);
                        if(data.comment_count > 0)
                        {
                            $('.post-comment-count-' + post_id).show();
                        }
                        $('.post-comment-count-' + post_id).html(data.comment_count);
                        $('.editable_text').html('');
                    }
                }
                setTimeout(function(){
                    $("#cmt-btn-mob-"+post_id).removeAttr("style");
                    $("#cmt-btn-mob-"+post_id).removeAttr("disabled");
                    $("#cmt-btn-"+post_id).removeAttr("style");
                    $("#cmt-btn-"+post_id).removeAttr("disabled");
                },1000);
            });
        } else {
            $scope.isMsgBoxEmpty = true;
        }
    };

    $scope.recent_post_something_check = function (event,postIndex) {
        postIndex = '';
        if (document.getElementById("edit_post_id"+postIndex)) {
            var post_id = document.getElementById("edit_post_id"+postIndex).value;
        } else {
            var post_id = 0;
        }        
        if (post_id == 0) {
        } else {
            var description_check = $('#editPostTexBox-' + post_id).text();

            var description = $('#editPostTexBox-' + post_id).html();
            description = description.replace(/&nbsp;/gi, " ");
            description = description.replace(/<br>$/, '');//old
            // description = description.replace(/<br>/gi, '');
            description = description.replace(/&gt;/gi, ">");
            description = description.replace(/&/g, "%26");            

            //var description = $("#editPostTexBox-"+post_id).val();//$scope.sim.description_edit;//document.getElementById("description").value;            
            description = description.trim();

            var sim_title = $scope.sim.sim_title_edit;
            var sim_hashtag = $scope.sim.sim_hashtag_edit;

            if($scope.sim.post_for == "simple")
            {
                if ((sim_title == '' || sim_title == undefined) || (sim_hashtag == '' || sim_hashtag == undefined) || description_check.trim() == '')
                {
                    $('#post .mes').html("<div class='pop_content'>This post appears to be blank. Please write to post.");
                    $('#post').modal('show');
                    $(document).on('keydown', function (e) {
                        if (e.keyCode === 27) {
                            $('#posterrormodal').modal('hide');
                            $('.modal-post').show();
                        }
                    });
                    //event.preventDefault();
                    return false;
                }
            }
            
            var form_data = new FormData();
            form_data.append('description', description);
            form_data.append('post_for', $scope.sim.post_for);
            form_data.append('sptitle', sim_title);
            form_data.append('hashtag', sim_hashtag);
            form_data.append('post_id', post_id);

            $('body').removeClass('modal-open');
            $("#post-popup").modal('hide');
            $http.post(base_url + 'user_post/edit_post_opportunity', form_data,
            {
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined, 'Process-Data': false}
            })
            .then(function (success) {
                if (success) {
                    $("#post_something_edit")[0].reset();
                    if (success.data.response == 1) {
                        $scope.recentpost.simple_data.description = success.data.sim_description;
                        //$('#simple-post-description-' + post_id).html(success.data.sim_description);
                        //$('#simple-post-description-' + post_id).attr("dd-text-collapse-text",success.data.sim_description);
                        $('#edit-simple-post-' + post_id).hide();
                        $('#simple-post-description-' + post_id).show();
                        $("#main-post-"+post_id+ " .post-images").show();
                    }
                }
            });
        }
    };

    $scope.recent_post_opportunity_check = function (event,postIndex) {
        postIndex = '';
        if (document.getElementById("opp_edit_post_id"+postIndex)) {
            var post_id = document.getElementById("opp_edit_post_id"+postIndex).value;
        } else {
            var post_id = 0;
        }        
        if (post_id == 0) {

        } else {
            //var description = $("#description_edit_"+post_id).val();//$scope.opp.description;//document.getElementById("description").value;
            var description = $('#description_edit_' + post_id).html();
            description = description.replace(/&nbsp;/gi, " ");
            description = description.replace(/<br>$/, '');
            description = description.replace(/&gt;/gi, ">");
            description = description.replace(/&/g, "%26");            
            description = description.trim();
            var opptitle = $scope.opp.opptitleedit;
            var job_title = $scope.opp.job_title_edit;
            var location = $scope.opp.location_edit;
            var company_name = $scope.opp.company_name_edit;
            var fields = $("#field_edit"+post_id).val();
            var otherField_edit = $("#otherField_edit"+post_id).val();//$scope.opp.otherField_edit;

            if((opptitle == undefined || opptitle == '')  || (job_title == undefined || job_title == '')  || (location == undefined || location == '') || (fields == undefined || fields == '') || (fields == 0 && otherField_edit == ""))
            {
                $('#post .mes').html("<div class='pop_content'>This post appears to be blank. Please write to post.");
                $('#post').modal('show');
                $(document).on('keydown', function (e) {
                    if (e.keyCode === 27) {
                        $('#posterrormodal').modal('hide');
                        $('.modal-post').show();
                    }
                });
                //event.preventDefault();
                return false;
            } else {


                var form_data = new FormData();

                form_data.append('description', description);
                form_data.append('opptitle', opptitle);
                form_data.append('field', fields);
                form_data.append('other_field', otherField_edit);
                form_data.append('job_title', JSON.stringify(job_title));
                form_data.append('location', JSON.stringify(location));
                form_data.append('post_for', $scope.opp.post_for);
                form_data.append('company_name', company_name);
                form_data.append('post_id', post_id);

                $('body').removeClass('modal-open');
                $("#opportunity-popup").modal('hide');
                $("#login_ajax_load"+post_id).show();
                $("#save_"+post_id).attr("style","pointer-events: none;");
                $http.post(base_url + 'user_post/edit_post_opportunity', form_data,
                        {
                            transformRequest: angular.identity,

                            headers: {'Content-Type': undefined, 'Process-Data': false}
                        })
                        .then(function (success) {
                            $("#login_ajax_load"+post_id).hide();
                            $("#save_"+post_id).attr("style","pointer-events: all;");
                            if (success.data.response == 1) {
                                $scope.recentpost.opportunity_data.opptitle = success.data.opptitle;
                                $scope.recentpost.opportunity_data.field = success.data.opp_field;
                                $scope.recentpost.opportunity_data.field_id = success.data.field_id;
                                $scope.recentpost.opportunity_data.location = success.data.opp_location;
                                $scope.recentpost.opportunity_data.opportunity_for = success.data.opp_opportunity_for;
                                $scope.recentpost.opportunity_data.opportunity = success.data.opportunity;
                                $scope.recentpost.opportunity_data.company_name = success.data.company_name;
                                $("#post_opportunity_edit")[0].reset();

                                $("#edit-opp-post-"+post_id).hide();
                                $('#post-opp-detail-' + post_id).show();
                                $("#main-post-"+post_id+ " .post-images").show();
                            }

                        });
            }

        }
    };

    $scope.recent_ask_question_check = function (event,postIndex) {
        postIndex = '';
        if (document.getElementById("ask_edit_post_id_"+postIndex)) {
            var post_id = document.getElementById("ask_edit_post_id_"+postIndex).value;
        } else {
            var post_id = 0;
        }
        if (post_id == 0) {

        } else {
            var ask_que = document.getElementById("ask_que_"+post_id).value;
            var ask_que = ask_que.trim();

            if($scope.IsVisible == true)
            {                
                var ask_web_link = $("#ask_web_link_"+post_id).val();
            }
            else
            {
                var ask_web_link = "";
            }
            var ask_que_desc = $('#ask_que_desc_' + post_id).val();
            /*ask_que_desc = ask_que_desc.replace(/&nbsp;/gi, " ");
            ask_que_desc = ask_que_desc.replace(/<br>$/, '');
            ask_que_desc = ask_que_desc.replace(/&gt;/gi, ">");
            ask_que_desc = ask_que_desc.replace(/&/g, "%26");*/
            ask_que_desc = ask_que_desc.trim();
            var related_category_edit = $scope.ask.related_category_edit;
            var edit_fields = $("#ask_field_"+post_id).val();  
            if(edit_fields == 0)
                var ask_other = $("#ask_other_"+post_id).val();
            else
                var ask_other = "";

            var ask_is_anonymously = ($("#ask_is_anonymously"+post_id+":checked").length > 0 ? 1 : 0);            
            
            if ((edit_fields == '') || (ask_que == ''))
            {
                $('#post .mes').html("<div class='pop_content'>Ask question and Field is required.");
                $('#post').modal('show');
                $(document).on('keydown', function (e) {
                    if (e.keyCode === 27) {
                        $('#posterrormodal').modal('hide');
                        $('.modal-post').show();
                    }
                });
                //event.preventDefault();
                return false;
            } else {


                var form_data = new FormData();

                form_data.append('question', ask_que);
                form_data.append('description', ask_que_desc);
                form_data.append('field', edit_fields);
                form_data.append('other_field', ask_other);
                form_data.append('category', JSON.stringify(related_category_edit));
                form_data.append('weblink', ask_web_link);
                form_data.append('post_for', "question");
                form_data.append('is_anonymously', ask_is_anonymously);
                form_data.append('post_id', post_id);
                $('body').removeClass('modal-open');
                $("#opportunity-popup").modal('hide');
                $("#ask-question").modal('hide');
                $http.post(base_url + 'user_post/edit_post_opportunity', form_data,
                {
                    transformRequest: angular.identity,

                    headers: {'Content-Type': undefined, 'Process-Data': false}
                })
                .then(function (success) {
                    if (success) {
                        $("#edit-ask-que-"+post_id).hide();
                        $("#ask-que-"+post_id).show();
                        $("#main-post-"+post_id+ " .post-images").show();                                
                        $scope.recentpost.question_data = success.data.question_data;                                
                    }
                });
            }
        }
    }
});

$(document).click(function(){
    $('.right-header ul.dropdown-menu').hide();
});

$(window).on("load", function () {
    $(".custom-scroll").mCustomScrollbar({
        autoHideScrollbar: true,
        theme: "minimal"
    });
});
function setCursotToEnd(el)
{
    el.focus();
    if (typeof window.getSelection != "undefined"
            && typeof document.createRange != "undefined") {
        var range = document.createRange();
        range.selectNodeContents(el);
        range.collapse(false);
        var sel = window.getSelection();
        sel.removeAllRanges();
        sel.addRange(range);
    } else if (typeof document.body.createTextRange != "undefined") {
        var textRange = document.body.createTextRange();
        textRange.moveToElementText(el);
        textRange.collapse(false);
        textRange.select();
    }
}