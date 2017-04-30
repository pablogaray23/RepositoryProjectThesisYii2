<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\form\ActiveField;
use kartik\widgets\FileInput;
use backend\models\AtnGen;
use yii\bootstrap\Modal;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\EspGen */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="esp-gen-form">

    <?php
	$form = ActiveForm::begin([
		'type' => ActiveForm::TYPE_VERTICAL
    ]) 
	?>
	<?php
	$datos=AtnGen::find()->orderBy('nombre')->asArray()->all();
	$listData=ArrayHelper::map($datos,'id_atencion','nombre');
	?>

	<div class="body-content">
		<div class="row">

		<?php if ($model->isNewRecord){?><!-- FORM CREATE -->
	 
	 
				<div  align='center'>

					<p align="left"><font size="3"> Fecha Actual : <?php echo date('d-m-Y'); ?></font> </p>
		
				</div><!-- close row last row-->
				<p>&nbsp;</p>  
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
					'placeholder' => 'Por ejemplo: Cardiología, Fonoaudiología, etc....' 
				   // 'rows' => 4
				])->hint('<b> Longitud </b> </br>  Máximo <u> 60 caracteres </u>.') ?>
				
			
	 
			<?php } else {?><!-- FORM UPDATE -->
	 
 
				<div style='display:table-cell; vertical-align:middle; text-align:center'>
 
					<p align="left"><font size="3"> Fecha Actual : <?php echo date('d-m-Y'); ?></font> </p>
	  
					<p>&nbsp;</p>
					<?= Html::img('imagenes/depositphotos_1335763-Medical-documents.jpg', ['width'=>'25%','display'=>'block','margin-left'=>'auto','margin-right'=>'auto','height'=>'15%'],['alt' => 'alt image']); ?>
        
				</div><!-- close row last row-->
				<p>&nbsp;</p>

			<?= $form->field($model, 'nombreEspecialidad')->textInput(['maxlength' => true])->label("Nombre <small>Original: ".$model->nombreEspecialidad."</small>") ?>

			
	 
	 	<?php } ?>
	
		</div>
	</div>
    <div class="form-group">
		<div class="col-lg-offset-5">
        <?= Html::submitButton($model->isNewRecord ? '<i class="glyphicon glyphicon-floppy-disk"></i> Guardar' : '<i class="glyphicon glyphicon-floppy-disk"></i> Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
