<?php
namespace Admin\Controller;
use Think\Controller;

/**
 * Class IndexController
 * @package Admin\Controller
 */
class FormController extends CommonController {
    public function lst(){
        $this->display();
    }
    public function add() {
        $this->display();
    }
}