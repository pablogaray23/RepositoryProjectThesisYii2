<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use backend\models\Event;
use backend\models\BoxGeneral;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\data\ArrayDataProvider;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reporte Porcentaje de Ocupación';
$this->params['breadcrumbs'][] = $this->title;

echo Html::a('<i class="fa glyphicon glyphicon-hand-up"></i> Reporte en PDF', ['reporte-porcentajepdf','month'=>$month-1,'year'=>$year,], [
    'class'=>'btn btn-danger', 
    'target'=>'_blank', 
    'data-toggle'=>'tooltip', 
    'title'=>'Se generara un PDF en una nueva ventana'
]);

$provider = new ArrayDataProvider([
    'allModels' => $lista,
]);
?>
<h2><center>Porcentaje de ocupación de el período <?php echo ($month-1)."/".$year?></center></h2>
<?= GridView::widget([
			'dataProvider' => $provider,
			'columns' => [
				['class' => 'yii\grid\SerialColumn'],
				[
					'label'=>'Nombre Box',
					'value'=>function($model){
						return $model[0];
					}
				],
				[
					'label'=>'Total horas utilizadas',
					'value'=>function($model){
						return $model[2];
					}
				],
				[
					'label'=>'Porcentaje de Ocupación',
					'value'=>function($model){
						return $model[1]."%";
					}
				]
			],
		]); ?>