<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "piso_inst".
 *
 * @property integer $id_piso
 * @property string $nombre_piso
 * @property integer $id_edificio
 */
class PisoInst extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'piso_inst';
    }
	

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre_piso', 'id_edificio'], 'required'],
            [['id_edificio'], 'integer'],
            [['nombre_piso'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_piso' => 'Id Piso',
            'nombre_piso' => 'Nombre Piso',
            'id_edificio' => 'Id Edificio',
        ];
    }
}
