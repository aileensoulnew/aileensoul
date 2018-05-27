app.controller('blogController', function ($scope, $http) {
	$scope.total_record = 0;
	$scope.categoryList = {};
	$scope.blogPost = [],
	$scope.limit = 5;
	$scope.currentPage = 1,
  	$scope.numPerPage = 5,
  	$scope.maxSize = 5;
  	$scope.iscategorySelected = false;
  	$scope.categorySelectedId = '';
  	// Subscribe scope
  	$scope.subscribe_email = '';
  	$scope.error_subscribe_visiblity = false;
  	$scope.error_subscribe_text = 'Please enter valid email id';
  	$scope.ajax_error_text = "";
  	$scope.ajax_error_visibility = false;
  	$scope.subscribe_visibility = true;

  	if((category_id) && category_id != ""){
		$scope.categorySelectedId = category_id;
		$scope.iscategorySelected = true;
	}
  	//CATEGORY LISTING
  	function categoryList(){
  		$http.get(base_url + "blog/get_blog_cat_list").then(function (success) {
            $scope.categoryList = success.data;
        }, function (error) {});
  	}
  	// console.log(blog_category);
  	categoryList();
  	// console.log($scope.categoryList);
	var filterajax = false;
	var isProcessing = false;
	function blog_post(pagenum) {
		if (isProcessing) {
			return;
		}
		isProcessing = true;
		var keyword = (keyword != "" && keyword) ? ("&searchword=" + keyword) : ""   ;
		$.ajax({
			type: 'POST',
			url: base_url + "blog/blog_ajax?page=" + pagenum + "&limit=" + $scope.limit + keyword,
			data: {total_record: $("#total_record").val()},
			dataType: "json",
			beforeSend: function () {
				$('#loader').show();
			},
			complete: function () {
				$('#loader').hide();
			},
			success: function (data) {
				$scope.blogPost = data.blog_data;
				// because of pagination page no. issue * by 2			
				$scope.total_record = data.total_record * 2;
				$scope.$apply();
				isProcessing = false;
				$scope.iscategorySelected = false;
				$scope.categorySelectedId = '';
			}
		});
	}
	
	var isCatProcessing = false;
    $scope.cat_post = function(cateid,page) { 
    	category_post_list(cateid,page);
    }

    function category_post_list(cateid,page){
    	if (isCatProcessing) {
            return;
        }
        page = (!page) ? 1 : page;
        cateid = (!cateid) ? $scope.categorySelectedId : cateid;
        isCatProcessing = true;
        $('#loader').show();
        var datavalue = new FormData();
        datavalue.append('cateid', cateid);
        datavalue.append('total_record', $("#total_record").val());
        isCatProcessing = $http.post(base_url + "blog/cat_ajax?cateid=" + cateid + "&page=" + page+ "&limit=" + $scope.limit, datavalue,
        {
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined, 'Process-Data': false}
        }).then(function (success) {
        	$scope.blogPost = success.data.blog_data;
        	$scope.total_record = success.data.total_record;
			isCatProcessing = false; 
			$scope.iscategorySelected = true;
			$scope.categorySelectedId = cateid;
        }, function (error) {}, 
        function (complete) { 
        	$("#loader").addClass("hidden");
        	isCatProcessing = false; 
        });
    }
    // PAGINATIONS
    $scope.$watch("currentPage + numPerPage", function() {
    	if($scope.iscategorySelected == true){
    		category_post_list('',$scope.currentPage);
    	}else{
	    	blog_post($scope.currentPage);
    	}
	});

	$scope.addsubscribe = function(){
		if(!validateEmail($scope.subscribe_email)){
			return false;
		}
		var datavalue = new FormData();
        datavalue.append('email', $scope.subscribe_email);
        $http.post(base_url + "blog/add_subscription", datavalue,
        {
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined, 'Process-Data': false}
        }).then(function (success) {
        	console.log(success);
        	if(success.data.error){
        		$scope.ajax_error_text = success.data.message;
        		$scope.ajax_error_visibility = true;
        	}
        	if(success.data.success){
				$scope.error_subscribe_visiblity = false;
				$scope.subscribe_visibility = false;
			}
        }, function (error) {}, 
        function (complete) { 
        	$("#loader").addClass("hidden");
        	isCatProcessing = false; 
        });
	}

	function validateEmail(sEmail) {
	    var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    	if (filter.test(sEmail)) {
	    	$scope.error_subscribe_visiblity = false;
	        return true;
	    }
	    else {
	    	$scope.error_subscribe_text = 'Please enter valid email id';
			$scope.error_subscribe_visiblity = true;
	        return false;
	    }
	}
});

