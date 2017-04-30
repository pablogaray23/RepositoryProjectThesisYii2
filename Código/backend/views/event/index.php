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
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Bootstrap 3, from LayoutIt!</title>

    <meta name="description" content="Source code generated using layoutit.com">
    <meta name="author" content="LayoutIt!">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

  </head>
  <body>

    <div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<h3 class="text-center text-primary">
				Reportes
			</h3>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<p>
				<h4>Una lista de el uso de todos los box dentro del periodo de un mes. Muestra la cantidad de horas utilizadas y el porcentaje.<h4>
			</p> 
			<br>
			<center><?= Html::button('<i class="glyphicon glyphicon-list-alt"></i> Porcentaje de Ocupación', ['value'=>Url::to('index.php?r=event/reporte-porcentaje'),'class' => 'btn btn-primary btn-lg ajax_button']) ?></center>
		</div>
		<div class="col-md-4">
			<p>
				<h4>Listar la lista mensual de profesionales que no han cumplido su horario. <b>Se recuerda marcar las horas como incumplidas en el sistema de horarios para tener un reporte actual.<b><h4>
			</p> 
				<center><?= Html::button('<i class="glyphicon glyphicon-list-alt"></i> Incumplimiento de Horas', ['value'=>Url::to('index.php?r=event/reporte-incumplido'),'class' => 'btn btn-primary btn-lg ajax_button']) ?></center>
		</div>
		<div class="col-md-4">
			<p>
				<h4>Listar las horas trabajadas por cada profesional en orden descendiente.<h4>
			</p>
			<br>
			<br>
				<center><?= Html::button('<i class="glyphicon glyphicon-list-alt"></i> Ranking de Profesionales', ['value'=>Url::to('index.php?r=event/reporte-ranking'),'class' => 'btn btn-primary btn-lg ajax_button']) ?></center>
		</div>
	</div>
</div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/scripts.js"></script>
  </body>
