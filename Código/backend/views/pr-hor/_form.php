<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\time\TimePicker;	

/* @var $this yii\web\View */
/* @var $model backend\models\PrHor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pr-hor-form">

    <?php $form = ActiveForm::begin(); ?>

    

    <?= $form->field($model, 'dia_semana')->textInput()->dropDownList([0=>'Lunes',1=>'Martes',2=>'Miercoles',3=>'Jueves',4=>'Viernes',5=>'Sabado'],['style'=>'width:200px']) ?>

    <?= $form->field($model, 'hora_inicio')->widget(\kartik\time\TimePicker::classname(), [
			'name' => 'start_time',
			'containerOptions' => ['style'=>'width:200px'],
			'pluginOptions'=>[
				'showMeridian'=>false,
			],
	],['style'=>'width:200px'])->label("Hora Inicio") ?>

    <?= $form->field($model, 'hora_fin')->widget(\kartik\time\TimePicker::classname(), [
			'name' => 'start_time',
			'containerOptions' => ['style'=>'width:200px'],
			'pluginOptions'=>[
				'showMeridian'=>false,
			],
	])->label("Hora Fin") ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
