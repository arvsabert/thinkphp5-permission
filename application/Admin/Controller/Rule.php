<?php
/**
 * Created by PhpStorm.
 * User: win10
 * Date: 2018/8/27
 * Time: 14:33
 */

namespace app\Admin\controller;


use app\Common\Controller\Admin;

/**
 * 后台权限管理
 * Class Rule
 * @package app\Admin\controller
 */
class Rule extends Admin
{
//******************权限***********************
    /**
     * 权限列表
     */
    public function index(){
        $data=db('ThinkAuthRule')->getTreeData('tree','id','title');
        $assign=array(
            'data'=>$data
        );
//        return json($assign);                      //返回数据
        $this->assign($assign);                //传送数据至页面
        $this->display();
    }

    /**
     * 添加权限
     */
    public function add(){
        $data=input('post.');
        unset($data['id']);               //删除前端取到的id值，前端也可以发送数据时不包含id，则注释掉
        $result=db('ThinkAuthRule')->createData($data);
        if ($result) {
            $this->success('添加成功',url('Admin/Rule/index'));
        }else{
            $this->error('添加失败');
        }
    }

    /**
     * 修改权限
     */
    public function edit(){
        $data=input('post.');
        $map=array(
            'id'=>$data['id']                  //组合数组
        );
        $result=db('ThinkAuthRule')->editData($map,$data);
        if ($result) {
            $this->success('修改成功',url('Admin/Rule/index'));
        }else{
            $this->error('修改失败');
        }
    }

    /**
     * 删除权限
     */
    public function delete(){
        $id=input('get.id');
        $map=array(
            'id'=>$id
        );
        $result=db('ThinkAuthRule')->deleteData($map);
        if($result){
            $this->success('删除成功',url('Admin/Rule/index'));
        }else{
            $this->error('请先删除子权限');
        }

    }
//*******************用户组**********************
    /**
     * 用户组列表
     */
    public function group(){
        $data=db('ThinkAuthGroup')->select();
        $assign=array(
            'data'=>$data
        );
//        return json($assign);                      //返回数据
        $this->assign($assign);                //传送数据至页面
        $this->display();
    }

    /**
     * 添加用户组
     */
    public function add_group(){
        $data=input('post.');
        unset($data['id']);               //删除前端取到的id值，前端也可以发送数据时不包含id，则注释掉
        $result=db('ThinkAuthGroup')->createData($data);
        if ($result) {
            $this->success('添加成功',url('Admin/Rule/group'));
        }else{
            $this->error('添加失败');
        }
    }

    /**
     * 修改用户组
     */
    public function edit_group(){
        $data=input('post.');
        $map=array(
            'id'=>$data['id']
        );
        $result=db('ThinkAuthGroup')->editData($map,$data);
        if ($result) {
            $this->success('修改成功',url('Admin/Rule/group'));
        }else{
            $this->error('修改失败');
        }
    }

    /**
     * 删除用户组
     */
    public function delete_group(){      //这里删除要操作两张表，为表auth-group和表auth-group-access
        $id=input('get.id',0,'intval');       //取id值，不存在为0，其类型为短整型
        $map=array(
            'id'=>$id
        );
        $result=db('ThinkAuthGroup')->deleteData($map);
        if ($result) {
            $this->success('删除成功',url('Admin/Rule/group'));
        }else{
            $this->error('删除失败');
        }
    }

//*****************权限-用户组*****************
    /**
     * 分配权限
     */
    public function rule_group(){
        if($this->request->isPost()){
            $data=input('post.');
            $map=array(
                'id'=>$data['id']
            );
            $data['rules']=implode(',', $data['rule_ids']);
            $result=db('ThinkAuthGroup')->editData($map,$data);
            if ($result) {
                $this->success('操作成功',url('Admin/Rule/group'));
            }else{
                $this->error('操作失败');
            }
        }else{
            $id=input('get.id');
            // 获取用户组数据
            $group_data=db('ThinkAuthGroup')->where(array('id'=>$id))->find();
            $group_data['rules']=explode(',', $group_data['rules']);
            // 获取规则数据
            $rule_data=db('ThinkAuthRule')->getTreeData('level','id','title');
            $assign=array(
                'group_data'=>$group_data,
                'rule_data'=>$rule_data
            );
//        return json($assign);                      //返回数据
            $this->assign($assign);                //传送数据至页面
            $this->display();
        }

    }
//******************用户-用户组*******************
    /**
     * 添加成员
     */
    public function check_user(){
        $username=input('get.username','');
        $group_id=input('get.group_id');
        $group_name=db('ThinkAuthGroup')->getFieldById($group_id,'title');
        $uids=db('ThinkAuthGroupAccess')->getUidsByGroupId($group_id);
        // 判断用户名是否为空
        if(empty($username)){
            $user_data='';
        }else{
            $user_data=db('Users')->where(array('username'=>$username))->select();
        }
        $assign=array(
            'group_name'=>$group_name,
            'uids'=>$uids,
            'user_data'=>$user_data,
        );
//        return json($assign);                      //返回数据
        $this->assign($assign);                  //传送数据至页面
        $this->display();
    }

