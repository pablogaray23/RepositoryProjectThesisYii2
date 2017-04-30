<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\time\TimePicker;	
use backend\models\PrMed;
use backend\controllers\PrMedController;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Event */
/* @var $form yii\widgets\ActiveForm */

$data = PrMed::find()->orderBy('apellidoPaterno')->asArray()->all();
$listData=ArrayHelper::map($data,'rut',['nombre']);
array_walk($listData,function(&$value,$key){
	$medAux = PrMed::find()->where(['rut'=>$key])->one();
	$value = $key.' | '.$medAux->nombre.' '.$medAux->apellidoPaterno;
});

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
	<div class="row">
		<div class="col-sm-2"></div>
		<div class="col-sm-4">
			<?= $form->field($model, 'date')->widget(\yii\jui\DatePicker::classname(), [
				'language' => 'es',
				'dateFormat' => 'dd-MM-yyyy',
			])->label("Desde") ?>
		</div>
		<div class="col-sm-4">
			<?= $form->field($modelDias, 'semanas')->widget(\yii\jui\DatePicker::classname(), [
				'language' => 'es',
				'dateFormat' => 'dd-MM-yyyy',
			])->label("Hasta") ?>
		</div>
	</div>
    <?= $form->field($model, 'start_time')->widget(\kartik\time\TimePicker::classname(), [
        'name' => 'start_time',
		'pluginOptions'=>[
			'showMeridian'=>false,
		],
])->label("Hora Inicio") ?>

    <?= $form->field($model, 'end_time')->widget(\kartik\time\TimePicker::classname(), [
    'name' => 'end_time',
	'pluginOptions'=>[
			'showMeridian'=>false,
		],
])->label("Hora Fin") ?>
	<?= $form->field($modelDias, 'dias')->checkboxList([1=>'Lunes', 2=>'Martes',3=>'Miercoles',4=>'Jueves',5=>'Viernes',6=>'Sabado']) ?>

    <div align="center" class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

	
	
    <?php ActiveForm::end(); ?>

</div>
