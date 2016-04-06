要用某一个伪静态URLRewrite规则，就将相应的规则拷贝到站点根目录


.htaccess 文件是apache环境下伪静态URLRewrite规则；IIS 6环境下访问：http://www.cr173.com/html/32070_1.html，配置成功后可以用该规则

web.config 文件是IIS 7以上版本的伪静态URLRewrite规则

tox_nginx.config 文件是nginx环境下的伪静态URLRewrite规则，要使用nginx伪静态规则，在将tox_nginx.config拷贝到根目录的同时还要在环境的nginx.config文件中对应引入tox_nginx.config引用方式，在location /{}中加入“include D://目录/tox/tox_nginx.conf”；

config.yaml 文件是sae上伪静态文件，该文件只有部分规则，是一个示例文件，需要的用户可以根据需要自行参照编写