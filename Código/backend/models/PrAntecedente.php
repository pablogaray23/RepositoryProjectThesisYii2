<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "pr_antecedente".
 *
 * @property integer $id
 * @property string $rut_med
 * @property string $nombreArchivo
 * @property integer $tipoAntecedente
 * @property string $fechaSubida
 */
class PrAntecedente extends \yii\db\ActiveRecord
{
	public $file;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pr_antecedente';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rut_med', 'nombreArchivo', 'tipoAntecedente', 'fechaSubida'], 'required'],
            [['tipoAntecedente'], 'integer'],
            [['fechaSubida'], 'safe'],
            [['rut_med'], 'string', 'max' => 15],
            [['nombreArchivo'], 'string', 'max' => 60],
			[['file'], 'file', 'skipOnEmpty' => false,'maxFiles' => 1,'extensions'=>'docx, pdf, xlsx, odt, doc, xls'],
        ];
    }
	
	public function getProfespecialidad()
	{
		//..............................................claseSecundaria....clasePrimaria
		return $this->hasOne(PrEsp::className(), ['rut' => 'rut_med']);
	}
	
	public function getNombretipo()
	{
		//..............................................claseSecundaria....clasePrimaria
		return $this->hasOne(PrAntecedenteTipo::className(), ['id_antecedente_tipo' => 'tipoAntecedente']);
	}

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rut_med' => 'Rut Med',
            'nombreArchivo' => 'Nombre Archivo',
            'tipoAntecedente' => 'Tipo Antecedente',
            'fechaSubida' => 'Fecha Subida',
        ];
    }
}
