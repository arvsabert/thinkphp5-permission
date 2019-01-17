<?php
/**
 * Created by PhpStorm.
 * User: win10
 * Date: 2018/8/27
 * Time: 14:33
 */

namespace app\Admin\controller;


use app\Common\Controller\Admin;

/**
 * 后台首页控制器
 * Class Index
 * @package app\Admin\controller
 */
class Index extends Admin
{
    /**
     * 首页
     */
    public function index(){
        $this->display();
    }
    /**
     * elements
     */
    public function elements(){

        $this->display();
    }

    /**
     * welcome
     */
    public function welcome(){
        $this->display();
    }

}