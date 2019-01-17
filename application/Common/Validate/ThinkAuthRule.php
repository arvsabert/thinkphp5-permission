<?php
/**
 * Created by PhpStorm.
 * User: win10
 * Date: 2018/8/28
 * Time: 13:49
 */

namespace app\Common\Validate;


use think\Validate;

class ThinkAuthRule extends Validate
{
    protected $rule = [
        'pid' => 'require|number',
        'name' => 'require',
        'title' => 'require|unique:ThinkAuthRule',
        'type' => 'require',
        'status' => 'require|number',
    ];

    protected $message = [
        'pid.require' => '父级id必须存在',
        'pid.number' => '父级id必须为数字类型',
        'name.require' => '路径必须存在',
        'title.require' => '名字应当给出',
        'title.unique' => '名字应当唯一',
        'type.require' => '类型应当存在',
        'status.require' => '状态必须存在',
        'status.number' => '状态应当为数字',
    ];

    protected $scene = [
        'add' => ['pid','name','title','type','status'],
        'update' => ['name','title'],
    ];

}