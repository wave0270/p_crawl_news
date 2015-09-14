//khởi tạo hàm String.format
String.format = function() {
	var theString = arguments[0];
	for (var i = 1; i < arguments.length; i++) {
		var regEx = new RegExp("\\{" + (i - 1) + "\\}", "gm");
		theString = theString.replace(regEx, arguments[i]);
	}
	return theString;
};
/**
 * Load Html thông qua proxy. Kết quả trả vè ở dạng json. Nội dung của json bao gồm:
 * - DATA: html content
 * - ENCODING: encoding của html
 * - ERROR_CODE: http error code. 200 = ok.
 * - ERROR_MSG: thông báo lỗi (nếu có) ở dạng string
 * Reference: http://api.jquery.com/jquery.ajax/
 * @param url
 * @param useCache: cờ báo hiệu cho biết có sử dụng cache hay không. Default là có dùng cache.
 * @returns {*}
 */
function getRemoteUrl(url, useCache) {
    var result = null;
    if (useCache == null) useCache = true;  // Nếu không định nghĩa thì default là có sử dụng cache.
    if (useCache == true) {
        // Thử đọc dữ liệu từ session storage. Nếu có dữ liệu thì trả kết quả về.
        response = sessionStorage.getItem(url);
        if (response != null) {
            console.log('getRemoteUrl: cache hit, url=', url);
            result = JSON.parse(response);
        }
    }else{
    	console.log('getRemoteUrl: loading from url=', url);
    	$.ajax({
		    url: URL_ROOT+'server/getUrlContent.php',
		    type: 'POST',
		    async: false,
		    dataType: 'text',
		    data: {
		        address: url
		    },
		    success: function(response) {
		    	// Lưu dữ liệu trong trường hợp có sử dụng cache
	            if (useCache == true) {
	                sessionStorage.setItem(url, response);
	            }
		       result = response;
		    }
		});
    }
	return result;
}
/**
 * Render data to document
 * @param data : html string
 * @returns 
 */
function getUrlCallback(data) {
	try{
		$('#content').html(data);
	} catch (e) {};
	readStyle='style-ebook';
	readSize='size-medium';
	readMargin='margin-x-narrow';
	var arr = readability.init();
	$('.panel-heading').html(arr.title);
	$('.panel-body').html(arr.content);
}
function getUrlFromInput(){
	var url = document.getElementById('url').value;
	getContent(url);
}
function getContent(url){
	if (url == undefined) {url = 'http://vnexpress.net/tin-tuc/the-gioi/phan-tich/vi-sao-co-pho-germanwings-lao-may-bay-xuong-nui-3174380.html';}
	if (url != '') {	
		$('.panel-heading').html('<div id="title"></div>');
		$('.panel-body').html('<div id="content"></div>');
		setTimeout(function(){
			var data = getRemoteUrl(url,false);
	    	getUrlCallback(data);	    		
		},300);
	} else {
		$('#url').notify("URL is empty!", {
			className : 'error',
			position : "top",
			autoHideDelay : 1000,
			showDuration : 300,
			hideDuration : 200
		});
	} 
}
