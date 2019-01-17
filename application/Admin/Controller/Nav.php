<?php
/**
 * Created by PhpStorm.
 * User: win10
 * Date: 2018/8/27
 * Time: 14:34
 */

namespace app\Admin\controller;


use app\Common\Controller\Admin;

/**
 * 后台菜单管理
 * Class Nav
 * @package app\Admin\controller
 */
class Nav extends Admin
{
    /**
     * 菜单列表
     */
    public function index(){
        $data=db('MenuBar')->getTreeData('tree','order_number,id');
        $assign=array(
            'data'=>$data
        );
//        return json($assign);                      //返回数据
        $this->assign($assign);                //传送数据至页面
        $this->display();
    }

    /**
     * 添加菜单
     */
    public function add(){
        $data=input('post.');
        unset($data['id']);               //删除前端取到的id值，前端也可以发送数据时不包含id，则注释掉
        $result=db('MenuBar')->addData($data);
        if ($result) {
            $this->success('添加成功',url('Admin/Nav/index'));
        }else{
            $this->error('添加失败');
        }
    }

    /**
     * 修改菜单
     */
    public function edit(){
        $data=input('post.');
        $map=array(
            'id'=>$data['id']
        );
        $result=db('MenuBar')->editData($map,$data);
        if ($result) {
            $this->success('修改成功',url('Admin/Nav/index'));
        }else{
            $this->error('修改失败');
        }
    }

    /**
     * 删除菜单
     */
    public function delete(){
        $id=input('get.id');
        $map=array(
            'id'=>$id
        );
        $result=db('MenuBar')->deleteData($map);
        if($result){
            $this->success('删除成功',url('Admin/Nav/index'));
        }else{
            $this->error('请先删除子菜单');
        }
    }

    /**
     * 菜单排序
     */
    public function order(){
        $data=input('post.');
        $result=db('MenuBar')->orderData($data);
        if ($result) {
            $this->success('排序成功',url('Admin/Nav/index'));
        }else{
            $this->error('排序失败');
        }
    }


}