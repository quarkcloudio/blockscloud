<?php
namespace Api\Controller;

class ErrorController extends CommonController
{
    public function show(){
        $lang = L('SYS_STATUS');
        $res['status'] = 400;
        $res['info'] = $lang['400'];
        $this->response($res,'json');
    }
}
