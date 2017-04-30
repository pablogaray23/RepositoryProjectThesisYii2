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
use backend\models\PrMed;
use backend\models\BoxGeneral;

/* @var $this yii\web\View */
/* @var $model app\models\BoxGeneral */

$medico = PrMed::find()->where(['rut'=>$_GET['id']])->one();
//$this->title = $model->nombre_box .', Sector '.$model->id_sector;
$this->title = 'Horario de '.$medico->nombre.' '.$medico->apellidoPaterno.' '.$medico->apellidoMaterno;
if (Yii::$app->user->can('Funcionario')){
	$this->params['breadcrumbs'][] = ['label' => 'Box Horarios', 'url' => ['index']];
	$this->params['breadcrumbs'][] = $this->title;
}
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
<div id='calendar' class="box-general-horario calendar"><center><h1><?= Html::encode($this->title) ?></h1></center></div>
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
	$hoy = date('Y-m-d');
	$lunes;
	$sabado;
	
	$eventos = Event::find()->where(['rut_profesional'=>$_GET['id']])->all();
	foreach($eventos as $evento){
		//$contador=4;
		//while($contador>0){
			$Event = new \yii2fullcalendar\models\Event();
			$Event->id = $evento->id_event;
			$Event->title = BoxGeneral::find()->where(['id_box'=>$evento->id_box])->one()->nombre_box;
			if (($evento->estado)=='Bloqueado'){
				$Event->color = '#cc0000';
			} else if (($evento->date<date('Y-m-d'))){
				$Event->color = '#00cc00';
			}
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
		'center'=>'title',
		'left'=>'prev,today,next',        
        'right'=>'agendaWeek,agendaDay,month',
	],
	'clientOptions' => [
		'allDaySlot' => false,
		'height' => 700,
		'lang' => 'es',
		'titleFormat' => ('MMMM D YYYY'),
		'slotLabelFormat' => 'h:mmt',
		'columnFormat' => 'dddd D/M',
		'scrollTime' => '00:30:00',
        'weekends' => true,
		'hiddenDays'=>[0],
        'defaultView' => 'agendaDay',
		'selectable'=>false,
		'selectableHelper' => true,
		'droppable' => false,
		'editable' => true,
		'defaultDate' => date('Y-m-d'),
		'minTime'=> '08:00:00',
		'maxTime' => '23:00:00',
		'slotDuration'=> '00:30:00',
		'eventOverlap' => new JsExpression("function(stillEvent, movingEvent) {
			return stillEvent.allDay && movingEvent.allDay;
		}	
		"),
		
		'eventClick' => new JsExpression("
		function(calEvent, jsEvent, view) {
			alert(calEvent.title);
			//alert('Inicio: ' + calEvent.start + ', Fin' + calEvent.end);
			//alert('View: ' + view.name);
		}
		
		"),
    ],
	
  ));
  ?>


