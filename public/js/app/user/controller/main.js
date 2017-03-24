function user(appObject) {

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
	var userindex = Vue.extend({
		template: '#userindex',
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
			onSubmit : function () {
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
			onSearch : function () {
				this.showData(1);
			},
			addDialog : function () {
				// ajax请求后台数据
				var _self = this;
				// 打开对话框
				var index = layer.open({
						type: 1 
						,title: '添加用户'
						,area: ['400px', '380px']
						,shade: 0
						,minButton: true
						,maxButton: true
						,taskbar:true
						,moveOut: true
						,content: render('usercreate.html')
						,zIndex: layer.zIndex //重点1
						,success: function(layero){
							layer.setTop(layero); //重点2
						}
					});
				new Vue({
					el: '#usercreate',
					data : {
						form:{
							name:'',
							email:'',
							password:'',
						}
					},
					methods: {
						submitForm : function (formName) {
							// ajax请求后台数据
							var _subSelf = this;
							$.ajax({
								url:config.url.userStore,
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
					}
				});

			},
			roleuserDialog : function (index, rows) {
				var id = rows[index]['id'];
				var name = rows[index]['name'];
				var _self = this;
				// 打开对话框
				var index = layer.open({
					type: 1 
					,title: '用户组'
					,area: ['600px', '500px']
					,shade: 0
					,minButton: false
					,maxButton: false
					,taskbar:true
					,moveOut: true
					,content: render('roleuser.html')
					,zIndex: layer.zIndex //重点1
					,success: function(layero){
						layer.setTop(layero); //重点2
					}
				});
				new Vue({
					el: '#roleuser',
					data : {
						form:{
							name:'',
						},
						checkAll: false,
						checkedRoles: [],
						roles: [],
						isIndeterminate: false
					},
					methods: {
						submitForm : function (formName) {
							// ajax请求后台数据
							var _subSelf = this;
							$.ajax({
								url:config.url.userAssignRole,
								type:'POST', // GET
								async:false, // 是否异步
								data:{
									id:id,
									roles:_subSelf.checkedRoles,
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

						},
						handleCheckAllChange : function (event) {
							this.checkedRoles = event.target.checked ? this.roles : [];
							this.isIndeterminate = false;
						},
						handleCheckedChange : function (value) {
							var checkedCount = value.length;
							this.checkAll = checkedCount === this.roles.length;
							this.isIndeterminate = checkedCount > 0 && checkedCount < this.roles.length;
						}
					},
					mounted: function () {
						var _subSelf = this;
						this.form.name = name;
						$.ajax({
							url:config.url.userRoles,
							type:'GET', // GET
							async:false, // 是否异步
							data:{
								id:id
							},
							dataType:'json',
							success:function(data,textStatus,jqXHR){
								if (data.status == 'success') {
									_subSelf.roles = data.data.lists;
									_subSelf.checkedRoles = data.data.checkedRoles;
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
			editDialog : function (index, rows) {
				var id = rows[index]['id'];
				var _self = this;
				// 打开对话框
				var index = layer.open({
					type: 1 
					,title: '编辑用户'
					,area: ['400px', '380px']
					,shade: 0
					,minButton: true
					,maxButton: true
					,taskbar:true
					,moveOut: true
					,content: render('usercreate.html')
					,zIndex: layer.zIndex //重点1
					,success: function(layero){
						layer.setTop(layero); //重点2
					}
				});
				new Vue({
					el: '#usercreate',
					data : {
						form:{
							name:'',
							email:'',
							password:'',
						}
					},
					methods: {
						submitForm : function (formName) {
							// ajax请求后台数据
							var _subSelf = this;
							$.ajax({
								url:config.url.userUpdate,
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
							url:config.url.userEdit,
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
			handleSizeChange : function (val) {
				// alert(`每页 ${val} 条`);
			},
			handleCurrentChange : function (val) {
				this.currentPage = val;
				this.showData(val);
			},handleSelectionChange : function (val) {
				this.multipleSelection = val;
			},showData : function (page) {
				// ajax请求后台数据
				var _self = this;
				$.ajax({
					url:config.url.userIndex,
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
			},setStatus : function (id,status) {
				// ajax请求后台数据
				var _self = this;
				$.ajax({
					url:config.url.userSetStatus,
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

	// 定义组件
	var roleindex = Vue.extend({
		template: '#roleindex',
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
			onSubmit : function () {
				// ajax请求后台数据
				var _self = this;
				$.ajax({
					url:config.url.roleSetAllStatus,
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
						,title: '添加用户组'
						,area: ['400px', '380px']
						,shade: 0
						,minButton: true
						,maxButton: true
						,taskbar:true
						,moveOut: true
						,content: render('rolecreate.html')
						,zIndex: layer.zIndex //重点1
						,success: function(layero){
							layer.setTop(layero); //重点2
						}
					});
				new Vue({
					el: '#rolecreate',
					data : {
						form:{
							name:'',
							display_name:'',
							description:'',
						}
					},
					methods: {
						submitForm : function (formName) {
							// ajax请求后台数据
							var _subSelf = this;
							$.ajax({
								url:config.url.roleStore,
								type:'POST', // GET
								async:false, // 是否异步
								data:{
									name:_subSelf.form.name,
									display_name:_subSelf.form.display_name,
									description:_subSelf.form.description,
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
					}
				});

			},
			permissionroleDialog : function (index, rows) {
				var id = rows[index]['id'];
				var display_name = rows[index]['display_name'];
				var _self = this;
				// 打开对话框
				var index = layer.open({
					type: 1 
					,title: '用户组授权'
					,area: ['600px', '500px']
					,shade: 0
					,minButton: false
					,maxButton: false
					,taskbar:true
					,moveOut: true
					,content: render('permissionrole.html')
					,zIndex: layer.zIndex //重点1
					,success: function(layero){
						layer.setTop(layero); //重点2
					}
				});
				new Vue({
					el: '#permissionrole',
					data : {
						form:{
							display_name:'',
						},
						checkAll: false,
						checkedPermissions: [],
						permissions: [],
						isIndeterminate: false
					},
					methods: {
						submitForm : function (formName) {
							// ajax请求后台数据
							var _subSelf = this;
							$.ajax({
								url:config.url.roleAssignPermission,
								type:'POST', // GET
								async:false, // 是否异步
								data:{
									id:id,
									permissions:_subSelf.checkedPermissions,
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

						},
						handleCheckAllChange : function (event) {
							this.checkedPermissions = event.target.checked ? this.permissions : [];
							this.isIndeterminate = false;
						},
						handleCheckedChange : function (value) {
							var checkedCount = value.length;
							this.checkAll = checkedCount === this.permissions.length;
							this.isIndeterminate = checkedCount > 0 && checkedCount < this.permissions.length;
						}
					},
					mounted: function () {
						var _subSelf = this;
						this.form.display_name = display_name;
						$.ajax({
							url:config.url.rolePermissions,
							type:'GET', // GET
							async:false, // 是否异步
							data:{
								id:id
							},
							dataType:'json',
							success:function(data,textStatus,jqXHR){
								if (data.status == 'success') {
									_subSelf.permissions = data.data.lists;
									_subSelf.checkedPermissions = data.data.checkedPermissions;
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
			editDialog : function (index, rows) {
				var id = rows[index]['id'];
				var _self = this;
				// 打开对话框
				var index = layer.open({
					type: 1 
					,title: '编辑用户组'
					,area: ['400px', '380px']
					,shade: 0
					,minButton: true
					,maxButton: true
					,taskbar:true
					,moveOut: true
					,content: render('rolecreate.html')
					,zIndex: layer.zIndex //重点1
					,success: function(layero){
						layer.setTop(layero); //重点2
					}
				});
				new Vue({
					el: '#rolecreate',
					data : {
						form:{
							name:'',
							display_name:'',
							description:'',
						}
					},
					methods: {
						submitForm : function (formName) {
							// ajax请求后台数据
							var _subSelf = this;
							$.ajax({
								url:config.url.roleUpdate,
								type:'POST', // GET
								async:false, // 是否异步
								data:{
									id:_subSelf.form.id,
									name:_subSelf.form.name,
									display_name:_subSelf.form.display_name,
									description:_subSelf.form.description,
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
							url:config.url.roleEdit,
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
			handleSizeChange : function (val) {
				// alert(`每页 ${val} 条`);
			},
			handleCurrentChange : function (val) {
				this.currentPage = val;
				this.showData(val);
			},handleSelectionChange : function (val) {
				this.multipleSelection = val;
			},showData : function (page) {
				// ajax请求后台数据
				var _self = this;
				$.ajax({
					url:config.url.roleIndex,
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
			},setStatus : function (id,status) {
				// ajax请求后台数据
				var _self = this;
				$.ajax({
					url:config.url.roleSetStatus,
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

	// 定义组件
	var permissionindex = Vue.extend({
		template: '#permissionindex',
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
			onSubmit : function () {
				// ajax请求后台数据
				var _self = this;
				$.ajax({
					url:config.url.permissionSetAllStatus,
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
						,title: '添加权限'
						,area: ['400px', '380px']
						,shade: 0
						,minButton: true
						,maxButton: true
						,taskbar:true
						,moveOut: true
						,content: render('permissioncreate.html')
						,zIndex: layer.zIndex //重点1
						,success: function(layero){
							layer.setTop(layero); //重点2
						}
					});
				new Vue({
					el: '#permissioncreate',
					data : {
						form:{
							name:'',
							display_name:'',
							description:'',
						}
					},
					methods: {
						submitForm : function (formName) {
							// ajax请求后台数据
							var _subSelf = this;
							$.ajax({
								url:config.url.permissionStore,
								type:'POST', // GET
								async:false, // 是否异步
								data:{
									name:_subSelf.form.name,
									display_name:_subSelf.form.display_name,
									description:_subSelf.form.description,
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
					}
				});

			},
			editDialog : function (index, rows) {
				var id = rows[index]['id'];
				var _self = this;
				// 打开对话框
				var index = layer.open({
					type: 1 
					,title: '编辑权限'
					,area: ['400px', '380px']
					,shade: 0
					,minButton: true
					,maxButton: true
					,taskbar:true
					,moveOut: true
					,content: render('permissioncreate.html')
					,zIndex: layer.zIndex //重点1
					,success: function(layero){
						layer.setTop(layero); //重点2
					}
				});
				new Vue({
					el: '#permissioncreate',
					data : {
						form:{
							name:'',
							display_name:'',
							description:'',
						}
					},
					methods: {
						submitForm : function (formName) {
							// ajax请求后台数据
							var _subSelf = this;
							$.ajax({
								url:config.url.permissionUpdate,
								type:'POST', // GET
								async:false, // 是否异步
								data:{
									id:_subSelf.form.id,
									name:_subSelf.form.name,
									display_name:_subSelf.form.display_name,
									description:_subSelf.form.description,
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
							url:config.url.permissionEdit,
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
			handleSizeChange : function (val) {
				// alert(`每页 ${val} 条`);
			},
			handleCurrentChange : function (val) {
				this.currentPage = val;
				this.showData(val);
			},handleSelectionChange : function (val) {
				this.multipleSelection = val;
			},showData : function (page) {
				// ajax请求后台数据
				var _self = this;
				$.ajax({
					url:config.url.permissionIndex,
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
			},setStatus : function (id,status) {
				// ajax请求后台数据
				var _self = this;
				$.ajax({
					url:config.url.permissionSetStatus,
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
            { path: '/', name: 'userindex', component: userindex },
            { path: '/userindex', name: 'userindex', component: userindex },
            { path: '/roleindex', name: 'roleindex', component: roleindex },
            { path: '/permissionindex', name: 'permissionindex', component: permissionindex }
        ]
    });

	new Vue({
		el: '#user',
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