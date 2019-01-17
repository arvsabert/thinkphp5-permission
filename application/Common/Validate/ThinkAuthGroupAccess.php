<?php
/**
 * Created by PhpStorm.
 * User: win10
 * Date: 2018/8/28
 * Time: 13:49
 */

namespace app\Common\Validate;


use think\Validate;

class ThinkAuthGroupAccess extends Validate
{
    protected $rule = [
        'uid' => 'require',
        'group_id' => 'require',
    ];

    protected $message = [
        'uid.require' => '用户id必须存在',
        'group_id.require' => '用户组id必须存在',
    ];

    protected $scene = [
        'add' => ['uid','group_id'],
        'update' => ['uid','group_id'],
    ];

}