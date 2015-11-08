<?php
namespace Admin\Controller;
use Think\Controller;

/**
 * Class IndexController
 * @package Admin\Controller
 */
class IndexController extends CommonController {
    public function index(){
        $this->display();
    }
}