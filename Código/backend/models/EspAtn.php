<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "esp_atn".
 *
 * @property integer $id
 * @property integer $id_esp_gen
 * @property integer $id_atn_gen
 */
class EspAtn extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'esp_atn';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_esp_gen', 'id_atn_gen'], 'required'],
            [['id_esp_gen', 'id_atn_gen'], 'integer'],
        ];
    }
	public function getAtencion()
	{
		$atencion = AtnGen::find()->where(['id_atencion'=>$this->id_atn_gen])->one();
		return $atencion->nombre;
	}
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_esp_gen' => 'Id Esp Gen',
            'id_atn_gen' => 'Id Atn Gen',
        ];
    }
}
