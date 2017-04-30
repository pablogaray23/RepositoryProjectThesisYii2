<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "pr_esp".
 *
 * @property integer $id_pr_esp
 * @property string $rut
 * @property integer $codigoEspecialidad
 * @property string $institucion
 * @property integer $anio
 */
class PrEsp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pr_esp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rut'], 'required'],
			[['codigoEspecialidad'], 'required', 'message' => 'Debe seleccionar la especialidad del Profesional'],
            [['codigoEspecialidad', 'anio'], 'integer'],
            [['rut'], 'string', 'max' => 11],
            [['institucion'], 'string', 'max' => 50],
        ];
    }
	
		public function getEspecialidad()
{
    return $this->hasOne(EspGen::className(), ['codigoEspecialidad' => 'codigoEspecialidad']);
}

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pr_esp' => 'Id Pr Esp',
            'rut' => 'Rut',
            'codigoEspecialidad' => 'Especialidad Principal',
            'institucion' => ' Institución de Educación que estudió',
            'anio' => 'Año de egreso ',
        ];
    }
}
