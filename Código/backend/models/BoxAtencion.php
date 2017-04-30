<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "box_atencion".
 *
 * @property integer $id_boxAtencion
 * @property integer $id_boxGeneral
 * @property integer $id_atn
 */
class BoxAtencion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'box_atencion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_boxGeneral', 'id_atn'], 'required'],
            [['id_boxGeneral', 'id_atn'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
	 
	 public function getAtencion()
{
	//..............................................claseSecundaria....clasePrimaria
    return $this->hasOne(AtnGen::className(), ['id_atencion' => 'id_atn']);
}
	 
    public function attributeLabels()
    {
        return [
            'id_boxAtencion' => 'Id Box Atencion',
            'id_boxGeneral' => 'Id Box General',
            'id_atn' => ' Actividad ',
        ];
    }
}
