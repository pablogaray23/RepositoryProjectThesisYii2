<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\form\ActiveField;
use backend\models\EspGen;
use backend\models\PrEsp;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\PrEsp */
/* @var $form yii\widgets\ActiveForm */


//$id=Yii::$app->request->get("id");


?>

<div class="pr-esp-form">

<?php $esp=EspGen::find()->all();
	$listData=ArrayHelper::map($esp,'codigoEspecialidad','nombreEspecialidad');?>
	

    <?php $form = ActiveForm::begin([
 //  'enableClientValidation' => true,
   'id' => 'modalContent',
   'type' => ActiveForm::TYPE_VERTICAL]); ?>
   
   <?php if ($model->isNewRecord){?><!-- FORM CREATE -->

	<?= $form->field($model, 'rut')->textInput(['readonly' => true,'value'=>$id]) ?>

	
	 <?= $form->field($model, 'codigoEspecialidad')->widget(Select2::classname(), [
    'data' => $listData,
    'options' => ['placeholder' => 'Selecciona una especialidad ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]) ?>

    <?= $form->field($model, 'institucion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'anio')->textInput() ?>
	
	<?php } else {?><!-- FORM UPDATE -->
	
	<?php
	$profEsp = PrEsp::findOne($id);
//$codigoDeLaEspecialidad = $profEsp->codigoEspecialidad;
$rutProfMed = $profEsp->rut;

 $algunosbox=EspGen::find()->where([ 'codigoEspecialidad' => $model->codigoEspecialidad])->all();
	$listLosBox=ArrayHelper::map($algunosbox,'codigoEspecialidad','nombreEspecialidad');


	?>
	
		<?= $form->field($model, 'rut')->textInput(['readonly' => true,'value'=>$rutProfMed]) ?>

	
	 <?= $form->field($model, 'codigoEspecialidad',[
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
])->dropDownList($listLosBox)->hint('<b> Importante </b> </br>  Sólo debe editar la información de los demás campos.') ?>
	 

    <?= $form->field($model, 'institucion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'anio')->textInput() ?>
	
	<?php } ?>

    <div class="form-group">
  <?= Html::submitButton($model->isNewRecord ? '<i class="glyphicon glyphicon-floppy-disk"></i> Guardar' : '<i class="glyphicon glyphicon-floppy-disk"></i> Actualizar ', ['class' => $model->isNewRecord ? 'btn btn-success ajax_button' : 'btn btn-primary']) ?>
         
    </div>

    <?php ActiveForm::end(); ?>

</div>
