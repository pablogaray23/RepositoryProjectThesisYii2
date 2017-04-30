<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SectorInst */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sector-inst-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre_sector')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'id_piso')->hiddenInput(['readonly' => true,'value'=>$id_piso])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
