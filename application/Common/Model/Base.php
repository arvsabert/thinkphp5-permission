<?php
/**
 * Created by PhpStorm.
 * User: win10
 * Date: 2018/8/27
 * Time: 14:28
 */

namespace app\Common\Model;


use think\Model;

/**
 * 基础model
 * Class Base
 * @package app\Common\Model
 */
class Base extends Model
{
    /**
     * 通过主键  查询数据
     * @param $id                   主键
     * @param string $field         查询字段
     * @return array|bool|null|\PDOStatement|string|Model|static
     */
    public function getDataById($id,$field = ''){
        if(!empty($field) && $field != ''){
            $data = $this->where($this->getPk(),$id)->field($field)->find();
        }else{
            $data = $this->get($id);
        }

        if(!$data){
            $this->error = '暂无此数据';
            return false;
        }
        return $data;
    }

    /**
     * 获取数据列表
     * @param array $map            查询条件
     * @param string $field         查询字段
     * @param string $order_key     排序字段名称
     * @param string $order         排列顺序
     * @return array|bool|\PDOStatement|string|\think\Collection
     */
    public function getDataList($map = [],$field = '',$order_key = '',$order = 'desc'){
        if($order_key == ''){
            $order_key = $this->getPk();
        }
        if(!empty($field) && $field != ''){
            $data = $this->where($map)->field($field)->order($order_key,$order)->select();
        }else{
            $data = $this->where($map)->order($order_key,$order)->select();
        }

        if(!$data){
            $this->error = '暂无此数据';
            return false;
        }
        return $data;
    }

    /**
     * 分页查询
     * @param array $map        查询条件
     * @param int $page         查询页码
     * @param string $field     查询字段
     * @param string $order_key 排序字段名称
     * @param string $order     排列顺序
     * @param string $row       每页查询条数
     * @return array|bool
     */
    public function getDataListByPage($map = [],$page = 1,$field = '',$order_key = '',$order = 'asc',$row = ''){
        if($order_key == ''){
            $order_key = $this->getPk();
        }
        $count = $this->where($map)->count();               //统计总查询数目
        if($row == ''){
            $row = config('Row');                       //每页显示的条数，在config/app.php 中配置
        }

        $total_page = ceil($count/$row);            //统计查询的总页数

        if($count == 0){
            $this->error = '暂无此数据';
            return false;
        }else{
            if(!empty($field) && $field != ''){
                $list = $this->where($map)->field($field)->page($page,$row)->order($order_key,$order)->select();
            }else{
                $list = $this->where($map)->page($page,$row)->order($order_key,$order)->select();
            }

            $data = [
                'row' => $row,
                'count' => $count,
                'total_page' =>$total_page,
                'list' => $list
            ];
            return $data;
        }
    }

    /**
     * 新建数据
     * @param $param                添加参数数组
     * @param $validate_scene       验证场景
     * @return array|bool|string
     */
    public function createData($param,$validate_scene){
        // 去除键值首尾的空格
        foreach ($param as $k => $v) {
            $param[$k]=trim($v);
        }

        $validate = validate($this->name);

        if(!$validate->scene($validate_scene)->check($param)){
            return $this->error = $validate->getError();
        }

        try{
            $this->data($param)->allowField(true)->save();
            return true;
        }catch (\Exception $e){
            return $this->error = '添加失败';
        }
    }

    /**
     * 通过主键编辑
     * @param $param            编辑参数数组
     * @param $id               主键
     * @param $validate_scene   验证场景
     * @return array|bool|string
     */
    public function updateDataById($param,$id,$validate_scene){
        // 去除键值首尾的空格
        foreach ($param as $k => $v) {
            $param[$k]=trim($v);
        }

        $checkData = $this->get($id);
        if(!$checkData){
            return $this->error = '暂无此数据';
        }

        $validate = validate($this->name);
        if(!$validate->scene($validate_scene)->check($param)){
            return $this->error = $validate->getError();
        }

        try{
            $this->allowField(true)->save($param,[$this->getPk() => $id]);
            return true;
        }catch (\Exception $e){
            return $this->error = '编辑失败';
        }
    }

    /**
     * 通过主键删除数据
     * @param $id               主键
     * @return bool|string
     */
    public function delDataById($id){
        $checkData = $this->get($id);
        if(!$checkData){
            $this->error = '暂无此数据';
            return false;
        }

        try{
            $pk = $this->getPk();
            $result = $this->where($pk,$id)->delete();
            if($result){
                return true;
            }else{
                return false;
            }
        }catch (\Exception $e){
            $this->error = '删除失败';
            return false;
        }
    }

    /**
     * 批量删除
     * @param array $ids    主键数组
     * @return bool
     */
    public function delDatas($ids = []){
        if(empty($ids)){
            $this->error = '删除失败';
            return false;
        }

        try{
            $pk = $this->getPk();
            $result = $this->where($pk,'in',$ids)->delete();
            if($result){
                return true;
            }else{
                return false;
            }
        }catch (\Exception $e){
            $this->error = '删除失败';
            return false;
        }
    }

    /**
     * 批量更新
     * @param $param        更新参数数组
     * @return bool
     */
    public function updateDatas($param){
        $result = $this->isUpdate(true)->saveAll($param);

        if($result){
            return true;
        }else{
            return false;
        }
    }

    /**
     *  通过数组条件修改数据
     * @param   array   $map         where语句数组形式
     * @param   array   $param       编辑参数数组
     * @param $validate_scene        验证场景
     * @return array|bool|string     操作是否成功
     */
    public function editData($map,$param,$validate_scene){
        // 去除键值首位空格
        foreach ($param as $k => $v) {
            $param[$k]=trim($v);
        }

        $validate = validate($this->name);
        if(!$validate->scene($validate_scene)->check($param)){
            return $this->error = $validate->getError();
        }

        try{
            $this->allowField(true)->where($map)->save($param);
            return true;
        }catch (\Exception $e){
            return $this->error = '编辑失败';
        }
    }

    /**
     * 删除数据
     * @param   array   $map    where语句数组形式
     * @return  boolean         操作是否成功
     */
    public function deleteData($map){
        if (empty($map)) {
            die('where为空的危险操作');
        }

        try{
            $result = $this->where($map)->delete();
            if($result){
                return true;
            }else{
                return false;
            }
        }catch (\Exception $e){
            $this->error = '删除失败';
            return false;
        }
    }

    /**
     * 数据排序
     * @param  array $data   数据源
     * @param  string $id    主键
     * @param  string $order 排序字段
     * @return boolean       操作是否成功
     */
    public function orderData($data,$id='id',$order='order_number'){
        foreach ($data as $k => $v) {
            $v=empty($v) ? null : $v;
            $this->where(array($id=>$k))->save(array($order=>$v));
        }
        return true;
    }

    /**
     * 获取全部数据
     * @param  string $type  tree获取树形结构 level获取层级结构
     * @param  string $order 排序方式
     * @return array         结构数据
     */
    public function getTreeData($type='tree',$order='',$name='name',$child='id',$parent='pid'){
        // 判断是否需要排序
        if(empty($order)){
            $data=$this->select();
        }else{
            $data=$this->order($order.' is null,'.$order)->select();
//            $data=$this->order($order)->select();                //在这里可以直接用该试代替上试
        }
        // 获取树形或者结构数据
        if($type=='tree'){
            $data=\Org\Nx\Data::tree($data,$name,$child,$parent);
        }elseif($type="level"){
            $data=\Org\Nx\Data::channelLevel($data,0,'&nbsp;',$child);
        }
        return $data;
    }

}