<?php

use yii\helpers\Html;

use yii\helpers\Url;
use yii\bootstrap\Modal;

use kartik\grid\GridView;
use kartik\widgets\Alert;

use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\BoxGeneralSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mantenedor Box de Atenciones';
$this->params['breadcrumbs'][] = $this->title;
session_start();
//var_dump($_SESSION['eventosNoAgregados']);die();51
if (session_status() != PHP_SESSION_NONE) {
    if (isset($_SESSION['eventosNoAgregados'])){
		if (strlen($_SESSION['eventosNoAgregados'])>51){
			//var_dump($_SESSION['eventosNoAgregados']);die();
			echo Alert::widget([
				'type' => Alert::TYPE_INFO,
				'title' => 'Advertencia',
				'icon' => 'glyphicon glyphicon-warning-sign',
				'body' => $_SESSION['eventosNoAgregados'],
				'showSeparator' => true,
				'delay' => false
			]);
		} else {
			echo Alert::widget([
				'type' => Alert::TYPE_SUCCESS,
				'title' => 'Notificacion',
				'icon' => 'glyphicon glyphicon-warning-sign',
				'body' => '¡Bloques de atencion generados exitosamente!',
				'showSeparator' => true,
				'delay' => false
			]);
		}
		unset($_SESSION['eventosNoAgregados']);
	}
}

?>
<div class="box-general-index">

    <h1><center><font color="blue"><?= Html::encode($this->title) ?></font></center></h1>
    <?php echo $this->render('_searchavan', ['model' => $searchModel]); ?>

    <p align="center">
         <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    </p>
	
	
	<?php
		Modal::begin([
			'header'=>'<h4>Datos Box</h4>',
			'id'=>'modal',
			'size'=>'modal-lg',
		]);
		echo "<div id='modalContent'></div>";
		Modal::end();
	?>

	
<div class="body-content" align="center">

<?= Html::button('Generar horarios automaticamente' , ['value'=>Url::to('index.php?r=event/create-all'),'class' => 'btn btn-success ajax_button']) ?>

<?php 
if($dataProvider->models==null){ 
?>
	<div class="body-content">
		<div class="row">
			<div class="col-md-12">
				<table>
					<tr>
					<td><center> <h2> No se encontraron resultados </h2></center> </td>
					</tr>
				</table>
			</div>
		</div>
	</div>
		
<?php	
}else{
?>
	<table>
	<?php
		$limite = 4;
		$contador = 0;
		echo "<div class='row'>";
		foreach($dataProvider->models as $p) {
			if($contador==0)
				echo "<tr>";
			echo "<td>";
			echo "<a href='index.php?r=box-general/horario&id=$p->id_box'>";
			
			//	echo "<center><h4>$p->id_box</h4></center>";
			echo "<center><h4> Box $p->nombre_box</h4></center>";
			//  $nombresector= $p->sector->nombre_sector;
			//echo "<center><h4>$nombresector</h4></center>";
		  
			//  $emmAtencion= $p->boxatencion->id_atn;
			//echo "<center><h4>$emmAtencion</h4></center>";

			$emmAtencion= $p->boxatencion->atencion->nombre;
			echo "<center><h4>$emmAtencion</h4></center>";
		 
		  
			//  echo "<center><h4>$p->sector->id_sector</h4></center>";
			//echo "<center><h4>$p->$boxatencion->id_atn</h4></center>";
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
			echo "<h4></h4>";
			$t = "index.php?r=box-general/view&id=$p->id_box";
			echo Html::a('<span class="glyphicon glyphicon-info-sign">	</span>', Url::to($t), ['class' => 'btn-link']);
			//echo "<b>Precio: $ ".number_format($p->precio,0,'','.')."</b>";
			
			//echo Html::a(' Ver Box ', ['box-general/view', 'id' => $p->id_box],  ['class' => 'btn btn-success']);		
			/*
			echo "<h4></h4>";
			$t = "index.php?r=box-general/view&id=$p->id_box";
			echo Html::button('<span class="glyphicon glyphicon-eye-open">	</span>', ['value'=>Url::to($t),'class' => 'btn-link ajax_button']);
			
			//echo Html::a(' Actualizar ', ['box-general/update', 'id' => $p->id_box],  ['class' => 'btn btn-success']);
			
			
			$t = "index.php?r=box-general/update&id=$p->id_box";
			echo Html::button('<span class="glyphicon glyphicon-pencil">	</span>', ['value'=>Url::to($t),'class' => 'btn-link ajax_button']);
			
			//echo Html::a(' Atenciones ', ['box-atencion/create', 'id' => $p->id_box],  ['class' => 'btn btn-success']);
			
			
			$t = "index.php?r=box-atencion/create&id=$p->id_box";
			echo Html::button('<span class="fa fa-plus-square">	</span>', ['value'=>Url::to($t),'class' => 'btn-link ajax_button']);
			
			
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


<?php	
} //Cierre else
?>

    </div>	
</div>

