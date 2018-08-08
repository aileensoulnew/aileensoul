var filter_selected_data = "";
//AJAX DATA LOAD BY LAZZY LOADER START
recommen_candidate_post(filter_selected_data, '', 1);
$(document).ready(function() {
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
                    recommen_candidate_post('', filter_selected_data, pagenum);
                }
            }
        }
    });
});
app.controller('recruiterSearchListController', function($scope, $http) {
    $scope.recruiterCityFilterList = {};
    $scope.recruiterTitleFilterList = {};
    $scope.recruiterIndustryFilterList = {};
    $scope.recruiterSkillFilterList = {};
    $scope.recruiterExperienceFilterList = {};

    function getFilterList() {
        $http.get(base_url + "recruiter/get_filer_data?limit=5").then(function(success) {
            $scope.recruiterCityFilterList = success.data.cities;
            $scope.recruiterTitleFilterList = success.data.job_title;
            $scope.recruiterIndustryFilterList = success.data.job_industries;
            $scope.recruiterSkillFilterList = success.data.job_skill;
            $scope.recruiterExperienceFilterList = success.data.job_experience;
        }, function(error) {});
    }
    getFilterList();
    $scope.getfilterrecruiterdata = function() {
        filter_selected_data = "";
        // Get Checked Category of filter and make data value for ajax call
        var city = "";
        $('.citiescheckbox').each(function() {
            if (this.checked) {
                var currentid = $(this).val();
                city += (city == "") ? currentid : "," + currentid;
            }
        });
        // Get Checked Category of filter and make data value for ajax call
        var title = "";
        $('.titlescheckbox').each(function() {
            if (this.checked) {
                var currentid = $(this).val();
                title += (title == "") ? currentid : "," + currentid;
            }
        });
        // Get Checked Category of filter and make data value for ajax call
        var industry = "";
        $('.industrycheckbox').each(function() {
            if (this.checked) {
                var currentid = $(this).val();
                industry += (industry == "") ? currentid : "," + currentid;
            }
        });
        var experience = "";
        $('.experiencecheckbox').each(function() {
            if (this.checked) {
                var currentid = $(this).val();
                experience += (experience == "") ? currentid : "," + currentid;
            }
        });
        var skill = "";
        $('.skillcheckbox').each(function() {
            if (this.checked) {
                var currentid = $(this).val();
                skill += (skill == "") ? currentid : "," + currentid;
            }
        });
        // if filter apply append id of category and location
        if (city != "") {
            filter_selected_data += "&city_id=" + city;
        }
        if (title != "") {
            filter_selected_data += "&title_id=" + title;
        }
        if (industry != "") {
            filter_selected_data += "&industry_id=" + industry;
        }
        if (skill != "") {
            filter_selected_data += "&skill_id=" + skill;
        }
        if (experience != "") {
            filter_selected_data += "&experience_id=" + experience;
        }
        recommen_candidate_post('filter', filter_selected_data, 1);
    }
});
var isProcessing = false;
var ajax_Post;

function recommen_candidate_post(from, filter_selected_data, pagenum) {
    if (from == "filter") {
        if (isProcessing) {
            ajax_Post.abort();
            isProcessing = false;
        }
        $('.job-contact-frnd').html('');
        $('#loader').show();
    }
    if (isProcessing) {
        /*
         *This won't go past this condition while
         *isProcessing is true.
         *You could even display a message.
         **/
        return;
    }
    isProcessing = true;
    ajax_Post = $.ajax({
        type: 'POST',
        url: base_url + "recruiter/recruiter_search_candidate?page=" + pagenum + "&skill=" + encodeURIComponent(skill) + "&place=" + place + filter_selected_data,
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
            $('.loader').remove();
        },
        success: function(data) {
            $('.loader').remove();
            if (from == "filter") {
                $('.job-contact-frnd').html('');
            }
            $('.job-contact-frnd').append(data);
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
function check() {
    var keyword = $.trim(document.getElementById('tags1').value);
    var place = $.trim(document.getElementById('searchplace1').value);
    if (keyword == "" && place == "") {
        return false;
    }
}

function checkvalue() {
    //alert("hi");
    var searchkeyword = $.trim(document.getElementById('rec_search_title').value);
    var searchplace = $.trim(document.getElementById('rec_search_loc').value);
    // alert(searchkeyword);
    // alert(searchplace);
    if (searchkeyword == "" && searchplace == "") {
        //     alert('Please enter Keyword');
        return false;
    }
}

function checkvalue_search() {
    var searchkeyword = $.trim(document.getElementById('tags').value);
    var searchplace = $.trim(document.getElementById('searchplace').value);
    if (searchkeyword == "" && searchplace == "") {
        //  alert('Please enter Keyword');
        return false;
    }
}

function save_user(abc, jobid) {
    // var saveid = document.getElementById("hideenuser"+jobid);
    var saveid = document.getElementById("hideenuser" + abc);
    $.ajax({
        type: 'POST',
        url: base_url + 'recruiter/save_search_user',
        data: 'user_id=' + abc + '&save_id=' + saveid.value,
        success: function(data) {
            $('.' + 'saveduser' + jobid).html(data).addClass('saved');
        }
    });
}
// save post end
/*function savepopup(id,jobid) {
           
    save_user(id,jobid);
          
    $('.biderror .mes').html("<div class='pop_content'>Candidate successfully saved.");
    $('#bidmodal').modal('show');
}*/
function savepopup(abc) {
    var saveid = document.getElementById("hideenuser" + abc);
    $.ajax({
        type: 'POST',
        url: base_url + 'recruiter/save_search_user',
        data: 'user_id=' + abc + '&save_id=' + saveid.value,
        success: function(data) {
            $('.' + 'saveduser' + abc).html(data).addClass('saved');
            $('.biderror .mes').html("<div class='pop_content'>Candidate successfully saved.");
            $('#bidmodal').modal('show');
        }
    });
}
// all popup close close using esc start 
$(document).on('keydown', function(e) {
    if (e.keyCode === 27) {
        //$( "#bidmodal" ).hide();
        $('#bidmodal').modal('hide');
    }
});
// change location
$(document).on('change', '.citiescheckbox,.titlescheckbox,.industrycheckbox,.skillcheckbox,.experiencecheckbox', function() {
    var self = this;
    angular.element(self).scope().getfilterrecruiterdata();
});