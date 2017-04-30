<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\BoxAtencion;
use backend\models\BoxAtencionSearch;
use yii\data\SqlDataProvider;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\BoxGeneral */

$emmm = $model->id_box;
echo $emmm;

$nombresector= $model->sector->nombre_sector;
echo $nombresector;

$this->params['breadcrumbs'][] = ['label' => 'Box Generals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box-general-view">

  
	<div class="body-content">
 <div class="row">
        
 <div class="col-md-6">
 
  <h2>Información General </h2>
  
  
  <div style='display:table-cell; vertical-align:middle; text-align:center'>
  
  
		<?= Html::img('imagenes/service-icon-1.png', ['width'=>'40%','display'=>'block','margin-left'=>'auto','margin-right'=>'auto','height'=>'10%'],['alt' => 'alt image']); ?>
        
		
		
         
		 </div><!-- close row last row-->
  

				<p>&nbsp;</p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_box',
            'nombre_box',
            'sector.nombre_sector',
        ],
    ]) ?>
	<?php
		$dataProvider = new SqlDataProvider([
			'sql'=>'SELECT * FROM atn_gen RIGHT JOIN box_atencion ON atn_gen.id_atencion = box_atencion.id_atn WHERE box_atencion.id_boxGeneral = :id',
			'params' => [':id' => $model->id_box],
		])
	?>
	
	   </div>
           
            <div class="col-md-6">
                <h2>Tipos de Atenciones</h2>

              
  <div style='display:table-cell; vertical-align:middle; text-align:center'>
  
  
                <p>&nbsp;</p>
				  <p>&nbsp;</p>
		<?= Html::img('imagenes/iconos-21.png', ['width'=>'45%','display'=>'block','margin-left'=>'auto','margin-right'=>'auto','height'=>'45%'],['alt' => 'alt image']); ?>
        
		
		  <p>&nbsp;</p>
		    <p>&nbsp;</p>
         
                <h2>   </h2>
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nombre',

           //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
	
	  <p>&nbsp;</p>
		    <p>&nbsp;</p>
            </div>

        </div>
    
	
  </div>
	
	
</div>