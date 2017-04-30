<?php


use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use backend\models\AtnGen;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\BoxAtencion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box-atencion-form">

     <?php $esp=AtnGen::find()->all();
	$listData=ArrayHelper::map($esp,'id_atencion','nombre');?>
    <?php $form = ActiveForm::begin(
	['layout' => 'horizontal',
	'fieldConfig' => [
        'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
        'horizontalCssClasses' => [
            'rut' => 'col-sm-4',
            'offset' => 'col-sm-offset-4',
            'wrapper' => 'col-sm-8',
            'error' => '',
            'hint' => '',
        ],
	]
	]); ?>
	
	
		  <p>&nbsp;</p>
			
			<center><h2>Información de Tipos de Actividades </h2></center>
			
		  <p>&nbsp;</p>
		    <p>&nbsp;</p>

	
	<?= $form->field($model, 'id_boxGeneral')->textInput(['readonly' => true,'value'=>$id]) ?>
	
	<?= $form->field($model, 'id_atn')->dropDownList($listData,['prompt'=>'Seleccione...']) ?>

    

    <div class="form-group">
	<div class="col-lg-offset-5">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
	 </div>

    <?php ActiveForm::end(); ?>

</div>
