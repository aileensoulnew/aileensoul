app.controller('artistSearchListController', function ($scope, $http,$window) {
    $scope.title = title;
    $scope.artistCategory = {};
    $scope.artistLocation = {};
    $scope.searchtitle = '';
    $scope.categorysearch = '';
    $scope.locationsearch = '';
    $scope.artist = {};
    pagenum = 1;
    var search_data_url = '';
    var isProcessing = false;
    // $scope.artistList = {};
    searchArtist();
    function artistCategory() {
        $http.get(base_url + "artist_live/artistCategory?limit=5").then(function (success) {
            $scope.artistCategory = success.data;
            $($scope.artistCategory).each(function(i,d){
                d.isselected = false;
            });
        }, function (error) {});
    }
    artistCategory();
    function otherCategoryCount() {
        $http.get(base_url + "artist_live/otherCategoryCount").then(function (success) {
            $scope.otherCategoryCount = success.data;
        }, function (error) {});
    }
    otherCategoryCount();
    // ARTIST CITY FILTER
    function artistLocation(){
        $http.get(base_url + "artist_live/artistAllLocation?limit=5").then(function (success) {
            $(success.data).each(function(i,d){
                d.isselected = false;
            });
            $scope.artistLocation = success.data;
        }, function (error) {});
    }
    artistLocation();
    function searchArtist() {
        
        if (q != '' && l == '') {
            search_data_url = base_url + 'artist_live/searchArtistData?q=' + q;
        } else if (q == '' && l != '') {
            search_data_url = base_url + 'artist_live/searchArtistData?l=' + l;
        } else {
            search_data_url = base_url + 'artist_live/searchArtistData?q=' + q + '&l=' + l;
        }
        getsearchresultlist(search_data_url,'pageload',pagenum);
    }
    

    // Search result text
    function searchResultText(){
        $scope.categorysearch = q.replace(/,/gi,' , ');
        $scope.locationsearch = l.replace(/,/gi,' , ');
        $scope.searchtitle = ($scope.categorysearch && $scope.locationsearch) ? (' for ' + $scope.categorysearch + ' in ' + $scope.locationsearch) : (($scope.categorysearch) ? $scope.categorysearch : $scope.locationsearch); 
    }
    searchResultText();

    $scope.getfilterartistdata = function(){
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
            search_data_url = base_url + 'artist_live/searchArtistData?q=' + q;
        } else if (q == '' && l != '') {
            search_data_url = base_url + 'artist_live/searchArtistData?l=' + l;
        } else {
            search_data_url = base_url + 'artist_live/searchArtistData?q=' + q + '&l=' + l;
        }

        // if filter apply append id of category and location
        if(location != ""){
            search_data_url += "&location_id=" + location;
        }
        if(category != ""){
            search_data_url += "&category_id=" + category;
        }
        // getsearchresultlist(search_data_url,'filter');
        $scope.artistList = {};
        pagenum = 1;
        isProcessing = false;
        $("#load-more").show();
        $http.get(search_data_url+'&page='+pagenum).then(function (success) {
            $("#load-more").hide();
            $('#main_loader').hide();
            // $('#main_page_load').show();
            $('body').removeClass("body-loader");            
            $scope.artistList = success.data.seach_artist;
            $scope.artist.page_number = pagenum;
            $scope.artist.total_record = success.data.total_record;
            $scope.artist.perpage_record = 5;            
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
            $("#load-more").show();
            $('#main_loader').hide();
            // $('#main_page_load').show();
            $('body').removeClass("body-loader");

            if(result.seach_artist.length > 0)
            {
                if(pagenum > 1)
                {
                    for (var i in result.seach_artist) {
                        // $scope.$apply(function () {
                            $scope.artistList.push(result.seach_artist[i]);
                        // });
                    }
                }
                else
                {
                    $scope.artistList = result.seach_artist;
                }                    
                $scope.artist.page_number = pagenum;
                $scope.artist.total_record = result.total_record;
                $scope.artist.perpage_record = 5;            
                isProcessing = false;
            }
            else
            {
                if(pagenum == 1)
                {                    
                    $scope.artistList = result.seach_artist;
                }
                $scope.showLoadmore = false;                
            }
            
        }, function (error) {});
    }

    angular.element($window).bind("scroll", function (e) {        
        if ($(window).scrollTop() >= ($(document).height() - $(window).height()) * 0.7) {
            isLoadingData = true;
            var page = $scope.artist.page_number;
            var total_record = $scope.artist.total_record;
            var perpage_record = $scope.artist.perpage_record;            
            if (parseInt(perpage_record * page) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum =  $scope.artist.page_number + 1;
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

// change location
$(document).on('change','.locationcheckbox,.categorycheckbox',function(){
    var self = this;
    // self.setAttribute('checked',(this.checked));
    angular.element(self).scope().getfilterartistdata();
});
