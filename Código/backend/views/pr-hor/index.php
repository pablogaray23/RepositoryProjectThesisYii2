<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use kartik\widgets\SideNav;
use kartik\widgets\Alert;
use backend\models\PrMed;
use backend\models\EspGen;
use backend\models\PrEsp;
use backend\models\PrAntecedente;
use backend\models\PrAntecedenteTipo;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PrHorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pr Hors';
$this->params['breadcrumbs'][] = $this->title;

$unBox = PrMed::findOne( $rut_med);
//$id_piso = $unBox->id_piso;
$elRut = $unBox->rut;
$nombreDelMedico = $unBox->nombre;
$apellidoPDelMedico = $unBox->apellidoPaterno;

$unaProfEsp = PrEsp::find()->where([ 'rut' => $rut_med])->asArray()->one();

//var_dump($unaProfEsp);

$username = \yii\helpers\ArrayHelper::getValue($unaProfEsp, 'codigoEspecialidad');

//$unCodigo = $unaProfEsp->codigoEspecialidad;

//var_dump($username);

$unaEspecialidad = EspGen::findOne( $username);

$unNombreEsp = $unaEspecialidad->nombreEspecialidad;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\PrAntecedenteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'R.U.T. Prof Médico '. $rut_med;
$this->params['breadcrumbs'][] = ['label' => 'Profesionales Médicos', 'url' => ['/pr-med/index']];
$this->params['breadcrumbs'][] = $this->title;

?>
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
			'size'=>'modal-sm',
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
}else{
	
}

@session_destroy();
?>
<div class="pr-hor-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
		<?= Html::button('Ingresar nuevo bloque', ['value'=>Url::to('index.php?r=pr-hor/create&rut_med='.$_GET['rut_med']),'class' => 'btn btn-primary ajax_button']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id_pr_horario',
            //'rut_profesional',
			//'dia_semana',
            [
				'attribute'=>'dia_semana',
				'label'=>'Dia',
				'value'=>function ($model, $key){
					
					if ($model->dia_semana==0) return 'Lunes';
					else if ($model->dia_semana==1) return 'Martes';
					else if ($model->dia_semana==2) return 'Miercoles';
					else if ($model->dia_semana==3) return 'Jueves';
					else if ($model->dia_semana==4) return 'Viernes';
					else if ($model->dia_semana==5) return 'Sabado';
					else return 'Domingo';
				},
			],
            'hora_inicio',
            'hora_fin',

            ['class' => 'yii\grid\ActionColumn',
			'template' => '{delete}'],
        ],
    ]); ?>
</div>
