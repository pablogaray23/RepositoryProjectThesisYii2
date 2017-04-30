<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use yii\data\SqlDataProvider;
use backend\models\PrAntecedente;
use backend\models\PrEsp;
use kartik\grid\GridView;
use backend\models\Profesion;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\widgets\SideNav;
use yii\bootstrap\Modal;
use fedemotta\datatables\DataTables;
use yii\data\ActiveDataProvider;
use kartik\widgets\Alert;


use backend\models\PrMed;
use backend\models\EspGen;

$unBox = PrMed::findOne( $model->rut);
//$id_piso = $unBox->id_piso;
$nombreDelMedico = $unBox->nombre;
$apellidoPDelMedico = $unBox->apellidoPaterno;


/* @var $this yii\web\View */
/* @var $model backend\models\PrMed */

$this->title = 'R.U.T. Prof Médico'.  $model->rut;
$this->params['breadcrumbs'][] = ['label' => 'Profesionales Médicos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<?php @session_start();

if (isset($_SESSION['especialidadCreado'])) {
    echo Alert::widget([
  'type' => Alert::TYPE_SUCCESS,
    'title' => 'Especialidad creada exitosa!',
    'icon' => 'glyphicon glyphicon-info-sign',
	
    
	'body' => ' Especialidad '.$_SESSION['especialidadCreado']->especialidad->nombreEspecialidad.' agregada correctamente correctamente.',
	
	'showSeparator' => true,
    'delay' => 4000
]);
	unset($_SESSION['especialidadCreado']);
} elseif (isset($_SESSION['especialidadNoCreado'])) {
    echo Alert::widget([
  'type' => Alert::TYPE_DANGER,
    'title' => 'Especialidad no creada!',
    'icon' => 'glyphicon glyphicon-info-sign',
	
    
	'body' => 'Profesional ya posee '.$_SESSION['especialidadNoCreado']->especialidad->nombreEspecialidad.' como especialidad.',
	
	'showSeparator' => true,
    'delay' => 4000
]);
	unset($_SESSION['especialidadNoCreado']);
} elseif (isset($_SESSION['especialidadActualizada'])) {
    echo Alert::widget([
  'type' => Alert::TYPE_WARNING,
    'title' => 'Especialidad actualizada correctamente!',
    'icon' => 'glyphicon glyphicon-info-sign',
	
    
	'body' => 'La especialidad '.$_SESSION['especialidadActualizada']->especialidad->nombreEspecialidad.' ha sido actualizada correctamente.',
	
	'showSeparator' => true,
    'delay' => 4000
]);
	unset($_SESSION['especialidadNoCreado']);
} elseif (isset($_SESSION['archivoCreado'])) {
    echo Alert::widget([
  'type' => Alert::TYPE_INFO,
    'title' => 'ANTECEDENTE MÉDICO AGREGADO CORRECTAMENTE!',
    'icon' => 'glyphicon glyphicon-info-sign',
	
    
	'body' => 'Profesional Médico posee nuevo "'.$_SESSION['archivoCreado']->tipoAntecedente.'" de nombre "'.$_SESSION['archivoCreado']->nombreArchivo.'" en sus registros.',
	
	'showSeparator' => true,
    'delay' => 4000
]);
	unset($_SESSION['archivoCreado']);

} elseif (isset($_SESSION['deletePrEsp'])){
	echo Alert::widget([
  'type' => Alert::TYPE_INFO,
    'title' => 'ESPECIALIDAD ELIMINADA CORRECTAMENTE!',
    'icon' => 'glyphicon glyphicon-info-sign',
	'body' => 'Se ha eliminado la especialidad'.$_SESSION['deletePrEsp']->especialidad->nombreEspecialidad.' de su registros.',
	'showSeparator' => true,
    'delay' => 4000
]);
unset($_SESSION['deletePrEsp']);
}elseif (isset($_SESSION['deleteAntecedentes'])){
	echo Alert::widget([
  'type' => Alert::TYPE_INFO,
    'title' => 'ANTECEDENTE MÉDICO ELIMINADO CORRECTAMENTE!',
    'icon' => 'glyphicon glyphicon-info-sign',
	'body' => 'Se ha eliminado el antecedente "'.$_SESSION['deleteAntecedentes']->nombreArchivo.'" de su registros correctamente.',
	'showSeparator' => true,
    'delay' => 4000
]);
unset($_SESSION['deleteAntecedentes']);
}else{
	
}

@session_destroy();
?>

<div class="pr-med-view">

 <div  class="body-content">
 <div class="row">
  

    <h1><center><font color="blue"> Portafolio Profesional Médico Dr(a).  <?= Html::encode($nombreDelMedico) ?>   <?= Html::encode($apellidoPDelMedico) ?> </font></center></h1>
	<h1><center><font color="blue"> Especialidad Principal.  <?= Html::encode($model->profespecialidad->especialidad->nombreEspecialidad) ?>    </font></center></h1>
	
		<?php
		Modal::begin([
			'options' => [
				'id' => 'modal',
				'tabindex' => false // important for Select2 to work properly
			],
			'header'=>'<h4>Datos Especialidad</h4>',
			//'id'=>'modal',
			'size'=>'modal-sm',
		]);
		echo "<div id='modalContent'></div>";
		Modal::end();
	?>

    <p align="center">
        <?= Html::a('Actualizar', ['update', 'id' => $model->rut], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Bloquear', ['delete', 'id' => $model->rut], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
	
	
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
        ['label' => 'Perfil', 'icon' => 'user', 'url' => ['/pr-med/view','id'=>$model->rut]],
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
		
		['label' => 'Antecedentes Médicos', 'icon' => 'glyphicon glyphicon-folder-open', 'url' => ['/pr-antecedente/index','rut_med'=>$model->rut]],
		['label' => 'Convenios Médicos', 'icon' => 'tags', 'url' => ['/pr-antecedente/convenios','rut_med'=>$model->rut]],
		['label' => 'Bloque de Horarios', 'icon' => 'glyphicon glyphicon-th', 'url' => ['/pr-hor/index','rut_med'=>$model->rut]],
		
      //  ['label' => 'Profile', 'icon' => 'user', 'url' => Url::to(['/site/profile', 'type'=>$type]), 'active' => ($item == 'profile')],
    ],
]);  
	
	?>
	
	
	
	
	
	<h3><center><font color="blue"> <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Datos Personales &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u> </font></center></h3>

    <?php
	
	$attributes = [
    [
        'group'=>true,
        'label'=>'SECCIÓN 1: Información Personal                                        ',
        'rowOptions'=>['class'=>'info'],
		'groupOptions'=>['class'=>'text-center']
    ],
    [
        'columns' => [
            [
                'attribute'=>'rut', 
                'label'=>'R.U.T.',
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:30%']
            ],
          [
                'attribute'=>'apellidoPaterno',
				'label'=>'Apellido Paterno',
                'valueColOptions'=>['style'=>'width:30%'],
            ],
        ],
    ],
    [
        'columns' => [
            [
                'attribute'=>'nombre',
				'label'=>'Nombre Profesional',
                'valueColOptions'=>['style'=>'width:30%'],
            ],
           [
                'attribute'=>'apellidoMaterno',
				'label'=>'Apellido Materno',
                'valueColOptions'=>['style'=>'width:30%'],
            ],
        ],
    ],
	  [
        'columns' => [
            [
                'attribute'=>'direccion',
				'label'=>'Dirección',
                'valueColOptions'=>['style'=>'width:30%'],
				
            ],
           [
                'attribute'=>'telefono',
				'label'=>'Teléfono',
                'valueColOptions'=>['style'=>'width:30%'],
				'visible' => true,
            ],
        ],
    ],
	 [
                'attribute'=>'email',
				'label'=>'E - Mail',
                'valueColOptions'=>['style'=>'width:30%'],
				'visible' => true,
				'class'=>'text-right'
            ],
   

	  [
        'group'=>true,
        'label'=>'SECCIÓN 2: Especialidades',
        'rowOptions'=>['class'=>'info'],
        'groupOptions'=>['class'=>'text-center']
    ],
  
   
  


  
];
	
