<?php
/**
 * Created by PhpStorm.
 * User: win10
 * Date: 2018/8/27
 * Time: 17:37
 */

namespace app\Common\Model;


/**
 * 权限规则model
 * Class ThinkAuthGroupAccess
 * @package app\Common\Model
 */
class ThinkAuthGroupAccess extends Base
{
    protected $table = 'think_auth_group_access';
    protected $pk = 'id';
    protected $autoWriteTimestamp = 'datetime';

    /**
     * 根据group_id获取全部用户id
     * @param  int $group_id 用户组id
     * @return array         用户数组
     */
    public function getUidsByGroupId($group_id){
        $user_ids=$this
            ->where(array('group_id'=>$group_id))
            ->column('uid',true);
        return $user_ids;
    }

    /**
     * 获取管理员权限列表
     */
    public function getAllData(){
        $data=$this
            ->field('u.id,u.username,u.email,aga.group_id,ag.title')
            ->alias('aga')
            ->rightJoin('user u ON aga.uid=u.id')
            ->leftJoin('think_auth_group ag ON aga.group_id=ag.id')
            ->select();
        // 获取第一条数据
        $first=$data[0];
        $first['title']=array();
        $user_data[$first['id']]=$first;
        // 组合数组
        foreach ($data as $k => $v) {
            foreach ($user_data as $m => $n) {
                $uids=array_map(function($a){return $a['id'];}, $user_data);
                if (!in_array($v['id'], $uids)) {
                    $v['title']=array();
                    $user_data[$v['id']]=$v;
                }
            }
        }
        // 组合管理员title数组
        foreach ($user_data as $k => $v) {
            foreach ($data as $m => $n) {
                if ($n['id']==$k) {
                    $user_data[$k]['title'][]=$n['title'];
                }
            }
            $user_data[$k]['title']=implode('、', $user_data[$k]['title']);
        }
        // 管理组title数组用顿号连接
        return $user_data;

    }


}