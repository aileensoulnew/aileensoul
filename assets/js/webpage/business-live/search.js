app.directive('onErrorSrc', function() {
    return {
        link: function(scope, element, attrs) {
          element.bind('error', function() {
            if (attrs.src != attrs.onErrorSrc) {
              attrs.$set('src', attrs.onErrorSrc);
            }
          });
        }
    }
});
app.controller('businessSearchListController', function ($scope, $http,$compile,$window) {
    $scope.title = title;
    $scope.businessCategory = {};
    $scope.businessLocation = {};
    $scope.searchtitle = '';
    $scope.categorysearch = '';
    $scope.locationsearch = '';
    $scope.business = {};
    pagenum = 1;
    var search_data_url = '';
    var isProcessing = false;

    searchBusiness();

    function load_add(){        
        setTimeout(function(){        
        /*var $el = $('<adsense ad-client="ca-pub-6060111582812113" ad-slot="8390312875" inline-style="display:block;" ad-format="auto"></adsense>').appendTo('.ads');
            $compile($el)($scope);*/
        /*var $el = $('<adsense ad-client="ca-pub-6060111582812113" ad-slot="8390312875" inline-style="display:block;" ad-class="adBlock"></adsense>').appendTo('.right-add-box');
            $compile($el)($scope);*/
        },2000);
    }

    function businessCategory() {
        $http.get(base_url + "business_live/businessCategory?limit=5").then(function (success) {
            $scope.businessCategory = success.data;
        }, function (error) {});
    }
    businessCategory();

    function otherCategoryCount() {
        $http.get(base_url + "business_live/otherCategoryCount").then(function (success) {
            $scope.otherCategoryCount = success.data;
        }, function (error) {});
    }
    otherCategoryCount();

    // ARTIST CITY FILTER
    function businessLocation(){
        $http.get(base_url + "business_live/businessLocation?limit=5").then(function (success) {
            $(success.data).each(function(i,d){
                d.isselected = false;
            });
            $scope.businessLocation = success.data;
        }, function (error) {});
    }
    businessLocation();

    function searchBusiness() {        
        if (q != '' && l == '') {
            search_data_url = base_url + 'business_live/searchBusinessData?q=' + q;
        } else if (q == '' && l != '') {
            search_data_url = base_url + 'business_live/searchBusinessData?l=' + l;
        } else {
            search_data_url = base_url + 'business_live/searchBusinessData?q=' + q + '&l=' + l;
        }
        getsearchresultlist(search_data_url,'pageload', pagenum);
    }
    

    // Search result text
    function searchResultText(){
        $scope.categorysearch = q.replace(/,/gi,' And ');
        $scope.locationsearch = l.replace(/,/gi,' And ');
        $scope.searchtitle = ($scope.categorysearch && $scope.locationsearch) ? (' for ' + $scope.categorysearch + ' and ' + $scope.locationsearch) : (($scope.categorysearch) ? $scope.categorysearch : $scope.locationsearch); 
    }
    searchResultText();

    $scope.getfilterbusinessdata = function(){
        var location = "";
        // Get Checked Location of filter and make data value for ajax call
        $('.locationcheckbox').each(function(){
            if(this.checked){
                var currentid = $(this).val();
                var urllocation_id = l.split(",");
                if (urllocation_id.indexOf(currentid) === -1) {
                    location += (location == "") ? currentid : "," + currentid;
                }
            }
        });

        // Get Checked Category of filter and make data value for ajax call
        var category = "";
        $('.categorycheckbox').each(function(){
            if(this.checked){
                var currentid = $(this).val();
                var urlcategory_id = q.split(",");
                if (urlcategory_id.indexOf(currentid) === -1) {
                    category += (category == "") ? currentid : "," + currentid;
                }
            }
        });
        
        if (q != '' && l == '') {
            search_data_url = base_url + 'business_live/searchBusinessData?q=' + q;
        } else if (q == '' && l != '') {
            search_data_url = base_url + 'business_live/searchBusinessData?l=' + l;
        } else {
            search_data_url = base_url + 'business_live/searchBusinessData?q=' + q + '&l=' + l;
        }

        // if filter apply append id of category and location
        if(location != ""){
            search_data_url += "&location_id=" + location;
        }
        if(category != ""){
            search_data_url += "&category_id=" + category;
        }
        // getsearchresultlist(search_data_url,'filter');
        pagenum = 1;
        isProcessing = false;
        $scope.businessList = {};
        $("#load-more").show();
        $http.get(search_data_url+'&page='+pagenum).then(function (success) {
            $("#load-more").hide();
            $('#main_loader').hide();
            // $('#main_page_load').show();
            //load_add();
            $('body').removeClass("body-loader");
            $scope.businessList = success.data.seach_business;
            $scope.business.page_number = pagenum;
            $scope.business.total_record = success.data.total_record;
            $scope.business.perpage_record = 5;            
            isProcessing = false;
        }, function (error) {});
    }

    function getsearchresultlist(search_url, from, pagenum){
        if (isProcessing) {            
            return;
        }
        isProcessing = true;
        $("#load-more").show();
        if(pagenum == 1){            
            $('#main_loader').show();
        }
        $http.get(search_url+'&page='+pagenum).then(function (success) {
            result = success.data;
            $("#load-more").hide();
            $('#main_loader').hide();            
            $('body').removeClass("body-loader");

            if(result.seach_business.length > 0)
            {
                if(pagenum > 1)
                {
                    for (var i in result.seach_business) {
                        // $scope.$apply(function () {
                            $scope.businessList.push(result.seach_business[i]);
                        // });
                    }
                }
                else
                {
                    $scope.businessList = result.seach_business;
                }                    
                $scope.business.page_number = pagenum;
                $scope.business.total_record = result.total_record;
                $scope.business.perpage_record = 5;            
                isProcessing = false;
            }
            else
            {
                if(pagenum == 1)
                {                    
                    $scope.businessList = result.seach_business;
                }
                $scope.showLoadmore = false;                
            }
        }, function (error) {});
    }

    angular.element($window).bind("scroll", function (e) {        
        if ($(window).scrollTop() >= ($(document).height() - $(window).height()) * 0.7) {            
            var page = $scope.business.page_number;
            var total_record = $scope.business.total_record;
            var perpage_record = $scope.business.perpage_record;            
            if (parseInt(perpage_record * page) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum =  $scope.business.page_number + 1;
                    getsearchresultlist(search_data_url, "", pagenum);
                }
            }
        }
    });
});

$(window).on("load", function () {
    $(".custom-scroll").mCustomScrollbar({
        autoHideScrollbar: true,
        theme: "minimal"
    });
    $('#q').val(q);
    $('#l').val(l);
});

// change location and category
$(document).on('change','.locationcheckbox,.categorycheckbox',function(){
    var self = this;
    // self.setAttribute('checked',(this.checked));
    angular.element(self).scope().getfilterbusinessdata();
});

