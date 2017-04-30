<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "event".
 *
 * @property integer $id_event
 * @property string $rut_profesional
 * @property integer $id_box
 * @property string $title
 * @property string $description
 * @property string $date
 * @property string $start_time
 * @property string $end_time
 * @property string $estado
 */
class Event extends \yii\db\ActiveRecord
{
	
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rut_profesional', 'id_box', 'title', 'description', 'date', 'start_time', 'end_time', 'estado'], 'required'],
            [['id_box'], 'integer'],
            [['date', 'start_time', 'end_time'], 'safe'],
            [['rut_profesional'], 'string', 'max' => 11],
            [['title', 'description'], 'string', 'max' => 30],
            [['estado'], 'string', 'max' => 10],
        ];
    }

	

	
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_event' => 'Id Event',
            'rut_profesional' => 'Rut Profesional',
            'id_box' => 'Id Box',
            'title' => 'Title',
            'description' => 'Description',
            'date' => 'Date',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'estado' => 'Estado',
        ];
    }
}
