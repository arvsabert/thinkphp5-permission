<?php
/**
 * Created by PhpStorm.
 * User: win10
 * Date: 2018/8/27
 * Time: 17:36
 */

namespace app\Common\Model;


use think\Db;

/**
 * 权限规则model
 * Class ThinkAuthGroup
 * @package app\Common\Model
 */
class ThinkAuthGroup extends Base
{
    protected $table = 'think_auth_group';
    protected $pk = 'id';
    protected $autoWriteTimestamp = 'datetime';

    /**
     * 传递主键id删除数据
     * @param  array   $map  主键id
     * @return boolean       操作是否成功
     */
    public function deleteData($map){              //这里删除两张表，最好做事务操作
        // 启动事务
        Db::startTrans();
        try {
            $result = Db::table('think_auth_group')->where($map)->delete();
            if ($result) {
                $group_map=array(
                    'group_id'=>$map['id']
                );
                // 删除关联表中的组数据
                $resultEnd = Db::table('think_auth_group_access')->deleteData($group_map);
                if($resultEnd){
                    // 提交事务
                    Db::commit();
                    return $resultEnd;
                }else{
                    return false;                 //此处也可以传送信息到前端告诉其为第二步数据出错原因
                }
            }else{
                return false;                     //此处也可以传送信息到前端告诉其为第一步数据出错原因
            }

        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
        }
    }

}