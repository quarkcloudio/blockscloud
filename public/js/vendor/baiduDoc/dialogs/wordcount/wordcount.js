// editor.getContent();
// editor.getContentTxt();
// editor.getPlainTxt();

$(function(){
	// $(".container").html(editor.getContent());
	var html = editor.getContent();
	var txt = editor.getPlainTxt();

	var html2 = '<div id="statistical">';
	var info = [ { name: '字数', count: countWord(txt) },
				 { name: '中文单词', count: countChineseWord(txt) },
				 { name: '英文单词', count: countEnglishWord(txt) },
				 { name: '字符数(不计空格)', count: countMainCharacter(txt) },
				 { name: '字符数(计空格)', count: countAllCharacter(txt) },
				 { name: '段落', count: countParagraph(html) }
				];

	html2 += '<ul id="statistical-content">';

	for( var i in info ) {
		html2 += '<li class="statistical-row"><span class="statistical-name">' + info[i].name + '</span><span class="statistical-count">' + info[i].count + '</span></li>';
	}

	html2 += '</ul>';

	$(".container").html(html2);

	function countParagraph(html) {
		return  $('<div>')
				.html(html)
				.find('p,h1,h2,h3,h4,h5,h6')
				.filter(function(){ 
					if( $.trim($(this).text() )) return true;})
				.length || 0;
	}

	function countChineseWord(txt) {
		var patt = /[\u4E00-\u9FA5]/g;
		if(txt.match(patt))
			return  txt.match(patt).length;
		else
			return 0;
	}

	function countWord(txt) {
		return countChineseWord(txt) + countEnglishWord(txt);
	}

	function countEnglishWord(txt) {
		var patt = /\b([A-Za-z]+)\b/g;
		if(txt.match(patt))
			return txt.match(patt).length;
		else
			return 0;
	}

	function countAllCharacter(txt) {
		return txt == '\n' ? 0:txt.length;
	}

	function countMainCharacter(txt) {
		var patt = /\s/g;
		if(/\S/.test(txt))
			return txt.replace(patt, '').length;
		else
			return 0;
	}

});
