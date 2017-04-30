<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\form\ActiveField;
use kartik\widgets\FileInput;

use yii\bootstrap\Modal;
use backend\models\Equipamiento;
use backend\models\BoxAtencion;
use backend\models\BoxEquipamiento;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\BoxEquipamiento */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box-equipamiento-form">

<?php $atenciones=Equipamiento::find()->all();
	$listData=ArrayHelper::map($atenciones,'id_equipamiento','nombre_equipamiento');?>

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL]); ?>
	
	<?php if ($model->isNewRecord){?><!-- FORM CREATE -->

    <?= $form->field($model, 'id_box')->textInput(['readonly' => true,'value'=>$id]) ?>
	
    <?= $form->field($model, 'id_equipamiento')->dropDownList($listData,['prompt'=>'Seleccione...']) ?>
	
	<?= $form->field($model, 'comentario')->textInput(['maxlength' => true]) ?>
	
		<?php } else {?><!-- FORM UPDATE -->
	
	<?php
	$profEsp = BoxEquipamiento::findOne($id);
//$codigoDeLaEspecialidad = $profEsp->codigoEspecialidad;
$rutProfMed = $profEsp->id_box;

 $algunosbox=Equipamiento::find()->where([ 'id_equipamiento' => $model->id_equipamiento])->all();
	$listLosBox=ArrayHelper::map($algunosbox,'id_equipamiento','nombre_equipamiento');


	?>
	
		<?= $form->field($model, 'id_box')->textInput(['readonly' => true,'value'=>$rutProfMed]) ?>

	
	 <?= $form->field($model, 'id_equipamiento')->dropDownList($listLosBox) ?>
	 

    <?= $form->field($model, 'comentario')->textInput(['maxlength' => true]) ?>

	
	<?php } ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
