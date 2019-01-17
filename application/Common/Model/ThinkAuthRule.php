<?php
/**
 * Created by PhpStorm.
 * User: win10
 * Date: 2018/8/27
 * Time: 17:38
 */

namespace app\Common\Model;


/**
 * 权限规则model
 * Class ThinkAuthRule
 * @package app\Common\Model
 */
class ThinkAuthRule extends Base
{
    protected $table = 'think_auth_rule';
    protected $pk = 'id';
    protected $autoWriteTimestamp = 'datetime';

    /**
     * 删除数据
     * @param	array	$map	where语句数组形式
     * @return	boolean			操作是否成功
     */
    public function deleteData($map){
        $count=$this
            ->where(array('pid'=>$map['id']))
            ->count();
        if($count!=0){
            return false;
        }
        $result=$this->where($map)->delete();
        return $result;

    }

}