<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PisoInst */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="piso-inst-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre_piso')->textInput(['maxlength' => true]) ?>

	
	<?= $form->field($model, 'id_edificio')->hiddenInput(['readonly' => true,'value'=>$id_edificio])->label(false) ?>
	

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
