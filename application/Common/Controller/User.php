<?php
/**
 * Created by PhpStorm.
 * User: win10
 * Date: 2018/8/27
 * Time: 14:30
 */

namespace app\Common\Controller;

/**
 * 用户基类控制器
 * Class User
 * @package app\Common\Controller
 */
class User extends Base
{
    /**
     *  初始化方法
     */
    public function initialize()
    {
        parent::initialize();
        // 添加不需要验证是否登录的连接 全部小写
        $not_need_login=array(
            'user/goods/app_buy'
        );
        // 转小写以兼容url大小写不统一的问题
        $action=strtolower(trim($this->request->url(),'/'));
        if (!in_array($action, $not_need_login)) {
            // 检测是否登录
            if (!check_login()) {
                if ($this->request->isAjax()) {
                    ajax_return('','您需要登录！',1);
                }else{
                    $this->error('您需要登录！');
                }
            }
        }
    }



}