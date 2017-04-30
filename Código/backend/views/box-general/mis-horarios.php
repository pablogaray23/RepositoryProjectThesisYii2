<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\web\JsExpression;
use yii\bootstrap\Modal;
use backend\models\Event;
use backend\controllers\EventController;
use yii\data\ActiveDataProvider;
use yii\bootstrap\Alert;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\BoxGeneral */

$this->title = $model->nombre_box .', Sector '.$model->id_sector;
$this->params['breadcrumbs'][] = ['label' => 'Box Horarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<link rel='stylesheet' href='fullcalendar/fullcalendar.css' />
<script src='js/jquery.min.js'></script>
<script src='js/moment.min.js'></script>
<script src='fullcalendar/fullcalendar.js'></script>
<?php @session_start();
if (isset($_SESSION['choque'])){
echo Alert::widget([
    'options' => [
        'class' => 'alert-warning',
    ],
	'body' => 'El bloque del dia $model->dia choca con un evento existente',
]);
unset($_SESSION['choue']);
}
@session_destroy();
?>
<div id='calendar' class="box-general-horario calendar"><h1><?= Html::encode($this->title) ?></h1></div>
<?php
		Modal::begin([
		'options' => [
				'id' => 'modal',
				'tabindex' => false // important for Select2 to work properly
			], 
			'header'=>'<h4>Datos Box</h4>',
			//'id'=>'modal',
			'size'=>'modal-lg',
			
		]);
		echo "<div id='modalContent'></div>";
		Modal::end();
	?>
	<?php
    $events = array();
	$test = new Event;
	$eventos = Event::find()->where(['id_box' => $_GET['id']])->andWhere(['rut_profesional'=>$rut])->all();
	foreach($eventos as $evento){
		//$contador=4;
		//while($contador>0){
			$Event = new \yii2fullcalendar\models\Event();
			$Event->id = $evento->id_event;
			$Event->title = $evento->title;
			//$semana = 7*$contador;
			//$dia = date("Y-m-d",strtotime($evento->date.'+'.$semana.' days'));
			//echo $dia;
			$Event->start = date($evento->date.'\T'.$evento->start_time.'\Z');
			$Event->end = date($evento->date.'\T'.$evento->end_time.'\Z');
			$events[] = $Event;
			//$contador--;
		//}
	}

	//Testing
	/*
	$Event = new \yii2fullcalendar\models\Event();
	$Event->id = 1;
	$Event->title = 'Aweonao\nOrtodoncia';
	$Event->start = date('Y-m-d\TH:i:s\Z');
	$Event->startEditable = true;
	$events[] = $Event;
	
	$Event = new \yii2fullcalendar\models\Event();
	$Event->id = 3;
	$Event->title = 'oli';
	$Event->start = date('Y-m-d\TH:i:s\Z',strtotime('tomorrow 10am'));
	$Event->startEditable = true;
	$events[] = $Event;

	$Event = new \yii2fullcalendar\models\Event();
	$Event->id = 2;
	$Event->title = 'Francisco Parra | Ortodoncia';
	$Event->start = date('Y-m-d\TH:i:s\Z',strtotime('tomorrow 6am'));
	$Event->startEditable = true;
	$events[] = $Event;
	*/
  ?>
  
<?= \yii2fullcalendar\yii2fullcalendar::widget(array(
	'events'=> $events,
	'header'=> [
		'center'=>'prev,next week',
		'left'=>'agendaWeek,basicDay',        
        'right'=>''
	],
	'clientOptions' => [
		'allDaySlot' => false,
		'height' => 500,
		'lang' => 'es',
		'titleFormat' => ('MMMM D YYYY'),
		'slotLabelFormat' => 'h:mmt',
		'columnFormat' => 'dddd D/M',
		'scrollTime' => '00:15:00',
        'weekends' => false,
        'defaultView' => 'agendaWeek',
		'selectable'=>true,
		'selectableHelper' => true,
		'droppable' => false,
		'editable' => true,
		'defaultDate' => date('Y-m-d'),
		'minTime'=> '08:00:00',
		'maxTime' => '23:00:00',
		'slotDuration'=> '00:15:00',
		'eventOverlap' => new JsExpression("function(stillEvent, movingEvent) {
			return stillEvent.allDay && movingEvent.allDay;
		}	
		"),
		'select' => new JsExpression("
		function(start, end){//16 a 22
			var url = window.location.href.indexOf('&id=')+4;
			var box = window.location.href.substring(url);
			var dia = start.toString().substring(4,15);
			var date = new Date(start);
			var horaInicio = start.toString().substring(16,21);
			var horaFin = end.toString().substring(16,21);
			$.get('index.php?r=event/create',{'day':dia,'start_time':horaInicio,'end_time':horaFin, 'box':box},function(data){
				
					$('#modal').modal('show')
					.find('#modalContent')
					.html(data);
			});
			//get the click of the create button
			$('#modalButton').click(function(){
				$('#modal').modal('show')
				.find('#modalContent')
				.load($(this).attr('value'));
			});
		}
		"),
		
		'eventClick' => new JsExpression("
		function(calEvent, jsEvent, view) {
			//alert('Event: ' + calEvent.title);
			//alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
			//alert('View: ' + view.name);
			
			$.get('index.php?r=event/update',{'id':calEvent.id},function(data){
				
					$('#modal').modal('show')
					.find('#modalContent')
					.html(data);
			});
			$('#modalButton').click(function(){
				$('#modal').modal('show')
				.find('#modalContent')
				.load($(this).attr('value'));
			});
		}
		
		"),
    ],
	
  ));
  ?>


