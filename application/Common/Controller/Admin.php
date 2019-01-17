<?php
/**
 * Created by PhpStorm.
 * User: win10
 * Date: 2018/8/27
 * Time: 14:29
 */

namespace app\Common\Controller;


use think\Request;
use wxkxklmyt\Auth;

/**
 * admin 基类控制器
 * Class Admin
 * @package app\Common\Controller
 */
class Admin extends Base
{
    /**
     *  初始化方法
     */
    public function initialize()
    {
        parent::initialize();
        $auth=new Auth();
        $request = \think\facade\Request::instance();
        $rule_name=$request->module().'/'.$request->controller().'/'.$request->action();
        $result=$auth->check($rule_name,session(['id']));
        if(!$result){
            $this->error('您没有权限访问');
        }
        // 分配菜单数据
        $nav_data=db('menuBar')->getTreeData('level','order_number,id');
        $assign=array(
            'nav_data'=>$nav_data
        );
//        return json($assign);                      //返回数据
        $this->assign($assign);
    }



}