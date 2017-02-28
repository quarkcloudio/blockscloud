function word(appObject) {

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
	var postIndex = Vue.extend({
		template: '#postIndex',
		data: function() {
			return {
				tableData: [],
				formInline: {
				name: '',
				status: ''
				},
				total: 0,
				multipleSelection: []
			}
		},
		methods: {
			onSubmit() {
				// ajax请求后台数据
				var _self = this;
				$.ajax({
					url:config.url.userSetAllStatus,
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
			onSearch() {
				this.showData();
			},
			addDialog() {
				// ajax请求后台数据
				var _self = this;
				// 打开对话框
				var index = layer.open({
						type: 1 
						,title: '添加文章'
						,area: ['800px', '380px']
						,shade: 0
						,minButton: true
						,maxButton: true
						,taskbar:true
						,moveOut: true
						,content: render('postCreate.html')
						,zIndex: layer.zIndex //重点1
						,success: function(layero){
							layer.setTop(layero); //重点2
						}
					});
				new Vue({
					el: '#postCreate',
					data : {
						form:{
							name:'',
							email:'',
							password:'',
						}
					},
					methods: {
						submitForm(formName) {
							// ajax请求后台数据
							var _subSelf = this;
							$.ajax({
								url:config.url.postStore,
								type:'POST', // GET
								async:false, // 是否异步
								data:{
									name:_subSelf.form.name,
									email:_subSelf.form.email,
									password:_subSelf.form.password,
								},
								dataType:'json',
								success:function(data,textStatus,jqXHR){
									if (data.status == 'success') {
										_self.showData();
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
					}
				});

			},
			editDialog(index, rows) {
				var id = rows[index]['id'];
				var _self = this;
				// 打开对话框
				var index = layer.open({
					type: 1 
					,title: '编辑文章'
					,area: ['800px', '380px']
					,shade: 0
					,minButton: true
					,maxButton: true
					,taskbar:true
					,moveOut: true
					,content: render('postCreate.html')
					,zIndex: layer.zIndex //重点1
					,success: function(layero){
						layer.setTop(layero); //重点2
					}
				});
				new Vue({
					el: '#postCreate',
					data : {
						form:{
							name:'',
							email:'',
							password:'',
						}
					},
					methods: {
						submitForm(formName) {
							// ajax请求后台数据
							var _subSelf = this;
							$.ajax({
								url:config.url.postUpdate,
								type:'POST', // GET
								async:false, // 是否异步
								data:{
									id:_subSelf.form.id,
									name:_subSelf.form.name,
									email:_subSelf.form.email,
									password:_subSelf.form.password,
								},
								dataType:'json',
								success:function(data,textStatus,jqXHR){
									if (data.status == 'success') {
										_self.showData();
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
							url:config.url.postEdit,
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
			deleteRow(index, rows) {
				this.setStatus(rows[index]['id'],-1);
				rows.splice(index, 1);
			},
			forbidRow(index, rows) {
				if(rows[index]['status'] == 1) {
					status = -2
				} else if(rows[index]['status'] == -2) {
					status = 1
				}
				this.setStatus(rows[index]['id'],status);
			},
			handleSizeChange(val) {
				alert(`每页 ${val} 条`);
			},
			handleCurrentChange(val) {
				this.currentPage = val;
				this.showData(val);
			},handleSelectionChange(val) {
				this.multipleSelection = val;
			},showData(page = 1) {
				// ajax请求后台数据
				var _self = this;
				$.ajax({
					url:config.url.postIndex,
					type:'GET', // GET
					async:false, // 是否异步
					data:{
						page:page,
						name:_self.formInline.name
					},
					dataType:'json',
					success:function(data,textStatus,jqXHR){
						if (data.status == 'success') {
							_self.tableData = data.data.lists;
							_self.total = data.data.total;
						} else {
							_self.$message.error(data.msg);
						}
					},
					error:function(xhr,textStatus){
						console.log('错误')
					}
				});
			},setStatus(id,status) {
				// ajax请求后台数据
				var _self = this;
				$.ajax({
					url:config.url.postSetStatus,
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
			this.showData();
        }
	});

	// 定义组件
	var postCateIndex = Vue.extend({
		template: '#postCateIndex',
		data: function() {
			return {
				tableData: [],
				formInline: {
				name: '',
				status: ''
				},
				multipleSelection: []
			}
		},
		methods: {
			onSubmit() {
				// ajax请求后台数据
				var _self = this;
				$.ajax({
					url:config.url.postCateSetAllStatus,
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
			onSearch() {
				this.showData();
			},
			addDialog() {
				// ajax请求后台数据
				var _self = this;
				// 打开对话框
				var index = layer.open({
						type: 1 
						,title: '添加分类目录'
						,area: ['400px', '580px']
						,shade: 0
						,minButton: false
						,maxButton: false
						,taskbar:true
						,moveOut: true
						,content: render('postCateCreate.html')
						,zIndex: layer.zIndex //重点1
						,success: function(layero){
							layer.setTop(layero); //重点2
						}
					});
				new Vue({
					el: '#postCateCreate',
					data : {
						form:{
							name:'',
							slug:'',
							pid:'',
							lists_tpl:'lists_tpl',
							detail_tpl:'detail_tpl',
							page_num:20,
							options: []
						}
					},
					methods: {
						submitForm(formName) {
							// ajax请求后台数据
							var _subSelf = this;
							$.ajax({
								url:config.url.postCateStore,
								type:'POST', // GET
								async:false, // 是否异步
								data:{
									name:_subSelf.form.name,
									slug:_subSelf.form.slug,
									pid:_subSelf.form.pid,
									lists_tpl:_subSelf.form.lists_tpl,
									detail_tpl:_subSelf.form.detail_tpl,
									page_num:_subSelf.form.page_num,
								},
								dataType:'json',
								success:function(data,textStatus,jqXHR){
									if (data.status == 'success') {
										_self.showData();
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
							url:config.url.postCateCreate,
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
			editDialog(index, rows) {
				var id = rows[index]['id'];
				var _self = this;
				// 打开对话框
				var index = layer.open({
					type: 1 
					,title: '编辑分类目录'
					,area: ['400px', '580px']
					,shade: 0
					,minButton: true
					,maxButton: true
					,taskbar:true
					,moveOut: true
					,content: render('postCateCreate.html')
					,zIndex: layer.zIndex //重点1
					,success: function(layero){
						layer.setTop(layero); //重点2
					}
				});
				new Vue({
					el: '#postCateCreate',
					data : {
						form:{
							name:'',
							slug:'',
							pid:'',
							lists_tpl:'lists_tpl',
							detail_tpl:'detail_tpl',
							page_num:20,
							options: []
						}
					},
					methods: {
						submitForm(formName) {
							// ajax请求后台数据
							var _subSelf = this;
							$.ajax({
								url:config.url.postCateUpdate,
								type:'POST', // GET
								async:false, // 是否异步
								data:{
									id:_subSelf.form.id,
									uuid:_subSelf.form.uuid,
									name:_subSelf.form.name,
									slug:_subSelf.form.slug,
									pid:_subSelf.form.pid,
									lists_tpl:_subSelf.form.lists_tpl,
									detail_tpl:_subSelf.form.detail_tpl,
									page_num:_subSelf.form.page_num,
								},
								dataType:'json',
								success:function(data,textStatus,jqXHR){
									if (data.status == 'success') {
										_self.showData();
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
							url:config.url.postCateEdit,
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
			deleteRow(index, rows) {
				this.setStatus(rows[index]['id'],-1);
				rows.splice(index, 1);
			},
			forbidRow(index, rows) {
				if(rows[index]['status'] == 1) {
					status = -2
				} else if(rows[index]['status'] == -2) {
					status = 1
				}
				this.setStatus(rows[index]['id'],status);
			},handleSelectionChange(val) {
				this.multipleSelection = val;
			},showData() {
				// ajax请求后台数据
				var _self = this;
				$.ajax({
					url:config.url.postCateIndex,
					type:'GET', // GET
					async:false, // 是否异步
					data:{
						name:_self.formInline.name
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
			},setStatus(id,status) {
				// ajax请求后台数据
				var _self = this;
				$.ajax({
					url:config.url.postCateSetStatus,
					type:'GET', // GET
					async:false, // 是否异步
					data:{
						id:id,
						status:status
					},
					dataType:'json',
					success:function(data,textStatus,jqXHR){
						if (data.status == 'success') {
							_self.showData();
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
			this.showData();
        }
	});

	// 定义路由
    var router = new VueRouter({
        routes: [
            { path: '/', name: 'postIndex', component: postIndex },
            { path: '/postIndex', name: 'postIndex', component: postIndex },
            { path: '/postCateIndex', name: 'postCateIndex', component: postCateIndex }
        ]
    });

	new Vue({
		el: '#user',
		router:router,
		methods: {
			handleOpen(key, keyPath) {
				console.log(key, keyPath);
			},
			handleClose(key, keyPath) {
				console.log(key, keyPath);
			}
		}
	});

}