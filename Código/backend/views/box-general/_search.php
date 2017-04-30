<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use backend\models\AtnGen;
use backend\models\BoxGeneral;

/* @var $this yii\web\View */
/* @var $model backend\models\BoxGeneralSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box-general-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index' , 'id_sector' =>  $id_sector],
		'layout'=>'horizontal',
        'method' => 'get',
    ]); ?>
	
	<?php $algunosbox=BoxGeneral::find()->where([ 'id_sector' => $id_sector])->all();
	$listLosBox=ArrayHelper::map($algunosbox,'nombre_box','nombre_box');?>
	
	<?php $atencion=AtnGen::find()->all();
	$listDataTres=ArrayHelper::map($atencion,'id_atencion','nombre');?>



    <?= $form->field($model, 'id_sector') ->textInput(['readonly' => true]) ?>
	
	
	
	<?= $form->field($model, 'nombre_box')->dropDownList($listLosBox, ['prompt'=>'escoja box']) ?>
	
	<?= $form->field($model, 'boxatencion')->dropDownList($listDataTres,['prompt'=>'Seleccione Atención...']) ?>
	
	

    <div class="form-group">
	<div class="col-lg-offset-5">
        <?= Html::submitButton('<i class="glyphicon glyphicon-search"></i> Buscar ', ['class' => 'btn btn-primary']) ?>
        
		
		<?= Html::a(' <i class="glyphicon glyphicon-refresh"></i> Refrescar Página ', ['box-general/index', 'id_sector' => $id_sector],  ['class' => 'btn btn-warning'])?>
		</div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
