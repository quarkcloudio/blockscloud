function demo(appObject) {
	// 打开对话框
	index = layer.open({
		type: 1 //此处以iframe举例
		,title: 'demo'
		,area: [appObject.attr('app-width')+'px', appObject.attr('app-height')+'px']
		,shade: 0
		,minButton: true
		,maxButton: false
		,taskbar:true
		,content: render('index.html')
		,zIndex: layer.zIndex //重点1
		,success: function(layero){
			layer.setTop(layero); //重点2
		}
	});
	// 渲染模板
	var appContent = new Vue({
		el: '#app',
		data() {
		return {
			form: {
			name: '',
			region: '',
			date1: '',
			date2: '',
			delivery: false,
			type: [],
			resource: '',
			desc: ''
			}
		}
		},
		methods: {
		onSubmit() {
			console.log('submit!');
		}
		}
	});

}