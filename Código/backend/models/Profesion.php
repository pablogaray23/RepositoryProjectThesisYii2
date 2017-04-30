<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "profesion".
 *
 * @property integer $id_profesion
 * @property string $nombre_profesion
 */
class Profesion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profesion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre_profesion'], 'required'],
            [['nombre_profesion'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_profesion' => 'Id Profesion',
            'nombre_profesion' => 'Nombre Profesion',
        ];
    }
}
