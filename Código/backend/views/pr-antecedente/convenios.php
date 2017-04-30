<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\form\ActiveField;
use yii\db\Query;
use backend\models\BoxGeneral;

use yii\data\ActiveDataProvider;

use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use backend\models\Event;
use yii\bootstrap\Modal;
use kartik\widgets\SideNav;
use kartik\widgets\Alert;
use backend\models\PrMed;
use backend\models\EspGen;
use backend\models\PrEsp;
use kartik\date\DatePicker;

$unBox = PrMed::findOne( $rut_med);
//$id_piso = $unBox->id_piso;
$elRut = $unBox->rut;
$nombreDelMedico = $unBox->nombre;
$apellidoPDelMedico = $unBox->apellidoPaterno;

$unaProfEsp = PrEsp::find()->where([ 'rut' => $rut_med])->asArray()->one();

//var_dump($unaProfEsp);

$username = \yii\helpers\ArrayHelper::getValue($unaProfEsp, 'codigoEspecialidad');

//$unCodigo = $unaProfEsp->codigoEspecialidad;

var_dump($username);

$unaEspecialidad = EspGen::findOne( $username);

$unNombreEsp = $unaEspecialidad->nombreEspecialidad;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\PrAntecedenteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'R.U.T. Prof Médico'. $rut_med;
$this->params['breadcrumbs'][] = ['label' => 'Profesionales Médicos', 'url' => ['/pr-med/index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<style>
table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    text-align: left;
    padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}

th {
    background-color: #4CAF50;
    color: white;
}
</style>

<div class="pr-antecedente-index">




<div  class="body-content">
 <div class="row">

    <h1><center><font color="blue"> Portafolio Profesional Médico Dr(a).  <?= Html::encode($nombreDelMedico) ?>   <?= Html::encode($apellidoPDelMedico) ?> </font></center></h1>
	<h1><center><font color="blue"> Especialidad Principal.  <?= Html::encode($unNombreEsp) ?>    </font></center></h1>
	
	
	
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
	

	?>
	
		<?php
		Modal::begin([
			//'header'=>'<h4>Nuevo Antecedente</h4>',
			'id'=>'modal',
			'size'=>'modal-lg',
		]);
		echo "<div id='modalContent'></div>";
		Modal::end();
	?>
	
	
	<div class="col-md-8 col-md-offset-2">
	
	
		<?php
	
	$type = '<p class="text-justify">' .
    'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.' . 
    '</p>';
	
	$item = [
    [
        'label'=>'<i class="glyphicon glyphicon-home"></i> Home',
        'content'=>$type,
        'active'=>true
    ],
   
 
];
	
	echo SideNav::widget([
    'type' => $type,
    'encodeLabels' => false,
     'heading' => 'Menú Profesional Médico',
    'items' => [
        // Important: you need to specify url as 'controller/action',
        // not just as 'controller' even if default action is used.
        ['label' => 'Perfil', 'icon' => 'user', 'url' => ['/pr-med/view','id'=>$rut_med]],
	//	['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii']],
	//['label' => ' Médicos ', 'icon' => 'fa fa-user-md', 'url' => ['pr-med/index'],],
        /*['label' => 'Books', 'icon' => 'book', 'items' => [
            ['label' => '<span class="pull-right badge">10</span> New Arrivals', 'url' => Url::to(['/site/new-arrivals', 'type'=>$type]), 'active' => ($item == 'new-arrivals')],
            ['label' => '<span class="pull-right badge">5</span> Most Popular', 'url' => Url::to(['/site/most-popular', 'type'=>$type]), 'active' => ($item == 'most-popular')],
            ['label' => 'Read Online', 'icon' => 'cloud', 'items' => [
                ['label' => 'Online 1', 'url' => Url::to(['/site/online-1', 'type'=>$type]), 'active' => ($item == 'online-1')],
                ['label' => 'Online 2', 'url' => Url::to(['/site/online-2', 'type'=>$type]), 'active' => ($item == 'online-2')]
            ]],
        ]],
        ['label' => '<span class="pull-right badge">3</span> Categories', 'icon' => 'tags', 'items' => [
            ['label' => 'Fiction', 'url' => Url::to(['/site/fiction', 'type'=>$type]), 'active' => ($item == 'fiction')],
            ['label' => 'Historical', 'url' => Url::to(['/site/historical', 'type'=>$type]), 'active' => ($item == 'historical')],
            ['label' => '<span class="pull-right badge">2</span> Announcements', 'icon' => 'bullhorn', 'items' => [
                ['label' => 'Event 1', 'url' => Url::to(['/site/event-1', 'type'=>$type]), 'active' => ($item == 'event-1')],
                ['label' => 'Event 2', 'url' => Url::to(['/site/event-2', 'type'=>$type]), 'active' => ($item == 'event-2')]
            ]],
        ]],*/
		
		['label' => 'Antecedentes Médicos', 'icon' => 'glyphicon glyphicon-folder-open', 'url' => ['/pr-antecedente/index','rut_med'=>$rut_med]],
		['label' => 'Convenios Médicos', 'icon' => 'tags', 'url' => ['/pr-antecedente/convenios','rut_med'=>$rut_med]],
		['label' => 'Bloque de Horarios', 'icon' => 'glyphicon glyphicon-th', 'url' => ['/pr-hor/index','rut_med'=>$rut_med]],
		
      //  ['label' => 'Profile', 'icon' => 'user', 'url' => Url::to(['/site/profile', 'type'=>$type]), 'active' => ($item == 'profile')],
    ],
]);  
	
	?>
	
	
	
	
	
	
	<?php @session_start();

if (isset($_SESSION['archivoCreado'])) {
    echo Alert::widget([
  'type' => Alert::TYPE_INFO,
    'title' => 'ANTECEDENTE MÉDICO AGREGADO CORRECTAMENTE!',
    'icon' => 'glyphicon glyphicon-info-sign',
	
    
	'body' => 'Profesional Médico posee nuevo "'.$_SESSION['archivoCreado']->tipoAntecedente.'" de nombre "'.$_SESSION['archivoCreado']->nombreArchivo.'" en sus registros.',
	
	'showSeparator' => true,
    'delay' => 4000
]);
	unset($_SESSION['archivoCreado']);

} elseif (isset($_SESSION['deleteAntecedentes'])){
	echo Alert::widget([
  'type' => Alert::TYPE_INFO,
    'title' => 'ANTECEDENTE MÉDICO ELIMINADO CORRECTAMENTE!',
    'icon' => 'glyphicon glyphicon-info-sign',
	'body' => 'Se ha eliminado el antecedente "'.$_SESSION['deleteAntecedentes']->nombreArchivo.'" de su registros correctamente.',
	'showSeparator' => true,
    'delay' => 4000
]);
unset($_SESSION['deleteAntecedentes']);
}elseif (isset($_SESSION['deleteConvenio'])){
	echo Alert::widget([
  'type' => Alert::TYPE_INFO,
    'title' => 'CONVENIO MÉDICO ELIMINADO CORRECTAMENTE!',
    'icon' => 'glyphicon glyphicon-info-sign',
	'body' => 'Se ha eliminado el convenio "'.$_SESSION['deleteConvenio']->nombreArchivo.'" de su registros correctamente.',
	'showSeparator' => true,
    'delay' => 4000
]);
unset($_SESSION['deleteConvenio']);
}else{
	
}

@session_destroy();
?>
	
	
	<h3><center><font color="blue"><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Convenios Médicos &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u> </font></center></h3>
	
	
	
	


	
	<?php
	$fecha = date('d-m-Y');
	
	//$date = date ('2016-10-17');

	//echo $date."</br>";

	$nbDay = date('N', strtotime($fecha));
	$monday = new \DateTime($fecha);

	//echo $monday;

	$sunday = new \DateTime($fecha);
	$elLunes = $monday->modify('-'.($nbDay-1).' days')->format('Y-m-d');

	//echo "</br>";

	$elDomingo = $sunday->modify('+'.(7-$nbDay).' days')->format('Y-m-d');
	
	//$query = Event::find()->where(['between','date',$elLunes,$elDomingo])->andWhere(['rut_profesional'=>$rut_med])->all();
	//$query = EspGen::find()->all();
	
	$Eventos =Event::find()->where(['between','date',$elLunes,$elDomingo])->andWhere(['rut_profesional'=>$rut_med])->all();
	
	$query = (new Query())->from('event')->where(['between','date',$elLunes,$elDomingo])->andWhere(['rut_profesional' => $rut_med]); 
	
	$minutosTotales = 0;
	setlocale(LC_ALL, 'es-ES');
	

$provider = new ActiveDataProvider([
    'query' => $query,
	
	
	
    'pagination' => [
        'pageSize' => 10,
    ],
   
]);
	
	?>
	<h3 > <center> Horario correspondiente a la semana <?php echo $elLunes; ?> al <?php echo $elDomingo; ?> </center></h3>
	
	        <table class="pure-table" style="margin:auto; width:100%;">
			
			<tr>
			<th>Número Box</th>
    <th> Día Semana </th>
    <th>Hora Inicio</th>
    <th>Hora Fin</th>
  </tr>
			
        
          <?php
         foreach($Eventos as $data){
			
			$columnaBox = BoxGeneral::find()->where(['id_box'=>$data->id_box])->one()->nombre_box;//con esto ya aprendi a obtener valores despues de un array desde modelDos
			//$columnaDia = \yii\helpers\ArrayHelper::getValue(date('n',strtotime($data,'date')));
			//$columnaDia = date('l',strtotime($data->date));
			$columnaDia = strftime("%A", strtotime($data->date));
			$columnaHoraInicio = \yii\helpers\ArrayHelper::getValue($data, 'start_time');
			$columnaHoraFin = \yii\helpers\ArrayHelper::getValue($data, 'end_time');
			
			$diff = ((strtotime($data->end_time))-(strtotime($data->start_time)))/60;
			$minutosTotales = $minutosTotales+$diff;
			
			
			   echo '
             <tr>
			 
			  <td>'.$columnaBox.'</td>
             
              <td>'.$columnaDia.'</td>
              <td>'.$columnaHoraInicio.'</td>
              <td>'.$columnaHoraFin.'</td>
              
             </tr>
            ';
			
		}
		
		
		
		//'footer'=>'<p > <center>'." ".." horas ".$minutosTotales." minutos".' </center></p>',
		
		$horasTotales = floor($minutosTotales/60);
		$minutosTotales = ($minutosTotales)-($horasTotales*60);
		
          ?>
		  
		   <tr>
    <td> Horas Semanales: </td>
    <td><?php echo $horasTotales?></td>
	 <td> minutos: </td>
    <td><?php echo $minutosTotales?></td>
  </tr>
		  
         </table>
	
		<p align="center">
	
	<?php
	echo Html::a('<i class="fa glyphicon glyphicon-hand-up"></i> Generar Convenio', ['report', 'rut' => $rut_med], [
    'class'=>'btn btn-danger', 
    'target'=>'_blank', 
    'data-toggle'=>'tooltip', 
    'title'=>'Will open the generated PDF file in a new window'
]);
	?>
	
	</p>
	
	
	
	
	
	
	
	 <p align="center">
        
    </p>
	
	

	<?= GridView::widget([
    'dataProvider'=> $dataProvider,
    'filterModel' => $searchModel,
	'columns' => [
          //  ['class' => 'yii\grid\SerialColumn'],

       				
		 [
            'attribute'=>'fechaSubida', 
			'value' => 'fechaSubida',
			'format'=>['date', 'd-MM-yyyy'],
			'filter' => \yii\jui\DatePicker::widget([
				'model'=>$searchModel,
				'attribute'=>'fechaSubida',
				'language' => 'es',
				'dateFormat' => 'yyyy-MM-dd',
    ]),
  //  'format' => 'html',
            
           
        ],
			//'fechaSubida:date',
			//'',
			
			  [
	            'attribute' => 'nombreArchivo',
	            'format' => 'html',
	            'value' => function($model) {
		           return Html::a($model->nombreArchivo,Yii::$app->request->baseUrl. '/convenios/' . $model->nombreArchivo, ['target' => '_blank','class' => 'profile-link']);
	            }
	        ],
			

             	    ['class' => 'yii\grid\ActionColumn',
			'template' => '{delete}',
			'buttons' => [
			
			

            'delete' => function ($url, $model) {
				//$t = 'index.php?r=profesional-antecedentes/index&id='.$url;
               // return Html::a('<span class="glyphicon glyphicon-file"></span>', $url, [ 'title' => "Antecedentes", 'class'=>'btn-link', ]);
				//return Html::a('Profile', ['pr-esp/delete', 'id' => $url], ['class' => 'profile-link']);
				return Html::a('Eliminar', ['pr-antecedente/deleteconvenio', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Estás seguro de eliminar el archivo?',
                'method' => 'post',
            ],
        ]);				
            },			
        ],
		], 
        ],
	'panel' => [
        'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-tags"></i> Convenios Médicos </h3>',
        'type'=>'success',
      //  'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Create Country', ['create'], ['class' => 'btn btn-success']),
		'before'=> Html::a('<i class="glyphicon glyphicon-repeat"></i> Actualizar ', ['/pr-antecedente/convenios','rut_med'=>$rut_med], ['class' => 'btn btn-info']).'<em> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;     * La información de los documentos no se pueden editar, pero puede eliminar el documento e ingresarlo nuevamente... </em>' ,
        'footer'=>false
    ],
	//'pjax'=>true,
]); ?>

</div>

</div>
	
	</div>

</div>
 