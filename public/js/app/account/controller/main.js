function account(appObject) {

	// 打开对话框
	layer.open({
		type: 1 //此处以iframe举例
		,title: appObject.attr('title')
		,area: [appObject.attr('app-width')+'px', appObject.attr('app-height')+'px']
		,shade: 0
		,minButton: false
		,maxButton: false
		,taskbar:true
		,moveOut: true
		,content: '<div id="app-content"></div>'
		,zIndex: layer.zIndex //重点1
		,success: function(layero){
			layer.setTop(layero); //重点2
		}
	});

	// 渲染模板
	var appContent = new Vue({
		el: '#app-content',
		template:render('index.html'),
		data : {
			labelPosition: 'right',
			username: userInfo['name'],
			form:{
				oldPassword:'',
				newPassword:''
			}
		},
		methods: {
			submitForm() {
				var vueObject = this;
				$.ajax({
					url:config.url.changePassword,
					type:'POST', // GET
					async:false, // 是否异步
					data:{
						oldPassword:vueObject.form.oldPassword,
						newPassword:vueObject.form.newPassword
					},
					dataType:'json',
					success:function(data,textStatus,jqXHR){
						layer.msg(data.msg,{zIndex: layer.zIndex,success: function(layero){layer.setTop(layero);}});
					},
					error:function(xhr,textStatus){
						console.log('错误')
					}
				});
			}
		}
	});

}