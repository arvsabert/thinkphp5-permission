<?php
/**
 * Created by PhpStorm.
 * User: win10
 * Date: 2018/8/27
 * Time: 15:21
 */

namespace app\Home\controller;


use app\Common\Controller\Home;
use think\Session;

/**
 * 商城首页Controller
 * Class Index
 * @package app\Home\controller
 */
class Index extends Home
{
    /**
     * 首页
     */
    public function index(){
        if($this->request->isPost()){
            // 做一个简单的登录 组合where数组条件
            $map=input('post.');
            $map['password']=md5($map['password']);
            $data=db('Users')->where($map)->find();
            if (empty($data)) {
                $this->error('账号或密码错误');
            }else{
                session(array(
                    'id'=>$data['id'],
                    'username'=>$data['username'],
                    'avatar'=>$data['avatar']
                ));
                $this->success('登录成功，前往管理后台',url('Admin/Index/index'));
            }
        }else{
            $data=check_login() ? session(['username']).'已登录' : '未登录';
            $assign=array(
                'data'=>$data
            );
//        return json($assign);                      //返回数据
            $this->assign($assign);              //传送数据至页面
            $this->display();
        }
    }

    /**
     * 退出
     */
    public function logout(){
        Session::clear();
        $this->success('退出成功，前往登录页面',url('Home/Index/index'));
    }

    /**
     *  下载多类型文件，此处为下载apk文件(若要调用公共函数，有时可能需要清除runtime缓存文件)
     */
    public function downloadApk(){
        $fileName = "C:\\Users\\Public\\Nwt\\cache\\recv\\LYB-GXY\\cca-2.apk";       //路径
        $showName="cca-2.apk";                      //文件名称及后缀
        download($fileName,$showName);
    }

}