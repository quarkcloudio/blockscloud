function navbar(appObject) {

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
		,content: render('index.html')
		,zIndex: layer.zIndex //重点1
		,success: function(layero){
			layer.setTop(layero); //重点2
		}
	});

	// 定义组件
	var navbarindex = Vue.extend({
		template: '#navbarindex',
		data: function() {
			return {
				tableData: [],
				formInline: {
				title: '',
				status: ''
				},
				total: 0,
				multipleSelection: []
			}
		},
		methods: {
			onSubmit : function () {
				// ajax请求后台数据
				var _self = this;
				$.ajax({
					url:config.url.navbarSetAllStatus,
					type:'POST',
					data:{
						status:_self.formInline.status,
						selection:_self.multipleSelection
					},
					dataType:'json',
					success:function(data,textStatus,jqXHR){
						if (data.status == 'success') {
							_self.showData(_self.currentPage);
							_self.$message({
								message: data.msg,
								type: 'success'
							});
						} else {
							_self.$message.error(data.msg);
						}
					},
					error:function(xhr,textStatus){
						console.log('错误')
					}
				});
			},
			onSearch : function () {
				this.showData(1);
			},
			addDialog : function () {
				// ajax请求后台数据
				var _self = this;
				// 打开对话框
				var index = layer.open({
						type: 1 
						,title: '添加导航'
						,area: ['360px', '430px']
						,shade: 0
						,minButton: true
						,maxButton: true
						,taskbar:true
						,moveOut: true
						,content: render('navbarcreate.html')
						,zIndex: layer.zIndex //重点1
						,success: function(layero){
							layer.setTop(layero); //重点2
						}
					});
				new Vue({
					el: '#navbarcreate',
					data : {
						form:{
							title:'',
							pid:'',
							url:'',
							sort:'',
							options: []
						}
					},
					methods: {
						submitForm : function (formName) {
							// ajax请求后台数据
							var _subSelf = this;
							$.ajax({
								url:config.url.navbarStore,
								type:'POST', // GET
								async:false, // 是否异步
								data:{
									title:_subSelf.form.title,
									pid:_subSelf.form.pid,
									url:_subSelf.form.url,
									sort:_subSelf.form.sort,
								},
								dataType:'json',
								success:function(data,textStatus,jqXHR){
									if (data.status == 'success') {
										_self.showData(1);
										_self.$message({
											message: data.msg,
											type: 'success'
										});
										layer.close(index);
									} else {
										_self.$message.error(data.msg);
									}
								},
								error:function(xhr,textStatus){
									console.log('错误')
								}
							});

						}
					},
					mounted: function () {
						var _subSelf = this;
						$.ajax({
							url:config.url.navbarCreate,
							type:'GET', // GET
							async:false, // 是否异步
							dataType:'json',
							success:function(data,textStatus,jqXHR){
								if (data.status == 'success') {
									_subSelf.form.options = data.data;
								} else {
									_subSelf.$message.error(data.msg);
								}
							},
							error:function(xhr,textStatus){
								console.log('错误')
							}
						});
					}
				});

			},
			editDialog : function (index, rows) {
				var id = rows[index]['id'];
				var _self = this;
				// 打开对话框
				var index = layer.open({
					type: 1 
					,title: '编辑导航'
					,area: ['360px', '430px']
					,shade: 0
					,minButton: true
					,maxButton: true
					,taskbar:true
					,moveOut: true
					,content: render('navbarcreate.html')
					,zIndex: layer.zIndex //重点1
					,success: function(layero){
						layer.setTop(layero); //重点2
					}
				});
				new Vue({
					el: '#navbarcreate',
					data : {
						form:{
							title:'',
							pid:'',
							url:'',
							sort:'',
							options: []
						}
					},
					methods: {
						submitForm : function (formName) {
							// ajax请求后台数据
							var _subSelf = this;
							$.ajax({
								url:config.url.navbarUpdate,
								type:'POST', // GET
								async:false, // 是否异步
								data:{
									id:_subSelf.form.id,
									title:_subSelf.form.title,
									pid:_subSelf.form.pid,
									url:_subSelf.form.url,
									sort:_subSelf.form.sort,
								},
								dataType:'json',
								success:function(data,textStatus,jqXHR){
									if (data.status == 'success') {
										_self.showData(1);
										_self.$message({
											message: data.msg,
											type: 'success'
										});
										layer.close(index);
									} else {
										_self.$message.error(data.msg);
									}
								},
								error:function(xhr,textStatus){
									console.log('错误')
								}
							});

						}
					},
					mounted: function () {
						var _subSelf = this;
						$.ajax({
							url:config.url.navbarEdit,
							type:'GET', // GET
							async:false, // 是否异步
							data:{
								id:id
							},
							dataType:'json',
							success:function(data,textStatus,jqXHR){
								if (data.status == 'success') {
									_subSelf.form = data.data;
								} else {
									_self.$message.error(data.msg);
								}
							},
							error:function(xhr,textStatus){
								console.log('错误')
							}
						});
					}
				});
			},
			deleteRow : function (index, rows) {
				this.setStatus(rows[index]['id'],-1);
				rows.splice(index, 1);
			},
			forbidRow : function (index, rows) {
				if(rows[index]['status'] == 1) {
					status = -2
				} else if(rows[index]['status'] == -2) {
					status = 1
				}
				this.setStatus(rows[index]['id'],status);
			},
			handleSelectionChange : function (val) {
				this.multipleSelection = val;
			},showData : function (page) {
				// ajax请求后台数据
				var _self = this;
				$.ajax({
					url:config.url.navbarIndex,
					type:'GET', // GET
					async:false, // 是否异步
					data:{
						page:page,
						title:_self.formInline.title
					},
					dataType:'json',
					success:function(data,textStatus,jqXHR){
						if (data.status == 'success') {
							_self.tableData = data.data;
						} else {
							_self.$message.error(data.msg);
						}
					},
					error:function(xhr,textStatus){
						console.log('错误')
					}
				});
			},setStatus : function (id,status) {
				// ajax请求后台数据
				var _self = this;
				$.ajax({
					url:config.url.navbarSetStatus,
					type:'GET', // GET
					async:false, // 是否异步
					data:{
						id:id,
						status:status
					},
					dataType:'json',
					success:function(data,textStatus,jqXHR){
						if (data.status == 'success') {
							_self.showData(_self.currentPage);
							_self.$message({
								message: data.msg,
								type: 'success'
							});
						} else {
							_self.$message.error(data.msg);
						}
					},
					error:function(xhr,textStatus){
						console.log('错误')
					}
				});
			}
		},
		mounted: function () {
			this.showData(1);
        }
	});

	// 定义路由
    var router = new VueRouter({
        routes: [
            { path: '/', name: 'navbarindex', component: navbarindex },
            { path: '/navbarindex', name: 'navbarindex', component: navbarindex }
        ]
    });

	new Vue({
		el: '#i-navbar',
		router:router,
		methods: {
			handleOpen : function (key, keyPath) {
				console.log(key, keyPath);
			},
			handleClose : function (key, keyPath) {
				console.log(key, keyPath);
			}
		}
	});

}