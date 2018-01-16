/*
*
*  date:2017/12/26
*  
*  Content-Type:application/json
*  get not suppport 不支持get 请求
*  param:
*      url: url
*      method: get/post/delete/put    
*      data: {a:"bb",c:"dd"}
*  return: 
*      json str
*/
function doAjax(url, method, data, callback){
	var myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json");	
	/* $.ajax({
		type:'get',
		data:{"data":[{"a":12,"cv":"234"}]},
		url:'/tp5/public/index/login/test',
		success:function(re){
			console.log(re)
		}
	}) 测试代码*/
	//console.log(url)
	if(method == 'get'){
		if(data === ''){ //data为空对象表示直接使用url不拼接数据
			fetch(url,{
			method:method,
			headers:myHeaders
			})
			.then(function(response){
				return response.json()
			})
			.then(function(datajson){
				callback(datajson)
			})
		}
		else{
			url = url + '?'
			for(var key in data){
				if(Array.isArray(data[key])){
					data[key].forEach(function(value, index){
						for(var key2 in value){
							url = url + '&' + key + '['+ index +']' +'[' + key2 + ']' + '=' + value[key2]
						}
					})
				}
				else{
					url = url + '&' + key + '=' +data[key]
				}
			}
			url = url.replace(/&/,'')
			fetch(url,{
				method:method,
				headers:myHeaders
			})
			.then(function(response){
				return response.json()
			})
			.then(function(datajson){
				callback(datajson)
			})
		}
		
	}
	else{ //post put delete
		fetch(url,{
			body:JSON.stringify(data),
			method:method,
			headers:myHeaders
		})
		.then(function(response){
			return response.json()
		})
		.then(function(datajson){
			callback(datajson)
		})
	}
	
}
/**
 * 
 * @param {url key} key
 * if key='' will return all key-value map
 * todo url array is not support 
 */
function getUrlParamsMap(key = ''){
	var param = window.location.search.split('?')[1]
	var paramsMap = {}
	param.split('&').forEach(function(fuckvar){
		var params = fuckvar.split('=')
		params.forEach(function(value, index){
			if(index%2 == 0){
				paramsMap[value] = params[index+1]
			}
		})
	})
	
	if(key == ''){
		return paramsMap
	}
	else{
		return paramsMap[key]
	}
}
/**
 * return str '2017-12-12 02:02:02'
 */
function getNow(minute = 0){
	day = parseInt(minute/1440)
	hour = parseInt((minute-day*1440)/60)
	minute = parseInt(minute - day*1440 - hour*60)
	var mydate = new Date()
	return mydate.getFullYear() +'-'+ (mydate.getMonth()+1) +'-'+ (mydate.getDate()+day) +' '+(mydate.getHours()+hour)+':'+(mydate.getMinutes()+minute)+':'+mydate.getSeconds()
}
