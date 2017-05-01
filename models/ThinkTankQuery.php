<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ThinkTank]].
 *
 * @see ThinkTank
 */
class ThinkTankQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ThinkTank[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ThinkTank|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
