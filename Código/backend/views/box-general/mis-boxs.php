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
?>


<?php 

if($misEventos==null){ 
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
		foreach($misEventos as $p) {
			
			if($contador==0)
				echo "<tr>";
			echo "<td>";
			echo "<a href='index.php?r=box-general/mishorarios&id=$p->id_box&rut=$p->rut_profesional'>";
			

			echo "<center><h4> Box ".\yii\helpers\ArrayHelper::getValue($p,'title')."</h4></center>";


			//$emmAtencion= $p->boxatencion->atencion->nombre;
			//$emmAtencion = \yii\helpers\ArrayHelper::getValue($p,'boxatencion')->atencion->nombre;
			//echo "<center><h4>$emmAtencion</h4></center>";

			echo "<div style='display:table-cell; vertical-align:middle; text-align:center'>";
			echo Html::img('imagenes/imagenBox.png', ['width'=>'40%','display'=>'block','margin-left'=>'auto','margin-right'=>'auto','height'=>'30%'],['alt' => 'alt image']);
			echo "<h4></h4>";
			$t = "index.php?r=box-general/view&id=".\yii\helpers\ArrayHelper::getValue($p,'id_box');
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

