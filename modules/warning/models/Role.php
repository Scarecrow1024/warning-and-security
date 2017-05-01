<?php

namespace app\modules\warning\models;

use yii\db\ActiveRecord;
use yii\base\Model;
use yii;

class Role extends ActiveRecord{
    public function rules()
    {
        return [
             [['role_name'], 'required'],
        ];
    }

    /*//更新分许前更新event_role关系表
    public function beforeSave($insert=false){
        $event_ids=Yii::$app->request->post('event_id');
        $id=Yii::$app->request->post('id');
        //先删除原来的对应的user_id
        $sql="delete from event_role where role_id = $id";
            Yii::$app->db->createCommand($sql)
             ->execute();
        //然后插入新的数据
        foreach($event_ids as $v){
            $sql="insert into event_role (role_id,event_id) values ($id,$v)";
            Yii::$app->db->createCommand($sql)
             ->execute();
        }
        echo "更新event_role表成功";
        return true;
    }*/

    //给成员分组后添加分组到user_role表
    public function afterSave($insert=true, $changedAttributes){
        $role_ids=Yii::$app->request->post('event_id');
        $max_id=Yii::$app->db->createCommand('select max(id) from role')
             ->queryOne();
        $max_id=$max_id['max(id)'];
        //添加用户后与角色表进行关联
        foreach($role_ids as $v){
            $sql="insert into event_role (role_id,event_id) values ($max_id,$v)";
            Yii::$app->db->createCommand($sql)
             ->execute();
        }

        var_dump($changedAttributes);
        var_dump($insert);
        echo "event_role更新成功";
    }

    //按照报警组的id进行分组查询
    public function getRoleNameById($id){
        $sql="select c.*,GROUP_CONCAT(a.id) event_id FROM role c LEFT JOIN event_role b ON c.id=b.role_id LEFT JOIN event a ON a.id=b.event_id where c.id = ".$id." GROUP BY c.id";
        $data=Yii::$app->db->createCommand($sql)
             ->queryAll();
        return $data;
    }

    //按照报警组的id进行分组查询
    public function getRoleName(){
        $sql="select c.*,GROUP_CONCAT(a.event_name) event_name FROM role c LEFT JOIN event_role b ON c.id=b.role_id LEFT JOIN event a ON a.id=b.event_id GROUP BY c.id";
        $data=Yii::$app->db->createCommand($sql)
             ->queryAll();
        return $data;
    }
}