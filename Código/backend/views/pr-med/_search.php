<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\models\EspGen;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\PrMedSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pr-med-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
		'layout' => 'horizontal',
        'method' => 'get',
    ]); ?>
	
	<?php $profesiones=EspGen::find()->all();
	$listDataTres=ArrayHelper::map($profesiones,'codigoEspecialidad','nombreEspecialidad');?>

    <?php // $form->field($model, 'rut') ?>

    <?php // $form->field($model, 'nombre') ?>

    <?php // $form->field($model, 'apellidoPaterno') ?>

    <?php // echo $form->field($model, 'apellidoMaterno') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'telefono') ?>

    <?php // echo $form->field($model, 'direccion') ?>

    <?= $form->field($model, 'profespecialidad')->dropDownList($listDataTres, ['prompt'=>'escoja profesión']) ?>
	
	

    <?php // echo $form->field($model, 'institucion_est') ?>

    <?php // echo $form->field($model, 'anio') ?>

    <div align="center" class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset Grid', ['index'], ['class' => 'btn btn-info']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
