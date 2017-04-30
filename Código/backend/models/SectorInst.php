<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "sector_inst".
 *
 * @property integer $id_sector
 * @property string $nombre_sector
 * @property integer $id_piso
 */
class SectorInst extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sector_inst';
    }
	
	public $field;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre_sector', 'id_piso'], 'required'],
            [['id_piso'], 'integer'],
            [['nombre_sector'], 'string', 'max' => 20],
			[['field'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_sector' => 'Id Sector',
            'nombre_sector' => 'Nombre Sector',
            'id_piso' => 'Id Piso',
        ];
    }
}
