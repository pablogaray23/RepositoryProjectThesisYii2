<?php


use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use backend\models\EspGen;
use yii\bootstrap\Modal;
use kartik\widgets\Alert;
use yii\helpers\ArrayHelper;
use backend\models\Profesion;
use kartik\widgets\Select2;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\PrMedSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Mantenedor de Profesionales Médicos';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php @session_start();

if (isset($_SESSION['profesionalCreado'])){
   echo Alert::widget([
   'type' => Alert::TYPE_INFO,
    'title' => 'CREACIÓN DE PROFESIONAL MÉDICO EXITOSA!',
    'icon' => 'glyphicon glyphicon-info-sign',
    'body' => 'Profesional '.$_SESSION['profesionalCreado']->nombre.' '.$_SESSION['profesionalCreado']->apellidoPaterno.' agregado correctamente',
	
	'showSeparator' => true,
    'delay' => 4000
]);
unset($_SESSION['profesionalCreado']);
} elseif (isset($_SESSION['profesionalNoCreado'])) {
    echo Alert::widget([
   'type' => Alert::TYPE_DANGER,
    'title' => 'CREACIÓN PROFESIONAL MÉDICO FALLIDA!',
    'icon' => 'glyphicon glyphicon-info-sign',
    'body' => 'Profesional de R.U.T. '.$_SESSION['profesionalNoCreado'].' ya se encuentra registrado.',
	
	'showSeparator' => true,
    'delay' => 4000
]);
	unset($_SESSION['profesionalNoCreado']);
} elseif (isset($_SESSION['profesionalActualizado'])) {
    echo Alert::widget([
  'type' => Alert::TYPE_SUCCESS,
    'title' => 'ACTUALIZACIÓN PROFESIONAL MÉDICO EXITOSA!',
    'icon' => 'glyphicon glyphicon-info-sign',
	
    
	'body' => 'Profesional de R.U.T. '.$_SESSION['profesionalActualizado']->rut.' y Nombre '.$_SESSION['profesionalActualizado']->nombre.' '.$_SESSION['profesionalActualizado']->apellidoPaterno.' actualizado correctamente.'.Html::button('Ver detalle ... ', ['value'=>Url::to('index.php?r=pr-med/view&id='.$_SESSION['profesionalActualizado']->rut),'class' => 'btn-link ajax_button']).' ',
	
	'showSeparator' => true,
    'delay' => 4000
]);
	unset($_SESSION['profesionalActualizado']);
} elseif (isset($_SESSION['especialidadCreado'])) {
    echo Alert::widget([
  'type' => Alert::TYPE_SUCCESS,
    'title' => 'Especialidad creada exitosa!',
    'icon' => 'glyphicon glyphicon-info-sign',
	
    
	'body' => 'Profesional de R.U.T. '.$_SESSION['especialidadCreado']->rut.' especialidad agregada correctamente correctamente.'.Html::button('Ver detalle ... ', ['value'=>Url::to('index.php?r=pr-esp/create&id='.$_SESSION['especialidadCreado']->rut),'class' => 'btn-link ajax_button']).' ',
	
	'showSeparator' => true,
    'delay' => 4000
]);
	unset($_SESSION['especialidadCreado']);
} elseif (isset($_SESSION['especialidadNoCreado'])) {
    echo Alert::widget([
  'type' => Alert::TYPE_DANGER,
    'title' => 'Especialidad no creada!',
    'icon' => 'glyphicon glyphicon-info-sign',
	
    
	'body' => 'Profesional de R.U.T. '.$_SESSION['especialidadNoCreado']->rut.' ya posee dicha especialidad.',
	
	'showSeparator' => true,
    'delay' => 4000
]);
	unset($_SESSION['especialidadNoCreado']);
} elseif (isset($_SESSION['archivoCreado'])) {
    echo Alert::widget([
  'type' => Alert::TYPE_SUCCESS,
    'title' => 'Antecedente Médico Agregado!',
    'icon' => 'glyphicon glyphicon-info-sign',
	
    
	'body' => 'Profesional de R.U.T. '.$_SESSION['archivoCreado']->rut_med.' antecedente agregado con éxito.'.Html::button('Ver archivos ... ', ['value'=>Url::to('index.php?r=pr-antecedente/create&id='.$_SESSION['archivoCreado']->rut_med),'class' => 'btn-link ajax_button']).' ',
	
	'showSeparator' => true,
    'delay' => 4000
]);
} elseif (isset($_SESSION['deletePrEsp'])){
	echo Alert::widget([
  'type' => Alert::TYPE_SUCCESS,
    'title' => 'ESPECIALIDAD BORRA HIJO DE PUTA!',
    'icon' => 'glyphicon glyphicon-info-sign',
	'body' => 'pero que hijo de perra',
	'showSeparator' => true,
    'delay' => 4000
]);
unset($_SESSION['deletePrEsp']);
}else{
	
}

