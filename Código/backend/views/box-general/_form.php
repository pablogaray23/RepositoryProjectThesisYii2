<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use backend\models\EspGen;

use yii\widgets\DetailView;
use backend\models\PrEsp;
use backend\models\PrEspSearch;
use yii\data\SqlDataProvider;
use yii\grid\GridView;

$id_sector=Yii::$app->request->get("id_sector");
echo $id_sector;

use backend\models\AtnGen;

/* @var $this yii\web\View */
/* @var $model backend\models\BoxGeneral */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $esp=EspGen::find()->orderBy('nombreEspecialidad')->asArray()->all();
	$listData=ArrayHelper::map($esp,'codigoEspecialidad','nombreEspecialidad');?>

<div class="box-general-form">

      <?php $form = ActiveForm::begin(['id' => 'modalContent','layout'=>'horizontal'
   // 'enableAjaxValidation' => false,
     //               'enableClientValidation' => true
                    ]); ?>
	
	<?php $atencion=AtnGen::find()->all();
	$listDataTres=ArrayHelper::map($atencion,'id_atencion','nombre');?>
	
	<div class="body-content">
 <div class="row">
        

	
	<?php if ($model->isNewRecord){?><!-- FORM CREATE -->
	
	 <div class="col-md-6">
	 
	 <p>&nbsp;</p>
	 <center>
	 <?= Html::img('imagenes/service-icon-1.png', ['width'=>'40%','display'=>'block','margin-left'=>'auto','margin-right'=>'auto','height'=>'10%'],['alt' => 'alt image']); ?>
        
		</center>
	 <p>&nbsp;</p>

    <?= $form->field($model, 'nombre_box')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($modelE, 'id_atn')->dropDownList($listDataTres) ?>
	
	<?= $form->field($model, 'id_sector')->hiddenInput(['readonly' => true,'value'=>$id_sector])->label(false) ?>	
	
	<?= $form->field($model, 'campo') ?>
	
	<?= $form->field($model, 'field') ?>

   	 </div>
           
            <div class="col-md-6">
			<blockquote>
			
                <h3>Información General </h3>
				<small>Debe completar todos los campos.</small>
				<small>En caso de equivarse, los datos pueden ser modificados.</small>

				<center><p>* Indicaciones *</p></center>
				
				<p> Nombre Box : </p>
  <small>Debe ingresar una <cite title="letra">letra</cite> o <cite title="número">número</cite> que actuará como identificador inicial. Al crearse éstos, se crearán secuenciamente a partir del identificador ingresado </br>
   Por ejemplo :     2... &nbsp;&nbsp;&nbsp; Box Generados &nbsp;&nbsp;&nbsp;  201, 202, 203, ... 220 </br>
   Por ejemplo :     A... &nbsp;&nbsp;&nbsp; Box Generados &nbsp;&nbsp;&nbsp;  A01, A02, A03, ... A20 </small>
  
  <p> Atención : </p>
  <small>Actividad de uso del box. Por defecto se crearán como <cite title="Atención General">Atención General</cite>.  Puede escojer otra...</small>
  <p> Rango de inicio : </p>
  <small> Número desde donde comienzan los box a crear  </small>
  <p> Rango de Fin : </p>
  <small> Número desde donde terminan los box a crear  </small>
  <small> Ejemplo : Rango de inicio 2, Rango de fin 10  </small>
  <small> Box creados 202, 203, 204 .....209 y 210  </small>
  
				
				
				
				
				</blockquote>


            </div>

        </div>
	
	
	<?php } else {?><!-- FORM UPDATE -->
	
	<div class="col-md-7">
	
	 <p>&nbsp;</p>
	 <p>&nbsp;</p>
	 <p>&nbsp;</p>
	 <p>&nbsp;</p>
	
	<?= $form->field($model, 'nombre_box')->textInput()->label("Número <small>Original: ".$model->nombre_box."</small>")?>


	
	<?= $form->field($model, 'id_sector')->textInput(['readonly' => true,'value'=>$id_sector]) ?>	

	
	
	 </div>
	 
	 <?php
		$dataProvider = new SqlDataProvider([
			'sql'=>'SELECT * FROM atn_gen RIGHT JOIN box_atencion ON atn_gen.id_atencion = box_atencion.id_atn WHERE box_atencion.id_boxGeneral = :id',
			'params' => [':id' => $model->id_box],
		])
	?>
           
            <div class="col-md-5">
               <h2>Tipos de Atenciones</h2>

                 
  <div style='display:table-cell; vertical-align:middle; text-align:center'>
  
  
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
	
            </div>
            </div>

        </div>
	
	
	<?php } ?>
		  
    
	
  </div>
	
	<div class="form-group">
        
		<div class="col-lg-offset-5">
           <?= Html::submitButton($model->isNewRecord ? '<i class="glyphicon glyphicon-floppy-disk"></i> Generar' : '<i class="glyphicon glyphicon-floppy-disk"></i> Guardar ', ['class' => $model->isNewRecord ? 'btn btn-success ajax_button' : 'btn btn-primary']) ?>
        </div>
    </div>
	
    <?php ActiveForm::end(); ?>

</div>
