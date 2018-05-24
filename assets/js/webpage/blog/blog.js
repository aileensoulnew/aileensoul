app.controller('blogController', function ($scope, $http) {
	$scope.total_record = 0;
	$scope.blogPost = {};
	$scope.limit = 4;
	$scope.currentPage = 1;
  	$scope.numPerPage = 10;
  	$scope.maxSize = 5;

	var filterajax = false;
	var isProcessing = false;
	function blog_post(pagenum) {
		if (isProcessing) {
			return;
		}
		isProcessing = true;
		$.ajax({
			type: 'POST',
			url: base_url + "blog/blog_ajax?page=" + pagenum,
			data: {total_record: $("#total_record").val()},
			dataType: "json",
			beforeSend: function () {
				$('#loader').show();
			},
			complete: function () {
				$('#loader').hide();
			},
			success: function (data) {
			  //  $('#loader').remove();
				$scope.blogPost = data.blog_data;
				$scope.total_record = 20;
				$scope.$apply();
				isProcessing = false;
				shortdesc();
			}
		});
	}
	blog_post(1);
});

app.filter('unsafe', function($sce) {
	return function(val) {
		return $sce.trustAsHtml(val);
	};
});


function shortdesc(){
	var showChar = 300;
	var ellipsestext = "...";
	$('.blog-text').each(function() {
		var content = $(this).html();

		if(content.length > showChar) {

			var c = content.substr(0, showChar);
			var h = content.substr(showChar-1, content.length - showChar);

			var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span></a></span>';

			$(this).html(html);
		}

	});
}


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
   });
// THIS SCRIPT IS USED FOR SCRAP IMAGE FOR FACEBOOK POST TO GET REAL IMAGE END



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