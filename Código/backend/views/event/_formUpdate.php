<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\time\TimePicker;	
use backend\models\PrMed;
use backend\controllers\PrMedController;
use kartik\select2\Select2;
use yii\bootstrap\ButtonGroup;

/* @var $this yii\web\View */
/* @var $model app\models\Event */
/* @var $form yii\widgets\ActiveForm */

$data = PrMed::find()->orderBy('apellidoPaterno')->asArray()->all();
$listData=ArrayHelper::map($data,'rut','apellidoPaterno');
$fechaEvento = $model->date;
if ($fechaEvento>=date('Y-m-d')){
	$model->date=date('d-m-Y',strtotime($model->date));
	$modelIteraciones->repetirCambios=date('d-m-Y',strtotime($modelIteraciones->repetirCambios));
?>

<div class="event-form">
	
    <?php $form = ActiveForm::begin(['layout'=>'horizontal']);?>
	
	
	<?= $form->field($model, 'rut_profesional')->widget(Select2::classname(), [
		'data' => $listData,
		'options' => ['placeholder' => 'Seleccione Profesional'],
		'pluginOptions' => [
			'allowClear' => true
		],
	]); ?>
	

    <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label("Titulo") ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true])->label("Descripción") ?>

    <?= $form->field($model, 'date')->widget(\kartik\widgets\DatePicker::classname(), [
    'language' => 'es',
	'removeButton' => false,
	'pluginOptions'=>[
		'format'=> 'dd-mm-yyyy',
		'startDate' => date('d-m-Y'),
		
	]
])->label("Fecha") ?>

    <?= $form->field($model, 'start_time')->widget(\kartik\time\TimePicker::classname(), [
        'name' => 'start_time',
		'pluginOptions'=>[
			'showMeridian'=>false,
		],
])->label("Hora Fin") ?>

    <?= $form->field($model, 'end_time')->widget(\kartik\time\TimePicker::classname(), [
    'name' => 'end_time',
	'pluginOptions'=>[
			'showMeridian'=>false,
		],
])->label("Hora Fin") ?>
	<?= $form->field($modelIteraciones, 'repetirCambios')->widget(\kartik\widgets\DatePicker::classname(), [
    'language' => 'es',
	'removeButton' => false,
	'pluginOptions'=>[
		'format'=> 'dd-mm-yyyy',
		'startDate' => date('d-m-Y'),
	]
])->label("Repetir cambios hasta...") ?>

	<?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	
    <?php ActiveForm::end(); ?>

</div>
<?php 

} else {
	$form = ActiveForm::begin([
		'layout'=>'horizontal',
		'action' => 'index.php?r=event/block&id='.$model->id_event
	]);
	?>
	<h3>No puede editar eventos pasados</h3>
	<div align="col-md-1" class="form-group">
			<?= Html::submitButton('Marcar como Incumplido',
			[
				'class' => 'btn btn-primary',
				'data-confirm' => Yii::t('yii', '¿Esta seguro de marcarlo como incumplido?'),
			]);
			?>
			
	</div>
	<?php ActiveForm::end();
}
?>