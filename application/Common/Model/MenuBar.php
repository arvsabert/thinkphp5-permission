<?php
/**
 * Created by PhpStorm.
 * User: win10
 * Date: 2018/8/27
 * Time: 17:34
 */

namespace app\Common\Model;


use wxkxklmyt\Auth;

/**
 *  菜单操作
 * Class MenuBar
 * @package app\Common\Model
 */
class MenuBar extends Base
{
    protected $table = 'menu_bar';
    protected $pk = 'id';
    protected $autoWriteTimestamp = 'datetime';


    /**
     * 删除数据
     * @param	array	$map	where语句数组形式
     * @return	boolean			操作是否成功
     * @throws \Exception
     */
    public function deleteData($map){
        $count=$this
            ->where(array('pid'=>$map['id']))
            ->count();
        if($count!=0){
            return false;
        }
        $this->where(array($map))->delete();
        return true;
    }

    /**
     * 获取全部菜单
     * @param  string $type tree获取树形结构 level获取层级结构
     * @return array       	结构数据
     */
    public function getTreeData($type='tree',$order=''){
        // 判断是否需要排序
        if(empty($order)){
            $data=$this->select();
        }else{
            $data=$this->order('order_number is null,'.$order)->select(); //让排序以order_num的大小顺序出现，该order条件可能用来控制空值情况，直接用$order作为参数代入
        }
        // 获取树形或者结构数据
        if($type=='tree'){
            $data=\Org\Nx\Data::tree($data,'name','id','pid');
        }elseif($type="level"){
            $data=\Org\Nx\Data::channelLevel($data,0,'&nbsp;','id');
            // 显示有权限的菜单
            $auth=new Auth();
            foreach ($data as $k => $v) {
                if ($auth->check($v['mca'],session(['id']))) {
                    foreach ($v['_data'] as $m => $n) {
                        if(!$auth->check($n['mca'],session(['id']))){
                            unset($data[$k]['_data'][$m]);
                        }
                    }
                }else{
                    // 删除无权限的菜单
                    unset($data[$k]);
                }
            }
        }
        // p($data);die;
        return $data;
    }

}