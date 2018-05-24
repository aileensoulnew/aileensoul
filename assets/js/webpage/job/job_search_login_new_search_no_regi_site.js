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
app.controller('jobSearchNRController', function ($scope, $http,$window) {
    $scope.showLoadmore = true;
    $scope.jobCategory = {};
    $scope.jobCity = {};
    $scope.jobCompany = {};
    $scope.jobSkill = {};
    $scope.searchJob = {};
    $scope.jobs = {};
    $scope.jds = "";
    $scope.mainKeyword = "";

    $scope.cmp_fil = "";
    $scope.cat_fil = "";
    $scope.loc_fil = "";
    $scope.skills_fil = "";
    $scope.jd_fil = "";
    $scope.per_fil = "";
    $scope.exp_fil = "";
    //$scope.jobcompany = "";
    var fil_limit = 10;
    job_search(1);

    function jobCategory(limit = "") {
        $http.get(base_url + "job_live/jobCategory?limit="+limit).then(function (success) {
            $scope.jobCategory = success.data;
        }, function (error) {});
    }
    jobCategory(fil_limit);

    function jobCity(limit = "") {
        $http.get(base_url + "job_live/jobCity?limit="+limit).then(function (success) {
            $scope.jobCity = success.data;
        }, function (error) {});
    }
    jobCity(fil_limit);
    function jobCompany(limit = "") {
        $http.get(base_url + "job_live/jobCompany?limit="+limit).then(function (success) {
            $scope.jobCompany = success.data;
        }, function (error) {});
    }
    jobCompany(fil_limit);
    function jobSkill(limit = "") {
        $http.get(base_url + "job_live/jobSkill?limit="+limit).then(function (success) {
            $scope.jobSkill = success.data;
        }, function (error) {});
    }
    jobSkill(fil_limit);

    function jobTitle(limit = "") {
        $http.get(base_url + "job_live/get_jobtitle?limit="+limit).then(function (success) {
            $scope.jobDesignation = success.data;
        }, function (error) {});
    }
    jobTitle(fil_limit);

    //CODE FOR RESPONES OF AJAX COME FROM CONTROLLER AND LAZY LOADER START
    var isProcessing = false;
    
    angular.element($window).bind("scroll", function (e) {        
        if ($(window).scrollTop() >= ($(document).height() - $(window).height()) * 0.7) {
            isLoadingData = true;
            var page = $scope.jobs.page_number;
            var total_record = $scope.jobs.total_record;
            var perpage_record = $scope.jobs.perpage_record;            
            if (parseInt(perpage_record * page) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum =  $scope.jobs.page_number + 1;
                    job_search(pagenum);
                }
            }
        }
    });

    function job_search(pagenum) {
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
        $.post(base_url + "job/ajax_job_search_new_filter?page=" + pagenum + "&search=" + encodeURIComponent(skill)+"&search_location=" + encodeURIComponent(search_location), {"company_id": $scope.cmp_fil, "category_id" : $scope.cat_fil, "location_id": $scope.loc_fil, "skill_id": $scope.skills_fil, "job_desc": $scope.jd_fil, "period_filter": $scope.per_fil, "exp_fil": $scope.exp_fil},
            function(success){
                $('#loader').hide();
                data = JSON.parse(success);
                if(data.jobData.length > 0)
                {
                    $scope.mainKeyword = skill;
                    if(pagenum > 1)
                    {
                        for (var i in data.jobData) {                            
                            //$scope.searchJob.push(data.jobData[i]);
                            $scope.$apply(function () {
                                $scope.searchJob.push(data.jobData[i]);
                            });
                        }
                    }
                    else
                    {
                        $scope.searchJob = data.jobData;
                    }
                    //$scope.searchJob = success.data.jobData;
                    $scope.jobs.page_number = pagenum;
                    $scope.jobs.total_record = data.total_record;
                    $scope.jobs.perpage_record = 5;            
                    isProcessing = false;
                }
                else
                {
                    if(pagenum == 1)
                    {                    
                        $scope.searchJob = data.jobData;
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
                    $('.biderror .mes').html("<div class='pop_content'>Please <a href='"+base_url+"login'>Login</a> or <a href='"+base_url+"job-profile/create-account'>Register</a>.</div>");
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
                    $('.biderror .mes').html("<div class='pop_content'>Please <a href='"+base_url+"login'>Login</a> or <a href='"+base_url+"job-profile/create-account'>Register</a>.</div>");
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
        $scope.cmp_fil = "";
        $('.company-filter').each(function(){
            if(this.checked){
                var currentid = $(this).val();
                $scope.cmp_fil += ($scope.cmp_fil == "") ? currentid : "," + currentid;
            }
        });
        // console.log(cmp_fil);

        $scope.cat_fil = "";
        $('.category-filter').each(function(){
            if(this.checked){
                var currentid = $(this).val();
                $scope.cat_fil += ($scope.cat_fil == "") ? currentid : "," + currentid;
            }
        });
        // console.log(cat_fil);

        $scope.loc_fil = "";
        $('.location-filter').each(function(){
            if(this.checked){
                var currentid = $(this).val();
                $scope.loc_fil += ($scope.loc_fil == "") ? currentid : "," + currentid;
            }
        });
        // console.log(loc_fil);

        $scope.skills_fil = "";
        $('.skills-filter').each(function(){
            if(this.checked){
                var currentid = $(this).val();
                $scope.skills_fil += ($scope.skills_fil == "") ? currentid : "," + currentid;
            }
        });
        // console.log(skills_fil);

        $scope.jd_fil = "";
        $('.jds-filter').each(function(){
            if(this.checked){
                var currentid = $(this).val();
                $scope.jd_fil += ($scope.jd_fil == "") ? currentid : "," + currentid;
            }
        });
        // console.log(jd_fil);

        $scope.per_fil = "";
        $('.period-filter').each(function(){
            if(this.checked){
                var currentid = $(this).val();
                $scope.per_fil += ($scope.per_fil == "") ? currentid : "," + currentid;
            }
        });
        // console.log(per_fil);
        
        $scope.exp_fil = "";
        $('.exp-filter').each(function(){
            if(this.checked){
                var currentid = $(this).val();
                $scope.exp_fil += ($scope.exp_fil == "") ? currentid : "," + currentid;
            }
        });
        // console.log(exp_fil);
        pagenum = 1;

        //$("#loader").show();

        $.post(base_url + "job/ajax_job_search_new_filter?page=" + pagenum + "&search=" + encodeURIComponent(skill)+"&search_location=" + encodeURIComponent(search_location), {"company_id": $scope.cmp_fil, "category_id" : $scope.cat_fil, "location_id": $scope.loc_fil, "skill_id": $scope.skills_fil, "job_desc": $scope.jd_fil, "period_filter": $scope.per_fil, "exp_fil": $scope.exp_fil},
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
        );
    };
});  