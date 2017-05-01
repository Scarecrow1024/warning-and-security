<?php

namespace app\modules\warning\models;

use yii\db\ActiveRecord;
use yii\base\Model;
use yii\db\Query;
use yii;

class User extends ActiveRecord{
    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return [
             [['username', 'phone','email'], 'required' ,'message'=>'必填'],
             ['email', 'email'],
        ];
    }

    /*//更新组员前更新user_role关系表
    public function beforeSave($insert=false){
        $role_ids=Yii::$app->request->post('role_id');
        $id=Yii::$app->request->post('id');
        //先删除原来的对应的user_id
        $sql="delete from user_role where user_id = $id";
            Yii::$app->db->createCommand($sql)
             ->execute();
        //然后插入新的数据
        foreach($role_ids as $v){
            $sql="insert into user_role (user_id,role_id) values ($id,$v)";
            Yii::$app->db->createCommand($sql)
             ->execute();
        }
        echo "更新user_role表成功";
        return true;
    }*/

    //给成员分组后添加分组到user_role表
    public function afterSave($insert=true, $changedAttributes){
        $role_ids=Yii::$app->request->post('role_id');
        $max_id=Yii::$app->db->createCommand('select max(id) from user')
             ->queryOne();
        $max_id=$max_id['max(id)'];
        //添加用户后与角色表进行关联
        foreach($role_ids as $v){
            $sql="insert into user_role (user_id,role_id) values ($max_id,$v)";
            Yii::$app->db->createCommand($sql)
             ->execute();
        }

        var_dump($changedAttributes);
        var_dump($insert);
        echo "user_role更新成功";
    }

    //获取一个组员的所有信息
    public function getRoleNameById($id){
        $sql="select a.*,GROUP_CONCAT(c.id) role_id FROM user a LEFT JOIN user_role b ON a.id=b.user_id LEFT JOIN role c ON b.role_id=c.id where a.id = ".$id." GROUP BY a.id ";
        $data=Yii::$app->db->createCommand($sql)
             ->queryAll();
        return $data;
    }

    //按照组员的id进行分组查询
    public function getRoleName(){
        $sql="select a.*,GROUP_CONCAT(c.role_name) role_name FROM user a LEFT JOIN user_role b ON a.id=b.user_id LEFT JOIN role c ON b.role_id=c.id GROUP BY a.id";
        //$sql="select c.role_name from user as a left join user_role as b on a.id = b.user_id left join role as c on c.id = b.role_id group by b.user_id";
        $data=Yii::$app->db->createCommand($sql)
             ->queryAll();
        return $data;
    }
}