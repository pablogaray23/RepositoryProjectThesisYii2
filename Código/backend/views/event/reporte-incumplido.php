<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use backend\models\Event;
use backend\models\BoxGeneral;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reportes';
$this->params['breadcrumbs'][] = $this->title;

echo Html::a('<i class="fa glyphicon glyphicon-hand-up"></i> Reporte en PDF', ['reportepdf','fecha'=>$fecha], [
    'class'=>'btn btn-danger', 
    'target'=>'_blank', 
    'data-toggle'=>'tooltip', 
    'title'=>'Will open the generated PDF file in a new window'
]);
	?>
	
	<?= GridView::widget([
			'dataProvider' => $dataProvider,
			'columns' => [
				['class' => 'yii\grid\SerialColumn'],

				'rut_profesional',
				'id_box',
				[
					'label'=>'Box',
					'value'=>function ($key){
						return BoxGeneral::find()->where(['id_box'=>$key])->one()->nombre_box;
					}
				],
				[
					'label'=>'Titulo',
					'value'=>'title',
				],
				[
					'label'=>'Fecha',
					'value'=>'date',
				],
				[
					'label'=>'Hora Inicio',
					'value'=>'start_time',
				],
				[
					'label'=>'Hora Fin',
					'value'=>'end_time',
				]

			],
			'toolbar' =>[
				'{export}',
			],
		]); ?>
		
	
