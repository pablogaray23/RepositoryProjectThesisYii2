<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "auth_assignment".
 *
 * @property string $user_id
 * @property string $item_name
 * @property integer $created_at
 */
class AuthAssignment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auth_assignment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'item_name', 'created_at'], 'required'],
            [['created_at'], 'integer'],
            [['user_id', 'item_name'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'item_name' => 'Item Name',
            'created_at' => 'Created At',
        ];
    }
}
