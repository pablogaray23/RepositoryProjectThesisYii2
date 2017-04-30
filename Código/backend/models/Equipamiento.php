<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "equipamiento".
 *
 * @property integer $id_equipamiento
 * @property string $nombre_equipamiento
 * @property string $descripcion
 */
class Equipamiento extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'equipamiento';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre_equipamiento'], 'required'],
            [['nombre_equipamiento'], 'string', 'max' => 30],
            [['descripcion'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_equipamiento' => 'Id Equipamiento',
            'nombre_equipamiento' => 'Nombre Equipamiento',
            'descripcion' => 'Descripcion',
        ];
    }
}
