<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\form\ActiveField;
use kartik\widgets\FileInput;

use yii\bootstrap\Modal;
use kartik\widgets\DatePicker;
use backend\models\PrAntecedenteTipo;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\PrAntecedente */
/* @var $form yii\widgets\ActiveForm */

$tiposAntecedentes=PrAntecedenteTipo::find()->orderBy('nombre_antecedente_tipo')->asArray()->all();
$listData=ArrayHelper::map($tiposAntecedentes,'id_antecedente_tipo','nombre_antecedente_tipo');

?>

<div class="pr-antecedente-form">
	<div class="body-content">
		<div class="row">
			<div class="col-md-6">
 
				<div style='display:table-cell; vertical-align:middle; text-align:center'>

					<p align="left"><font size="3"> Fecha Actual : <?php echo date('d-m-Y'); ?></font> </p>
  
					<p>&nbsp;</p>
					<?= Html::img('imagenes/depositphotos_1335763-Medical-documents.jpg', ['width'=>'25%','display'=>'block','margin-left'=>'auto','margin-right'=>'auto','height'=>'15%'],['alt' => 'alt image']); ?>
        
				</div><!-- close row last row-->
				<p>&nbsp;</p>
				
				<?php $form = ActiveForm::begin([
				'type' => ActiveForm::TYPE_VERTICAL,
				'options'=>['enctype'=>'multipart/form-data'] // important
				]) ?>
				
				<?= $form->field($model, 'rut_med')->textInput(['readonly' => true,'value'=>$rut_med]) ?>
				
				<?= $form->field($model, 'tipoAntecedente')->widget(Select2::classname(), [
					'data' => $listData,
					'options' => ['placeholder' => 'Selecciona un tipo de documento ...'],
					'pluginOptions' => [
						'allowClear' => true
					],
				]) ?>
				
				<?= $form->field($model, 'file')->widget(FileInput::classname(), [
					'options'=>['multiple' => false],
					'pluginOptions' => [
						'showPreview' => false,
						'showCaption' => true,
						'showRemove' => true,
						'previewFileType' => 'image'
					]
				])?>
			<!----------- ALGUNA WEA ---------->
			</div>
			<div class="col-md-6">

				<blockquote>			
					<h3>Información General </h3>
					<small> Los campos marcados con (*) son obligatorios.</small>
					<small> Puede subir un máx. de 2 archivos al instante. </small>
					<center><p>* Indicaciones *</p></center>
					<p> Tipo Antecedente : </p>
					<small>Debe escribir qué tipo de antecedente subirá.  Este tipo de antecedente servirá como identificador de los archivos. </br>
					Por ejemplo :     Curriculum, Fotococopia tamaño Carnet, etc. </br>
					</small>
					<p> Archivo : </p>
					<small> Corresponde a cualquier documento "Antecedente Médico" que desea guardar.</br>
					Debe pulsar el botón "Browse..." para seleccionar el archivo a subir. </br>
					Es preferible escanear los documentos y guardarlos en formato .pdf </br>
					Los archivos permitidos son .pdf, .docx (Word), .xlsx (Excel) e imágenes .png .jpg </br>
					</small>
				  <p align="center"> 
				   Por defecto el sistema añadirá el R.U.T. del profesional como parte del nombre del archivo </br>
				   además de guardar la fecha actual en la cual se subió el archivo.</p>
				</blockquote>
			</div>
		</div>
	</div>
    <?php ActiveForm::end(); ?>

</div>
