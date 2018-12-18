app.directive('numbersOnly', function () {
    return {
        require: 'ngModel',
        link: function (scope, element, attr, ngModelCtrl) {
            function fromUser(text) {
                if (text) {
                    var transformedInput = text.replace(/[^0-9]/g, '');

                    if (transformedInput !== text) {
                        ngModelCtrl.$setViewValue(transformedInput);
                        ngModelCtrl.$render();
                    }
                    return transformedInput;
                }
                return undefined;
            }            
            ngModelCtrl.$parsers.push(fromUser);
        }
    };
});
app.directive('checkFileExt', ['$compile', function($compile) {

    return {
        restrict: 'A',
        scope: true,
        link: function(scope, element, attrs) {
            attrs.$observe('checkFile', function(text) {
                // console.log(text);
                var filename_arr = text.split('.');
                var upload_url = scope.$eval(attrs.checkFilePath);
                // console.log(filename_arr);
                //console.log(filename_arr[filename_arr.length - 1]);
                var allowed_img_ext = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF'];
                var allowed_doc_ext = ['pdf','PDF','docx','doc'];
                var fileExt = filename_arr[filename_arr.length - 1];
                /*if ($.inArray(fileExt.toLowerCase(), allowed_img_ext) !== -1) {
                    var inner_html = $compile('<a href="'+upload_url+text+'" target="_blank"><img src="'+upload_url+text+'"></a>')(scope);
                }
                else if ($.inArray(fileExt.toLowerCase(), allowed_doc_ext) !== -1) {*/
                    var inner_html = $compile('<a class="file-preview-cus" href="'+upload_url+text+'" target="_blank"><img src="'+base_url+'assets/n-images/detail/file-up-cus.png"></a>')(scope);   
                // }
                element.empty();
                element.append(inner_html);
            });
            
        }
    };
}]);
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
app.filter('wordFirstCase', function () {
    return function(input) {
      return (!!input) ? input.charAt(0).toUpperCase() + input.substr(1).toLowerCase() : '';
    }
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
app.controller('businessProfileController', function ($scope, $http, $location, $window,$compile) {
    var all_months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    $scope.all_months = all_months;
    $scope.from_user_id = from_user_id;
    $scope.to_user_id = to_user_id;

    //Socila Links Start
    $scope.social_linksset = {social_links: []};

    $scope.social_linksset.social_links = [];
    $scope.addNewSocialLinks = function () {
        // console.log($scope.social_linksset.social_links.length);
        if($scope.social_linksset.social_links.length < 7)
        {
            $scope.social_linksset.social_links.push('');
            if($scope.social_linksset.social_links.length == 7)
            {
                $("#add-new-link").hide();
            }
        }
        else
        {
            $("#add-new-link").hide();
        }
    };

    $scope.removeSocialLinks = function (z) {
        //var lastItem = $scope.social_linksset.social_links.length - 1;
        $scope.social_linksset.social_links.splice(z,1);
        $("#add-new-link").show();
    };

    $scope.check_socialurl = function(id){
        var link_type = $("#link_type"+id+" option:selected").val();
        var link_url = $("#link_url"+id).val();        
        if(link_type == "Facebook")
        {            
            if(/(http|https):\/\/?(?:www\.)?(mbasic.facebook|m\.facebook|facebook|fb)\.(com|me)\/(?:(?:\w\.)*#!\/)?(?:pages\/)?(?:[\w\-\.]*\/)*([\w\-\.]*)/i.test(link_url)){
                $("#link_url"+id).removeClass("error");
                return true;
            }
            else
            {
                $("#link_url"+id).addClass("error");
                return false;
            }
        }
        if(link_type == "Google")
        {            
            if(/\+[^/]+|\d{21}/i.test(link_url)){
                $("#link_url"+id).removeClass("error");
                return true;
            }
            else
            {
                $("#link_url"+id).addClass("error");
                return false;
            }
        }
        if(link_type == "Instagram")
        {            
            if(/https?:\/\/(www\.)?instagram\.com\/([A-Za-z0-9_](?:(?:[A-Za-z0-9_]|(?:\.(?!\.))){0,28}(?:[A-Za-z0-9_]))?)/i.test(link_url)){
                $("#link_url"+id).removeClass("error");
                return true;
            }
            else
            {
                $("#link_url"+id).addClass("error");
                return false;
            }
        }
        if(link_type == "LinkedIn")
        {            
            if(/(http|https):\/\/?(?:www\.)?linkedin.com(\w+:{0,1}\w*@)?(\S+)(:([0-9])+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/i.test(link_url)){
                $("#link_url"+id).removeClass("error");
               return true; 
            }
            else
            {
                $("#link_url"+id).addClass("error");
                return false;
            }
        }
        if(link_type == "Pinterest")
        {            
            if(/^http(s)?:\/\/(in.)pinterest.com\/(.*)?$/i.test(link_url)){
                $("#link_url"+id).removeClass("error");
                return true;
            }
            else
            {
                $("#link_url"+id).addClass("error");
                return false;
            }
        }
        if(link_type == "GitHub")
        {            
            if(/http(s)?:\/\/(www\.)?github\.(com|io)\/[A-z 0-9 _-]+\/?/i.test(link_url)){
                $("#link_url"+id).removeClass("error");
                return true;
            }
            else
            {
                $("#link_url"+id).addClass("error");
                return false;
            }
        }
        if(link_type == "Twitter")
        {            
            if(/http(s)?:\/\/(.*\.)?twitter\.com\/[A-z 0-9 _]+\/?/i.test(link_url)){
                $("#link_url"+id).removeClass("error");
                return true;
            }
            else
            {
                $("#link_url"+id).addClass("error");
                return false;
            }
        }

    };

    $scope.personal_linksset = {personal_links: []};

    $scope.personal_linksset.personal_links = [];
    $scope.addNewPersonalLinks = function () {
        // console.log($scope.personal_linksset.personal_links.length);
        if($scope.personal_linksset.personal_links.length < 10)
        {
            $scope.personal_linksset.personal_links.push('');
            if($scope.personal_linksset.personal_links.length == 10)
            {
                $("#add-personla-link").hide();
            }
        }
        else
        {
            $("#add-personla-link").hide();
        }
    };

    $scope.removePersonalLinks = function (z) {
        //var lastItem = $scope.personal_linksset.personal_links.length - 1;
        $scope.personal_linksset.personal_links.splice(z,1);
        $("#add-personla-link").show();
    };
    $scope.check_personalurl = function(id){
        var personal_link_url = $("#personal_link_url"+id).val();
        //var regexp =   /^(https):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i;
        var res = personal_link_url.match(/(http(s)?:\/\/.)(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g);
        if(res != null)// if (regexp.test(personal_link_url))
        {
            $("#personal_link_url"+id).removeClass("error");
            return true;
        }
        else
        {
            $("#personal_link_url"+id).addClass("error");
            return false;
        }
    };

    $scope.save_user_links = function(){
        $("#user_links_loader").show();
        $("#user_links_save").attr("style","pointer-events:none;display:none;");
        var link_type = $('.link_type').serializeArray();
        var link_url = $('.link_url').serializeArray();
        var err_link = 0;
        link_url.forEach(function(links,idx) {          
          if($scope.check_socialurl(idx) === false)
          {
            err_link = 1;
          }
        });        

        var personal_link_url = $('.personal_link_url').serializeArray();
        personal_link_url.forEach(function(links,idx) {          
          if($scope.check_personalurl(idx) === false)
          {
            err_link = 1;
          }
        });
        if(err_link == 1)
        {
            $("#user_links_save").removeAttr("style");
            $("#user_links_loader").hide();
            return;
        }
        var updatedata = $.param({'link_type':link_type,'link_url':link_url,'personal_link_url':personal_link_url});
        $http({
            method: 'POST',
            url: base_url + 'business_profile_live/save_user_links',                
            data: updatedata,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {                
            // $('#main_page_load').show();                
            success = result.data.success;
            if(success == 1)
            {
                user_social_links_data = result.data.user_social_links_data;
                user_personal_links_data = result.data.user_personal_links_data;
                $scope.user_social_links = user_social_links_data;
                $scope.user_personal_links = user_personal_links_data;
                $scope.social_linksset.social_links = user_social_links_data;
                $scope.personal_linksset.personal_links = user_personal_links_data;
            }
            $("#user_links_save").removeAttr("style");
            $("#user_links_loader").hide();
            $("#social-link").modal('hide');
            var profile_progress = result.data.profile_progress;
            var count_profile_value = profile_progress.user_process_value;
            var count_profile = profile_progress.user_process;
            $scope.progress_status = profile_progress.progress_status;
            $scope.set_progress(count_profile_value,count_profile);
        });
    };

    
    $scope.get_user_links = function()
    {
        $http({
            method: 'POST',
            url: base_url + 'business_profile_live/get_user_links',
            //data: 'u=' + user_id,
            data: 'user_slug=' + user_slug,//Pratik
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                $scope.user_social_links = result.data.user_social_links_data;
                $scope.user_personal_links = result.data.user_personal_links_data;
                $scope.social_linksset.social_links = result.data.user_social_links_data_edit;
                $scope.personal_linksset.personal_links = result.data.user_personal_links_data_edit;
            }
            else
            {
                $scope.user_social_links = [];
                $scope.user_personal_links = [];
            }
            $("#social-link-loader").hide();
            $("#social-link-body").show();

        });
    };
    $scope.get_user_links();
    //Socila Links End

    //User Achieve & Award Start
    $scope.award_date_fnc = function(dob_day,dob_month,dob_year){
        $("#awarddateerror").hide();
        $("#awarddateerror").html('');
        var kcyear = document.getElementsByName("award_year")[0],
        kcmonth = document.getElementsByName("award_month")[0],
        kcday = document.getElementsByName("award_day")[0];                
        
        var d = new Date();
        var n = d.getFullYear();
        year_opt = "";
        for (var i = n; i >= 1950; i--) {
            if(dob_year == i)
            {
                year_opt += "<option value='"+i+"' selected='selected'>"+i+"</option>";
            }
            else
            {                
                year_opt += "<option value='"+i+"'>"+i+"</option>";
            }            
        }
        $("#award_year").html(year_opt);
        
        function validate_date(dob_day,dob_month,dob_year) {
            var y = +kcyear.value;
            if(dob_month != ""){
                var m = dob_month;
            }
            else{
            var m = kcmonth.value;
            }

            if(dob_day != ""){
                var d = dob_day;
            }
            else{                
                var d = kcday.value;
            }
            if (m === "02"){
                var mlength = 28 + (!(y & 3) && ((y % 100) !== 0 || !(y & 15)));
            }
            else{
                var mlength = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][m - 1];
            }

            kcday.length = 0;
            var day_opt = "";
            for (var i = 1; i <= mlength; i++) {
                if(dob_day == i)
                {
                    day_opt += "<option value='"+i+"' selected='selected'>"+i+"</option>";
                }
                else
                {                
                    day_opt += "<option value='"+i+"'>"+i+"</option>";
                }
            }
            $("#award_day").html(day_opt);
        }
        validate_date(dob_day,dob_month,dob_year);
    };
    $scope.award_error = function()
    {
        $("#awarddateerror").hide();
        $("#awarddateerror").html('');
    };

    var award_formdata = new FormData();
    $(document).on('change','#award_file', function(e){
        $("#award_file_error").hide();
        if(this.files[0].size > 10485760)
        {
            $("#award_file_error").html("File size must be less than 10MB.");
            $("#award_file_error").show();
            $(this).val("");
            return true;
        }
        else
        {
            var fileExtension = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF','pdf','PDF','docx','doc'];
            var ext = $(this).val().split('.');        
            if ($.inArray(ext[ext.length - 1].toLowerCase(), fileExtension) !== -1) {             
                award_formdata.append('award_file', $('#award_file')[0].files[0]);
            }
            else {
                $("#award_file_error").html("Invalid file selected.");
                $("#award_file_error").show();
                $(this).val("");
            }         
        }
    });

    $scope.award_validate = {
        rules: {            
            award_title: {
                required: true,
                maxlength: 200,
                minlength: 3
            },            
            award_org: {
                required: true,
                maxlength: 200,
                minlength: 3
            },           
            award_month: {
                required: true,
            },
            award_day: {
                required: true,
            },
            award_year: {
                required: true,
            },
            award_desc: {
                required: true,
                maxlength: 700,
                minlength: 10
            },
        },
        /*groups: {
            publication_date: "publication_year publication_month publication_day"
        },   */     
        messages: {
            award_title: {
                required: "Please enter achievements & awards title",
            },
            award_org: {
                required: "Please enter achievements & awards organization",
            },
            award_month: {
                required: "Please select achievements & awards date",
            },
            award_day: {
                required: "Please select achievements & awards date",
            },
            award_year: {
                required: "Please select achievements & awards date",
            },
            award_desc: {
                required: "Please enter achievements & awards description",
            },

        },
        errorPlacement: function (error, element) {
            /*if (element.attr("name") == "publication_month" || element.attr("name") == "publication_day" || element.attr("name") == "publication_year") {
                error.insertAfter("#publication_year");                
            } else {*/
                error.insertAfter(element);
            // }
        },
    };
    $scope.save_user_award = function(){
        if ($scope.award_form.validate()) {
            $("#user_award_loader").show();
            $("#user_award_save").attr("style","pointer-events:none;display:none;");

            var award_day = $("#award_day option:selected").val();
            var award_month = $("#award_month option:selected").val();
            var award_year = $("#award_year option:selected").val();

            var todaydate = new Date();
            var dd = todaydate.getDate();
            var mm = todaydate.getMonth() + 1;
            var yyyy = todaydate.getFullYear();
            if (dd < 10) {
                dd = '0' + dd
            }

            if (mm < 10) {
                mm = '0' + mm
            }

            var todaydate = yyyy + '/' + mm + '/' + dd;
            var value = award_year + '/' + award_month + '/' + award_day;

            var d1 = Date.parse(todaydate);
            var d2 = Date.parse(value);

            if (d1 < d2) {
                $("#awarddateerror").html("Achievements & Award date always less than to today's date.");
                $("#awarddateerror").show();

                $("#user_award_save").removeAttr("style");
                $("#user_award_loader").hide();
                return false;
            }

            award_formdata.append('edit_awards', $scope.edit_awards);
            award_formdata.append('awards_file_old', $scope.awards_file_old);
            award_formdata.append('award_title', $('#award_title').val());
            award_formdata.append('award_org', $('#award_org').val());            
            award_formdata.append('award_day', award_day);
            award_formdata.append('award_month', award_month);
            award_formdata.append('award_year', award_year);
            award_formdata.append('award_desc', $('#award_desc').val());

            $http.post(base_url + 'business_profile_live/save_user_award', award_formdata,
            {
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined, 'Process-Data': false},
            })
            .then(function (result) {
                if (result) {
                    result = result.data;
                    if(result.success == '1')
                    {
                        $("#user_award_save").removeAttr("style");
                        $("#user_award_loader").hide();
                        $("#award_form")[0].reset();
                        $scope.reset_awards_form();
                        $scope.user_award = result.user_award;
                        $("#Achiv-awards").modal('hide');
                    }
                    else
                    {
                        $("#user_award_save").removeAttr("style");
                        $("#user_award_loader").hide();
                        $("#award_form")[0].reset();
                        $("#Achiv-awards").modal('hide');
                    }
                }
            });
        }
    };

    $scope.get_user_award = function(){
        $http({
            method: 'POST',
            url: base_url + 'business_profile_live/get_user_award',
            //data: 'u=' + user_id,
            data: 'user_slug=' + user_slug,//Pratik
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                user_award = result.data.user_award;
                $scope.user_award = user_award;
                $("#awards-loader").hide();
                $("#awards-body").show();
            }

        });
    }
    $scope.get_user_award();
    $scope.view_more_award = 2;
    $scope.award_view_more = function(){
        $scope.view_more_award = $scope.user_award.length;
        $("#view-more-award").hide();
    };

    $scope.reset_awards_form = function(){
        $scope.edit_awards = 0;
        $scope.awards_file_old = '';
        $("#Achiv-awards").removeClass("edit-form-cus");
        $("#award_day").html("");
        $("#award_year").html("");
        $("#award_file_error").hide();        
        $("#award_file_prev").remove();
        $("#delete_user_award_modal").remove();
        $("#award_form")[0].reset();
        award_formdata = new FormData();
    };
    $scope.edit_user_award = function(index){
        $scope.reset_awards_form();
        $("#Achiv-awards").addClass("edit-form-cus");
        var award_arr = $scope.user_award[index];
        $scope.edit_awards = award_arr.id_award;
        $("#award_title").val(award_arr.award_title);
        $("#award_org").val(award_arr.award_org);        
        var award_date_arr = award_arr.award_date.split("-");
        award_day = award_date_arr[2];
        award_month = award_date_arr[1];
        award_year = award_date_arr[0];
        $("#award_month").val(award_month);
        $scope.award_date_fnc(award_day,award_month,award_year);

        $("#award_desc").val(award_arr.award_desc);

        var award_file_name = award_arr.award_file;
        $scope.awards_file_old = award_file_name;
        if(award_file_name.trim() != "")
        {            
            var filename_arr = award_file_name.split('.');
            $("#award_file_prev").remove();
            var allowed_img_ext = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF'];
            var allowed_doc_ext = ['pdf','PDF','docx','doc'];
            var fileExt = filename_arr[filename_arr.length - 1];
            /*if ($.inArray(fileExt.toLowerCase(), allowed_img_ext) !== -1) {
                var inner_html = '<p id="award_file_prev" class="screen-shot"><a href="'+business_user_award_upload_url+award_file_name+'" target="_blank"><img style="width: 100px;" src="'+business_user_award_upload_url+award_file_name+'"></a></p>';
            }
            else if ($.inArray(fileExt.toLowerCase(), allowed_doc_ext) !== -1) {*/
                var inner_html = '<p id="award_file_prev" class="screen-shot"><a class="file-preview-cus" href="'+business_user_award_upload_url+award_file_name+'" target="_blank"><img src="'+base_url+'assets/n-images/detail/file-up-cus.png"></a></p>';   
            // }

            var contentTr = angular.element(inner_html);
            contentTr.insertAfter($("#award_file_error"));
            $compile(contentTr)($scope);
        }
        setTimeout(function(){  
            $scope.award_form.validate();
        },1000);

        var delete_btn = '<a id="delete_user_award_modal" href="#" data-target="#delete-award-model" data-toggle="modal" class="save delete-edit"><span>Delete</span></a>';
        var contentbtn = angular.element(delete_btn);
        contentbtn.insertAfter($("#user_award_loader"));
        $compile(contentbtn)($scope);
        $("#Achiv-awards").modal("show");
    };

    $scope.delete_user_award = function(){
        $("#delete_user_award").attr("style","pointer-events:none;display:none;");
        $("#user_award_del_loader").show();
        $("#award-delete-btn").hide();
        if($scope.edit_awards != 0)
        {
            var expdata = $.param({'award_id': $scope.edit_awards});
            $http({
                method: 'POST',
                url: base_url + 'business_profile_live/delete_user_award',
                data: expdata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (result) {
                if (result) {
                    result = result.data;
                    if(result.success == '1')
                    {
                        $scope.user_award = result.user_award;
                        $("#delete-award-model").modal('hide');
                        $("#Achiv-awards").modal('hide');
                        $("#delete_user_award").removeAttr("style");
                        $("#user_award_del_loader").hide();
                        $("#award-delete-btn").show();                        
                        $scope.reset_awards_form();
                        // $scope.exp_designation = [];
                        // $("#experience_form")[0].reset();                        
                    }
                    else
                    {
                        $("#delete-award-model").modal('hide');
                        $("#Achiv-awards").modal('hide');
                        $("#delete_user_award").removeAttr("style");
                        $("#user_award_del_loader").hide();
                        $("#award-delete-btn").show();
                        $scope.reset_awards_form();
                        // $scope.exp_designation = [];
                        // $("#experience_form")[0].reset();                        
                    }
                }
            });
        }
    };
    //User Achieve & Award End

    //News / Press Release Start
    $scope.edit_press_release_id = 0;

    $scope.press_release_validate = {
        rules: {            
            press_rel_title: {
                required: true,
                maxlength: 255,
                minlength: 3
            },            
            press_rel_link: {
                required: true,
                maxlength: 255,
                minlength: 3,
                url:true
            },
        },
    };
    $scope.save_press_release = function(){
        if ($scope.press_release_form.validate()) {
            $("#press_release_loader").show();
            $("#save_press_release").attr("style","pointer-events:none;display:none;");
            var press_rel_title = $("#press_rel_title").val();
            var press_rel_link = $("#press_rel_link").val();
            var edit_press_release = $scope.edit_press_release_id;
            var insert_data = $.param({'press_rel_title':press_rel_title,'press_rel_link':press_rel_link,'edit_press_release':edit_press_release});
            $http({
                method: 'POST',
                url: base_url + 'business_profile_live/save_press_release',                
                data: insert_data,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function (result) {                
                // $('#main_page_load').show();                
                success = result.data.success;
                if(success == 1)
                {
                    user_press_release = result.data.user_press_release;                    
                    $scope.user_press_release = user_press_release;
                }
                $("#save_press_release").removeAttr("style");
                $("#press_release_loader").hide();
                $("#press-release").modal('hide');                
            });
        }
    };

    $scope.get_press_release = function(){
        $http({
            method: 'POST',
            url: base_url + 'business_profile_live/get_user_press_release',
            //data: 'u=' + user_id,
            data: 'user_slug=' + user_slug,//Pratik
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                user_press_release = result.data.user_press_release;
                $scope.user_press_release = user_press_release;
                $("#press-release-loader").hide();
                $("#press-release-body").show();
            }

        });
    };
    $scope.get_press_release();

    $scope.view_more_pr = 2;
    $scope.pr_view_more = function(){
        $scope.view_more_pr = $scope.user_press_release.length;
        $("#view-more-pr").hide();
    };
    $scope.reset_press_release = function(){
        $("#press-release").removeClass("edit-form-cus");
        $("#delete_press_releas_modal").remove();
        $scope.edit_press_release_id = 0;
        $("#press_release_form")[0].reset();
    };
    $scope.edit_press_release = function(index){
        $scope.reset_press_release();
        $("#press-release").addClass("edit-form-cus");
        $("#press_release_form")[0].reset();
        var press_release_data = $scope.user_press_release[index];
        $scope.edit_press_release_id = press_release_data.id_news_press_release;
        $("#press_rel_title").val(press_release_data.news_press_release_title);
        $("#press_rel_link").val(press_release_data.news_press_release_link);

        setTimeout(function(){  
            $scope.press_release_form.validate();
        },1000);

        var delete_btn = '<a id="delete_press_releas_modal" href="#" data-target="#delete-pr-model" data-toggle="modal" class="save delete-edit"><span>Delete</span></a>';
        var contentbtn = angular.element(delete_btn);
        contentbtn.insertAfter($("#press_release_loader"));
        $compile(contentbtn)($scope);
        $("#press-release").modal("show");
    };

    $scope.delete_press_release = function(){
        $("#delete_press_release").attr("style","pointer-events:none;display:none;");
        $("#delete_press_release_loader").show();
        $("#pr-delete-btn").hide();
        if($scope.edit_press_release_id != 0)
        {
            var expdata = $.param({'edit_press_release_id': $scope.edit_press_release_id});
            $http({
                method: 'POST',
                url: base_url + 'business_profile_live/delete_press_release',
                data: expdata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (result) {
                if (result) {
                    result = result.data;
                    if(result.success == '1')
                    {
                        $scope.user_press_release = result.user_press_release;
                        $("#delete-pr-model").modal('hide');
                        $("#press-release").modal('hide');
                        $("#delete_press_release").removeAttr("style");
                        $("#delete_press_release_loader").hide();
                        $("#pr-delete-btn").show();                        
                        $scope.reset_press_release();
                    }
                    else
                    {
                        $("#delete-pr-model").modal('hide');
                        $("#press-release").modal('hide');
                        $("#delete_press_release").removeAttr("style");
                        $("#delete_press_release_loader").hide();
                        $("#pr-delete-btn").show();
                        $scope.reset_press_release();
                    }
                }
            });
        }
    };
    //News / Press Release End

    //Business Portfolio Start
    $scope.edit_portfolio_id = 0;
    var portfolio_formdata = new FormData();
    $(document).on('change','#portfolio_file', function(e){
        $("#portfolio_file_error").hide();
        if(this.files[0].size > 10485760)
        {
            $("#portfolio_file_error").html("File size must be less than 10MB.");
            $("#portfolio_file_error").show();
            $(this).val("");
            return true;
        }
        else
        {
            var fileExtension = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF','pdf','PDF','docx','doc'];
            var ext = $(this).val().split('.');        
            if ($.inArray(ext[ext.length - 1].toLowerCase(), fileExtension) !== -1) {             
                portfolio_formdata.append('portfolio_file', $('#portfolio_file')[0].files[0]);
            }
            else {
                $("#portfolio_file_error").html("Invalid file selected.");
                $("#portfolio_file_error").show();
                $(this).val("");
            }         
        }
    });

    $scope.business_portfolio_validate = {
        rules: {            
            portfolio_title: {
                required: true,
                maxlength: 200,
                minlength: 3
            },            
            portfolio_desc: {
                required: true,
                maxlength: 700,
                minlength: 10
            },
        },
    };
    $scope.save_portfolio = function(){
        if ($scope.business_portfolio_form.validate()) {
            $("#portfolio_loader").show();
            $("#portfolio_save").attr("style","pointer-events:none;display:none;");

            portfolio_formdata.append('edit_portfolio_id', $scope.edit_portfolio_id);
            portfolio_formdata.append('portfolio_file_old', $scope.portfolio_file_old);
            portfolio_formdata.append('portfolio_title', $('#portfolio_title').val());
            portfolio_formdata.append('portfolio_desc', $('#portfolio_desc').val());            
            
            $http.post(base_url + 'business_profile_live/save_portfolio', portfolio_formdata,
            {
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined, 'Process-Data': false},
            })
            .then(function (result) {
                if (result) {
                    result = result.data;
                    if(result.success == '1')
                    {
                        $("#portfolio_save").removeAttr("style");
                        $("#portfolio_loader").hide();
                        $("#business_portfolio_form")[0].reset();
                        // $scope.reset_awards_form();
                        $scope.user_portfolio = result.user_portfolio;
                        $("#bus-portfolio").modal('hide');
                    }
                    else
                    {
                        $("#portfolio_save").removeAttr("style");
                        $("#portfolio_loader").hide();
                        $("#business_portfolio_form")[0].reset();
                        $("#bus-portfolio").modal('hide');
                    }
                }
            });
        }
    };

    $scope.get_portfolio = function(){
        $http({
            method: 'POST',
            url: base_url + 'business_profile_live/get_portfolio',
            //data: 'u=' + user_id,
            data: 'user_slug=' + user_slug,//Pratik
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                user_portfolio = result.data.user_portfolio;
                $scope.user_portfolio = user_portfolio;
                $("#portfolio-loader").hide();
                $("#portfolio-body").show();
            }

        });
    }
    $scope.get_portfolio();
    $scope.view_more_port = 2;
    $scope.port_view_more = function(){
        $scope.view_more_port = $scope.user_portfolio.length;
        $("#view-more-pr").hide();
    };
    $scope.reset_portfolio = function(){
        $scope.edit_portfolio_id = 0;
        $scope.portfolio_file_old = '';
        $("#bus-portfolio").removeClass("edit-form-cus");
        $("#portfolio_file_error").hide();        
        $("#portfolio_file_prev").remove();
        $("#delete_user_portfolio_modal").remove();
        $("#business_portfolio_form")[0].reset();
        portfolio_formdata = new FormData();
    };
    $scope.edit_portfolio = function(index){
        $scope.reset_portfolio();
        $("#bus-portfolio").addClass("edit-form-cus");
        var portfolio_data = $scope.user_portfolio[index];        
        $scope.edit_portfolio_id = portfolio_data.id_portfolio;
        $("#portfolio_title").val(portfolio_data.portfolio_title);
        $("#portfolio_desc").val(portfolio_data.portfolio_desc);

        var portfolio_file_name = portfolio_data.portfolio_file;
        $scope.portfolio_file_old = portfolio_file_name;
        if(portfolio_file_name.trim() != "")
        {            
            var filename_arr = portfolio_file_name.split('.');
            $("#portfolio_file_prev").remove();
            var allowed_img_ext = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF'];
            var allowed_doc_ext = ['pdf','PDF','docx','doc'];
            var fileExt = filename_arr[filename_arr.length - 1];
            /*if ($.inArray(fileExt.toLowerCase(), allowed_img_ext) !== -1) {
                var inner_html = '<p id="portfolio_file_prev" class="screen-shot"><a href="'+business_user_portfolio_upload_url+portfolio_file_name+'" target="_blank"><img style="width: 100px;" src="'+business_user_portfolio_upload_url+portfolio_file_name+'"></a></p>';
            }
            else if ($.inArray(fileExt.toLowerCase(), allowed_doc_ext) !== -1) {*/
                var inner_html = '<p id="portfolio_file_prev" class="screen-shot"><a class="file-preview-cus" href="'+business_user_portfolio_upload_url+portfolio_file_name+'" target="_blank"><img src="'+base_url+'assets/n-images/detail/file-up-cus.png"></a></p>';   
            // }

            var contentTr = angular.element(inner_html);
            contentTr.insertAfter($("#portfolio_file_error"));
            $compile(contentTr)($scope);
        }
        setTimeout(function(){  
            $scope.award_form.validate();
        },1000);

        var delete_btn = '<a id="delete_user_portfolio_modal" href="#" data-target="#delete-portfolio-model" data-toggle="modal" class="save delete-edit"><span>Delete</span></a>';
        var contentbtn = angular.element(delete_btn);
        contentbtn.insertAfter($("#portfolio_loader"));
        $compile(contentbtn)($scope);
        $("#bus-portfolio").modal("show");

    };

    $scope.delete_portfolio = function(){
        $("#delete_portfolio").attr("style","pointer-events:none;display:none;");
        $("#delete_portfolio_loader").show();
        $("#portfolio-delete-btn").hide();
        if($scope.edit_portfolio_id != 0)
        {
            var expdata = $.param({'edit_portfolio_id': $scope.edit_portfolio_id});
            $http({
                method: 'POST',
                url: base_url + 'business_profile_live/delete_portfolio',
                data: expdata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (result) {
                if (result) {
                    result = result.data;
                    if(result.success == '1')
                    {
                        $scope.user_portfolio = result.user_portfolio;
                        $("#delete-portfolio-model").modal('hide');
                        $("#bus-portfolio").modal('hide');
                        $("#delete_portfolio").removeAttr("style");
                        $("#delete_portfolio_loader").hide();
                        $("#portfolio-delete-btn").show();                        
                        $scope.reset_portfolio();
                    }
                    else
                    {
                        $("#delete-portfolio-model").modal('hide');
                        $("#bus-portfolio").modal('hide');
                        $("#delete_portfolio").removeAttr("style");
                        $("#delete_portfolio_loader").hide();
                        $("#portfolio-delete-btn").show();
                        $scope.reset_portfolio();
                    }
                }
            });
        }
    };
    //Business Portfolio End

    // Review Start
    $scope.get_review = function(){
        $http({
            method: 'POST',
            url: base_url + 'business_profile_live/get_review',            
            data: 'to_user_id=' + to_user_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                $scope.review_data = result.data.review_data;
                $scope.review_count = result.data.review_count;
                $scope.avarage_review = result.data.avarage_review;                
                setTimeout(function(){
                    $("#avarage_review").val($scope.avarage_review);
                    $("#avarage_review").rating({min:0, max:5, step:0.5, size:'sm',readonly:true});
                    $(".user-rating").rating({min:0, max:5, step:0.5, size:'sm',readonly:true});
                    $("#review-loader").hide();
                    $("#review-body").show();
                },1000);
            }
        });
    };
    $scope.get_review();

    var business_review_formdata = new FormData();
    $(document).on('change','#review_file', function(e){
        $("#review_file_error").hide();
        if(this.files[0].size > 10485760)
        {
            $("#review_file_error").html("File size must be less than 10MB.");
            $("#review_file_error").show();
            $(this).val("");
            return true;
        }
        else
        {
            var fileExtension = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF'];
            var ext = $(this).val().split('.');        
            if ($.inArray(ext[ext.length - 1].toLowerCase(), fileExtension) !== -1) {             
                business_review_formdata.append('review_file', $('#review_file')[0].files[0]);
            }
            else {
                $("#review_file_error").html("Invalid file selected.");
                $("#review_file_error").show();
                $(this).val("");
            }         
        }
    });

    $scope.business_review_validate = {
        rules: {
            review_star: {
                required: true,
            },
            review_desc: {
                required: true,
            },
        },
        messages: {
            review_star: {
                required: "Please select start",
            },
            review_desc: {
                required: "Please enter rating review description",
            },
        },
    };

    $scope.save_review = function(){
        if ($scope.business_review.validate())
        {
            $("#review_loader").show();
            $("#save_review").attr("style","pointer-events:none;display:none;");

            business_review_formdata.append('from_user_id', from_user_id);
            business_review_formdata.append('to_user_id', to_user_id);
            business_review_formdata.append('review_star', $('#review_star').val());
            business_review_formdata.append('review_star', $('#review_star').val());
            business_review_formdata.append('review_desc', $('#review_desc').val());

            $http.post(base_url + 'business_profile_live/save_review', business_review_formdata,
            {
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined, 'Process-Data': false},
            })            
            .then(function (result) {                
                // $('#main_page_load').show();                
                success = result.data.success;
                $("#business_review")[0].reset();
                if(success == 1)
                {
                    $("#review_loader").hide();
                    $("#save_review").removeAttr("style");
                    $scope.review_data = result.data.review_data;
                    $scope.review_count = result.data.review_count;
                    $scope.avarage_review = result.data.avarage_review;                
                    setTimeout(function(){
                        // $("#rating-1").val($scope.avarage_review);
                        $("#avarage_review").rating({min:0, max:5, step:0.5, size:'sm',readonly:true});
                        $('#avarage_review').rating('update', $scope.avarage_review);
                        $(".user-rating").rating({min:0, max:5, step:0.5, size:'sm',readonly:true});
                    },1000);

                    $("#reviews").modal("hide");
                }
                else if(success == 0)
                {                    
                    $("#reviews").modal("hide");
                }
            });
        }
    };
    // Review End

    //How Business Name Started Start
    $story_upload = $('#story-upload').croppie({
        enableExif: true,
        enableResize: true,
        showZoomer:false,
        viewport: {
            width: 1250,
            height: 300,
            type: 'square'
        },
        boundary: {
            width: 1250,
            height: 300
        }
    });
    $(document).on('change','#story_file', function(e){
        $("#story-upload").show();
        $("#upload-file").addClass("story_sel_img");
        var reader = new FileReader();
        reader.onload = function(e) {
            $story_upload.croppie('bind', {
                url: e.target.result
            }).then(function() {
                // console.log('jQuery bind complete');
            });
        }
        reader.readAsDataURL(this.files[0]);
    });
    
    $scope.story_form_validate = {
        rules: {
            story_desc: {
                required: true,
            },
            story_diff: {
                required: true,
            },
        },
    };

    $scope.save_business_story = function(){
        if ($scope.story_form.validate()) {
            $("#save_business_story_loader").show();
            $("#save_business_story").attr("style","pointer-events:none;display:none;");
            $story_upload.croppie('result', {
                type: 'canvas',
                size: 'viewport',
            }).then(function(resp) {

                var story_desc = $("#story_desc").val();
                var story_diff = $("#story_diff").val();
                var story_file = resp;
                var insert_data = $.param({'story_desc':story_desc,'story_diff':story_diff,'story_file':story_file});

                $http({
                    method: 'POST',
                    url: base_url + 'business_profile_live/save_business_story',                
                    data: insert_data,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                })
                .then(function (result) {                
                    // $('#main_page_load').show();                
                    success = result.data.success;
                    if(success == 1)
                    {
                        $scope.story_data = result.data.story_data;
                    }
                    $("#save_business_story").removeAttr("style");
                    $("#save_business_story_loader").hide();
                    $("#bus-name-started").modal('hide');
                });
            });
        }
    };

    $scope.get_business_story = function(){
        $http({
            method: 'POST',
            url: base_url + 'business_profile_live/get_business_story',            
            data: 'user_slug=' + user_slug,//Pratik
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                $scope.story_data = result.data.story_data;
                $("#story-loader").hide();
                $("#story-body").show();
            }
        });
    };
    $scope.get_business_story();


    $scope.edit_business_story = function(){
        // $("#bus-portfolio").addClass("edit-form-cus");
        if($scope.story_data)
        {
            $("#story_desc").val($scope.story_data.story_desc);
            $("#story_diff").val($scope.story_data.story_diff);

            var story_file_name = $scope.story_data.story_file;        
            if(story_file_name.trim() != "")
            {
                $("#upload-file").show();
                var filename_arr = story_file_name.split('.');
                $("#story_file_prev").remove();
                var allowed_img_ext = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF'];
                var allowed_doc_ext = ['pdf','PDF','docx','doc'];
                var fileExt = filename_arr[filename_arr.length - 1];
                /*if ($.inArray(fileExt.toLowerCase(), allowed_img_ext) !== -1) {
                    var inner_html = '<p id="story_file_prev" class="screen-shot"><a href="'+business_user_story_upload_url+story_file_name+'" target="_blank"><img style="width: 100px;" src="'+business_user_story_upload_url+story_file_name+'"></a></p>';
                }
                else if ($.inArray(fileExt.toLowerCase(), allowed_doc_ext) !== -1) {*/
                    var inner_html = '<p id="story_file_prev" class="screen-shot"><a class="file-preview-cus" href="'+business_user_story_upload_url+story_file_name+'" target="_blank"><img src="'+business_user_story_upload_url+story_file_name+'" style="width:100%;"></a></p>';   
                // }

                var contentTr = angular.element(inner_html);
                contentTr.insertAfter($("#upload-file"));
                $compile(contentTr)($scope);
            }
            setTimeout(function(){  
                $scope.award_form.validate();
            },1000);
        }

        $("#bus-name-started").modal("show");
    };

    $scope.open_business_story = function(){
        // $("#bus-portfolio").addClass("edit-form-cus");
        if($scope.story_data)
        {
            var story_file_name = $scope.story_data.story_file;        
            if(story_file_name.trim() != "")
            {
                var filename_arr = story_file_name.split('.');
                $("#story_file_prev1").remove();
                var allowed_img_ext = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF'];
                var allowed_doc_ext = ['pdf','PDF','docx','doc'];
                var fileExt = filename_arr[filename_arr.length - 1];
                /*if ($.inArray(fileExt.toLowerCase(), allowed_img_ext) !== -1) {
                    var inner_html = '<p id="story_file_prev" class="screen-shot"><a href="'+business_user_story_upload_url+story_file_name+'" target="_blank"><img style="width: 100px;" src="'+business_user_story_upload_url+story_file_name+'"></a></p>';
                }
                else if ($.inArray(fileExt.toLowerCase(), allowed_doc_ext) !== -1) {*/
                    var inner_html = '<p id="story_file_prev1" class="screen-shot"><a class="file-preview-cus" href="'+business_user_story_upload_url+story_file_name+'" target="_blank"><img src="'+business_user_story_upload_url+story_file_name+'" style="width:100%;"></a></p>';   
                // }

                var contentTr = angular.element(inner_html);
                contentTr.insertAfter($("#upload-file1"));
                $compile(contentTr)($scope);
            }
        }

        $("#bus-name-started-display").modal("show");
    };
    //How Business Name Started End

    //Timeline Start
    $scope.set_timeline = function()
    {
        var timelines = $('.cd-horizontal-timeline'),
            eventsMinDistance = 100;

        (timelines.length > 0) && initTimeline(timelines);

        function initTimeline(timelines) {
            timelines.each(function(){
                var timeline = $(this),
                    timelineComponents = {};
                //cache timeline components 
                timelineComponents['timelineWrapper'] = timeline.find('.events-wrapper');
                timelineComponents['eventsWrapper'] = timelineComponents['timelineWrapper'].children('.events');
                timelineComponents['fillingLine'] = timelineComponents['eventsWrapper'].children('.filling-line');
                timelineComponents['timelineEvents'] = timelineComponents['eventsWrapper'].find('a');
                timelineComponents['timelineDates'] = parseDate(timelineComponents['timelineEvents']);
                timelineComponents['eventsMinLapse'] = minLapse(timelineComponents['timelineDates']);
                timelineComponents['timelineNavigation'] = timeline.find('.cd-timeline-navigation');
                timelineComponents['eventsContent'] = timeline.children('.events-content');

                //assign a left postion to the single events along the timeline
                setDatePosition(timelineComponents, eventsMinDistance);
                //assign a width to the timeline
                var timelineTotWidth = setTimelineWidth(timelineComponents, eventsMinDistance);
                //the timeline has been initialize - show it
                timeline.addClass('loaded');

                //detect click on the next arrow
                timelineComponents['timelineNavigation'].on('click', '.next', function(event){
                    event.preventDefault();
                    updateSlide(timelineComponents, timelineTotWidth, 'next');
                });
                //detect click on the prev arrow
                timelineComponents['timelineNavigation'].on('click', '.prev', function(event){
                    event.preventDefault();
                    updateSlide(timelineComponents, timelineTotWidth, 'prev');
                });
                //detect click on the a single event - show new event content
                timelineComponents['eventsWrapper'].on('click', 'a', function(event){
                    event.preventDefault();
                    timelineComponents['timelineEvents'].removeClass('selected');
                    $(this).addClass('selected');
                    updateOlderEvents($(this));
                    updateFilling($(this), timelineComponents['fillingLine'], timelineTotWidth);
                    updateVisibleContent($(this), timelineComponents['eventsContent']);
                });

                //on swipe, show next/prev event content
                timelineComponents['eventsContent'].on('swipeleft', function(){
                    var mq = checkMQ();
                    ( mq == 'mobile' ) && showNewContent(timelineComponents, timelineTotWidth, 'next');
                });
                timelineComponents['eventsContent'].on('swiperight', function(){
                    var mq = checkMQ();
                    ( mq == 'mobile' ) && showNewContent(timelineComponents, timelineTotWidth, 'prev');
                });

                //keyboard navigation
                /*$(document).keyup(function(event){
                    if(event.which=='37' && elementInViewport(timeline.get(0)) ) {
                        showNewContent(timelineComponents, timelineTotWidth, 'prev');
                    } else if( event.which=='39' && elementInViewport(timeline.get(0))) {
                        showNewContent(timelineComponents, timelineTotWidth, 'next');
                    }
                });*/
            });
        }

        function updateSlide(timelineComponents, timelineTotWidth, string) {
            //retrieve translateX value of timelineComponents['eventsWrapper']
            var translateValue = getTranslateValue(timelineComponents['eventsWrapper']),
                wrapperWidth = Number(timelineComponents['timelineWrapper'].css('width').replace('px', ''));
            //translate the timeline to the left('next')/right('prev') 
            (string == 'next') 
                ? translateTimeline(timelineComponents, translateValue - wrapperWidth + eventsMinDistance, wrapperWidth - timelineTotWidth)
                : translateTimeline(timelineComponents, translateValue + wrapperWidth - eventsMinDistance);
        }

        function showNewContent(timelineComponents, timelineTotWidth, string) {
            //go from one event to the next/previous one
            var visibleContent =  timelineComponents['eventsContent'].find('.selected'),
                newContent = ( string == 'next' ) ? visibleContent.next() : visibleContent.prev();

            if ( newContent.length > 0 ) { //if there's a next/prev event - show it
                var selectedDate = timelineComponents['eventsWrapper'].find('.selected'),
                    newEvent = ( string == 'next' ) ? selectedDate.parent('li').next('li').children('a') : selectedDate.parent('li').prev('li').children('a');
                
                updateFilling(newEvent, timelineComponents['fillingLine'], timelineTotWidth);
                updateVisibleContent(newEvent, timelineComponents['eventsContent']);
                newEvent.addClass('selected');
                selectedDate.removeClass('selected');
                updateOlderEvents(newEvent);
                updateTimelinePosition(string, newEvent, timelineComponents);
            }
        }

        function updateTimelinePosition(string, event, timelineComponents) {
            //translate timeline to the left/right according to the position of the selected event
            var eventStyle = window.getComputedStyle(event.get(0), null),
                eventLeft = Number(eventStyle.getPropertyValue("left").replace('px', '')),
                timelineWidth = Number(timelineComponents['timelineWrapper'].css('width').replace('px', '')),
                timelineTotWidth = Number(timelineComponents['eventsWrapper'].css('width').replace('px', ''));
            var timelineTranslate = getTranslateValue(timelineComponents['eventsWrapper']);

            if( (string == 'next' && eventLeft > timelineWidth - timelineTranslate) || (string == 'prev' && eventLeft < - timelineTranslate) ) {
                translateTimeline(timelineComponents, - eventLeft + timelineWidth/2, timelineWidth - timelineTotWidth);
            }
        }

        function translateTimeline(timelineComponents, value, totWidth) {
            var eventsWrapper = timelineComponents['eventsWrapper'].get(0);
            value = (value > 0) ? 0 : value; //only negative translate value
            value = ( !(typeof totWidth === 'undefined') &&  value < totWidth ) ? totWidth : value; //do not translate more than timeline width
            setTransformValue(eventsWrapper, 'translateX', value+'px');
            //update navigation arrows visibility
            (value == 0 ) ? timelineComponents['timelineNavigation'].find('.prev').addClass('inactive') : timelineComponents['timelineNavigation'].find('.prev').removeClass('inactive');
            (value == totWidth ) ? timelineComponents['timelineNavigation'].find('.next').addClass('inactive') : timelineComponents['timelineNavigation'].find('.next').removeClass('inactive');
        }

        function updateFilling(selectedEvent, filling, totWidth) {
            //change .filling-line length according to the selected event
            var eventStyle = window.getComputedStyle(selectedEvent.get(0), null),
                eventLeft = eventStyle.getPropertyValue("left"),
                eventWidth = eventStyle.getPropertyValue("width");
            eventLeft = Number(eventLeft.replace('px', '')) + Number(eventWidth.replace('px', ''))/2;
            var scaleValue = eventLeft/totWidth;
            setTransformValue(filling.get(0), 'scaleX', scaleValue);
        }

        function setDatePosition(timelineComponents, min) {
            for (i = 0; i < timelineComponents['timelineDates'].length; i++) { 
                var distance = daydiff(timelineComponents['timelineDates'][0], timelineComponents['timelineDates'][i]),
                    distanceNorm = Math.round(distance/timelineComponents['eventsMinLapse']) + 2;
                timelineComponents['timelineEvents'].eq(i).css('left', distanceNorm*min+'px');
            }
        }

        function setTimelineWidth(timelineComponents, width) {
            var timeSpan = daydiff(timelineComponents['timelineDates'][0], timelineComponents['timelineDates'][timelineComponents['timelineDates'].length-1]),
                timeSpanNorm = timeSpan/timelineComponents['eventsMinLapse'],
                timeSpanNorm = Math.round(timeSpanNorm) + 4,
                totalWidth = timeSpanNorm*width;
            timelineComponents['eventsWrapper'].css('width', totalWidth+'px');
            updateFilling(timelineComponents['eventsWrapper'].find('a.selected'), timelineComponents['fillingLine'], totalWidth);
            updateTimelinePosition('next', timelineComponents['eventsWrapper'].find('a.selected'), timelineComponents);
        
            return totalWidth;
        }

        function updateVisibleContent(event, eventsContent) {
            var eventDate = event.data('date'),
                visibleContent = eventsContent.find('.selected'),
                selectedContent = eventsContent.find('[data-date="'+ eventDate +'"]'),
                selectedContentHeight = selectedContent.height();

            if (selectedContent.index() > visibleContent.index()) {
                var classEnetering = 'selected enter-right',
                    classLeaving = 'leave-left';
            } else {
                var classEnetering = 'selected enter-left',
                    classLeaving = 'leave-right';
            }

            selectedContent.attr('class', classEnetering);
            visibleContent.attr('class', classLeaving).one('webkitAnimationEnd oanimationend msAnimationEnd animationend', function(){
                visibleContent.removeClass('leave-right leave-left');
                selectedContent.removeClass('enter-left enter-right');
            });
            eventsContent.css('height', selectedContentHeight+'px');
        }

        function updateOlderEvents(event) {
            event.parent('li').prevAll('li').children('a').addClass('older-event').end().end().nextAll('li').children('a').removeClass('older-event');
        }

        function getTranslateValue(timeline) {
            var timelineStyle = window.getComputedStyle(timeline.get(0), null),
                timelineTranslate = timelineStyle.getPropertyValue("-webkit-transform") ||
                    timelineStyle.getPropertyValue("-moz-transform") ||
                    timelineStyle.getPropertyValue("-ms-transform") ||
                    timelineStyle.getPropertyValue("-o-transform") ||
                    timelineStyle.getPropertyValue("transform");

            if( timelineTranslate.indexOf('(') >=0 ) {
                var timelineTranslate = timelineTranslate.split('(')[1];
                timelineTranslate = timelineTranslate.split(')')[0];
                timelineTranslate = timelineTranslate.split(',');
                var translateValue = timelineTranslate[4];
            } else {
                var translateValue = 0;
            }

            return Number(translateValue);
        }

        function setTransformValue(element, property, value) {
            element.style["-webkit-transform"] = property+"("+value+")";
            element.style["-moz-transform"] = property+"("+value+")";
            element.style["-ms-transform"] = property+"("+value+")";
            element.style["-o-transform"] = property+"("+value+")";
            element.style["transform"] = property+"("+value+")";
        }

        //based on http://stackoverflow.com/questions/542938/how-do-i-get-the-number-of-days-between-two-dates-in-javascript
        function parseDate(events) {
            var dateArrays = [];
            events.each(function(){
                var singleDate = $(this),
                    dateComp = singleDate.data('date').split('T');
                if( dateComp.length > 1 ) { //both DD/MM/YEAR and time are provided
                    var dayComp = dateComp[0].split('/'),
                        timeComp = dateComp[1].split(':');
                } else if( dateComp[0].indexOf(':') >=0 ) { //only time is provide
                    var dayComp = ["2000", "0", "0"],
                        timeComp = dateComp[0].split(':');
                } else { //only DD/MM/YEAR
                    var dayComp = dateComp[0].split('/'),
                        timeComp = ["0", "0"];
                }
                var newDate = new Date(dayComp[2], dayComp[1]-1, dayComp[0], timeComp[0], timeComp[1]);
                dateArrays.push(newDate);
            });
            return dateArrays;
        }

        function daydiff(first, second) {
            return Math.round((second-first));
        }

        function minLapse(dates) {
            //determine the minimum distance among events
            var dateDistances = [];
            for (i = 1; i < dates.length; i++) { 
                var distance = daydiff(dates[i-1], dates[i]);
                dateDistances.push(distance);
            }
            return Math.min.apply(null, dateDistances);
        }

        /*
            How to tell if a DOM element is visible in the current viewport?
            http://stackoverflow.com/questions/123999/how-to-tell-if-a-dom-element-is-visible-in-the-current-viewport
        */
        function elementInViewport(el) {
            var top = el.offsetTop;
            var left = el.offsetLeft;
            var width = el.offsetWidth;
            var height = el.offsetHeight;

            while(el.offsetParent) {
                el = el.offsetParent;
                top += el.offsetTop;
                left += el.offsetLeft;
            }

            return (
                top < (window.pageYOffset + window.innerHeight) &&
                left < (window.pageXOffset + window.innerWidth) &&
                (top + height) > window.pageYOffset &&
                (left + width) > window.pageXOffset
            );
        }

        function checkMQ() {
            //check if mobile or desktop device
            return window.getComputedStyle(document.querySelector('.cd-horizontal-timeline'), '::before').getPropertyValue('content').replace(/'/g, "").replace(/"/g, "");
        }

    };

    $scope.selected_timeline = 0;
    $scope.select_timeline_item = 0;
    $scope.select_timeline = function(idx){
        $scope.select_timeline_item = idx;
    };
    $scope.get_business_timeline = function(){
        $http({
            method: 'POST',
            url: base_url + 'business_profile_live/get_business_timeline',
            data: 'user_slug=' + user_slug,//Pratik
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                $scope.timeline_data = result.data.timeline_data;
                setTimeout(function(){
                    $scope.set_timeline();
                },1000);
                $("#timeline-loader").hide();
                $("#timeline-body").show();
            }
        });
    };
    $scope.get_business_timeline();

    $scope.timeline_error = function()
    {
        $("#timelinedateerror").hide();
        $("#timelinedateerror").html('');
    };

    $scope.timeline_date_fnc = function(dob_day,dob_month,dob_year){
        $("#timelinedateerror").hide();
        $("#timelinedateerror").html('');
        var kcyear = document.getElementsByName("timeline_year")[0],
        kcmonth = document.getElementsByName("timeline_month")[0],
        kcday = document.getElementsByName("timeline_day")[0];                
        
        var d = new Date();
        var n = d.getFullYear();
        year_opt = "";
        for (var i = n; i >= 1950; i--) {
            if(dob_year == i)
            {
                year_opt += "<option value='"+i+"' selected='selected'>"+i+"</option>";
            }
            else
            {                
                year_opt += "<option value='"+i+"'>"+i+"</option>";
            }            
        }
        $("#timeline_year").html(year_opt);
        
        function validate_date(dob_day,dob_month,dob_year) {
            var y = +kcyear.value;
            if(dob_month != ""){
                var m = dob_month;
            }
            else{
            var m = kcmonth.value;
            }

            if(dob_day != ""){
                var d = dob_day;
            }
            else{                
                var d = kcday.value;
            }
            if (m === "02"){
                var mlength = 28 + (!(y & 3) && ((y % 100) !== 0 || !(y & 15)));
            }
            else{
                var mlength = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][m - 1];
            }

            kcday.length = 0;
            var day_opt = "";
            for (var i = 1; i <= mlength; i++) {
                if(dob_day == i)
                {
                    day_opt += "<option value='"+i+"' selected='selected'>"+i+"</option>";
                }
                else
                {                
                    day_opt += "<option value='"+i+"'>"+i+"</option>";
                }
            }
            $("#timeline_day").html(day_opt);
        }
        validate_date(dob_day,dob_month,dob_year);
    };

    var timeline_formdata = new FormData();
    $(document).on('change','#timeline_file', function(e){
        $("#timeline_file_error").hide();
        if(this.files[0].size > 10485760)
        {
            $("#timeline_file_error").html("File size must be less than 10MB.");
            $("#timeline_file_error").show();
            $(this).val("");
            return true;
        }
        else
        {
            var fileExtension = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF','pdf','PDF','docx','doc'];
            var ext = $(this).val().split('.');        
            if ($.inArray(ext[ext.length - 1].toLowerCase(), fileExtension) !== -1) {             
                timeline_formdata.append('timeline_file', $('#timeline_file')[0].files[0]);
            }
            else {
                $("#timeline_file_error").html("Invalid file selected.");
                $("#timeline_file_error").show();
                $(this).val("");
            }         
        }
    });

    $scope.timeline_validate = {
        rules: {            
            timeline_title: {
                required: true,
                maxlength: 200,
                minlength: 3
            },            
            timeline_desc: {
                required: true,
                maxlength: 700,
                minlength: 10
            },
            timeline_month: {
                required: true,
            },
            timeline_day: {
                required: true,
            },
            timeline_year: {
                required: true,
            },
        },
    };
    $scope.edit_timeline_id = 0;
    $scope.timeline_file_old = "";
    $scope.save_timeline = function(){
        if ($scope.timeline_form.validate()) {
            $("#timeline_loader").show();
            $("#save_timeline").attr("style","pointer-events:none;display:none;");

            var timeline_day = $("#timeline_day option:selected").val();
            var timeline_month = $("#timeline_month option:selected").val();
            var timeline_year = $("#timeline_year option:selected").val();

            var todaydate = new Date();
            var dd = todaydate.getDate();
            var mm = todaydate.getMonth() + 1;
            var yyyy = todaydate.getFullYear();
            if (dd < 10) {
                dd = '0' + dd
            }

            if (mm < 10) {
                mm = '0' + mm
            }

            var todaydate = yyyy + '/' + mm + '/' + dd;
            var value = timeline_year + '/' + timeline_month + '/' + timeline_day;

            var d1 = Date.parse(todaydate);
            var d2 = Date.parse(value);

            if (d1 < d2) {
                $("#timelinedateerror").html("Timeline date always less than to today's date.");
                $("#timelinedateerror").show();

                $("#user_timeline_save").removeAttr("style");
                $("#user_timeline_loader").hide();
                return false;
            }

            timeline_formdata.append('edit_timeline_id', $scope.edit_timeline_id);
            timeline_formdata.append('timeline_file_old', $scope.timeline_file_old);
            timeline_formdata.append('timeline_title', $('#timeline_title').val());
            timeline_formdata.append('timeline_day', timeline_day);
            timeline_formdata.append('timeline_month', timeline_month);
            timeline_formdata.append('timeline_year', timeline_year);
            timeline_formdata.append('timeline_desc', $('#timeline_desc').val());            
            
            $http.post(base_url + 'business_profile_live/save_timeline', timeline_formdata,
            {
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined, 'Process-Data': false},
            })
            .then(function (result) {
                if (result) {
                    result = result.data;
                    if(result.success == '1')
                    {
                        $("#save_timeline").removeAttr("style");
                        $("#timeline_loader").hide();
                        $("#timeline_form")[0].reset();                        
                        $scope.timeline_data = result.timeline_data;
                        setTimeout(function(){
                            $scope.set_timeline();
                            // $scope.selected_timeline = 0;
                        },1000);
                        $("#timeline").modal('hide');
                    }
                    else
                    {
                        $("#save_timeline").removeAttr("style");
                        $("#timeline_loader").hide();
                        $("#timeline_form")[0].reset();
                        $("#timeline").modal('hide');
                    }
                }
            });
        }
    };

    $scope.reset_timeline_form = function(){
        $scope.edit_timeline_id = 0;
        $scope.timeline_file_old = '';
        $("#timeline").removeClass("edit-form-cus");
        $("#timeline_day").html("");
        $("#timeline_year").html("");
        $("#timeline_file_error").hide();        
        $("#timeline_file_prev").remove();
        $("#delete_user_timeline_modal").remove();
        $("#timeline_form")[0].reset();
        timeline_formdata = new FormData();
    };
    $scope.edit_timeline = function(main_index,inner_index){
        $scope.reset_timeline_form();
        $("#timeline").addClass("edit-form-cus");        
        var timeline_arr = $scope.timeline_data[main_index].timeline_inner_data[inner_index];
        $scope.edit_timeline_id = timeline_arr.id_timeline;
        $("#timeline_title").val(timeline_arr.timeline_title);
        $("#timeline_desc").val(timeline_arr.timeline_desc);        
        var timeline_date_arr = timeline_arr.timeline_date.split("-");
        timeline_day = timeline_date_arr[2];
        timeline_month = timeline_date_arr[1];
        timeline_year = timeline_date_arr[0];
        $("#timeline_month").val(timeline_month);
        $scope.timeline_date_fnc(timeline_day,timeline_month,timeline_year);

        var timeline_file_name = timeline_arr.timeline_file;
        $scope.timeline_file_old = timeline_file_name;
        if(timeline_file_name.trim() != "")
        {            
            var filename_arr = timeline_file_name.split('.');
            $("#timeline_file_prev").remove();
            var allowed_img_ext = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF'];
            var allowed_doc_ext = ['pdf','PDF','docx','doc'];
            var fileExt = filename_arr[filename_arr.length - 1];
            /*if ($.inArray(fileExt.toLowerCase(), allowed_img_ext) !== -1) {
                var inner_html = '<p id="timeline_file_prev" class="screen-shot"><a href="'+business_user_timeline_upload_url+timeline_file_name+'" target="_blank"><img style="width: 100px;" src="'+business_user_timeline_upload_url+timeline_file_name+'"></a></p>';
            }
            else if ($.inArray(fileExt.toLowerCase(), allowed_doc_ext) !== -1) {*/
                var inner_html = '<p id="timeline_file_prev" class="screen-shot"><a class="file-preview-cus" href="'+business_user_timeline_upload_url+timeline_file_name+'" target="_blank"><img src="'+base_url+'assets/n-images/detail/file-up-cus.png"></a></p>';   
            // }

            var contentTr = angular.element(inner_html);
            contentTr.insertAfter($("#timeline_file_error"));
            $compile(contentTr)($scope);
        }
        setTimeout(function(){  
            $scope.timeline_form.validate();
        },1000);

        var delete_btn = '<a id="delete_user_timeline_modal" href="#" data-target="#delete-timeline-model" data-toggle="modal" class="save delete-edit"><span>Delete</span></a>';
        var contentbtn = angular.element(delete_btn);
        contentbtn.insertAfter($("#timeline_loader"));
        $compile(contentbtn)($scope);
        $("#timeline").modal("show");
    };

    $scope.delete_timeline = function(){
        $("#delete_timeline").attr("style","pointer-events:none;display:none;");
        $("#delete_timeline_loader").show();
        $("#timeline-delete-btn").hide();
        if($scope.edit_timeline_id != 0)
        {
            var expdata = $.param({'edit_timeline_id': $scope.edit_timeline_id});
            $http({
                method: 'POST',
                url: base_url + 'business_profile_live/delete_timeline',
                data: expdata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (result) {
                if (result) {
                    result = result.data;
                    if(result.success == '1')
                    {
                        $scope.timeline_data = result.timeline_data;
                        $("#delete-timeline-model").modal('hide');
                        $("#timeline").modal('hide');
                        $("#delete_timeline").removeAttr("style");
                        $("#delete_timeline_loader").hide();
                        $("#timeline-delete-btn").show();                        
                        $scope.reset_timeline_form();                       
                    }
                    else
                    {
                        $("#delete-timeline-model").modal('hide');
                        $("#timeline").modal('hide');
                        $("#delete_timeline").removeAttr("style");
                        $("#delete_timeline_loader").hide();
                        $("#timeline-delete-btn").show();
                        $scope.reset_timeline_form();
                    }
                }
            });
        }
    };
    //Timeline End

    //Job Opening Start
    $scope.get_business_job_opening = function(){
        $http({
            method: 'POST',
            url: base_url + 'business_profile_live/get_business_job_opening',
            data: 'user_slug=' + user_slug,//Pratik
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                $scope.jobs_data = result.data.jobs_data;
                $scope.rec_profile = result.data.rec_profile;
                $("#jobs-loader").hide();
                $("#jobs-body").show();
            }
        });
    };
    $scope.get_business_job_opening();
    //Job Opening End

    //Hours of Operation Start
    $scope.change_opening_hour = function()
    {
        if($scope.opening_hour == '2')
        {
            $("#specified_day_div").show();
        }
        else
        {
            $("#specified_day_div").hide();
        }
    };

    $scope.opening_hours_validate = {
        rules: {            
            opening_hour: {
                required: true,               
            },
            sun_from_time: {
                required: {
                    depends: function(element) {
                        return $("#opening_hour option:selected").val() == 2 ? true : false;
                    }
                },
            },
            sun_from_ap: {
                required: {
                    depends: function(element) {
                        return $("#opening_hour option:selected").val() == 2 ? true : false;
                    }
                },
            },
            sun_to_time: {
                required: {
                    depends: function(element) {
                        return $("#opening_hour option:selected").val() == 2 ? true : false;
                    }
                },
            },
            sun_to_ap: {
                required: {
                    depends: function(element) {
                        return $("#opening_hour option:selected").val() == 2 ? true : false;
                    }
                },
            },
            mon_from_time: {
                required: {
                    depends: function(element) {
                        return $("#opening_hour option:selected").val() == 2 ? true : false;
                    }
                },
            },
            mon_from_ap: {
                required: {
                    depends: function(element) {
                        return $("#opening_hour option:selected").val() == 2 ? true : false;
                    }
                },
            },
            mon_to_time: {
                required: {
                    depends: function(element) {
                        return $("#opening_hour option:selected").val() == 2 ? true : false;
                    }
                },
            },
            mon_to_ap: {
                required: {
                    depends: function(element) {
                        return $("#opening_hour option:selected").val() == 2 ? true : false;
                    }
                },
            },
            tue_from_time: {
                required: {
                    depends: function(element) {
                        return $("#opening_hour option:selected").val() == 2 ? true : false;
                    }
                },
            },
            tue_from_ap: {
                required: {
                    depends: function(element) {
                        return $("#opening_hour option:selected").val() == 2 ? true : false;
                    }
                },
            },
            tue_to_time: {
                required: {
                    depends: function(element) {
                        return $("#opening_hour option:selected").val() == 2 ? true : false;
                    }
                },
            },
            tue_to_ap: {
                required: {
                    depends: function(element) {
                        return $("#opening_hour option:selected").val() == 2 ? true : false;
                    }
                },
            },
            wed_from_time: {
                required: {
                    depends: function(element) {
                        return $("#opening_hour option:selected").val() == 2 ? true : false;
                    }
                },
            },
            wed_from_ap: {
                required: {
                    depends: function(element) {
                        return $("#opening_hour option:selected").val() == 2 ? true : false;
                    }
                },
            },
            wed_to_time: {
                required: {
                    depends: function(element) {
                        return $("#opening_hour option:selected").val() == 2 ? true : false;
                    }
                },
            },
            wed_to_ap: {
                required: {
                    depends: function(element) {
                        return $("#opening_hour option:selected").val() == 2 ? true : false;
                    }
                },
            },
            thu_from_time: {
                required: {
                    depends: function(element) {
                        return $("#opening_hour option:selected").val() == 2 ? true : false;
                    }
                },
            },
            thu_from_ap: {
                required: {
                    depends: function(element) {
                        return $("#opening_hour option:selected").val() == 2 ? true : false;
                    }
                },
            },
            thu_to_time: {
                required: {
                    depends: function(element) {
                        return $("#opening_hour option:selected").val() == 2 ? true : false;
                    }
                },
            },
            thu_to_ap: {
                required: {
                    depends: function(element) {
                        return $("#opening_hour option:selected").val() == 2 ? true : false;
                    }
                },
            },
            fri_from_time: {
                required: {
                    depends: function(element) {
                        return $("#opening_hour option:selected").val() == 2 ? true : false;
                    }
                },
            },
            fri_from_ap: {
                required: {
                    depends: function(element) {
                        return $("#opening_hour option:selected").val() == 2 ? true : false;
                    }
                },
            },
            fri_to_time: {
                required: {
                    depends: function(element) {
                        return $("#opening_hour option:selected").val() == 2 ? true : false;
                    }
                },
            },
            fri_to_ap: {
                required: {
                    depends: function(element) {
                        return $("#opening_hour option:selected").val() == 2 ? true : false;
                    }
                },
            },
            sat_from_time: {
                required: {
                    depends: function(element) {
                        return $("#opening_hour option:selected").val() == 2 ? true : false;
                    }
                },
            },
            sat_from_ap: {
                required: {
                    depends: function(element) {
                        return $("#opening_hour option:selected").val() == 2 ? true : false;
                    }
                },
            },
            sat_to_time: {
                required: {
                    depends: function(element) {
                        return $("#opening_hour option:selected").val() == 2 ? true : false;
                    }
                },
            },
            sat_to_ap: {
                required: {
                    depends: function(element) {
                        return $("#opening_hour option:selected").val() == 2 ? true : false;
                    }
                },
            },
        },
    };
    $scope.save_opening_hours = function(){
        if ($scope.opening_hours_form.validate()) {
            $("#opening_hours_loader").show();
            $("#save_opening_hours").attr("style","pointer-events:none;display:none;");

            var opening_hour = $("#opening_hour option:selected").val();

            var insert_data = $.param({
                'opening_hour': opening_hour,
                'sun_from_time': $("#sun_from_time option:selected").val(),
                'sun_from_ap': $("#sun_from_ap option:selected").val(),
                'sun_to_time': $("#sun_to_time option:selected").val(),
                'sun_to_ap': $("#sun_to_ap option:selected").val(),

                'mon_from_time': $("#mon_from_time option:selected").val(),
                'mon_from_ap': $("#mon_from_ap option:selected").val(),
                'mon_to_time': $("#mon_to_time option:selected").val(),
                'mon_to_ap': $("#mon_to_ap option:selected").val(),

                'tue_from_time': $("#tue_from_time option:selected").val(),
                'tue_from_ap': $("#tue_from_ap option:selected").val(),
                'tue_to_time': $("#tue_to_time option:selected").val(),
                'tue_to_ap': $("#tue_to_ap option:selected").val(),

                'wed_from_time': $("#wed_from_time option:selected").val(),
                'wed_from_ap': $("#wed_from_ap option:selected").val(),
                'wed_to_time': $("#wed_to_time option:selected").val(),
                'wed_to_ap': $("#wed_to_ap option:selected").val(),

                'thu_from_time': $("#thu_from_time option:selected").val(),
                'thu_from_ap': $("#thu_from_ap option:selected").val(),
                'thu_to_time': $("#thu_to_time option:selected").val(),
                'thu_to_ap': $("#thu_to_ap option:selected").val(),

                'fri_from_time': $("#fri_from_time option:selected").val(),
                'fri_from_ap': $("#fri_from_ap option:selected").val(),
                'fri_to_time': $("#fri_to_time option:selected").val(),
                'fri_to_ap': $("#fri_to_ap option:selected").val(),

                'sat_from_time': $("#sat_from_time option:selected").val(),
                'sat_from_ap': $("#sat_from_ap option:selected").val(),
                'sat_to_time': $("#sat_to_time option:selected").val(),
                'sat_to_ap': $("#sat_to_ap option:selected").val()                
            });

            $http({
                method: 'POST',
                url: base_url + 'business_profile_live/save_opening_hours',                
                data: insert_data,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function (result) {                
                // $('#main_page_load').show();                
                success = result.data.success;
                if(success == 1)
                {
                    $scope.bus_opening_hours = result.data.bus_opening_hours;
                }
                $("#save_opening_hours").removeAttr("style");
                $("#opening_hours_loader").hide();
                $("#hours-opration").modal('hide'); 
            });
        }
    };

    $scope.get_opening_hours = function(){
        $http({
            method: 'POST',
            url: base_url + 'business_profile_live/get_opening_hours',
            data: 'user_slug=' + user_slug,//Pratik
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                $scope.bus_opening_hours = result.data.bus_opening_hours;                
            }
            $("#hours-loader").hide();
            $("#hours-body").show();
        });
    };
    $scope.get_opening_hours();

    $scope.edit_opening_hours = function(main_index,inner_index){
        var opening_hours_arr = $scope.bus_opening_hours;
        if(opening_hours_arr)
        {
            $("#opening_hour").val(opening_hours_arr.opening_hour);
            if(opening_hours_arr.opening_hour == 2)
            {
                $("#specified_day_div").show();
                $("#sun_from_time").val(opening_hours_arr.sun_from_time);
                $("#sun_from_ap").val(opening_hours_arr.sun_from_ap);
                $("#sun_to_time").val(opening_hours_arr.sun_to_time);
                $("#sun_to_ap").val(opening_hours_arr.sun_to_ap);

                $("#mon_from_time").val(opening_hours_arr.mon_from_time);
                $("#mon_from_ap").val(opening_hours_arr.mon_from_ap);
                $("#mon_to_time").val(opening_hours_arr.mon_to_time);
                $("#mon_to_ap").val(opening_hours_arr.mon_to_ap);

                $("#tue_from_time").val(opening_hours_arr.tue_from_time);
                $("#tue_from_ap").val(opening_hours_arr.tue_from_ap);
                $("#tue_to_time").val(opening_hours_arr.tue_to_time);
                $("#tue_to_ap").val(opening_hours_arr.tue_to_ap);

                $("#wed_from_time").val(opening_hours_arr.wed_from_time);
                $("#wed_from_ap").val(opening_hours_arr.wed_from_ap);
                $("#wed_to_time").val(opening_hours_arr.wed_to_time);
                $("#wed_to_ap").val(opening_hours_arr.wed_to_ap);

                $("#thu_from_time").val(opening_hours_arr.thu_from_time);
                $("#thu_from_ap").val(opening_hours_arr.thu_from_ap);
                $("#thu_to_time").val(opening_hours_arr.thu_to_time);
                $("#thu_to_ap").val(opening_hours_arr.thu_to_ap);

                $("#fri_from_time").val(opening_hours_arr.fri_from_time);
                $("#fri_from_ap").val(opening_hours_arr.fri_from_ap);
                $("#fri_to_time").val(opening_hours_arr.fri_to_time);
                $("#fri_to_ap").val(opening_hours_arr.fri_to_ap);

                $("#sat_from_time").val(opening_hours_arr.sat_from_time);
                $("#sat_from_ap").val(opening_hours_arr.sat_from_ap);
                $("#sat_to_time").val(opening_hours_arr.sat_to_time);
                $("#sat_to_ap").val(opening_hours_arr.sat_to_ap);
            }
            else
            {
                $("#specified_day_div").hide();
                $("#sun_from_time").val('');
                $("#sun_from_ap").val('');
                $("#sun_to_time").val('');
                $("#sun_to_ap").val('');

                $("#mon_from_time").val('');
                $("#mon_from_ap").val('');
                $("#mon_to_time").val('');
                $("#mon_to_ap").val('');

                $("#tue_from_time").val('');
                $("#tue_from_ap").val('');
                $("#tue_to_time").val('');
                $("#tue_to_ap").val('');

                $("#wed_from_time").val('');
                $("#wed_from_ap").val('');
                $("#wed_to_time").val('');
                $("#wed_to_ap").val('');

                $("#thu_from_time").val('');
                $("#thu_from_ap").val('');
                $("#thu_to_time").val('');
                $("#thu_to_ap").val('');

                $("#fri_from_time").val('');
                $("#fri_from_ap").val('');
                $("#fri_to_time").val('');
                $("#fri_to_ap").val('');

                $("#sat_from_time").val('');
                $("#sat_from_ap").val('');
                $("#sat_to_time").val('');
                $("#sat_to_ap").val('');
            }
            
        }
        $("#hours-opration").modal('show');
    };
    //Hours of Operation End
});