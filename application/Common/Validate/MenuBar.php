<?php
/**
 * Created by PhpStorm.
 * User: win10
 * Date: 2018/8/28
 * Time: 13:47
 */

namespace app\Common\Validate;


use think\Validate;

class MenuBar extends Validate
{
    protected $rule = [
        'pid' => 'require',
        'name' => 'require|unique:MenuBar',
        'mca' => 'require',
        'ico' => 'require',
    ];

    protected $message = [
        'pid.require' => '父级id必须给出',
        'name.require' => '菜单名必须存在',
        'name.unique' => '菜单名已存在，请修改',
        'mca.require' => '路劲必须给出',
        'ico.require' => 'font-awesome图标必须存在',
    ];

    protected $scene = [
        'add' => ['pid','name','mca','ico'],
        'update' => ['name','mca','ico'],
    ];

}