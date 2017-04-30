<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\BoxAtencion;
use backend\models\BoxAtencionSearch;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model backend\models\BoxAtencion */

$emmm = $id;
echo $emmm;

//todo este codigo de abajo es para obtener un cierto atributo de una tabla a través de un id, en este caso
//quiero recuperar solamente el sector donde se ubica este box
use backend\models\BoxGeneral;
use backend\models\SectorInst;

$box = BoxGeneral::findOne( $id);
$id_sector = $box->id_sector;
$nombreDelBox = $box->nombre_box;

$elSector = SectorInst::findOne( $id_sector);

$nombreDelSector = $elSector->nombre_sector;



$this->title = 'Agregar Atenciones al Box General';
$this->params['breadcrumbs'][] = ['label' => 'Box Atencions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box-atencion-create">

 <?php
		
		$dataProvider = new ActiveDataProvider([
			'query' => BoxAtencion::find()->where(['id_boxGeneral'=>$id]),
		]);
		
	?>

    <h1><center><u><font color="blue"><?= Html::encode($this->title) ?></font></u></center></h1>
	
	
	<div class="body-content">
 <div class="row">
        <div class="col-md-6">

    <?= $this->render('_form', [
        'model' => $model,
		'id'=>$id,
    ]) ?>
	
	 </div>
           
            <div class="col-md-6">
			
				
		  <p>&nbsp;</p>
			
			<center><h2> Información Box </h2></center>
			
		    <p>&nbsp;</p>
			<center>
			<table>
			<tr>
			<td> Box&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
			<td> <?= $nombreDelBox?> </td>
			</tr>
			<tr>
			<td> Sector &nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
			<td> <?= $nombreDelSector?> </td>
			</tr>
			</table>
			</center>

			
		  <p>&nbsp;</p>
			
			<center><h2> Atenciones </h2></center>
			
		    <p>&nbsp;</p>
	
	
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			
						
			'atencion.nombre',
			
						    ['class' => 'yii\grid\ActionColumn',
			'template' => '{delete}',
			'buttons' => [
			
			

            'delete' => function ($url, $model) {
				//$t = 'index.php?r=profesional-antecedentes/index&id='.$url;
               // return Html::a('<span class="glyphicon glyphicon-file"></span>', $url, [ 'title' => "Antecedentes", 'class'=>'btn-link', ]);
				//return Html::a('Profile', ['pr-esp/delete', 'id' => $url], ['class' => 'profile-link']);
				return Html::a('Delete', ['delete', 'id' => $model->id_boxAtencion], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]);				
            },			
        ],
		], 
			
			
		         
        ],
    ]); ?>
<?php Pjax::end(); ?>
		</div>
		</div>
		</div>


</div>