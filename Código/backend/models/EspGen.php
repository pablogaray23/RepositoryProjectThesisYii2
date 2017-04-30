<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "esp_gen".
 *
 * @property integer $codigoEspecialidad
 * @property string $nombreEspecialidad
 */
class EspGen extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'esp_gen';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombreEspecialidad'], 'required', 'message' => 'Debe ingresar al menos una especialidad.'],
            [['nombreEspecialidad'], 'string', 'max' => 60],
        ];
    }
	
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'codigoEspecialidad' => 'Codigo Especialidad',
            'nombreEspecialidad' => 'Nombre Especialidad (*)',
        ];
    }
}