    /**
     * 添加用户到用户组
     */
    public function add_user_to_group(){
        $data=input('get.');
        $map=array(
            'uid'=>$data['uid'],
            'group_id'=>$data['group_id']
        );
        $count=db('ThinkAuthGroupAccess')->where($map)->count();             //查询数据库是否已经添加
        if($count==0){
            db('ThinkAuthGroupAccess')->createData($data);
        }
        $this->success('操作成功',url('Admin/Rule/check_user',array('group_id'=>$data['group_id'],'username'=>$data['username'])));
    }

    /**
     * 将用户移除用户组
     */
    public function delete_user_from_group(){
        $map=input('get.');
        $result=db('ThinkAuthGroupAccess')->deleteData($map);
        if ($result) {
            $this->success('操作成功',url('Admin/Rule/admin_user_list'));
        }else{
            $this->error('操作失败');
        }
    }

    /**
     * 管理员列表
     */
    public function admin_user_list(){
        $data=db('ThinkAuthGroupAccess')->getAllData();
        $assign=array(
            'data'=>$data
        );
//        return json($assign);                      //返回数据
        $this->assign($assign);                  //传送数据至页面
        $this->display();
    }

    /**
     * 添加管理员
     */
    public function add_admin(){
        if($this->request->isPost()){
            $data=input('post.');
            $result=db('Users')->createData($data);             //这里添加管理员，即是新增用户
            if($result){
                if (!empty($data['group_ids'])) {          //管理组的id，可能多个
                    foreach ($data['group_ids'] as $k => $v) {
                        $group=array(
                            'uid'=>$result,
                            'group_id'=>$v
                        );
                        db('ThinkAuthGroupAccess')->createData($group);
                    }
                }
                // 操作成功
                $this->success('添加成功',url('Admin/Rule/admin_user_list'));
            }else{
                $error_word=db('Users')->getError();
                // 操作失败
                $this->error($error_word);
            }
        }else{
            $data=db('ThinkAuthGroup')->select();
            $assign=array(
                'data'=>$data
            );
//        return json($assign);                      //返回数据
            $this->assign($assign);                  //传送数据至页面
            $this->display();
        }
    }

    /**
     * 修改管理员
     */
    public function edit_admin(){
        if($this->request->isPost()){
            $data=input('post.');
            // 组合where数组条件
            $uid=$data['id'];
            $map=array(
                'id'=>$uid
            );
            // 修改权限
            db('ThinkAuthGroupAccess')->deleteData(array('uid'=>$uid));
            foreach ($data['group_ids'] as $k => $v) {
                $group=array(
                    'uid'=>$uid,
                    'group_id'=>$v
                );
                db('ThinkAuthGroupAccess')->createData($group);
            }
            $data=array_filter($data);  //如果没有提供callback 函数，array_filter() 将删除 array 中所有等值为 FALSE的条目.这也就是过滤数组空白元素的精华所在.即过滤空数组
            // 如果修改密码则md5
            if (!empty($data['password'])) {
                $data['password']=md5($data['password']);
            }
            // p($data);die;
            $result=db('Users')->editData($map,$data);
            if($result){
                // 操作成功
                $this->success('编辑成功',url('Admin/Rule/edit_admin',array('id'=>$uid)));
            }else{
                $error_word=db('Users')->getError();
                if (empty($error_word)) {
                    $this->success('编辑成功',url('Admin/Rule/edit_admin',array('id'=>$uid)));
                }else{
                    // 操作失败
                    $this->error($error_word);
                }

            }
        }else{
            $id=input('get.id',0,'intval');
            // 获取用户数据
            $user_data=db('Users')->find($id);
            // 获取已加入用户组
            $group_data=db('ThinkAuthGroupAccess')
                ->where(array('uid'=>$id))
                ->getField('group_id',true);
            // 全部用户组
            $data=db('ThinkAuthGroup')->select();
            $assign=array(
                'data'=>$data,
                'user_data'=>$user_data,
                'group_data'=>$group_data
            );
//        return json($assign);                      //返回数据
            $this->assign($assign);               //传送数据至页面
            $this->display();
        }
    }

    //在这里缺少一个删除用户的功能，可能放到user用户功能模块去操作了,在userModel模块里，禁止删除用户

}