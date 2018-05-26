app.controller('blogController', function ($scope, $http) {
	$scope.total_record = 0;
	$scope.categoryList = {};
	$scope.blogPost = [],
	$scope.limit = 5;
	$scope.currentPage = 4,
  	$scope.numPerPage = 5,
  	$scope.maxSize = 5;
  	$scope.iscategorySelected = false;
  	$scope.categorySelectedId = '';

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








(function(){var moduleName='angularUtils.directives.dirPagination';var DEFAULT_ID='__default';var module;try{module=angular.module(moduleName);}catch(err){module=angular.module(moduleName,[]);}
module.directive('dirPaginate',['$compile','$parse','paginationService',dirPaginateDirective]).directive('dirPaginateNoCompile',noCompileDirective).directive('dirPaginationControls',['paginationService','paginationTemplate',dirPaginationControlsDirective]).filter('itemsPerPage',['paginationService',itemsPerPageFilter]).service('paginationService',paginationService).provider('paginationTemplate',paginationTemplateProvider).run(['$templateCache',dirPaginationControlsTemplateInstaller]);function dirPaginateDirective($compile,$parse,paginationService){return{terminal:true,multiElement:true,compile:dirPaginationCompileFn};function dirPaginationCompileFn(tElement,tAttrs){var expression=tAttrs.dirPaginate;var match=expression.match(/^\s*([\s\S]+?)\s+in\s+([\s\S]+?)(?:\s+track\s+by\s+([\s\S]+?))?\s*$/);var filterPattern=/\|\s*itemsPerPage\s*:[^|]*/;if(match[2].match(filterPattern)===null){throw 'pagination directive: the \'itemsPerPage\' filter must be set.';}
var itemsPerPageFilterRemoved=match[2].replace(filterPattern,'');var collectionGetter=$parse(itemsPerPageFilterRemoved);addNoCompileAttributes(tElement);var rawId=tAttrs.paginationId||DEFAULT_ID;paginationService.registerInstance(rawId);return function dirPaginationLinkFn(scope,element,attrs){var paginationId=$parse(attrs.paginationId)(scope)||attrs.paginationId||DEFAULT_ID;paginationService.registerInstance(paginationId);var repeatExpression=getRepeatExpression(expression,paginationId);addNgRepeatToElement(element,attrs,repeatExpression);removeTemporaryAttributes(element);var compiled=$compile(element);var currentPageGetter=makeCurrentPageGetterFn(scope,attrs,paginationId);paginationService.setCurrentPageParser(paginationId,currentPageGetter,scope);if(typeof attrs.totalItems!=='undefined'){paginationService.setAsyncModeTrue(paginationId);scope.$watch(function(){return $parse(attrs.totalItems)(scope);},function(result){if(0<=result){paginationService.setCollectionLength(paginationId,result);}});}else{scope.$watchCollection(function(){return collectionGetter(scope);},function(collection){if(collection){paginationService.setCollectionLength(paginationId,collection.length);}});}
compiled(scope);};}
function getRepeatExpression(expression,paginationId){var repeatExpression,idDefinedInFilter=!!expression.match(/(\|\s*itemsPerPage\s*:[^|]*:[^|]*)/);if(paginationId!==DEFAULT_ID&&!idDefinedInFilter){repeatExpression=expression.replace(/(\|\s*itemsPerPage\s*:[^|]*)/,"$1 : '"+paginationId+"'");}else{repeatExpression=expression;}
return repeatExpression;}
function addNgRepeatToElement(element,attrs,repeatExpression){if(element[0].hasAttribute('dir-paginate-start')||element[0].hasAttribute('data-dir-paginate-start')){attrs.$set('ngRepeatStart',repeatExpression);element.eq(element.length-1).attr('ng-repeat-end',true);}else{attrs.$set('ngRepeat',repeatExpression);}}
function addNoCompileAttributes(tElement){angular.forEach(tElement,function(el){if(el.nodeType===Node.ELEMENT_NODE){angular.element(el).attr('dir-paginate-no-compile',true);}});}
function removeTemporaryAttributes(element){angular.forEach(element,function(el){if(el.nodeType===Node.ELEMENT_NODE){angular.element(el).removeAttr('dir-paginate-no-compile');}});element.eq(0).removeAttr('dir-paginate-start').removeAttr('dir-paginate').removeAttr('data-dir-paginate-start').removeAttr('data-dir-paginate');element.eq(element.length-1).removeAttr('dir-paginate-end').removeAttr('data-dir-paginate-end');}
function makeCurrentPageGetterFn(scope,attrs,paginationId){var currentPageGetter;if(attrs.currentPage){currentPageGetter=$parse(attrs.currentPage);}else{var defaultCurrentPage=paginationId+'__currentPage';scope[defaultCurrentPage]=1;currentPageGetter=$parse(defaultCurrentPage);}
return currentPageGetter;}}
function noCompileDirective(){return{priority:5000,terminal:true};}
function dirPaginationControlsTemplateInstaller($templateCache){$templateCache.put('angularUtils.directives.dirPagination.template','<ul class="pagination" ng-if="1 < pages.length"><li ng-if="boundaryLinks" ng-class="{ disabled : pagination.current == 1 }"><a href="" ng-click="setCurrent(1)">&laquo;</a></li><li ng-if="directionLinks" ng-class="{ disabled : pagination.current == 1 }"><a href="" ng-click="setCurrent(pagination.current - 1)">&lsaquo;</a></li><li ng-repeat="pageNumber in pages track by $index" ng-class="{ active : pagination.current == pageNumber, disabled : pageNumber == \'...\' }"><a href="" ng-click="setCurrent(pageNumber)">{{ pageNumber }}</a></li><li ng-if="directionLinks" ng-class="{ disabled : pagination.current == pagination.last }"><a href="" ng-click="setCurrent(pagination.current + 1)">&rsaquo;</a></li><li ng-if="boundaryLinks"  ng-class="{ disabled : pagination.current == pagination.last }"><a href="" ng-click="setCurrent(pagination.last)">&raquo;</a></li></ul>');}
function dirPaginationControlsDirective(paginationService,paginationTemplate){var numberRegex=/^\d+$/;return{restrict:'AE',templateUrl:function(elem,attrs){return attrs.templateUrl||paginationTemplate.getPath();},scope:{maxSize:'=?',onPageChange:'&?',paginationId:'=?'},link:dirPaginationControlsLinkFn};function dirPaginationControlsLinkFn(scope,element,attrs){var rawId=attrs.paginationId||DEFAULT_ID;var paginationId=scope.paginationId||attrs.paginationId||DEFAULT_ID;if(!paginationService.isRegistered(paginationId)&&!paginationService.isRegistered(rawId)){var idMessage=(paginationId!==DEFAULT_ID)?' (id: '+paginationId+') ':' ';throw 'pagination directive: the pagination controls'+idMessage+'cannot be used without the corresponding pagination directive.';}
if(!scope.maxSize){scope.maxSize=9;}
scope.directionLinks=angular.isDefined(attrs.directionLinks)?scope.$parent.$eval(attrs.directionLinks):true;scope.boundaryLinks=angular.isDefined(attrs.boundaryLinks)?scope.$parent.$eval(attrs.boundaryLinks):false;var paginationRange=Math.max(scope.maxSize,5);scope.pages=[];scope.pagination={last:1,current:1};scope.range={lower:1,upper:1,total:1};scope.$watch(function(){return(paginationService.getCollectionLength(paginationId)+1)*paginationService.getItemsPerPage(paginationId);},function(length){if(0<length){generatePagination();}});scope.$watch(function(){return(paginationService.getItemsPerPage(paginationId));},function(current,previous){if(current!=previous&&typeof previous!=='undefined'){goToPage(scope.pagination.current);}});scope.$watch(function(){return paginationService.getCurrentPage(paginationId);},function(currentPage,previousPage){if(currentPage!=previousPage){goToPage(currentPage);}});scope.setCurrent=function(num){if(isValidPageNumber(num)){num=parseInt(num,10);paginationService.setCurrentPage(paginationId,num);}};function goToPage(num){if(isValidPageNumber(num)){scope.pages=generatePagesArray(num,paginationService.getCollectionLength(paginationId),paginationService.getItemsPerPage(paginationId),paginationRange);scope.pagination.current=num;updateRangeValues();if(scope.onPageChange){scope.onPageChange({newPageNumber:num});}}}
function generatePagination(){var page=parseInt(paginationService.getCurrentPage(paginationId))||1;scope.pages=generatePagesArray(page,paginationService.getCollectionLength(paginationId),paginationService.getItemsPerPage(paginationId),paginationRange);scope.pagination.current=page;scope.pagination.last=scope.pages[scope.pages.length-1];if(scope.pagination.last<scope.pagination.current){scope.setCurrent(scope.pagination.last);}else{updateRangeValues();}}
function updateRangeValues(){var currentPage=paginationService.getCurrentPage(paginationId),itemsPerPage=paginationService.getItemsPerPage(paginationId),totalItems=paginationService.getCollectionLength(paginationId);scope.range.lower=(currentPage-1)*itemsPerPage+1;scope.range.upper=Math.min(currentPage*itemsPerPage,totalItems);scope.range.total=totalItems;}
function isValidPageNumber(num){return(numberRegex.test(num)&&(0<num&&num<=scope.pagination.last));}}
function generatePagesArray(currentPage,collectionLength,rowsPerPage,paginationRange){var pages=[];var totalPages=Math.ceil(collectionLength/rowsPerPage);var halfWay=Math.ceil(paginationRange/2);var position;if(currentPage<=halfWay){position='start';}else if(totalPages-halfWay<currentPage){position='end';}else{position='middle';}
var ellipsesNeeded=paginationRange<totalPages;var i=1;while(i<=totalPages&&i<=paginationRange){var pageNumber=calculatePageNumber(i,currentPage,paginationRange,totalPages);var openingEllipsesNeeded=(i===2&&(position==='middle'||position==='end'));var closingEllipsesNeeded=(i===paginationRange-1&&(position==='middle'||position==='start'));if(ellipsesNeeded&&(openingEllipsesNeeded||closingEllipsesNeeded)){pages.push('...');}else{pages.push(pageNumber);}
i++;}
return pages;}
function calculatePageNumber(i,currentPage,paginationRange,totalPages){var halfWay=Math.ceil(paginationRange/2);if(i===paginationRange){return totalPages;}else if(i===1){return i;}else if(paginationRange<totalPages){if(totalPages-halfWay<currentPage){return totalPages-paginationRange+i;}else if(halfWay<currentPage){return currentPage-halfWay+i;}else{return i;}}else{return i;}}}
function itemsPerPageFilter(paginationService){return function(collection,itemsPerPage,paginationId){if(typeof(paginationId)==='undefined'){paginationId=DEFAULT_ID;}
if(!paginationService.isRegistered(paginationId)){throw 'pagination directive: the itemsPerPage id argument (id: '+paginationId+') does not match a registered pagination-id.';}
var end;var start;if(collection instanceof Array){itemsPerPage=parseInt(itemsPerPage)||9999999999;if(paginationService.isAsyncMode(paginationId)){start=0;}else{start=(paginationService.getCurrentPage(paginationId)-1)*itemsPerPage;}
end=start+itemsPerPage;paginationService.setItemsPerPage(paginationId,itemsPerPage);return collection.slice(start,end);}else{return collection;}};}
function paginationService(){var instances={};var lastRegisteredInstance;this.registerInstance=function(instanceId){if(typeof instances[instanceId]==='undefined'){instances[instanceId]={asyncMode:false};lastRegisteredInstance=instanceId;}};this.isRegistered=function(instanceId){return(typeof instances[instanceId]!=='undefined');};this.getLastInstanceId=function(){return lastRegisteredInstance;};this.setCurrentPageParser=function(instanceId,val,scope){instances[instanceId].currentPageParser=val;instances[instanceId].context=scope;};this.setCurrentPage=function(instanceId,val){instances[instanceId].currentPageParser.assign(instances[instanceId].context,val);};this.getCurrentPage=function(instanceId){var parser=instances[instanceId].currentPageParser;return parser?parser(instances[instanceId].context):1;};this.setItemsPerPage=function(instanceId,val){instances[instanceId].itemsPerPage=val;};this.getItemsPerPage=function(instanceId){return instances[instanceId].itemsPerPage;};this.setCollectionLength=function(instanceId,val){instances[instanceId].collectionLength=val;};this.getCollectionLength=function(instanceId){return instances[instanceId].collectionLength;};this.setAsyncModeTrue=function(instanceId){instances[instanceId].asyncMode=true;};this.isAsyncMode=function(instanceId){return instances[instanceId].asyncMode;};}
function paginationTemplateProvider(){var templatePath='angularUtils.directives.dirPagination.template';this.setPath=function(path){templatePath=path;};this.$get=function(){return{getPath:function(){return templatePath;}};};}})();