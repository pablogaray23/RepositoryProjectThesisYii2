<?php

use yii\helpers\Html;

use yii\helpers\Url;
use yii\bootstrap\Modal;

use kartik\grid\GridView;
use kartik\widgets\Alert;

use yii\widgets\Pjax;

use backend\models\PrMed;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\BoxGeneralSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$medico = PrMed::find()->where(['rut'=>$_GET['id']])->one();

$this->title = 'Box Atenciones de '.$medico->nombre.' '.$medico->apellidoPaterno.' '.$medico->apellidoMaterno;
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="box-general-index">

    <h1><center><font color="blue"><?= Html::encode($this->title) ?></font></center></h1>
    

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


<?php 
if($lista==null){ 
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
		
		foreach($lista as $p) {
			
			if($contador==0)
				echo "<tr>";
			echo "<td>";
			echo "<a href='index.php?r=pr-med/calendario&id=".$p['id_box']."&rut=".$_GET['id']."'>";
			
			echo "<center><h4> Box ".$p['nombre_box']."</h4></center>";


			//$emmAtencion= $p->boxatencion->atencion->nombre;
			//echo "<center><h4>$emmAtencion</h4></center>";

			echo "<div style='display:table-cell; vertical-align:middle; text-align:center'>";
			echo Html::img('imagenes/imagenBox.png', ['width'=>'40%','display'=>'block','margin-left'=>'auto','margin-right'=>'auto','height'=>'30%'],['alt' => 'alt image']);
			echo "<h4></h4>";
			$t = "index.php?r=box-general/view&id=".$p['id_box'];
			echo Html::a('<span class="glyphicon glyphicon-info-sign">	</span>', Url::to($t), ['class' => 'btn-link']);
	
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

