<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\AtnGen;
use backend\models\AtnGenSearch;
use backend\models\EspAtn;
use backend\models\EspAtnSearch;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use yii\data\ActiveDataProvider;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\EspAtn */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $queryAtn=AtnGen::find()->all();
$listData=ArrayHelper::map($queryAtn,'id_atencion','nombre');

$queryEsp = EspAtn::find()->where(['id_esp_gen' => $esp]);
$searchModel = new EspAtnSearch();
$dataProvider = new ActiveDataProvider([
    'query' => $queryEsp,
    'pagination' => [
        'pageSize' => 10,
    ],
    'sort' => [
        'defaultOrder' => [
            
        ]
    ],
]);
		
?>

<div class="esp-atn-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_esp_gen')->hiddenInput(['readonly' => true,'value'=>$esp ])->label(false) ?>
	
	<?= $form->field($model, 'id_atn_gen')->widget(Select2::classname(), [
		'data' => $listData,
		'options' => ['placeholder' => 'Nueva Atención...'],
		'pluginOptions' => [
			'allowClear' => true
		],
	])->label('Nueva Atencion') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
	
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [	'class' => 'yii\grid\SerialColumn'],
			'atencion',
			['class' => 'yii\grid\ActionColumn',
				'template' => '{delete}',
				'buttons' => [],
			],
		],
		 		
		
    ]); ?>

</div>
