<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[PrEsp]].
 *
 * @see PrEsp
 */
class PrEspQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return PrEsp[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return PrEsp|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
