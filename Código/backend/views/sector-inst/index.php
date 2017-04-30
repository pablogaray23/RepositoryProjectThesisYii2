<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\widgets\Alert;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\SectorInstSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use backend\models\PisoInst;

$piso = PisoInst::findOne( $id_piso);
$id_edificio = $piso->id_edificio;
$nombre_piso = $piso->nombre_piso;


//echo $id_edificio;


$this->title = 'Sectores del  piso "'.$nombre_piso.'" ';
$this->params['breadcrumbs'][] = ['label' => 'Piso Insts', 'url' => ['piso-inst/index', 'id_edificio' => $id_edificio]];
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
	
<div class="sector-inst-index">

    <h1><center><?= Html::encode($this->title) ?></center></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

  
<p>
    <center>
	<?= Html::button('<i class="glyphicon glyphicon-edit"></i> Ingresar Nuevo Sector', ['value'=>Url::to('index.php?r=sector-inst/create&id_piso='.$id_piso),'class' => 'btn btn-primary ajax_button']) ?>
	</center>
</p>



<div class="body-content" align="center">

<?php
	if($dataProvider->models==null){
		?>
			<div class="body-content">
 <div class="row">
        
 <div class="col-md-12">
	<table>
	<tr>
	<td><center> <p>&nbsp;</p></center> </td>
	</tr>
	<tr>
	<td><center> <p>&nbsp;</p></center> </td>
	</tr>
	<tr>
	<td><center> <h2>  <?= $nombre_piso?> no posee sectores </h2></center> </td>
	</tr>
	<tr>
	<td><center> <p>&nbsp;</p></center> </td>
	</tr>
	
	<tr>
	<td><center> <h3> Para agregar sectores, presione el botón "Crear Nuevo Sector" </h3></center> </td>
	</tr>
	</table>
	
	 </div>
    
	
  </div>
	
	
</div>
		
<?php	}else{
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
		
		
      echo "<center><h4>$p->nombre_sector</h4></center>";
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
		
		echo Html::a(' Ver Box ', ['box-general/index', 'id_sector' => $p->id_sector],  ['class' => 'btn btn-info']);
		
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

		
<?php	}
?>


 
    </div>	
</div>


