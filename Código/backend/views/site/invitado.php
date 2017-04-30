<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

use backend\models\PrMed;
use backend\models\EspGen;

use kartik\grid\GridView;


$this->title = 'Sistema Gestión Horario Box';
?>
<div class="site-index">
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
	
		'beforeHeader'=>[
			[
				'columns'=>[
					['content'=>' Especialidad ', 'options'=>['colspan'=>2, 'class'=>'text-center warning']], 
					['content'=>' Nombre Médico ', 'options'=>['colspan'=>3, 'class'=>'text-center warning']], 
					['content'=>' Correo', 'options'=>['colspan'=>1, 'class'=>'text-center warning']], 
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
