app.controller('businessSearchListController', function ($scope, $http) {
    $scope.title = title;
    $scope.businessCategory = {};
    $scope.businessLocation = {};
    $scope.searchtitle = '';
    $scope.categorysearch = '';
    $scope.locationsearch = '';
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
        var search_data_url = '';
        if (q != '' && l == '') {
            search_data_url = base_url + 'business_live/searchBusinessData?q=' + q;
        } else if (q == '' && l != '') {
            search_data_url = base_url + 'business_live/searchBusinessData?l=' + l;
        } else {
            search_data_url = base_url + 'business_live/searchBusinessData?q=' + q + '&l=' + l;
        }
        getsearchresultlist(search_data_url,'pageload');
    }
    searchBusiness();

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

        var search_data_url = '';
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
        getsearchresultlist(search_data_url,'filter');        
    }

    function getsearchresultlist(search_url, from){
        $("#loader").removeClass("hidden");
        $http.get(search_url).then(function (success) {
            $("#loader").addClass("hidden");
            $scope.businessList = success.data;
        }, function (error) {});
    }
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

