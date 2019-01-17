<?php
/**
 * Created by PhpStorm.
 * User: win10
 * Date: 2018/8/27
 * Time: 14:39
 */

namespace app\User\controller;


use app\Common\Controller\User;

class Index extends User
{
    /**
     *  首页
     * @return mixed
     */
    public function index(){
        return $this->fetch();
    }

}