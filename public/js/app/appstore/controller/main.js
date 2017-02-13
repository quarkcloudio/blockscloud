function appstore(appObject) {

	// 打开对话框
	layer.open({
		type: 1 //此处以iframe举例
		,title: appObject.attr('title')
		,area: [appObject.attr('app-width')+'px', appObject.attr('app-height')+'px']
		,shade: 0
		,minButton: true
		,maxButton: true
		,taskbar:true
		,moveOut: true
		,content: '<div id="app-content"></div>'
		,zIndex: layer.zIndex //重点1
		,success: function(layero){
			layer.setTop(layero); //重点2
		}
	});

	// 渲染模板
	new Vue({
		el: '#app-content',
		template:render('index.html'),
		data:{
			items: [],
			total: 0,
		},
		methods: {
			handleSizeChange(val) {
				alert(`每页 ${val} 条`);
			},
			handleCurrentChange(val) {
				this.currentPage = val;
				// ajax请求后台数据
				var vueObject = this;
				$.ajax({
					url:config.url.appstoreIndex,
					type:'GET', // GET
					async:false, // 是否异步
					data:{
						page:val
					},
					dataType:'json',
					success:function(data,textStatus,jqXHR){
						if (data.status == 'success') {
							vueObject.items = data.data.lists;
							vueObject.total = data.data.total;
						} else {
							layer.msg(data.msg,{zIndex: layer.zIndex,success: function(layero){layer.setTop(layero);}});
						}
					},
					error:function(xhr,textStatus){
						console.log('错误')
					}
				});
			},
			appInfo(appID) {
				getAppInfo(appID)
			}
		},
		mounted: function () {
			// ajax请求后台数据
			var vueObject = this;
			$.ajax({
				url:config.url.appstoreIndex,
				type:'GET', // GET
				async:false, // 是否异步
				data:{
					page:1
				},
				dataType:'json',
				success:function(data,textStatus,jqXHR){
					if (data.status == 'success') {
						vueObject.items = data.data.lists;
						vueObject.total = data.data.total;
					} else {
						layer.msg(data.msg,{zIndex: layer.zIndex,success: function(layero){layer.setTop(layero);}});
					}
				},
				error:function(xhr,textStatus){
					console.log('错误')
				}
			});
        }
	});

}

