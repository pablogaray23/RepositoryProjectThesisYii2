<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\models\Profesion;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use kartik\widgets\DepDrop;
use yii\helpers\Url;

use backend\models\EdificioInst;
use backend\models\PisoInst;
use backend\models\SectorInst;
use backend\models\AtnGen;

use yii\helpers\Json;


/* @var $this yii\web\View */
/* @var $model backend\models\BoxGeneralSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box-general-search">

    <?php $form = ActiveForm::begin([
        'action' => ['box-general/boxs'],
		'layout' => 'horizontal',
        'method' => 'get',
    ]); ?>
	
	
	
	

    <?php // $form->field($model, 'id_box') ?>
	
	<?= $form->field($model, 'paraedificio')->dropDownList(
		ArrayHelper::map(EdificioInst::find()->all(),'id_edificio','nombre_edificio'),
		[
			'id' => 'id_edificio',
			'prompt' => 'Seleccione...',
		]
	) ?>
	
	<?= $form->field($model, 'parapiso')->widget(DepDrop::classname(), [
    'options'=>['id'=>'id_piso'],
    'pluginOptions'=>[
        'depends'=>['id_edificio'],
        'placeholder'=>'Seleccione...',
        'url'=>Url::to(['box-general/sel-piso'])
		]
	])->label('Piso');	?>
	
	 <?= $form->field($model, 'id_sector')->widget(DepDrop::classname(), [
    'pluginOptions'=>[
        'depends'=>['id_edificio', 'id_piso'],
        'placeholder'=>'Seleccione...',
        'url'=>Url::to(['box-general/sel-sector'])
		]
	])->label('Sector');?>
	

    <?= $form->field($model, 'nombre_box')->label("Nombre") ?>

	<?= $form->field($model, 'boxatencion')->dropDownList(
		ArrayHelper::map(AtnGen::find()->all(),'id_atencion','nombre'),
		[
			'id' => 'id_atencion',
			'prompt' => 'Seleccione...',
		]
	)->label("Tipo Atencion") ?>

    <div align="center" class="form-group">
        <?= Html::submitButton('Filtrar', ['class' => 'btn btn-primary']) ?>
        <?= Html::a(' <i class="glyphicon glyphicon-refresh"></i> Refrescar Página ', ['box-general/boxs'],  ['class' => 'btn btn-warning'])?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
