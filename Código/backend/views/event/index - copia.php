<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Event;
use backend\models\BoxGeneral;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reportes';
$this->params['breadcrumbs'][] = $this->title;

$minutosDia=15*5*60;
//$esteEvento = Event::find()->where(['id_box'=>'2'])->andWhere(['between','date','2016-07-20','2016-07-24'])->all();
$listaIdBox = BoxGeneral::find()->select('id_box, nombre_box')->all();
//$Eventos = Event::find()->where(['between','date','2016-06-20','2016-06-24'])->andWhere(['id_box'=>'2'])->all();



?>
<?php
		Modal::begin([
			'options' => [
				'id' => 'modal',
				'tabindex' => false // important for Select2 to work properly
			],
			'header'=>false,
			//'id'=>'modal',
			'size'=>'modal-lg',
		]);
		echo "<div id='modalContent'></div>";
		Modal::end();
	?>
<div class="event-index row">
	<center><h2>Reportes</h2></center>
	<div class="col-sm-4" style="outline: 1px solid orange;">
		Aca va el espacio para explicar reporte de horas usadas en cada box<br><br><br><br>
		<center><?= Html::button('<i class="glyphicon glyphicon-list-alt"></i> Porcentaje de Ocupación', ['value'=>Url::to('index.php?r=event/reporte-incumplido'),'class' => 'btn btn-primary ajax_button']) ?></center>
	</div>
    <div class="col-sm-4" style="outline: 1px solid orange;">
		Aca va el espacio para explicar lista eventos incumplidos del mes
	</div>
	<div class="col-sm-4" style="outline: 1px solid orange;"><br>
		<?php 
		foreach($listaIdBox as $box){
			$Eventos = Event::find()->where(['between','date','2016-06-20','2016-06-24'])->andWhere(['id_box'=>$box->id_box])->all();
			$minutosTotales = 0;
			foreach($Eventos as $actual)
			{
				$horaInicio = strtotime($actual->start_time);
				$horaFin = strtotime($actual->end_time);
				$diff = ($horaFin-$horaInicio)/60;
				//echo $actual->id_event.": ".$diff."<br>";
				$minutosTotales = $minutosTotales+$diff;
			}
			$promedio = round((100*$minutosTotales)/$minutosDia,0,PHP_ROUND_HALF_DOWN);
			echo $box->nombre_box.' '.$promedio."% | Horas usadas: ".round($minutosTotales/60,0,PHP_ROUND_HALF_DOWN) ."<br>";
		}
		?>
		<br>
		martes:<?php ?>
		<br>
		miercoles:<?php ?>
		<br>
		jueves:<?php ?>
		<br>
		viernes:<?php ?>
		<br>
	</div>
</div>
