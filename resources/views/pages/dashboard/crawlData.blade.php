<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta content="width=device-width,initial-scale = 1" name="viewport">
        <meta name="csrf-token" content="{!! Session::token() !!}">
        <link href="{{asset('/libs/bootstrap/css/bootstrap.min.css')}}" type="text/css" rel="stylesheet" />
        <!-- --------------------------------------- -->
		<script type="text/javascript" src="{{asset('/libs/jquery/jquery.min.js')}}"></script>
		<script type="text/javascript" src="{{asset('/libs/notify/notify.min.js')}}"></script>
    	<script type="text/javascript" src="{{asset('/js/crawl/readability.js')}}"></script>
    	<script type="text/javascript" src="{{asset('/js/crawl/custom.js')}}"></script>
    	<script>
    		var URL_ROOT = "{{ URL::route('index') }}/";
    		var TOKEN	 = "{{csrf_token()}}"
		</script>
    </head>
    <body>
    	<div class="container" style="margin-top: 10px; padding-right: 5px; padding-left: 5px; width: 100%; overflow-x:hidden;">
    		<div id="submit-div">
		        <input id="url" type="text" class="form-control" placeholder="URL here...">
		        <button id="get-content" class="btn btn-info" type="button" onclick="getUrlFromInput()">Get Content</button>
    		</div>
    		<div class="group">
				<div class="panel-heading">

				</div>
				<div class="panel-body">

				</div>
			</div>
		</div>
	    <script>
	    	function getListAll(souceObj,url_page,num_page,list_arr){
	    		/*first page*/
	    		for(var i=souceObj.csspath.length-1; i>=0; i--){
	    			list_arr = getList(souceObj.url,souceObj.csspath[i],list_arr);
	    		}
	    		/*from page 2*/
	    		for( var i=2 ; i<=num_page; i++){
	    			list_arr = getList(String.format(url_page,i),souceObj.csspath[0],list_arr);
	    		}
	    		return list_arr;
	    	}
	    	function getList(url,csspath,list_arr){
	    		console.log(url)
	    		var html = getRemoteUrl(url,false);
	    		var htmlDOM = document.createElement("html");
	    		$(htmlDOM).html(html);
	    		var list = $(htmlDOM).find(csspath.parent_path)
	    		console.log(list.length)
	    		for( var i=0; i<list.length; i++){
	    			var obj = {
	    				title 	: $(list[i]).find(csspath.title_path)[0].innerText.trim(),
	    				href	: $(list[i]).find(csspath.href_path)[0].href,
	    				image	: $(list[i]).find(csspath.image_path)[0].src,
	    				desc	: $(list[i]).find(csspath.desc_path)[0].innerText.trim(),
	    			};
	    			list_arr.push(obj);
	    		}
	    		return list_arr;
	    	}
	    	function saveToDatabase(arr,domain,type){
	    		var params = {
	    			_token	: TOKEN,
	    			arr		: arr,
	    			domain	: domain,
	    			type	: type,
	    		};
	    		$.post(URL_ROOT + 'aj_save_news', params, function (data) {
	    			console.log(data)
	    			//todo
			    }).always(function() {
			    	//todo
			    }).error(function(e){
			    	if(e.status == 401){
			    		//todo
			    	}
			    });
	    	}
	    	$(document).ready(function(){
	    		vnexpress_beauty = [
	    			{
	    				url_page 	: "http://suckhoe.vnexpress.net/tin-tuc/khoe-dep/page/{0}.html",
	    				url			: "http://suckhoe.vnexpress.net/tin-tuc/khoe-dep",
	    			},
	    			{
	    				url_page 	: "http://suckhoe.vnexpress.net/tin-tuc/dinh-duong/page/{0}.html",
	    				url 		: "http://suckhoe.vnexpress.net/tin-tuc/dinh-duong",
	    			},
	    			{
	    				url_page 	: "http://giaitri.vnexpress.net/tin-tuc/gioi-sao/page/{0}.html",
	    				url 		: "http://giaitri.vnexpress.net/tin-tuc/gioi-sao",
	    			}
	    		];
	    		
	    		var national_vnexpress_obj = {
	    			domain		: 'vnexpress.net',
	    			type		: 'beauty',
	    			url_page 	: vnexpress_beauty[0].url_page,
	    			num_page	: 1,
	    			souceObj	: {
			    		url 	: vnexpress_beauty[0].url,
			    		csspath		: [
			    			{
			    				parent_path	: '#col_1 .list_news > li',
					    		title_path	: '.title_news .txt_link',
					    		href_path	: '.title_news .txt_link',
					    		image_path	: '.thumb img',
					    		desc_path	: '.news_lead',
			    			},
			    			{
			    				parent_path	: '.content_scoller > ul > li',
					    		title_path	: '.title_news .txt_link',
					    		href_path	: '.title_news .txt_link',
					    		image_path	: '.icon_content',
					    		desc_path	: '.news_lead',
			    			},
			    			{
			    				parent_path	: '.box_hot_news',
					    		title_path	: '.title_news .txt_link',
					    		href_path	: '.title_news .txt_link',
					    		image_path	: '.width_image_common',
					    		desc_path	: '.news_lead',
			    			}
			    		]
			    	}
	    		}
	    		
	    		var arr = [];
	   			for(var i=0; i<vnexpress_beauty.length; i++){
	   				national_vnexpress_obj.url_page = vnexpress_beauty[i].url_page;
	   				national_vnexpress_obj.souceObj.url = vnexpress_beauty[i].url;
	   				arr = getListAll(national_vnexpress_obj.souceObj,national_vnexpress_obj.url_page,national_vnexpress_obj.num_page,arr);
	   				console.log(arr)
	   			}
	   			console.log(arr)
	    		// saveToDatabase(arr,national_vnexpress_obj.domain,national_vnexpress_obj.type);
	    	});
    	</script>
    </body>
</html>