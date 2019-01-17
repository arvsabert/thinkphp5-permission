<?php
/**
 * Created by PhpStorm.
 * User: win10
 * Date: 2018/8/27
 * Time: 14:32
 */

namespace app\Admin\controller;


use app\Common\Controller\Admin;

/**
 * 后台首页控制器
 * Class User
 * @package app\Admin\controller
 */
class User extends Admin
{
    /**
     * 用户列表
     */
    public function index(){
        $word=input('get.word','');
        if (empty($word)) {
            $map=array();
        }else{
            $map=array(
                'username'=>$word
            );
        }
        $assign=db('Users')->getAdminPage($map,'register_time desc');           //该方法暂不存在
//        return json($assign);                      //返回数据
        $this->assign($assign);                //传送数据至页面
        $this->display();
    }

}