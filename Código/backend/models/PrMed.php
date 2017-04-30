<?php

namespace backend\models;


use Yii;

/**
 * This is the model class for table "pr_med".
 *
 * @property string $rut
 * @property string $nombre
 * @property string $apellidoPaterno
 * @property string $apellidoMaterno
 * @property string $email
 * @property integer $telefono
 * @property string $direccion
 */
class PrMed extends \yii\db\ActiveRecord
{
	public $horas;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pr_med';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        //   [['rut', 'nombre', 'apellidoPaterno'], 'required'],
			[['rut'], 'required', 'message' => 'Debe ingresar el R.U.T. del Profesional'],
		    [['nombre'], 'required', 'message' => 'Debe ingresar el nombre del Profesional'],
			[['apellidoPaterno'], 'required', 'message' => 'Debe ingresar el apellido paterno del Profesional'],
           // [['telefono'], 'integer'],
          //  ['telefono','match', 'pattern' => '/^[0-9]{6,10}$/','message'=>Yii::t('app','min. 6 dígitos máx. 9')],

			[['email'], 'email'],
            [['rut'], 'string', 'max' => 9],
			[['telefono'], 'string', 'max' => 11],
            [['nombre', 'apellidoPaterno', 'apellidoMaterno', 'email'], 'string', 'max' => 60],
            [['direccion'], 'string', 'max' => 100],
        ];
    }
	
	


	public function getProfespecialidad()
	{
	//..............................................claseSecundaria....clasePrimaria
		return $this->hasOne(PrEsp::className(), ['rut' => 'rut']);
	}

	public function getHorasMes()
	{
		$Eventos = Event::find()->where(['rut_profesional'=>$this->rut])->all();
		$sumaHoras = 0;
		foreach($Eventos as $evento){
			$sumaHoras = $sumaHoras + (strtotime($evento->end_time)-strtotime($evento->start_time));
		}
		$this->horas = $sumaHoras/3600;
		return $sumaHoras/3600;
	}

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rut' => 'R.U.T. (*)',
            'nombre' => 'Nombre Profesional (*)',
            'apellidoPaterno' => 'Apellido Paterno (*)',
            'apellidoMaterno' => 'Apellido Materno',
            'email' => 'Email',
            'telefono' => 'Telefono',
            'direccion' => 'Direccion',
        ];
    }
	public function existeRut($attribute,$params){
		$data = ProfesionalMedico::find()->where('rut = '.$attribute)->one();
		if ($data!=null){
			$this->addError($attribute, 'RUT ya existe');
			return \yii\widgets\ActiveForm::validate($model);
		}
	}
}
