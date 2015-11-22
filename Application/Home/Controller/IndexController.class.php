<?php
namespace Home\Controller;
use Think\Controller;
/**
 * 首页
 */
class IndexController extends CommonController {
    public function index(){
        echo urlencode('http://wxsearch.sentiger.com/index.php/Home/Index/index');die;
        $this->display();
    }


}