<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[AdminUsers]].
 *
 * @see AdminUsers
 */
class AdminUsersQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return AdminUsers[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AdminUsers|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
