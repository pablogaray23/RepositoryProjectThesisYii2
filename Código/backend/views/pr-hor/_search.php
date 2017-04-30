<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PrHorSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pr-hor-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_pr_horario') ?>

    <?= $form->field($model, 'rut_profesional') ?>

    <?= $form->field($model, 'dia_semana') ?>

    <?= $form->field($model, 'hora_inicio') ?>

    <?= $form->field($model, 'hora_fin') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
