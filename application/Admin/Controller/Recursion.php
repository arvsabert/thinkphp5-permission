<?php
/**
 * Created by PhpStorm.
 * User: win10
 * Date: 2019/1/9
 * Time: 11:47
 */

namespace app\Admin\Controller;
use think\Controller;


/**
 * 递归函数模块测试
 * Class Recursion
 * @package app\Admin\Controller
 */
class Recursion extends Controller
{
//    static public $result = array();

    public function test(){
        test();
    }

    //global 全局变量
    public function testGlobal(){
       testGlobal();
    }

    //static  static的作用：仅在第一次调用函数的时候对变量进行初始化，并且保留变量值。
    public function testStatic(){
        testStatic();
    }

    //所谓递归函数，重点是如何处理函数调用自身是如何保证所需要的结果得以在函数间合理"传递"，当然也有不需要函数之间传值得递归函数
    public function testNone(){
        testNone();
    }




}