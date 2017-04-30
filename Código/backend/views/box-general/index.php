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


use backend\models\SectorInst;

@session_start();
if (isset($_SESSION['existeBox'])){
	echo Alert::widget([
	   'type' => Alert::TYPE_INFO,
		'title' => 'Notificación',
		'icon' => 'glyphicon glyphicon-info-sign',
		'body' => 'Nombre de box debe ser único.',
		
		'showSeparator' => true,
		'delay' => 4000
	]);
}


$sector = SectorInst::findOne( $id_sector);
$id_piso = $sector->id_piso;
$nombre_sector = $sector->nombre_sector;
//echo $id_edificio;
$this->title = 'Box del  sector "'.$nombre_sector.'" ';
$this->params['breadcrumbs'][] = ['label' => ' Sectores ', 'url' => ['sector-inst/index', 'id_piso' => $id_piso]];

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box-general-index">

    <h1><center><?= Html::encode($this->title) ?></center></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel , 'id_sector' =>  $id_sector]); ?>
	
	<?php @session_start();

if (isset($_SESSION['atencionNoCreado'])){
   echo Alert::widget([
   'type' => Alert::TYPE_SUCCESS,
   'title' => 'No se pudo agregar la atención!',
    'icon' => 'glyphicon glyphicon-info-sign',
    'body' => 'Box Número ya posee dicha atención.',
	
	'showSeparator' => true,
    'delay' => 10000
]);
unset($_SESSION['atencionNoCreado']);
}  elseif (isset($_SESSION['atencionCreado'])) {
    echo Alert::widget([
  'type' => Alert::TYPE_SUCCESS,
    'title' => 'Atención agregada exitosa!',
    'icon' => 'glyphicon glyphicon-info-sign',
	
    
	'body' => 'Box de Número '.$_SESSION['atencionCreado']->id_boxGeneral.' se le ha sido agregada una nueva atención correctamente.'.Html::button('Ver detalle ... ', ['value'=>Url::to('index.php?r=box-atencion/create&id='.$_SESSION['atencionCreado']->id_boxGeneral),'class' => 'btn-link ajax_button']).' ',
	
	'showSeparator' => true,
    'delay' => 10000
]);
	unset($_SESSION['atencionCreado']);
}   elseif (isset($_SESSION['deleteAtencionBox'])){
	echo Alert::widget([
  'type' => Alert::TYPE_SUCCESS,
    'title' => 'Se ha eliminado una atención!',
    'icon' => 'glyphicon glyphicon-info-sign',
	'body' => 'pero que hijo de perra',
	'showSeparator' => true,
    'delay' => 10000
]);
unset($_SESSION['deleteAtencionBox']);
}else{
	
}

@session_destroy();
?>
	
	<p>&nbsp;</p>

    <p>
		<center>
		  
		  <?= Html::button('Nuevo Box ', ['value'=>Url::to('index.php?r=box-general/create&id_sector='.$id_sector),'class' => 'btn btn-success ajax_button']) ?>
		</center>
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


<?php
	if($dataProvider->models==null){
		?>
			<div class="body-content">
 <div class="row">
        
 <div class="col-md-12">
	<table>
	
	<tr>
	<td><center> <h2> Sin Box de Atención </h2></center> </td>
	</tr>
	
	
	<tr>
	<td><center> <h3> Para agregar Box, presione el botón " Nuevo Box" </h3></center> </td>
	</tr>
	</table>
	
	 </div>
    
	
  </div>
	
	
</div>
		
<?php	}else{
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
       // echo "<a href='index.php?r=pr-med/view&id=$p->rut'>";
		
		echo "<center><h4>$p->id_box</h4></center>";
		echo "<center><h4> Box $p->nombre_box</h4></center>";
		$nombresector= $p->sector->nombre_sector;
		echo "<center><h4>$nombresector</h4></center>";
		  
		$emmAtencion= $p->boxatencion->id_atn;
		echo "<center><h4>$emmAtencion</h4></center>";
		  
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
        //echo "<b>Precio: $ ".number_format($p->precio,0,'','.')."</b>";
		
		//echo Html::a(' Ver Box ', ['box-general/view', 'id' => $p->id_box],  ['class' => 'btn btn-success']);
		
		
		echo "<h4></h4>";
		$t = "index.php?r=box-general/view&id=$p->id_box";
        echo Html::button('<span class="glyphicon glyphicon-eye-open">	</span>', ['value'=>Url::to($t),'class' => 'btn-link ajax_button']);
		
		//echo Html::a(' Actualizar ', ['box-general/update', 'id' => $p->id_box],  ['class' => 'btn btn-success']);
		
		
		$t = "index.php?r=box-general/update&id=$p->id_box";
        echo Html::button('<span class="glyphicon glyphicon-pencil">	</span>', ['value'=>Url::to($t),'class' => 'btn-link ajax_button']);
		
		//echo Html::a(' Atenciones ', ['box-atencion/create', 'id' => $p->id_box],  ['class' => 'btn btn-success']);
		
		
		$t = "index.php?r=box-atencion/create&id=$p->id_box";
        echo Html::button('<span class="fa fa-plus-square">	</span>', ['value'=>Url::to($t),'class' => 'btn-link ajax_button']);
		
		/*
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


