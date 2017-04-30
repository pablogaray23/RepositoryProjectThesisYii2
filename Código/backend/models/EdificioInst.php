<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "edificio_inst".
 *
 * @property integer $id_edificio
 * @property string $nombre_edificio
 */
class EdificioInst extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'edificio_inst';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre_edificio'], 'required'],
            [['nombre_edificio'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_edificio' => 'Id Edificio',
            'nombre_edificio' => 'Nombre Edificio',
        ];
    }
}