@session_destroy();
?>
<div class="pr-med-index">

   
     <h1><center><font color="blue"><?= Html::encode($this->title) ?> &nbsp;&nbsp;<i class="fa fa-user-md"></i> </font></center></h1>
    

    <p align="center">
         <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
		 <?= Html::button('<i class="glyphicon glyphicon-plus"></i> Nuevo Profesional Medico', ['value'=>Url::to('index.php?r=pr-med/create'),'class' => 'btn btn-primary ajax_button']) ?>
    </p>
	
	<?php
		Modal::begin([
			'options' => [
				'id' => 'modal',
				'tabindex' => false // important for Select2 to work properly
			],
			'header'=>'<h4>Datos Profesional</h4>',
			//'id'=>'modal',
			'size'=>'modal-lg',
		]);
		echo "<div id='modalContent'></div>";
		Modal::end();
	?>
	
 <?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
	
		'beforeHeader'=>[
			[
				'columns'=>[
					['content'=>' Especialidad ', 'options'=>['colspan'=>2, 'class'=>'text-center warning']], 
					['content'=>' Nombre Médico ', 'options'=>['colspan'=>3, 'class'=>'text-center warning']], 
					['content'=>' Correo', 'options'=>['colspan'=>1, 'class'=>'text-center warning']], 
					['content'=>' Ver ', 'options'=>['colspan'=>1, 'class'=>'text-center warning']], 
					['content'=>' Horario ', 'options'=>['colspan'=>1, 'class'=>'text-center warning']], 
				],
            'options'=>['class'=>'skip-export'] // remove this row from export
			]
		],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			
			[
				'attribute'=>'profespecialidad', 
				'label' => 'Especialidad',
				'width'=>'150px',
				'value'=> 'profespecialidad.especialidad.nombreEspecialidad',
				
				'filterType'=>GridView::FILTER_SELECT2,
				'filter'=>ArrayHelper::map(EspGen::find()->orderBy('nombreEspecialidad')->asArray()->all(), 'codigoEspecialidad', 'nombreEspecialidad'), 
				'filterWidgetOptions'=>[
					'pluginOptions'=>['allowClear'=>true],
				],
				'filterInputOptions'=>['placeholder'=>'Escoja especialidad...'],
				'format'=>'raw',
			],
            'rut',
            'nombre',
			[
				'attribute'=>'apellidoPaterno', 
				'label' => 'Apellido Paterno',
				'width'=>'100px',
				'value'=>function ($model, $key, $index, $widget) { 
					return $model->apellidoPaterno;
				},
			],
            'email:email',
            ['class' => 'yii\grid\ActionColumn',
				'template' => '{view}',
				'buttons' => [
					'view' => function ($url, $model) {
						$t = 'index.php?r=pr-med/view&id='.$url;
						return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', Url::to($url, true), ['class' => 'btn-link']);
					},	
				],
			],
			['class' => 'yii\grid\ActionColumn',
				'template' => '{calendario}',
				'buttons' => [
					'calendario' => function ($url, $model) {
						$t = 'index.php?r=pr-med/calendario&id='.$url;
						return Html::a('<span class="glyphicon glyphicon-calendar"></span>', Url::to($url, true), ['class' => 'btn-link']);
					},	
				],
			],
        ],
		
			'panel' => [
        'heading'=>'<h3 class="panel-title"><i class="fa fa-user-md"></i> Profesionales Médicos </h3>',
        'type'=>'success',
      //  'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Create Country', ['create'], ['class' => 'btn btn-success']),
		//'before'=>Html::button('<i class="glyphicon glyphicon-plus"></i> Nuevo Profesional Medico', ['value'=>Url::to('index.php?r=pr-med/create'),'class' => 'btn btn-success ajax_button']),
       // 'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Nuevo Profesional Medico', ['create'], ['class' => 'btn btn-info']),
        'before'=>Html::a('<i class="glyphicon glyphicon-refresh"></i> Actualizar Datos', ['index'], ['class' => 'btn btn-info']),
		//'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset Grid', ['index'], ['class' => 'btn btn-info']),
        'footer'=>true
    ],
		'pjax'=>true,
		
    ]); ?>
</div>