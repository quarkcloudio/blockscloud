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
			tableData: [{
			date: '2016-05-02',
			name: '王小虎',
			address: '上海市普陀区金沙江路 1518 弄'
			}, {
			date: '2016-05-04',
			name: '王小虎',
			address: '上海市普陀区金沙江路 1517 弄'
			}, {
			date: '2016-05-01',
			name: '王小虎',
			address: '上海市普陀区金沙江路 1519 弄'
			}, {
			date: '2016-05-01',
			name: '王小虎',
			address: '上海市普陀区金沙江路 1519 弄'
			}, {
			date: '2016-05-01',
			name: '王小虎',
			address: '上海市普陀区金沙江路 1519 弄'
			}, {
			date: '2016-05-01',
			name: '王小虎',
			address: '上海市普陀区金沙江路 1519 弄'
			}, {
			date: '2016-05-01',
			name: '王小虎',
			address: '上海市普陀区金沙江路 1519 弄'
			}, {
			date: '2016-05-01',
			name: '王小虎',
			address: '上海市普陀区金沙江路 1519 弄'
			}, {
			date: '2016-05-03',
			name: '王小虎',
			address: '上海市普陀区金沙江路 1516 弄'
			}],
			formInline: {
			user: '',
			region: ''
			}
		},
		methods: {
			handleOpen(key, keyPath) {
				console.log(key, keyPath);
			},
			handleClose(key, keyPath) {
				console.log(key, keyPath);
			},
			onSubmit() {
				console.log('submit!');
			},
			deleteRow(index, rows) {
				rows.splice(index, 1);
			}
		},
		mounted: function () {
			// ajax请求后台数据
			var vueObject = this;
			$.ajax({
				url:'',
				type:'GET', // GET
				async:false, // 是否异步
				data:{
					path:path
				},
				dataType:'json',
				success:function(data,textStatus,jqXHR){
					if (data.status == 'success') {

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