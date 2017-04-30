<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use backend\models\Event;
use backend\models\BoxGeneral;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reportes';
$this->params['breadcrumbs'][] = $this->title;


$month = date('m',strtotime($fecha));
$year = date('Y',strtotime($fecha));
$query = Event::find()->select('*')->where('year(date)="'.$year.'"')->andWhere('month(date)="'.$month.'"')->andWhere(['<>','estado','Pendiente']);
$dataProvider = new ActiveDataProvider([
    'query' => $query,
]);
	?>
	<h2><center>Lista de bloques de horario incumplidos para el período <?php echo $fecha;?></center></h2>
	<br>
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
		
	
