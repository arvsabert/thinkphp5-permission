<?php
/**
 * Created by PhpStorm.
 * User: win10
 * Date: 2018/8/28
 * Time: 11:46
 */

namespace app\Admin\Controller;


use app\Common\Controller\Base;

/**
 *  文章
 * Class Posts
 * @package app\Admin\Controller
 */
class Posts extends Base
{
    /**
     * 文章列表
     */
    public function index(){
        $this->display();
    }

}