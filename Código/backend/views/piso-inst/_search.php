<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$id_edificio=Yii::$app->request->post("id_edificio");

/* @var $this yii\web\View */
/* @var $model backend\models\PisoInstSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="piso-inst-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>


    <?= $form->field($model, 'nombre_piso') ?>

	
	<?= $form->field($model, 'id_edificio')->textInput(['readonly' => true,'value'=>$id_edificio]) ?>

    <div class="form-group">
        <?= Html::a('Submit', ['piso-inst/index'], [
		'class' => 'btn btn-success',
        'data' => [
            'method' => 'get',
            'params'=>[
				
				'id_edificio' => $id_edificio,
				],
        ]
    ])?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
