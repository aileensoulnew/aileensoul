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

        if(slug[slug.length - 1] == "-")
        {            
            slug = slug.slice(0,-1);
        }
        return slug;
    };
});
app.filter('capitalize', function () {
    return function (str) {
        if (str === undefined || !str || str == null) {
            return false;
        }
        return str.split(" ").map(function (input) {
            return (!!input) ? input.charAt(0).toUpperCase() + input.substr(1).toLowerCase() : ''
        }).join(" ");

    }
});
app.controller('freelanceApplyNRController', function ($scope, $http,$window) {
    $scope.showLoadmore = true;
    $scope.jobCategory = {};
    $scope.jobCity = {};
    $scope.jobCompany = {};
    $scope.jobSkill = {};
    $scope.freepostapply = {};
    $scope.fa = {};
    $scope.jds = "";
    $scope.mainKeyword = "";

    
    $scope.cat_fil = "";    
    $scope.skills_fil = "";
    $scope.worktype = "";
    $scope.per_fil = "";
    $scope.exp_fil = "";
    //$scope.jobcompany = "";
    var fil_limit = 10;
    fa_search(1);

    function FAFields(limit = 0) {
        $http.get(base_url + "freelancer_apply_live/freelancerFields?limit="+limit).then(function (success) {
            $scope.FAFields = success.data;
        }, function (error) {});
    }
    FAFields(fil_limit);

    function FASkills(limit = 0) {
        $http.get(base_url + "freelancer_apply_live/freelancerSkills?limit="+limit).then(function (success) {
            $scope.FASkills = success.data.fa_skills;
        }, function (error) {});
    }
    FASkills(fil_limit);

    //CODE FOR RESPONES OF AJAX COME FROM CONTROLLER AND LAZY LOADER START
    var isProcessing = false;
    
    angular.element($window).bind("scroll", function (e) {        
        if ($(window).scrollTop() >= ($(document).height() - $(window).height()) * 0.7) {
            isLoadingData = true;
            var page = $scope.fa.page_number;
            var total_record = $scope.fa.total_record;
            var perpage_record = $scope.fa.perpage_record;            
            if (parseInt(perpage_record * page) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum =  $scope.fa.page_number + 1;
                    fa_search(pagenum);
                }
            }
        }
    });

    function fa_search(pagenum) {
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
        $.post(base_url + "freelancer_apply_live/ajax_project_list_no_login?page=" + pagenum + "&search=" + encodeURIComponent(skill)+"&search_location=" + encodeURIComponent(search_location), {"category_id" : $scope.cat_fil, "skill_id": $scope.skills_fil, "worktype": $scope.worktype, "period_filter": $scope.per_fil, "exp_fil": $scope.exp_fil},
            function(success){
                $('#loader').hide();
                data = JSON.parse(success);
                if(data.fa_projects.length > 0)
                {
                    $scope.mainKeyword = skill;
                    if(pagenum > 1)
                    {
                        for (var i in data.fa_projects) {
                            $scope.$apply(function () {
                                $scope.freepostapply.push(data.fa_projects[i]);
                            });
                        }
                    }
                    else
                    {
                        $scope.freepostapply = data.fa_projects;
                    }                    
                    $scope.fa.page_number = pagenum;
                    $scope.fa.total_record = data.total_record;
                    $scope.fa.perpage_record = 5;            
                    isProcessing = false;
                }
                else
                {
                    if(pagenum == 1)
                    {                    
                        $scope.freepostapply = data.fa_projects;
                    }
                    $scope.showLoadmore = false;                
                }
            }
        );        
    }
    //CODE FOR RESPONES OF AJAX COME FROM CONTROLLER AND LAZY LOADER END

    //apply post start
    $scope.applypopup = function(postid, userid)
    {
        if(job_profile_set == 0 && login_user_id != "")
        {
            $("#job_apply").val(postid);
            $("#job_apply_userid").val(userid);
            $("#job_save").val('');
            $('#job_reg').modal('show');
        }
        else
        {
            if(login_user_id == "" || job_deactive == 1)
            {                
                if(login_user_id == ""){
                    $('.biderror .mes').html("<div class='pop_content pop-content-cus'><h2>Lorem ipsum is a dummy text ists use for dummy data</h2>Please <p class='poppup-btns'><a class='btn1' href='"+base_url+"login'>Login</a> or <a class='btn1' href='"+base_url+"job-profile/create-account'>Register</a></p></div>");
                }
                else if(job_deactive == 1)
                    $('.biderror .mes').html("<div class='pop_content'>Please Reactive.</div>");
                $('#bidmodal').modal('show');
            }
            else
            {                
                $('.biderror .mes').html("<div class='pop_content'>Do you want to apply this job?<div class='model_ok_cancel'><a class='okbtn' id=" + postid + " onClick='apply_post(" + postid + "," + userid + ")' href='javascript:void(0);' data-dismiss='modal' title='Yes'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal' title='No'>No</a></div></div>");
                $('#bidmodal').modal('show');
            }
        }
    };

    $scope.apply_post = function(abc, xyz) {
        var alldata = 'all';
        var user = xyz;

        $.ajax({
            type: 'POST',
            url: base_url + 'job/job_apply_post',
            data: 'post_id=' + abc + '&allpost=' + alldata + '&userid=' + user,
            datatype: 'json',
            success: function (data) {
                $('.savedpost' + abc).hide();
                $('.applypost' + abc).html(data.status);
                $('.applypost' + abc).attr('disabled', 'disabled');
                $('.applypost' + abc).attr('onclick', 'myFunction()');
                $('.applypost' + abc).addClass('applied');

                if (data.notification.notification_count != 0) {
                    var notification_count = data.notification.notification_count;
                    var to_id = data.notification.to_id;
                    show_header_notification(notification_count, to_id);
                }
            }
        });
    };
    //apply post end

    //save post start 
    $scope.savepopup  = function(id) {
        
        if(job_profile_set == 0 && login_user_id != "")
        {
            $("#job_apply_userid").val('');
            $("#job_apply").val('');
            $("#job_save").val(id);
            $('#job_reg').modal('show');
        }
        else
        {
            if(login_user_id == "" || job_deactive == 1)
            {
                if(login_user_id == ""){
                    $('.biderror .mes').html("<div class='pop_content pop-content-cus'><h2>Lorem ipsum is a dummy text ists use for dummy data</h2>Please <p class='poppup-btns'><a class='btn1' href='"+base_url+"login'>Login</a> or <a class='btn1' href='"+base_url+"job-profile/create-account'>Register</a></p></div>");
                }
                else if(job_deactive == 1)
                    $('.biderror .mes').html("<div class='pop_content'>Please Reactive.</div>");
                $('#bidmodal').modal('show');
            }
            else
            {
                save_post(id);
                $('.biderror .mes').html("<div class='pop_content'>Job successfully saved.");
                $('#bidmodal').modal('show');
            }
        }
    };

    function save_post(abc)
    {
        $.ajax({
            type: 'POST',
            url: base_url + 'job/job_save',
            data: 'post_id=' + abc,
            success: function (data) {
                $('.' + 'savedpost' + abc).html(data).addClass('saved');
            }
        });

    };
    
    $scope.applyJobFilter = function() {
       
        $scope.cat_fil = "";
        $('.category-filter').each(function(){
            if(this.checked){
                var currentid = $(this).val();
                $scope.cat_fil += ($scope.cat_fil == "") ? currentid : "," + currentid;
            }
        });
         console.log($scope.cat_fil);

        
        $scope.skills_fil = "";
        $('.skills-filter').each(function(){
            if(this.checked){
                var currentid = $(this).val();
                $scope.skills_fil += ($scope.skills_fil == "") ? currentid : "," + currentid;
            }
        });
         console.log($scope.skills_fil);

        $scope.worktype = "";
        $('.worktype-filter').each(function(){
            if(this.checked){
                var currentid = $(this).val();
                $scope.worktype += ($scope.worktype == "") ? currentid : "," + currentid;
            }
        });
         console.log($scope.worktype);

        $scope.per_fil = "";
        $('.period-filter').each(function(){
            if(this.checked){
                var currentid = $(this).val();
                $scope.per_fil += ($scope.per_fil == "") ? currentid : "," + currentid;
            }
        });
         console.log($scope.per_fil);
        
        $scope.exp_fil = "";
        $('.exp-filter').each(function(){
            if(this.checked){
                var currentid = $(this).val();
                $scope.exp_fil += ($scope.exp_fil == "") ? currentid : "," + currentid;
            }
        });
         console.log($scope.exp_fil);
        pagenum = 1;

        //$("#loader").show();

        /*$.post(base_url + "job/ajax_job_search_new_filter?page=" + pagenum + "&search=" + encodeURIComponent(skill)+"&search_location=" + encodeURIComponent(search_location), {"company_id": $scope.cmp_fil, "category_id" : $scope.cat_fil, "location_id": $scope.loc_fil, "skill_id": $scope.skills_fil, "job_desc": $scope.jd_fil, "period_filter": $scope.per_fil, "exp_fil": $scope.exp_fil},
            function(success){
                $scope.searchJob = {};
                data = JSON.parse(success);
                $scope.$apply(function () {
                    $scope.searchJob = data.jobData;
                    $scope.jobs.page_number = pagenum;
                    $scope.jobs.total_record = data.total_record;
                    $scope.jobs.perpage_record = 5;            
                    isProcessing = false;
                });
            }
        );*/
    };
});  