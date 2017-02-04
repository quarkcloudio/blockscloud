# Blockscloud WEB OS

这个系统从2014年最初的idea到2017年已经有两年半的时间了，时光荏苒。作者是一个php程序员，开发过程中总是为找一个好的、可扩展的后台模板而苦恼，积木云的早期版本使用了芒果云+onethink整合，但碍于芒果云不提供源码以及TP官方对onethink放弃支持，造成了旧版本积木云维护的异常困难。于是作者在2016年用更先进的laravel和vue重写了所有代码。开源不易，请尊重版权！ 

## 安装说明

首先需要将web环境的默认目录指向public目录

编辑.env文件，配置数据库信息

## 命令行下执行数据迁移

第一步：php artisan migrate(您需要将php加入到环境变量)

第二步：php artisan db:seed(注意: 如果在执行迁移时发生「class not found」错误，试着先执行 composer dump-autoload 命令后再进行一次。)

默认用户名：administrator 密码：admin

## 官方支持

积木云QQ群：4110211

github地址:https://github.com/tangtanglove/blockscloud

coding地址:https://git.coding.net/tangtanglove/blockscloud.git

开发社区：http://www.cloudblocks.cn

运营网站：http://www.blockscloud.com

作者blog：http://www.ixiaoquan.com

## License

未获商业授权之前，不得将本软件用于商业用途（包括但不限于企业网站、经营性网站、以营利为目或实现盈利的网站）。购买商业授权请QQ:869716224。 不得对本软件或与之关联的商业授权进行出租、出售、抵押或发放子许可证。 禁止在 积木云 的整体或任何部分基础上以发展任何派生版本、修改版本或第三方版本用于重新分发。 如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回，并承担相应法律责任。
