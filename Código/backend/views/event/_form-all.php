<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\time\TimePicker;	
use backend\models\PrMed;
use backend\controllers\PrMedController;
use kartik\select2\Select2;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Event */
/* @var $form yii\widgets\ActiveForm */

$data = PrMed::find()->orderBy('apellidoPaterno')->asArray()->all();
$listData=ArrayHelper::map($data,'rut','apellidoPaterno');

?>

<div class="event-form">
	
    <?php $form = ActiveForm::begin(['layout'=>'horizontal']);?>
	
	<?= $form->field($limite, 'semanaInicio')->widget(\kartik\date\DatePicker::classname(), [
	'language' => 'es',
	'pluginOptions' => [
        'calendarWeeks' => true,
        'daysOfWeekDisabled' => [0,2,3,4,5,6],
        'format' => 'dd-mm-yyyy',
        'autoclose' => true,
    ]
]) ?>
	
	<?= $form->field($limite, 'semanaFin')->widget(\kartik\date\DatePicker::classname(), [
	'language' => 'es',
	'pluginOptions' => [
        'calendarWeeks' => true,
        'daysOfWeekDisabled' => [0,2,3,4,5,6],
        'format' => 'dd-mm-yyyy',
        'autoclose' => true,
    ]
]) ?>
	
    <div align="center" class="form-group">
        <?= Html::submitButton('Generar',['class' => 'btn btn-success']) ?>
    </div>

	
	
    <?php ActiveForm::end(); ?>

</div>
