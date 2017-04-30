<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\widgets\Alert;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\EdificioInstSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Estructura Edificios';
$this->params['breadcrumbs'][] = $this->title;

@session_start();
if (isset($_SESSION['edificioCreado'])){
	echo Alert::widget([
		'type' => Alert::TYPE_INFO,
		'title' => 'Notificación',
		'icon' => 'glyphicon glyphicon-info-sign',
		'body' => 'Edificio ingresado exitosamente',
		'showSeparator' => true,
		'delay' => 4000
	]);
}
@session_destroy();
?>
<div class="edificio-inst-index">

    <h1><center><?= Html::encode($this->title) ?></center></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
		<?= Html::button('<i class="glyphicon glyphicon-plus"></i> Ingresar nuevo Edificio', ['value'=>Url::to('index.php?r=edificio-inst/create'),'class' => 'btn btn-primary ajax_button']) ?>
    </p>

	
		
 <div class="body-content" align="center">
	<?php
		Modal::begin([
			'options' => [
				'id' => 'modal',
				'tabindex' => false // important for Select2 to work properly
			],
			'header'=>'<h4>Nuevo Edificio</h4>',
			//'id'=>'modal',
			'size'=>'modal-sm',
		]);
		echo "<div id='modalContent'></div>";
		Modal::end();
	?>

 
<table>
<?php
    $limite = 2;
    $contador = 0;
	echo "<div class='row'>";
    foreach($dataProvider->models as $p) {
        if($contador==0)
            echo "<tr>";
        echo "<td>";
       // echo "<a href='index.php?r=pr-med/view&id=$p->rut'>";
		
		
      echo "<center><h4>$p->nombre_edificio</h4></center>";
		//echo "<h4>$p->nombre</h4>";
        /*Buscar la imagen del producto basado en el ID */
     //   $imagen = "id_".$p->id_producto.".jpg";
        /*Si la imagen no existe, asignar imagen por defecto */
       // if(!file_exists("catalogo/$imagen"))
        //    $imagen = "temporal.jpg";
        /*Mostrar la Imagen */
        //echo "<img src='/@backend/web/imagenes/imagenBox.png' width='200px' ><br />";
		echo "<div style='display:table-cell; vertical-align:middle; text-align:center'>";
		echo Html::img('imagenes/imagenBox.png', ['width'=>'40%','display'=>'block','margin-left'=>'auto','margin-right'=>'auto','height'=>'30%'],['alt' => 'alt image']);
        //echo "<b>Precio: $ ".number_format($p->precio,0,'','.')."</b>";
		
		echo Html::a(' Ver Pisos ', ['piso-inst/index', 'id_edificio' => $p->id_edificio],  ['class' => 'btn btn-info']);
		
		
		/*echo Html::a('Ver Pisos', ['piso-inst/index'], [
            'class' => 'btn btn-success',
            'data' => [
               // 'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
				'params'=>[
				
				'id_edificio' => $p->id_edificio,
				],
					
				
				],
        ]);
		*/
		
		/*
		echo "<h4></h4>";
		$t = "index.php?r=piso-inst/view&id=$p->id";
        echo Html::button('<span class="glyphicon glyphicon-eye-open">	</span>', ['value'=>Url::to($t),'class' => 'btn-link ajax_button']);
		
		$t = "index.php?r=bx-gen/update&id=$p->id";
        echo Html::button('<span class="glyphicon glyphicon-pencil">	</span>', ['value'=>Url::to($t),'class' => 'btn-link ajax_button']);
		
		//$t = "index.php?r=bx-gen/delete&id=$p->id";
		$id = $p->id;
		$nombre = $p->nombre;
		echo Html::a('<span class="glyphicon glyphicon-remove">	</span>', ['bx-gen/delete', 'id' => $id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Estás seguro de eliminar este box '.$nombre .' de la lista ?',
               // 'method' => 'get',
            ],
        ]);
		
		*/
		
		
		
		echo "<h4></h4>";
		echo "</div>";
        echo "</a>";        
        echo "</td>";
        $contador++;
        if($contador==$limite){
            echo "</tr>";
            $contador=0;
        }    
		 echo "</div><!-- close row last row-->";
    }
    /*Si no completamos el limite por fila, nos faltará cerrar el tr */
    if($contador!=0){
        echo "</tr>";
    }
?>
</table>

    
    </div>
	
	
</div>
