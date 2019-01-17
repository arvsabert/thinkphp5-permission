<?php
/**
 * Created by PhpStorm.
 * User: win10
 * Date: 2018/8/28
 * Time: 13:49
 */

namespace app\Common\Validate;


use think\Validate;

class ThinkAuthGroup extends Validate
{
    protected $rule = [
        'title' => 'require|unique:ThinkAuthGroup',
        'status' => 'require|number',
        'rules' => 'require',
    ];

    protected $message = [
        'title.require' => '名字必须存在',
        'title.unique' => '名字必须唯一',
        'status.require' => '状态必须给出',
        'status.number' => '状态应当为数字',                 //1为启用，2为禁用
        'rules.require' => '规则必须存在，可为复数规则',
    ];

    protected $scene = [
        'add' => ['title','status','rules'],
        'update' => ['title','status','rules'],
    ];

}