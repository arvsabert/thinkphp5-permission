<?php
/**
 * Created by PhpStorm.
 * User: win10
 * Date: 2018/8/28
 * Time: 13:48
 */

namespace app\Common\Validate;


use think\Validate;

class User extends Validate
{
    protected $rule = [
        'username' => 'require|unique:User',
        'password' => 'require|alphaNum',
        'repassword' => 'require|confirm:password',
        'avatar' => 'require|image',
        'email' => 'require|email',
        'phone' => 'require|mobile',
        'status' => 'require|number',
    ];

    protected $message = [
        'name.require' => '用户名字必须存在',
        'name.unique' => '用户名已存在，请修改',
        'password.require' => '密码必须存在',
        'password.alphaNum' => '密码必须是字母和数字的组合',
        'repassword.require' => '确认密码必须存在',
        'repassword.confirm' => '确认密码与密码必须相同',
        'avatar.require' => '头像必须存在',
        'avatar.image' => '头像上传的必须是图片',
        'email.require' => '电子邮箱必须存在',
        'email.email' => '电子邮箱必须是email格式',
        'phone.require' => '电话号码必须存在',
        'phone.mobile' => '电话号码格式不正确',
        'status.require' => '状态必须存在',
        'status.number' => '状态必须是数字',
    ];

    protected $scene = [
        'add' => ['name','password','repassword','email','phone','status'],
        'addAvatar' => ['avatar'],                                           //添加头像
        'update' => ['name','email','phone'],
        'updateAvatar' => ['avatar'],                                        //修改头像
        'updatepwd' => ['password','repassword'],                            //修改密码
    ];

}