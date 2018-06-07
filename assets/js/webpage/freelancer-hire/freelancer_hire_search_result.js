var filter_selected_data = "";
app.controller('freelancerHireSearchController', function ($scope, $http) {
    $scope.categoryFilterList = {};
    $scope.cityFilterList = {};
    $scope.skillFilterList = {};
    $scope.experienceFilterList = {};

    function getFilterList() {
        $http.get(base_url + "freelancer/get_filter_data?limit=5").then(function (success) {
            $scope.cityFilterList = success.data.freelancer_cities;
            $scope.categoryFilterList = success.data.freelancer_category;
            $scope.skillFilterList = success.data.freelancer_skills;
            $scope.experienceFilterList = success.data.freelancer_experience;
        }, function (error) {});
    }
    getFilterList();

    $scope.getfilterfreelancehiredata = function(){
        filter_selected_data = "";

        // Get Checked Category of filter and make data value for ajax call
        var category = "";
        $('.categorycheckbox').each(function(){
            if(this.checked){
                var currentid = $(this).val();
                category += (category == "") ? currentid : "," + currentid;
            }
        });
        
        // Get Checked Category of filter and make data value for ajax call
        var city = "";
        $('.citiescheckbox').each(function(){
            if(this.checked){
                var currentid = $(this).val();
                city += (city == "") ? currentid : "," + currentid;
            }
        });

        // Get Checked Skill of filter and make data value for ajax call
        var skill = "";
        $('.skillcheckbox').each(function(){
            if(this.checked){
                var currentid = $(this).val();
                skill += (skill == "") ? currentid : "," + currentid;
            }
        });

        // Get Checked Experience of filter and make data value for ajax call
        var experience = "";
        $('.experiencecheckbox').each(function(){
            if(this.checked){
                var currentid = $(this).val();
                experience += (experience == "") ? currentid : "," + currentid;
            }
        });

        // if filter apply append id of category and location
        if(city != ""){
            filter_selected_data += "&city_id=" + city;
        } 
        if(category != ""){
            filter_selected_data += "&category_id=" + category;
        }
        if(skill != ""){
            filter_selected_data += "&skill_id=" + skill;
        }
        if(experience != ""){
            filter_selected_data += "&experience_id=" + experience;
        }
        freelancerhire_search('filter',filter_selected_data, 1);        
    }
});


//CODE FOR RESPONES OF AJAX COME FROM CONTROLLER AND LAZY LOADER START
$(document).ready(function () {
    freelancerhire_search('',filter_selected_data, 1);

    $(window).scroll(function () {
        
       // if ($(window).scrollTop() == $(document).height() - $(window).height()) {
            //  if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
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
                    
                    freelancerhire_search('',filter_selected_data, pagenum);
                }
            }
        }
    });    
});
var isProcessing = false;
var ajaxSearch;
function freelancerhire_search(from,filter_selected_data='',pagenum)
{
    if(from == "filter" ){
        if(isProcessing){
            ajaxSearch.abort();
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
    // url = '<?php echo base_url() . "freelancer-hire/search?page=" ?>'+clicked_id+"&skill="  + encodeURIComponent(searchkeyword) + "&place=" + searchplace;
    isProcessing = true;
    
    ajaxSearch = $.ajax({
        type: 'POST',
        url: base_url + "search/ajax_freelancer_hire_search?page=" + pagenum + "&skill="  + encodeURIComponent(skill) + "&place=" + place + filter_selected_data,
        data: {total_record:$("#total_record").val()},
        dataType: "html",
        beforeSend: function () {
            if (pagenum == 'undefined') {
                $(".job-contact-frnd").prepend('<p style="text-align:center;"><img class="loader" src="' + base_url + 'images/loading.gif"/></p>');
            } else {
                $('#loader').show();
            }
        },
        complete: function () {
            $('#loader').hide();
        },
        success: function (data) { 
            if(from == "filter"){
                $('.job-contact-frnd').html('');
            }
            $('.loader').remove();
            $('.job-contact-frnd').append(data);
            // second header class add for scroll
            var nb = $('.post-design-box').length;
            if (nb == 0) {
                $("#dropdownclass").addClass("no-post-h2");
            } else {
                $("#dropdownclass").removeClass("no-post-h2");
            }
            isProcessing = false;
            $('#main_loader').hide();
            $('#main_page_load').show();
        }
    });
}

//CODE FOR RESPONES OF AJAX COME FROM CONTROLLER AND LAZY LOADER END

//FUNCTION FOR CHECK VALUE OF SEARCH KEYWORD AND PLACE ARE BLANK START
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
//FUNCTION FOR CHECK VALUE OF SEARCH KEYWORD AND PLACE ARE BLANK END
//CODE FOR SAVE USER START
function savepopup(id) {
    save_user(id);

    $('.biderror .mes').html("<div class='pop_content'>Your Freelancer is successfully saved.");
    $('#bidmodal').modal('show');
}
function save_user(abc)
{
    var saveid = document.getElementById("hideenuser" + abc);
    $.ajax({
        type: 'POST',
        url:  base_url + "freelancer_hire_live/save_user1",
        data: 'user_id=' + abc + '&save_id=' + saveid.value,
        success: function (data) {
            $('.' + 'saveduser' + abc).html(data).addClass('saved');
        }
    });
}
//CODE FOR SAVE USER END
//ALL POPUP CLOSE USING ESC START
$(document).on('keydown', function (e) {
    if (e.keyCode === 27) {
        $('#bidmodal').modal('hide');
    }
});
//ALL POPUP CLOSE USING ESC END


// ADD OR REMOVE FILTER
$(document).on('change','.filtercheckbox',function(){
    var self = this;
    angular.element(self).scope().getfilterfreelancehiredata();
});

