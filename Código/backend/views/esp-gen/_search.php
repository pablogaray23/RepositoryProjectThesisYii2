<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\form\ActiveField;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model backend\models\EspGenSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="esp-gen-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'codigoEspecialidad') ?>

    <?= $form->field($model, 'nombreEspecialidad', [
    'hintType' => ActiveField::HINT_SPECIAL,
    'hintSettings' => [
        'iconBesideInput' => true,
        'onLabelClick' => false,
        'onLabelHover' => false,
        'onIconClick' => true,
        'onIconHover' => true,
        'title' => '<i class="glyphicon glyphicon-info-sign"></i> Nota'
    ]
])->textArea([
    'id' => 'address-input', 
    'placeholder' => 'Por ejemplo :     Cardiología, Fonoaudiología, etc....' 
   // 'rows' => 4
])->hint('<b> Longitud </b> </br>  Máximo <u> 60 caracteres </u>.') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
