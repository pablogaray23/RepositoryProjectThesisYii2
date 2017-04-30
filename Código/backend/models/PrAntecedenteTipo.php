<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "pr_antecedente_tipo".
 *
 * @property integer $id_antecedente_tipo
 * @property string $nombre_antecedente_tipo
 */
class PrAntecedenteTipo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pr_antecedente_tipo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre_antecedente_tipo'], 'required'],
            [['nombre_antecedente_tipo'], 'string', 'max' => 30],
            [['nombre_antecedente_tipo'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_antecedente_tipo' => 'Id Antecedente Tipo',
            'nombre_antecedente_tipo' => 'Nombre Antecedente Tipo',
        ];
    }
}
