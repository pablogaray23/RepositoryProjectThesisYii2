<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\data\SqlDataProvider;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\widgets\Alert;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\PisoInstSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


use backend\models\EdificioInst;

$edificio = EdificioInst::findOne( $id_edificio);
$nombre_edificio = $edificio->nombre_edificio;

$this->params['breadcrumbs'][] = ['label' => 'Edificios', 'url' => ['edificio-inst/index']];
$this->title = 'Pisos del edificio "'.$nombre_edificio.'" ';
$this->params['breadcrumbs'][] = $this->title;
?>

	<?php
		Modal::begin([
			'options' => [
				'id' => 'modal',
				'tabindex' => false // important for Select2 to work properly
			],
			'header'=>'<h4>Editar información edificio</h4>',
			//'id'=>'modal',
			'size'=>'modal-sm',
		]);
		echo "<div id='modalContent'></div>";
		Modal::end();
	?>

<div class="piso-inst-index">

    <h1><center><?= Html::encode($this->title) ?></center></h1>
	<br>
     <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
	
	
	
	
    <center><p>
		<?= Html::button('<i class="glyphicon glyphicon-edit"></i> Editar nombre edificio', ['value'=>Url::to('index.php?r=edificio-inst/update&id='.$id_edificio),'class' => 'btn btn-primary ajax_button']) ?>
		<br><br>
		<?= Html::button('<i class="glyphicon glyphicon-plus"></i> Ingresar Piso', ['value'=>Url::to('index.php?r=piso-inst/create&id_edificio='.$id_edificio),'class' => 'btn btn-primary ajax_button']) ?>
		
		
    </p></center>
	






<div class="body-content" align="center">


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
		
		
      echo "<center><h4>$p->nombre_piso</h4></center>";
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
		
		echo Html::a(' Ver Sectores ', ['sector-inst/index', 'id_piso' => $p->id_piso],  ['class' => 'btn btn-info']);
		
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


