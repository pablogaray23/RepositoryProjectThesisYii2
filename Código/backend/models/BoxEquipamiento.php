<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "box_equipamiento".
 *
 * @property integer $id_box_equipamiento
 * @property integer $id_equipamiento
 * @property integer $id_box
 */
class BoxEquipamiento extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'box_equipamiento';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_equipamiento', 'id_box'], 'required'],
            [['id_equipamiento', 'id_box'], 'integer'],
			[['comentario'], 'string', 'max' => 50],
        ];
    }
	
			 public function getEquipamiento()
{
	//..............................................claseSecundaria....clasePrimaria
    return $this->hasOne(Equipamiento::className(), ['id_equipamiento' => 'id_equipamiento']);
}

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_box_equipamiento' => 'Id Box Equipamiento',
            'id_equipamiento' => 'Id Equipamiento',
			'comentario' => ' Comentario',
            'id_box' => 'Id Box',
        ];
    }
}
