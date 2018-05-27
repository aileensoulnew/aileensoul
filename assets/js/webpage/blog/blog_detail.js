app.controller('blogDetailController', function ($scope, $http) {
	$scope.total_record = 0;
	$scope.blogDetails = {};
	$scope.categoryList = {};
  	$scope.iscategorySelected = false;
  	$scope.categorySelectedId = '';
  	// Subscribe scope
  	$scope.subscribe_email = '';
  	$scope.error_subscribe_visiblity = false;
  	$scope.error_subscribe_text = 'Please enter valid email id';
  	$scope.ajax_error_text = "";
  	$scope.ajax_error_visibility = false;
  	$scope.subscribe_visibility = true;
  	$scope.comment_error_visibility = false;
  	$scope.comment_error_text = true;

  	$scope.cname = '';
  	$scope.comment_email = '';
  	$scope.comment_msg = '';


  	//CATEGORY LISTING
  	function categoryList(){
  		$http.get(base_url + "blog/get_blog_cat_list").then(function (success) {
            $scope.categoryList = success.data;
        }, function (error) {});
  	}
  	// console.log(blog_category);
  	categoryList();

  	function blogDetailsList(){
  		$http.get(base_url + "blog/get_blog_details?blog_slug="+ blog_slug).then(function (success) {
            $scope.blogDetails = success.data;
        }, function (error) {});
  	}
  	// console.log(blog_blogDetails);
  	blogDetailsList();
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
	blog_post(1);

	var isCatProcessing = false;
    $scope.cat_post = function(cateid,page) { 
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
    		cat_post('',$scope.currentPage);
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

	/*$scope.addcomment = function(){
		if($scope.cname == "" || !$scope.cname){
			$scope.comment_error_visibility = true;
  			$scope.comment_error_text = "Please enter a name";
			return false;
		}
		if($scope.comment_email == ""){
			$scope.comment_error_visibility = true;
  			$scope.comment_error_text = "Please enter a email";
  			return false;
		}
		if($scope.comment_email != ""){
			if(!validateEmail(sEmail)){
				$scope.comment_error_visibility = true;
	  			$scope.comment_error_text = "Please enter valid email";
	  			return false;
	  		}
		}
		if($scope.comment_msg == ""){
			$scope.comment_error_visibility = true;
  			$scope.comment_error_text = "Please enter a message";
  			return false;
		}
		if($scope.comment_error_visibility == false){
			// $("#comment").submit();
		}
	}*/
});

app.filter('unsafe', function($sce) {
	return function(val) {
		return $sce.trustAsHtml(val);
	};
});

//Validation Start
$(document).ready(function () {
	$("#comment").validate({
		rules: {
			name: {
				required: true,
			  
			},
			email: {
				required: true,
				email:true,
			  
			},
			message: {
				required: true,
			  
			},
		  
		},
		messages: {
			name: {
				required: "Please enter a name",
			   
			},
			 email: {
				required: "Please enter a email",
			   
			},
			 message: {
				required: "Please enter a message",
			   
			 },   
		},
  	});
		//Validation End
	$(".angularsection").removeClass("hidden");

	//It prevent page automatically refresh
  	$(document).on('submit', "#comment", function(e) {
		e.preventDefault();
		if($(this).valid()) 
		{
			var blog_id=document.getElementById("blog_id").value;
			var name=document.getElementById("name").value;
			var email=document.getElementById("email").value;
			var message=document.getElementById("message").value;
   
		  $.ajax({
		   type: 'POST',
		   url: base_url + 'blog/comment_insert',
		   data: 'blog_id=' +blog_id+ '&name=' +name+ '&email=' + email+ '&message=' + message,         
   
		   success: function (data) {
			   if (data == 1) 
			   {
				  $.fancybox.open('<div class="message"><h2>Thank you for your valuable feedback</h2></div>');
				  $('#name').val(''); 
				  $('#email').val(''); 
				  $('#message').val(''); 
			   }
			 
		   }
		  });
		}
				
  });
   
});

// THIS SCRIPT IS USED FOR SCRAP IMAGE FOR FACEBOOK POST TO GET REAL IMAGE START
 var url= window.location.href;
	 $.ajax({
	 type: 'POST',
	 url: 'https://graph.facebook.com?id='+url+'&scrape=true',
		 success: function(data){
		}
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


function addcomment(){
	$(".comment_error").addClass("hidden");
	$(".comment_error").text("");
	$("#comment").submit();
	
}