echo	DetailView::widget([
        'model' => $model,
		 'attributes' => $attributes,
		   'panel'=>[
        'heading'=>'Profesional Médico ' . $model->rut,
        'type'=>DetailView::TYPE_INFO,
    ],
		 /*
		        'attributes' => [
            'rut',
            'nombre',
            'apellidoPaterno',
            'apellidoMaterno',
            'email:email',
            'telefono',
            'direccion',
            'id_profesion',
            'institucion_est',
            'anio',
        ],
		 */
 
	
    ]) ?>
	
	
	
		<?php
		$dataProviderDos = new ActiveDataProvider([
    'query' => PrEsp::find()->where(['rut'=> $model->rut]),
]);
	?>
	
		<?= GridView::widget([
        'dataProvider' => $dataProviderDos,
		'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'codigoEspecialidad',
			
				  [
            'attribute'=>'codigoEspecialidad', 
			'label' => 'Especialidad',
            'width'=>'150px',
            'value'=>function ($model, $key, $index, $widget) { 
                return $model->especialidad->nombreEspecialidad;
            },
          //  'group'=>true,  // enable grouping
        ],
		
				  [
            'attribute'=>'institucion', 
			'label' => 'Institución de Educación',
            'width'=>'350px',
            'value'=>function ($model, $key, $index, $widget) { 
                return $model->institucion;
            },
        //    'group'=>true,  // enable grouping
        ],
			
		//	'institucion',
			'anio',

                	    ['class' => 'yii\grid\ActionColumn',
			'template' => '{update}{delete}',
			'buttons' => [
			
			'update' => function ($url, $model) {
				$t = 'index.php?r=pr-esp/update&id='.$model->id_pr_esp;
                return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value'=>Url::to($t),'class' => 'btn-link ajax_button']);
            },
			
			

            'delete' => function ($url, $model) {
				//$t = 'index.php?r=profesional-antecedentes/index&id='.$url;
               // return Html::a('<span class="glyphicon glyphicon-file"></span>', $url, [ 'title' => "Antecedentes", 'class'=>'btn-link', ]);
				//return Html::a('Profile', ['pr-esp/delete', 'id' => $url], ['class' => 'profile-link']);
				return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['pr-esp/delete', 'id' => $model->id_pr_esp], [
            'class' => 'btn-link',
            'data' => [
                'confirm' => '¿Estás seguro de eliminar la especialidad?',
                'method' => 'post',
            ],
        ]);				
            },			
        ],
		], 
        ],
			'panel' => [
        'heading'=>false,
        'type'=>'success',
        'before'=>Html::button('Agregar una especialidad', ['value'=>Url::to('index.php?r=pr-esp/create&id='.$_GET['id']),'class' => 'btn btn-primary ajax_button']),
        'footer'=>false
    ],
    ]); ?>
	
	
	</div>
	</div>
	
	</div>
	

</div>
