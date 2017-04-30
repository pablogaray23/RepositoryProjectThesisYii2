<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\form\ActiveField;
use backend\models\EspGen;
use backend\models\PrEsp;
use backend\models\PrEspSearch;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\PrMed */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pr-med-form">


   <?php $form = ActiveForm::begin([
 //  'enableClientValidation' => true,
   'id' => 'modalContent',
   'type' => ActiveForm::TYPE_VERTICAL]); ?>
   
   <div class="body-content">
 <div class="row">
	
	<?php $esp=EspGen::find()->orderBy('nombreEspecialidad')->asArray()->all();
	$listData=ArrayHelper::map($esp,'codigoEspecialidad','nombreEspecialidad');?>
	
	
        

	
	<?php if ($model->isNewRecord){?><!-- FORM CREATE -->
	
	 <div class="col-md-6">
	 
	   <center><h2> Datos Personales </h2></center>
	   <p>&nbsp;</p>

    <?= $form->field($model, 'rut', [
    'hintType' => ActiveField::HINT_SPECIAL,
    'hintSettings' => [
        'iconBesideInput' => true,
        'onLabelClick' => true,
        'onLabelHover' => false,
        'onIconClick' => true,
        'onIconHover' => true,
        'title' => '<i class="glyphicon glyphicon-info-sign"></i> Nota'
    ],
	 'feedbackIcon' => [
        'prefix' => 'fa fa-',
      //  'default' => 'phone',
        'success' => 'check-circle',
        'error' => 'exclamation-circle',
    ]
])->textArea([
    'id' => 'address-input', 
    'placeholder' => 'Por ejemplo :  179894076, 18768543k, etc....' ,
    'rows' => 1
])->hint('<b> Longitud </b> </br>   Máximo <u> 11 caracteres </u>. </br> <b> Formato </b> </br>  En lo posible <u> sin puntos ni guión </u>.') ?>

    <?= $form->field($model, 'nombre', [
    'feedbackIcon' => [
        'prefix' => 'fa fa-',
        'default' => 'user',
        'success' => 'user-plus',
        'error' => 'user-times',
        'defaultOptions' => ['class'=>'text-warning']
    ]
])->textInput(['placeholder'=>'Ingresa un nombre...']) ?>

    <?= $form->field($model, 'apellidoPaterno', [
    'feedbackIcon' => [
        'prefix' => 'fa fa-',
        'default' => 'user',
        'success' => 'user-plus',
        'error' => 'user-times',
        'defaultOptions' => ['class'=>'text-warning']
    ]
])->textInput(['placeholder'=>'Ingresa un apellido paterno...']) ?>

    <?= $form->field($model, 'apellidoMaterno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(array('placeholder' => 'nombre@gmail.com')) ?>

    <?= $form->field($model, 'telefono', [
    'feedbackIcon' => [
        'prefix' => 'fa fa-',
        'default' => 'phone',
        'success' => 'check-circle',
        'error' => 'exclamation-circle',
    ]
])->widget('yii\widgets\MaskedInput', [
    'mask' => '999-9999999'
])->textInput(['placeholder'=>' Ejemplo 042-214758']) ?>

    <?= $form->field($model, 'direccion')->textInput(['maxlength' => true]) ?>
	
	</div>
	
		 <div class="col-md-6">
	 
	   <h2> Datos Académicos </h2>
	   <p>&nbsp;</p>

    <?= $form->field($modelE, 'codigoEspecialidad')->widget(Select2::classname(), [
    'data' => $listData,
    'options' => ['placeholder' => 'Selecciona una especialidad ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]) ?>
	
	
	<?= $form->field($modelE, 'institucion')->textInput(array('placeholder' => 'Ciudad donde estudió ProfesionalMedico')) ?>
	
	<?= $form->field($modelE, 'anio')->textInput(array('placeholder' => 'Año egreso ProfesionalMedico')) ?>
	
	    	<blockquote>			
                <h3>Información General </h3>
				<small> Los campos marcados con (*) son obligatorios.</small>
				<small>En caso de equivarse, los datos pueden ser modificados.</small>

				<center><p>* Indicaciones *</p></center>
				
  <small> Es recomendable completar los campos <cite title="letra">email</cite> , <cite title="número">teléfono</cite> o <cite title="número">dirección</cite> 
  para poder contactar o comunicarse con el Profesional Médico.
     </br>
   Se entenderá por <u> Especialidad Principal </u> al campo o área principal que el Profesional Médico ejerce como su Profesión. En caso de los Médicos, es recomendable registrar su Especialidad Principal, ya que se "asume" que el profesional es <u>Médico General</u>. </small>
  
  
				
				
				
				
				</blockquote>
	
	</div>
	
	<?php } else {?><!-- FORM UPDATE -->
	
	<div class="col-md-7">
	
	    <?= $form->field($model, 'rut')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'apellidoPaterno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'apellidoMaterno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telefono')->textInput() ?>

    <?= $form->field($model, 'direccion')->textInput(['maxlength' => true]) ?>

	
	</div>
	
			 <div class="col-md-6">
	 
	   <h2> Datos Académicos </h2>
	   <p>&nbsp;</p>

	
	</div>
	
	<?php } ?>
	
	</div>
	
	</div>
	

    <div align="center" class="form-group">
	 <?= Html::resetButton('<i class="glyphicon glyphicon-repeat"></i> Deshacer', ['class' => 'btn btn-default']) ?>

           <?= Html::submitButton($model->isNewRecord ? '<i class="glyphicon glyphicon-floppy-disk"></i> Guardar' : '<i class="glyphicon glyphicon-floppy-disk"></i> Actualizar ', ['class' => $model->isNewRecord ? 'btn btn-success ajax_button' : 'btn btn-primary']) ?>
         
  </div>

    <?php ActiveForm::end(); ?>

</div>
