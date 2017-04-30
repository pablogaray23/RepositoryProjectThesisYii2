<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "atn_gen".
 *
 * @property integer $id_atencion
 * @property string $nombre
 */
class AtnGen extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'atn_gen';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 20],
            [['nombre'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_atencion' => 'Id Atencion',
            'nombre' => 'Nombre',
        ];
    }
}
