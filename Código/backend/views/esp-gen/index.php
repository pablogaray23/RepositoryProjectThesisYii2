<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use kartik\widgets\Alert;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\EspGenSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mantenedor de Especialidades';
$this->params['breadcrumbs'][] = $this->title;
?>


<?php @session_start();

if (isset($_SESSION['especialidadCreado'])){
	echo Alert::widget([
		'type' => Alert::TYPE_INFO,
		'title' => 'CREACIÓN DE LA ESPECIALIDAD EXITOSA!',
		'icon' => 'glyphicon glyphicon-info-sign',
		'body' => 'Especialidad '.$_SESSION['especialidadCreado']->nombreEspecialidad.' agregada correctamente.',		
		'showSeparator' => true,
		'delay' => 4000
	]);
	unset($_SESSION['especialidadCreado']);
	
} elseif (isset($_SESSION['especialidadNoCreado'])) {
    echo Alert::widget([
	   'type' => Alert::TYPE_DANGER,
		'title' => 'CREACIÓN DE LA ESPECIALIDAD FALLIDA!',
		'icon' => 'glyphicon glyphicon-info-sign',
		'body' => 'Especialidad '.$_SESSION['especialidadNoCreado'].' ya se encuentra registrada.',
		
		'showSeparator' => true,
		'delay' => 4000
	]);
	unset($_SESSION['especialidadNoCreado']);
}elseif (isset($_SESSION['especialidadActualizado'])) {
    echo Alert::widget([
		'type' => Alert::TYPE_SUCCESS,
		'title' => 'ACTUALIZACIÓN DE LA ESPECIALIDAD EXITOSA!',
		'icon' => 'glyphicon glyphicon-info-sign',
		
		
		'body' => 'Especialidad '.$_SESSION['especialidadActualizado']->nombreEspecialidad.' actualizada correctamente.'.Html::button('Ver detalle ... ', ['value'=>Url::to('index.php?r=esp-gen/view&id='.$_SESSION['especialidadActualizado']->codigoEspecialidad),'class' => 'btn-link ajax_button']).' ',
		
		'showSeparator' => true,
		'delay' => 4000
	]);
	unset($_SESSION['especialidadActualizado']);
}

@session_destroy();
?>

<div class="esp-gen-index">

    <h1><center><font color="blue"><?= Html::encode($this->title) ?> &nbsp;&nbsp;<i class="glyphicon glyphicon-education"></i> </font></center></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
	
		
	<?php
		Modal::begin([
			'header'=>'<h4>Atenciones</h4>',
			'id'=>'modal',
			'size'=>'modal-sm',
		]);
		echo "<div id='modalContent'></div>";
		Modal::end();
	?>

    <p align="center">
       <?= Html::button('<i class="glyphicon glyphicon-plus"></i> Crear Nueva Especialidad', ['value'=>Url::to('index.php?r=esp-gen/create'),'class' => 'btn btn-primary ajax_button']) ?>
    </p>
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
			['class' => 'yii\grid\SerialColumn'],

			//  'codigoEspecialidad',
			//  'nombreEspecialidad',
			[
				'class' => 'kartik\grid\EditableColumn',
				'header' => 'Nombre Especialidad',
				'attribute' => 'nombreEspecialidad',
				//	'filterType'=>GridView::FILTER_SELECT2,
				//	'format'=>'FORMAT_BUTTON',
				'value' => function($model){
					return Html::a($model->nombreEspecialidad,  
					'#', 
					['title'=>'Haga click para editar el nombre']);	
					},
				'filterWidgetOptions'=>[
					'pluginOptions'=>['allowClear'=>true],
				],
				'filterInputOptions'=>['placeholder'=>'Escriba la especialidad que desea BUSCAR y presione Enter ...', 'class'       => 'form-control',],
				'format'=>'raw',
				'editableOptions'=>[
				'header'=>' Nombre Especialidad', 
					'size'=>'md',
				],
			],
		
			['class' => 'yii\grid\ActionColumn',
				'template' => '{especialidades} {delete}',
				'buttons' => [
					'especialidades' => function ($url, $model) {
						$t = 'index.php?r=esp-atn/create&esp='.$model->codigoEspecialidad;
						return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value'=>Url::to($t),'class' => 'btn-link ajax_button','title' => Yii::t('app', 'Atenciones asignadas'),]);
						},
				],
			],
        ],
		'panel' => [
			'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-education"></i> Especialidades </h3>',
			'type'=>'success',
			//  'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Create Country', ['create'], ['class' => 'btn btn-success']),
			'before'=> Html::a('<i class="glyphicon glyphicon-repeat"></i> Refrescar Tabla', ['index'], ['class' => 'btn btn-info']).'<em> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;* Para editar la información de alguna especialidad, haga click sobre el "nombre de la especialidad" </em>' ,
			// 'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset Grid', ['index'], ['class' => 'btn btn-info']),
			'footer'=>true
		],
		'pjax'=>true,
		'exportConfig' => [
			GridView::PDF => [
				'label' => 'PDF',
				'icon' => 'floppy-disk',
				'iconOptions' => ['class' => 'text-danger'],
				'showHeader' => true,
				'showPageSummary' => true,
				'showFooter' => true,
				'showCaption' => true,
				'filename' => 'especialidades',
				'alertMsg' =>  'El archivo PDF esta siendo cargado para ser generado. Es recomendable habilitar mensaje de "Ventana Emergente"',
				'options' => ['title' => 'Portable Document Format'],
				'mime' => 'application/pdf',
				'config' => [
					'mode' => 'c',
					'format' => 'A4-L',
					'destination' => 'D',
					'marginTop' => 20,
					'marginBottom' => 20,
					'cssInline' => '.kv-wrap{padding:20px;}' .
					'.kv-align-center{text-align:center;}' .
					'.kv-align-left{text-align:left;}' .
					'.kv-align-right{text-align:right;}' .
					'.kv-align-top{vertical-align:top!important;}' .
					'.kv-align-bottom{vertical-align:bottom!important;}' .
					'.kv-align-middle{vertical-align:middle!important;}' .
					'.kv-page-summary{border-top:4px double #ddd;font-weight: bold;}' .
					'.kv-table-footer{border-top:4px double #ddd;font-weight: bold;}' .
					'.kv-table-caption{font-size:1.5em;padding:8px;border:1px solid #ddd;border-bottom:none;}',
					'methods' => [
						'SetFooter' => [
							['odd' => 'especialidades', 'even' => 'especialidades']
						],
					],			  
					'options' => [
						'title' => '', 
							'subject' => 'PDF export generated by kartik-v/yii2-grid extension',
							'keywords' => 'krajee, grid, export, yii2-grid, pdf'
					],
					'contentBefore'=>' Especialidades',
					'contentAfter'=>'Especialidades'
				]
			],
		]
	]); ?>
</div>
