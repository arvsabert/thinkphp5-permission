<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/**
 * Created by PhpStorm.
 * User: win10
 * Date: 2018/8/27
 * Time: 13:43
 */

header("Content-type:text/html;charset=utf-8");

//传递数据以易于阅读的样式格式化后输出
function p($data){
    // 定义样式
    $str='<pre style="display: block;padding: 9.5px;margin: 44px 0 0 0;font-size: 13px;line-height: 1.42857;color: #333;word-break: break-all;word-wrap: break-word;background-color: #F5F5F5;border: 1px solid #CCC;border-radius: 4px;">';
    // 如果是boolean或者null直接显示文字；否则print
    if (is_bool($data)) {
        $show_data=$data ? 'true' : 'false';
    }elseif (is_null($data)) {
        $show_data='null';
    }else{
        $show_data=print_r($data,true);
    }
    $str.=$show_data;
    $str.='</pre>';
    echo $str;
}

/**
 * 检测是否登录
 * @return boolean 是否登录
 */
function check_login(){
    if (!empty(session(['id']))){
        return true;
    }else{
        return false;
    }
}

/**
 * 返回iso、Android、ajax的json格式数据
 * @param  array  $data           需要发送到前端的数据
 * @param  string  $error_message 成功或者错误的提示语
 * @param  integer $error_code    状态码： 0：成功  1：失败
 * @return string                 json格式的数据
 */
function ajax_return($data='',$error_message='成功',$error_code=1){
    $all_data=array(
        'error_code'=>$error_code,
        'error_message'=>$error_message,
    );
    if ($data!=='') {
        $all_data['data']=$data;
        // app 禁止使用和为了统一字段做的判断
        $reserved_words=array('id','title','price','product_title','product_id','product_category','product_number');
        foreach ($reserved_words as $k => $v) {
            if (array_key_exists($v, $data)) {
                echo 'app不允许使用【'.$v.'】这个键名 —— 此提示是function.php 中的ajax_return函数返回的';
                die;
            }
        }
    }
    // 如果是ajax或者app访问；则返回json数据 pc访问直接p出来
    echo json_encode($all_data);
    exit(0);
}

/**
 *  用于下载多类型文件，此处为下载apk文件
 * @param $filename
 * @param $showname
 */
function download($fileName,$showName){
//    $filename = "C:\\Users\\Public\\Nwt\\cache\\recv\\LYB-GXY\\cca.apk";
//    $showname="cca.apk";
    header("Pragma: public");
    header("Cache-control: max-age=180");
    header("Content-Disposition: attachment; filename=".$showName);
    header("Content-type: application/octet-stream");
    header('Content-Encoding: none');
    header("Content-Transfer-Encoding: binary" );
    readfile($fileName);
}

/**
 * 以下为递归函数测试
 */
function test($a=0,&$result=array()){
    $a++;
    if ($a<10) {
        $result[]=$a;
        test($a,$result);
    }

    echo $a;
    dump($result);
    return $result;

}
//global 全局变量
function testGlobal($a=0,$result=array()){
    global $result;
    $a++;
    if ($a<10) {
        $result[]=$a;
        testGlobal($a,$result);
    }

    dump($result);
    return $result;
}
//static  static的作用：仅在第一次调用函数的时候对变量进行初始化，并且保留变量值。
function testStatic($a=0){
    static $result=array();
    $a++;
    if ($a<10) {
        $result[]=$a;
        test($a);
    }
    return $result;
}
//所谓递归函数，重点是如何处理函数调用自身是如何保证所需要的结果得以在函数间合理"传递"，当然也有不需要函数之间传值得递归函数
function testNone($a=0){
    $a++;
    if ($a<10) {
        echo $a;

        test($a);
    }
}