app.filter('unsafe', function($sce) {
	return function(val) {
		return $sce.trustAsHtml(val);
	};
});

//Click on Read more Process Start
function read_more(blog_id,slug) {
	$.ajax({
	  	type: 'POST',
	  	url: base_url + 'blog/read_more',
	  	data: 'blog_id=' + blog_id,         
	  	success: function (data) {
			if (data == 1) 
			{
				window.location= base_url +"blog/" + slug;
			}
		}
	});
}
//Click on Read more Process Start

// FOR SEARCH VALIDATION FOR EMAPTY SEARCH START 
function checkvalue() 
{
	var searchkeyword = $.trim(document.getElementById('q').value);
	if (searchkeyword == "") 
	{
	   return false;
	}
}
// FOR SEARCH VALIDATION FOR EMAPTY SEARCH END 

// THIS SCRIPT IS USED FOR SCRAP IMAGE FOR FACEBOOK POST TO GET REAL IMAGE START
$(document).ready(function() {
	$(document).on('click',".fbk", function() {
		 	var url= $(this).attr('url');
		var url_encode= $(this).attr('url_encode');
		var title=$(this).attr('title');
		var summary= $(this).attr('summary');
		var image=$(this).attr('image');
		$.ajax({
			type: 'POST',
			url: 'https://graph.facebook.com?id='+url+'&scrape=true',
			  	success: function(data){
				console.log(data);
			}
  		});
	   	window.open('http://www.facebook.com/sharer.php?s=100&p[title]='+title+'&p[summary]='+summary+'&p[url]='+ url_encode+'&p[images][0]='+image+'', 'sharer', 'toolbar=0,status=0,width=620,height=280');
	});

	$(".angularsection").removeClass("hidden");
});
// THIS SCRIPT IS USED FOR SCRAP IMAGE FOR FACEBOOK POST TO GET REAL IMAGE END

// Social media click
$(document).on("click", '#google_link', function(event) { 
    var  url = $(this).attr('url_encode');
    window.open('https://plus.google.com/share?url=' + url +'', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');
});

$(document).on("click", '#linked_link', function(event) { 
    var  url = $(this).attr('url_encode');
    window.open('https://www.linkedin.com/cws/share?url=' + url +'', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');
});

$(document).on("click", '#twitter_link', function(event) { 
    var  url = $(this).attr('url_encode');
    window.open('https://twitter.com/intent/tweet?url=' + url +'', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');
});

$(document).on("click", '#facebook_link', function(event) { 
    var url = $(this).attr('url');
    var url_encode = $(this).attr('url_encode');
    var title = $(this).attr('title');
    var summary = $(this).attr('summary');
    var image = $(this).attr('image');

    $.ajax({
        type: 'POST',
        url: 'https://graph.facebook.com?id=' + url + '&scrape=true',
        success: function (data) {
            console.log(data);
        }

    });
    window.open('http://www.facebook.com/sharer.php?s=100&p[title]=' + title + '&p[summary]=' + summary + '&p[url]=' + url_encode + '&p[images][0]=' + image + '', 'sharer', 'toolbar=0,status=0,width=620,height=280');
});