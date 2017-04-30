<?php

namespace backend\models;


use Yii;

/**
 * This is the model class for table "box_general".
 *
 * @property integer $id_box
 * @property string $nombre_box
 * @property integer $id_sector
 */
class BoxGeneral extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'box_general';
    }
	
	public $field;
	public $campo;
	public $paraedificio;
	public $parapiso;
	public $paraAtencion;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre_box', 'id_sector'], 'required'],
            [['id_sector'], 'integer'],
            [['nombre_box'], 'string', 'max' => 20],
			[['field','paraedificio', 'parapiso','campo','paraAtencion'], 'integer', 'min' => 1],
			[['field'], 'compare', 'compareAttribute' => 'campo', 'operator' => '>=' , 'message' => 'Rango Fin debe ser mayor a Rango Inicio'],
        ];
    }
	
	public function getSector()
{
    return $this->hasOne(SectorInst::className(), ['id_sector' => 'id_sector']);
}

	public function getBoxatencion()
{
	//..............................................claseSecundaria....clasePrimaria
    return $this->hasOne(BoxAtencion::className(), ['id_boxGeneral' => 'id_box']);
}

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_box' => 'Id Box',
            'nombre_box' => 'Nombre Box',
            'id_sector' => 'Id Sector',
			'campo' => 'Rango de Inicio',
			'field' => 'Rango de Fin',
			'paraedificio' => 'Edificio',
        ];
    }
}
