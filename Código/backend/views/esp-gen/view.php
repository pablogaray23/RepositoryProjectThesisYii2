<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\EspGen */

$this->title = $model->codigoEspecialidad;
$this->params['breadcrumbs'][] = ['label' => 'Esp Gens', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="esp-gen-view">

   
  <div class="body-content">
 <div class="row">
 
  <div class="col-md-8 col-md-offset-2">
   <p>&nbsp;</p>
  
  <center><h2><u><font color="blue">Información de la Especialidad</font></u></center> </h2>
  
                <p>&nbsp;</p>
				<center>
		<?= Html::img('imagenes/glyphicon-education.jpg', ['width'=>'10%','display'=>'block','margin-left'=>'auto','margin-right'=>'auto','height'=>'10%'],['alt' => 'alt image']); ?>
        
		
		 </center>
		 
		  <p>&nbsp;</p>

   
	
	
	
	
	
	  <?php
	
	$attributes = [
    [
        'group'=>true,
        'label'=>'SECCIÓN 1: Información General                                       ',
        'rowOptions'=>['class'=>'info'],
		'groupOptions'=>['class'=>'text-center']
    ],
    [
        'columns' => [
            [
                'attribute'=>'nombreEspecialidad', 
                'label'=>' Nombre Especialidad',
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:30%']
            ],
          
        ],
    ],
   
	
	 
];
	
echo	DetailView::widget([
        'model' => $model,
		 'attributes' => $attributes,
		   'panel'=>[
        'heading'=>'Especialidad Médica',
        'type'=>DetailView::TYPE_INFO,
    ],
	
 
	
    ]) ?>
	
	
	
	

</div>
	
	 </div>
	  </div>

  

</div>

