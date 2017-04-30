<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "pr_hor".
 *
 * @property integer $id_pr_horario
 * @property string $rut_profesional
 * @property integer $dia_semana
 * @property string $hora_inicio
 * @property string $hora_fin
 */
class PrHor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pr_hor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rut_profesional', 'dia_semana', 'hora_inicio', 'hora_fin'], 'required'],
            [['dia_semana'], 'integer'],
            [['hora_inicio', 'hora_fin'], 'safe'],
            [['rut_profesional'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pr_horario' => 'Id Pr Horario',
            'rut_profesional' => 'Rut Profesional',
            'dia_semana' => 'Dia Semana',
            'hora_inicio' => 'Hora Inicio',
            'hora_fin' => 'Hora Fin',
        ];
    }
}
