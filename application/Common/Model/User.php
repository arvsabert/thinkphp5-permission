<?php
/**
 * Created by PhpStorm.
 * User: win10
 * Date: 2018/8/27
 * Time: 17:33
 */

namespace app\Common\Model;


use think\facade\Request;

class User extends Base
{
    protected $table = 'User';
    protected $pk = 'id';
    protected $autoWriteTimestamp = 'datetime';

    /**
     * 添加用户
     * @param 添加参数数组 $param
     * @param 验证场景 $validate_scene
     * @return array|bool|string
     */
    public function createData($param, $validate_scene)
    {
        // 去除键值首尾的空格
        foreach ($param as $k => $v) {
            if($k == 'password' || $k == 'repssword'){       //密码及确认密码不必去除首尾空格
                $v = md5($v);                                //MD5加密并可以组合密码（如时间戳和TOKEN，但必须确保两者一致）
            }
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
     *  修改用户
     * @param array $map
     * @param array $param
     * @param 验证场景 $validate_scene
     * @return array|bool|string
     */
    public function editData($map, $param, $validate_scene)
    {
        // 去除键值首位空格
        foreach ($param as $k => $v) {
            if($k == 'password' || $k == 'repssword'){       //密码及确认密码不必去除首尾空格
                $v = md5($v);                                //MD5加密并可以组合密码（如时间戳和TOKEN，但必须确保两者一致）
            }
            $param[$k]=trim($v);
        }

        $validate = validate($this->name);
        if(!$validate->scene($validate_scene)->check($param)){
            return $this->error = $validate->getError();
        }

        try{
            $this->allowField(true)->where(array($map))->save($param);
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
        die('禁止删除用户');
    }

}