function getAppInfo(appID) {

	template = '<div class="appInfo-wrapper" id="appInfo-wrapper" style="padding: 20px; font-size: 18px;">\
					<el-row>\
						<el-col :span="8"><img :src="appInfo.icon" width="100%" /></el-col>\
						<el-col :span="1">&nbsp;</el-col>\
						<el-col :span="15">\
							<el-row>\
								<el-col :span="24"><h3>{{appInfo.title}}</h3></el-col>\
							</el-row>\
							<el-row>\
								<el-col :span="24"><h5>版本号：{{appInfo.version}}</h5></el-col>\
							</el-row>\
							<el-row>\
								<el-col :span="24"><h5>作者：{{appInfo.author}}</h5></el-col>\
							</el-row>\
						</el-col>\
					</el-row>\
					<hr>\
					<el-form ref="form" :model="form" label-width="100px">\
						<el-form-item label="添加到桌面 ">\
							<el-switch @change="addToDesktop" on-text="" off-text="" v-model="form.desktop"></el-switch>\
						</el-form-item>\
						<el-form-item label="添加到Dock">\
							<el-switch @change="addToDock" on-text="" off-text="" v-model="form.dock"></el-switch>\
						</el-form-item>\
					</el-form>\
				</div>';

	// 打开对话框
	layer.open({
		type: 1 //此处以iframe举例
		,title: '程序设置'
		,area: ['460px','460px']
		,shade: 0
		,minButton: true
		,maxButton: true
		,taskbar:true
		,content:template
		,zIndex: layer.zIndex //重点1
		,success: function(layero){
			layer.setTop(layero); //重点2
		}
	});

	// 渲染模板
	new Vue({
		el: '#appInfo-wrapper',
		data:{
			appInfo: [],
			form: {
				desktop: false,
				dock: false,
			}
		},
		methods: {
			addToDesktop(val) {
				// ajax请求后台数据
				var appInfoObject = this;
				$.ajax({
					url:config.url.addToDesktop,
					type:'GET', // GET
					async:false, // 是否异步
					data:{
						status:val,
						id:appInfoObject.appInfo.id
					},
					dataType:'json',
					success:function(data,textStatus,jqXHR){
						if (data.status == 'success') {
							if (data.data == 'true') {
								appInfoObject.form.desktop = true;
								html = "<div class='app-box middle appdblclick "+appInfoObject.appInfo.context+"' title='"+appInfoObject.appInfo.title+"' app-name='"+appInfoObject.appInfo.name+"' app-width="+appInfoObject.appInfo.width+" app-height="+appInfoObject.appInfo.height+">\
								<span class='app-icon'><img class='img-rounded' src='"+appInfoObject.appInfo.icon+"' alt='"+appInfoObject.appInfo.title+"' app-width="+appInfoObject.appInfo.width+" app-height="+appInfoObject.appInfo.height+"></span>\
								<span class='app-name'>"+appInfoObject.appInfo.title+"</span>\
								<div class='clear'></div>\
								</div>";
								$('.desktop .app-list').append(html);
							} else {
								appInfoObject.form.desktop = false;
								$('.desktop .app-list').find('.'+appInfoObject.appInfo.context).remove();
							}
							// 重排图标
							appsort.init();
						} else {
							layer.msg(data.msg,{zIndex: layer.zIndex,success: function(layero){layer.setTop(layero);}});
						}
					},
					error:function(xhr,textStatus){
						console.log('错误')
					}
				});
			},
			addToDock(val) {
				// ajax请求后台数据
				var appInfoObject = this;
				$.ajax({
					url:config.url.addToDock,
					type:'GET', // GET
					async:false, // 是否异步
					data:{
						status:val,
						id:appInfoObject.appInfo.id
					},
					dataType:'json',
					success:function(data,textStatus,jqXHR){
						if (data.status == 'success') {
							if (data.data == 'true') {
								appInfoObject.form.dock = true;
								html = "<li class='"+appInfoObject.appInfo.context+"'>\
										<a class='appclick' title='"+appInfoObject.appInfo.title+"' app-name='"+appInfoObject.appInfo.name+"' app-width='"+appInfoObject.appInfo.width+"' app-height='"+appInfoObject.appInfo.height+"'>\
										<span style='display: none;'>"+appInfoObject.appInfo.title+"</span>\
										<img src='"+appInfoObject.appInfo.icon+"'>\
										</a>\
										</li>";
								$('#dock-menu-list').append(html);
							} else {
								appInfoObject.form.dock = false;
								$('#dock-menu-list').find('.'+appInfoObject.appInfo.context).remove();
							}
						} else {
							layer.msg(data.msg,{zIndex: layer.zIndex,success: function(layero){layer.setTop(layero);}});
						}
					},
					error:function(xhr,textStatus){
						console.log('错误')
					}
				});
			}
		},
		mounted: function () {
			// ajax请求后台数据
			var appInfoObject = this;
			$.ajax({
				url:config.url.appInfo,
				type:'GET', // GET
				async:false, // 是否异步
				data:{
					id:appID
				},
				dataType:'json',
				success:function(data,textStatus,jqXHR){
					if (data.status == 'success') {
						appInfoObject.appInfo = data.data.appInfo;
						appInfoObject.form.desktop = data.data.desktop;
						appInfoObject.form.dock = data.data.dock;
					} else {
						layer.msg(data.msg,{zIndex: layer.zIndex,success: function(layero){layer.setTop(layero);}});
					}
				},
				error:function(xhr,textStatus){
					console.log('错误')
				}
			});
		}
	});
}