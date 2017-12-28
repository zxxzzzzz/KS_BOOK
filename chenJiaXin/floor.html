/*
*
*  date:2017/12/26
*
*  Content-Type:application/json
*
*  param:
*      url: url
*      method: get/post/delete/put    get not suppport array data like {data:{a:xxxx}}
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
	else{
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
